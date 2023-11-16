<!DOCTYPE html>
<html>

<head>
    <title>Data Perjalanan User</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Atur warna latar belakang dan teks pada navbar */
        .navbar {
            background-color: #70cce1;
            color: #fff;
        }

        /* Atur margin pada navbar */
        .navbar {
            margin-bottom: 20px;
        }

        /* Atur ukuran font pada tombol navbar */
        .navbar .btn {
            font-size: 14px;
        }

        /* Atur margin pada container */
        .container {
            margin-top: 20px;
        }

        /* Atur ukuran font pada judul halaman */
        h2 {
            font-size: 24px;
            color: #007bff;
        }

        /* Atur ukuran font pada teks konten halaman */
        p {
            font-size: 16px;
        }

        /* Atur margin pada tombol edit dan delete */
        .table .btn {
            margin: 2px;
        }

        /* Atur lebar gambar pada tabel */
        .table td img {
            max-width: 100px;
            height: auto;
        }

        /* Atur margin pada form pencarian */
        .search-form {
            margin-bottom: 20px;
        }

        /* Atur tata letak navbar pada perangkat mobile */
        @media (max-width: 576px) {
            .navbar-brand {
                margin-right: 0;
            }

            .navbar-nav.ml-auto.mt-1 {
                margin-top: 0;
            }

            .nav-link.btn.mb-1.text-light.btn-primary {
                margin-bottom: 0.5rem;
            }

            /* Atur lebar navbar collapse pada perangkat mobile */
            .navbar-collapse {
                width: 100%;
            }

            /* Atur tata letak tombol navbar pada perangkat mobile */
            .navbar-toggler {
                margin-top: 0.5rem;
            }

            /* Atur tata letak tombol pada perangkat mobile */
            .navbar-nav .btn {
                display: block;
                margin-bottom: 0.5rem;
                width: 100%;
            }
        }

        /* Atur tampilan tombol tambah perjalanan */
        .btn-tambah {
            background-color: #28a745;
            color: #fff;
        }

        /* Atur tampilan tombol edit perjalanan */
        .btn-edit {
            background-color: #ffc107;
            color: #212529;
        }

        /* Atur tampilan tombol hapus perjalanan */
        .btn-hapus {
            background-color: #dc3545;
            color: #fff;
        }

        /* Atur tampilan link foto */
        .link-foto {
            color: #007bff;
            cursor: pointer;
        }

        .navbar-brand .separator {
            border-right: 2px solid #fff;
            width: 100%;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="">
            <img src="assets/pgn.png" width="130" height="30" class="mr-2">
            <span class="separator"></span>
            SAFETY DRIVE
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto mr-3 mt-1">
                <?php
                echo "<li class='nav-item'><a class='nav-link btn mb-1 mr-2 text-light btn-success' href='akun_user.php'><i class='fas fa-chevron-left'></i> Back</a></li>";
                echo "<li class='nav-item'><a class='nav-link btn mb-1 text-light btn-danger' href='logout.php'><i class='fas fa-sign-out-alt'></i> Logout</a></li>";
                ?>
            </ul>
        </div>
    </nav>

    <div class="container table-responsive">
        <?php
        // Ambil ID user dari parameter GET
        $user_id = $_GET['id'] ?? '';
        if (empty($user_id)) {
            echo "User ID tidak valid.";
            exit;
        }
        // Lakukan koneksi ke database (ganti bagian ini sesuai dengan konfigurasi database Anda)
        include 'inc/db.php';

        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        // Ambil data user berdasarkan ID
        $user_query = "SELECT username FROM users WHERE id='$user_id'";
        $user_result = $conn->query($user_query);
        if ($user_result->num_rows > 0) {
            $user_row = $user_result->fetch_assoc();
            $username = $user_row['username'];

            echo "<h2>Profil User</h2>";
            echo "<p>Nama: $username</p>";

            // Menghitung total jarak tempuh dari data yang dicari
            $tanggal_awal = $_GET['tanggal_awal'] ?? '';
            $tanggal_akhir = $_GET['tanggal_akhir'] ?? '';

            // Fitur pencarian di atas pencarian tanggal
            $keyword = $_GET['keyword'] ?? '';

            $total_km_pencarian_query = "SELECT SUM(km_akhir - km_awal) AS total_km_pencarian FROM laporan WHERE user_id='$user_id'";

            // Tambahkan kondisi tanggal_awal dan tanggal_akhir jika ada pencarian tanggal
            if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
                $total_km_pencarian_query .= " AND tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
            }

            // Tambahkan kondisi pencarian berdasarkan keyword
            if (!empty($keyword)) {
                $total_km_pencarian_query .= " AND (alamat_awal LIKE '%$keyword%' OR alamat_tujuan LIKE '%$keyword%')";
            }

            $total_km_pencarian_result = $conn->query($total_km_pencarian_query);
            $total_km_pencarian_row = $total_km_pencarian_result->fetch_assoc();
            $total_km_pencarian = $total_km_pencarian_row['total_km_pencarian'];

            echo "<p>Total Jarak Tempuh : $total_km_pencarian KM</p>";
        }

        $query = "SELECT * FROM laporan WHERE user_id='$user_id'";

        // Tambahkan kondisi tanggal_awal dan tanggal_akhir jika ada pencarian tanggal
        if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
            $query .= " AND tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
        }

        // Tambahkan kondisi pencarian berdasarkan keyword
        if (!empty($keyword)) {
            $query .= " AND (alamat_awal LIKE '%$keyword%' OR alamat_tujuan LIKE '%$keyword%')";
        }
        $query .= " ORDER BY laporan.id DESC";
        $result = $conn->query($query);
        $totalRowsResult = $conn->query($query);
        $totalRows = $totalRowsResult->num_rows;

        // Define jumlah baris per halaman
        $rowsPerPage = 4;

        // Dapatkan nomor halaman saat ini dari query string
        $currentPage = 1;
        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $currentPage = $_GET['page'];
        }

        // Hitung total jumlah halaman
        $totalPages = ceil($totalRows / $rowsPerPage);

        // Pastikan currentPage tidak lebih dari totalPages dan tidak negatif
        $currentPage = max(1, min($currentPage, $totalPages));

        // Hitung nomor baris awal untuk halaman saat ini
        $startRow = ($currentPage - 1) * $rowsPerPage;

        // Tambahkan klausa LIMIT ke dalam query SQL
        $query .= " LIMIT $startRow, $rowsPerPage";

        $result = $conn->query($query);
        echo "<h2>Laporan Perjalanan</h2>";

        echo "<div class='search-form'>";
        echo "<form method='GET' action='detail.php?id=$user_id'>";
        echo "<div class='form-row'>";
        echo "<div class='form-group col-md-4'>";
        echo "<label for='keyword'>Cari Alamat:</label>";
        echo "<input type='text' class='form-control' name='keyword' id='keyword' value='$keyword'>";
        echo "</div>";
        echo "<div class='form-group col-md-4'>";
        echo "<label for='tanggal_awal'>Tanggal Awal:</label>";
        echo "<input type='date' class='form-control' name='tanggal_awal' id='tanggal_awal' value='$tanggal_awal'>";
        echo "</div>";
        echo "<div class='form-group col-md-4'>";
        echo "<label for='tanggal_akhir'>Tanggal Akhir:</label>";
        echo "<input type='date' class='form-control' name='tanggal_akhir' id='tanggal_akhir' value='$tanggal_akhir'>";
        echo "</div>";
        echo "</div>";
        echo "<input type='hidden' name='id' value='$user_id'>";
        echo "<button class='btn btn-primary' type='submit'><i class='fas fa-search'></i></button>";
        echo "<button class='btn btn-danger ml-1' type='reset' onclick='window.location.href=\"detail.php?id=$user_id\"'><i class='fas fa-sync'></i></button>";
        echo "<a href='download_pdf2.php' class='btn btn-success ml-1'><i class='fas fa-file-pdf'></i></a>";
        echo "<a href='download_excel2.php' class='btn btn-success ml-1'><i class='fas fa-file-excel'></i></a>";
        echo "</form>";
        echo "</div>";

        if ($result->num_rows > 0) {
            echo "<div class='table-responsive'>";
            echo "<table class='table'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Tanggal</th>";
            echo "<th>Alamat Awal</th>";
            echo "<th>Alamat Tujuan</th>";
            echo "<th>KM Awal</th>";
            echo "<th>KM Akhir</th>";
            echo "<th>Total KM</th>";
            echo "<th>Jenis Perjalanan</th>";
            echo "<th>Perkiraan BBM</th>";
            echo "<th>Foto KM Awal</th>";
            echo "<th>Foto KM Akhir</th>";
            //echo "<th>Status</th>";
            echo "<th>Actions</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['tanggal'] . "</td>";
                echo "<td>" . $row['alamat_awal'] . "</td>";
                echo "<td>" . $row['alamat_tujuan'] . "</td>";
                echo "<td>" . $row['km_awal'] . "</td>";
                echo "<td>" . $row['km_akhir'] . "</td>";
                $total_km = $row['km_akhir'] - $row['km_awal'];
                echo "<td>" . $total_km . "</td>";
                echo "<td>" . $row['jenis_perjalanan'] . "</td>";
                // Perhitungan perkiraan BBM berdasarkan jenis perjalanan dan tipe mobil
                $jenis_perjalanan = $row['jenis_perjalanan'];
                $tipe_mobil = $row['tipe_mobil'];
                $perkiraan_bbm = 0;

                if ($jenis_perjalanan == 'luar' && $tipe_mobil == 'innova') {
                    $bbm_per_km = 1 / 8;
                } elseif ($jenis_perjalanan == 'dalam' && $tipe_mobil == 'innova') {
                    $bbm_per_km = 1 / 10;
                } elseif ($jenis_perjalanan == 'luar' && $tipe_mobil == 'avanza veloz') {
                    $bbm_per_km = 1 / 10;
                } elseif ($jenis_perjalanan == 'dalam' && $tipe_mobil == 'avanza veloz') {
                    $bbm_per_km = 1 / 12;
                } elseif ($jenis_perjalanan == 'luar' && $tipe_mobil == 'triton') {
                    $bbm_per_km = 1 / 12;
                } elseif ($jenis_perjalanan == 'dalam' && $tipe_mobil == 'triton') {
                    $bbm_per_km = 1 / 10;
                } elseif ($jenis_perjalanan == 'luar' && $tipe_mobil == 'avanza putih') {
                    $bbm_per_km = 1 / 12;
                } elseif ($jenis_perjalanan == 'dalam' && $tipe_mobil == 'avanza putih') {
                    $bbm_per_km = 1 / 13;
                }

                // Perkiraan BBM = Total KM * BBM per KM
                $perkiraan_bbm = round($total_km * $bbm_per_km);
                echo "<td>" . $perkiraan_bbm . "</td>";
                echo "<td><img src='uploads/" . $row['foto'] . "' width='100' data-toggle='modal' data-target='#fotoModal' data-foto='uploads/" . $row['foto'] . "'></td>";
                echo "<td><img src='uploads/" . $row['foto2'] . "' width='100' data-toggle='modal' data-target='#fotoModal' data-foto='uploads/" . $row['foto2'] . "'></td>";
                echo "<td>";
                echo "<a href='edit_admin.php?id=" . $row['id'] . "' class='btn btn-primary'><i class='fas fa-pencil-alt'></i></span></a> ";
                echo "<a href='delete_admin.php?id=" . $row['id'] . "' class='btn btn-danger'><i class='fas fa-trash-alt'></i></span></a> ";
                //echo "<a href='download_pdf.php?id=" . $row['id'] . "' class='btn btn-success'>PDF</a>";
                //echo "<a href='download_excel.php?id=" . $row['id'] . "' class='btn btn-success'>EXCEL</a>";
                echo "<a href='#' class='btn btn-info' data-toggle='modal' data-target='#detailModal" . $row['id'] . "'><i class='fas fa-info-circle'></i></span></a>";
                echo "</td>";
                echo "</tr>";
                echo "<div class='modal fade' id='detailModal" . $row['id'] . "' tabindex='-1' role='dialog' aria-labelledby='detailModalLabel" . $row['id'] . "' aria-hidden='true'>";
                echo "<div class='modal-dialog' role='document'>";
                echo "<div class='modal-content'>";
                echo "<div class='modal-header'>";
                echo "<h5 class='modal-title' id='detailModalLabel" . $row['id'] . "'>Detail Laporan</h5>";
                echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                echo "<span aria-hidden='true'>&times;</span>";
                echo "</button>";
                echo "</div>";
                echo "<div class='modal-body'>";
                echo "<a href='download_pdf.php?id=" . $row['id'] . "' class='btn btn-danger mr-3 mb-4'>PDF</a>";
                echo "<a href='download_excel.php?id=" . $row['id'] . "' class='btn btn-success mb-4'>Excel</a>";
                echo "<p>No Polisi: " . $row['no_polisi'] . "</p>";
                echo "<p>Tipe Mobil: " . $row['tipe_mobil'] . "</p>";
                echo "<p>Lampu Depan: " . $row['lampu_depan'] . "</p>";
                echo "<p>Lampu Sen Depan: " . $row['lampu_sen_depan'] . "</p>";
                echo "<p>Lampu Sen Belakang: " . $row['lampu_sen_belakang'] . "</p>";
                echo "<p>Lampu Rem: " . $row['lampu_rem'] . "</p>";
                echo "<p>Lampu Mundur: " . $row['lampu_mundur'] . "</p>";
                echo "<p>Bodi: " . $row['bodi'] . "</p>";
                echo "<p>Ban: " . $row['ban'] . "</p>";
                echo "<p>Pedal Gas: " . $row['pedal'] . "</p>";
                echo "<p>Pedal Kopling: " . $row['kopling'] . "</p>";
                echo "<p>Pedal Rem: " . $row['gas_rem'] . "</p>";
                echo "<p>Klakson: " . $row['klakson'] . "</p>";
                echo "<p>Weaper: " . $row['weaper'] . "</p>";
                echo "<p>Air Weaper: " . $row['air_weaper'] . "</p>";
                echo "<p>Air Radiator: " . $row['air_radiator'] . "</p>";
                echo "<p>Oli Mesin: " . $row['oli_mesin'] . "</p>";
                echo "<p>Note: " . $row['note'] . "</p>";
                echo "</div>";
                echo "<div class='modal-footer'>";
                echo "<button type='button' class='btn btn-danger' data-dismiss='modal'>Close</button>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
            echo "</tbody>";
            echo "</table>";
            echo "</div>";
            if ($totalPages > 0) {
                echo "<nav aria-label='Page navigation'>";
                echo "<ul class='pagination justify-content-center'>";

                // Add "Back" button for previous page
                if ($currentPage > 1) {
                    $prevPage = $currentPage - 1;
                    echo "<li class='page-item'><a class='page-link' href='detail.php?id=$user_id&page=$prevPage'>&laquo;</a></li>";
                }

                // Loop through the pagination numbers
                for ($page = 1; $page <= $totalPages; $page++) {
                    $activeClass = ($page == $currentPage) ? " active" : "";
                    echo "<li class='page-item$activeClass'><a class='page-link' href='detail.php?id=$user_id&page=$page'>$page</a></li>";
                }

                // Add "Next" button for next page
                if ($currentPage < $totalPages) {
                    $nextPage = $currentPage + 1;
                    echo "<li class='page-item'><a class='page-link' href='detail.php?id=$user_id&page=$nextPage'>&raquo;</a></li>";
                }

                echo "</ul>";
                echo "</nav>";
            } else {
                echo "<p>Belum ada laporan perjalanan.</p>";
            }
        } else {
            echo "Belum ada laporan perjalanan.";
        }
        // Tutup koneksi
        $conn->close();
        ?>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="fotoModal" tabindex="-1" role="dialog" aria-labelledby="fotoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="" class="img-fluid" id="modalFoto">
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $('#fotoModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var foto = button.data('foto');
            var modal = $(this);
            modal.find('.modal-body #modalFoto').attr('src', foto);
        });
    </script>
</body>

</html>