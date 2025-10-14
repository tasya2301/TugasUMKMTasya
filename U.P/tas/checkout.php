<?php
session_start();
include 'koneksi.php';

// Jika keranjang kosong, arahkan ke halaman produk
if (empty($_SESSION['keranjang'])) {
    header("Location: index.php");
    exit;
}

// Pastikan user login
if (!isset($_SESSION['id_user'])) {
    echo "<script>alert('Silakan login terlebih dahulu!'); window.location='login.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_user = $_SESSION['id_user'];
    $tanggal = date('Y-m-d H:i:s');

    // Hitung total harga
    $total = 0;
    foreach ($_SESSION['keranjang'] as $item) {
        $total += $item['harga'] * $item['jumlah'];
    }

    // Simpan setiap produk ke tabel transaksi
    foreach ($_SESSION['keranjang'] as $id_produk => $item) {
        $produk = mysqli_real_escape_string($conn, $item['nama']);
        $jumlah = (int)$item['jumlah'];
        $harga = (int)$item['harga'];
        $subtotal = $harga * $jumlah;

        $query = "INSERT INTO transaksi (user_id, produk, jumlah, total, status, tanggal) 
                  VALUES ('$id_user', '$produk', '$jumlah', '$subtotal', 'Pending', '$tanggal')";
        mysqli_query($conn, $query) or die("Gagal simpan transaksi: " . mysqli_error($conn));
    }

    // Kosongkan keranjang
    unset($_SESSION['keranjang']);

    echo "<script>alert('Pesanan berhasil dibuat!'); window.location='profil.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
  <style>
    body {
        font-family: Arial, sans-serif;
        background: #fff; /* Putih */
        padding: 20px;
        color: #111; /* Teks hitam */
    }
    .checkout-container {
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        max-width: 600px;
        margin: auto;
        box-shadow: 0 3px 8px rgba(0,0,0,0.15);
        border: 1px solid #ddd;
    }
    h2 {
        text-align: center;
        color: #000; /* Hitam */
    }
    h3 {
        color: #111;
        margin-bottom: 10px;
    }
    ul {
        list-style: none;
        padding-left: 0;
        margin: 0;
    }
    ul li {
        padding: 8px 0;
        border-bottom: 1px dashed #aaa;
        color: #111;
    }
    .total {
        font-size: 18px;
        margin-top: 12px;
        text-align: right;
        font-weight: bold;
        color: #000;
    }
    button {
        background: #000; /* Hitam */
        color: #fff;
        padding: 12px 20px;
        border: none;
        cursor: pointer;
        border-radius: 6px;
        font-size: 16px;
        margin-top: 15px;
        float: right;
        transition: 0.3s;
    }
    button:hover {
        background: #333; /* Abu gelap */
    }
</style>

</head>
<body>

<div class="checkout-container">
    <h2>Checkout</h2>
    <form method="POST">
        <h3>Ringkasan Pesanan</h3>
        <ul>
            <?php
            $total = 0;
            foreach ($_SESSION['keranjang'] as $item) {
                $subtotal = $item['harga'] * $item['jumlah'];
                $total += $subtotal;
                echo "<li>{$item['nama']} ({$item['jumlah']} x Rp " . number_format($item['harga'], 0, ',', '.') . ") 
                = <strong>Rp " . number_format($subtotal, 0, ',', '.') . "</strong></li>";
            }
            ?>
        </ul>
        <p class="total"><strong>Total: Rp <?php echo number_format($total, 0, ',', '.'); ?></strong></p>

        <button type="submit">✅ Buat Pesanan</button>
    </form>
</div>

</body>
</html>
