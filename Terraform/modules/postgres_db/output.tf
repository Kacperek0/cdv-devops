output "postgres_host" {
  value = azurerm_postgresql_server.psql_server.name
}

output "postgres_user" {
  value = azurerm_postgresql_server.psql_server.administrator_login
}

output "postgres_password" {
  value = azurerm_postgresql_server.psql_server.administrator_login_password
}
