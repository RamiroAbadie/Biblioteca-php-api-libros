<?php

$host = "localhost";
$dbname = "[]";
$user = "[]";
$pass = "[]";

try {

    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $user,
        $pass
    );

    echo "Conexión exitosa";

} catch (PDOException $e) {

    echo "Error: " . $e->getMessage();
}