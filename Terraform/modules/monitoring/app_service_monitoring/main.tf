resource "azurerm_monitor_diagnostic_setting" "app_diagnostic_setting" {
  name                       = "${var.prefix}-${var.application}-${var.environment}-mds"
  target_resource_id         = var.app_service_id
  log_analytics_workspace_id = var.log_analytics_workspace_id

  metric {
    category = "AllMetrics"
    enabled  = true
    retention_policy {
      enabled = true
      days    = 7
    }
  }

  enabled_log {
    category = "AppServiceHTTPLogs"
    retention_policy {
      enabled = true
      days    = 7
    }
  }
}

resource "azurerm_monitor_metric_alert" "server_error_alert" {
  name                = "[${var.severity}] 5xx errors above ${var.threshold} on ${var.app_service_name}"
  resource_group_name = var.resource_group_name

  scopes = [var.app_service_id]

  frequency   = "PT1M"
  severity    = var.severity == "critical" ? "1" : "2"
  window_size = "PT1M"

  criteria {
    metric_namespace = "Microsoft.Web/sites"
    metric_name      = "Http5xx"
    aggregation      = "Total"
    operator         = "GreaterThan"
    threshold        = var.threshold

    dimension {
      name     = "Instance"
      operator = "Include"
      values   = ["*"]
    }
  }

  action {
    action_group_id = var.severity == "critical" ? var.critical_ag : var.warning_ag
  }

  tags = {
    application = var.application
    environment = var.environment
    owner       = var.owner
  }
}

resource "azurerm_monitor_metric_alert" "server_4xx_errors_alert" {
  name                = "[${var.severity}] 4xx errors above ${var.threshold} on ${var.app_service_name}"
  resource_group_name = var.resource_group_name

  scopes = [var.app_service_id]

  frequency   = "PT1M"
  severity    = var.severity == "critical" ? "1" : "2"
  window_size = "PT1M"

  criteria {
    metric_namespace = "Microsoft.Web/sites"
    metric_name      = "Http4xx"
    aggregation      = "Total"
    operator         = "GreaterThan"
    threshold        = var.threshold + 50

    dimension {
      name     = "Instance"
      operator = "Include"
      values   = ["*"]
    }
  }

  action {
    action_group_id = var.severity == "critical" ? var.critical_ag : var.warning_ag
  }

  tags = {
    application = var.application
    environment = var.environment
    owner       = var.owner
  }
}
