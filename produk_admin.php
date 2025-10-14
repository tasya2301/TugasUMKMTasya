<?php
session_start();
include 'koneksi.php';

// Cek role admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$result = mysqli_query($conn, "SELECT * FROM tb_produk ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Produk</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {font-family: Arial, sans-serif;background: #f0f8ff;margin:0;padding:0;}
        .container {width:90%;max-width:1100px;margin:auto;padding:20px;}
        h1 {text-align:center;color:#3498db;}
        table {width:100%;border-collapse:collapse;margin-top:25px;}
        th, td {border:1px solid #3498db;padding:10px;text-align:center;}
        th {background:#3498db;color:white;}
        img {width:80px;height:80px;object-fit:cover;}
        .btn {display:inline-block;padding:6px 10px;margin:2px;font-size:14px;border-radius:5px;text-decoration:none;color:white;}
        .btn-add {background:#27ae60;}
        .btn-edit {background:#f39c12;}
        .btn-del {background:#e74c3c;}
        .btn-back {background:#2980b9;}
    </style>
</head>
<body>
<div class="container">
    <h1>Kelola Produk</h1>
    <a href="dashboard.php" class="btn btn-back"><i class="bi bi-house"></i> Dashboard</a>
    <a href="tambah_produk.php" class="btn btn-add"><i class="bi bi-plus"></i> Tambah Produk</a>

    <table>
        <tr>
            <th>ID</th>
            <th>Foto</th>
            <th>Nama</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><img src="uploads/<?= $row['foto'] ?>" alt=""></td>
            <td><?= htmlspecialchars($row['nama']) ?></td>
            <td>Rp <?= number_format($row['harga'],0,',','.') ?></td>
            <td><?= $row['stok'] ?></td>
            <td>
                <a href="edit_produk.php?id=<?= $row['id'] ?>" class="btn btn-edit">Edit</a>
                <a href="hapus_produk.php?id=<?= $row['id'] ?>" class="btn btn-del btn-hapus">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

<script>
document.querySelectorAll('.btn-hapus').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        let link = this.getAttribute('href');
        Swal.fire({
            title: "Yakin?",
            text: "Produk ini akan dihapus!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#e74c3c",
            cancelButtonColor: "#3498db",
            confirmButtonText: "Ya, hapus!"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link;
            }
        });
    });
});
</script>
</body>
</html>
