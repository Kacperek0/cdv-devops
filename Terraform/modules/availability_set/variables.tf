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

variable "location" {
  type        = string
  description = "Azure region"
}

variable "resource_group_name" {
  type        = string
  description = "Resource group name"
}

variable "owner" {
  type        = string
  description = "Resource owner"
}
