<?php
session_start();
include '../../db.php';
include "../../function.php";

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$order_id = (int) $_GET['id'];
$error = '';
$success = '';

// Fetch available menus
$menus = $conn->query("SELECT * FROM menu WHERE status = 'tersedia'");

// Get current order info
$order_stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
$order_stmt->bind_param("i", $order_id);
$order_stmt->execute();
$order_result = $order_stmt->get_result();
$order = $order_result->fetch_assoc();

if (!$order) {
    echo "Pesanan tidak ditemukan.";
    exit;
}

// Get existing order details
$detail_stmt = $conn->prepare("SELECT * FROM order_detail WHERE pesanan_id = ?");
$detail_stmt->bind_param("i", $order_id);
$detail_stmt->execute();
$details_result = $detail_stmt->get_result();
$existing_details = [];
while ($row = $details_result->fetch_assoc()) {
    $existing_details[] = $row;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_name = $_POST['customer_name'];
    $status = $_POST['status'];
    $menu_ids = $_POST['menu_id'];
    $quantities = $_POST['quantity'];

    $total = 0;
    $new_details = [];

    // Rollback stock first (restore old quantities)
    foreach ($existing_details as $item) {
        $restore_stock = $conn->prepare("UPDATE menu SET stock = stock + ? WHERE id = ?");
        $restore_stock->bind_param("ii", $item['qty'], $item['menu_id']);
        $restore_stock->execute();
    }

    // Validate and calculate new items
    foreach ($menu_ids as $index => $menu_id) {
        $qty = (int) $quantities[$index];

        $menu_stmt = $conn->prepare("SELECT nama, harga, stock FROM menu WHERE id = ?");
        $menu_stmt->bind_param("i", $menu_id);
        $menu_stmt->execute();
        $menu_result = $menu_stmt->get_result();
        $menu = $menu_result->fetch_assoc();

        if (!$menu || $qty <= 0 || $qty > $menu['stock']) {
            $error = "Jumlah tidak valid untuk menu: " . htmlspecialchars($menu['nama'] ?? '');
            break;
        }

        $subtotal = $menu['harga'] * $qty;
        $total += $subtotal;

        $new_details[] = [
            'menu_id' => $menu_id,
            'quantity' => $qty,
            'subtotal' => $subtotal
        ];
    }

    if (!$error) {
        // Update orders table
        $update_order = $conn->prepare("UPDATE orders SET nama_pelanggan = ?, total = ?, status = ? WHERE id = ?");
        $update_order->bind_param("sdsi", $customer_name, $total, $status, $order_id);

        $update_order->execute();

        // Delete old details
        $conn->query("DELETE FROM order_detail WHERE pesanan_id = $order_id");

        // Insert new details and deduct stock
        foreach ($new_details as $item) {
            $stmt_detail = $conn->prepare("INSERT INTO order_detail (pesanan_id, menu_id, qty, subtotal) VALUES (?, ?, ?, ?)");
            $stmt_detail->bind_param("iiid", $order_id, $item['menu_id'], $item['quantity'], $item['subtotal']);
            $stmt_detail->execute();

            $update_stock = $conn->prepare("UPDATE menu SET stock = stock - ? WHERE id = ?");
            $update_stock->bind_param("ii", $item['quantity'], $item['menu_id']);
            $update_stock->execute();
        }

        $success = "Pesanan berhasil diperbarui.";
    }
}
?>

<?php include "../layout/navbar.php"; ?>
<?php include "../layout/sidebar.php"; ?>

<div class="container mt-5">
    <div class="card border-warning shadow-sm">
        <div class="card-header bg-warning fw-bold">
            Edit Pesanan
        </div>
        <div class="card-body">

            <a href="index.php" class="btn btn-secondary mb-3">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php elseif ($success): ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Pelanggan</label>
                    <input type="text" name="customer_name" class="form-control" required value="<?= htmlspecialchars($order['nama_pelanggan']) ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Status Pesanan</label>
                    <select name="status" class="form-select" required>
                        <option value="pending" <?= $order['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="diproses" <?= $order['status'] === 'diproses' ? 'selected' : '' ?>>Diproses</option>
                        <option value="selesai" <?= $order['status'] === 'selesai' ? 'selected' : '' ?>>Selesai</option>
                        <option value="dibatalkan" <?= $order['status'] === 'dibatalkan' ? 'selected' : '' ?>>Dibatalkan</option>
                    </select>
                </div>

                <div id="menu-list">
                    <?php foreach ($existing_details as $detail): ?>
                        <div class="menu-item row g-2 mb-2">
                            <div class="col-md-6">
                                <select name="menu_id[]" class="form-select" required>
                                    <option value="">-- Pilih Menu --</option>
                                    <?php
                                    $menus->data_seek(0); // Reset pointer
                                    while ($menu = $menus->fetch_assoc()):
                                    ?>
                                        <option value="<?= $menu['id'] ?>" <?= $menu['id'] == $detail['menu_id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($menu['nama']) ?> (stock: <?= $menu['stock'] ?>)
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="number" name="quantity[]" class="form-control" min="1" value="<?= $detail['qty'] ?>" required>
                            </div>
                            <div class="col-md-2 d-flex align-items-start">
                                <button type="button" class="btn btn-danger btn-remove">×</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <button type="button" id="add-menu" class="btn btn-outline-secondary mb-3">
                    + Tambah Menu
                </button><br>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('add-menu').addEventListener('click', function () {
    const list = document.getElementById('menu-list');
    const item = list.querySelector('.menu-item').cloneNode(true);
    item.querySelectorAll('input, select').forEach(input => input.value = '');
    list.appendChild(item);
});

document.addEventListener('click', function (e) {
    if (e.target.classList.contains('btn-remove')) {
        const items = document.querySelectorAll('.menu-item');
        if (items.length > 1) {
            e.target.closest('.menu-item').remove();
        }
    }
});
</script>

<?php include "../layout/footer.php"; ?>
