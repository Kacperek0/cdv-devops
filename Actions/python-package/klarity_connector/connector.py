# Native libraries
import json

# Third party libraries
import requests
from requests.adapters import HTTPAdapter, Retry

class KlarityConnector:
    """
    Connector class for Klarity.
    Establishes connection to Klarity and provides methods for sending GraphQL requests.

    :param region: Region to connect to. Valid values are 'us', 'eu' and 'uk'.
    :type region: str

    :param api_key: API key for Klarity.
    :type api_key: str

    """
    def __init__(self, region: str, api_key: str, billing_period: str = 'current'):
        """
        Establish Klarity connection
        """
        self.region = region
        self.api_key = api_key
        self.billing_period = billing_period
        self.url = self.__get_url(region)

        self.retry_strategy = Retry(
            total=10,
            status_forcelist=[500, 502, 503, 504],
            allowed_methods=['POST'],
            backoff_factor=3
        )

        self.adapter = HTTPAdapter(max_retries=self.retry_strategy)

        self.session = requests.Session()

        self.session.mount('https://', self.adapter)


    def __get_url(self, region) -> str:
        """
        Get url for region
        """
        if region == 'us':
            return 'https://api.cnop-int.us.nordcloudapp.com/graphql'
        elif region == 'eu':
            return 'https://api.cnop-int.nordcloudapp.com/graphql'
        elif region == 'uk':
            return 'https://api.cnop-int.uk.nordcloudapp.com/graphql'
        else:
            raise ValueError(f'Invalid region: {region}')

    def graphql_request(self, query: str, variables: dict = None) -> dict:
        """
        Send GraphQL request
        """

        response = self.session.post(
            self.url,
            json={
                'query': query,
                'variables': variables
            }, headers={
                'x-api-key': self.api_key,
                'x-billing-period': self.billing_period
            }
        )

        if response.status_code != 200:
            print(f'GraphQL request failed with status code {response.status_code} and response body {response.text}')

        return json.loads(response.text)
