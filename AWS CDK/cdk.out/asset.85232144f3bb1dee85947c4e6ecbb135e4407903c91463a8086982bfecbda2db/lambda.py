import os
import json
import requests
import boto3
import datetime

client = boto3.client('dynamodb')

def get_current_pull_requests() -> json:
    response = requests.get('https://api.github.com/repos/octocat/Hello-World/pulls')

    table = os.getenv('TABLE_NAME')
    client.put_item(
        TableName=table,
        Item={
            'pull_requests': response.json()
        }
    )

    return response.json()

def lambda_handler(event, context):
    recent_pull_requests = get_current_pull_requests()
    return {
        'statusCode': 200,
        'body': json.dumps(recent_pull_requests)
    }
