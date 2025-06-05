<?php
include '../../auth/check.php';
include '../../db.php';

$result = $conn->query("SELECT * FROM pesanan");
?>

<h2>Daftar Pesanan</h2>
<a href="add.php">+ Tambah Pesanan</a>
<br><br>

<table border="1" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Gambar</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $no++ . "</td>";
            echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
            echo "<td>";
            if (!empty($row['gambar'])) {
                echo "<img src='../../uploads/" . htmlspecialchars($row['gambar']) . "' width='100'>";
            } else {
                echo "Tidak ada gambar";
            }
            echo "</td>";
            echo "<td>
                    <a href='edit.php?id=" . $row['id'] . "'>Edit</a> | 
                    <a href='delete.php?id=" . $row['id'] . "' onclick='return confirm(\"Yakin ingin hapus?\")'>Hapus</a>
                  </td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
