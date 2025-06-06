<?php
session_start();
include '../../db.php';
include "../../function.php";


// Only allow staff
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header("Location: ../../auth/login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

if (!$order) {
    echo "Pesanan tidak ditemukan.";
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];
    $pesanan = $_POST['pesanan'];

    $updateStmt = $conn->prepare("UPDATE orders SET status = ?, pesanan = ? WHERE id = ?");
    $updateStmt->bind_param("ssi", $status, $pesanan, $id);
    if ($updateStmt->execute()) {
        $success = "Pesanan berhasil diperbarui.";
        // Refresh data
        $stmt->execute();
        $order = $stmt->get_result()->fetch_assoc();
    } else {
        $error = "Gagal memperbarui pesanan.";
    }
}

include "../layout/navbar.php";
include "../layout/sidebar.php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-warning fw-bold">Edit Pesanan</div>
        <div class="card-body">
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <p><strong>Nama:</strong> <?= htmlspecialchars($order['nama_pelanggan']) ?></p>
            <p><strong>No. WhatsApp:</strong> <?= htmlspecialchars($order['nomor_whatsapp']) ?></p>
            <p><strong>Pesanan:</strong><br><?= nl2br(htmlspecialchars($order['pesanan'])) ?></p>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="pending" <?= $order['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="diproses" <?= $order['status'] === 'diproses' ? 'selected' : '' ?>>Diproses</option>
                        <option value="selesai" <?= $order['status'] === 'selesai' ? 'selected' : '' ?>>Selesai</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">pesanan</label>
                    <textarea name="pesanan" rows="3" class="form-control"><?= htmlspecialchars($order['pesanan']) ?></textarea>
                </div>

                <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                <a href="index.php" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
