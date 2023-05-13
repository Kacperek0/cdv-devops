import unittest

from klarity_connector import KlarityConnector

class TestKlarityConnector(unittest.TestCase):
    def test_init(self):
        connector = KlarityConnector('eu', 'api_key')
        self.assertEqual(connector.region, 'eu')
        self.assertEqual(connector.api_key, 'api_key')
        self.assertEqual(connector.url, 'https://api.cnop-int.nordcloudapp.com/graphql')
        self.assertEqual(connector.retry_strategy.total, 10)
        self.assertEqual(connector.retry_strategy.status_forcelist, [500, 502, 503, 504])
        self.assertEqual(connector.retry_strategy.allowed_methods, ['POST'])
        self.assertEqual(connector.retry_strategy.backoff_factor, 3)
        self.assertEqual(connector.adapter.max_retries, connector.retry_strategy)


    def test_get_url_eu(self):
        connector = KlarityConnector('eu', 'api_key')
        self.assertEqual(connector._KlarityConnector__get_url('eu'), 'https://api.cnop-int.nordcloudapp.com/graphql')


    def test_get_url_us(self):
        connector = KlarityConnector('us', 'api_key')
        self.assertEqual(connector._KlarityConnector__get_url('us'), 'https://api.cnop-int.us.nordcloudapp.com/graphql')


    def test_get_url_uk(self):
        connector = KlarityConnector('uk', 'api_key')
        self.assertEqual(connector._KlarityConnector__get_url('uk'), 'https://api.cnop-int.uk.nordcloudapp.com/graphql')
        

    def test_get_url_invalid(self):
        connector = KlarityConnector('eu', 'api_key')
        with self.assertRaises(ValueError):
            connector._KlarityConnector__get_url('apac')
