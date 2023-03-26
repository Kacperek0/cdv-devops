terraform {
  required_providers {
    azurerm = {
      source  = "hashicorp/azurerm"
      version = "3.42.0"
    }
  }
  backend "azurerm" {
    resource_group_name  = "cdv-tfstate-rg"
    storage_account_name = "cdvftstatekacper"
    container_name       = "tfstate"
    key                  = "terraform.tfstate"
  }
}

provider "azurerm" {
  features {}
}
