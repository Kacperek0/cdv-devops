terraform {
  required_providers {
    azurerm = {
      source  = "hashicorp/azurerm"
      version = "3.42.0"
    }
  }
  backend "azurerm" {
    resource_group_name  = var.backend_rg_name
    storage_account_name = var.backend_sa_name
    container_name       = "tfstate"
    key                  = "terraform.tfstate"
  }
}

provider "azurerm" {
  features {}
}
