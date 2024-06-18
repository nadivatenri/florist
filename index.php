<?php
session_start();

// Daftar produk contoh
$products = [
    2006 => ["name" => "Aurora", "price" => 500000],
    2007 => ["name" => "Elsa", "price" => 450000],
    2008 => ["name" => "Belle", "price" => 450000],
    2009 => ["name" => "Snow White", "price" => 600000],
    2010 => ["name" => "Ariel", "price" => 300000],
    2011 => ["name" => "Pocahontas", "price" => 550000],
    2012 => ["name" => "Rapunzel", "price" => 400000],
    2013 => ["name" => "Merida", "price" => 500000],
];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>NARA Florist</title>
</head>
<body>
    <h1>Daftar Produk</h1>
    <ul>
        <?php foreach ($products as $id => $product) : ?>
            <li>
                <?= $product['name'] ?> - Rp. <?= number_format($product['price']) ?>
                <a href="cart.php?id=<?= $id ?>">Tambah ke Keranjang</a>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="view_cart.php">Lihat Keranjang</a>
</body>
</html>

