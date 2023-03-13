#!/bin/bash
# Update apt
sudo apt-get update -y
# Install git
sudo apt-get install git -y
# Install nginx
sudo apt-get install nginx -y
# Enable nginx
sudo systemctl enable nginx
# Start nginx
sudo systemctl start nginx
# Update OpenSSL
sudo apt-get upgrade openssl
# Install PostgreSQL
sudo apt-get install postgresql postgresql-contrib -y
# Open PostgreSQL port
sudo ufw allow 5432
# Enable PostgreSQL
sudo systemctl enable postgresql
# Start PostgreSQL
sudo systemctl start postgresql
# Create postgresql user
sudo -u postgres createuser --superuser $USER
# Create postgresql database
sudo -u postgres createdb $USER
# Set postgresql password
echo "ALTER USER azureuser PASSWORD 'postgres';" | sudo -u postgres psql
# Install pip3
sudo apt-get install python3-pip -y
# Set python3.10 as default
sudo update-alternatives --install /usr/bin/python3 python3 /usr/bin/python3.10 1
# Install NPM
sudo apt-get install npm -y
# Install NodeJS
sudo apt-get install nodejs -y
# install React
sudo npm install -g create-react-app


# Go to repository
cd ../Backend
# Install requirements
pip3 install -r requirements.txt
# Resolve JWT error
pip uninstall JWT -y
pip uninstall PyJWT -y
pip install PyJWT
# Start python3 backend server
nohup python3 main.py &

# Go to repository
cd ../Frontend
# Install requirements
npm install
# Build react
npm run build
# Copy build to nginx
sudo cp -r build/* /var/www/html/

# Copy nginx config
sudo cp ../Infra/nginx.conf /etc/nginx/sites-available/default
# Restart nginx
sudo systemctl restart nginx


