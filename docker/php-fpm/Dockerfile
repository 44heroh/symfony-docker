FROM php:8.1.0-fpm

# Install packages
RUN apt-get update \
    && apt-get install -y \
        curl \
        wget \
        zlib1g-dev \
        libmcrypt-dev \
        libzip-dev zip \
        libpng-dev \
        libpq-dev \
        iputils-ping

# Xdebug
ARG INSTALL_XDEBUG=false
RUN if [ ${INSTALL_XDEBUG} = true ]; \
    then \
      pecl install xdebug-3.1.6 && docker-php-ext-enable xdebug; \
    fi;

COPY ./docker/php-fpm/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# Postgres
RUN docker-php-ext-install pdo pdo_pgsql
#RUN apk add --no-cache imagick && docker-php-ext-install imagick
#RUN apk add --no-cache libpq-dev && docker-php-ext-configure gd
#RUN apk add --no-cache libpq-dev && docker-php-ext-install gd
#RUN apk add --no-cache libpq-dev && docker-php-ext-configure zip
#RUN apk add --no-cache libpq-dev && docker-php-ext-install zip
# Configure non-root user.
ARG PUID=1000
ARG PGID=1000
RUN groupmod -o -g ${PGID} www-data && \
    usermod -o -u ${PUID} -g www-data www-data

# Source code
RUN chown www-data:www-data /var/www
COPY --chown=www-data:www-data ./ /var/www
WORKDIR /var/www

USER root

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-interaction

CMD php-fpm

EXPOSE 9000
