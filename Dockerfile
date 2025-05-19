FROM php:8.1-apache

# Install mysqli extension
RUN docker-php-ext-install mysqli

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Configure Apache to allow .htaccess
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Copy all project files
COPY . /var/www/html/

# Ensure calon_foto folder exists and is writable
RUN mkdir -p /var/www/html/calon_foto && \
    chown -R www-data:www-data /var/www/html/calon_foto && \
    chmod -R 755 /var/www/html/calon_foto
