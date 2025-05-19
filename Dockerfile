# Gunakan image PHP dengan Apache
FROM php:8.1-apache

# Install ekstensi mysqli
RUN docker-php-ext-install mysqli

# Salin semua file ke dalam direktori web server
COPY . /var/www/html/

# Aktifkan mod_rewrite (jika kamu akan pakai .htaccess)
RUN a2enmod rewrite

# Atur hak akses file
RUN chown -R www-data:www-data /var/www/html

# Atur direktori kerja
WORKDIR /var/www/html
