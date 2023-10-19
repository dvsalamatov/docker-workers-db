FROM php:8.0-fpm as php_base

RUN set -xe \
    && apt-get update \
    && apt-get install -y \
        locales \
        curl \
        mariadb-client \
        libzip-dev \
        zip \
        unzip \
    --no-install-recommends \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        mysqli \
        bcmath \
        zip \
        sockets

COPY docker/php/php.ini /usr/local/etc/php/php.ini

COPY --from=composer /usr/bin/composer /usr/local/bin/composer

FROM php_base as php_worker

RUN set -xe \
    && apt-get update \
    && apt-get install -y \
    supervisor

COPY docker/worker/supervisord.conf /etc/supervisor/conf.d/

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf", "-n"]
