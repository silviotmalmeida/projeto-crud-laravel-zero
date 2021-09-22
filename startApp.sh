#!/bin/bash

echo "Iniciando o app..."
docker container exec -it crud-laravel-zero php /entrada-saida/application
