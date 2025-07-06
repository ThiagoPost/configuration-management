#!/bin/bash

echo "Iniciando deploy de produção..."

docker compose up -d --build

echo "Deploy de produção finalizado com sucesso."
