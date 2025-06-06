<?php
session_start();
include '../../db.php';
include "../../function.php";

// Fetch all menu items
$result = $conn->query("SELECT * FROM menu ORDER BY id DESC");
?>

<?php include "../layout/navbar.php"; ?>
<?php include "../layout/sidebar.php"; ?>

<div class="container mt-4">
    <h2>Daftar Menu</h2>

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Nama Menu</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php $no = 1; ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['nama']) ?></td>
                        <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                        <td><?= $row['stock'] ?></td>
                        <td>
                            <?php if ($row['status'] === 'tersedia'): ?>
                                <span class="badge bg-success">Tersedia</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Habis</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">Tidak ada menu.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include "../layout/footer.php"; ?>
