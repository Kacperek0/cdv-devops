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

module "golden_image_vmss" {
  source = "./modules/vm_scale_set"

  prefix      = var.prefix
  application = var.application
  environment = var.environment
  owner       = var.owner

  resource_group_name = module.resource_group.resource_group_name
  location            = var.location

  instances = 2

  admin_password = var.admin_password

  sg_id     = module.networking.sg_id
  subnet_id = module.networking.subnet_id

  is_from_golden_image = true
  golden_image_id      = "/subscriptions/725fa6c3-bb84-4bc9-a873-2d1d65c02bbf/resourceGroups/cdv-golden-image-rg/providers/Microsoft.Compute/galleries/cdv_fastapi_gallery/images/fastapi-backend-generalized/versions/0.0.1"
}
