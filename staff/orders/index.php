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

  <div class="container mt-5">
    
        <h2 class="fw-bold mb-4">
            Daftar Pesanan
        </h2>
        
            <div class="mb-3 d-flex flex-wrap gap-2">
                <a href="add.php" class="btn btn-warning">
                    <i class="bi bi-plus-circle"></i> Tambah Pesanan
                </a>
                <a href="export_orders_excel.php" class="btn btn-success">
                    <i class="bi bi-file-earmark-excel-fill"></i> Export Pesanan ke Excel
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-warning">
                        <tr>
                            <th>No</th>
                            <th>Nama Pelanggan</th>
                            <th>Total</th>
                            <th>Tanggal</th>
                            <th>Status</th>
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
                                        <?php if ($order['status'] == 'pending'): ?>
                                            <span class="badge bg-secondary">Pending</span>
                                        <?php elseif ($order['status'] == 'selesai'): ?>
                                            <span class="badge bg-success">Selesai</span>
                                        <?php else: ?>
                                            <span class="badge bg-dark"><?= $order['status'] ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            <a href="view.php?id=<?= $order['id'] ?>" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i> Lihat
                                            </a>
                                            <a href="edit.php?id=<?= $order['id'] ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>
                                            <a href="delete.php?id=<?= $order['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus pesanan ini?')">
                                                <i class="bi bi-trash"></i> Hapus
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">Belum ada pesanan</td>
                            </tr>
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
