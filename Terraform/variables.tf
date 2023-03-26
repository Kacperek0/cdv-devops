variable "application" {
  type        = string
  description = "Applcation name"
}

variable "environments" {
  type        = set(string)
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

variable "admin_password" {
  type        = string
  description = "Admin password"
}

variable "environment" {
  type        = string
  description = "Environment type"
}
