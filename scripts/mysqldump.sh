#!/bin/bash

docker exec money_mysql mysqldump -u root money > ../docker/mysql/init.sql