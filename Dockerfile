# Stage 1: Build vendor dependencies
FROM composer:2.7 as vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --ignore-platform-reqs --optimize-autoloader --no-scripts
COPY . .
# Stage 2: Build frontend assets
FROM node:20 as frontend
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
COPY --from=vendor /app/vendor ./vendor
RUN cp .env.production .env || true
RUN npm run build
# Stage 3: Final Production Image
FROM php:8.2-fpm-alpine
WORKDIR /var/www/html

# Install system dependencies & PHP extensions
RUN apk add --no-cache \
    zip \
    libzip-dev \
    freetype \
    libjpeg-turbo \
    libpng \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    icu-dev \
    mariadb-client \
    oniguruma-dev \
    tzdata \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    intl \
    zip \
    opcache \
    && apk del freetype-dev libjpeg-turbo-dev libpng-dev

# Setup PHP Configuration for Production
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Copy files from previous stages
COPY --chown=www-data:www-data . .
COPY --from=vendor --chown=www-data:www-data /app/vendor ./vendor
COPY --from=frontend --chown=www-data:www-data /app/public/build ./public/build

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
