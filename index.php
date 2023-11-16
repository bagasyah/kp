<!DOCTYPE html>
<html>

<head>
    <title>Laporan Perjalanan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .navbar {
            background-color: #70cce1;
        }

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

        .dropdown-toggle:focus {
            box-shadow: none;
        }

        table {}

        .details-content {
            margin-top: 10px;
            margin-bottom: 10px;
        }

        @media (max-width: 576px) {
            .navbar-brand {
                margin-right: 0;
            }

            .navbar-nav.ml-auto.mt-1 {
                margin-top: 0;
            }

            .nav-link.btn.mb-1.text-light.btn-success {
                margin-bottom: 0.5rem;
            }

            .table-responsive-sm {
                overflow-x: auto;
            }

            table {
                width: 100%;
            }
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
            <ul class="navbar-nav mr-auto">
            </ul>
            <ul class="navbar-nav ml-auto mt-1">
                <?php
                echo "<li class='nav-item'><a class='nav-link btn mb-1 text-light btn-success' href='login.php'><i class='fas fa-sign-in-alt'></i> Login</a></li>";
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

        // Deklarasi variabel total_km_all di luar loop while
        $total_km_all = 0;

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

        // Tambahkan kondisi pencarian berdasarkan tanggal
        $tanggal_awal = $_GET['tanggal_awal'] ?? '';
        $tanggal_akhir = $_GET['tanggal_akhir'] ?? '';

        if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
            $query .= " WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
        }
        if (!empty($search_query)) {
            if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
                $query .= " AND (tanggal LIKE '%$search_query%' OR alamat_awal LIKE '%$search_query%' OR alamat_tujuan LIKE '%$search_query%' OR username LIKE '%$search_query%')";
            } else {
                $query .= " WHERE tanggal LIKE '%$search_query%' OR alamat_awal LIKE '%$search_query%' OR alamat_tujuan LIKE '%$search_query%' OR username LIKE '%$search_query%'";
            }
        }
        $query .= " ORDER BY laporan.id DESC";
        $totalRowsResult = $conn->query($query);
        $totalRows = $totalRowsResult->num_rows;

        // Eksekusi query ke database
        $result = $conn->query($query);

        // Tampilkan tampilan HTML untuk menampilkan hasil query
        echo "<h2 class='mt-1'>Semua Laporan Perjalanan</h2>";
        echo "<div class='search-form'>";
        echo "<form method='GET' action='index.php'>";
        echo "<div class='form-row'>";
        echo "<div class='form-group col-md-4'>";
        echo "<label for='search'>Cari:</label>";
        echo "<input type='text' class='form-control' name='search' id='search' value='$search_query'>";
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
        echo "<button class='btn btn-primary' type='submit'><i class='fas fa-search'></i></button>";
        echo "<button class='btn btn-danger ml-1' type='reset' onclick='window.location.href=\"index.php\"'><i class='fas fa-sync'></i></button>";
        echo "<a href='download.php' class='btn btn-success ml-1'><i class='fas fa-file-pdf'></i></a>";
        echo "<a href='download_excel2.php' class='btn btn-success ml-1'><i class='fas fa-file-excel'></i></a>";
        echo "</form>";
        echo "</div>";
        // Eksekusi query ke database
        $result = $conn->query($query);

        // Hitung total km sebelum loop while
        while ($row = $result->fetch_assoc()) {
            $total_km = $row['km_akhir'] - $row['km_awal']; // Menghitung total km
            $total_km_all += $total_km; // Menambahkannya ke total km keseluruhan
        }

        // Tampilkan total km keseluruhan di atas tabel
        echo "<h4>Total Jarak Tempuh : " . $total_km_all . " KM</h4>";

        // Mulai menampilkan tabel dan data perjalanan
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

        // Reset ulang result set
        $result->data_seek(0);

        while ($row = $result->fetch_assoc()) {
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
            echo "<td><a href='#' data-toggle='modal' data-target='#fotoModal' data-foto='uploads/" . $row['foto'] . "'><img src='uploads/" . $row['foto'] . "' width='100'></a></td>";
            echo "<td><a href='#' data-toggle='modal' data-target='#fotoModal' data-foto='uploads/" . $row['foto2'] . "'><img src='uploads/" . $row['foto2'] . "' width='100'></a></td>";
            echo "<td></td>"; // Kolom tambahan untuk tombol detail
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