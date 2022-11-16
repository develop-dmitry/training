#!/bin/bash

path=$( cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )

docker exec money_mysql mysqldump -u root money > "$path"/../docker/mysql/init.sql