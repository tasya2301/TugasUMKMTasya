<?php
session_start();
include 'koneksi.php';

// Ambil ID produk dari URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Cek apakah ID produk valid
$query = mysqli_query($conn, "SELECT * FROM tb_produk WHERE id = $id");
$produk = mysqli_fetch_assoc($query);

if (!$produk) {
    // Produk tidak ditemukan
    header("Location: products.php?msg=notfound");
    exit;
}

// Jika keranjang belum ada di session, buat keranjang baru
if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

// Jika produk sudah ada di keranjang, tambahkan jumlahnya
if (isset($_SESSION['keranjang'][$id])) {
    $_SESSION['keranjang'][$id]['jumlah'] += 1;
} else {
    // Tambahkan produk baru ke keranjang
    $_SESSION['keranjang'][$id] = [
        'id' => $produk['id'],
        'nama' => $produk['nama'],
        'harga' => $produk['harga'],
        'poto' => $produk['poto'],
        'jumlah' => 1
    ];
}

// Redirect kembali ke halaman products.php atau ke keranjang
header("Location: keranjang.php?msg=added");
exit;
?>
