#!/bin/bash
PROJECT_FOLDER=$1

# Install the project's dependencies
cd ${PROJECT_FOLDER}
curl -sS https://getcomposer.org/installer | php
php composer.phar install --no-interaction --prefer-source --no-progress
