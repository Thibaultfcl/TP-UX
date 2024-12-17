<?php
require 'vendor/autoload.php';

$faker = Faker\Factory::create();
$pdo = new PDO('mysql:host=localhost;dbname=product_catalog', 'root', '');

$stmt = $pdo->query("SELECT COUNT(*) FROM products");
$rowCount = $stmt->fetchColumn();

if ($rowCount == 0) {
    for ($i = 0; $i < 1000; $i++) {
        $stmt = $pdo->prepare("INSERT INTO products (name, description, price, image_url) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $faker->word(),
            $faker->sentence(),
            $faker->randomFloat(2, 5, 200),
            $faker->imageUrl(640, 480, 'product', true)
        ]);
    }
    echo "Données insérées avec succès.";
}
?>