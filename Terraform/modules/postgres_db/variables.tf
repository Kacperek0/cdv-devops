variable "resource_group_name" {
  type        = string
  description = "Resource group name"
}

variable "location" {
  type        = string
  description = "Azure region"
}

variable "environment" {
  type        = string
  description = "Environment name"
}

variable "application" {
  type        = string
  description = "Application name"
}

variable "owner" {
  type        = string
  description = "Owner email"
}

variable "prefix" {
  type        = string
  description = "Team prefix"
}
