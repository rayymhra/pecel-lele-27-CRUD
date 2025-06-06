<?php
session_start();
include '../../db.php';
include "../../function.php";

// 1) Check login + role
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit;
}
if ($_SESSION['role'] !== 'staff') {
    // If admin lands here by mistake, you could redirect them back to admin dashboard:
    header("Location: ../../admin/index.php");
    exit;
}

// 2) Fetch all orders
$result = $conn->query("SELECT * FROM orders ORDER BY tanggal_order DESC");

$orders = $conn->query("SELECT * FROM orders ORDER BY tanggal_order DESC");

include "../layout/navbar.php";
include "../layout/sidebar.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Kelola Pesanan - Staff</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7"
    crossorigin="anonymous"
  />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
  />
</head>
<body>

  <div class="container mt-4">
    <h2>Daftar Pesanan</h2>
    <a href="add.php" class="btn btn-primary mb-3">+ Tambah Pesanan</a>

    <table class="table table-bordered table-striped">
        <thead class="table-warning">
            <tr>
                <th>No</th>
                <th>Nama Pelanggan</th>
                <th>Total</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($orders->num_rows > 0): ?>
                <?php $no = 1; ?>
                <?php while ($order = $orders->fetch_assoc()): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($order['nama_pelanggan']) ?></td>
                        <td>Rp<?= number_format($order['total'], 0, ',', '.') ?></td>
                        <td><?= $order['tanggal_order'] ?></td>
                        <td>
                            <a href="view.php?id=<?= $order['id'] ?>" class="btn btn-sm btn-info">Lihat</a>
                            <a href="delete.php?id=<?= $order['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus pesanan ini?')">Hapus</a>
                            <a href="edit.php?id=<?= $order['id'] ?>" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5" class="text-center">Belum ada pesanan</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
    crossorigin="anonymous"
  ></script>
</body>
</html>
