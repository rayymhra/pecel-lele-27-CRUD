<?php
include '../../auth/check.php';
include '../../db.php';
include "../../function.php";


$result = $conn->query("SELECT * FROM testimoni ORDER BY id DESC");

include "../layout/navbar.php";
include "../layout/sidebar.php";
?>

<div class="container mt-4">
    <h2 class="fw-bold mb-4">Daftar Testimoni</h2>
    
    <a href="add.php" class="btn btn-warning mb-3 text-dark fw-semibold">
        <i class="bi bi-plus-circle"></i> Tambah Testimoni
    </a>
    
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-warning text-dark">
                <tr>
                    <th>Nama</th>
                    <th>Isi</th>
                    <th>Tanggal</th>
                    <th style="width: 170px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nama']) ?></td>
                        <td style="white-space: pre-line;"><?= nl2br(htmlspecialchars($row['isi'])) ?></td>
                        <td><?= htmlspecialchars($row['tanggal']) ?></td>
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


<?php include "../layout/footer.php" ?>
