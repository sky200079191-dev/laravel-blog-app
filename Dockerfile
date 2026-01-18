# 1. PHPとApacheがセットになった標準イメージを使用
FROM php:8.2-apache

# 2. Laravelに必要な拡張機能をインストール
RUN apt-get update && apt-get install -y \
    libpng-dev zlib1g-dev libxml2-dev libzip-dev zip unzip \
    && docker-php-ext-install pdo_mysql gd bcmath zip

# 3. Apacheの設定（公開ディレクトリをpublicに変更）
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/conf-available/docker-php.conf!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN a2enmod rewrite

# 4. プロジェクトファイルをコピー
COPY . /var/www/html

# 5. Composerのインストールと実行
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# 6. 権限の設定
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 7. ポート設定
EXPOSE 80