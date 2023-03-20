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
  description = "Environment type"
}

variable "application" {
  type        = string
  description = "Applcation name"
}

variable "owner" {
  type        = string
  description = "Owner email"
  default     = "kacper.szczepanek@cdv.pl"
}
