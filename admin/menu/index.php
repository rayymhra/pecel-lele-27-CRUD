<?php
include '../../auth/check.php';
include '../../db.php';
include "../../function.php";

// Get menu with category name
$result = $conn->query("SELECT menu.*, categories.name AS category_name 
                        FROM menu 
                        LEFT JOIN categories ON menu.category_id = categories.id");

include "../layout/navbar.php";
include "../layout/sidebar.php";
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold">Daftar Menu</h2>
        <a href="add.php" class="btn btn-warning text-dark fw-semibold">
            Tambah Menu
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered align-middle table-striped">
            <thead class="table-warning">
                <tr>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Deskripsi</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Status</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nama']) ?></td>
                        <td><?= htmlspecialchars($row['category_name'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                        <td>Rp<?= number_format($row['harga'], 0, ',', '.') ?></td>
                        <td><?= (int)$row['stock'] ?></td>
                        <td>
                            <?php if ($row['status'] === 'tersedia'): ?>
                                <span class="badge bg-success">Tersedia</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Habis</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($row['gambar']): ?>
                                <img src="../../uploads/<?= $row['gambar'] ?>" width="100" alt="gambar menu">
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin hapus?')">
                                <i class="bi bi-trash"></i> Hapus
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include "../layout/footer.php" ?>
