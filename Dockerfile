FROM php:8.3.20-fpm

# Instala extensões e dependências do PHP
RUN apt-get update && apt-get install -y \
    libpq-dev \
    postgresql-client \
    zip unzip curl libzip-dev git gnupg \
    && docker-php-ext-install pdo pdo_pgsql zip

# Instala Node.js (Vite) e npm
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Define o diretório de trabalho
WORKDIR /var/www

# Copia os arquivos da aplicação
COPY . .

# Instala dependências PHP
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Instala e compila os assets com Vite
RUN npm install && npm run build

# Copia o script de entrypoint
COPY scripts/entrypoint /usr/local/bin/entrypoint
RUN chmod +x /usr/local/bin/entrypoint

ENTRYPOINT ["/usr/local/bin/entrypoint"]
CMD ["php-fpm"]
