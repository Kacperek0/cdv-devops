output "postgres_server_name" {
    value = azurerm_postgresql_server.psql.name
}

output "postgres_user" {
    value = azurerm_postgresql_server.psql.administrator_login
}

output "postgres_password" {
    value = azurerm_postgresql_server.psql.administrator_login_password
}

output "database_name" {
    value = azurerm_postgresql_database.fastapidb.name
}
