<?php
// データベース接続情報
define("DB_HOST", "localhost");
define("DB_NAME", "bbs");
define("DSN", "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME);
define("DB_USERNAME", "root");
define("DB_PASSWORD", "");
define("IMAGE_DIR", "upload/");
define("OPTIONS", array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,        // 失敗したら例外を投げる
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_CLASS,   //デフォルトのフェッチモードはクラス
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',   //MySQL サーバーへの接続時に実行するコマンド
       ));
?>