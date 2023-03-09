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

variable "instances" {
  type        = number
  description = "VM count"
}

variable "admin_password" {
  type        = string
  description = "Admin passowrd"
}

variable "resource_group_name" {
  type        = string
  description = "Resource group name"
}

variable "subnet_id" {
    type = string
    description = "Subnet Id"
}

variable "sg_id" {
    type = string
    description = "NSG Id"
}
