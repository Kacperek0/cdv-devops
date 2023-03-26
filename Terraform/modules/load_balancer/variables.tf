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
  description = "Environment type"
}

variable "resource_group_name" {
  type        = string
  description = "RG Name"
}

variable "location" {
  type        = string
  description = "Azure region"
}

variable "owner" {
  type        = string
  description = "Resource owner"
}

variable "vm_names" {
  type        = list(any)
  description = "Backend pool vm names"
}

variable "vm_nic" {
  type        = list(any)
  description = "VM's NIC list"
}
