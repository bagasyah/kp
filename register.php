<!DOCTYPE html>
<html>
<?php
session_start();
include 'inc/db.php';

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek apakah username sudah ada dalam tabel users
    $checkQuery = "SELECT * FROM users WHERE username='$username'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        $errorMessage = 'Username sudah terdaftar. Silakan gunakan username lain.';
    } else {
        // Jika username belum terdaftar, lakukan penambahan data ke tabel users
        $insertQuery = "INSERT INTO users (username, password, role, status) VALUES ('$username', '$password', 'user', 'pending')";
        if ($conn->query($insertQuery) === TRUE) {
            $errorMessage = 'Registrasi berhasil. Admin akan memeriksa registrasi Anda.';
        } else {
            $errorMessage . $insertQuery . '<br>' . $conn->error . '</div>';
        }
    }
}
?>

<head>
    <title>Registrasi</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
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
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="header-content ">
                            <img src="assets/akhlak.png" alt="Logo" width="140" height="40">
                        </div>
                        <div class="header-content">
                            <img src="assets/logopgn.png" alt="Logo" width="230" height="30">
                        </div>
                    </div>
                    <h2 class="text-center mt-3">REGISTER</h2>
                    <div class="card-body">
                        <?php if (isset($errorMessage)): ?>
                            <div class="alert alert-danger">
                                <?php echo $errorMessage; ?>
                            </div>
                        <?php endif; ?>
                        <form method="POST" action="register.php">
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary btn-block"
                                    name="register">Register</button>
                            </div>
                        </form>
                        <p class="text-center mt-4">Sudah memiliki akun? <a href="login.php">Kembali ke
                                Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>