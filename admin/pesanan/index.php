<?php
include '../../auth/check.php';
include '../../db.php';

$result = $conn->query("SELECT * FROM pesanan");

include "../layout/navbar.php";
include "../layout/sidebar.php";
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold">Daftar Pesanan</h2>
        <a href="add.php" class="btn btn-warning fw-semibold text-dark">
            <i class="bi bi-plus-circle"></i> Tambah Pesanan
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered align-middle shadow-sm">
            <thead class="table-warning text-dark">
                <tr>
                    <th scope="col" style="width: 50px;">No</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Gambar</th>
                    <th scope="col" style="width: 170px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$no}</td>";
                    echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                    echo "<td>";
                    if (!empty($row['gambar'])) {
                        echo "<img src='../../uploads/" . htmlspecialchars($row['gambar']) . "' width='100' class='img-thumbnail'>";
                    } else {
                        echo "Tidak ada gambar";
                    }
                    echo "</td>";
                    echo "<td>
                        <a href='edit.php?id={$row['id']}' class='btn btn-sm btn-outline-primary me-1'>
                            <i class='bi bi-pencil'></i> Edit
                        </a>
                        <a href='delete.php?id={$row['id']}' class='btn btn-sm btn-outline-danger' onclick='return confirm(\"Yakin ingin hapus?\")'>
                            <i class='bi bi-trash'></i> Hapus
                        </a>
                      </td>";
                    echo "</tr>";
                    $no++;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>


<?php include "../layout/footer.php" ?>
