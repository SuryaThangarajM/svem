# Step 1: Use official PHP 8.2 image with FPM (FastCGI Process Manager)
FROM php:8.2-fpm

# Step 2: Install system dependencies and PHP extensions required for Laravel
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev \
    libzip-dev libpq-dev

# Install PHP extensions required for Laravel
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Step 3: Install Composer globally
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Step 4: Set the working directory inside the container
WORKDIR /var/www

# Step 5: Copy the Laravel project files to the container
COPY . .

# Step 6: Install the Laravel project dependencies using Composer
RUN composer install --no-dev --optimize-autoloader

# Step 7: Set permissions to avoid any permission issues
RUN chown -R www-data:www-data /var/www

# Step 8: Expose port 8080 to make it accessible
EXPOSE 8080

# Step 9: Run the Laravel development server
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8080

