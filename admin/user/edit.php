<?php
include '../../auth/check.php';
include '../../db.php';
include "../../function.php";


$id = $_GET['id'];
$result = $conn->query("SELECT * FROM users WHERE id = $id");
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $user['password'];

    $role = $_POST['role'];
$stmt = $conn->prepare("UPDATE users SET username = ?, password = ?, role = ? WHERE id = ?");
$stmt->bind_param("sssi", $username, $password, $role, $id);

    $stmt->execute();

    header("Location: index.php");
    exit;
}

include '../layout/navbar.php';
include '../layout/sidebar.php';
?>

<div class="container mt-4">
    <h2 class="fw-bold mb-4">Edit Users</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Username:</label>
            <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Password (biarkan kosong jika tidak diubah):</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
    <label>Role:</label>
    <select name="role" class="form-select" required>
        <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
        <option value="staff" <?= $user['role'] === 'staff' ? 'selected' : '' ?>>Staff</option>
        <option value="customer" <?= $user['role'] === 'customer' ? 'selected' : '' ?>>Customer</option>
    </select>
</div>


        <button type="submit" class="btn btn-warning text-dark fw-semibold">Simpan Perubahan</button>
    </form>
</div>

<?php include '../layout/footer.php'; ?>
