<?php
define('API_KEY', 'a8bc5e845a4f2736bcf3d0f70ec31e4c');
define('DB_HOST', getenv('DB_HOST') ?: 'db');
define('DB_NAME', getenv('DB_NAME') ?: 'tiempo_app');
define('DB_USER', getenv('DB_USER') ?: 'antoniodb');
define('DB_PASS', getenv('DB_PASS') ?: '123456789');

function getDB() {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("CREATE TABLE IF NOT EXISTS CONSULTA (
        ID INT AUTO_INCREMENT PRIMARY KEY,
        CIUDAD VARCHAR(40),
        PAIS VARCHAR(40),
        FECHA DATETIME DEFAULT NOW()
    )");
    return $pdo;
}