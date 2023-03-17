resource "azurerm_public_ip" "lb_public_ip" {
  name                = "${var.prefix}-${var.application}-${var.environment}-lb-public-ip"
  location            = var.location
  resource_group_name = var.resource_group_name
  allocation_method   = "Static"
  sku                 = "Standard"

    tags = {
        application = var.application
        environment = var.environment
        owner       = var.owner
    }
}

resource "azurerm_lb" "lb" {
  name                = "${var.prefix}-${var.application}-${var.environment}-lb"
  location            = var.location
  resource_group_name = var.resource_group_name
  sku                 = "Standard"

    frontend_ip_configuration {
        name                 = "PublicIPAddress"
        public_ip_address_id = azurerm_public_ip.lb_public_ip.id
    }

    tags = {
        application = var.application
        environment = var.environment
        owner       = var.owner
    }
}

resource "azurerm_lb_backend_address_pool" "lb_backend_pool" {
  loadbalancer_id     = azurerm_lb.lb.id
  name                = "${var.prefix}-${var.application}-${var.environment}-lb-backend-pool"
}

resource "azurerm_lb_probe" "lb_probe" {
  loadbalancer_id     = azurerm_lb.lb.id
  name                = "${var.prefix}-${var.application}-${var.environment}-lb-probe"
  port                = 80
  protocol            = "Http"
  interval_in_seconds = 5
  number_of_probes    = 2
  request_path = "/"

}

resource "azurerm_lb_rule" "lb_rule" {
  loadbalancer_id                = azurerm_lb.lb.id
  name                           = "${var.prefix}-${var.application}-${var.environment}-lb-rule"
  protocol                       = "Tcp"
  frontend_port                  = 80
  backend_port                   = 80
  frontend_ip_configuration_name = "PublicIPAddress"
  probe_id                       = azurerm_lb_probe.lb_probe.id
  backend_address_pool_ids       = [azurerm_lb_backend_address_pool.lb_backend_pool.id]
}

resource "azurerm_network_interface_backend_address_pool_association" "lb_backend_pool" {
  count                   = length(var.vm_names)
  network_interface_id    = var.vm_nic[count.index]
  ip_configuration_name   = "external"
  backend_address_pool_id = azurerm_lb_backend_address_pool.lb_backend_pool.id
}
