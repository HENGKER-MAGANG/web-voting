FROM php:8.1-apache

# Install ekstensi mysqli
RUN docker-php-ext-install mysqli

# Salin semua file ke container
COPY . /var/www/html/

# Set permission folder upload (jika perlu)
RUN chown -R www-data:www-data /var/www/html/calon_foto

# Aktifkan mod_rewrite (opsional jika perlu routing .htaccess)
RUN a2enmod rewrite

# Konfigurasi Apache agar mendukung .htaccess
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf
