<?php
session_start();
include '../../db.php';
include "../../function.php";

// Fetch all categories
$result = $conn->query("SELECT * FROM categories ORDER BY id DESC");
?>

<?php include "../layout/navbar.php"; ?>
<?php include "../layout/sidebar.php"; ?>

<div class="container mt-4">
    <h2>Daftar Kategori</h2>
    <a href="add.php" class="btn btn-primary mb-3">+ Tambah Kategori</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Kategori</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $no++?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= nl2br(htmlspecialchars($row['description'])) ?></td>
                    <td>
                        <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus kategori ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include "../layout/footer.php"; ?>
