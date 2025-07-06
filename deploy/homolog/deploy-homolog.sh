#!/bin/bash

echo "Iniciando deploy de homologação..."

# Atualiza o repositório
git pull origin master

docker compose up -d --build

echo "Deploy finalizado com sucesso."
