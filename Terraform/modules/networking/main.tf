resource "azurerm_virtual_network" "vnet" {
  name                = "${var.prefix}-${var.application}-${var.environment}-vnet"
  location            = var.location
  address_space       = ["10.0.0.0/16"]
  resource_group_name = var.resource_group_name

  tags = {
    application = var.application
    environment  = var.environment
    owner       = var.owner
  }
}

resource "azurerm_subnet" "subnet" {
  name                 = "${var.prefix}-${var.application}-${var.environment}-subnet"
  resource_group_name  = var.resource_group_name
  virtual_network_name = azurerm_virtual_network.vnet.name
  address_prefixes       = ["10.0.1.0/24"]
}

resource "azurerm_network_security_group" "nsg" {
  name                = "${var.prefix}-${var.application}-${var.environment}-nsg"
  resource_group_name = var.resource_group_name
  location            = azurerm_virtual_network.vnet.location

  security_rule {
    name                       = "ssh"
    priority                   = 100
    direction                  = "Inbound"
    access                     = "Allow"
    protocol                   = "Tcp"
    source_port_range          = "*"
    destination_port_range     = "22"
    source_address_prefix      = "*"
    destination_address_prefix = "*"
  }

  tags = {
    application = var.application
    environment  = var.environment
    owner       = var.owner
  }
}


