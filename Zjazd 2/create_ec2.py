import os
import boto3

from dotenv import load_dotenv

load_dotenv()

"""
1. Tworzenie VPC
2. Tworzenie Internet Gateway
3. Route Table
4. Subnet
5. Przypisac RT do subnetu
6. Stworzenie instancji
    a. Wpięcie instancji do domyślnej Security Grupy
    b. Dodanie publicznego IP do maszyny
"""
# Nizszy poziom abstrakcji
# client = boto3.client('ec2')

# Wyzszy poziom abstrakcji
client = boto3.resource(
    'ec2',
    aws_access_key_id=os.getenv('AWS_KEY'),
    aws_secret_access_key=os.getenv('AWS_SECRET'),
    region_name='eu-west-1'
    )

def tag_resource(resource_type: str, name: str) -> list[dict]:

    return [
        {
            'ResourceType': resource_type,
            'Tags': [
                {
                    'Key': 'Name',
                    'Value': f'{name}-{resource_type}'
                },
                {
                    'Key': 'Env',
                    'Value': 'Sandbox'
                },
                {
                    'Key': 'App',
                    'Value': 'CDV-EC2'
                }
            ]
        }
    ]


def create_vpc(dry_run: bool):
    vpc = client.create_vpc(
        DryRun=dry_run,
        CidrBlock='10.0.0.0/16',
        TagSpecifications=tag_resource('vpc', 'ec2-lab')
    )

    vpc.wait_until_available()

    return vpc


def create_security_group(vpc):
    security_group = vpc.create_security_group(
        Description='Sandbox SG',
        GroupName='sandbox-sg',
        TagSpecifications=tag_resource('security-group', 'sandbox-sg'),
    )

    security_group.authorize_ingress(
        CidrIp='0.0.0.0/0',
        FromPort=22,
        ToPort=22,
        IpProtocol='-1'
    )

    return security_group

def create_internet_gateway(dry_run: bool):
    internet_gw = client.create_internet_gateway(
        DryRun=dry_run,
        TagSpecifications=tag_resource('internet-gateway', 'igw')
    )

    return internet_gw


def create_route_table(vpc, igw, dry_run: bool):
    route_table = vpc.create_route_table(
        DryRun=dry_run,
        TagSpecifications=tag_resource('route-table', 'rt')
    )

    route = route_table.create_route(
        DestinationCidrBlock='0.0.0.0/0',
        GatewayId=igw.id
    )

    return {
        'route_table': route_table,
        'route': route
    }


def create_subnet(dry_run: bool, vpc, route_table):
    subnet = client.create_subnet(
        DryRun=dry_run,
        CidrBlock='10.0.0.0/18',
        VpcId=vpc.id,
        TagSpecifications=tag_resource('subnet', 'subnet')
    )

    route_table.associate_with_subnet(SubnetId=subnet.id)

    return subnet


def create_instance(subnet, security_group) -> None:
    instance = client.create_instances(
        BlockDeviceMappings=[
            {
                'DeviceName': '/dev/xvda',
                'Ebs': {
                    'DeleteOnTermination': True,
                    'VolumeSize': 10,
                    'VolumeType': 'gp2'
                }
            }
        ],
        ImageId='ami-01cae1550c0adea9c',
        InstanceType='t2.micro',
        KeyName='cdv-aws',
        MaxCount=1,
        MinCount=1,
        TagSpecifications=tag_resource('instance', 'ec2-lab'),
        NetworkInterfaces=[{
            'AssociatePublicIpAddress': True,
            'SubnetId': subnet.id,
            'DeviceIndex': 0,
            'Groups': [
                security_group.id
            ]
        }],
    )

    print(instance[0].id)


def main():
    vpc = create_vpc(False)
    security_group = create_security_group(vpc)
    igw = create_internet_gateway(False)
    vpc.attach_internet_gateway(
        InternetGatewayId=igw.id
    )
    route_table = create_route_table(vpc=vpc, igw=igw, dry_run=False)
    subnet = create_subnet(dry_run=False, vpc=vpc, route_table=route_table['route_table'])
    create_instance(subnet, security_group)

if __name__ == '__main__':
    main()

