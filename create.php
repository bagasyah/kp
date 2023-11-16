<?php include 'inc/db.php'; ?>

<!DOCTYPE html>
<html>

<head>
    <title>Buat Laporan Perjalanan</title>
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

        .fot {
            font-size: 18px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="mt-3">Laporan Perjalanan</h2>
        <form method="POST" action="create_process.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="tanggal">Tanggal:</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
            </div>
            <div class="form-group">
                <label for="alamat_awal">Alamat Awal:</label>
                <input type="text" class="form-control" id="alamat_awal" name="alamat_awal" required>
            </div>
            <div class="form-group">
                <label for="alamat_tujuan">Alamat Tujuan:</label>
                <input type="text" class="form-control" id="alamat_tujuan" name="alamat_tujuan" required>
            </div>
            <div class="form-group">
                <label for="km_awal">KM Awal:</label>
                <input type="number" class="form-control" id="km_awal" name="km_awal" required>
            </div>
            <div class="form-group">
                <label for="km_akhir">KM Akhir:</label>
                <input type="number" class="form-control" id="km_akhir" name="km_akhir">
            </div>
            <div class="form-group">
                <label for="no_polisi">No Polisi:</label>
                <input type="text" class="form-control" id="no_polisi" name="no_polisi" required>
            </div>
            <div class="form-group">
                <label for="tipe_mobil">Tipe Mobil:</label>
                <select class="form-control" id="tipe_mobil" name="tipe_mobil" required>
                    <option value="innova">Innova</option>
                    <option value="avanza veloz">Avanza Veloz</option>
                    <option value="triton">Triton</option>
                    <option value="avanza putih">Avanza Putih</option>
                </select>
            </div>
            <div class="form-group">
                <label for="jenis_perjalanan">Jenis Perjalanan:</label>
                <select class="form-control" id="jenis_perjalanan" name="jenis_perjalanan" required>
                    <option value="luar">Luar</option>
                    <option value="dalam">Dalam</option>
                </select>
            </div>
            <div class="form-group">
                <label for="lampu_depan">Lampu Depan:</label><br>
                <input type="radio" id="lampu_depan_berfungsi" name="lampu_depan" value="berfungsi" required>
                <label for="lampu_depan_berfungsi">Berfungsi</label>
                <input type="radio" id="lampu_depan_rusak" name="lampu_depan" value="rusak" required>
                <label for="lampu_depan_rusak">Rusak</label>
            </div>
            <div class="form-group">
                <label for="lampu_sen_depan">Lampu Sen Depan:</label><br>
                <input type="radio" id="lampu_sen_depan_berfungsi" name="lampu_sen_depan" value="berfungsi" required>
                <label for="lampu_sen_depan_berfungsi">Berfungsi</label>
                <input type="radio" id="lampu_sen_depan_rusak" name="lampu_sen_depan" value="rusak" required>
                <label for="lampu_sen_depan_rusak">Rusak</label>
            </div>
            <div class="form-group">
                <label for="lampu_sen_belakang">Lampu Sen Belakang:</label><br>
                <input type="radio" id="lampu_sen_belakang_berfungsi" name="lampu_sen_belakang" value="berfungsi"
                    required>
                <label for="lampu_sen_belakang_berfungsi">Berfungsi</label>
                <input type="radio" id="lampu_sen_belakang_rusak" name="lampu_sen_belakang" value="rusak" required>
                <label for="lampu_sen_belakang_rusak">Rusak</label>
            </div>
            <div class="form-group">
                <label for="lampu_rem">Lampu Rem:</label><br>
                <input type="radio" id="lampu_rem_berfungsi" name="lampu_rem" value="berfungsi" required>
                <label for="lampu_rem_berfungsi">Berfungsi</label>
                <input type="radio" id="lampu_rem_rusak" name="lampu_rem" value="rusak" required>
                <label for="lampu_rem_rusak">Rusak</label>
            </div>
            <div class="form-group">
                <label for="lampu_mundur">Lampu Mundur:</label><br>
                <input type="radio" id="lampu_mundur_berfungsi" name="lampu_mundur" value="berfungsi" required>
                <label for="lampu_mundur_berfungsi">Berfungsi</label>
                <input type="radio" id="lampu_mundur_rusak" name="lampu_mundur" value="rusak" required>
                <label for="lampu_mundur_rusak">Rusak</label>
            </div>
            <div class="form-group">
                <label for="bodi">Bodi:</label><br>
                <input type="radio" id="bodi_baik" name="bodi" value="baik" required>
                <label for="bodi_baik">Baik</label>
                <input type="radio" id="bodi_rusak" name="bodi" value="rusak" required>
                <label for="bodi_rusak">Rusak</label>
            </div>
            <div class="form-group">
                <label for="ban">Ban:</label><br>
                <input type="radio" id="ban_baik" name="ban" value="baik" required>
                <label for="ban_baik">Baik</label>
                <input type="radio" id="ban_rusak" name="ban" value="rusak" required>
                <label for="ban_rusak">Rusak</label>
            </div>
            <div class="form-group">
                <label for="pedal">Pedal Gas:</label><br>
                <input type="radio" id="pedal_berfungsi" name="pedal" value="berfungsi" required>
                <label for="pedal_berfungsi">Berfungsi</label>
                <input type="radio" id="pedal_rusak" name="pedal" value="rusak" required>
                <label for="pedal_rusak">Rusak</label>
            </div>
            <div class="form-group">
                <label for="kopling">Pedal Kopling:</label><br>
                <input type="radio" id="kopling_berfungsi" name="kopling" value="berfungsi" required>
                <label for="kopling_berfungsi">Berfungsi</label>
                <input type="radio" id="kopling_rusak" name="kopling" value="rusak" required>
                <label for="kopling_rusak">Rusak</label>
            </div>
            <div class="form-group">
                <label for="gas_rem">Pedal Rem:</label><br>
                <input type="radio" id="gas_rem_berfungsi" name="gas_rem" value="berfungsi" required>
                <label for="gas_rem_berfungsi">Berfungsi</label>
                <input type="radio" id="gas_rem_rusak" name="gas_rem" value="rusak" required>
                <label for="gas_rem_rusak">Rusak</label>
            </div>
            <div class="form-group">
                <label for="klakson">Klakson:</label><br>
                <input type="radio" id="klakson_baik" name="klakson" value="baik" required>
                <label for="klakson_baik">Berfungsi</label>
                <input type="radio" id="klakson_rusak" name="klakson" value="rusak" required>
                <label for="klakson_rusak">Rusak</label>
            </div>
            <div class="form-group">
                <label for="weaper">Weaper:</label><br>
                <input type="radio" id="weaper_berfungsi" name="weaper" value="berfungsi" required>
                <label for="weaper_berfungsi">Berfungsi</label>
                <input type="radio" id="weaper_rusak" name="weaper" value="rusak" required>
                <label for="weaper_rusak">Rusak</label>
            </div>
            <div class="form-group">
                <label for="air_weaper">Air Weaper:</label><br>
                <input type="radio" id="air_weaper_terisi" name="air_weaper" value="terisi" required>
                <label for="air_weaper_terisi">Terisi</label>
                <input type="radio" id="air_weaper_kosong" name="air_weaper" value="kosong" required>
                <label for="air_weaper_kosong">Kosong</label>
            </div>
            <div class="form-group">
                <label for="air_radiator">Air Radiator:</label><br>
                <input type="radio" id="air_radiator_terisi" name="air_radiator" value="terisi" required>
                <label for="air_radiator_terisi">Terisi</label>
                <input type="radio" id="air_radiator_kosong" name="air_radiator" value="kosong" required>
                <label for="air_radiator_kosong">Kosong</label>
            </div>
            <div class="form-group">
                <label for="oli_mesin">Oli Mesin:</label><br>
                <input type="radio" id="oli_mesin_full" name="oli_mesin" value="terisi" required>
                <label for="oli_mesin_full">Terisi</label>
                <input type="radio" id="oli_mesin_kosong" name="oli_mesin" value="kosong" required>
                <label for="oli_mesin_kosong">Kosong</label>
            </div>
            <div class="form-group">
                <label for="note">Note:</label>
                <textarea class="form-control" id="note" name="note" rows="4"></textarea>
            </div>
            <div class="form-group">
                <label for="foto">Foto KM Awal:</label>
                <input type="file" id="foto" name="foto" required>
            </div>
            <div class="form-group">
                <label for="foto2">Foto KM Akhir:</label>
                <input type="file" id="foto2" name="foto2">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success" name="submit">Submit</button>
                <button type="button" class="btn btn-danger"
                    onclick="window.location.href='dashboard.php'">Cancel</button>
            </div>
        </form>
    </div>
</body>

</html>