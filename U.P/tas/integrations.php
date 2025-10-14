<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

// Simpan pengaturan jika form disubmit
if (isset($_POST['simpan'])) {
    $midtrans_key = $_POST['midtrans_key'];
    $rajaongkir_key = $_POST['rajaongkir_key'];
    $whatsapp_api = $_POST['whatsapp_api'];

    // Contoh simpan ke tabel tb_integrations (pastikan tabel ini ada di database)
    mysqli_query($conn, "
        REPLACE INTO tb_integrations (id, midtrans_key, rajaongkir_key, whatsapp_api)
        VALUES (1, '$midtrans_key', '$rajaongkir_key', '$whatsapp_api')
    ");

    $pesan = "Pengaturan integrasi berhasil disimpan!";
}

// Ambil pengaturan terakhir
$setting = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tb_integrations WHERE id = 1"));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Integrasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            max-width: 500px;
            margin: auto;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background: #477c93;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            margin-top: 15px;
            cursor: pointer;
        }
        button:hover {
            background: #365e72;
        }
        .alert {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<h2>Pengaturan Integrasi</h2>

<?php if (!empty($pesan)) { ?>
    <div class="alert"><?= $pesan ?></div>
<?php } ?>

<form method="post">
    <label for="midtrans_key">Midtrans Server Key</label>
    <input type="text" id="midtrans_key" name="midtrans_key" value="<?= $setting['midtrans_key'] ?? '' ?>">

    <label for="rajaongkir_key">RajaOngkir API Key</label>
    <input type="text" id="rajaongkir_key" name="rajaongkir_key" value="<?= $setting['rajaongkir_key'] ?? '' ?>">

    <label for="whatsapp_api">WhatsApp API URL</label>
    <input type="text" id="whatsapp_api" name="whatsapp_api" value="<?= $setting['whatsapp_api'] ?? '' ?>">

    <button type="submit" name="simpan">Simpan Pengaturan</button>
</form>

</body>
</html>
