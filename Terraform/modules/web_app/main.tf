resource "azurerm_service_plan" "asp" {
  name                = "${var.prefix}-${var.application}-${var.environment}-asp"
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

resource "azurerm_linux_web_app" "webapp" {
  name                = "${var.prefix}-${var.application}-${var.environment}-webapp"
  resource_group_name = var.resource_group_name
  location            = var.location
  service_plan_id     = azurerm_service_plan.asp.id

  site_config {
    always_on                         = true
    health_check_path                 = "/"
    health_check_eviction_time_in_min = 5
    app_command_line                  = "python3 main.py"

    application_stack {
      python_version = "3.10"
    }
  }

  app_settings = {
    POSTGRES_USER     = "${var.postgres_user}@${var.postgres_host}"
    POSTGRES_PASSWORD = var.postgres_password
    POSTGRES_HOST     = "${var.postgres_host}.postgres.database.azure.com"
  }

  tags = {
    application = var.application
    environment = var.environment
    owner       = var.owner
  }
}

