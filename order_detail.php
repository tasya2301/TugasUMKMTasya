<?php
include 'koneksi.php';
session_start();

// Pastikan admin login
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

// Ambil ID order
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Proses update status jika form dikirim
if (isset($_POST['update_status'])) {
    $status_baru = mysqli_real_escape_string($conn, $_POST['status']);
    mysqli_query($conn, "UPDATE tb_orders SET status = '$status_baru' WHERE id = $id");
    header("Location: order_detail.php?id=$id&msg=updated");
    exit;
}

// Ambil data order
$order = mysqli_query($conn, "SELECT * FROM tb_orders WHERE id = $id");
$data_order = mysqli_fetch_assoc($order);

if (!$data_order) {
    echo "<h3>Order tidak ditemukan!</h3>";
    exit;
}

// Ambil data item di order ini
$order_items = mysqli_query($conn, "
    SELECT p.nama, p.harga, i.jumlah, (p.harga * i.jumlah) AS subtotal
    FROM tb_order_items i
    JOIN tb_produk p ON i.produk_id = p.id
    WHERE i.order_id = $id
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Order #<?php echo $id; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Detail Order #<?php echo $id; ?></h2>

    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'updated'): ?>
        <div class="alert alert-success">Status order berhasil diperbarui!</div>
    <?php endif; ?>

    <p><strong>Nama Pelanggan:</strong> <?php echo $data_order['nama_pelanggan']; ?></p>
    <p><strong>Email:</strong> <?php echo $data_order['email']; ?></p>
    <p><strong>Alamat:</strong> <?php echo $data_order['alamat']; ?></p>
    <p><strong>Tanggal Order:</strong> <?php echo $data_order['tanggal_order']; ?></p>

    <!-- Form Ubah Status -->
    <form method="POST" class="mb-3">
        <label for="status" class="form-label"><strong>Status:</strong></label>
        <div class="input-group" style="max-width:300px;">
            <select name="status" id="status" class="form-select">
                <option value="Menunggu Pembayaran" <?php if($data_order['status']=="Menunggu Pembayaran") echo "selected"; ?>>Menunggu Pembayaran</option>
                <option value="Diproses" <?php if($data_order['status']=="Diproses") echo "selected"; ?>>Diproses</option>
                <option value="Dikirim" <?php if($data_order['status']=="Dikirim") echo "selected"; ?>>Dikirim</option>
                <option value="Selesai" <?php if($data_order['status']=="Selesai") echo "selected"; ?>>Selesai</option>
                <option value="Dibatalkan" <?php if($data_order['status']=="Dibatalkan") echo "selected"; ?>>Dibatalkan</option>
            </select>
            <button type="submit" name="update_status" class="btn btn-primary">Simpan</button>
        </div>
    </form>

    <h4>Produk yang Dipesan</h4>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        $total = 0;
        while ($item = mysqli_fetch_assoc($order_items)) {
            $total += $item['subtotal'];
            echo "<tr>
                <td>{$item['nama']}</td>
                <td>Rp " . number_format($item['harga'], 0, ',', '.') . "</td>
                <td>{$item['jumlah']}</td>
                <td>Rp " . number_format($item['subtotal'], 0, ',', '.') . "</td>
            </tr>";
        }
        ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-end">Total</th>
                <th>Rp <?php echo number_format($total, 0, ',', '.'); ?></th>
            </tr>
        </tfoot>
    </table>

    <a href="orders.php" class="btn btn-secondary">Kembali</a>
</div>
</body>
</html>
