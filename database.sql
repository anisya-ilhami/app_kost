-- Buat database
CREATE DATABASE IF NOT EXISTS db_kostanisya;
USE db_kostanisya;

-- Tabel penghuni
CREATE TABLE tb_penghuni (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    no_ktp VARCHAR(30) NOT NULL,
    no_hp VARCHAR(20) NOT NULL,
    tgl_masuk DATE NOT NULL,
    tgl_keluar DATE DEFAULT NULL
);

-- Tabel kamar
CREATE TABLE tb_kamar (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nomor VARCHAR(10) NOT NULL,
    harga INT NOT NULL
);

-- Tabel barang tambahan
CREATE TABLE tb_barang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    harga INT NOT NULL
);

-- Relasi kamar-penghuni
CREATE TABLE tb_kmr_penghuni (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_kamar INT NOT NULL,
    id_penghuni INT NOT NULL,
    tgl_masuk DATE NOT NULL,
    tgl_keluar DATE DEFAULT NULL,
    FOREIGN KEY (id_kamar) REFERENCES tb_kamar(id),
    FOREIGN KEY (id_penghuni) REFERENCES tb_penghuni(id)
);

-- Barang bawaan penghuni
CREATE TABLE tb_brng_bawaan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_barang INT NOT NULL,
    id_penghuni INT NOT NULL,
    FOREIGN KEY (id_barang) REFERENCES tb_barang(id),
    FOREIGN KEY (id_penghuni) REFERENCES tb_penghuni(id)
);

-- Tagihan bulanan
CREATE TABLE tb_tagihan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bulan VARCHAR(7) NOT NULL, -- format YYYY-MM
    id_kmr_penghuni INT NOT NULL,
    jumlah INT NOT NULL,
    FOREIGN KEY (id_kmr_penghuni) REFERENCES tb_kmr_penghuni(id)
);

-- Pembayaran
CREATE TABLE tb_bayar (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_tagihan INT NOT NULL,
    jumlah_bayar INT NOT NULL,
    status ENUM('lunas','cicil') NOT NULL,
    FOREIGN KEY (id_tagihan) REFERENCES tb_tagihan(id)
); 