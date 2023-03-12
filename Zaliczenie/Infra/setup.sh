#!/bin/bash
# Update apt
sudo apt-get update
# Install git
sudo apt-get install git
# Install nginx
sudo apt-get install nginx
# Enable nginx
sudo systemctl enable nginx
# Start nginx
sudo systemctl start nginx
# Install PostgreSQL
sudo apt-get install postgresql postgresql-contrib
# Enable PostgreSQL
sudo systemctl enable postgresql
# Start PostgreSQL
sudo systemctl start postgresql
# Create postgresql user
sudo -u postgres createuser --superuser $USER
# Create postgresql database
sudo -u postgres createdb $USER
# Install Python
sudo apt-get install python3 python3-pip
# Install NPM
sudo apt-get install npm
# Install NodeJS
sudo apt-get install nodejs
# install React
sudo npm install -g create-react-app
# install nohup

# Clone repository
git clone https://github.com/Kacperek0/cdv-devops.git
# Go to repository
cd Zaliczenie/Backend
# Install virtualenv
sudo pip3 install virtualenv
# Create virtualenv
virtualenv -p python3 venv
# Activate virtualenv
source venv/bin/activate
# Install requirements
pip3 install -r requirements.txt
# Start python3 backend server
nohup python3 main.py

# Go to repository
cd Zaliczenie/Frontend
# Install requirements
npm install
# Build react
npm run build
# Copy build to nginx
sudo cp -r build/* /var/www/html/

# Configure nginx
sudo cp /home/kacper/Zaliczenie/Infra/nginx.conf /etc/nginx/sites-available/default
# Restart nginx
sudo systemctl restart nginx


