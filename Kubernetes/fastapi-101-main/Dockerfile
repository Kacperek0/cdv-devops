FROM python:3.10-slim

WORKDIR /app

COPY requirements.txt requirements.txt

RUN pip3 install -r requirements.txt

COPY ./src .

EXPOSE 8000

CMD ["python3", "main.py"]
