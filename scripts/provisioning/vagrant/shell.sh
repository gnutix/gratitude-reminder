#!/bin/bash
PROJECT_FOLDER=$1
source ${PROJECT_FOLDER}/scripts/provisioning/utils/insert.sh

# Make composer executable accessible globally
if [ ! -f "/usr/local/bin/composer" ]; then
  sudo ln -s ${PROJECT_FOLDER}/composer.phar /usr/local/bin/composer
fi

# Update bash profile
insert "-a" "cd ${PROJECT_FOLDER}" "${HOME}/.bashrc"
