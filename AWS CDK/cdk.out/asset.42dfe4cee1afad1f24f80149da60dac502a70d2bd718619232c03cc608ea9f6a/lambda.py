import json
import requests

def get_current_pull_requests() -> json:
    response = requests.get('https://api.github.com/repos/octocat/Hello-World/pulls')

    return response.json()

def lambda_handler(event, context):
    recent_pull_requests = get_current_pull_requests()
    return {
        'statusCode': 200,
        'body': json.dumps(recent_pull_requests)
    }
