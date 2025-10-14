<?php
include "koneksi.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitasi ID

    // Ambil nama file gambar dulu
    $query = mysqli_query($conn, "SELECT foto FROM tb_produk WHERE id='$id'");
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        $filePath = "img/" . $data['foto'];

        // Hapus data dari database
        $delete = mysqli_query($conn, "DELETE FROM tb_produk WHERE id='$id'");

        if ($delete) {
            // Jika ada file gambar, hapus juga dari folder img
            if (file_exists($filePath) && !is_dir($filePath)) {
                unlink($filePath);
            }

            // Redirect kembali ke dashboard dengan notifikasi sukses
            header("Location: dashboard.php?msg=deleted");
            exit;
        } else {
            // Jika gagal hapus data
            header("Location: dashboard.php?msg=error");
            exit;
        }
    } else {
        // Jika data tidak ditemukan
        header("Location: dashboard.php?msg=notfound");
        exit;
    }
} else {
    // Jika ID tidak dikirim
    header("Location: dashboard.php?msg=invalid");
    exit;
}
?>