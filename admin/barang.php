<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
    header('Location: ../public/login.php'); exit;
}
include '../config/db.php';
// Tambah barang
if (isset($_POST['tambah'])) {
    $nama = trim($_POST['nama']);
    $harga = intval($_POST['harga']);
    if ($nama && $harga > 0) {
        $stmt = $conn->prepare("INSERT INTO tb_barang (nama, harga) VALUES (?, ?)");
        $stmt->bind_param('si', $nama, $harga);
        $stmt->execute();
        $stmt->close();
        header('Location: barang.php'); exit;
    } else {
        $err = 'Nama dan harga barang wajib diisi!';
    }
}
// Hapus barang
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    $conn->query("DELETE FROM tb_barang WHERE id=$id");
    header('Location: barang.php'); exit;
}
// Edit barang
if (isset($_POST['edit'])) {
    $id = intval($_POST['id']);
    $nama = trim($_POST['nama']);
    $harga = intval($_POST['harga']);
    if ($nama && $harga > 0) {
        $stmt = $conn->prepare("UPDATE tb_barang SET nama=?, harga=? WHERE id=?");
        $stmt->bind_param('sii', $nama, $harga, $id);
        $stmt->execute();
        $stmt->close();
        header('Location: barang.php'); exit;
    } else {
        $err = 'Nama dan harga barang wajib diisi!';
    }
}
$barang = $conn->query("SELECT * FROM tb_barang ORDER BY nama ASC");
?>
<!DOCTYPE html>
<html lang='id'>
<head>
    <meta charset='UTF-8'>
    <title>Data Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; }
        .container { max-width: 900px; margin: 30px auto; background: #fff; padding: 24px; border-radius: 8px; box-shadow: 0 2px 8px #0001; }
        h1 { margin-top: 0; }
        .card { margin-bottom: 32px; border: 1px solid #eee; border-radius: 6px; background: #f9f9f9; }
        .card-title { background: #eee; padding: 10px 16px; font-weight: bold; border-radius: 6px 6px 0 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 0; }
        th, td { border: 1px solid #ccc; padding: 8px 10px; text-align: left; }
        th { background: #f2f2f2; }
        .btn { padding: 5px 12px; border-radius: 4px; border: none; cursor: pointer; font-size: 14px; }
        .btn-warning { background: #ffc107; color: #222; }
        .btn-danger { background: #dc3545; color: #fff; }
        .btn-primary { background: #007bff; color: #fff; }
        .alert { background: #f8d7da; color: #842029; padding: 10px; border-radius: 4px; margin-bottom: 16px; text-align: center; }
    </style>
</head>
<body>
<a href='dashboard.php' class='btn btn-secondary mt-3 ms-3'>Kembali ke Dashboard</a>
<div class='container'>
    <h1>Data Barang</h1>
    <?php if (!empty($err)): ?>
        <div class='alert'><?= $err ?></div>
    <?php endif; ?>
    <div class='card'>
        <div class='card-title'>Tambah Barang</div>
        <form method='post'>
            <label>Nama Barang</label>
            <input type='text' name='nama' required>
            <label>Harga</label>
            <input type='number' name='harga' min='1' required>
            <button type='submit' name='tambah' class='btn btn-primary'>Tambah</button>
        </form>
    </div>
    <h2>Daftar Barang</h2>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr><th>No</th><th>Nama Barang</th><th>Harga</th><th>Aksi</th></tr>
        </thead>
        <tbody>
        <?php $no=1; while($row = $barang->fetch_assoc()): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= number_format($row['harga'],0,',','.') ?></td>
                <td>
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id'] ?>">Edit</button>
                    <a href='?hapus=<?= $row['id'] ?>' class='btn btn-danger' onclick="return confirm('Hapus barang ini?')">Hapus</a>
                    <!-- Modal Edit -->
                    <div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <form method="post">
                            <div class="modal-header">
                              <h5 class="modal-title">Edit Barang</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                              <input type="hidden" name="id" value="<?= $row['id'] ?>">
                              <div class="mb-3">
                                <label class="form-label">Nama Barang</label>
                                <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($row['nama']) ?>" required>
                              </div>
                              <div class="mb-3">
                                <label class="form-label">Harga</label>
                                <input type="number" name="harga" class="form-control" value="<?= $row['harga'] ?>" min="1" required>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                              <button type="submit" name="edit" class="btn btn-primary">Simpan</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 