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
$Nama = $_POST['Nama'];
$Username = $_POST['Username'];
$password = $_POST ['password'];


// Menghindari SQL Injection dan hashing password
$Nama = $connection->real_escape_string($Nama);
$Username = $connection->real_escape_string($Username);
$passwordhash = password_hash($connection->real_escape_string($password), PASSWORD_BCRYPT);

// Membuat query untuk menyimpan data ke tabel tb_users
$query = "INSERT INTO tb_user (Nama, Username, Sandi) VALUES ('$Nama', '$Username', '$passwordhash')";

// Menjalankan query
if ($connection->query($query) === TRUE) {
    echo "Pendaftaran berhasil! <a href='login.html'>Login</a>";
} else {
    echo "Error: " . $query . "<br>" . $connection->error;
}

// Menutup koneksi
$connection->close();
?>
