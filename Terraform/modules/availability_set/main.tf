resource "azurerm_availability_set" "as" {
  name                         = "${var.prefix}-${var.application}-${var.environment}-as"
  location                     = var.location
  resource_group_name          = var.resource_group_name
  managed                      = true
  platform_fault_domain_count  = 2
  platform_update_domain_count = 1

  tags = {
    application = var.application
    environment = var.environment
    owner       = var.owner
  }
}
