<?php
session_start();
include 'inc/db.php';

// Pastikan hanya admin yang dapat mengakses halaman ini
if ($_SESSION['role'] !== 'admin') {
    header("Location: dashboard_register.php");
    exit();
}

// Memastikan parameter id ada dan tidak kosong
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $userId = $_GET['id'];

    // Mengubah status akun pengguna menjadi 'rejected' di tabel users
    $updateQuery = "UPDATE users SET status = 'rejected' WHERE id = '$userId'";
    if ($conn->query($updateQuery) === TRUE) {
        // Menghapus akun pengguna dari tabel users
        $deleteQuery = "DELETE FROM users WHERE id = '$userId'";
        if ($conn->query($deleteQuery) === TRUE) {
            echo '<div class="alert alert-success">Akun pengguna telah ditolak dan dihapus.</div>';
        } else {
            echo '<div class="alert alert-danger">Error: ' . $deleteQuery . '<br>' . $conn->error . '</div>';
        }
    } else {
        echo '<div class="alert alert-danger">Error: ' . $updateQuery . '<br>' . $conn->error . '</div>';
    }
}

header("Location: akun_user.php");
exit();
?>