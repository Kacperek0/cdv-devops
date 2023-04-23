terraform {
  required_providers {
    datadog = {
      source  = "DataDog/datadog"
      version = "3.23.0"
    }
  }
}

provider "datadog" {
  api_key = var.datadog_api_key
  app_key = var.datadog_app_key
  api_url = "https://api.datadoghq.eu/"
}
