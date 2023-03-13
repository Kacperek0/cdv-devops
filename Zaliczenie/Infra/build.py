import os
import sys

from dotenv import load_dotenv
from azure.identity import ClientSecretCredential
from azure.mgmt.compute import ComputeManagementClient
from azure.mgmt.network import NetworkManagementClient
from azure.mgmt.network.v2021_02_01.models import NetworkSecurityGroup
from azure.mgmt.network.v2021_02_01.models import (
    SecurityRule,
    SecurityRuleAccess,
    SecurityRuleDirection,
    SecurityRuleProtocol,
)
from azure.mgmt.resource import ResourceManagementClient
from azure.mgmt.network.v2021_02_01.models import (
    PublicIPAddress,
    PublicIPAddressDnsSettings,
    PublicIPAddressSku,
)

load_dotenv()

def create_azure_resource_group(credentials, subscription_id, resource_group_name, location):
    # Create a resource group
    resource_client = ResourceManagementClient(credentials, subscription_id)
    resource_client.resource_groups.create_or_update(
        resource_group_name, {'location': location}
    )


def create_vnet(credentials, subscription_id, resource_group_name, location, vnet_name, subnet_name):
    network_client = NetworkManagementClient(credentials, subscription_id)
    async_vnet_creation = network_client.virtual_networks.begin_create_or_update(
        resource_group_name,
        vnet_name,
        {
            "location": location,
            "address_space": {"address_prefixes": ["10.0.0.0/16"]},
            "subnets": [{"name": subnet_name, "address_prefix": "10.0.1.0/24"}],
        },
    )
    vnet = async_vnet_creation.result()

    return vnet


def create_network_security_group(credentials, subscription_id, resource_group_name, nsg_name):
    # Create a network security group (NSG)
    network_client = NetworkManagementClient(credentials, subscription_id)
    nsg = network_client.network_security_groups.begin_create_or_update(
        resource_group_name,
        nsg_name,
        NetworkSecurityGroup(location="westeurope")
    ).result()

    # Add security rules to the NSG to allow inbound traffic on ports 22, 80, and 443
    inbound_rules = [
        SecurityRule(
            name="allow_ssh",
            access=SecurityRuleAccess.allow,
            description="Allow SSH",
            destination_address_prefix="*",
            destination_port_range="22",
            direction=SecurityRuleDirection.inbound,
            priority=100,
            protocol=SecurityRuleProtocol.tcp,
            source_address_prefix="*",
            source_port_range="*",
        ),
        SecurityRule(
            name="allow_http",
            access=SecurityRuleAccess.allow,
            description="Allow HTTP",
            destination_address_prefix="*",
            destination_port_range="80",
            direction=SecurityRuleDirection.inbound,
            priority=200,
            protocol=SecurityRuleProtocol.tcp,
            source_address_prefix="*",
            source_port_range="*",
        ),
        SecurityRule(
            name="allow_https",
            access=SecurityRuleAccess.allow,
            description="Allow HTTPS",
            destination_address_prefix="*",
            destination_port_range="443",
            direction=SecurityRuleDirection.inbound,
            priority=300,
            protocol=SecurityRuleProtocol.tcp,
            source_address_prefix="*",
            source_port_range="*",
        ),
    ]
    for rule in inbound_rules:
        network_client.security_rules.begin_create_or_update(
            resource_group_name,
            nsg_name,
            rule.name,
            rule
        ).result()

    return nsg


def create_public_ip_address(credentials, subscription_id, resource_group_name, public_ip_name, location):
    # Create a public IP address for the virtual machine
    network_client = NetworkManagementClient(credentials, subscription_id)
    public_ip_address_params = PublicIPAddress(
        location=location,
        sku=PublicIPAddressSku(name="Standard"),
        public_ip_allocation_method="Static",
        dns_settings=PublicIPAddressDnsSettings(domain_name_label=public_ip_name)
    )
    public_ip_address_result = network_client.public_ip_addresses.begin_create_or_update(
        resource_group_name, public_ip_name, public_ip_address_params
    ).result()

    return public_ip_address_result


