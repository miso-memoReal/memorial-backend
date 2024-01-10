ARG PHP_VERSION=8.3.1
ARG COMPOSER_VERSION=2.6.6

FROM composer:${COMPOSER_VERSION} as composer

FROM php:${PHP_VERSION}-fpm-alpine as app-base

RUN apk add --no-cache tzdata
ENV TZ=Asia/Tokyo \
    LANG=en_US.UTF-8 \
    LANGUAGE=en_US:en \
    LC_ALL=en_US.UTF-8

RUN apk add --no-cache curl libcurl nghttp2-libs && \
    apk add --no-cache --virtual .build-deps ${PHPIZE_DEPS} && \
    apk add --no-cache oniguruma-dev libpq-dev shadow php82-zip libzip-dev libpng-dev php82-simplexml libxml2-dev && \
    pecl install redis && \
    pecl install protobuf && \
    curl -sSL https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions -o - | sh -s open-telemetry/opentelemetry-php-instrumentation@1.0.0beta6 && \
    docker-php-ext-configure opcache --enable-opcache && \
    docker-php-ext-install opcache bcmath pdo_pgsql zip gd simplexml && \
    docker-php-ext-enable redis protobuf && \
    apk del .build-deps && \
    rm -rf /tmp/*

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN apk add --no-cache --virtual .build-deps linux-headers autoconf gcc g++ make && \
    pecl install xdebug && \
    docker-php-ext-enable xdebug && \
    apk del .build-deps

RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini
ADD ./infra/php/settings/php.ini /usr/local/etc/php/php.ini
ADD ./infra/php/settings/zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf

# parameterize php-fpm conf
ENV PHP_FPM_PM_MAX_CHILDREN=5
ENV PHP_FPM_PM_START_SERVERS=2
ENV PHP_FPM_PM_MIN_SPARE_SERVERS=1
ENV PHP_FPM_PM_MAX_SPARE_SERVERS=3
ENV PHP_FPM_PM_MAX_REQUESTS=500

COPY --from=composer /usr/bin/composer /usr/bin/composer

# Laravel Sail
ARG WWWGROUP
ARG WWWUSER
RUN groupadd --force -g $WWWGROUP sail
RUN useradd --no-user-group -m -g $WWWGROUP -u $WWWUSER sail
RUN sed -i "s/www-data/$WWWGROUP/g" /usr/local/etc/php-fpm.d/zz-docker.conf

RUN mkdir -p /var/run/php-fpm/ && chown sail:$WWWGROUP /var/run/php-fpm/

USER sail

WORKDIR /var/www/html/

# for development
FROM app-base as app-local

# install xdebug
USER root
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN apk add --update linux-headers && \
    apk add --no-cache --virtual .build-deps ${PHPIZE_DEPS} && \
    pecl install xdebug-3.2.1 && \
    docker-php-ext-enable xdebug && \
    apk del .build-deps
USER sail

ARG WWWGROUP
ADD --chown=sail:$WWWGROUP ./infra/php/settings/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
# ini for dev
ADD --chown=sail:$WWWGROUP ./infra/php/settings/php-dev.ini /usr/local/etc/php/php.ini

COPY ./infra/php/settings/docker-php-entrypoint /usr/local/bin/docker-php-entrypoint
ENTRYPOINT ["docker-php-entrypoint"]
CMD ["php-fpm"]

# for deployment
FROM app-base as app-deploy
ARG WWWGROUP

ADD --chown=sail:$WWWGROUP ./composer.json ./composer.json
ADD --chown=sail:$WWWGROUP ./composer.lock ./composer.lock
RUN composer install -n --no-ansi --no-scripts --no-autoloader --no-progress --prefer-dist
ADD --chown=sail:$WWWGROUP ./ ./
# runs post-dump-autoload script
RUN composer dump-autoload && \
    chmod -R 777 storage bootstrap/cache && \
    php artisan clear-compiled && \
    php artisan config:clear && \
    php artisan route:clear && \
    php artisan view:clear

COPY ./infra/php/settings/docker-php-entrypoint-prod /usr/local/bin/docker-php-entrypoint
ENTRYPOINT ["docker-php-entrypoint"]
CMD ["php-fpm"]
