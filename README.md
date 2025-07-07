# CoachMarket

## 環境構築

Dockerビルド

・https://github.com/nogu516/CoachMarket.git

・docker-compose up -d --build

Laravel環境構築

・docker-compose exec php bash

・composer install

・.env.exampleファイルから.envを作成し、環境変数を変更

・php artisan key:generate

・php artisan migrate

・php artisan db:seed

開発環境

・お問い合わせ画面： http://localhost

・ユーザー登録　　： http://localhost/register

・phpMyAdmin     : http://localhost:8080

## 使用技術

・PHP    :8.2.28
・Laravel:11.0
・MySQL  :8.0.26
・nginx  :1.21.1
・query

## ER図

・新模擬案件1のテーブル仕様書

・VScode内のsrc/docs内参照

