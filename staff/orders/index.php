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
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2 class="fw-bold">Daftar Pesanan</h2>
      <a href="add.php" class="btn btn-warning">
     Tambah Pesanan
  </a>
    </div>

    <?php if (isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
  <div class="alert alert-success">Pesanan berhasil dihapus.</div>
<?php elseif (isset($_GET['msg']) && $_GET['msg'] === 'notfound'): ?>
  <div class="alert alert-warning">Pesanan tidak ditemukan.</div>
<?php endif; ?>


    <div class="table-responsive">
      <table class="table table-bordered table-striped align-middle shadow-sm">
        <thead class="table-warning text-dark">
          <tr>
            <th scope="col">No</th>
            <th scope="col">Nama Pelanggan</th>
            <th scope="col">No. WhatsApp</th>
            <th scope="col">Pesanan</th>
            <th scope="col">Tanggal</th>
            <th scope="col">Status</th>
            <th scope="col" style="width: 170px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          while ($row = $result->fetch_assoc()):
              // Prepare a badge class based on status
              switch ($row['status']) {
                  case 'pending':
                      $badge = 'bg-secondary';
                      break;
                  case 'diproses':
                      $badge = 'bg-warning text-dark';
                      break;
                  case 'selesai':
                      $badge = 'bg-success';
                      break;
                  case 'dibatalkan':
                      $badge = 'bg-danger';
                      break;
                  default:
                      $badge = 'bg-secondary';
              }
          ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row['nama_pelanggan']) ?></td>
            <td>
              <a href="https://wa.me/<?= htmlspecialchars($row['nomor_whatsapp']) ?>" target="_blank" class="text-decoration-none">
                <i class="bi bi-whatsapp text-success"></i>
                <?= htmlspecialchars($row['nomor_whatsapp']) ?>
              </a>
            </td>
            <td style="white-space: pre-line;"><?= nl2br(htmlspecialchars($row['pesanan'])) ?></td>
            <td><?= date('d/m/Y H:i', strtotime($row['tanggal_order'])) ?></td>
            <td>
              <span class="badge <?= $badge ?> text-capitalize">
                <?= htmlspecialchars($row['status']) ?>
              </span>
            </td>
            <td>
              <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary me-1">
                <i class="bi bi-pencil-square"></i> Ubah
              </a>
              <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger" 
                 onclick="return confirm('Yakin ingin menghapus pesanan ini?')">
                <i class="bi bi-trash"></i> Hapus
              </a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>

  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
    crossorigin="anonymous"
  ></script>
</body>
</html>
