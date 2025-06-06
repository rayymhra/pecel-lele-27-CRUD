<?php
session_start();
include '../../db.php';
include "../../function.php";

$menus = $conn->query("SELECT * FROM menu WHERE status = 'tersedia' AND stock > 0");
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_name = $_POST['customer_name'];
    $menu_ids = $_POST['menu_id'];
    $quantities = $_POST['quantity'];

    $total = 0;
    $details = [];

    foreach ($menu_ids as $index => $menu_id) {
        $menu_stmt = $conn->prepare("SELECT nama, harga, stock FROM menu WHERE id = ?");
        $menu_stmt->bind_param("i", $menu_id);
        $menu_stmt->execute();
        $menu_result = $menu_stmt->get_result();
        $menu = $menu_result->fetch_assoc();

        $qty = (int) $quantities[$index];
        if ($qty <= 0 || $qty > $menu['stock']) {
            $error = "Jumlah tidak valid untuk menu: " . htmlspecialchars($menu['nama']);
            break;
        }

        $subtotal = $menu['harga'] * $qty;
        $total += $subtotal;

        $details[] = [
            'menu_id' => $menu_id,
            'quantity' => $qty,
            'subtotal' => $subtotal
        ];
    }

    if (!$error) {
        // Insert into orders
        $stmt = $conn->prepare("INSERT INTO orders (nama_pelanggan, total) VALUES (?, ?)");
        $stmt->bind_param("sd", $customer_name, $total);
        $stmt->execute();
        $order_id = $stmt->insert_id;

        // Insert order details + update stock
        foreach ($details as $item) {
            $stmt_detail = $conn->prepare("INSERT INTO order_detail (pesanan_id, menu_id, qty, subtotal) VALUES (?, ?, ?, ?)");
            $stmt_detail->bind_param("iiid", $order_id, $item['menu_id'], $item['quantity'], $item['subtotal']);
            $stmt_detail->execute();

            $update_stock = $conn->prepare("UPDATE menu SET stock = stock - ? WHERE id = ?");
            $update_stock->bind_param("ii", $item['quantity'], $item['menu_id']);
            $update_stock->execute();
        }

        $success = "Pesanan berhasil disimpan.";
    }
}
?>

<?php include "../layout/navbar.php"; ?>
<?php include "../layout/sidebar.php"; ?>

<div class="container mt-5">
    <div class="card border-warning shadow">
        <div class="card-header bg-warning text-dark fw-bold">
            Tambah Pesanan
        </div>
        <div class="card-body">
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php elseif ($success): ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Nama Pelanggan</label>
                    <input type="text" name="customer_name" class="form-control" required>
                </div>

                <label class="form-label">Daftar Menu</label>
                <div id="menu-list">
                    <div class="menu-item row g-2 mb-2">
                        <div class="col-md-6">
                            <select name="menu_id[]" class="form-select" required>
                                <option value="">-- Pilih Menu --</option>
                                <?php while ($row = $menus->fetch_assoc()): ?>
                                    <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['nama']) ?> (stock: <?= $row['stock'] ?>)</option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="number" name="quantity[]" class="form-control" min="1" placeholder="Jumlah" required>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger btn-remove w-100">×</button>
                        </div>
                    </div>
                </div>

                <button type="button" id="add-menu" class="btn btn-warning">+ Tambah Menu</button>
                <div class="mt-5">
                    <button type="submit" class="btn btn-outline-success">Simpan Pesanan</button>
                    <a href="index.php" class="btn btn-secondary ms-1">Kembali</a>
                </div>
                
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
