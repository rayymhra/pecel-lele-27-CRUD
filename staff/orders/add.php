<?php
session_start();
include '../../db.php';
include "../../function.php";

// Check if staff
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header("Location: ../../auth/login.php");
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $wa = trim($_POST['wa']);
    $pesanan = trim($_POST['pesanan']);

    if (!$nama || !$wa || !$pesanan) {
        $error = "Semua kolom harus diisi.";
    } else {
        $stmt = $conn->prepare("INSERT INTO orders (nama_pelanggan, nomor_whatsapp, pesanan) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nama, $wa, $pesanan);
        if ($stmt->execute()) {
            $success = "Pesanan berhasil ditambahkan.";
        } else {
            $error = "Gagal menambahkan pesanan.";
        }
    }
}

include "../layout/navbar.php";
include "../layout/sidebar.php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Pesanan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <div class="card shadow-sm">
    <div class="card-header bg-warning text-dark fw-bold">
      Tambah Pesanan
    </div>
    <div class="card-body">
      <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>
      <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
      <?php endif; ?>

      <form method="POST">
        <div class="mb-3">
          <label class="form-label">Nama Pelanggan</label>
          <input type="text" name="nama" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Nomor WhatsApp</label>
          <input type="text" name="wa" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Pesanan</label>
          <textarea name="pesanan" rows="4" class="form-control" required></textarea>
        </div>

        <button type="submit" class="btn btn-warning">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
      </form>
    </div>
  </div>
</div>
</body>
</html>
