#!/bin/bash

#
# Insert something into a file (only if it's not already in it)
#
# Argument 1: options to be passed in a string
# -a: append the content at the end of the file instead of overwriting the complete file
# -s: use sudo to insert the content into the file
#
# Argument 2: the content to insert
# Argument 3: the file in which to insert the content
#
insert() {
  local INPUT=$2
  local FILE=$3
  local APPEND=""
  local SUDO=""

  # Options
  if [[ $1 == *"-a"* ]]; then
    APPEND="--append"
  fi
  if [[ $1 == *"-s"* ]]; then
    SUDO=`which sudo`
  fi

  # Ensure the folder/file exists
  if [ ! -f ${FILE} ]; then
    ${SUDO} mkdir -p $(dirname ${FILE})
    ${SUDO} touch ${FILE}
  fi

  # Insert only if the content is not already found in the file
  if [ -z "$APPEND" ] || [ ! `grep -q -F "${INPUT}" ${FILE}` ] ; then
    printf "\nInsert the following content into ${FILE} (using options: -a=\"${APPEND}\" -s=\"${SUDO}\"):\n"
    printf "${INPUT}" | sed 's/^/  /'
    printf "\n\n"

    echo "${INPUT}" | ${SUDO} tee ${APPEND} ${FILE} > /dev/null
  fi
}
