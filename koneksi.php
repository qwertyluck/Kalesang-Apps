<?php
// Konfigurasi Koneksi Cloud Database (Supabase PostgreSQL)
$host     = "db.tqjwefgddbkpprplysse.supabase.co";
$port     = "5432";
$dbname   = "postgres";
$user     = "postgres";
$password = "MASUKKAN_PASSWORD_SUPABASE_ANDA_DI_SINI"; // Ganti dengan password database Anda

// Membuat string koneksi untuk PostgreSQL
$connection_string = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password}";

// Menghubungkan ke database Supabase
$koneksi = pg_connect($connection_string);

// Cek apakah koneksi berhasil
if (!$koneksi) {
    die("<p style='color: red; font-weight: bold;'>[GAGAL] Gagal terhubung ke Cloud Database Supabase: " . pg_last_error() . "</p>");
} else {
    // Komentar di bawah bisa diaktifkan jika ingin melihat pesan sukses saat uji coba
    // echo "<p style='color: green;'>[SUKSES] Berhasil terhubung ke Cloud Database Supabase!</p>";
}
?>
