variable "name" {
  type        = string
  description = "Monitor name"
}

variable "type" {
  type        = string
  description = "Monitor type"
}

variable "warn_message" {
  type        = string
  description = "Warning message"
}

variable "warn_endpoint" {
  type        = string
  description = "Warning endpoint"
}

variable "critical_message" {
  type        = string
  description = "Critical message"
}

variable "critical_endpoint" {
  type        = string
  description = "Critical endpoint"
}

variable "mitigation_message" {
  type        = string
  description = "Mitigation message"
}

variable "time_range" {
  type        = string
  description = "Monitor time range"
}

variable "metric" {
  type        = string
  description = "Metric name"
}

variable "host" {
  type        = string
  description = "Host indicatior"
}

variable "comparison_operator" {
  type        = string
  description = "Comparison operator"
}

variable "critical_threshold" {
  type        = number
  description = "Critial threshold value"
}

variable "warn_threshold" {
  type        = number
  description = "Warning threshold value"
}

variable "critical_recovery" {
  type        = number
  description = "Critial threshold recovery value"
}

variable "warn_recovery" {
  type        = number
  description = "Warning threshold recovery value"
}

variable "datadog_api_key" {
  type        = string
  description = "Datadog API Key"
}

variable "datadog_app_key" {
  type        = string
  description = "Datadog App key"
}
