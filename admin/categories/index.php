<?php
session_start();
include '../../db.php';
include "../../function.php";

// Fetch all categories
$result = $conn->query("SELECT * FROM categories ORDER BY id DESC");
?>

<?php include "../layout/navbar.php"; ?>
<?php include "../layout/sidebar.php"; ?>

<div class="container mt-5">
            

    
        <h2 class="fw-bold">Daftar Kategori</h2>
        <a href="add.php" class="btn btn-warning my-3">Tambah Kategori</a>
        
            <table class="table table-striped">
                <thead class="table-warning">
                    <tr>
                        <th>#</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th class="text-center">Aksi</th>
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
                            <td class="text-center">
                                <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning text-dark">Edit</a>
                                <a href="delete.php?id=<?= $row['id'] ?>" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Yakin ingin menghapus kategori ini?')">
                                   Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        

</div>


<?php include "../layout/footer.php"; ?>
