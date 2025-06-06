<?php
include '../../auth/check.php';
include '../../db.php';
include "../../function.php";


include '../layout/navbar.php';
include '../layout/sidebar.php';

$result = $conn->query("SELECT * FROM users");
?>

<div class="container mt-4">
    <h2 class="fw-bold mb-4">Daftar Users</h2>
    <a href="add.php" class="btn btn-warning mb-3 text-dark fw-semibold">
        Tambah Users
    </a>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-warning text-dark">
    <tr>
        <th>Username</th>
        <th>Role</th>
        <th style="width: 170px;">Aksi</th>
    </tr>
</thead>
<tbody>
    <?php while ($row = $result->fetch_assoc()) : ?>
        <tr>
            <td><?= htmlspecialchars($row['username']) ?></td>
            <td><?= htmlspecialchars($row['role']) ?></td>
            
                      <td>
                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary me-1">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <a href="delete.php?id=<?= $row['id'] ?>" 
                               onclick="return confirm('Yakin ingin menghapus?')" 
                               class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i> Hapus
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../layout/footer.php'; ?>