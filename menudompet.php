<?php
session_start();
include 'koneksi.php';

// Ambil semua data produk dari database
$result = mysqli_query($conn, "SELECT * FROM tb_produk ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Tas Premium</title>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --primary: #000000ff;
            --secondary: #ffffffff;
            --accent: #fefefeff;
            --dark: #f9fbfcff;
            --light: #ffffffff;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: var(--light);
            color: var(--dark);
        }
        
        header {
            background: linear-gradient(135deg, var(--primary), var(--dark));
            color: white;
            padding: 1.5rem;
            text-align: center;
            position: relative;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .logo {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .tagline {
            font-style: italic;
            opacity: 0.9;
        }
        
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            background-color: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        
        .nav-links {
            display: flex;
            gap: 2rem;
        }
        
        .nav-links a {
            text-decoration: none;
            color: var(--dark);
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .nav-links a:hover {
            color: var(--primary);
        }
        
        .cart-btn {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .cart-btn:hover {
            background-color: var(--dark);
            transform: scale(1.05);
        }
        
        .hero {
            height: 400px;
            background: url('img/7.jpeg') center/cover;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        
        .hero::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, rgba(23, 55, 92, 0), rgba(106, 147, 212, 0));
        }
        
        .hero-content {
            z-index: 1;
            color: white;
            text-align: center;
            max-width: 800px;
            padding: 2rem;
        }
        
        .hero h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        .cta-btn {
            background-color: white;
            color: var(--primary);
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .cta-btn:hover {
            background-color: var(--accent);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .products {
            padding: 4rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .section-title h2 {
            font-size: 2rem;
            color: black;
            margin-bottom: 1rem;
        }
        
        .section-title p {
            color: #777;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
        }
        
        .product-card {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
        }
        
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .product-image {
            height: 200px;
            width: 100%;
            object-fit: cover;
        }
        
        .product-info {
            padding: 1.5rem;
        }
        
        .product-info h3 {
            margin-bottom: 0.5rem;
            color: var(--primary);
        }
        
        .product-info p {
            color: #666;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }
        
        .product-price {
            font-weight: 700;
            color: var(--dark);
            font-size: 1.2rem;
            margin-bottom: 1rem;
            display: block;
        }
        
        .add-to-cart {
            width: 100%;
            padding: 0.75rem;
            background-color: var(--secondary);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .add-to-cart:hover {
            background-color: var(--primary);
        }
        
        .cart-sidebar {
            position: fixed;
            top: 0;
            right: -400px;
            width: 400px;
            height: 100vh;
            background-color: white;
            box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
            transition: right 0.3s ease;
            z-index: 1000;
            display: flex;
            flex-direction: column;
        }
        
        .cart-sidebar.active {
            right: 0;
        }
        
        .cart-header {
            padding: 1.5rem;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .close-cart {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #666;
        }
        
        .cart-items {
            flex: 1;
            overflow-y: auto;
            padding: 1.5rem;
        }
        
        .cart-item {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #eee;
        }
        
        .cart-item-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
        }
        
        .cart-item-details {
            flex: 1;
        }
        
        .cart-item-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .cart-item-price {
            display: block;
            color: #000;
            margin-bottom: 0.5rem;
        }
        
        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .quantity-btn {
            width: 25px;
            height: 25px;
            border: 1px solid #ddd;
            background: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 3px;
        }
        
        .remove-item {
            color: #e74c3c;
            background: none;
            border: none;
            cursor: pointer;
            margin-left: auto;
            font-size: 0.9rem;
        }
        
        .cart-footer {
            padding: 1.5rem;
            border-top: 1px solid #eee;
        }
        
        .cart-total {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            font-weight: 600;
            font-size: 1.1rem;
        }
        
        .checkout-btn {
            width: 100%;
            padding: 1rem;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .checkout-btn:hover {
            background-color: var(--dark);
        }
        
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s;
        }
        
        .overlay.active {
            opacity: 1;
            pointer-events: all;
        }
        
        footer {
            background-color: var(--dark);
            color: white;
            text-align: center;
            padding: 2rem;
            margin-top: 3rem;
        }
        
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            text-align: left;
        }
        
        .footer-column h3 {
            margin-bottom: 1rem;
            color: var(--secondary);
        }
        
        .footer-column ul {
            list-style: none;
        }
        
        .footer-column ul li {
            margin-bottom: 0.5rem;
        }
        
        .footer-column ul li a {
            color: #ddd;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer-column ul li a:hover {
            color: var(--secondary);
        }
        
        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .social-links a {
            color: white;
            font-size: 1.5rem;
        }
        
        .copyright {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: #aaa;
            font-size: 0.9rem;
        }
        
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }
            
            .nav-links {
                display: none;
            }
            
            .cart-sidebar {
                width: 100%;
                right: -100%;
            }
            
            .hero {
                height: 300px;
            }
        }

        nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
    background: #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.nav-links a {
    margin-right: 15px;
    text-decoration: none;
    color: #333;
    font-weight: 500;
}

.nav-actions {
    display: flex;
    align-items: center;
}

.cart-btn {
    background: #2b777cff;
    color: white;
    border: none;
    padding: 8px 12px;
    margin-right: 10px;
    border-radius: 5px;
    cursor: pointer;
}

.profile-btn {
    display: inline-block;
    background: #388ab9ff;
    color: white;
    padding: 8px 12px;
    text-decoration: none;
    border-radius: 5px;
    font-weight: 500;
}
.detail-btn {
    display: inline-block;
    background-color: #000;    /* Hitam */
    color: #fff;              /* Tulisan putih */
    padding: 8px 16px;
    border-radius: 5px;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 600;
    transition: all 0.3s;
}

.detail-btn:hover {
    background-color: #333;   /* Abu gelap saat hover */
}

    </style>
</head>
<body>

    
    <nav>
    <div class="nav-links">
        <a href=index.php>Beranda</a>
     </div>
    
   <div class="nav-actions">
   <div class="flex gap-3">
          <!-- Tombol keranjang -->
          <a href="keranjang.php" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-full shadow flex items-center gap-2 transition">
              <i class="bi bi-cart-fill"></i> <span id="cart-count">0</span>
          </a>

          <!-- Tombol profil / login -->
          <?php if (isset($_SESSION['user_id'])): ?>
              <a href="profil.php" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-full shadow transition">
                  <i class="bi bi-person-circle"></i> Profil
              </a>
          <?php else: ?>
              <a href="login.php" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-full shadow transition">
                  <i class="bi bi-box-arrow-in-right"></i> Login
              </a>
          <?php endif; ?>
      </div>
  
    </nav>
<section class="products">
    <div class="section-title">
        <h2 class="text-4xl font-bold text-gray-900 mb-4">PILIHAN PRODUK</h2>
        <p>Biar setiap perjalanan jadi cerita indah dengan dompet berkualitas</p>
    </div>

    <div class="product-grid">
        <?php while ($data = mysqli_fetch_assoc($result)) { ?>
            <div class="product-card">
                <!-- Pastikan path foto sesuai folder tempat kamu simpan -->
                <img src="img/<?php echo $data['foto']; ?>" 
                     alt="<?php echo htmlspecialchars($data['nama']); ?>" 
                     class="product-image" 
                     style="height: 200px; object-fit: cover;">
                
            <div class="product-info">
                <h3><?php echo $data['nama']; ?></h3>
                <p><?php echo $data['deskripsi']; ?></p>
                <p class="product-price">Rp <?php echo number_format($data['harga'], 0, ',', '.'); ?></p>
                <p>Stok: <?php echo $data['stok']; ?></p> <!-- Tambahin ini kalau mau tampil stok -->

<div class="btn-group" style="margin-top: 10px;">
    <a href="detail.php?id=<?php echo $data['id']; ?>" 
       class="detail-btn">
       Lihat Detail
    </a>
</div>

    </div>
        <?php } ?>
    </div>
</section>

    
  
</body>
</html>
