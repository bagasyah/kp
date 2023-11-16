<?php
include 'inc/db.php';

$id = $_GET['id'];
$query = "SELECT * FROM laporan WHERE id='$id'";
$result = $conn->query($query);
$row = $result->fetch_assoc();

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $tanggal = $_POST['tanggal'];
    $alamat_awal = $_POST['alamat_awal'];
    $alamat_tujuan = $_POST['alamat_tujuan'];
    $km_awal = $_POST['km_awal'];
    $km_akhir = $_POST['km_akhir'];
    $no_polisi = $_POST['no_polisi'];
    $tipe_mobil = $_POST['tipe_mobil'];
    $jenis_perjalanan = $_POST['jenis_perjalanan'];
    $note = $_POST['note'];
    $foto = $_FILES['foto']['name'];
    $foto2 = $_FILES['foto2']['name'];
    $lampu_depan = '';
    $lampu_sen_depan = '';
    $lampu_sen_belakang = '';
    $lampu_rem = '';
    $lampu_mundur = '';
    $bodi = '';
    $ban = '';
    $pedal = '';
    $kopling = '';
    $gas_rem = '';
    $oli_mesin = '';
    $klakson = '';
    $weaper = '';
    $air_weaper = '';
    $air_radiator = '';

    if (isset($_POST['lampu_depan'])) {
        $lampu_depan = $_POST['lampu_depan'];
        $lampu_sen_depan = $lampu_depan === 'berfungsi' ? 'rusak' : 'berfungsi';
    } elseif (isset($_POST['lampu_sen_depan'])) {
        $lampu_sen_depan = $_POST['lampu_sen_depan'];
        $lampu_depan = $lampu_sen_depan === 'berfungsi' ? 'rusak' : 'berfungsi';
    }

    if (isset($_POST['lampu_sen_belakang'])) {
        $lampu_sen_belakang = $_POST['lampu_sen_belakang'];
    }

    if (isset($_POST['lampu_rem'])) {
        $lampu_rem = $_POST['lampu_rem'];
    }

    if (isset($_POST['lampu_mundur'])) {
        $lampu_mundur = $_POST['lampu_mundur'];
    }

    if (isset($_POST['bodi'])) {
        $bodi = $_POST['bodi'];
    }

    if (isset($_POST['ban'])) {
        $ban = $_POST['ban'];
    }

    if (isset($_POST['pedal'])) {
        $pedal = $_POST['pedal'];
    }

    if (isset($_POST['kopling'])) {
        $kopling = $_POST['kopling'];
    }

    if (isset($_POST['gas_rem'])) {
        $gas_rem = $_POST['gas_rem'];
    }

    if (isset($_POST['oli_mesin'])) {
        $oli_mesin = $_POST['oli_mesin'];
    }

    if (isset($_POST['klakson'])) {
        $klakson = $_POST['klakson'];
    }

    if (isset($_POST['weaper'])) {
        $weaper = $_POST['weaper'];
    }

    if (isset($_POST['air_weaper'])) {
        $air_weaper = $_POST['air_weaper'];
    }

    if (isset($_POST['air_radiator'])) {
        $air_radiator = $_POST['air_radiator'];
    }

    // Check if a new photo file is uploaded
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $foto = $_FILES['foto']['name'];
        $foto_tmp = $_FILES['foto']['tmp_name'];
        $foto_path = 'uploads/' . $foto;

        // Move the uploaded file to the uploads folder
        if (move_uploaded_file($foto_tmp, $foto_path)) {
            // Update the photo in the database
            $query = "UPDATE laporan SET tanggal='$tanggal', alamat_awal='$alamat_awal', alamat_tujuan='$alamat_tujuan', km_awal='$km_awal', km_akhir='$km_akhir', foto='$foto', lampu_depan='$lampu_depan', lampu_sen_depan='$lampu_sen_depan', lampu_sen_belakang='$lampu_sen_belakang', lampu_rem='$lampu_rem', lampu_mundur='$lampu_mundur', bodi='$bodi', ban='$ban', pedal='$pedal', kopling='$kopling', gas_rem='$gas_rem', oli_mesin='$oli_mesin', klakson='$klakson', weaper='$weaper', air_weaper='$air_weaper', air_radiator='$air_radiator', note='$note' WHERE id='$id'";
            if ($conn->query($query) === TRUE) {
                header("Location: detail.php");
                exit();
            } else {
                echo "Error: " . $query . "<br>" . $conn->error;
            }
        } else {
            echo "Failed to move uploaded file.";
        }
    }

    // Check if a new foto2 file is uploaded
    if (isset($_FILES['foto2']) && $_FILES['foto2']['error'] === UPLOAD_ERR_OK) {
        $foto2 = $_FILES['foto2']['name'];
        $foto2_tmp = $_FILES['foto2']['tmp_name'];
        $foto2_path = 'uploads/' . $foto2;


        // Move the uploaded file to the uploads folder
        if (move_uploaded_file($foto_tmp, $foto_path)) {
            // Update the photo in the database
            $query = "UPDATE laporan SET tanggal='$tanggal', alamat_awal='$alamat_awal', alamat_tujuan='$alamat_tujuan', km_awal='$km_awal', km_akhir='$km_akhir', foto='$foto', lampu_depan='$lampu_depan', lampu_sen_depan='$lampu_sen_depan', lampu_sen_belakang='$lampu_sen_belakang', lampu_rem='$lampu_rem', lampu_mundur='$lampu_mundur', bodi='$bodi', ban='$ban', pedal='$pedal', kopling='$kopling', gas_rem='$gas_rem', oli_mesin='$oli_mesin', klakson='$klakson', weaper='$weaper', air_weaper='$air_weaper', air_radiator='$air_radiator', note='$note' WHERE id='$id'";
            if ($conn->query($query) === TRUE) {
                header("Location: detail.php");
                exit();
            } else {
                echo "Error: " . $query . "<br>" . $conn->error;
            }
        } else {
            echo "Failed to move uploaded file.";
        }
    }

    // No new photo uploaded, update other fields in the database
    $query = "UPDATE laporan SET tanggal='$tanggal', alamat_awal='$alamat_awal', alamat_tujuan='$alamat_tujuan', km_awal='$km_awal', km_akhir='$km_akhir', foto2='$foto2', lampu_depan='$lampu_depan', lampu_sen_depan='$lampu_sen_depan', lampu_sen_belakang='$lampu_sen_belakang', lampu_rem='$lampu_rem', lampu_mundur='$lampu_mundur', bodi='$bodi', ban='$ban', pedal='$pedal', kopling='$kopling', gas_rem='$gas_rem', oli_mesin='$oli_mesin', klakson='$klakson', weaper='$weaper', air_weaper='$air_weaper', air_radiator='$air_radiator', note='$note' WHERE id='$id'";
    if ($conn->query($query) === TRUE) {
        header("Location: detail.php");
        exit();
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Laporan Perjalanan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        .container {
            padding: 30px;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        h3 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .form-control {
            font-size: 16px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-group input[type="radio"],
        .form-group input[type="checkbox"] {
            margin-right: 5px;
        }

        .btn {
            font-size: 18px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Edit Laporan Perjalanan</h2>
        <form method="POST" action="edit.php" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="form-group">
                <label for="tanggal">Tanggal:</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal"
                    value="<?php echo $row['tanggal']; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="alamat_awal">Alamat Awal:</label>
                <input type="text" class="form-control" id="alamat_awal" name="alamat_awal"
                    value="<?php echo $row['alamat_awal']; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="alamat_tujuan">Alamat Tujuan:</label>
                <input type="text" class="form-control" id="alamat_tujuan" name="alamat_tujuan"
                    value="<?php echo $row['alamat_tujuan']; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="km_awal">KM Awal:</label>
                <input type="number" class="form-control" id="km_awal" name="km_awal"
                    value="<?php echo $row['km_awal']; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="km_akhir">KM Akhir:</label>
                <input type="number" class="form-control" id="km_akhir" name="km_akhir"
                    value="<?php echo $row['km_akhir']; ?>" required>
            </div>
            <div class="form-group">
                <label for="no_polisi">No Polisi:</label>
                <input type="text" class="form-control" id="no_polisi" name="no_polisi"
                    value="<?php echo $row['no_polisi']; ?>" required>
            </div>
            <div class="form-group">
                <label for="tipe_mobil">Tipe Mobil:</label>
                <select class="form-control" id="tipe_mobil" name="tipe_mobil" required>
                    <option value="innova" <?php if ($row['tipe_mobil'] === 'innova')
                        echo 'selected'; ?>>Innova</option>
                    <option value="avanza veloz" <?php if ($row['tipe_mobil'] === 'avanza veloz')
                        echo 'selected'; ?>>Avanza Veloz</option>
                    <option value="triton" <?php if ($row['tipe_mobil'] === 'triton')
                        echo 'selected'; ?>>Triton</option>
                    <option value="avanza putih" <?php if ($row['tipe_mobil'] === 'avanza putih')
                        echo 'selected'; ?>>Avanza Putih</option>
                </select>
            </div>
            <div class="form-group">
                <label for="jenis_perjalanan">Tipe Mobil:</label>
                <select class="form-control" id="jenis_perjalanan" name="jenis_perjalanan" required>
                    <option value="luar" <?php if ($row['jenis_perjalanan'] === 'luar')
                        echo 'selected'; ?>>luar</option>
                    <option value="dalam" <?php if ($row['jenis_perjalanan'] === 'dalam')
                        echo 'selected'; ?>>dalam
                    </option>
                </select>
            </div>
            <h2>Navigasi</h2>
            <div class="form-group">
                <label for="lampu_depan">Lampu Depan:</label><br>
                <input type="radio" id="lampu_depan_berfungsi" name="lampu_depan" value="berfungsi" <?php if ($row['lampu_depan'] === 'berfungsi')
                    echo 'checked'; ?> required>
                <label for="lampu_depan_berfungsi">Berfungsi</label>
                <input type="radio" id="lampu_depan_rusak" name="lampu_depan" value="rusak" <?php if ($row['lampu_depan'] === 'rusak')
                    echo 'checked'; ?> required>
                <label for="lampu_depan_rusak">Rusak</label>
            </div>
            <div class="form-group">
                <label for="lampu_sen_depan">Lampu Sen Depan:</label><br>
                <input type="radio" id="lampu_sen_depan_berfungsi" name="lampu_sen_depan" value="berfungsi" <?php if ($row['lampu_sen_depan'] === 'berfungsi')
                    echo 'checked'; ?> required>
                <label for="lampu_sen_depan_berfungsi">Berfungsi</label>
                <input type="radio" id="lampu_sen_depan_rusak" name="lampu_sen_depan" value="rusak" <?php if ($row['lampu_sen_depan'] === 'rusak')
                    echo 'checked'; ?> required>
                <label for="lampu_sen_depan_rusak">Rusak</label>
            </div>
            <div class="form-group">
                <label for="lampu_sen_belakang">Lampu Sen Belakang:</label><br>
                <input type="radio" id="lampu_sen_belakang_berfungsi" name="lampu_sen_belakang" value="berfungsi" <?php if ($row['lampu_sen_belakang'] === 'berfungsi')
                    echo 'checked'; ?>>
                <label for="lampu_sen_belakang_berfungsi">Berfungsi</label>
                <input type="radio" id="lampu_sen_belakang_rusak" name="lampu_sen_belakang" value="rusak" <?php if ($row['lampu_sen_belakang'] === 'rusak')
                    echo 'checked'; ?>>
                <label for="lampu_sen_belakang_rusak">Rusak</label>
            </div>
            <div class="form-group">
                <label for="lampu_rem">Lampu Rem:</label><br>
                <input type="radio" id="lampu_rem_berfungsi" name="lampu_rem" value="berfungsi" <?php if ($row['lampu_rem'] === 'berfungsi')
                    echo 'checked'; ?>>
                <label for="lampu_rem_berfungsi">Berfungsi</label>
                <input type="radio" id="lampu_rem_rusak" name="lampu_rem" value="rusak" <?php if ($row['lampu_rem'] === 'rusak')
                    echo 'checked'; ?>>
                <label for="lampu_rem_rusak">Rusak</label>
            </div>
            <div class="form-group">
                <label for="lampu_mundur">Lampu Mundur:</label><br>
                <input type="radio" id="lampu_mundur_berfungsi" name="lampu_mundur" value="berfungsi" <?php if ($row['lampu_mundur'] === 'berfungsi')
                    echo 'checked'; ?>>
                <label for="lampu_mundur_berfungsi">Berfungsi</label>
                <input type="radio" id="lampu_mundur_rusak" name="lampu_mundur" value="rusak" <?php if ($row['lampu_mundur'] === 'rusak')
                    echo 'checked'; ?>>
                <label for="lampu_mundur_rusak">Rusak</label>
            </div>
            <h2>Bagian Mobil</h2>
            <div class="form-group">
                <label for="bodi">Bodi:</label><br>
                <input type="radio" id="bodi_baik" name="bodi" value="baik" <?php if ($row['bodi'] === 'baik')
                    echo 'checked'; ?>>
                <label for="bodi_baik">Baik</label>
                <input type="radio" id="bodi_rusak" name="bodi" value="rusak" <?php if ($row['bodi'] === 'rusak')
                    echo 'checked'; ?>>
                <label for="bodi_rusak">Rusak</label>
            </div>
            <div class="form-group">
                <label for="ban">Ban:</label><br>
                <input type="radio" id="ban_baik" name="ban" value="baik" <?php if ($row['ban'] === 'baik')
                    echo 'checked'; ?>>
                <label for="ban_baik">Baik</label>
                <input type="radio" id="ban_rusak" name="ban" value="rusak" <?php if ($row['ban'] === 'rusak')
                    echo 'checked'; ?>>
                <label for="ban_rusak">Rusak</label>
            </div>
            <div class="form-group">
                <label for="pedal">Pedal Gas:</label><br>
                <input type="radio" id="pedal_berfungsi" name="pedal" value="berfungsi" <?php if ($row['pedal'] === 'berfungsi')
                    echo 'checked'; ?>>
                <label for="pedal_berfungsi">Berfungsi</label>
                <input type="radio" id="pedal_rusak" name="pedal" value="rusak" <?php if ($row['pedal'] === 'rusak')
                    echo 'checked'; ?>>
                <label for="pedal_rusak">Rusak</label>
            </div>
            <div class="form-group">
                <label for="kopling">Pedal Kopling:</label><br>
                <input type="radio" id="kopling_berfungsi" name="kopling" value="berfungsi" <?php if ($row['kopling'] === 'berfungsi')
                    echo 'checked'; ?>>
                <label for="kopling_berfungsi">Berfungsi</label>
                <input type="radio" id="kopling_rusak" name="kopling" value="rusak" <?php if ($row['kopling'] === 'rusak')
                    echo 'checked'; ?>>
                <label for="kopling_rusak">Rusak</label>
            </div>
            <div class="form-group">
                <label for="gas_rem">Pedal Rem:</label><br>
                <input type="radio" id="gas_rem_berfungsi" name="gas_rem" value="berfungsi" <?php if ($row['gas_rem'] === 'berfungsi')
                    echo 'checked'; ?>>
                <label for="gas_rem_berfungsi">Berfungsi</label>
                <input type="radio" id="gas_rem_rusak" name="gas_rem" value="rusak" <?php if ($row['gas_rem'] === 'rusak')
                    echo 'checked'; ?>>
                <label for="gas_rem_rusak">Rusak</label>
            </div>
            <div class="form-group">
                <label for="klakson">Klakson:</label><br>
                <input type="radio" id="klakson_baik" name="klakson" value="baik" <?php if ($row['klakson'] === 'baik')
                    echo 'checked'; ?>>
                <label for="klakson_baik">Baik</label>
                <input type="radio" id="klakson_rusak" name="klakson" value="rusak" <?php if ($row['klakson'] === 'rusak')
                    echo 'checked'; ?>>
                <label for="klakson_rusak">Rusak</label>
            </div>
            <div class="form-group">
                <label for="weaper">Weaper:</label><br>
                <input type="radio" id="weaper_berfungsi" name="weaper" value="berfungsi" <?php if ($row['weaper'] === 'berfungsi')
                    echo 'checked'; ?>>
                <label for="weaper_berfungsi">Berfungsi</label>
                <input type="radio" id="weaper_rusak" name="weaper" value="rusak" <?php if ($row['weaper'] === 'rusak')
                    echo 'checked'; ?>>
                <label for="weaper_rusak">Rusak</label>
            </div>
            <div class="form-group">
                <label for="air_weaper">Air Weaper:</label><br>
                <input type="radio" id="air_weaper_terisi" name="air_weaper" value="terisi" <?php if ($row['air_weaper'] === 'terisi')
                    echo 'checked'; ?>>
                <label for="air_weaper_terisi">Terisi</label>
                <input type="radio" id="air_weaper_tidak_terisi" name="air_weaper" value="tidak terisi" <?php if ($row['air_weaper'] === 'tidak terisi')
                    echo 'checked'; ?>>
                <label for="air_weaper_tidak_terisi">Tidak Terisi</label>
            </div>
            <div class="form-group">
                <label for="air_radiator">Air Radiator:</label><br>
                <input type="radio" id="air_radiator_terisi" name="air_radiator" value="terisi" <?php if ($row['air_radiator'] === 'terisi')
                    echo 'checked'; ?>>
                <label for="air_radiator_terisi">Terisi</label>
                <input type="radio" id="air_radiator_tidak_terisi" name="air_radiator" value="kosong" <?php if ($row['air_radiator'] === 'kosong')
                    echo 'checked'; ?>>
                <label for="air_radiator_tidak_terisi">Kosong</label>
            </div>
            <div class="form-group">
                <label for="oli_mesin">Oli Mesin:</label><br>
                <input type="radio" id="oli_mesin_terisi" name="oli_mesin" value="terisi" <?php if ($row['oli_mesin'] === 'terisi')
                    echo 'checked'; ?>>
                <label for="oli_mesin_terisi">Terisi</label>
                <input type="radio" id="oli_mesin_tidak_terisi" name="oli_mesin" value="kosong" <?php if ($row['oli_mesin'] === 'kosong')
                    echo 'checked'; ?>>
                <label for="oli_mesin_tidak_terisi">Kosong</label>
            </div>
            <div class="form-group">
                <label for="foto">Foto:</label><br>
                <img src="uploads/<?php echo $row['foto']; ?>" alt="Foto" width="200"><br>
                <input type="file" class="form-control-file" id="foto" name="foto">
            </div>
            <div class="form-group">
                <label for="foto2">Foto:</label><br>
                <img src="uploads/<?php echo $row['foto2']; ?>" alt="Foto2" width="200"><br>
                <input type="file" class="form-control-file" id="foto2" name="foto2">
            </div>
            <div class="form-group">
                <label for="note">Note:</label>
                <textarea class="form-control" id="note" name="note"><?php echo $row['note']; ?></textarea>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            <button type="button" class="btn btn-danger" onclick="window.location.href='detail.php'">Cancel</button>
        </form>
    </div>
</body>

</html>