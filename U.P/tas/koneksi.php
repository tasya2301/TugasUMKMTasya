<?php
// Konfigurasi database
$host = 'localhost'; 
$user = 'root'; 
$password = ''; 
$dbname = 'db_tokotasya'; 

// Membuat koneksi (procedural)
$conn = mysqli_connect($host, $user, $password, $dbname);

// Memeriksa koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
