<?php
include 'inc/db.php';

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Pastikan pengguna sudah login sebelumnya dan Anda memiliki cara untuk mendapatkan ID pengguna (misalnya dari variabel sesi)
session_start();
if (!isset($_SESSION['user_id'])) {
    die("Anda belum login. Silakan login terlebih dahulu.");
}

$user_id = $_SESSION['user_id'];

$search_query = "";
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
}

$query = "SELECT * FROM laporan INNER JOIN users ON laporan.user_id = users.id WHERE laporan.user_id = $user_id";

if (!empty($search_query)) {
    $query .= " AND (tanggal LIKE '%$search_query%' OR alamat_awal LIKE '%$search_query%' OR alamat_tujuan LIKE '%$search_query%' OR username LIKE '%$search_query%')";
}

$query .= " ORDER BY laporan.id DESC";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    // Nama file
    $filename = "laporan_perjalanan_" . date('Ymd') . ".csv";

    // Set header untuk file Excel
    header("Content-type: text/csv");
    header("Content-Disposition: attachment; filename=$filename");
    header("Pragma: no-cache");
    header("Expires: 0");

    // Buka file output untuk ditulis
    $output = fopen("php://output", "w");

    // Tulis baris header
    fputcsv($output, array('User', 'Tanggal', 'Alamat Awal', 'Alamat Tujuan', 'KM Awal', 'KM Akhir', 'Total KM', 'No. Polisi', 'Tipe Mobil', 'Jenis Perjalanan', 'Perkiraan BBM'));

    // Fungsi untuk menghitung perkiraan BBM
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

    // Tulis data dari database
    while ($row = $result->fetch_assoc()) {
        // Hitung total KM dan perkiraan BBM
        $total_km = $row['km_akhir'] - $row['km_awal'];
        $perkiraan_bbm = calculateBBM($row['jenis_perjalanan'], $row['tipe_mobil'], $total_km);

        fputcsv(
            $output,
            array(
                $row['username'],
                $row['tanggal'],
                $row['alamat_awal'],
                $row['alamat_tujuan'],
                $row['km_awal'],
                $row['km_akhir'],
                $total_km,
                $row['no_polisi'],
                $row['tipe_mobil'],
                $row['jenis_perjalanan'],
                $perkiraan_bbm,
            )
        );
    }

    // Tutup file output
    fclose($output);
    exit;
} else {
    echo "<p>Tidak ada data yang dapat diunduh.</p>";
}
?>