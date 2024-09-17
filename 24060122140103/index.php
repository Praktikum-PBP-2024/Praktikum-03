<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <title>Tugas Praktikum PBP Pertemuan 3</title>
    <script>
        function validateKelas() {
            var kelas = document.getElementById("kelas").value;
            var ekstrakurikuler = document.getElementById("ekstrakurikuler");

            if (kelas === "XII") {
                ekstrakurikuler.style.display = "none";
            } else {
                ekstrakurikuler.style.display = "block";
            }
        }

        function resetForm() {
            document.querySelector("form").reset();
            validateKelas();
        }
    </script>
</head>
<body class="container">
    <?php
        if (isset($_POST['submit'])) {
            $nis = $_POST['nis'];
            if (empty($nis)) {
                $error_nis = "NIS harus diisi";
            } else if (!preg_match("/^[0-9]{10}$/", $nis)) {
                $error_nis = "NIS harus terdiri dari 10 karakter berisi angka 0..9";
            }

            $nama = $_POST['nama'];
            if (empty($nama)) {
                $error_nama = "Nama harus diisi";
            } else if (!preg_match("/^[a-zA-Z ]*$/", $nama)) {
                $error_nama = "Nama harus terdiri dari huruf dan spasi";
            }

            $jenis_kelamin = $_POST['jenis_kelamin'];
            if (empty($jenis_kelamin)) {
                $error_jenis_kelamin = "Jenis Kelamin harus diisi";
            }

            $kelas = $_POST['kelas'];
            if (empty($kelas)) {
                $error_kelas = "Kelas harus diisi";
            }

            if (isset($_POST['ekstrakurikuler'])) {
                $ekstrakurikuler = $_POST['ekstrakurikuler'];
            } else {
                $ekstrakurikuler = array();
            }
            if (($kelas === "X" || $kelas === "XI") && (count($ekstrakurikuler) < 1 || count($ekstrakurikuler) > 3)) {
                $error_ekstrakurikuler = "Ekstrakurikuler harus dipilih, minimal 1 dan maksimal 3";
            }
        }   
    ?>
    <div class="card">
        <div class="card-header">Form Input Siswa</div>
        <div class="card-body">
            <form action="" method="POST" class="">
                <div class="form-group">
                    <label for="nis">NIS:</label>
                    <input type="text" class="form-control" id="nis" name="nis" value="<?php if (isset($nis)) echo $nis;?>">
                    <div class="error text-danger"><?php if (isset($error_nis)) echo $error_nis;?></div>
                </div>
                <br />
                <div class="form-group">
                    <label for="nama">Nama:</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?php if (isset($nama)) echo $nama;?>">
                    <div class="error text-danger"><?php if (isset($error_nama)) echo $error_nama;?></div>
                </div>
                <br />
                <div class="form-group">
                    <label>Jenis Kelamin:</label>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="jenis_kelamin" value="pria" <?php if (isset($jenis_kelamin) && $jenis_kelamin == "pria") echo "checked";?>>Pria
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="jenis_kelamin" value="wanita" <?php if (isset($jenis_kelamin) && $jenis_kelamin == "wanita") echo "checked";?>>Wanita
                        </label>
                    </div>
                    <div class="error text-danger"><?php if (isset($error_jenis_kelamin)) echo $error_jenis_kelamin;?></div>
                </div>
                <br />
                <div class="form-group">
                    <label for="kelas">Kelas:</label>
                    <select name="kelas" id="kelas" class="form-control" onchange="validateKelas()">
                        <option value=""disabled selected>--Pilih Kelas--</option>
                        <option value="X" <?php if (isset($kelas) && $kelas == "X") echo "selected";?>>X</option>
                        <option value="XI" <?php if (isset($kelas) && $kelas == "XI") echo "selected";?>>XI</option>
                        <option value="XII" <?php if (isset($kelas) && $kelas == "XII") echo "selected";?>>XII</option>
                    </select>
                    <div class="error text-danger"><?php if (isset($error_kelas)) echo $error_kelas;?></div>
                </div>
                <br />
                <div class="form-group" id="ekstrakurikuler" style="display:block;">
                    <label>Ekstrakurikuler:</label>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="ekstrakurikuler[]" value="pramuka" <?php if (isset($ekstrakurikuler) && in_array("pramuka", $ekstrakurikuler)) echo "checked";?>>Pramuka
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="ekstrakurikuler[]" value="seni_tari" <?php if (isset($ekstrakurikuler) && in_array("seni_tari", $ekstrakurikuler)) echo "checked";?>>Seni Tari
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="ekstrakurikuler[]" value="sinematografi" <?php if (isset($ekstrakurikuler) && in_array("sinematografi", $ekstrakurikuler)) echo "checked";?>>Sinematografi
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="ekstrakurikuler[]" value="basket" <?php if (isset($ekstrakurikuler) && in_array("basket", $ekstrakurikuler)) echo "checked";?>>Basket
                        </label>
                    </div>
                    <div class="error text-danger"><?php if (isset($error_ekstrakurikuler)) echo $error_ekstrakurikuler;?></div>
                </div>
                <br />
                <button type="submit" class="btn btn-primary" name="submit" value="submit">Submit</button>
                <button type="button" class="btn btn-danger" onclick="resetForm()">Reset</button>
            </form>
            <br />
            <?php 
                if (isset($_POST['submit']) && (empty($error_nis) && empty($error_nama) && empty($error_jenis_kelamin) && empty($error_kelas) && empty($error_ekstrakurikuler))) {
                    echo '<h3>Your Input:</h3>';
                    echo 'NIS: ' . $_POST['nis'] . '<br />';
                    echo 'Nama: ' . $_POST['nama'] . '<br />';
                    
                    echo 'Jenis Kelamin: ';
                    if ($_POST['jenis_kelamin'] == 'pria') {
                        echo 'Pria';
                    } elseif ($_POST['jenis_kelamin'] == 'wanita') {
                        echo 'Wanita';
                    }
                    echo '<br />';
                    echo 'Kelas: ' . $_POST['kelas'] . '<br />';
                    
                    $ekstrakurikuler_mapping = array(
                        'pramuka' => 'Pramuka',
                        'seni_tari' => 'Seni Tari',
                        'sinematografi' => 'Sinematografi',
                        'basket' => 'Basket'
                    );

                    $ekstrakurikuler = $_POST['ekstrakurikuler'];
                    if (!empty($ekstrakurikuler)) {
                        echo 'Ekstrakurikuler: ';
                        foreach ($ekstrakurikuler as $ekstrakurikuler_pilihan) {
                            echo '<br /> - ' . $ekstrakurikuler_mapping[$ekstrakurikuler_pilihan];
                        }
                    }
                }
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>
