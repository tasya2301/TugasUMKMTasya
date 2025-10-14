<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$id_transaksi = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ambil data transaksi
$query = mysqli_query($conn, "SELECT * FROM transaksi WHERE id='$id_transaksi' AND user_id='$id_user'");
$transaksi = mysqli_fetch_assoc($query);

if (!$transaksi) {
    echo "<h2>Nota tidak ditemukan!</h2>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nota Pembelian</title>
    <style>
        body { font-family: Arial, sans-serif; background: #fff; padding: 40px; color:#000; }
        .nota-container { max-width: 600px; margin: auto; border: 1px solid #ccc; padding: 20px; border-radius: 10px; }
        h2 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        td { padding: 8px; }
        .footer { margin-top: 20px; text-align: center; font-size: 14px; color: #555; }
        .btn-print {
            display: block; margin: 20px auto; padding: 10px 20px;
            background: #000; color: #fff; border: none; border-radius: 6px;
            cursor: pointer; transition: 0.3s;
        }
        .btn-print:hover { background: #333; }
    </style>
</head>
<body>

<div class="nota-container">
    <h2>🧾 Nota Pembelian</h2>
    <table>
        <tr><td><strong>Tanggal</strong></td><td><?php echo $transaksi['tanggal']; ?></td></tr>
        <tr><td><strong>Produk</strong></td><td><?php echo $transaksi['produk']; ?></td></tr>
        <tr><td><strong>Jumlah</strong></td><td><?php echo $transaksi['jumlah']; ?></td></tr>
        <tr><td><strong>Total</strong></td><td>Rp <?php echo number_format($transaksi['total'],0,',','.'); ?></td></tr>
        <tr><td><strong>Status</strong></td><td><?php echo $transaksi['status']; ?></td></tr>
    </table>

    <button class="btn-print" onclick="window.print()">🖨️ Cetak Nota</button>

    <div class="footer">
        Terima kasih sudah berbelanja 💖<br>
        Toko Tas Korean Style
    </div>
</div>

</body>
</html>
