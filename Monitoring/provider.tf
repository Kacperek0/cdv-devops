terraform {
  required_providers {
    datadog = {
      source  = "DataDog/datadog"
      version = "3.23.0"
    }
  }
  backend "azurerm" {
    resource_group_name  = "cdv-tfstate-rg"
    storage_account_name = "cdvftstatekacper"
    container_name       = "datadog-tfstate"
    key                  = "terraform.tfstate"
  }
}

provider "datadog" {
  api_key = var.datadog_api_key
  app_key = var.datadog_app_key
  api_url = "https://api.datadoghq.eu/"
}
