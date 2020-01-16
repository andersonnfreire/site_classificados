<?php

session_start();

try {
    $pdo = new PDO("mysql:dbname=classificados;host=localhost", "root", "");
    return $pdo;
} catch (PDOException $ex) {
    echo "Falhou: ".$ex->getMessage();
    exit;
}
?>



