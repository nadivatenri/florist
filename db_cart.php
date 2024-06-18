<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_florist";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari formulir
$OrderID = $_POST['OrderID'];
$NamaBunga = $_POST['NamaBunga'];
$Quantity = $_POST['Quantity'];
$FlowerID = $_POST['FlowerID'];
$Harga = $_POST ['Harga'];
$Username = $_POST ['Username'];
$TotalHarga = $_POST ['$TotalHarga'];

?>
