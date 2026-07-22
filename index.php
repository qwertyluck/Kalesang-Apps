<?php
// Memanggil file koneksi cloud database
include "koneksi.php";

// Fungsi sederhana untuk mengambil total data atau menghitung ringkasan
// (Kita buat aman dengan pengecekan koneksi terlebih dahulu)
$total_transaksi = 0;
if ($koneksi) {
    $query_cek = pg_query($koneksi, "SELECT COUNT(*) as total FROM bku_transaksi");
    if ($query_cek) {
        $data = pg_fetch_assoc($query_cek);
        $total_transaksi = $data['total'];
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Kalesang Keuangan Satker</title>
    <!-- Menggunakan Bootstrap CSS agar tampilan langsung rapi dan profesional -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Navbar Atas -->
    <nav class="navbar navbar-dark bg-dark shadow-sm">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">🛡️ Kalesang-Apps: Keuangan Satker</span>
            <span class="text-white-50 small">Status Cloud Database: <strong class="text-success">Terhubung</strong></span>
        </div>
    </nav>

    <!-- Konten Utama Dashboard -->
    <div class="container my-5">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="p-4 bg-white rounded shadow-sm border-start border-primary border-4">
                    <h2 class="fw-bold text-dark">Selamat Datang, Bendahara!</h2>
                    <p class="text-muted mb-0">Sistem pembukuan bayangan (*shadow BKU*), monitoring, dan mitigasi risiko anggaran satuan kerja yang terintegrasi secara aman di cloud.</p>
                </div>
            </div>
        </div>

        <!-- Kartu Statistik / Ringkasan Cepat -->
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-white h-100">
                    <div class="card-body">
                        <h6 class="text-muted text-uppercase small fw-bold">Total Transaksi Tercatat</h6>
                        <h3 class="fw-bold text-primary mt-2"><?php echo $total_transaksi; ?> <span class="fs-6 text-muted">Data</span></h3>
                        <p class="small text-muted mb-0">Jumlah entri kuitansi/pengeluaran di shadow BKU.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-white h-100">
                    <div class="card-body">
                        <h6 class="text-muted text-uppercase small fw-bold">Monitoring Tagihan</h6>
                        <h3 class="fw-bold text-success mt-2">Aktif</h3>
                        <p class="small text-muted mb-0">Pelacakan dokumen SPP, SPM, dan SP2D.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-white h-100">
                    <div class="card-body">
                        <h6 class="text-muted text-uppercase small fw-bold">Keamanan & Backup</h6>
                        <h3 class="fw-bold text-info mt-2">Cloud Synced</h3>
                        <p class="small text-muted mb-0">Data terlindungi dan aman dari kerusakan hardware.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu Pintasan / Navigasi Selanjutnya -->
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">Navigasi Modul Utama</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">Pilih modul di bawah ini untuk mulai mengelola administrasi keuangan Anda:</p>
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="#" class="btn btn-outline-primary">➕ Input Transaksi Baru</a>
                            <a href="test_koneksi.php" target="_blank" class="btn btn-outline-secondary">🔍 Cek Status Tabel Database</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center py-4 text-muted small">
        <p>&copy; 2026 Kalesang-Apps. Dirancang khusus untuk ketertiban administrasi keuangan Satker.</p>
    </footer>

</body>
</html>
