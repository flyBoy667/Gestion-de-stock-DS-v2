<?php
$host = 'localhost';
$dbname = 'stock_v3';
$username = 'fly';
$password = 'root';

try {
    $connect = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
    die();
}

