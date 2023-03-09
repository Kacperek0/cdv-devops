output "subnet_id" {
  value = azurerm_subnet.subnet.id
}

output "sg_id" {
    value = azurerm_network_security_group.nsg.id
}
