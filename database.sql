-- Membuat Database Kalesang Satker
CREATE DATABASE IF NOT EXISTS kalesang_satker;
USE kalesang_satker;

-- 1. Tabel Master Akun (MAK)
CREATE TABLE master_akun_mak (
    id_mak INT AUTO_INCREMENT PRIMARY KEY,
    kode_mak VARCHAR(50) NOT NULL,
    uraian_mak VARCHAR(255) NOT NULL,
    pagu_anggaran DECIMAL(15, 2) DEFAULT 0.00,
    tahun_anggaran YEAR NOT NULL
);

-- 2. Tabel Master Rekanan / Vendor
CREATE TABLE master_rekanan (
    id_rekanan INT AUTO_INCREMENT PRIMARY KEY,
    nama_rekanan VARCHAR(150) NOT NULL,
    npwp VARCHAR(30),
    informasi_bank VARCHAR(100)
);

-- 3. Tabel Transaksi / Shadow BKU
CREATE TABLE bku_transaksi (
    id_transaksi INT AUTO_INCREMENT PRIMARY KEY,
    tanggal DATE NOT NULL,
    no_bukti VARCHAR(100),
    id_mak INT,
    id_rekanan INT,
    uraian TEXT NOT NULL,
    debet DECIMAL(15, 2) DEFAULT 0.00,
    kredit DECIMAL(15, 2) DEFAULT 0.00,
    jenis_buku ENUM('Kas', 'Bank', 'Pajak', 'Panjar') NOT NULL,
    file_bukti VARCHAR(255),
    FOREIGN KEY (id_mak) REFERENCES master_akun_mak(id_mak),
    FOREIGN KEY (id_rekanan) REFERENCES master_rekanan(id_rekanan)
);

-- 4. Tabel Monitoring Tagihan (SPP, SPM, SP2D)
CREATE TABLE monitoring_spp_spm (
    id_tagihan INT AUTO_INCREMENT PRIMARY KEY,
    id_transaksi INT,
    uraian_tagihan TEXT,
    nilai_tagihan DECIMAL(15, 2) NOT NULL,
    no_spp VARCHAR(100),
    tgl_spp DATE,
    no_spm VARCHAR(100),
    tgl_spm DATE,
    no_sp2d VARCHAR(100),
    status ENUM('Draft', 'Verifikasi', 'SPP', 'SPM', 'SP2D') DEFAULT 'Draft',
    FOREIGN KEY (id_transaksi) REFERENCES bku_transaksi(id_transaksi)
);

-- 5. Tabel Log Aset & Persediaan
CREATE TABLE log_aset_persediaan (
    id_aset INT AUTO_INCREMENT PRIMARY KEY,
    id_transaksi INT,
    kode_siman VARCHAR(50),
    nama_barang VARCHAR(255) NOT NULL,
    volume INT NOT NULL,
    harga_satuan DECIMAL(15, 2) NOT NULL,
    pic_penerima VARCHAR(100),
    FOREIGN KEY (id_transaksi) REFERENCES bku_transaksi(id_transaksi)
);
