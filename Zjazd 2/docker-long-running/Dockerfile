FROM python:3.10-slim

# Set workdirectory
WORKDIR /usr/src/app

# Copy application code
COPY . .

# Install utility tools
RUN apt update && apt install -y \
    htop \
    vim \
    git

# Run application
CMD [ "python", "./main.py"]
