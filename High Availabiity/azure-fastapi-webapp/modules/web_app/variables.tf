variable "resource_group_name" {
    type = string
    description = "RG Name"
}

variable "location" {
    type = string
    description = "Location"
}

variable "application" {
    type = string
    description = "application"
}

variable "environment" {
    type = string
    description = "environment"
}

variable "owner" {
    type = string
    description = "owner"
}

variable "postgres_user" {
    type = string
    description = "postgres_user"
}

variable "postgres_password" {
    type = string
    description = "postgres_password"
}

variable "postgres_server_name" {
    type = string
    description = "postgres_server"
}

variable "postgres_port" {
    type = string
    description = "postgres_port"
}

variable "database_name" {
    type = string
    description = "database_name"
}
