module "lb_health_probe" {
  source = "../../modules/monitor"

  name = "Load balancer's health probe errors for cdv-terraform-dev-lb"
  type = "metric alert"

  warn_message     = "Something is no yes, but not so much."
  critical_message = "Something is very no yes."

  mitigation_message = "Please do the needful."

  warn_endpoint     = "@pagerduty-nginx-warning"
  critical_endpoint = "@pagerduty-Nginx-critical"

  time_range          = "last_5m"
  metric              = "azure.network_loadbalancers.health_probe_status"
  host                = "name:cdv-terraform-dev-lb"
  comparison_operator = "<"

  warn_threshold     = 75
  critical_threshold = 50

  warn_recovery     = 76
  critical_recovery = 51

  datadog_api_key = var.datadog_api_key
  datadog_app_key = var.datadog_app_key
}
