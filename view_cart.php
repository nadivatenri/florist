<?php
session_start();
include 'cart.php';
include 'db_cart.php';

// Daftar produk 
$products = [
    1 => ["name" => "Aurora", "price" => 500000],
    2 => ["name" => "Elsa", "price" => 450000],
    3 => ["name" => "Belle", "price" => 450000],
    4 => ["name" => "Snow White", "price" => 600000],
    5 => ["name" => "Ariel", "price" => 300000],
    6 => ["name" => "Pocahontas", "price" => 550000],
    7 => ["name" => "Rapunzel", "price" => 400000],
    8 => ["name" => "Merida", "price" => 500000],
];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
    <?php displayCart(); ?>
    <a href="index.php">Kembali ke Daftar Produk</a>
    <br><br>
    <a href="cart.php?action=checkout">Checkout</a>
</body>
</html>
