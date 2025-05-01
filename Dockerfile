FROM php:8.2-apache

# Instala dependências básicas do Laravel e do PostgreSQL
RUN apt-get update && apt-get install -y \
    git unzip curl libpng-dev libonig-dev libxml2-dev zip npm nodejs libpq-dev \
    && docker-php-ext-install bcmath pdo pdo_pgsql

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copia os arquivos do projeto
COPY . /var/www/html

# Define o diretório de trabalho
WORKDIR /var/www/html

# Instala dependências do Laravel e compila o frontend
RUN composer install --no-interaction --prefer-dist --optimize-autoloader \
    && npm install \
    && npm run build

# Permissões para diretórios de cache
RUN chmod -R 777 storage bootstrap/cache

EXPOSE 80

# Remove .env, limpa config cache, aplica migrations e inicia servidor
CMD rm -f .env && php artisan config:clear && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=80
