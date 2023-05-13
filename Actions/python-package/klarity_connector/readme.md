### Klarity Connector
Python connector for Klarity API

#### Installation
```bash
pip install klarity-connector
```

#### Usage
```python

from klarity_connector import KlarityConnector

# Create a connector
connector = KlarityConnector(
    region='eu'
    api_key='YOUR_API_KEY',
)

# Sending GraphQL query
query = """
    query applications{
        applicationsPaginated(limit: 100, page: 0){
            results{
                name,
                cost{
                    currentMonth
                }
            }
        }
    }
"""

response = connector.graphql_request(query)

# Sending GraphQL mutation
mutation = """
    mutation createApplication($name: String!, $description: String){
        createApplication(name: $name, description: $description){
            name
        }
    }
"""

variables = {
    'name': 'My new application',
    'description': 'My new application description'
}

response = connector.graphql_request(mutation, variables)

```

### Official product documentation
[docs](https://docs.klarity.nordcloudapp.com)
