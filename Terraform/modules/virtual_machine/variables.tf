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
  type        = string
  description = "Subnet Id"
}

variable "sg_id" {
  type        = string
  description = "NSG Id"
}

variable "create_public_ip" {
  type        = bool
  description = "Should Public IP be created"
}

variable "create_as" {
  type        = bool
  description = "Should be placed in Availability Set"
}

variable "availability_set_id" {
  type        = string
  description = "Availability set ID"
  default     = null
}
