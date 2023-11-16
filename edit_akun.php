<!DOCTYPE html>
<html>

<head>
    <title>Edit Akun Pengguna</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Atur margin pada container */
        .container {
            margin-top: 20px;
        }

        /* Atur ukuran font pada judul halaman */
        h2 {
            font-size: 24px;
        }

        /* Atur ukuran font pada teks konten halaman */
        p {
            font-size: 16px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Edit Akun Pengguna</h2>
        <?php
        include 'inc/db.php';

        if (isset($_GET['id'])) {
            $user_id = $_GET['id'];

            // Fetch data pengguna berdasarkan ID
            $query = "SELECT * FROM users WHERE id='$user_id'";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                ?>
                <form method="POST" action="update.php">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username"
                            value="<?php echo $row['username']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="text" class="form-control" id="password" name="password"
                            value="<?php echo $row['password']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control" id="role" name="role" required>
                            <option value="user" <?php echo ($row['role'] == 'user') ? 'selected' : ''; ?>>User</option>
                            <option value="admin" <?php echo ($row['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="approved" <?php echo ($row['status'] == 'approved') ? 'selected' : ''; ?>>Approved
                            </option>
                            <option value="pending" <?php echo ($row['status'] == 'pending') ? 'selected' : ''; ?>>Pending
                            </option>
                            <option value="rejected" <?php echo ($row['status'] == 'rejected') ? 'selected' : ''; ?>>Rejected
                            </option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="akun_user.php" class="btn btn-danger">Cancel</a>
                </form>
                <?php
            } else {
                echo "<p>Data akun pengguna tidak ditemukan.</p>";
            }
        } else {
            echo "<p>ID pengguna tidak ditemukan.</p>";
        }

        $conn->close();
        ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>