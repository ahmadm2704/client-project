FROM php:7.4-apache

RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    libmariadb-dev \
    && docker-php-ext-install \
    pdo \
    pdo_mysql \
    && a2enmod rewrite \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY . .

EXPOSE 80

CMD ["apache2-foreground"]
