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

module "postgres_server" {
  source = "./modules/postgres_db"

  resource_group_name = module.resource_group.resource_group_name
  location            = var.location

  environment = var.environment
  application = var.application
  owner       = var.owner
  prefix      = var.prefix
}

module "web_app" {
  source = "./modules/web_app"

  prefix      = var.prefix
  application = var.application
  environment = var.environment
  owner       = var.owner

  resource_group_name = module.resource_group.resource_group_name
  location            = var.location

  postgres_user     = module.postgres_server.postgres_user
  postgres_password = module.postgres_server.postgres_password
  postgres_host     = module.postgres_server.postgres_host
}
