#!/bin/bash
title() {
    printf "\n"
    yes "#" | head -$(( ${#1} + 6)) | tr -d "\n"
    printf "\n## ${1} ##\n"
    yes "#" | head -$(( ${#1} + 6)) | tr -d "\n"
    printf "\n\n"
}

PROJECT_FOLDER=$1
SCRIPTS_PATH="${PROJECT_FOLDER}/scripts/provisioning"

title "Install useful softwares"
sudo add-apt-repository ppa:ondrej/php5-5.6
sudo apt-get update
sudo apt-get install -y python-software-properties git-core curl
sudo apt-get update

title "Install Apache, PHP and its extensions"
source ${SCRIPTS_PATH}/vagrant/webserver.sh ${PROJECT_FOLDER}

title "Configure the project"
source ${SCRIPTS_PATH}/project.sh ${PROJECT_FOLDER}

title "Configure the shell"
source ${SCRIPTS_PATH}/vagrant/shell.sh ${PROJECT_FOLDER}

title "Clean-up"
sudo apt-get clean
