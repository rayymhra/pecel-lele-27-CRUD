<?php
session_start();
include '../../db.php';
include "../../function.php";

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$order_id = (int) $_GET['id'];

// Get order info
$order_stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
$order_stmt->bind_param("i", $order_id);
$order_stmt->execute();
$order_result = $order_stmt->get_result();
$order = $order_result->fetch_assoc();

if (!$order) {
    echo "Pesanan tidak ditemukan.";
    exit;
}

// Get order details
$detail_stmt = $conn->prepare("
    SELECT od.*, m.nama AS menu_nama, m.harga 
    FROM order_detail od
    JOIN menu m ON od.menu_id = m.id
    WHERE od.pesanan_id = ?
");
$detail_stmt->bind_param("i", $order_id);
$detail_stmt->execute();
$details = $detail_stmt->get_result();
?>

<?php include "../layout/navbar.php"; ?>
<?php include "../layout/sidebar.php"; ?>

<div class="container mt-4">
    <h2>Detail Pesanan</h2>
    <a href="index.php" class="btn btn-secondary mb-3">← Kembali</a>

    <div class="card">
        <div class="card-body">
            <p><strong>Nama Pelanggan:</strong> <?= htmlspecialchars($order['nama_pelanggan']) ?></p>
            <p><strong>Tanggal Pesan:</strong> <?= $order['tanggal_order'] ?></p>
            <p><strong>Total:</strong> Rp<?= number_format($order['total'], 0, ',', '.') ?></p>

            <h5 class="mt-4">Rincian Menu:</h5>
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Menu</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($item = $details->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['menu_nama']) ?></td>
                            <td>Rp<?= number_format($item['harga'], 0, ',', '.') ?></td>
                            <td><?= $item['qty'] ?></td>
                            <td>Rp<?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "../layout/footer.php"; ?>
