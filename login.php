<!DOCTYPE html>
<html>
<?php
session_start();
include 'inc/db.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if ($row['status'] == 'approved') {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role'];
            header("Location: dashboard.php");
        } else {
            $errorMessage = 'Registrasi Anda belum disetujui oleh admin.';
        }
    } else {
        $errorMessage = 'Username atau password salah.';
    }
}
?>

<head>
    <title>Login - Nama Aplikasi Anda</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/login.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            padding-top: 40px;
            background-color: #70cce1;
        }

        .container-fluid {
            max-width: 100%;
            margin: 0 auto;
            padding: 10px;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: none;
            padding: 20px 30px;
            font-size: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header img {
            max-width: 100%;
            /* IE8 */
            display: block;
            margin: 0 auto;
        }

        .card-header .header-content {
            flex: 1;
            text-align: center;
        }

        .card-header .header-content:last-child {
            text-align: right;
        }

        .card-body {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            padding: 12px 20px;
            font-size: 16px;
            border-radius: 5px;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
        }

        .btn-block {
            display: block;
        }

        .mt-4 {
            margin-top: 1.5rem;
        }

        .text-center {
            text-align: center;
        }

        .text-center a {
            color: #007bff;
        }

        .img-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .img-container img {
            max-width: 100%;
            height: auto;
            width: auto\9;
            /* IE8 */
        }

        .alert {
            margin-bottom: 0;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <div class="header-content ">
                            <img src="assets/akhlak.png" alt="Logo" width="140" height="40">
                        </div>
                        <div class="header-content">
                            <img src="assets/logopgn.png" alt="Logo" width="230" height="30">
                        </div>
                    </div>
                    <h2 class="text-center mt-3">LOGIN</h2>
                    <div class="card-body">
                        <?php if (isset($errorMessage)): ?>
                            <div class="alert alert-danger">
                                <?php echo $errorMessage; ?>
                            </div>
                        <?php endif; ?>
                        <form method="POST" action="login.php">
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary btn-block" name="login">Login</button>
                            </div>
                        </form>
                        <!---<p class="text-center mt-4">Belum memiliki akun? <a href="register.php">Registrasi</a></p>-->
                        <p class="text-center">Kembali ke <a href="index.php">beranda</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>