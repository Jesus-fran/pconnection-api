# Utiliza una imagen oficial de PHP como base
FROM php:8.2-apache

# Configura el directorio de trabajo
WORKDIR /var/www/html

# Copia los certificados al contenedor
COPY docker/certificates/* /etc/ssl/certs/

COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# Instala dependencias de Laravel y otras extensiones
RUN apt-get update && apt-get install -y libzip-dev unzip && docker-php-ext-install pdo pdo_mysql zip && apt-get clean

# Copia los archivos del proyecto al contenedor
COPY . /var/www/html

# Ajusta los permisos 
RUN chown -R www-data:www-data /var/www/html

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Exponer el puerto 80 y 443
EXPOSE 80

# CMD especifica el comando por defecto que se ejecutará al iniciar el contenedor
CMD ["apache2-foreground"]

