variable "prefix" {
  type        = string
  description = "team prefix"
}

variable "application" {
  type        = string
  description = "Application name"
}

variable "environment" {
  type        = string
  description = "Environment name"
}

variable "stage" {
  type        = string
  description = "Stage name"
}

variable "resource_group_name" {
  type        = string
  description = "Resource group name"
}

variable "location" {
  type        = string
  description = "Azure region"
}

variable "owner" {
  type        = string
  description = "Owner's email"
}
