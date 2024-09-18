<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        .invalid-feedback {
            display: block;
        }
    </style>
</head>
<body>
    <?php
        if (isset($_POST["submit"])) {
            $errors = [];

            $nis = $_POST['nis'];
            if (empty($nis)) {
                $errors['nis'] = "NIS wajib diisi.";
            } elseif (!preg_match("/^\d{10}$/", $nis)) {
                $errors['nis'] = "NIS harus 10 karakter dan hanya berisi angka 0-9.";
            }
        
            $nama = $_POST['nama'];
            if (empty($nama)) {
                $errors['nama'] = "Nama wajib diisi.";
            }
        
            if (empty($_POST['jenis_kelamin'])) {
                $errors['jenis_kelamin'] = "Jenis kelamin wajib dipilih.";
            }
        
            $kelas = $_POST['kelas'];
            if ($kelas === "X" || $kelas === "XI") {
                if (empty($_POST['ekstrakurikuler'])) {
                    $errors['ekstrakurikuler'] = "Ekstrakurikuler wajib dipilih minimal 1 kegiatan untuk kelas X atau XI.";
                } else {
                    $ekstrakurikuler = $_POST['ekstrakurikuler'];
                    if (count($ekstrakurikuler) < 1 || count($ekstrakurikuler) > 3) {
                        $errors['ekstrakurikuler'] = "Pilih minimal 1 dan maksimal 3 kegiatan ekstrakurikuler.";
                    }
                }
            }
        
            if ($kelas === "XII" && !empty($_POST['ekstrakurikuler'])) {
                $errors['kelas'] = "Kelas XII tidak boleh mengikuti kegiatan ekstrakurikuler.";
            }

        }
    ?>

    <div class="container col-6 mx-auto">
        <form method="post" action="" class="g-3 border">
            <div class="form-group has-validation">
                <label for="nis">NIS:</label>
                <input type="text" class="form-control" id="nis" name="nis" maxlength="10" value="<?= isset($_POST['nis']) ? $_POST['nis'] : '' ?>">

                <div id="nisFeedback" class="invalid-feedback">
                    <?= isset($errors['nis']) ? $errors['nis'] : '' ?>
                </div>
            </div>
    
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?= isset($_POST['nama']) ? $_POST['nama'] : '' ?>">

                <div id="nisFeedback" class="invalid-feedback">
                    <?= isset($errors['nama']) ? $errors['nama'] : '' ?>
                </div>
            </div>
    
            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin:</label>
                
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="pria" value="Pria" <?= isset($_POST['jenis_kelamin']) && $_POST['jenis_kelamin'] == 'Pria' ? 'checked' : '' ?>>
                    <label class="form-check-label" for="pria">Pria</label>
                </div>
    
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="wanita" value="Wanita" <?= isset($_POST['jenis_kelamin']) && $_POST['jenis_kelamin'] == 'Wanita' ? 'checked' : '' ?>>
                    <label class="form-check-label" for="wanita">Wanita</label>
                </div>

                <div id="nisFeedback" class="invalid-feedback">
                    <?= isset($errors['jenis_kelamin']) ? $errors['jenis_kelamin'] : '' ?>
                </div>
            </div>
    
            <div class="form-group">
                <label for="kelas">Kelas:</label>
    
                <select class="form-select" name="kelas" id="kelas" onchange="toggleEkstrakurikuler()">
                    <option value="X" <?= isset($_POST['kelas']) && $_POST['kelas'] == 'X' ? 'selected' : '' ?>>X</option>
                    <option value="XI" <?= isset($_POST['kelas']) && $_POST['kelas'] == 'XI' ? 'selected' : '' ?>>XI</option>
                    <option value="XII" <?= isset($_POST['kelas']) && $_POST['kelas'] == 'XII' ? 'selected' : '' ?>>XII</option>
                </select>

                <div id="nisFeedback" class="invalid-feedback">
                    <?= isset($errors['kelas']) ? $errors['kelas'] : '' ?>
                </div>
            </div>
    
            <div class="form-group" id="ekstrakurikuler">
                <label for="ekstrakurikuler">Ekstrakulikuler:</label>
    
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Pramuka" name="ekstrakurikuler[]" id="pramuka" <?= isset($_POST['ekstrakurikuler']) && in_array('Pramuka', $_POST['ekstrakurikuler']) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="pramuka">
                        Pramuka
                    </label>
                </div>
    
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Seni Tari" name="ekstrakurikuler[]" id="seni_tari" <?= isset($_POST['ekstrakurikuler']) && in_array('Seni Tari', $_POST['ekstrakurikuler']) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="seni_tari">
                        Seni Tari
                    </label>
                </div>
    
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Sinematografi" name="ekstrakurikuler[]" id="sinematografi" <?= isset($_POST['ekstrakurikuler']) && in_array('Sinematografi', $_POST['ekstrakurikuler']) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="sinematografi">
                        Sinematografi
                    </label>
                </div>
    
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Basket" name="ekstrakurikuler[]" id="basket" <?= isset($_POST['ekstrakurikuler']) && in_array('Basket', $_POST['ekstrakurikuler']) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="basket">
                        Basket
                    </label>
                </div>

                <div id="nisFeedback" class="invalid-feedback">
                    <?= isset($errors['ekstrakurikuler']) ? $errors['ekstrakurikuler'] : '' ?>
                </div>
            </div>
            <br>
    
            <div class="form-group">
                <button type="submit" class="btn btn-primary" name="submit" value="submit">
                    Submit
                </button>

                <a href="index.php" class="btn btn-danger">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <?php
        if (empty($errors) && isset($_POST["submit"])) {
            echo "Form berhasil disubmit!<br>";
            echo "NIS: " . htmlspecialchars($nis) . "<br>";
            echo "Nama: " . htmlspecialchars($nama) . "<br>";
            echo "Jenis Kelamin: " . htmlspecialchars($_POST['jenis_kelamin']) . "<br>";
            echo "Kelas: " . htmlspecialchars($kelas) . "<br>";
    
            if (isset($ekstrakurikuler)) {
                echo "Ekstrakurikuler: " . implode(", ", $ekstrakurikuler) . "<br>";
            }
        }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        function toggleEkstrakurikuler() {
            const kelas = document.getElementById('kelas').value;
            const ekstrakurikulerDiv = document.getElementById('ekstrakurikuler');
            if (kelas === 'X' || kelas === 'XI') {
                ekstrakurikulerDiv.style.display = 'block';
            } else {
                ekstrakurikulerDiv.style.display = 'none';
            }
        }
    </script>
</body>
</html>