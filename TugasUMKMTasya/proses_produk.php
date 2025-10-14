<?php
session_start();
include 'koneksi.php'; // koneksi pakai $conn

// ==== FUNGSI UPLOAD FOTO ====
function uploadFoto($file, $fotoLama = null) {
    $allowed = ['jpg','jpeg','png','gif'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $size = $file['size'];

    if (!in_array($ext, $allowed) || $size > 2000000) {
        return false; // file tidak valid
    }

    $namaBaru = uniqid() . "." . $ext;
    $tujuan = "img/" . $namaBaru;

    if (move_uploaded_file($file['tmp_name'], $tujuan)) {
        if ($fotoLama && file_exists("img/" . $fotoLama)) {
            unlink("img/" . $fotoLama);
        }
        return $namaBaru;
    }
    return false;
}

// ==== TAMBAH PRODUK ====
if (isset($_POST['aksi']) && $_POST['aksi'] == "tambah") {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];

    $foto = null;
    if (!empty($_FILES['foto']['name'])) {
        $foto = uploadFoto($_FILES['foto']);
    }

    $query = $conn->prepare("INSERT INTO tb_produk (nama, deskripsi, harga, foto) VALUES (?, ?, ?, ?)");
    $query->bind_param("ssis", $nama, $deskripsi, $harga, $foto);
    $simpan = $query->execute();

    echo $simpan 
        ? "<script>window.location='dashboard.php?msg=add_success';</script>" 
        : "<script>window.location='dashboard.php?msg=add_error';</script>";
}

// ==== EDIT PRODUK ====
if (isset($_POST['aksi']) && $_POST['aksi'] == "edit") {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $fotoLama = $_POST['foto_lama'];

    $fotoBaru = $fotoLama;
    if (!empty($_FILES['foto']['name'])) {
        $fotoUpload = uploadFoto($_FILES['foto'], $fotoLama);
        if ($fotoUpload) {
            $fotoBaru = $fotoUpload;
        }
    }

    $query = $conn->prepare("UPDATE tb_produk SET nama=?, deskripsi=?, harga=?, foto=? WHERE id=?");
    $query->bind_param("ssisi", $nama, $deskripsi, $harga, $fotoBaru, $id);
    $simpan = $query->execute();

    echo $simpan 
        ? "<script>window.location='dashboard.php?msg=edit_success';</script>" 
        : "<script>window.location='dashboard.php?msg=edit_error';</script>";
}

// ==== HAPUS PRODUK ====
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];

    $result = $conn->prepare("SELECT foto FROM tb_produk WHERE id=?");
    $result->bind_param("i", $id);
    $result->execute();
    $data = $result->get_result()->fetch_assoc();

    if ($data && file_exists("img/" . $data['foto'])) {
        unlink("img/" . $data['foto']);
    }

    $hapus = $conn->prepare("DELETE FROM tb_produk WHERE id=?");
    $hapus->bind_param("i", $id);
    $sukses = $hapus->execute();

    echo $sukses 
        ? "<script>window.location='dashboard.php?msg=delete_success';</script>" 
        : "<script>window.location='dashboard.php?msg=delete_error';</script>";
}
?>
