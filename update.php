<?php
include 'inc/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $status = $_POST['status'];

    // Update data akun pengguna
    $update_query = "UPDATE users SET username='$username',password='$password', role='$role', status='$status' WHERE id='$user_id'";
    if ($conn->query($update_query) === TRUE) {
        echo "<div class='alert alert-success'>Akun pengguna berhasil diperbarui.</div>";
    } else {
        echo "<div class='alert alert-danger'>Gagal memperbarui akun pengguna: " . $conn->error . "</div>";
    }
}

$conn->close();

// Redirect ke halaman akun_user.php setelah proses update selesai
header("Location: akun_user.php");
exit();
?>