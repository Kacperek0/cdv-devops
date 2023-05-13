import os
import logging

import azure.functions as func
from azure.cognitiveservices.vision.computervision import ComputerVisionClient
from msrest.authentication import CognitiveServicesCredentials


def main(myblob: func.InputStream):
    logging.info(f"Python blob trigger function processed blob \n"
                f"Name: {myblob.name}\n"
                f"Blob Size: {myblob.length} bytes")

    subscription_key = os.getenv('COMPUTER_VISION_SUBSCRIPTION_KEY')
    endpoint = os.getenv('COMPUTER_VISION_ENDPOINT')

    credentials = CognitiveServicesCredentials(subscription_key)
    client = ComputerVisionClient(endpoint, credentials)

    response = client.detect_objects_in_stream(myblob)

    if response.objects:
        objects = response.objects
        is_hotdog = False

        for obj in objects:
            if obj.object_property == "Hot dog":
                is_hotdog = True
                break

        if is_hotdog:
            logging.info("Hotdog!")
            return "Hotdog!"
        else:
            logging.info("Not hotdog!")
            return "Not hotdog!"
    else:
        logging.info("No objects detected.")
        return "No objects detected."
