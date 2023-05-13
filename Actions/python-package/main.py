import os

from klarity_connector import KlarityConnector

# Establish connection to Klarity
connector = KlarityConnector(
    region='eu',
    api_key=os.getenv('KLARITY_KEY')
)

def main():
    query = '''
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
    '''

    response = connector.graphql_request(query)

    print(response)

if __name__ == '__main__':
    main()
