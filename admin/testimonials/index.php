<?php
include '../../auth/check.php';
include '../../db.php';

$result = $conn->query("SELECT * FROM testimoni ORDER BY id DESC");
?>

<h2>Daftar Testimoni</h2>
<a href="add.php">Tambah Testimoni</a>
<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>Nama</th>
        <th>Isi</th>
        <th>Tanggal</th>
        <th>Aksi</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) : ?>
        <tr>
            <td><?= htmlspecialchars($row['nama']) ?></td>
            <td><?= nl2br(htmlspecialchars($row['isi'])) ?></td>
            <td><?= $row['tanggal'] ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id'] ?>">Edit</a> |
                <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
