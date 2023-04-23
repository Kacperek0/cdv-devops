terraform {
  required_providers {
    datadog = {
      source  = "DataDog/datadog"
      version = "3.23.0"
    }
  }
}

provider "datadog" {
  api_key = var.datadog_api_key
  app_key = var.datadog_app_key
  api_url = "https://api.datadoghq.eu/"
}

resource "datadog_monitor" "monitor" {
  name               = var.name
  type               = var.type
  message            = "{{#is_alert_to_warning}}\n${var.warn_message} {{warn_threshold}} level.\n${var.warn_endpoint}\n{{/is_alert_to_warning}}\n{{#is_alert}}\n${var.critical_message} {{threshold}}.\n\n${var.critical_endpoint}\n{{/is_alert}}\n${var.mitigation_message}\n{{#is_alert_recovery}}\nLooks like issue is gone.\n${var.critical_endpoint}\n{{/is_alert_recovery}}\n{{#is_warning_recovery}}\nIssue solved!\n${var.warn_endpoint}\n{{/is_warning_recovery}}"
  escalation_message = var.critical_endpoint

  query = "avg(${var.time_range}):avg:${var.metric}{${var.host}} ${var.comparison_operator} ${var.critical_threshold}"

  monitor_thresholds {
    critical = var.critical_threshold
    warning  = var.warn_threshold

    critical_recovery = var.critical_recovery
    warning_recovery  = var.warn_recovery
  }
}
