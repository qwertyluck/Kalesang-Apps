<?php
// Memanggil file koneksi cloud database
include "koneksi.php";

// Mengambil seluruh data transaksi dari cloud database Supabase diurutkan dari yang terbaru
$query = "SELECT t.*, m.kode_mak, r.nama_rekanan 
          FROM bku_transaksi t 
          LEFT JOIN master_akun_mak m ON t.id_mak = m.id_mak 
          LEFT JOIN master_rekanan r ON t.id_rekanan = r.id_rekanan 
          ORDER BY t.tanggal DESC, t.id_transaksi DESC";

$result = pg_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Transaksi - Kalesang-Apps</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Navbar Atas -->
    <nav class="navbar navbar-dark bg-dark shadow-sm">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">🛡️ Kalesang-Apps: Rekapitulasi Shadow BKU</span>
            <div>
                <a href="tambah_transaksi.php" class="btn btn-success btn-sm">➕ Tambah Transaksi</a>
                <a href="index.php" class="btn btn-outline-light btn-sm">Dashboard</a>
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <div class="container my-5">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold text-dark">Daftar Transaksi Keseluruhan</h2>
                        <p class="text-muted mb-0">Menampilkan seluruh catatan pembukuan bayangan yang tersimpan aman di cloud.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Data -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>No. Bukti</th>
                                <th>Jenis Buku</th>
                                <th>Uraian / Keterangan</th>
                                <th>Debet (Rp)</th>
                                <th>Kredit (Rp)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result && pg_num_rows($result) > 0): ?>
                                <?php $no = 1; while ($row = pg_fetch_assoc($result)): ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($row['tanggal'])); ?></td>
                                        <td><span class="badge bg-secondary"><?php echo htmlspecialchars($row['no_bukti'] ?? '-'); ?></span></td>
                                        <td><span class="badge bg-info text-dark"><?php echo $row['jenis_buku']; ?></span></td>
                                        <td><?php echo htmlspecialchars($row['uraian']); ?></td>
                                        <td class="text-success fw-bold"><?php echo number_format($row['debet'], 2, ',', '.'); ?></td>
                                        <td class="text-danger fw-bold"><?php echo number_format($row['kredit'], 2, ',', '.'); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">Belum ada data transaksi yang tercatat di cloud database.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center py-4 text-muted small">
        <p>&copy; 2026 Kalesang-Apps. Terhubung secara real-time dengan Supabase Cloud.</p>
    </footer>

</body>
</html>
