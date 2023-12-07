FROM php:8.2-apache

ENV APACHE_DOCUMENT_ROOT /var/www/html
WORKDIR /var/www/html

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

COPY . /var/www/html

RUN chmod -R 777 /var/www/html

EXPOSE 80

RUN docker-php-ext-install pdo pdo_mysql

# ENTRYPOINT ["top", "-b"]