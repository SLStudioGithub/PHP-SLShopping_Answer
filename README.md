# ローカル環境構築

## DB作成
・以下sqlを実行して接続先のDBを作成
```sql
CREATE DATABASE `sl_shopping_db`
	DEFAULT CHARSET utf8mb4
	DEFAULT COLLATE utf8mb4_bin
;

USE `sl_shopping_db`;
```

## 開発環境構築手順
1. リポジトリを`c:/xampp/htdocs`直下にclone

2. 以下コマンドでライブラリをインストール
```bash
composer install
```

3. 以下コマンドで`.env`を作成
```bash
cp .env.example .env
```

4. 以下コマンドでアプリケーションキー生成
```bash
php artisan key:generate
```

5. 以下コマンドでテーブルとデータを作成
```bash
php artisan migrate
php artisan db:seed
```

6. シンボリックリンク作成
```bash
php artisan storage:link
```

7. 画面表示
   - 画面URL
     	- [shop画面](http://localhost/PHP-DemoProject/public/shop/top)
         	- Email: `test1@co.jp`, password: `password1`
     	- [管理画面](http://localhost/PHP-DemoProject/public/admin/dashboard)
			- ID: `admin`, password: `admin`

8. 画像の縦横比
	- 画像の縦横比は1:1で統一する。（例:250px * 250px）

## DBデータリセット方法
・以下コマンドでDBデータをリセット
```bash
php artisan migrate:refresh --seed
```