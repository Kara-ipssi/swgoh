# Get php 8.1 official image with apache
FROM php:8.1-apache

# Install dependencies
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

# Install PHP extensions
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions intl pdo_mysql zip

# Install Composer
RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
    mv composer.phar /usr/local/bin/composer

RUN apt update && apt install -yqq nodejs npm

COPY . /var/www

COPY ./apache.conf /etc/apache2/sites-available/000-default.conf

RUN cd /var/www && \
    composer install 

WORKDIR /var/www/

ENTRYPOINT ["bash", "./docker.sh"]

EXPOSE 80