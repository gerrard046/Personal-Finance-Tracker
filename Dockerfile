FROM php:8.3-cli

WORKDIR /var/www/html

RUN apt-get update \
    && apt-get install -y git unzip libzip-dev libicu-dev zip curl ca-certificates \
    && docker-php-ext-install pdo pdo_sqlite zip intl \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# Install Node.js 18
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

COPY . .

# Ensure entrypoint exists
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 8000

CMD ["/usr/local/bin/docker-entrypoint.sh"]
