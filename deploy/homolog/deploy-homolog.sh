#!/bin/bash

echo "Iniciando deploy de homologação..."

docker-compose up -d --build

echo "Deploy finalizado com sucesso."
