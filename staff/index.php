<?php
include "../function.php";
include '../db.php';

// Get data
$totalOrders = ($conn->query("SELECT COUNT(*) AS total FROM orders")->fetch_assoc())['total'] ?? 0;
$pendingOrders = ($conn->query("SELECT COUNT(*) AS total FROM orders WHERE status = 'pending'")->fetch_assoc())['total'] ?? 0;
$completedOrders = ($conn->query("SELECT COUNT(*) AS total FROM orders WHERE status = 'selesai'")->fetch_assoc())['total'] ?? 0;
$revenue = ($conn->query("SELECT IFNULL(SUM(total),0) AS revenue FROM orders WHERE status = 'selesai'")->fetch_assoc())['revenue'] ?? 0;

include "layout/navbar.php";
include "layout/sidebar.php";
?>

<style>
    .card-yellow {
        background-color: #ffe066;
        border: none;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        color: #4b4b00;
        border-radius: 1rem;
        transition: 0.3s;
    }
    .card-yellow:hover {
        transform: translateY(-4px);
    }
    .dashboard-title {
        font-weight: 700;
        color: #4b4b00;
    }
    .dashboard-value {
        font-size: 2.2rem;
        font-weight: 600;
    }
    .quick-link .btn {
        padding: 12px 24px;
        font-weight: bold;
        border-radius: 0.8rem;
    }
</style>

<div class="container mt-4">
    <h1 class="mb-4 dashboard-title">Dashboard Staff</h1>

    <div class="row g-4">
        <div class="col-md-3">
            <div class="card card-yellow p-3">
                <h6>Total Pesanan</h6>
                <div class="dashboard-value"><?= number_format($totalOrders) ?></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-yellow p-3">
                <h6>Pesanan Pending</h6>
                <div class="dashboard-value"><?= number_format($pendingOrders) ?></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-yellow p-3">
                <h6>Pesanan Selesai</h6>
                <div class="dashboard-value"><?= number_format($completedOrders) ?></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-yellow p-3">
                <h6>Total Pendapatan</h6>
                <div class="dashboard-value">Rp<?= number_format($revenue, 0, ',', '.') ?></div>
            </div>
        </div>
    </div>

    <div class="mt-5 quick-link">
        <h4 class="mb-3 dashboard-title">Menu Cepat</h4>
        <a href="orders/index.php" class="btn btn-warning me-2">Kelola Pesanan</a>
        <a href="menu/index.php" class="btn btn-warning">Kelola Menu</a>
    </div>
</div>

<?php include 'layout/footer.php'; ?>
