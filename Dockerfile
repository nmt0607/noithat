FROM composer
WORKDIR '/app'
COPY . .
RUN composer install --ignore-platform-reqs

#############################
FROM php:7.4-fpm
#CP resource PHP
COPY --from=0 --chown=1000 /app/php/local.ini /usr/local/etc/php/conf.d/local.ini
COPY --from=0 --chown=1000 /app /var/www
# Arguments defined in docker-compose.yml
ENV user=www
ENV uid=1000

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libjpeg-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libgd-dev \
    jpegoptim optipng pngquant gifsicle \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    npm \
    unzip

# Clear cache !
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user
RUN chown -R www:www-data /var/www/storage

RUN chmod -R ug+w /var/www/storage
# Set working directory
WORKDIR /var/www

USER $user