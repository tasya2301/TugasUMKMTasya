<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

// Ambil data order
$query = mysqli_query($conn, "
    SELECT id, nama_pelanggan, email, telepon, alamat, tanggal_order, total_harga, status
    FROM tb_orders
    ORDER BY tanggal_order DESC
");

// Hitung total penjualan
$total_penjualan = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT SUM(total_harga) AS total FROM tb_orders
"))['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f4f8;
            padding: 20px;
        }
        h2, h3 {
            text-align: center;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            background: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background: #477c93;
            color: white;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        .total-box {
            background: #fff;
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            color: #333;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<h2>Laporan Penjualan</h2>
<div class="total-box">
    Total Penjualan: Rp <?= number_format($total_penjualan, 0, ',', '.') ?>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Pelanggan</th>
            <th>Email</th>
            <th>Telepon</th>
            <th>Alamat</th>
            <th>Tanggal Order</th>
            <th>Total Harga</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($query)) { ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['nama_pelanggan']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['telepon']) ?></td>
                <td><?= htmlspecialchars($row['alamat']) ?></td>
                <td><?= $row['tanggal_order'] ?></td>
                <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                <td><?= $row['status'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

</body>
</html>
