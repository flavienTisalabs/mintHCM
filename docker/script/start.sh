#!/bin/bash

# Variables
REPO_URL="https://github.com/flavienTisalabs/mintHCM.git"
DEST_DIR="/var/www/MintHCM"
TEMP_DIR=$(mktemp -d)
FILE=/var/www/html/.initialized

# Always download the latest code from Git
if [ -d "$DEST_DIR" ]; then
    echo "Updating MintHCM from Git repository..."
    cd $DEST_DIR
    git pull origin main 
else
    echo "Cloning MintHCM from Git repository..."
    git clone $REPO_URL $TEMP_DIR
    cp -R $TEMP_DIR/* $DEST_DIR/
    rm -r $TEMP_DIR
fi

# Generate config
php /var/www/script/generate_config.php

# Set permissions
chown -R www-data:www-data $DEST_DIR
chmod -R 755 $DEST_DIR
chmod -R 755 $DEST_DIR/legacy/cache
chmod -R 755 $DEST_DIR/legacy/upload

# Check if the configMint4 file was generated
if [[ ! -f $DEST_DIR/configMint4 ]]; then
    printf "Error: Failed to generate configMint4 - please check the configuration\n"
    exit 1
fi

# Start Apache service
service apache2 start

# Make the MintHCM installation request
printf "Starting MintHCM installation...\n"
su -s /bin/bash -c 'php /var/www/MintHCM/MintCLI install < /var/www/MintHCM/configMint4' www-data

# Check the exit code
if [[ $? -ne 0 ]]; then
    printf "Error: MintHCM installation failed - please check logs\n"
else
    printf "MintHCM installation completed!\n"
    # Add cron and start service
    printf "*    *    *    *    *     cd /var/www/MintHCM/legacy; php -f cron.php > /dev/null 2>&1" > /var/spool/cron/crontabs/www-data
    service cron start
fi
