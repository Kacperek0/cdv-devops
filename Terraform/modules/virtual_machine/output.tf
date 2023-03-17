output "vm_name" {
    value = azurerm_linux_virtual_machine.linux_machine.name
}

output "vm_nic" {
    value = azurerm_network_interface.nic.id
}
