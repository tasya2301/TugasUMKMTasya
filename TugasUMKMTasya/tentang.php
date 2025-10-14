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
    <style>
       :root {
    --primary: #000;   /* Hitam */
    --secondary: #000000ff; /* Putih */
    --accent: #000;    /* Hitam */
    --dark: #000;      /* Hitam */
    --light: #fff;     /* Putih */
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
            color: var(--primary);
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
            color: var(--primary);
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

    </style>
</head>
<body>
    
    <nav>
    <div class="nav-links">
        <a href=index.php>Beranda</a>

    </div>
    
   
    </nav>
  <div class="footer-column">
                <h3>Kontak</h3>
                <ul>
                    <li>Jl.cipto mangunkusumo No. 123</li>
                    <li>cirebon, Indonesia</li>
                    <li>Telp: (021) 1234567</li>
                    <li>Email: info@taspremium.com</li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Jam Buka</h3>
                <ul>
                    <li>Senin-Jumat: 10:00 - 22:00</li>
                    <li>Sabtu-Minggu: 09:00 - 23:00</li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Follow Kami</h3>
                <div class="social-links">
                   <li>Instagram</li>
                    <li>Facebook</li>
                    <li>Twitter</li>
                </div>
            </div>
        </div>
        <div class="copyright">
            &copy; 2023 toko tas Premium. Semua Hak Dilindungi.
        </div>
    </footer>
    
    <script>
        // Cart functionality
        const cartBtn = document.getElementById('cart-btn');
        const closeCartBtn = document.getElementById('close-cart');
        const cartSidebar = document.getElementById('cart-sidebar');
        const overlay = document.getElementById('overlay');
        const cartItemsContainer = document.getElementById('cart-items');
        const cartTotalElement = document.getElementById('cart-total');
        const cartCountElement = document.getElementById('cart-count');
        const addToCartBtns = document.querySelectorAll('.add-to-cart');
        
        let cart = [];
        
        // Toggle cart sidebar
        cartBtn.addEventListener('click', () => {
            cartSidebar.classList.add('active');
            overlay.classList.add('active');
        });
        
        closeCartBtn.addEventListener('click', () => {
            cartSidebar.classList.remove('active');
            overlay.classList.remove('active');
        });
        
        overlay.addEventListener('click', () => {
            cartSidebar.classList.remove('active');
            overlay.classList.remove('active');
        });
        
        // Add to cart functionality
        addToCartBtns.forEach(button => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                const price = parseInt(button.getAttribute('data-price'));
                
                // Check if item already exists in cart
                const existingItem = cart.find(item => item.id === id);
                
                if (existingItem) {
                    existingItem.quantity += 1;
                } else {
                    cart.push({
                        id,
                        name,
                        price,
                        quantity: 1
                    });
                }
                
                updateCart();
                
                // Show cart
                cartSidebar.classList.add('active');
                overlay.classList.add('active');
            });
        });
        
        // Update cart UI
        function updateCart() {
            // Update cart items
            if (cart.length === 0) {
                cartItemsContainer.innerHTML = '<p class="empty-cart-message">Keranjang Anda masih kosong</p>';
            } else {
                cartItemsContainer.innerHTML = '';
                
                cart.forEach(item => {
                    const cartItemElement = document.createElement('div');
                    cartItemElement.className = 'cart-item';
                    
                    cartItemElement.innerHTML = `
                        <img src="https://placehold.co/800x600" alt="${item.name}" class="cart-item-img">
                        <div class="cart-item-fs">
                            <h4 class="cart-item-title">${item.name}</h4>
                            <span class="cart-item-price">Rp ${item.price.toLocaleString()}</span>
                            <div class="quantity-controls">
                                <button class="quantity-btn minus" data-id="${item.id}">-</button>
                                <span>${item.quantity}</span>
                                <button class="quantity-btn plus" data-id="${item.id}">+</button>
                            </div>
                        </div>
                        <button class="remove-item" data-id="${item.id}">Hapus</button>
                    `;
                    
                    cartItemsContainer.appendChild(cartItemElement);
                });
                
                // Add event listeners for quantity controls
                document.querySelectorAll('.quantity-btn.minus').forEach(button => {
                    button.addEventListener('click', () => {
                        const id = button.getAttribute('data-id');
                        const item = cart.find(item => item.id === id);
                        
                        if (item.quantity > 1) {
                            item.quantity -= 1;
                        } else {
                            cart = cart.filter(item => item.id !== id);
                        }
                        
                        updateCart();
                    });
                });
                
                document.querySelectorAll('.quantity-btn.plus').forEach(button => {
                    button.addEventListener('click', () => {
                        const id = button.getAttribute('data-id');
                        const item = cart.find(item => item.id === id);
                        
                        item.quantity += 1;
                        updateCart();
                    });
                });
                
                document.querySelectorAll('.remove-item').forEach(button => {
                    button.addEventListener('click', () => {
                        const id = button.getAttribute('data-id');
                        cart = cart.filter(item => item.id !== id);
                        updateCart();
                    });
                });
            }
            
            // Update cart total
            const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            cartTotalElement.textContent = `Rp ${total.toLocaleString()}`;
            
            // Update cart count
            const count = cart.reduce((sum, item) => sum + item.quantity, 0);
            cartCountElement.textContent = count;
        }
        
        // Checkout button
        document.querySelector('.checkout-btn').addEventListener('click', () => {
            if (cart.length === 0) {
                alert('Keranjang belanja Anda masih kosong!');
                return;
            }
            
            alert('Terima kasih sudah berbelanja! Pesanan Anda sedang diproses.');
            cart = [];
            updateCart();
            cartSidebar.classList.remove('active');
            overlay.classList.remove('active');
        });
    </script>
</body>
</html>