# 1. Imagen base: PHP 8.2 con servidor web Apache
FROM php:8.2-apache

# 2. Instalar extensiones para conectar con MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# 3. Copiar el código fuente a la raíz de Apache
COPY src/ /var/www/html/

# 4. Exponer el puerto HTTP
EXPOSE 80

