variable "application" {
  type        = string
  description = "Applcation name"
}

variable "environment" {
  type        = string
  description = "Environment type"
}

variable "owner" {
  type        = string
  description = "Owner email"
  default     = "kacper.szczepanek@cdv.pl"
}

variable "location" {
  type        = string
  description = "Azure region"
}

variable "prefix" {
  type        = string
  description = "Team prefix"
}


variable "resource_group_name" {
  type        = string
  description = "Resource group name"
}

variable "vm_names" {
    type        = list(string)
    description = "VM names"
}

variable "vm_nic" {
    type        = list(string)
    description = "VM NICs"
}
