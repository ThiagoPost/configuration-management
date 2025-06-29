FROM php:8.3.20-fpm

# Instala extensões e dependências
RUN apt-get update && apt-get install -y \
    libpq-dev \
    postgresql-client \ 
    zip unzip curl libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Define diretório de trabalho
WORKDIR /var/www

COPY . .

RUN composer install

# Copia o script de entrypoint e dá permissão
COPY scripts/entrypoint /usr/local/bin/entrypoint
RUN chmod +x /usr/local/bin/entrypoint

ENTRYPOINT ["/usr/local/bin/entrypoint"]
CMD ["php-fpm"]
