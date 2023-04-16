output "la_id" {
  value = azurerm_log_analytics_workspace.la.id
}

output "la_name" {
  value = azurerm_log_analytics_workspace.la.name
}

output "warning_ag" {
  value = azurerm_monitor_action_group.warning_ag.id
}

output "critical_ag" {
  value = azurerm_monitor_action_group.critical_ag.id
}
