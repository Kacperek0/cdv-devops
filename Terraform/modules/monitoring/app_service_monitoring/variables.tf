variable "prefix" {
  type        = string
  description = "Team prefix"
}

variable "application" {
  type        = string
  description = "Application name"
}

variable "environment" {
  type        = string
  description = "Environment name"
}

variable "owner" {
  type        = string
  description = "Owner email"
}

variable "resource_group_name" {
  type        = string
  description = "RG name"
}

variable "app_service_id" {
  type        = string
  description = "App Service ID"
}

variable "log_analytics_workspace_id" {
  type        = string
  description = "LA Workspace ID"
}

variable "severity" {
  type        = string
  description = "Alert severity"
}

variable "threshold" {
  type        = number
  description = "Threshold value"
}

variable "app_service_name" {
  type        = string
  description = "App Service Name"
}

variable "critical_ag" {
  type        = string
  description = "Critical Action Group ID"
  default     = null
}

variable "warning_ag" {
  type        = string
  description = "Warning Action Group ID"
  default     = null
}
