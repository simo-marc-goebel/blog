FROM dunglas/frankenphp:latest

RUN install-php-extensions \
    pdo_mysql \
    mysqli \
    xdebug

COPY Caddyfile /etc/frankenphp/Caddyfile