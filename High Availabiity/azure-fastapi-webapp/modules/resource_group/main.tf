resource "azurerm_resource_group" "rg" {
  name     = "${var.prefix}-${var.application}-${var.environment}-rg"
  location = var.location

  tags = {
    application = var.application
    environment = var.environment
    owner       = var.owner
  }
}
