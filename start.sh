#!/usr/bin/env bash

red=$'\e[1;31m'
grn=$'\e[1;32m'
blu=$'\e[1;34m'
mag=$'\e[1;35m'
cyn=$'\e[1;36m'
white=$'\e[0m'


echo " $red **** Installing Pre requisites **** $white "
sudo docker-compose down && docker-compose up --build -d

echo " $grn **** Installing Dependencies **** $blu " 
docker-compose run php composer install  --ignore-platform-reqs --no-interaction

echo " $red **** Running Migrations **** $white "
docker exec php php bin/console doctrine:migrations:migrate

echo " $red **** Importing Shipments **** $white "
docker exec php php bin/console app:import:shipments

echo " $mag **** Running unit test case **** $cyn "
docker exec php php bin/phpunit


exit 0