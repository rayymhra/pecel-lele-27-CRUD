<?php
include '../../auth/check.php';
include '../../db.php';

$result = $conn->query("SELECT * FROM menu");
?>

<h2>Daftar Menu</h2>
<a href="add.php">Tambah Menu</a>
<table>
    <tr>
        <th>Nama</th>
        <th>Deskripsi</th>
        <th>Harga</th>
        <th>gambar</th>
        <th>Aksi</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['nama']) ?></td>
            <td><?= htmlspecialchars($row['deskripsi']) ?></td>
            <td>Rp<?= number_format($row['harga'], 0, ',', '.') ?></td>
            <td>
                <?php if ($row['gambar']): ?>
                    <img src="../../uploads/<?= $row['gambar'] ?>" width="100">
                <?php endif; ?>
            </td>
            <td>
                <a href="edit.php?id=<?= $row['id'] ?>">Edit</a> |
                <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
