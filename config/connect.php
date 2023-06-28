<?php

$dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=UTF8";

try {
    return new PDO($dsn, DB_USER, DB_PASSWORD);
} catch (PDOException $e) {
    echo $e->getMessage();
}
