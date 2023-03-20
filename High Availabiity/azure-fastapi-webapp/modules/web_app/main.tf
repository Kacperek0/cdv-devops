resource "azurerm_service_plan" "app_plan" {
  name                = "${var.application}-${var.environment}-asp"
  resource_group_name = var.resource_group_name
  location            = var.location
  os_type             = "Linux"
  sku_name            = "B1"

  tags = {
    application = var.application
    environment = var.environment
    owner       = var.owner
  }
}

resource "azurerm_linux_web_app" "fastapi" {
  name                = "${var.application}-${var.environment}-webapp"
  resource_group_name = var.resource_group_name
  location            = var.location
  service_plan_id = azurerm_service_plan.app_plan.id

  app_settings = {
    POSTGRES_USER     = "${var.postgres_user}@${var.postgres_server_name}"
    POSTGRES_PASSWORD = var.postgres_password
    POSTGRES_SERVER   = "${var.postgres_server_name}.postgres.database.azure.com"
    POSTGRES_PORT     = var.postgres_port
    DATABASE_NAME     = var.database_name
  }

  site_config {
    always_on                         = true
    health_check_path                 = "/"
    health_check_eviction_time_in_min = 10
    app_command_line = "python3 main.py"
    
    application_stack {
        python_version = "3.10"
    }
  }

  tags = {
    application = var.application
    environment = var.environment
    owner       = var.owner
  }
}
