<?php
session_start(); // Pastikan untuk memanggil session_start() di awal script jika belum dilakukan
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = null; // Jika user belum login, variabel $user_id diisi dengan null
}
require('inc/db.php');
require('fpdf.php');

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

$search_query = "";
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
}

// Buat objek PDF
$pdf = new FPDF();
$pdf->AddPage();

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

if (isset($_GET['id'])) {
    // Mendownload satu dokumen laporan berdasarkan ID
    $id = $_GET['id'];
    $query = "SELECT * FROM laporan INNER JOIN users ON laporan.user_id = users.id WHERE laporan.id = $id";

    $result = $conn->query($query);
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Nama file
        $filename = "laporan_perjalanan_" . $row['id'] . ".pdf";

        // Tulis data dari database
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Laporan Perjalanan', 0, 1, 'C');
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 10);
        $header = array('Nama', 'Tanggal', 'Alamat Awal', 'Alamat Tujuan');
        foreach ($header as $col) {
            $pdf->Cell(37, 10, $col, 1);
        }
        $pdf->Ln();
        $pdf->Cell(37, 10, $row['username'], 1);
        $pdf->Cell(37, 10, $row['tanggal'], 1);
        $pdf->Cell(37, 10, $row['alamat_awal'], 1);
        $pdf->Cell(37, 10, $row['alamat_tujuan'], 1);
        $pdf->Ln();
        $pdf->Ln();
        // Tabel KM awal, KM akhir, dan Total KM
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFont('Arial', '', 10);
        $header_km = array('KM Awal', 'KM Akhir', 'Total KM', 'Perkiraan BBM', 'Jenis Perjalanan');
        foreach ($header_km as $col) {
            $pdf->Cell(37, 10, $col, 1);
        }
        $pdf->Ln();

        $pdf->Cell(37, 10, $row['km_awal'], 1);
        $pdf->Cell(37, 10, $row['km_akhir'], 1);
        $total_km = $row['km_akhir'] - $row['km_awal'];
        $perkiraan_bbm = calculateBBM($row['jenis_perjalanan'], $row['tipe_mobil'], $total_km);
        $pdf->Cell(37, 10, $total_km, 1);
        $pdf->Cell(37, 10, $perkiraan_bbm, 1);
        $pdf->Cell(37, 10, $row['jenis_perjalanan'], 1);
        $pdf->Ln();

        // Tabel terpisah untuk data lainnya
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 10, 'Data Lainnya', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 10);
        $header2 = array('No Polisi', 'Tipe Mobil', 'Lampu Depan', 'Lampu Sen Depan', 'Lampu Sen Belakang');
        foreach ($header2 as $col) {
            $pdf->Cell(37, 10, $col, 1);
        }
        $pdf->Ln();

        $pdf->Cell(37, 10, $row['no_polisi'], 1);
        $pdf->Cell(37, 10, $row['tipe_mobil'], 1);
        $pdf->Cell(37, 10, $row['lampu_depan'], 1);
        $pdf->Cell(37, 10, $row['lampu_sen_depan'], 1);
        $pdf->Cell(37, 10, $row['lampu_sen_belakang'], 1);
        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFont('Arial', '', 10);
        $header2 = array('Lampu Rem', 'Lampu Mundur', 'Bodi', 'Ban', 'Pedal');
        foreach ($header2 as $col) {
            $pdf->Cell(37, 10, $col, 1);
        }
        $pdf->Ln();
        $pdf->Cell(37, 10, $row['lampu_rem'], 1);
        $pdf->Cell(37, 10, $row['lampu_mundur'], 1);
        $pdf->Cell(37, 10, $row['bodi'], 1);
        $pdf->Cell(37, 10, $row['ban'], 1);
        $pdf->Cell(37, 10, $row['pedal'], 1);
        $pdf->Ln();
        // Spasi antara setiap baris data
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFont('Arial', '', 10);
        $header2 = array('Kopling', 'Gas/Rem', 'Oli Mesin', 'Klakson', 'Weaper');
        foreach ($header2 as $col) {
            $pdf->Cell(37, 10, $col, 1);
        }
        $pdf->Ln();
        $pdf->Cell(37, 10, $row['kopling'], 1);
        $pdf->Cell(37, 10, $row['gas_rem'], 1);
        $pdf->Cell(37, 10, $row['oli_mesin'], 1);
        $pdf->Cell(37, 10, $row['klakson'], 1);
        $pdf->Cell(37, 10, $row['weaper'], 1);
        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFont('Arial', '', 10);
        $header2 = array('Air Weaper', 'Air Radiator');
        foreach ($header2 as $col) {
            $pdf->Cell(37, 10, $col, 1);
        }
        $pdf->Ln();
        $pdf->Cell(37, 10, $row['air_weaper'], 1);
        $pdf->Cell(37, 10, $row['air_radiator'], 1);

        // Gabungkan gambar KM awal dan KM akhir menjadi satu gambar
        $gambar_km_awal = 'uploads/' . $row['foto'];
        $gambar_km_akhir = 'uploads/' . $row['foto2'];

        if (file_exists($gambar_km_awal) && file_exists($gambar_km_akhir)) {
            // Tambahkan teks "KM Awal" di atas gambar KM awal
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetXY(10, 200);
            $pdf->Cell(90, 10, 'KM Awal', 0, 1, 'C');

            // Tambahkan teks "KM Akhir" di atas gambar KM akhir
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetXY(110, 200);
            $pdf->Cell(90, 10, 'KM Akhir', 0, 1, 'C');

            // Menampilkan gambar KM awal dan KM akhir
            $pdf->Image($gambar_km_awal, 10, 210, 90, 60, 'jpg');
            $pdf->Image($gambar_km_akhir, 110, 210, 90, 60, 'jpg');
        } else {
            $pdf->Cell(0, 10, 'Gambar KM tidak ditemukan.', 0, 1, 'L');
        }

        // Spasi antara setiap baris data
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        // Output PDF
        $pdf->Output('D', $filename); // Menampilkan dialog download

        exit;
    } else {
        echo "<p>Dokumen laporan tidak ditemukan.</p>";
    }
} else {
    // Mendownload semua dokumen laporan dalam satu PDF
    $query = "SELECT * FROM laporan INNER JOIN users ON laporan.user_id = users.id";

    if (!empty($search_query)) {
        $query .= " WHERE tanggal LIKE '%$search_query%' OR alamat_awal LIKE '%$search_query%' OR alamat_tujuan LIKE '%$search_query%' OR username LIKE '%$search_query%'";
    }
    if (isset($user_id)) { // Pastikan variabel $user_id sudah berisi ID user yang telah login
        // Tambahkan kondisi untuk hanya mengambil data yang dimiliki oleh user yang login
        $query .= " AND laporan.user_id = $user_id";
    }

    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        // Tulis header tabel
        // ... Kode untuk menulis header tabel ...

        while ($row = $result->fetch_assoc()) {
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(0, 10, 'Laporan Perjalanan', 0, 1, 'C');
            $pdf->Ln();

            // ... Kode untuk menulis data laporan ...

            // Tabel utama
            $pdf->SetFont('Arial', '', 10);
            $header = array('Nama', 'Tanggal', 'Alamat Awal', 'Alamat Tujuan');
            foreach ($header as $col) {
                $pdf->Cell(37, 10, $col, 1);
            }
            $pdf->Ln();
            $pdf->Cell(37, 10, $row['username'], 1);
            $pdf->Cell(37, 10, $row['tanggal'], 1);
            $pdf->Cell(37, 10, $row['alamat_awal'], 1);
            $pdf->Cell(37, 10, $row['alamat_tujuan'], 1);
            $pdf->Ln();
            $pdf->Ln();
            // Tabel KM awal, KM akhir, dan Total KM
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetFont('Arial', '', 10);
            $header_km = array('KM Awal', 'KM Akhir', 'Total KM', 'Perkiraan BBM', 'Jenis Perjalanan');
            foreach ($header_km as $col) {
                $pdf->Cell(37, 10, $col, 1);
            }
            $pdf->Ln();

            $pdf->Cell(37, 10, $row['km_awal'], 1);
            $pdf->Cell(37, 10, $row['km_akhir'], 1);
            $total_km = $row['km_akhir'] - $row['km_awal'];
            $perkiraan_bbm = calculateBBM($row['jenis_perjalanan'], $row['tipe_mobil'], $total_km);
            $pdf->Cell(37, 10, $total_km, 1);
            $pdf->Cell(37, 10, $perkiraan_bbm, 1);
            $pdf->Cell(37, 10, $row['jenis_perjalanan'], 1);
            $pdf->Ln();

            // Tabel terpisah untuk data lainnya
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(0, 10, 'Data Lainnya', 0, 1, 'L');
            $pdf->SetFont('Arial', '', 10);
            $header2 = array('No Polisi', 'Tipe Mobil', 'Lampu Depan', 'Lampu Sen Depan', 'Lampu Sen Belakang');
            foreach ($header2 as $col) {
                $pdf->Cell(37, 10, $col, 1);
            }
            $pdf->Ln();

            $pdf->Cell(37, 10, $row['no_polisi'], 1);
            $pdf->Cell(37, 10, $row['tipe_mobil'], 1);
            $pdf->Cell(37, 10, $row['lampu_depan'], 1);
            $pdf->Cell(37, 10, $row['lampu_sen_depan'], 1);
            $pdf->Cell(37, 10, $row['lampu_sen_belakang'], 1);
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetFont('Arial', '', 10);
            $header2 = array('Lampu Rem', 'Lampu Mundur', 'Bodi', 'Ban', 'Pedal');
            foreach ($header2 as $col) {
                $pdf->Cell(37, 10, $col, 1);
            }
            $pdf->Ln();
            $pdf->Cell(37, 10, $row['lampu_rem'], 1);
            $pdf->Cell(37, 10, $row['lampu_mundur'], 1);
            $pdf->Cell(37, 10, $row['bodi'], 1);
            $pdf->Cell(37, 10, $row['ban'], 1);
            $pdf->Cell(37, 10, $row['pedal'], 1);
            $pdf->Ln();
            // Spasi antara setiap baris data
            $pdf->Ln();
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetFont('Arial', '', 10);
            $header2 = array('Kopling', 'Gas/Rem', 'Oli Mesin', 'Klakson', 'Weaper');
            foreach ($header2 as $col) {
                $pdf->Cell(37, 10, $col, 1);
            }
            $pdf->Ln();
            $pdf->Cell(37, 10, $row['kopling'], 1);
            $pdf->Cell(37, 10, $row['gas_rem'], 1);
            $pdf->Cell(37, 10, $row['oli_mesin'], 1);
            $pdf->Cell(37, 10, $row['klakson'], 1);
            $pdf->Cell(37, 10, $row['weaper'], 1);
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetFont('Arial', '', 10);

            $header2 = array('Air Weaper', 'Air Radiator');
            foreach ($header2 as $col) {
                $pdf->Cell(37, 10, $col, 1);
            }
            $pdf->Ln();
            $pdf->Cell(37, 10, $row['air_weaper'], 1);
            $pdf->Cell(37, 10, $row['air_radiator'], 1);
            $pdf->Ln();

            // Gabungkan gambar KM awal dan KM akhir menjadi satu gambar

            // Tampilkan gambar KM Awal
            $gambar_km_awal = 'uploads/' . $row['foto'];
            $gambar_km_akhir = 'uploads/' . $row['foto2'];

            if (file_exists($gambar_km_awal) && file_exists($gambar_km_akhir)) {
                // Tambahkan teks "KM Awal" di atas gambar KM awal
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->SetXY(10, 200);
                $pdf->Cell(90, 10, 'KM Awal', 0, 1, 'C');

                // Tambahkan teks "KM Akhir" di atas gambar KM akhir
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->SetXY(110, 200);
                $pdf->Cell(90, 10, 'KM Akhir', 0, 1, 'C');

                // Menampilkan gambar KM awal dan KM akhir
                $pdf->Image($gambar_km_awal, 10, 210, 90, 60, 'jpg');
                $pdf->Image($gambar_km_akhir, 110, 210, 90, 60, 'jpg');
            } else {
                $pdf->Cell(0, 10, 'Gambar KM tidak ditemukan.', 0, 1, 'L');
            }
            $pdf->Ln();
            $pdf->Ln();
            $pdf->Ln();
            $pdf->Ln();
            $pdf->Ln();
            $pdf->Ln();
            $pdf->Ln();
            $pdf->Ln();
            $pdf->Ln();
            $pdf->Ln();
        }
        $pdf->Ln();
        // Output PDF
        $pdf->Output('D', 'laporan_perjalanan_all.pdf'); // Menampilkan dialog download

        exit;
    } else {
        echo "<p>Tidak ada data yang dapat diunduh.</p>";
    }
}
?>