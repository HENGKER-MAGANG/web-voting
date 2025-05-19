# Gunakan image PHP dengan Apache dan ekstensi MySQL
FROM php:8.1-apache

# Install ekstensi mysqli
RUN docker-php-ext-install mysqli

# Salin source code ke dalam container
COPY ./public /var/www/html/
COPY ./includes /var/www/html/includes/
COPY ./calon_foto /var/www/html/calon_foto/

# Set permissions
RUN chown -R www-data:www-data /var/www/html

# Aktifkan rewrite module jika diperlukan
RUN a2enmod rewrite

# Salin file konfigurasi Apache (optional)
# COPY ./000-default.conf /etc/apache2/sites-available/000-default.conf

# Set working directory
WORKDIR /var/www/html
