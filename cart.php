<?php

session_start();
include 'db_cart.php';

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

// Fungsi untuk mendapatkan total item di keranjang
function getTotalItems() {
    $totalItems = 0;
    foreach ($_SESSION['cart'] as $Quantity) {
        $totalItems += $Quantity;
    }
    return $totalItems;
}

// Fungsi untuk menampilkan isi keranjang
function displayCart() {
    global $products;
    
    echo "<h1>Keranjang Belanja</h1><ul>";
    foreach ($_SESSION['cart'] as $id => $Quantity) {
        echo "<li>" . $products[$id]['name'] . " - Jumlah: " . $Quantity . " <a href='cart.php?action=remove&id=$id'>Hapus</a></li>";
    }
    echo "</ul><p>Total Produk: " . getTotalItems() . "</p>";
}

// Fungsi untuk checkout dan menyimpan ke database
function checkout() {
    global $conn;
    if (empty($_SESSION['cart'])) {
        echo "Keranjang belanja kosong!";
        return;
    }

    $conn->begin_transaction();

    try {
        // Insert ke tabel orders dan dapatkan ID pesanan baru
        $conn->query("INSERT INTO tb_order () VALUES ()");
        $orderId = $conn->insert_id;

        // Insert setiap item ke tabel order details
        foreach ($_SESSION['cart'] as $productId => $Quantity) {
            // Ambil detail produk dari tabel products
            $result = $conn->query("SELECT * FROM tb_flower WHERE FlowerID= $productId");

            if ($result && $product = $result->fetch_assoc()) {
                $productName = $product['NamaBunga'];
                $productPrice = $product['Harga'];
                $totalPrice = $productPrice * $Quantity;

                // Debug: Tampilkan detail produk yang diambil
                var_dump($product);

                // Persiapkan pernyataan INSERT untuk tb_order
                $stmt = $conn->prepare("INSERT INTO tb_order (NamaBunga, Quantity, FlowerID, Harga, Username, TotalHarga) VALUES ( ?, ?, ?, ?, ?, ?)");
                if ($stmt === false) {
                    throw new Exception("Persiapan gagal: " . $conn->error);
                }

                // Ikatan parameter dan eksekusi pernyataan
                $orderId = ''; // Contoh OrderID, Anda mungkin perlu menghasilkan ini secara dinamis
                $username = 'nidipie'; // Contoh nama pengguna, sesuaikan sesuai kebutuhan
                $stmt->bind_param("siiisd", $productName, $Quantity, $productId, $productPrice, $username, $totalPrice);

                // Debug: Tampilkan query yang disiapkan
                echo "Query: INSERT INTO tb_order (NamaBunga, Quantity, FlowerID, Harga, Username, TotalHarga) VALUES ($orderId, $productName, $Quantity, $productId, $productPrice, $username, $totalPrice)";

                if (!$stmt->execute()) {
                    throw new Exception("Eksekusi gagal: " . $stmt->error);
                }

                $stmt->close();
            } else {
                throw new Exception("Error mengambil detail produk: " . $conn->error);
            }
        }

        $conn->commit();
        $_SESSION['cart'] = [];
        header("Location: thank_you.php");
        exit;
    } catch (Exception $e) {
        $conn->rollback();
        echo "Checkout gagal: " . $e->getMessage();
    }
}

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $productId = isset($_GET['id']) ? (int)$_GET['id'] : null;
    $Quantity = isset($_POST['Quantity']) ? (int)$_POST['Quantity'] : 1;

    switch ($action) {
        case 'add':
            if ($productId) {
                addToCart($productId);
            }
            header("Location: view_cart.php");
            exit;
        case 'update':
            if ($productId) {
                updateCart($productId, $Quantity);
            }
            header("Location: view_cart.php");
            exit;
        case 'remove':
            if ($productId) {
                removeFromCart($productId);
            }
            header("Location: view_cart.php");
            exit;
        case 'checkout':
            checkout();
            exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Keranjang Belanja</title>
</head>
<body>
    <?php displayCart(); ?>
    <form method="post" action="cart.php?action=add&id=1">
        <input type="number" name="quantity" value="1">
        <button type="submit">Tambah ke Keranjang</button>
    </form>
</body>
</html>
