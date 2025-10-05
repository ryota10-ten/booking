# booking
# 概要
    飲食店の予約アプリでユーザーは飲食店の予約やお気に入り登録ができる。
    また、予約日の当日にサイトからリマインドメールが送られる。
    店舗代表者は、自分のお店の情報を登録・更新ができる。また、予約情報の更新もできる。
    サイト管理者は店舗代表者の登録やユーザー全員に対してお知らせメールを送ることができる。

# 主な機能
    ユーザーの登録
    ユーザーのメール認証
    ユーザーのログイン.ログアウト
    ユーザー飲食店の予約、お気に入り登録
    ユーザーのレビュー投稿
    ユーザーの予約情報の変更
    店舗代表者の登録、ログイン。ログアウト
    店舗情報の追加、編集
    サイト管理者のログイン、ログアウト
    サイト管理者のメール送信機能

# 使用技術
    Laravel Framework 8.83.29
    PHP 8.1.33 (cli) 
    mysql from 11.8.2-MariaDB, client 15.2 for debian-linux-gnu (x86_64) using  EditLine wrapper
    nginx version: nginx/1.21.1

# 開発環境
    ユーザーの会員登録ページ:http://localhost/register
    ユーザーのログインページ；http://localhost/login
    管理者のログインページ；http://localhost/admin/login
    店舗代表者のログインページ：http://localhost/manager/login
    店舗代表者の登録ページ：http://localhost/manager/register
    phpmyadmin:http://localhost:8080/index.php

## セットアップ
# 1.リポジトリをクローン ディレクトリ以下に、booking.gitをクローンしてリポジトリ名をbookingTestに変更。
    git clone git@github.com:ryota10-ten/booking.git
    mv booking bookingTest 
    cd bookingTest

# 2.Docker の設定 
    docker compose up -d --build code .
    bookingコンテナが作成されていれば成功です。

# 3.Laravel のパッケージのインストール 
    docker compose exec php bash composer install
# 4..env ファイルの作成 
    cp .env.example .env 
    .env.example をコピーして .env を作成。
    .env ファイルを以下に修正 
    DB_CONNECTION=mysql 
    DB_HOST=mysql 
    DB_PORT=3306 
    DB_DATABASE=laravel_db 
    DB_USERNAME=laravel_user 
    DB_PASSWORD=laravel_pass

## ※メール送信の設定（Mailtrap） 
    (1)Mailtrap のアカウント作成 Mailtrap の公式サイト（https://mailtrap.io/）にアクセスし、無料アカウントを作成してください。
    (2)Mailtrap の SMTP 設定を取得 Mailtrap にログイン後、Inbox を作成 Start Testing を開く
    Laravel 7+ and 8.Xの設定を選択 .env に以下の情報を設定
        MAIL_MAILER=smtp MAIL_HOST=smtp.mailtrap.io MAIL_PORT=2525 MAIL_USERNAME=your_mailtrap_username MAIL_PASSWORD=your_mailtrap_password MAIL_ENCRYPTION=null MAIL_FROM_ADDRESS=no-reply@example.com
    MAIL_USERNAME と MAIL_PASSWORD には Mailtrap のダッシュボードで確認できる値を入力してください。

## ※予約処理にStripe を使用しています。
    (1) Stripe アカウント作成
    Stripe の公式サイト（https://stripe.com）にアクセスして、アカウントを作成してください。
    テスト用の API キー（公開可能キーと秘密キー）を取得します。 
    (2) Laravel の設定
    STRIPE_KEY=pk_test_xxxxxxxxxxxxxxxxxxxxx
    STRIPE_SECRET=sk_test_xxxxxxxxxxxxxxxxxxxxx
    STRIPE_WEBHOOK_SECRET=xxxxxxxxxxxxxxxxxxxxx
        STRIPE_KEY には 公開可能キー（Publishable Key）
        STRIPE_SECRET には 秘密キー（Secret Key） を設定してください。
    (3) Stripe のテストモードでの動作確認
    テストカード番号（例: 4242 4242 4242 4242）を使用して、決済が正常に動作するか確認できます。
    詳細は Stripe の公式ドキュメント（https://stripe.com/docs/testing）を参照してください。

# 5.アプリキーの生成 以下のコマンドを実行して、アプリケーションの暗号化キーを生成してください。 
    php artisan key:generate
# 6.マイグレーションとシーディングの実装 
    php artisan migrate 
    php artisan db:seed
# 7.サーバーを起動
    php artisan serve ブラウザで http://localhost/register にアクセスするとアプリを確認できます。

# 8.機能テストの確認 
    MySQLコンテナからMySQLに、rootユーザでログインして、testというデータベースを作成 
    docker compose exec mysql bash 
    mysql -u root -p 
    docker-compose.ymlファイルのMYSQL_ROOT_PASSWORD:に設定されているパスワードを記述

    データベースの作成 
        CREATE DATABASE test;
    phpコンテナにログイン 
        docker compose exec mysql bash
    テスト用の.envファイル作成 
        cp .env .env.testing
    .env.testingファイルを以下に修正
        APP_ENV=test 
        APP_KEY= 
        APP_DEBUG=true 
        APP_URL=http://localhost
        DB_DATABASE=test 
        DB_USERNAME=root 
        DB_PASSWORD=root
    テスト用のアプリケーションの暗号キーを作成
        php artisan key:generate --env=testing
    テスト用のテーブルを作成
        php artisan migrate --env=testing
    テストの実行
        vendor/bin/phpunit tests/Feature/
#ER図
<img width="686" height="511" alt="スクリーンショット 2025-08-31 15 17 49" src="https://github.com/user-attachments/assets/55b71d0c-b8c6-47a9-a197-fdf816a74530" />

    

