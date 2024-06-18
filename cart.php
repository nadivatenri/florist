<?php
session_start();
include 'db_cart.php';

// Daftar produk
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

// Initialize the cart if not already done
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Fungsi untuk menambahkan produk ke keranjang
function addToCart($FlowerID) {
    if (!isset($_SESSION['cart'][$FlowerID])) {
        $_SESSION['cart'][$FlowerID] = 0;
    }
    $_SESSION['cart'][$FlowerID]++;
}

// Fungsi untuk menghapus produk dari keranjang
function removeFromCart($FlowerID) {
    if (isset($_SESSION['cart'][$FlowerID])) {
        unset($_SESSION['cart'][$FlowerID]);
    }
}

// Fungsi untuk menampilkan isi keranjang
function displayCart() {
    global $products;

    echo "<h1>Keranjang Belanja</h1><ul>";
    foreach ($_SESSION['cart'] as $id => $Quantity) {
        echo "<li>" . $products[$id]['name'] . " - Jumlah: " . $Quantity . " <a href='cart.php?action=remove&id=$id'>Hapus</a></li>";
    }
    echo "</ul><p>Total Produk: " . array_sum($_SESSION['cart']) . "</p>";
}

// Fungsi untuk checkout dan menyimpan ke database
function checkout() {
    global $conn, $products;

    if (empty($_SESSION['cart'])) {
        echo "Keranjang belanja kosong!";
        return;
    }

    $conn->begin_transaction();

    try {
        $conn->query("INSERT INTO tb_order (OrderID) VALUES (NULL)");
        $orderId = $conn->insert_id;

        foreach ($_SESSION['cart'] as $productId => $Quantity) {
            $productName = $products[$productId]['name'];
            $productPrice = $products[$productId]['price'];
            $totalPrice = $productPrice * $Quantity;

            $stmt = $conn->prepare("INSERT INTO tb_order (NamaBunga, Quantity, FlowerID, Harga, Username, TotalHarga) VALUES (?, ?, ?, ?, ?, ?)");
            if ($stmt === false) {
                throw new Exception("Persiapan gagal: " . $conn->error);
            }

            $username = 'nidipie'; // Sesuaikan dengan nama pengguna yang sebenarnya
            $stmt->bind_param("siiisd", $productName, $Quantity, $productId, $productPrice, $username, $totalPrice);

            if (!$stmt->execute()) {
                throw new Exception("Eksekusi gagal: " . $stmt->error);
            }

            $stmt->close();
        }

        $conn->commit();
        $_SESSION['cart'] = []; // Kosongkan keranjang setelah checkout
        header("Location: thank_you.php");
        exit;
    } catch (Exception $e) {
        $conn->rollback();
        echo "Checkout gagal: " . $e->getMessage();
    }
}

// Proses tindakan berdasarkan parameter 'action' dari URL
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $productId = isset($_GET['id']) ? (int)$_GET['id'] : null;

    switch ($action) {
        case 'add':
            if ($productId) {
                addToCart($productId);
            }
            header("Location: cart.php");
            exit;
        case 'remove':
            if ($productId) {
                removeFromCart($productId);
            }
            header("Location: cart.php");
            exit;
        case 'checkout':
            checkout();
            exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Keranjang Belanja</title>
</head>
<body>
<?php displayCart(); ?>
<br>
<a href="index.php">Kembali ke Daftar Produk</a>
<br><br>
<a href="cart.php?action=checkout">Checkout</a>
</body>
</html>