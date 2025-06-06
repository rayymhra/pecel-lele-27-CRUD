<?php
include '../../auth/check.php';
include '../../db.php';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=orders_pecel_lele27.xls");

echo "Order ID\tNama Pelanggan\tTanggal Order\tTotal Harga\tStatus\n";

$result = $conn->query("SELECT id, nama_pelanggan, tanggal_order, total, status FROM orders ORDER BY tanggal_order DESC");

while ($row = $result->fetch_assoc()) {
    echo "{$row['id']}\t{$row['nama_pelanggan']}\t{$row['tanggal_order']}\t{$row['total']}\t{$row['status']}\n";
}
?>
