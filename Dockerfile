FROM php:8.4-apache

# 1. 必要なライブラリとNode.js（npm）のインストール
RUN apt-get update && apt-get install -y \
    libpng-dev zlib1g-dev libxml2-dev libzip-dev zip unzip \
    curl \
    && curl -sL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install pdo_mysql gd bcmath zip

# 2. Apacheの設定
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/conf-available/docker-php.conf!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN a2enmod rewrite

# 3. ファイルのコピー
COPY . /var/www/html
WORKDIR /var/www/html

# 4. PHPライブラリのインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# 5. デザインファイルのビルド（ここが重要！）
RUN npm install
RUN npm run build

# 6. データベースの準備と権限設定
RUN touch database/database.sqlite && chmod 777 database/database.sqlite
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80
