<?php
session_start();
include 'koneksi.php';

// Jika belum login, arahkan ke login.php
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

// Ambil data user
$userResult = mysqli_query($conn, "SELECT * FROM tb_user WHERE id='$id_user'");
$user = mysqli_fetch_assoc($userResult);

if (isset($_POST['update'])) {
    $nama   = mysqli_real_escape_string($conn, $_POST['nama'] ?? '');
    $hp     = mysqli_real_escape_string($conn, $_POST['hp'] ?? '');
    $email  = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat'] ?? '');

    // Kalau password diisi, update pakai yang baru
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    } else {
        $password = $user['password']; // tetap pakai password lama
    }

    $update = "UPDATE tb_user 
               SET nama='$nama', email='$email', password='$password', hp='$hp', alamat='$alamat'
               WHERE id='$id_user'";

    if (mysqli_query($conn, $update)) {
        $_SESSION['nama'] = $nama;
        echo "<script>alert('Profil berhasil diperbarui!');window.location='profil.php';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal update profil! " . mysqli_error($conn) . "');</script>";
    }
}


// Ambil riwayat transaksi
$transaksi = mysqli_query($conn, "SELECT * FROM transaksi WHERE user_id='$id_user' ORDER BY tanggal DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Saya</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-pink-100 font-sans">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-pink-300 to-blue-300 shadow-md p-4 flex justify-between rounded-b-3xl">
        <div class="flex gap-4">
            <a href="index.php" class="font-semibold text-white hover:underline">🏡 Beranda</a>
        </div>
        <div class="flex gap-3">
            <a href="logout.php" class="bg-pink-400 hover:bg-pink-500 text-white px-4 py-2 rounded-full shadow">🚪 Logout</a>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto p-6">
        <!-- Sapaan -->
        <h1 class="text-3xl font-bold mb-6 text-pink-700 text-center">
            🌸 Halo, <?php echo htmlspecialchars($user['nama'] ?? ''); ?>! 👋
        </h1>


        <!-- Edit Profil -->
        <div class="bg-white p-6 rounded-3xl shadow-lg mb-8 border-2 border-pink-200">
            <h2 class="text-2xl font-semibold mb-4 text-pink-600"> Edit Profil </h2>
            <form method="POST" class="space-y-3">
                <input type="text" name="nama" value="<?php echo htmlspecialchars($user['nama']); ?>" class="w-full border border-pink-200 p-3 rounded-full focus:ring-2 focus:ring-pink-300" required>
                <input type="text" name="hp" value="<?php echo htmlspecialchars($user['hp']); ?>" class="w-full border border-pink-200 p-3 rounded-full focus:ring-2 focus:ring-pink-300" required>
                <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="w-full border border-pink-200 p-3 rounded-full bg-gray-100 cursor-not-allowed">
                <input type="text" name="alamat" value="<?php echo htmlspecialchars($user['alamat']); ?>" class="w-full border border-pink-200 p-3 rounded-full" placeholder="🏠 Alamat Anda">
                <input type="password" name="password" placeholder="🔑 Password baru (opsional)" class="w-full border border-pink-200 p-3 rounded-full">
                <button type="submit" name="update" class="w-full bg-pink-400 text-white px-6 py-3 rounded-full hover:bg-pink-500 shadow-md">
                    💾 Simpan Perubahan
                </button>
            </form>
        </div>

        <!-- Riwayat Transaksi -->
        <div class="bg-white p-6 rounded-3xl shadow-lg border-2 border-blue-200">
            <h2 class="text-2xl font-semibold mb-4 text-blue-600">🛍️ Riwayat Transaksi</h2>
            <?php if (mysqli_num_rows($transaksi) > 0) { ?>
<table class="w-full border-collapse bg-blue-50 rounded-2xl overflow-hidden">
    <thead>
        <tr class="bg-gradient-to-r from-blue-300 to-pink-300 text-white">
            <th class="p-3">📅 Tanggal</th>
            <th class="p-3">🎁 Produk</th>
            <th class="p-3">🔢 Jumlah</th>
            <th class="p-3">💰 Total</th>
            <th class="p-3">📌 Status</th>
            <th class="p-3">🧾 Nota</th> <!-- Tambahan -->
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($transaksi)) { ?>
            <tr class="text-center hover:bg-pink-100 transition">
                <td class="p-3"><?php echo htmlspecialchars($row['tanggal'] ?? ''); ?></td>
                <td class="p-3"><?php echo htmlspecialchars($row['produk'] ?? ''); ?></td>
                <td class="p-3"><?php echo htmlspecialchars($row['jumlah'] ?? ''); ?></td>
                <td class="p-3">Rp <?php echo number_format($row['total'], 0, ',', '.'); ?></td>
                <td class="p-3"><?php echo htmlspecialchars($row['status'] ?? ''); ?></td>
                <td class="p-3">
                    <a href="nota.php?id=<?php echo $row['id']; ?>" 
                       class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-full shadow">
                       🧾 Cetak
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
           <?php } else { ?>
                <p class="text-pink-600 text-center">🌷 Belum ada transaksi, yuk belanja dulu! ✨</p>
            <?php } ?>
        </div>
    </div>
</body>
</html>

