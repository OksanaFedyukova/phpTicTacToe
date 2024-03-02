# Usa la imagen oficial de PHP con Apache
FROM php:7.4-apache

# Copia los archivos de tu aplicación al directorio del servidor web en el contenedor
COPY . /var/www/html

# Expone el puerto 80 para el tráfico web
EXPOSE 80
