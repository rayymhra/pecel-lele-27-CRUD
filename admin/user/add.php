<?php
include '../../auth/check.php';
include '../../db.php';
include "../../function.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];
    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $role);


    // $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    // $stmt->bind_param("ss", $username, $password);
    $stmt->execute();

    header("Location: index.php");
    exit;
}

include '../layout/navbar.php';
include '../layout/sidebar.php';
?>

<div class="container mt-4">
    <h2 class="fw-bold mb-4">Tambah Admin</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Username:</label>
            <input type="text" name="username" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password:</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
    <label>Role:</label>
    <select name="role" class="form-select" required>
        <option value="admin">Admin</option>
        <option value="staff" selected>Staff</option>
    </select>
</div>


        <button type="submit" class="btn btn-warning text-dark fw-semibold">Simpan</button>
    </form>
</div>

<?php include '../layout/footer.php'; ?>
