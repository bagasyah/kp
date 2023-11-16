<?php
include 'inc/db.php';

$id = $_GET['id'];

$query = "DELETE FROM laporan WHERE id='$id'";
if ($conn->query($query) === TRUE) {
    // Notifikasi berhasil dihapus
    echo "<script>alert('Data berhasil dihapus.');</script>";
    echo "<script>window.location.href = 'detail.php';</script>";
    exit();
} else {
    echo "Error: " . $query . "<br>" . $conn->error;
}
?>