
<?php
$host = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'db_florist';

// Membuat koneksi ke database
$connection = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// Periksa koneksi
if ($connection->connect_error) {
  die("Koneksi gagal: " . $connection->connect_error);
}

// Mendapatkan data dari formulir
$username = $_POST['username'];
$password = $_POST['password'];

// Menghindari SQL Injection
$username = $connection->real_escape_string($username);
$password = $connection->real_escape_string($password);

// Membuat query untuk menyimpan data ke tabel users
$query = "INSERT INTO tb_login (Username, Sandi) VALUES ('$username', '$password')";

// Menjalankan query
if ($connection->query($query) === TRUE) {
  echo "Login Berhasil!";
} else {
  echo "Error: " . $query . "<br>" . $connection->error;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<li class="nav-item">
            <a class="nav-link" href="shop.html">
              silahkan lanjut berbelanja
            </a>
</head>
</html>