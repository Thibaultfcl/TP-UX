<?php
$pdo = new PDO('mysql:host=localhost;dbname=product_catalog', 'root', '');
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 20;
$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;

$stmt = $pdo->prepare("SELECT * FROM products LIMIT :limit OFFSET :offset");
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();

header('Content-Type: application/json');
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
?>