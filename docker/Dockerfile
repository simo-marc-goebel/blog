FROM dunglas/frankenphp:latest

RUN install-php-extensions \
    pdo_mysql \
    xdebug

COPY Caddyfile /etc/frankenphp/Caddyfile
WORKDIR /app