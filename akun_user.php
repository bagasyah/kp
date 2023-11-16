<!DOCTYPE html>
<html>

<head>
    <title>Akun Pengguna</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <style>
        /* Atur margin pada container */
        .navbar {
            background-color: #70cce1;
        }

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

        /* Responsif pada perangkat seluler */
        @media (max-width: 576px) {

            /* Atur ukuran font pada judul halaman untuk perangkat seluler */
            h2 {
                font-size: 20px;
            }

            /* Atur ukuran font pada teks konten halaman untuk perangkat seluler */
            p {
                font-size: 14px;
            }

            /* Atur margin pada navbar untuk perangkat seluler */
            .navbar-nav {
                margin: 0;
            }

            /* Atur margin pada tombol navigasi untuk perangkat seluler */
            .navbar-toggler {
                margin-right: 0;
            }

            /* Atur margin pada tombol navigasi di dalam navbar untuk perangkat seluler */
            .navbar-collapse {
                margin-top: 10px;
            }
        }

        .navbar-brand .separator {
            border-right: 2px solid #fff;
            width: 100%;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="dashboard.php">
            <img src="assets/pgn.png" width="130" height="30" class="mr-2">
            <span class="separator"></span>
            SAFETY DRIVE
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto mr-3">
                <?php
                session_start();
                if (!isset($_SESSION['user_id'])) {
                    header("Location: login.php");
                    exit();
                }

                $role = $_SESSION['role'];
                echo "<li class='nav-item'><a class='nav-link btn mb-1 mr-2 text-light btn-success' href='dashboard.php'><i class='fas fa-chevron-left'></i> Back</a></li>";
                echo "<li class='nav-item'><a class='nav-link btn mb-1 mr-2 text-light btn-danger' href='logout.php'><i class='fas fa-sign-out-alt'></i> Logout</a></li>";
                ?>
            </ul>
        </div>
    </nav>
    <div class="container">
        <div class="table-responsive">
            <?php
            include 'inc/db.php';

            // Mengatasi kesalahan yang mungkin terjadi ketika menggunakan $_POST
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_user'])) {
                $new_username = mysqli_real_escape_string($conn, $_POST['username']);
                $new_password = mysqli_real_escape_string($conn, $_POST['password']);
                $new_role = mysqli_real_escape_string($conn, $_POST['role']);
                $new_status = "approved";

                $create_user_query = "INSERT INTO users (username, password, role, status) VALUES ('$new_username', '$new_password', '$new_role', '$new_status')";

                if ($conn->query($create_user_query) === TRUE) {
                    echo "<div class='alert alert-success'>Akun pengguna berhasil dibuat.</div>";
                } else {
                    echo "<div class='alert alert-danger'>Gagal membuat akun pengguna.</div>";
                }
            }

            if ($role == 'admin') {
                if (isset($_GET['delete'])) {
                    $delete_id = $_GET['delete'];

                    // Hapus laporan terlebih dahulu
                    $delete_laporan_query = "DELETE FROM laporan WHERE user_id='$delete_id'";
                    if ($conn->query($delete_laporan_query) === TRUE) {
                        // Setelah laporan dihapus, hapus akun pengguna
                        $delete_query = "DELETE FROM users WHERE id='$delete_id'";
                        if ($conn->query($delete_query) === TRUE) {
                            echo "<div class='alert alert-success'>Akun pengguna berhasil dihapus.</div>";
                        } else {
                            echo "<div class='alert alert-danger'>Gagal menghapus akun pengguna.</div>";
                        }
                    } else {
                        echo "<div class='alert alert-danger'>Gagal menghapus laporan terkait.</div>";
                    }
                }

                $query = "SELECT users.id, users.username, users.password, users.role, users.status, SUM(laporan.km_akhir - laporan.km_awal) AS total_km 
                FROM users LEFT JOIN laporan ON users.id = laporan.user_id 
                GROUP BY users.id, users.username, users.password, users.role, users.status";


                // Mengatur kata kunci pencarian jika ada
                if (isset($_GET['search'])) {
                    $search = $_GET['search'];
                    $query .= " HAVING users.username LIKE '%$search%'";
                }

                $result = $conn->query($query);

                echo "<h2 class='mt-3'>Akun Pengguna</h2>";

                // Tampilkan form pencarian
                echo "<form class='mb-3' method='GET'>";
                echo "<div class='input-group'>";
                echo "<input type='text' class='form-control' name='search' placeholder='Cari akun pengguna...'>";
                echo "<div class='input-group-append'>";
                echo "<button class='btn btn-primary' type='submit'><i class='fas fa-search'></i></button>";
                echo "<button class='btn btn-danger ml-1' type='reset' onclick='window.location.href=\"akun_user.php\"'><i class='fas fa-sync'></i></button>";
                echo "</div>";
                echo "</div>";
                echo "</form>";

                // Add a new form to create user accounts
                echo "<form class='mb-3' method='POST'>";
                echo "<div class='form-row'>";
                echo "<div class='col-md-4 mb-3'>";
                echo "<label for='username'>Username</label>";
                echo "<input type='text' class='form-control' id='username' name='username' required>";
                echo "</div>";
                echo "<div class='col-md-4 mb-3'>";
                echo "<label for='password'>Password</label>";
                echo "<input type='password' class='form-control' id='password' name='password' required>";
                echo "</div>";
                echo "<div class='col-md-4 mb-3'>"; // Adjusted the column size to fit the "Role" and "Create" button in the same row
                echo "<label for='role'>Role</label>";
                echo "<select class='form-control' id='role' name='role' required>";
                echo "<option value='admin'>Admin</option>";
                echo "<option value='user'>User</option>";
                echo "</select>";
                echo "</div>";
                echo "<div class='col-md-4 mb-3'>"; // Adjusted the column size to fit the "Role" and "Create" button in the same row
                echo "<button type='submit' class='btn btn-success' name='create_user'><i class='fas fa-edit'></i> Create</button>";
                echo "</div>";
                echo "</div>";
                echo "</form>";

                if ($result->num_rows > 0) {
                    echo "<div class='table-responsive'>";
                    echo "<table class='table'>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>Username</th>";
                    echo "<th>Password</th>";
                    echo "<th>Role</th>";
                    echo "<th>Status</th>";
                    echo "<th>Total KM</th>";
                    echo "<th>Actions</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>" . $row['password'] . "</td>";
                        echo "<td>" . $row['role'] . "</td>";
                        echo "<td>" . $row['status'] . "</td>";
                        echo "<td>" . $row['total_km'] . "</td>";
                        echo "<td>";
                        echo "<a href='edit_akun.php?id=" . $row['id'] . "' class='btn btn-primary mt-1'><i class='fas fa-pencil-alt'></i></a> ";
                        echo "<a href='javascript:void(0);' class='btn btn-danger mr-1 mt-1' onclick='confirmDelete(" . $row['id'] . ")'><i class='fas fa-trash-alt'></i></a>";
                        echo "<a href='detail.php?id=" . $row['id'] . "' class='btn btn-info mt-1'><i class='fas fa-arrow-right'></i></a>";
                        echo "</td>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                } else {
                    echo "Belum ada akun pengguna terdaftar.";
                }
            }

            $conn->close();
            ?>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function confirmDelete(userId) {
            var confirmation = confirm("Anda yakin ingin menghapus akun pengguna ini?");
            if (confirmation) {
                window.location.href = '?delete=' + userId;
            }
        }
    </script>

</body>

</html>