def create_virtual_machine(credentials, subscription_id, resource_group_name, vm_name, location, vnet, subnet, nsg, public_ip_address):
    vm_client = ComputeManagementClient(credentials, subscription_id)
    # Create a network interface for the virtual machine
    network_client = NetworkManagementClient(credentials, subscription_id)
    nic = network_client.network_interfaces.begin_create_or_update(
        resource_group_name,
        vm_name,
        {
            "location": location,
            "ip_configurations": [
                {
                    "name": "ipconfig1",
                    "subnet": {"id": subnet.id},
                    "private_ip_allocation_method": "Dynamic",
                    "public_ip_address": {"id": public_ip_address.id},
                }
            ],
            "network_security_group": {"id": nsg.id},
        },
    ).result()

    vm_client.virtual_machines.begin_create_or_update(
        resource_group_name,
        vm_name,
        {
            "location": location,
            "storage_profile": {
                "image_reference": {
                    "publisher": "canonical",
                    "offer": "0001-com-ubuntu-server-jammy",
                    "sku": "22_04-lts",
                    "version": "latest",
                }
            },
            "hardware_profile": {"vm_size": "Standard_B1s"},
            "os_profile": {
                "computer_name": vm_name,
                "admin_username": "azureuser",
                "admin_password": "Password123!",
                "linux_configuration": {"disable_password_authentication": False},
            },
            "network_profile": {
                "network_interfaces": [
                    {
                        "id": "/subscriptions/{}/resourceGroups/{}/providers/Microsoft.Network/networkInterfaces/{}".format(
                            subscription_id, resource_group_name, vm_name
                        ),
                        "primary": True,
                    }
                ]
            },
        },
    ).result()

    # Attach the network interface to the virtual machine
    vm_client.virtual_machines.begin_update(
        resource_group_name,
        vm_name,
        {
            "network_profile": {
                "network_interfaces": [
                    {
                        "id": nic.id,
                        "primary": True,
                    }
                ]
            }
        },
    ).result()

    return vm_client.virtual_machines.get(resource_group_name, vm_name)

def main():
    # Azure Datacenter
    location = "westeurope"

    # Azure Resource Group
    resource_group_name = "sales-prod-rg"

    # Azure Virtual Network
    vnet_name = "sales-prod-vnet"

    # Azure Virtual Network Subnet
    subnet_name = "sales-prod-subnet"

    # Azure Service Principal
    subscription_id = os.environ.get("AZURE_SUBSCRIPTION_ID")
    credentials = ClientSecretCredential(
        client_id=os.environ.get("AZURE_CLIENT_ID"),
        client_secret=os.environ.get("AZURE_CLIENT_SECRET"),
        tenant_id=os.environ.get("AZURE_TENANT_ID"),
    )

    # Create Azure resource group
    create_azure_resource_group(
        credentials, subscription_id, resource_group_name, location
    )

    # Create Azure Virtual Network
    vnet = create_vnet(
        credentials, subscription_id, resource_group_name, location, vnet_name, subnet_name
    )

    # Create Azure Network Security Group
    nsg = create_network_security_group(
        credentials, subscription_id, resource_group_name, "sales-prod-nsg"
    )

    # Create Azure Public IP Address
    public_ip_address = create_public_ip_address(
        credentials, subscription_id, resource_group_name, "sales-prod-ip", location
    )

    # Create Azure Virtual Machine
    vm = create_virtual_machine(
        credentials,
        subscription_id,
        resource_group_name,
        "sales-prod-vm",
        location,
        vnet,
        vnet.subnets[0],
        nsg,
        public_ip_address,
    )

    print("VM created: {}".format(vm.name))

if __name__ == "__main__":
    main()
