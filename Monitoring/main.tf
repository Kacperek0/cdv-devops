module "iaas_nginx" {
    source = "./applications/iaas_nginx"

    datadog_api_key = var.datadog_api_key
    datadog_app_key = var.datadog_app_key
}
