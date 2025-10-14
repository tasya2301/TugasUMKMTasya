<?php
include 'koneksi.php';

// Ambil ID produk dari URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ambil data produk dari database
$query = mysqli_query($conn, "SELECT * FROM tb_produk WHERE id = $id");
$produk = mysqli_fetch_assoc($query);

// Kalau produk tidak ditemukan
if (!$produk) {
    echo "<h2>Produk tidak ditemukan!</h2>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk - <?php echo htmlspecialchars($produk['nama']); ?></title>
 <style>
    body {
        font-family: Arial, sans-serif;
        background: #e3e3e3ff; /* Putih */
        margin: 0;
        padding: 0;
        color: #111; /* Hitam teks */
    }
    .container {
        max-width: 1000px;
        margin: 40px auto;
        background: #ebe9e9ff; /* Putih abu-abu lembut */
        padding: 20px;
        display: flex;
        gap: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }
    .product-image {
        flex: 1;
    }
    .product-image img {
        width: 100%;
        border-radius: 10px;
        border: 1px solid #ddd; /* Bingkai tipis */
    }
    .product-info {
        flex: 1;
    }
    .product-info h1 {
        margin-bottom: 10px;
        color: #000; /* Judul hitam pekat */
    }
    .product-price {
        font-size: 22px;
        color: #000; /* Harga hitam */
        margin: 15px 0;
        font-weight: bold;
    }
    .product-desc {
        margin: 20px 0;
        color: #333; /* Abu tua untuk teks deskripsi */
    }
    .btn {
        display: inline-block;
        padding: 12px 20px;
        background: #000; /* Tombol hitam */
        color: #fff; /* Teks putih */
        border-radius: 5px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: 0.3s;
        font-size: 16px;
    }
    .btn:hover {
        background: #444; /* Abu gelap saat hover */
    }
    input[type="number"] {
        padding: 10px;
        width: 80px;
        margin-right: 10px;
        font-size: 16px;
        text-align: center;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    form {
        margin-top: 20px;
    }
</style>

</head>
<body>

<div class="container">
    <!-- Foto Produk -->
    <div class="product-image">
        <img src="img/<?php echo $produk['foto']; ?>" alt="<?php echo htmlspecialchars($produk['nama']); ?>">
    </div>

    <!-- Informasi Produk -->
    <div class="product-info">
        <h1><?php echo htmlspecialchars($produk['nama']); ?></h1>
        <div class="product-price">
            Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?>
        </div>
        <div class="product-desc">
            <p><strong>Stok:</strong> <?php echo $produk['stok']; ?></p>
            <p><strong>Kategori:</strong> <?php echo htmlspecialchars($produk['id_kategori']); ?></p>
            <p><?php echo nl2br(htmlspecialchars($produk['deskripsi'])); ?></p>
        </div>

        <!-- Form tambah ke keranjang -->
        <form action="keranjang.php" method="GET">
            <input type="hidden" name="aksi" value="tambah">
            <input type="hidden" name="id" value="<?php echo $produk['id']; ?>">
            <label for="jumlah">Jumlah:</label>
            <input type="number" name="jumlah" id="jumlah" value="1" min="1" max="<?php echo $produk['stok']; ?>">
            <button type="submit" class="btn">🛒</button>
        </form>
    </div>
</div>

</body>
</html>
