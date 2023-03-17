module "resource_group" {
  source = "./modules/resource_group"

  application = var.application
  environment = "all"
  owner       = var.owner
  location    = var.location
  prefix      = var.prefix
}

# module "storage_account" {
#   source   = "./modules/storage_account"
#   for_each = var.environments

#   application         = var.application
#   environment         = each.key
#   owner               = var.owner
#   location            = var.location
#   resource_group_name = module.resource_group.resource_group_name
# }

module "networking" {
  source = "./modules/networking"

  application         = var.application
  environment         = var.environment
  owner               = var.owner
  location            = var.location
  prefix              = var.prefix
  resource_group_name = module.resource_group.resource_group_name
}

module "webserver_virtual_machine" {
  source = "./modules/virtual_machine"

  count = 2

  application         = var.application
  environment         = var.environment
  owner               = var.owner
  location            = var.location
  prefix              = var.prefix
  instances           = count.index
  admin_password      = var.admin_password
  resource_group_name = module.resource_group.resource_group_name
  subnet_id           = module.networking.subnet_id
  sg_id               = module.networking.sg_id
  create_public_ip    = false
}

module "bastion_host" {
  source = "./modules/virtual_machine"

  count = 1

  application         = "bastion"
  environment         = var.environment
  owner               = var.owner
  location            = var.location
  prefix              = var.prefix
  instances           = count.index
  admin_password      = var.admin_password
  resource_group_name = module.resource_group.resource_group_name
  subnet_id           = module.networking.subnet_id
  sg_id               = module.networking.sg_id
  create_public_ip    = true
}

module "webserver_load_balancer" {
  source = "./modules/load_balancer"

  application         = var.application
  environment         = var.environment
  owner               = var.owner
  location            = var.location
  prefix              = var.prefix
  resource_group_name = module.resource_group.resource_group_name
  vm_names = [
    module.webserver_virtual_machine[0].vm_name,
    module.webserver_virtual_machine[1].vm_name,
  ]
  vm_nic = [
    module.webserver_virtual_machine[0].vm_nic,
    module.webserver_virtual_machine[1].vm_nic,
  ]
}
