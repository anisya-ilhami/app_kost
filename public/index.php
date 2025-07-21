<?php
include '../config/db.php';
function rupiah($angka) {
    return 'Rp ' . number_format($angka, 0, ',', '.');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda Kost</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #fafafa; }
        .navbar {
            background: #222; color: #fff; padding: 12px 24px;
            display: flex; justify-content: space-between; align-items: center;
        }
        .navbar .brand { font-weight: bold; font-size: 20px; color: #fff; text-decoration: none; }
        .navbar .login-btn {
            background: #007bff; color: #fff; border: none; padding: 8px 18px;
            border-radius: 4px; cursor: pointer; text-decoration: none; font-size: 15px;
        }
        .container { max-width: 1000px; margin: 30px auto; background: #fff; padding: 24px; border-radius: 8px; box-shadow: 0 2px 8px #0001; }
        h1 { margin-top: 0; }
        .card { margin-bottom: 32px; border: 1px solid #eee; border-radius: 6px; background: #f9f9f9; }
        .card-title { background: #eee; padding: 10px 16px; font-weight: bold; border-radius: 6px 6px 0 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 0; }
        th, td { border: 1px solid #ccc; padding: 8px 10px; text-align: left; }
        th { background: #f2f2f2; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="index.php" class="brand">Kost Anisya</a>
        <a href="login.php" class="login-btn">Login Admin</a>
    </div>
    <div class="container">
        <h1>Selamat Datang di Kost Anisya</h1>
        <div class="card">
            <div class="card-title">Kamar Kosong</div>
            <table>
                <thead>
                    <tr><th>No</th><th>Nomor Kamar</th><th>Harga Sewa</th></tr>
                </thead>
                <tbody>
                <?php
                $sql = "SELECT * FROM tb_kamar k WHERE k.id NOT IN (SELECT id_kamar FROM tb_kmr_penghuni WHERE tgl_keluar IS NULL)";
                $res = $conn->query($sql);
                $no = 1;
                while ($row = $res->fetch_assoc()): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['nomor']) ?></td>
                        <td><?= rupiah($row['harga']) ?></td>
                    </tr>
                <?php endwhile; if ($res->num_rows == 0): ?>
                    <tr><td colspan="3" class="text-center">Tidak ada kamar kosong.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="card">
            <div class="card-title">Kamar yang Harus Segera Membayar</div>
            <table>
                <thead>
                    <tr><th>No</th><th>Nomor Kamar</th><th>Nama Penghuni</th><th>Tanggal Masuk</th><th>Jatuh Tempo</th></tr>
                </thead>
                <tbody>
                <?php
                $sql = "SELECT k.nomor, p.nama, kp.tgl_masuk, kp.id
                        FROM tb_kmr_penghuni kp
                        JOIN tb_kamar k ON kp.id_kamar = k.id
                        JOIN tb_penghuni p ON kp.id_penghuni = p.id
                        WHERE kp.tgl_keluar IS NULL";
                $res = $conn->query($sql);
                $no = 1;
                $now = date('Y-m-d');
                $found = false;
                while ($row = $res->fetch_assoc()) {
                    $tgl_masuk = $row['tgl_masuk'];
                    $diff = (strtotime($now) - strtotime($tgl_masuk)) / (60*60*24);
                    $bulan_ke = floor($diff / 30) + 1;
                    $jatuh_tempo = date('Y-m-d', strtotime("$tgl_masuk +".($bulan_ke*30)." days"));
                    $selisih = (strtotime($jatuh_tempo) - strtotime($now)) / (60*60*24);
                    if ($selisih >= 0 && $selisih <= 7) {
                        $found = true;
                        echo "<tr><td>{$no}</td><td>".htmlspecialchars($row['nomor'])."</td><td>".htmlspecialchars($row['nama'])."</td><td>{$tgl_masuk}</td><td>{$jatuh_tempo}</td></tr>";
                        $no++;
                    }
                }
                if (!$found) echo '<tr><td colspan="5" class="text-center">Tidak ada kamar yang harus segera membayar.</td></tr>';
                ?>
                </tbody>
            </table>
        </div>
        <div class="card">
            <div class="card-title">Kamar yang Terlambat Bayar</div>
            <table>
                <thead>
                    <tr><th>No</th><th>Nomor Kamar</th><th>Nama Penghuni</th><th>Jatuh Tempo</th><th>Status</th></tr>
                </thead>
                <tbody>
                <?php
                $sql = "SELECT k.nomor, p.nama, kp.tgl_masuk, kp.id
                        FROM tb_kmr_penghuni kp
                        JOIN tb_kamar k ON kp.id_kamar = k.id
                        JOIN tb_penghuni p ON kp.id_penghuni = p.id
                        WHERE kp.tgl_keluar IS NULL";
                $res = $conn->query($sql);
                $no = 1;
                $now = date('Y-m-d');
                $found = false;
                while ($row = $res->fetch_assoc()) {
                    $tgl_masuk = $row['tgl_masuk'];
                    $diff = (strtotime($now) - strtotime($tgl_masuk)) / (60*60*24);
                    $bulan_ke = floor($diff / 30) + 1;
                    $jatuh_tempo = date('Y-m-d', strtotime("$tgl_masuk +".($bulan_ke*30)." days"));
                    if (strtotime($now) > strtotime($jatuh_tempo)) {
                        $found = true;
                        echo "<tr><td>{$no}</td><td>".htmlspecialchars($row['nomor'])."</td><td>".htmlspecialchars($row['nama'])."</td><td>{$jatuh_tempo}</td><td>Terlambat</td></tr>";
                        $no++;
                    }
                }
                if (!$found) echo '<tr><td colspan="5" class="text-center">Tidak ada kamar yang terlambat bayar.</td></tr>';
                ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html> 