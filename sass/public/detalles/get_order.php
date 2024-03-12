<?php

$dsn = 'mysql:host=localhost;dbname=qcep';
$username = 'usr_generic';
$password = '2024@Thos';

try {
    $pdo = new PDO($dsn, $username, $password);


    $stmt = $pdo->query("SELECT * FROM orden ORDER BY codigo");
    $orderData = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo json_encode($orderData);
} catch (PDOException $e) {
    echo "ERROR：" . $e->getMessage();
}
