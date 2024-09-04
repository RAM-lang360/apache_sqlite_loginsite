# ベースイメージとしてphp:8.0-apacheを使用
FROM php:8.0-apache

# 必要な拡張機能をインストール
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Apacheの設定ファイルをコンテナにコピー
COPY apache-config/000-default.conf /etc/apache2/sites-available/000-default.conf

# ソースコードをApacheのドキュメントルートにコピー
COPY src/ /var/www/html/
#SQLite3機能の追加
RUN apt-get update && apt-get install -y sqlite3

# Apacheの設定を適用
RUN a2enmod rewrite
# 権限の付与
RUN groupadd -r webadmin && usermod -aG webadmin www-data;

RUN useradd -m -G webadmin your username

RUN chown -R your username:webadmin front_end && chown -R your username:webadmin back_end
# ポート80を公開
EXPOSE 80

# Apacheをフォアグラウンドで起動
CMD ["apache2-foreground","apt update","apt install sqlite3"]

#docker container run -d -p 80:80 --name apache_sql -v 絶対パス/src/:/var/www/html/ apache_sql:latest