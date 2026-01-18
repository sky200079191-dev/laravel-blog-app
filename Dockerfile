FROM richarvey/php-apache-heroku:latest
COPY . /var/www/html
ENV WEBROOT /var/www/html/public
ENV APP_KEY base64:dLio5Vy1a2mCAdod7jCNX7T/DtWBB2oFv2KCbUsL01U=
RUN composer install --no-dev --optimize-autoloader