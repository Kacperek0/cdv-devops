resource "azurerm_logic_app_workflow" "logic_app" {
  name                = "${var.prefix}-${var.application}-${var.environment}-${var.stage}-logic-app"
  resource_group_name = var.resource_group_name
  location            = var.location

  identity {
    type = "SystemAssigned"
  }

  tags = {
    application = var.application
    environment = var.environment
    owner       = var.owner
  }
}
