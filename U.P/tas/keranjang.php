<?php
session_start();
include 'koneksi.php';

// Pastikan session keranjang sudah ada
if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

// Ambil aksi dari URL
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : '';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$jumlah = isset($_GET['jumlah']) ? intval($_GET['jumlah']) : 1;

if ($aksi == "tambah" && $id > 0) {
    // Ambil data produk dari database
    $query = mysqli_query($conn, "SELECT * FROM tb_produk WHERE id = $id");
    $produk = mysqli_fetch_assoc($query);

    if ($produk) {
        if (isset($_SESSION['keranjang'][$id])) {
            $_SESSION['keranjang'][$id]['jumlah'] += $jumlah;
        } else {
            $_SESSION['keranjang'][$id] = [
                'nama' => $produk['nama'],
                'harga' => $produk['harga'],
                'foto' => $produk['foto'],
                'jumlah' => $jumlah
            ];
        }
    }
    header("Location: keranjang.php");
    exit;
}

if ($aksi == "hapus" && $id > 0) {
    unset($_SESSION['keranjang'][$id]);
    header("Location: keranjang.php");
    exit;
}

if ($aksi == "update" && !empty($_POST['jumlah'])) {
    foreach ($_POST['jumlah'] as $id_produk => $qty) {
        if ($qty > 0) {
            $_SESSION['keranjang'][$id_produk]['jumlah'] = intval($qty);
        } else {
            unset($_SESSION['keranjang'][$id_produk]);
        }
    }
    header("Location: keranjang.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
 <style>
    body {
        font-family: Arial, sans-serif;
        background: #ffffff; /* putih */
        padding: 20px;
        color: #111; /* teks hitam */
    }
    h2 {
        text-align: center;
        color: #000; /* judul hitam */
    }
    table {
        width: 100%;
        border-collapse: collapse;
        background: #fff; 
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }
    table th, table td {
        padding: 12px;
        text-align: center;
        border-bottom: 1px solid #ddd;
        color: #111;
    }
    table th {
        background: #000; /* header hitam */
        color: #fff; /* teks putih */
    }
    img {
        width: 80px;
        border-radius: 6px;
        border: 1px solid #ccc;
    }
    .btn {
        display: inline-block;
        padding: 10px 18px;
        background: #000; /* tombol hitam */
        color: #fff;
        border-radius: 5px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: 0.3s;
        font-size: 14px;
    }
    .btn:hover {
        background: #333; /* abu gelap saat hover */
    }
    .btn-danger {
        background: #e74c3c;
    }
    .btn-danger:hover {
        background: #c0392b;
    }
    input[type="number"] {
        width: 60px;
        text-align: center;
        padding: 6px;
        border: 1px solid #aaa;
        border-radius: 5px;
        color: #111;
        background: #fff;
    }
    .total {
        text-align: right;
        font-size: 18px;
        margin-top: 15px;
        font-weight: bold;
        color: #000;
    }
    .actions {
        margin-top: 15px;
        text-align: right;
    }
</style>

</head>
<body>

<h2 > <span id="cart-count">Keranjang Belanja</span></h2>

<form action="keranjang.php?aksi=update" method="POST">
<table>
    <tr>
        <th>Gambar</th>
        <th>Nama Produk</th>
        <th>Harga</th>
        <th>Jumlah</th>
        <th>Subtotal</th>
        <th>Aksi</th>
    </tr>
    <?php
    $total = 0;
    if (!empty($_SESSION['keranjang'])) {
        foreach ($_SESSION['keranjang'] as $id_produk => $item) {
            $subtotal = $item['harga'] * $item['jumlah'];
            $total += $subtotal;
            echo "<tr>
                <td><img src='img/{$item['foto']}' alt='{$item['nama']}'></td>
                <td>{$item['nama']}</td>
                <td>Rp " . number_format($item['harga'], 0, ',', '.') . "</td>
                <td><input type='number' name='jumlah[$id_produk]' value='{$item['jumlah']}' min='1' style='width:60px;text-align:center;'></td>
                <td>Rp " . number_format($subtotal, 0, ',', '.') . "</td>
                <td><a href='keranjang.php?aksi=hapus&id=$id_produk' class='btn btn-danger'>Hapus</a></td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='6'>Keranjang kosong</td></tr>";
    }
    ?>
</table>

<div class="total">
    <strong>Total: Rp <?php echo number_format($total, 0, ',', '.'); ?></strong>
</div>

<div class="actions">
    <button type="submit" class="btn">Update Keranjang</button>
    <?php if ($total > 0) { ?>
        <a href="checkout.php" class="btn">Checkout</a>
    <?php } ?>
    <a href="index.php" class="btn">Lanjut Belanja</a>
</div>
</form>

</body>
</html>
