resource "azurerm_postgresql_server" "psql" {
  name                = "fastapi-psql-dev-1"
  resource_group_name = var.resource_group_name
  location            = var.location

  sku_name   = "B_Gen5_1"
  version    = "11"
  storage_mb = 5120

  backup_retention_days        = 7
  geo_redundant_backup_enabled = false
  auto_grow_enabled            = true

  public_network_access_enabled    = true
  ssl_enforcement_enabled          = false
  ssl_minimal_tls_version_enforced = "TLSEnforcementDisabled"

  # Dane do logowania muszą byc takie same jak w obrazie.
  administrator_login          = "postgres"
  administrator_login_password = "Q1w2e3r4t5y6."

  tags = {
    environment = var.environment
    application = var.application
    owner       = var.owner
  }
}

resource "azurerm_postgresql_database" "fastapidb" {
  name                = "fastapidb"
  resource_group_name = var.resource_group_name
  server_name         = azurerm_postgresql_server.psql.name
  charset             = "UTF8"
  collation           = "English_United States.1252"
}
