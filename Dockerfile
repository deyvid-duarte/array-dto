FROM php:8.3

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git

# Install PHP extensions
RUN docker-php-ext-install mbstring exif bcmath

# Install Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy application files
COPY . .

# Keep the container running
CMD ["tail", "-f", "/dev/null"]