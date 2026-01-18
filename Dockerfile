# 1. 安定したPHP環境を使用
FROM php:8.2-fpm

# 2. 必要なライブラリをインストール
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip nginx

# 3. PHPの拡張機能をインストール
RUN docker-php-ext-install pdo_mysql mbstring

# 4. Composer（PHPのパッケージ管理ツール）をインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. 作業ディレクトリを設定
WORKDIR /var/www

# 6. まずファイルをコピー
COPY . .

# 7. ここが重要：コンテナの中で composer install を実行する
# これにより vendor フォルダがコンテナ内で生成されます
RUN composer install --no-dev --optimize-autoloader

# 8. 権限設定
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# 9. ポート設定
EXPOSE 80

# 10. 実行コマンド
CMD php artisan serve --host=0.0.0.0 --port=$PORT