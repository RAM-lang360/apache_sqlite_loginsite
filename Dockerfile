# ベースイメージとしてphp:8.0-apacheを使用
FROM php:8.0-apache

# 必要なPHP拡張機能をインストール
RUN docker-php-ext-install mysqli pdo pdo_mysql

# SQLite3 をインストール
RUN apt-get update && apt-get install -y sqlite3

# Apacheのmod_rewriteを有効化
RUN a2enmod rewrite

# Apacheの設定ファイルをコピー
COPY apache-config/000-default.conf /etc/apache2/sites-available/000-default.conf

# ソースコードをドキュメントルートにコピー
COPY src/ /var/www/html/

# 権限設定（オプション）
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# ポート80を公開
EXPOSE 80

# Apacheをフォアグラウンドで起動
CMD ["apache2-foreground"]
