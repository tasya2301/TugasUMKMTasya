# Membuat file cart.php untuk menangani aksi tambah dan hapus item dari keranjang, dengan posisi keranjang belanja di sidebar kanan yang bisa dibuka/tutup.

cart_php = """
<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$id = $_POST['id'];
$name = $_POST['name'];
$price = $_POST['price'];
$action = $_POST['action'];

if ($action === 'add') {
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity'] += 1;
    } else {
        $_SESSION['cart'][$id] = [
            'id' => $id,
            'name' => $name,
            'price' => $price,
            'quantity' => 1
        ];
    }
} elseif ($action === 'remove') {
    unset($_SESSION['cart'][$id]);
}

header("Location: index.php");
exit;
?>
"""

# Simpan file cart.php
cart_path = Path("/mnt/data/cart.php")
cart_path.write_text(cart_php, encoding="utf-8")
cart_path.name
