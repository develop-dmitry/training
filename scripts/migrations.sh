#!/bin/bash

docker exec money_web /var/www/html/vendor/bin/doctrine-migrations "$@"