resource "azurerm_linux_virtual_machine_scale_set" "vmss" {
  name                = "${var.prefix}-${var.application}-${var.environment}-vmss"
  resource_group_name = var.resource_group_name
  location            = var.location
  sku                 = "Standard_B1s"
  instances           = var.instances

  admin_username                  = "azureuser"
  admin_password                  = var.admin_password
  disable_password_authentication = false

  custom_data = filebase64("${path.module}/setup.sh")

  health_probe_id = azurerm_lb_probe.lb_probe.id

  source_image_reference {
    publisher = "canonical"
    offer     = "0001-com-ubuntu-server-jammy"
    sku       = "22_04-lts"
    version   = "latest"
  }

  os_disk {
    caching              = "ReadWrite"
    storage_account_type = "StandardSSD_LRS"
    disk_size_gb         = 30
  }

  network_interface {
    name                      = "${var.prefix}-${var.application}-${var.environment}-vmss-nic"
    primary                   = true
    network_security_group_id = var.sg_id
    ip_configuration {
      name                           = "${var.prefix}-${var.application}-${var.environment}-vmss-ipconf"
      subnet_id                      = var.subnet_id
      primary                        = true
      application_security_group_ids = null #TODO: Check if it's required
      load_balancer_backend_address_pool_ids = [
        azurerm_lb_backend_address_pool.lb_backend_pool.id
      ]
    }
  }

  boot_diagnostics {}

  tags = {
    application = var.application
    environment = var.environment
    owner       = var.owner
  }
}

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
