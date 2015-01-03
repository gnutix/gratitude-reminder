#!/bin/bash
PROJECT_FOLDER=$1
source ${PROJECT_FOLDER}/scripts/provisioning/utils/insert.sh

# Avoid Apache warnings
insert "-s" "ServerName localhost" "/etc/apache2/conf-enabled/fqdn.conf"

# Install PHP and its extensions
sudo apt-get install -y apache2 libapache2-mod-php5

# Configure PHP timezone
TIMEZONE=$(cat "${PROJECT_FOLDER}/scripts/provisioning/resources/timezone.ini")
PHP_CLI_PATH=$(php --ini | grep "Scan for additional .ini files in:" | cut -d" " -f7)
insert "-s" "${TIMEZONE}" "${PHP_CLI_PATH}/20-timezone.ini"
insert "-s" "${TIMEZONE}" "/etc/php5/apache2/conf.d/20-timezone.ini"

# Configure Apache Virtual Host
VHOST=$(cat <<EOF
<VirtualHost *:80>
  DocumentRoot "${PROJECT_FOLDER}/web"
  ServerName 127.0.0.1
  <Directory "${PROJECT_FOLDER}/web">
    AllowOverride All
    Require all granted
  </Directory>
</VirtualHost>
EOF
)
insert "-s" "${VHOST}" "/etc/apache2/sites-enabled/000-default.conf"

# Activate mod_rewite
sudo a2enmod rewrite

# Restart the server to apply the changes
sudo service apache2 reload
