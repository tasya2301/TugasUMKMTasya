<?php
include 'koneksi.php';
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f8ff; /* biru muda background */
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #3498db; /* judul biru */
        }
        .products {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }
        .product-card {
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            text-align: center;
            transition: 0.3s;
            border: 2px solid #3498db; /* border biru */
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 10px rgba(0,0,0,0.15);
        }
        .product-card img {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }
        .product-card h3 {
            margin: 10px 0;
            color: #3498db; /* nama produk biru */
        }
        .price {
            color: #2980b9; /* harga biru tua */
            font-weight: bold;
        }
        .btn {
            display: inline-block;
            padding: 8px 12px;
            margin: 8px 4px;
            font-size: 14px;
            border-radius: 5px;
            text-decoration: none;
            transition: 0.3s;
            background: #3498db; /* semua tombol biru */
            color: white;
        }
        .btn:hover {
            opacity: 0.85;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Daftar Produk</h1>

    <!-- Tombol Kembali -->
    <a href="dashboard.php" class="btn">⬅ Kembali</a>

    <div class="products">
        <?php
        $query = mysqli_query($conn, "SELECT * FROM tb_produk ORDER BY id DESC");
        if (mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                ?>
                <div class="product-card">
                    <img src="img/<?php echo $row['foto']; ?>" alt="<?php echo $row['nama']; ?>">
                    <h3><?php echo $row['nama']; ?></h3>
                    <p class="price">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></p>
                    <a href="detail.php?id=<?php echo $row['id']; ?>" class="btn">Detail</a>
                    <a href="tambah_keranjang.php?id=<?php echo $row['id']; ?>" class="btn">+ Keranjang</a>
                </div>
                <?php
            }
        } else {
            echo "<p style='text-align:center; color:#3498db;'>Produk belum tersedia.</p>";
        }
        ?>
    </div>
</div>

</body>
</html>
