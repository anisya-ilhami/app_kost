<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
    header('Location: ../public/login.php'); exit;
}
include '../config/db.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Admin Kost</a>
  </div>
</nav>
<div class="container">
    <h1 class="mb-4">Dashboard Admin</h1>
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Kamar</h5>
                    <p class="card-text display-6">
                        <?php $r = $conn->query("SELECT COUNT(*) as jml FROM tb_kamar"); $d = $r->fetch_assoc(); echo $d['jml']; ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Penghuni</h5>
                    <p class="card-text display-6">
                        <?php $r = $conn->query("SELECT COUNT(*) as jml FROM tb_penghuni WHERE tgl_keluar IS NULL"); $d = $r->fetch_assoc(); echo $d['jml']; ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Kamar Kosong</h5>
                    <p class="card-text display-6">
                        <?php $r = $conn->query("SELECT COUNT(*) as jml FROM tb_kamar WHERE id NOT IN (SELECT id_kamar FROM tb_kmr_penghuni WHERE tgl_keluar IS NULL)"); $d = $r->fetch_assoc(); echo $d['jml']; ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-danger mb-3">
                <div class="card-body">
                    <h5 class="card-title">Tagihan Belum Lunas</h5>
                    <p class="card-text display-6">
                        <?php $r = $conn->query("SELECT COUNT(*) as jml FROM tb_tagihan t LEFT JOIN tb_bayar b ON t.id = b.id_tagihan WHERE b.status IS NULL OR b.status != 'lunas'"); $d = $r->fetch_assoc(); echo $d['jml']; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <a href="kamar.php" class="btn btn-primary">Kelola Data Kamar</a>
            <a href="penghuni.php" class="btn btn-success">Kelola Data Penghuni</a>
            <a href="barang.php" class="btn btn-warning">Kelola Data Barang</a>
            <a href="tagihan.php" class="btn btn-danger">Kelola Tagihan</a>
            <a href="pembayaran.php" class="btn btn-info">Kelola Pembayaran</a>
        </div>
    </div>
</div>
</body>
</html> 