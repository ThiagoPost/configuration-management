FROM php:8.3.20-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    postgresql-client \
    zip unzip curl libzip-dev git gnupg \
    && docker-php-ext-install pdo pdo_pgsql zip

RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www

COPY ../../ ./

RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

COPY ../../scripts/entrypoint /usr/local/bin/entrypoint
RUN chmod +x /usr/local/bin/entrypoint

ENTRYPOINT ["/usr/local/bin/entrypoint"]
CMD ["php-fpm"]
