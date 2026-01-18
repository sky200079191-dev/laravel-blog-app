FROM php:8.2-fpm

# 必要なシステムのインストール
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nginx

# PHP拡張機能のインストール
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Composerのインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# プロジェクトファイルのコピー
WORKDIR /var/www
COPY . .

# ライブラリのインストール
RUN composer install --no-dev --optimize-autoloader

# 権限の設定
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# ポートの公開
EXPOSE 80

# 起動コマンド（Renderのポートに合わせてNginxとPHPを起動）
CMD php artisan serve --host=0.0.0.0 --port=$PORT