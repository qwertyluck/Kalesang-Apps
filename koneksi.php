<?php
// Konfigurasi Database untuk Aplikasi Kalesang Keuangan Satker
$host     = "localhost";
$user     = "root";     // Default username database lokal
$password = "";         // Default password database lokal (biasanya kosong)
$database = "kalesang_satker";

// Membuat koneksi
$koneksi = mysqli_connect($host, $user, $password, $database);

// Cek apakah koneksi berhasil
if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
// Jika berhasil terkoneksi, Anda bisa mengaktifkan baris di bawah ini untuk uji coba (opsional)
// echo "Koneksi database berhasil!";
?>
