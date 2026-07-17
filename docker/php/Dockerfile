FROM php:8.2-fpm-alpine

# Instala extensões necessárias para o projeto (PDO MySQL e cURL)
RUN apk add --no-cache \
    libcurl \
    curl-dev \
    libxml2-dev \
    oniguruma-dev \
    $PHPIZE_DEPS \
    && docker-php-ext-install pdo_mysql curl

# Copia e instala o Composer diretamente da imagem oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

EXPOSE 9000
CMD ["php-fpm"]