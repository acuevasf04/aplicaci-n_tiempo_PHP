FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql

# 1. Creamos la carpeta PHP dentro del contenedor
RUN mkdir -p /var/www/html/PHP

# 2. Copiamos el contenido a esa carpeta específica
COPY PHP/configuracion.php /var/www/html/PHP/

COPY PHP/Inyeccion.php /var/www/html/PHP/

COPY PHP/tiempo_diario.php /var/www/html/PHP/

COPY PHP/tiempo_horas.php /var/www/html/PHP/

# 3. Copiamos el index.php a la raíz
COPY index.php /var/www/html/

COPY logo_tiempo.png /var/www/html/

# Configurar Apache
RUN echo '<Directory /var/www/html>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
    DirectoryIndex index.php index.html\n\
</Directory>' > /etc/apache2/conf-available/custom.conf \
    && a2enconf custom

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

EXPOSE 80