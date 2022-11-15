#!/bin/bash

path=$( cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )

"${path}"/composer.sh install
"${path}"/npm.sh install
"${path}"/npm.sh run build

if [ ! -d "${path}"/../public/assets ]; then
    cd "${path}"/../public && ln -s ../frontend/dist assets
fi