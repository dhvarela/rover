#!/bin/bash

# Copy config files
cp .env.template .env
cp docker-container-config-files/sites/rover.com.template docker-container-config-files/sites/rover.com
cp docker-container-config-files/xdebug/xdebug.ini.template docker-container-config-files/xdebug/xdebug.ini

# Add domain to local hosts file
echo "172.16.4.2 rover.com" | sudo tee -a /etc/hosts