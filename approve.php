<?php
include 'inc/db.php';

$id = $_GET['id'];

$query = "UPDATE users SET status='approved' WHERE id='$id'";
if ($conn->query($query) === TRUE) {
    header("Location: akun_user.php");
} else {
    echo "Error: " . $query . "<br>" . $conn->error;
}
?>