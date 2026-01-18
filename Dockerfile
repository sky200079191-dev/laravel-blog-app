FROM richarvey/php-apache-heroku:1.10.3
COPY . /var/www/html
ENV WEBROOT /var/www/html/public
RUN composer install --no-dev --optimize-autoloader