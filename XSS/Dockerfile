FROM php:8.1-apache

# Apache mod_rewrite'ı etkinleştir
RUN a2enmod rewrite

# PHP extension'ları yükle
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Apache document root'u ayarla
ENV APACHE_DOCUMENT_ROOT /var/www/html
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Apache'yi başlat
CMD ["apache2-foreground"]
