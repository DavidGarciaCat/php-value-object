FROM php:7.4-fpm

# Update OS repositories
RUN apt-get update

# Install OS dependencies
RUN apt-get install -y zip unzip zlib1g-dev libzip-dev
RUN docker-php-ext-install zip

# Install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN php -r "unlink('composer-setup.php');"

# Check software versions
RUN php --version
RUN composer --version
