#!/usr/bin/env bash

BIN_PATH="$( dirname $( realpath "${0}" ) )"
PROVISION_PATH="$( realpath "${BIN_PATH}/provision" )"
PROJECT_PATH="$( realpath "${BIN_PATH}/.." )"

. ${PROVISION_PATH}/env.sh

source "${PROJECT_PATH}/.env"

. ${PROVISION_PATH}/system.sh
. ${PROVISION_PATH}/project.sh
