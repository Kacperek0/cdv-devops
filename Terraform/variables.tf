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

variable "backend_rg_name" {
  type        = string
  description = "Remote backend RG name"
}

variable "backend_sa_name" {
  type        = string
  description = "Remote backend Storage Account name"
}
