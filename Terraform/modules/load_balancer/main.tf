resource "azurerm_public_ip" "pip" {
  name                = "${var.prefix}-${var.application}-${var.environment}-lb-pip"
  resource_group_name = var.resource_group_name
  location            = var.location
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
  resource_group_name = var.resource_group_name
  location            = var.location
  sku                 = "Standard"

  frontend_ip_configuration {
    name                 = "${var.prefix}-${var.application}-${var.environment}-lb-frontend-ip"
    public_ip_address_id = azurerm_public_ip.pip.id
  }

  tags = {
    application = var.application
    environment = var.environment
    owner       = var.owner
  }
}

resource "azurerm_lb_backend_address_pool" "lb_backend_pool" {
  name            = "${var.prefix}-${var.application}-${var.environment}-lb-pool"
  loadbalancer_id = azurerm_lb.lb.id
}

resource "azurerm_lb_probe" "lb_probe" {
  name                = "${var.prefix}-${var.application}-${var.environment}-lb-probe"
  loadbalancer_id     = azurerm_lb.lb.id
  port                = "80"
  protocol            = "Http"
  request_path        = "/"
  interval_in_seconds = 5
  number_of_probes    = 2
}

resource "azurerm_lb_rule" "lb_rule" {
  name                           = "${var.prefix}-${var.application}-${var.environment}-lb-probe"
  loadbalancer_id                = azurerm_lb.lb.id
  protocol                       = "Tcp"
  frontend_port                  = 80
  backend_port                   = 80
  frontend_ip_configuration_name = azurerm_lb.lb.frontend_ip_configuration[0].name
  probe_id                       = azurerm_lb_probe.lb_probe.id
  backend_address_pool_ids       = [azurerm_lb_backend_address_pool.lb_backend_pool.id]
}

resource "azurerm_network_interface_backend_address_pool_association" "lb_backend_pool_association" {
  count                   = length(var.vm_names)
  network_interface_id    = var.vm_nic[count.index]
  backend_address_pool_id = azurerm_lb_backend_address_pool.lb_backend_pool.id
  ip_configuration_name   = "external"
}
