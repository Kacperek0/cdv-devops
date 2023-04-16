resource "azurerm_log_analytics_workspace" "la" {
  name                = "${var.prefix}-${var.application}-monitoring-la"
  resource_group_name = var.resource_group_name
  location            = var.location

  sku = "PerGB2018"

  tags = {
    application = var.application
    environment = "monitoring"
    owner       = var.owner
  }
}

resource "azurerm_monitor_action_group" "warning_ag" {
  name                = "${var.prefix}-${var.application}-warning-ag"
  resource_group_name = var.resource_group_name
  short_name          = "warn-email"

  email_receiver {
    name                    = "${var.prefix}-${var.application}-warning-email"
    email_address           = "kacper.szczepanek@cdv.pl"
    use_common_alert_schema = true
  }
}

resource "azurerm_monitor_action_group" "critical_ag" {
  name                = "${var.prefix}-${var.application}-critical-ag"
  resource_group_name = var.resource_group_name
  short_name          = "crit-email"

  email_receiver {
    name                    = "${var.prefix}-${var.application}-critical-email"
    email_address           = "kacper.szczepanek@cdv.pl"
    use_common_alert_schema = true
  }
}
