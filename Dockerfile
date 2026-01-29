FROM php:8.4-apache

# 必要なライブラリとNode.jsのインストール
RUN apt-get update && apt-get install -y \
    libpng-dev zlib1g-dev libxml2-dev libzip-dev zip unzip \
    curl \
    && curl -sL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install pdo_mysql gd bcmath zip

# Apacheの設定
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/conf-available/docker-php.conf!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN a2enmod rewrite

# ファイルのコピー
COPY . /var/www/html
WORKDIR /var/www/html

# Composer（PHPライブラリ）のインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# npm（デザイン関連）のビルド
RUN npm install && npm run build

# データベースファイルの土台作成と権限付与
RUN mkdir -p database && touch database/database.sqlite && chmod 777 database/database.sqlite
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

EXPOSE 80

# 起動時に自動で migrate を実行するようにスクリプトを仕込む
EXPOSE 80

# 起動時にマイグレーションを実行してからApacheを起動する設定
CMD php artisan migrate --force && apache2-foreground
