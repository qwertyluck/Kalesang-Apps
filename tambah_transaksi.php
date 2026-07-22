<?php
// Memanggil file koneksi cloud database
include "koneksi.php";

$pesan_sukses = "";
$pesan_error = "";

// Jika form dikirimkan (tombol simpan ditekan)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tanggal     = $_POST['tanggal'];
    $no_bukti    = $_POST['no_bukti'];
    $jenis_buku  = $_POST['jenis_buku'];
    $id_mak      = !empty($_POST['id_mak']) ? $_POST['id_mak'] : "NULL";
    $id_rekanan  = !empty($_POST['id_rekanan']) ? $_POST['id_rekanan'] : "NULL";
    $uraian      = $_POST['uraian'];
    $debet       = !empty($_POST['debet']) ? $_POST['debet'] : 0;
    $kredit      = !empty($_POST['kredit']) ? $_POST['kredit'] : 0;
    $file_bukti  = $_POST['file_bukti'];

    // Query untuk menyimpan data ke PostgreSQL Supabase
    $query_insert = "INSERT INTO bku_transaksi (tanggal, no_bukti, id_mak, id_rekanan, uraian, debet, kredit, jenis_buku, file_bukti) 
                     VALUES ('$tanggal', '$no_bukti', $id_mak, $id_rekanan, '$uraian', $debet, $kredit, '$jenis_buku', '$file_bukti')";
    
    $result = pg_query($koneksi, $query_insert);

    if ($result) {
        $pesan_sukses = "Data transaksi berhasil disimpan ke cloud database!";
    } else {
        $pesan_error = "Gagal menyimpan data: " . pg_last_error($koneksi);
    }
}

// Ambil data MAK untuk pilihan dropdown (jika sudah diisi nanti)
$list_mak = pg_query($koneksi, "SELECT * FROM master_akun_mak");
// Ambil data Rekanan untuk pilihan dropdown
$list_rekanan = pg_query($koneksi, "SELECT * FROM master_rekanan");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Transaksi - Kalesang-Apps</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Navbar Atas -->
    <nav class="navbar navbar-dark bg-dark shadow-sm">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">🛡️ Kalesang-Apps: Input Transaksi Shadow BKU</span>
            <a href="index.php" class="btn btn-outline-light btn-sm">← Kembali ke Dashboard</a>
        </div>
    </nav>

    <!-- Konten Form -->
    <div class="container my-5" style="max-width: 800px;">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h4 class="mb-0 fw-bold text-dark">Form Pencatatan Transaksi Baru</h4>
                <p class="text-muted small mb-0">Catat transaksi pengeluaran atau penerimaan harian Anda ke dalam sistem pembukuan bayangan.</p>
            </div>
            <div class="card-body p-4">

                <!-- Notifikasi Pesan -->
                <?php if (!empty($pesan_sukses)): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $pesan_sukses; ?> <a href="index.php" class="alert-link">Kembali ke Dashboard</a>
                    </div>
                <?php endif; ?>

                <?php if (!empty($pesan_error)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $pesan_error; ?>
                    </div>
                <?php endif; ?>

                <!-- Form HTML -->
                <form action="" method="POST">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="tanggal" class="form-label fw-bold">Tanggal Transaksi <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" required value="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="no_bukti" class="form-label fw-bold">Nomor Bukti / Kuitansi</label>
                            <input type="text" class="form-control" id="no_bukti" name="no_bukti" placeholder="Contoh: KWT-001/2026">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="jenis_buku" class="form-label fw-bold">Jenis Buku <span class="text-danger">*</span></label>
                            <select class="form-select" id="jenis_buku" name="jenis_buku" required>
                                <option value="Kas">Buku Kas Tunai</option>
                                <option value="Bank">Buku Bank</option>
                                <option value="Pajak">Buku Pajak</option>
                                <option value="Panjar">Buku Panjar</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="id_mak" class="form-label fw-bold">Kode MAK (Akun Belanja)</label>
                            <select class="form-select" id="id_mak" name="id_mak">
                                <option value="">-- Pilih MAK (Opsional) --</option>
                                <?php if ($list_mak && pg_num_rows($list_mak) > 0): ?>
                                    <?php while ($row = pg_fetch_assoc($list_mak)): ?>
                                        <option value="<?php echo $row['id_mak']; ?>"><?php echo $row['kode_mak'] . ' - ' . $row['uraian_mak']; ?></option>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                            </select>
                            <div class="form-text small">Belum ada data MAK? Bisa dikosongkan dulu.</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="uraian" class="form-label fw-bold">Uraian / Keterangan Pembayaran <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="uraian" name="uraian" rows="3" required placeholder="Tuliskan keperluan belanja atau rincian transaksi..."></textarea>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="debet" class="form-label fw-bold">Debet (Uang Masuk / Penerimaan)</label>
                            <input type="number" step="0.01" class="form-control" id="debet" name="debet" value="0.00">
                        </div>
                        <div class="col-md-6">
                            <label for="kredit" class="form-label fw-bold">Kredit (Uang Keluar / Belanja)</label>
                            <input type="number" step="0.01" class="form-control" id="kredit" name="kredit" value="0.00">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="file_bukti" class="form-label fw-bold">Keterangan / Link File Bukti Dukung</label>
                        <input type="text" class="form-control" id="file_bukti" name="file_bukti" placeholder="Nama file scan atau catatan arsip fisik">
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">💾 Simpan Transaksi ke Cloud</button>
                        <a href="index.php" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <footer class="text-center py-4 text-muted small">
        <p>&copy; 2026 Kalesang-Apps. Keamanan data terjamin di cloud Supabase.</p>
    </footer>

</body>
</html>
