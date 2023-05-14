resource "azurerm_storage_account" "storge" {
  name                     = "sa3rjg93hg02${var.environment}"
  resource_group_name      = var.resource_group_name
  location                 = var.location
  account_kind             = "StorageV2"
  account_tier             = "Standard"
  account_replication_type = "LRS"

  static_website {
    index_document     = "index.html"
    error_404_document = "error404.html"
  }

  tags = {
    application = var.application
    environment = var.environment
    owner       = var.owner
  }
}
