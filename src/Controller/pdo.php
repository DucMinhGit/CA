<?php

require_once __DIR__ . '/../../config/database.php';

$dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=UTF8";

function connect():PDO {
    return new PDO(
        sprintf("mysql:host=%s;dbname=%s;charset=UTF8", DB_HOST, DB_NAME),
        DB_USER,
        DB_PASSWORD,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
}