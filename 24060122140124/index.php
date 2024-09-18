<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php
    $nisError = $namaError = $jenisKelaminError = $kelasError = $ekskulError = "";
    $nis = $nama = $jenis_kelamin = $kelas = "";
    $ekskul = [];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validasi NIS
        if (empty($_POST["nis"])) {
            $nisError = "NIS wajib diisi.";
        } elseif (!preg_match("/^[0-9]{10}$/", $_POST["nis"])) {
            $nisError = "NIS harus terdiri dari 10 karakter dan hanya berisi angka.";
        } else {
            $nis = $_POST["nis"];
        }

        // Validasi Nama
        if (empty($_POST["nama"])) {
            $namaError = "Nama wajib diisi.";
        } else {
            $nama = $_POST["nama"];
        }

        // Validasi Jenis Kelamin
        if (empty($_POST["jenis_kelamin"])) {
            $jenisKelaminError = "Jenis kelamin wajib dipilih.";
        } else {
            $jenis_kelamin = $_POST["jenis_kelamin"];
        }

        // Validasi Kelas
        if (empty($_POST["kelas"])) {
            $kelasError = "Kelas wajib dipilih.";
        } else {
            $kelas = $_POST["kelas"];
        }

        // Validasi Ekstrakurikuler
        if ($kelas == "x" || $kelas == "xi") {
            if (empty($_POST["ekskul"])) {
                $ekskulError = "Minimal memilih 1 ekstrakurikuler.";
            } elseif (count($_POST["ekskul"]) > 3) {
                $ekskulError = "Maksimal memilih 3 ekstrakurikuler.";
            } else {
                $ekskul = $_POST["ekskul"];
            }
        }
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="nis">NIS:</label>
            <input type="text" class="form-control" id="nis" name="nis" maxlength="10" value="<?php echo $nis; ?>">
            <span class="text-danger"><?php echo $nisError; ?></span>
        </div>
        <div class="form-group">
            <label for="nama">Nama:</label>
            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama; ?>">
            <span class="text-danger"><?php echo $namaError; ?></span>
        </div>
        <label>Jenis Kelamin:</label>
        <div class="form-check">
            <label class="form-check-label">
                <input type="radio" class="form-check-input" name="jenis_kelamin" value="pria" <?php if ($jenis_kelamin == "pria") echo "checked"; ?>>
                Pria
            </label>
        </div>
        <div class="form-check">
            <label class="form-check-label">
                <input type="radio" class="form-check-input" name="jenis_kelamin" value="wanita" <?php if ($jenis_kelamin == "wanita") echo "checked"; ?>>
                Wanita
            </label>
        </div>
        <span class="text-danger"><?php echo $jenisKelaminError; ?></span>
        <br>
        <div class="form-group">
            <label for="kelas">Kelas:</label>
            <select id="kelas" name="kelas" class="form-control" onchange="toggleEkskul(this.value)">
                <option value="">-- Pilih Kelas --</option>
                <option value="x" <?php if ($kelas == "x") echo "selected"; ?>>X</option>
                <option value="xi" <?php if ($kelas == "xi") echo "selected"; ?>>XI</option>
                <option value="xii" <?php if ($kelas == "xii") echo "selected"; ?>>XII</option>
            </select>
            <span class="text-danger"><?php echo $kelasError; ?></span>
        </div>
        
        <div id="ekskulSection" style="display: none;">
            <label>Ekstrakulikuler:</label>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="ekskul[]" value="pramuka" <?php if (in_array("pramuka", $ekskul)) echo "checked"; ?>>
                    Pramuka
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="ekskul[]" value="seni_tari" <?php if (in_array("seni_tari", $ekskul)) echo "checked"; ?>>
                    Seni Tari
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="ekskul[]" value="sinematografi" <?php if (in_array("sinematografi", $ekskul)) echo "checked"; ?>>
                    Sinematografi
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="ekskul[]" value="basket" <?php if (in_array("basket", $ekskul)) echo "checked"; ?>>
                    Basket
                </label>
            </div>
            <span class="text-danger"><?php echo $ekskulError; ?></span>
        </div>

        <br>
        <button type="submit" class="btn btn-primary" name="submit" value="submit">
            Submit
        </button>
        <button type="reset" class="btn btn-danger" onclick="window.location.href=window.location.href">
            Reset
        </button>
    </form>

    <?php
    // Jika sudah valid semua
    if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($nisError) && empty($namaError) && empty($jenisKelaminError) && empty($kelasError) && empty($ekskulError)) {
        echo "<h3>Your Input:</h3>";
        echo 'NIS = ' . $nis . '<br />';
        echo 'Nama = ' . $nama . '<br />';
        echo 'Jenis Kelamin = ' . $jenis_kelamin . '<br />';
        echo 'Kelas = ' . $kelas . '<br />';

        if ($kelas == "x" || $kelas == "xi") {
            echo 'Ekstrakulikuler = ' . implode(", ", $ekskul) . '<br />';
        } else {
            echo 'Siswa kelas XII tidak boleh mengikuti kegiatan ekstrakurikuler.<br />';
        }
    }
    ?>

    <script>
        function toggleEkskul(kelas) {
            var ekskulSection = document.getElementById("ekskulSection");
            if (kelas == "x" || kelas == "xi") {
                ekskulSection.style.display = "block";
            } else {
                ekskulSection.style.display = "none";
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            var kelas = document.getElementById("kelas").value;
            toggleEkskul(kelas);
        });
    </script>
</body>
</html>
