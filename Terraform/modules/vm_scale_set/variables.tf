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

variable "resource_group_name" {
  type        = string
  description = "Resource group name"
}

variable "location" {
  type        = string
  description = "Azure region"
}

variable "instances" {
  type        = number
  description = "Nubmer of instances deployed"
}

variable "admin_password" {
  type        = string
  description = "Admin password"
}

variable "sg_id" {
  type        = string
  description = "Security Group ID"
}

variable "subnet_id" {
  type        = string
  description = "Subnet ID"
}

variable "owner" {
  type        = string
  description = "Resource owner"
}

variable "is_from_golden_image" {
  type        = bool
  description = "Is VMSS created from custom image"
}

variable "golden_image_id" {
  type        = string
  description = "Golden image ID"
  default     = null
}
