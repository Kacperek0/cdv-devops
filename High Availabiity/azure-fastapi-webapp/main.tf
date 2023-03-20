module "resource_group" {
  source = "./modules/resource_group"

  application = var.application
  environment = "all"
  owner       = var.owner
  location    = var.location
  prefix      = var.prefix
}

module "networking" {
  source = "./modules/networking"

  application         = var.application
  environment         = var.environment
  owner               = var.owner
  location            = var.location
  prefix              = var.prefix
  resource_group_name = module.resource_group.resource_group_name
}

module "postgres_database" {
  source = "./modules/managed_postgres"

  application         = var.application
  environment         = var.environment
  owner               = var.owner
  location            = var.location
  resource_group_name = module.resource_group.resource_group_name
}

module "web_app" {
  source = "./modules/web_app"

  application         = var.application
  environment         = var.environment
  owner               = var.owner
  location            = var.location
  resource_group_name = module.resource_group.resource_group_name
  postgres_user       = module.postgres_database.postgres_user
  postgres_password   = module.postgres_database.postgres_password
  postgres_server_name     = module.postgres_database.postgres_server_name
  postgres_port       = "5432"
  database_name       = module.postgres_database.database_name

  depends_on = [
    module.postgres_database
  ]
}
