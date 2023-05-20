import os
import logging

import azure.functions as func
from azure.cognitiveservices.vision.computervision import ComputerVisionClient
from azure.storage.blob import BlobServiceClient
from msrest.authentication import CognitiveServicesCredentials


def set_blob_metadata(myblob: func.InputStream, metadata: dict) -> None:
    storage_connection_string = os.getenv('cdvhotdogi1240834892_STORAGE')
    blob_service_client = BlobServiceClient.from_connection_string(storage_connection_string)
    logging.info(myblob)
    logging.info(metadata)
    logging.info(blob_service_client)

    container_name = 'photos'
    container_client = blob_service_client.get_container_client(container_name)
    logging.info(container_client)

    blob_name = myblob.name.split('/')[-1]
    blob_client = container_client.get_blob_client(blob_name)
    logging.info(myblob.name)
    logging.info(blob_client)

    blob_client.set_blob_metadata(metadata)

def check_whats_in_bun(client: ComputerVisionClient, myblob: func.InputStream) -> dict:
    metadata = {
        'is_hotdog': None
    }

    response = client.detect_objects_in_stream(myblob)

    if response.objects:
        objects = response.objects
        is_hotdog = False

        for item in objects:
            if 'hot dog' in item.object_property.lower():
                is_hotdog = True
                break

        if is_hotdog:
            logging.info('Hotdog! 🌭')
            metadata['is_hotdog'] = 'Hotdog'
        else:
            logging.info('Not hotdog 😡')
            metadata['is_hotdog'] = 'Not hotdog'
    else:
        logging.info('Not hotdog 😡')
        metadata['is_hotdog'] = 'Not hotdog'

    return metadata


def main(myblob: func.InputStream):
    logging.info(f"Python blob trigger function processed blob \n"
                 f"Name: {myblob.name}\n"
                 f"Blob Size: {myblob.length} bytes")

    subscription_key = os.getenv('SUBSCRIPTION_KEY')
    endpoint = os.getenv('ENDPOINT')

    client = ComputerVisionClient(
        endpoint=endpoint,
        credentials=CognitiveServicesCredentials(subscription_key)
    )

    metadata = check_whats_in_bun(client, myblob)
    logging.info(myblob)
    logging.info(myblob.name)
    logging.info(metadata)
    set_blob_metadata(myblob, metadata)
