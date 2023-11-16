<!DOCTYPE html>
<html>

<head>
    <title>Semua Laporan Perjalanan</title>
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

        .search-form input[type="text"] {
            width: 100%;
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
            <ul class="navbar-nav ml-auto mr-3 mt-1">
                <?php
                echo "<li class='nav-item'><a class='nav-link btn mb-1 mr-2 text-light btn-success' href='dashboard.php'><i class='fas fa-chevron-left'></i> Back</a></li>";
                echo "<li class='nav-item'><a class='nav-link btn mb-1 mr-2 text-light btn-danger' href='logout.php'><i class='fas fa-sign-out-alt'></i> Logout</a></li>";
                ?>
            </ul>
        </div>
    </nav>
    <div class="container">
        <?php
        include 'inc/db.php';
        // Periksa koneksi
        if ($conn->connect_error) {
            die("Koneksi ke database gagal: " . $conn->connect_error);
        }

        // Deklarasi fungsi calculateBBM di luar loop while
        function calculateBBM($jenis_perjalanan, $tipe_mobil, $total_km)
        {
            $bbm_per_km = 0;

            if ($jenis_perjalanan == 'luar') {
                if ($tipe_mobil == 'innova') {
                    $bbm_per_km = 1 / 8;
                } elseif ($tipe_mobil == 'avanza veloz') {
                    $bbm_per_km = 1 / 10;
                } elseif ($tipe_mobil == 'triton') {
                    $bbm_per_km = 1 / 12;
                } elseif ($tipe_mobil == 'avanza putih') {
                    $bbm_per_km = 1 / 12;
                }
            } elseif ($jenis_perjalanan == 'dalam') {
                if ($tipe_mobil == 'innova') {
                    $bbm_per_km = 1 / 10;
                } elseif ($tipe_mobil == 'avanza veloz') {
                    $bbm_per_km = 1 / 12;
                } elseif ($tipe_mobil == 'triton') {
                    $bbm_per_km = 1 / 10;
                } elseif ($tipe_mobil == 'avanza putih') {
                    $bbm_per_km = 1 / 13;
                }
            }

            $perkiraan_bbm = round($total_km * $bbm_per_km); // Bulatkan hasil jika koma
            return $perkiraan_bbm;
        }

        // Kode query dan tampilan HTML
        $search_query = "";
        if (isset($_GET['search'])) {
            $search_query = $_GET['search'];
        }

        $query = "SELECT * FROM laporan INNER JOIN users ON laporan.user_id = users.id";

        if (!empty($search_query)) {
            $query .= " WHERE tanggal LIKE '%$search_query%' OR alamat_awal LIKE '%$search_query%' OR alamat_tujuan LIKE '%$search_query%' OR username LIKE '%$search_query%'";
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

        // Pastikan currentPage tidak lebih dari totalPages
        $currentPage = min($currentPage, $totalPages);

        // Hitung nomor baris awal untuk halaman saat ini
        $startRow = ($currentPage - 1) * $rowsPerPage;

        // Tambahkan klausa LIMIT ke dalam query SQL
        $query .= " LIMIT $startRow, $rowsPerPage";

        $result = $conn->query($query);

        echo "<h2 class='mt-3'>Semua Laporan Perjalanan</h2>";

        echo "<form class='mb-3' method='GET' action='data_perjalanan.php'>";
        echo "<div class='input-group'>";
        echo "<input type='text' class='form-control' name='search' placeholder='Search' value='$search_query'>";
        echo "<div class='input-group-append'>";
        echo "<button class='btn btn-primary' type='submit'><i class='fas fa-search'></i></button>";
        echo "<button class='btn btn-danger ml-1' type='reset' onclick='window.location.href=\"data_perjalanan.php\"'><i class='fas fa-sync'></i></button>";
        echo "<a href='download_pdf2.php' class='btn btn-success ml-1'><i class='fas fa-file-pdf'></i></a>";
        echo "<a href='download_excel2.php' class='btn btn-success ml-1'><i class='fas fa-file-excel'></i></a>";
        echo "</div>";
        echo "</form>";
        echo "</div>";

        if ($result->num_rows > 0) {
            echo "<div class='table-responsive table-responsive-sm'>";
            echo "<table class='table'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>User</th>";
            echo "<th>Tanggal</th>";
            echo "<th>Alamat Awal</th>";
            echo "<th>Alamat Tujuan</th>";
            echo "<th>KM Awal</th>";
            echo "<th>KM Akhir</th>";
            echo "<th>Total KM</th>";
            echo "<th>Jenis Perjalanan</th>";
            echo "<th>Perkiraan BBM</th>";
            //echo "<th>Status</th>";
            echo "<th>Foto KM Awal</th>";
            echo "<th>Foto KM Akhir</th>";
            echo "<th></th>"; // Kolom tambahan untuk tombol detail
            //echo "<th>Actions</th>"; // Kolom tambahan untuk tombol download
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . $row['tanggal'] . "</td>";
                echo "<td>" . $row['alamat_awal'] . "</td>";
                echo "<td>" . $row['alamat_tujuan'] . "</td>";
                echo "<td>" . $row['km_awal'] . "</td>";
                echo "<td>" . $row['km_akhir'] . "</td>";
                $total_km = $row['km_akhir'] - $row['km_awal']; // Menghitung total km
        
                $jenis_perjalanan = $row['jenis_perjalanan'];
                $tipe_mobil = $row['tipe_mobil'];
                $perkiraan_bbm = calculateBBM($jenis_perjalanan, $tipe_mobil, $total_km);

                echo "<td>" . $total_km . "</td>";
                echo "<td>" . $jenis_perjalanan . "</td>";
                echo "<td>" . $perkiraan_bbm . "</td>";
                //echo "<td>" . $row['status_lap'] . "</td>";
                echo "<td><a href='#' data-toggle='modal' data-target='#fotoModal' data-foto='uploads/" . $row['foto'] . "'><img src='uploads/" . $row['foto'] . "' width='100'></a></td>";
                echo "<td><a href='#' data-toggle='modal' data-target='#fotoModal' data-foto='uploads/" . $row['foto2'] . "'><img src='uploads/" . $row['foto2'] . "' width='100'></a></td>";
                echo "<td></td>"; // Kolom tambahan untuk tombol detail
                //echo "<td><a class='btn btn-success ml-1' href='download.php?id=" . $row['id'] . "'>Download</a></td>";
                echo "</tr>"; // Tutup baris data saat ini
                echo "<tr>"; // Baris baru untuk menu detail
                echo "<td colspan='12'>"; // Menggabungkan sel menjadi 1 kolom
                echo "<details>";
                echo "<summary><i class='fas fa-search'></i> Detail</summary>";
                echo "<div class='details-content'>";
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
                echo "</details>";
                echo "</td>";
                echo "</tr>";

                // Menyimpan nilai perkiraan BBM ke dalam database
                $laporan_id = $row['id'];
                $update_query = "UPDATE laporan SET perkiraan_bbm = $perkiraan_bbm WHERE id = $laporan_id";
                $conn->query($update_query);
            }
            echo "</tbody>";
            echo "</table>";
            echo "</div>";
            if ($totalPages > 0) {
                echo "<nav aria-label='Page navigation'>";
                echo "<ul class='pagination justify-content-center'>";

                // Tambahkan tombol Back (Previous) jika currentPage > 1
                if ($currentPage > 1) {
                    echo "<li class='page-item'><a class='page-link' href='data_perjalanan.php?page=" . ($currentPage - 1) . "'>&laquo;</a></li>";
                }

                for ($page = 1; $page <= $totalPages; $page++) {
                    $activeClass = ($page == $currentPage) ? " active" : "";
                    echo "<li class='page-item$activeClass'><a class='page-link' href='data_perjalanan.php?page=$page'>$page</a></li>";
                }

                // Tambahkan tombol Next jika currentPage < totalPages
                if ($currentPage < $totalPages) {
                    echo "<li class='page-item'><a class='page-link' href='data_perjalanan.php?page=" . ($currentPage + 1) . "'>&raquo;</a></li>";
                }

                echo "</ul>";
                echo "</nav>";
            } else {
                echo "<p>Belum ada laporan perjalanan.</p>";
            }
        } else {
            echo "<p>Belum ada laporan perjalanan.</p>";
        }
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