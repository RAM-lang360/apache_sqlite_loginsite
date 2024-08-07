# ベースイメージとしてphp:8.0-apacheを使用
FROM php:8.0-apache

# 必要な拡張機能をインストール
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Apacheの設定ファイルをコンテナにコピー
COPY apache-config/000-default.conf /etc/apache2/sites-available/000-default.conf

# ソースコードをApacheのドキュメントルートにコピー
COPY src/ /var/www/html/

# Apacheの設定を適用
RUN a2enmod rewrite

# ポート80を公開
EXPOSE 80

# Apacheをフォアグラウンドで起動
CMD ["apache2-foreground"]