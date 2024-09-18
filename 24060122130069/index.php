<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Praktikum 3</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <!-- validasi php -->
    <?php
    $error_nama = $error_nis = $error_jenis_kelamin = $error_kelas = $error_ekskul = '';
    $nama = $nis = $jenis_kelamin = $kelas = $ekskul = '';
    $ekskul = [];

    if (isset($_POST["submit"])) {
        // Validasi Nama
        $nama = test_input($_POST['nama']);
        if (empty($nama)) {
            $error_nama = "Nama harus diisi";
        } elseif (!preg_match("/^[a-zA-Z\s]*$/", $nama)) {
            $error_nama = "Nama hanya dapat berisi huruf dan spasi";
        }

        // Validasi Jenis Kelamin
        $jenis_kelamin = isset($_POST['jenis_kelamin']) ? test_input($_POST['jenis_kelamin']) : '';
        if (empty($jenis_kelamin)) {
            $error_jenis_kelamin = "Jenis kelamin harus diisi";
        }

        // Validasi NIS
        $nis = test_input($_POST["nis"]);
        if (empty($nis)) {
            $error_nis = "NIS perlu diisi";
        } elseif (!preg_match("/^\d+$/", $nis)) {
            $error_nis = "NIS hanya dapat berisi angka";
        }

        $kelas = isset($_POST['kelas']) ? test_input($_POST['kelas']) : '';

        // Validasi Ekskul
        $ekskul = isset($_POST["ekskul"]) ? ($_POST["ekskul"]) : [];
        if ($kelas == 'x' || $kelas == 'xi') {
            if (empty($ekskul) || sizeof($ekskul) > 3 || sizeof($ekskul) < 1) {
                $error_ekskul = 'pilih 1-3 ekskul';
            }
        } else {
            $ekskul = [];
        }

    }

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>

    <h1>Form Input Siswa</h1>
    <form action="" method="POST" autocomplete="on">
        <!-- nis -->
        <div class="form-group">
            <label for="nis">NIS:</label>
            <input type="text" class="form-control form-control-sm" id="nis" name="nis" maxlength="10"
                value="<?php echo isset($nis) ? htmlspecialchars($nis) : ''; ?>">
            <div class="error"><?php if (!empty($error_nis))
                echo $error_nis; ?></div>
        </div>

        <!-- nama -->
        <div class="form-group">
            <label for="nama">Nama:</label>
            <input type="text" class="form-control form-control-sm" id="nama" name="nama" maxlength="50"
                value="<?php echo isset($nama) ? htmlspecialchars($nama) : ''; ?>">
            <div class="error"><?php if (!empty($error_nama))
                echo $error_nama; ?></div>
        </div>

        <!-- Jenis Kelamin -->
        <label>Jenis Kelamin:</label>
        <div class="form-check">
            <label class="form-check-label">
                <input type="radio" class="form-check-input" name="jenis_kelamin" value="pria" <?php if ($jenis_kelamin == "pria")
                    echo "checked"; ?>>
                Pria
            </label>
        </div>
        <div class="form-check">
            <label class="form-check-label">
                <input type="radio" class="form-check-input" name="jenis_kelamin" value="wanita" <?php if ($jenis_kelamin == "wanita")
                    echo "checked"; ?>>
                Wanita
            </label>
        </div>
        <div class="error"><?php if (!empty($error_jenis_kelamin))
            echo $error_jenis_kelamin; ?></div>
        <br>

        <!-- Kelas -->
        <div class="form-group">
            <label for="kelas">Kelas :</label>
            <select name="kelas" id="kelas" class="form-control">
                <option value="x">X</option>
                <option value="xi">XI</option>
                <option value="xii">XII</option>
            </select>
        </div>
        <div class="error"><?php if (!empty($error_kelas))
            echo $error_kelas; ?></div>

        <br>

        <!-- Ekskul -->
        <label for="">Ekstrakulikuler :</label>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="ekskul[]" value="pramuka" id="pramuka">
            <label class="form-check-label" for="pramuka">
                Pramuka
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="ekskul[]" value="cinematography" id="cinematography">
            <label class="form-check-label" for="cinematography">
                Cinematography
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="ekskul[]" value="seni_tari" id="seni_tari">
            <label class="form-check-label" for="seni_tari">
                Seni Tari
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="ekskul[]" value="basket" id="basket">
            <label class="form-check-label" for="basket">
                Basket
            </label>
        </div>
        <div class="error"><?php if (!empty($error_ekskul))
            echo $error_ekskul; ?></div>

        <br>
        <!-- submit, reset dan button -->
        <button type="submit" class="btn btn-primary" name="submit" value="submit">
            Submit
        </button>
        <button type="reset" class="btn btn-danger">
            Reset
        </button>

    </form>

    <script>
        document.querySelector('form').addEventListener('reset', function (event) {
            console.log('Form reset');
        });

        const kelas_dipilih = document.getElementById('kelas');

        function hideEkskul() {

            let ekskul = document.getElementsByName('ekskul[]');

            if (kelas_dipilih.value == "xii") {
                for (let i = 0; i < ekskul.length; i++) {
                    ekskul[i].setAttribute('hidden', 'true');
                }
            }
            else {
                for (let i = 0; i < ekskul.length; i++) {
                    ekskul[i].removeAttribute('hidden');
                }
            }
        }

        window.onload = hideEkskul;
        kelas_dipilih.onchange = hideEkskul;
    </script>

    <?php
    // Jika tidak ada error, tampilkan input
    if (empty($error_nama) && empty($error_nis) && empty($error_jenis_kelamin) && empty($error_kelas) && empty($error_ekskul)) {
        echo "<h3>Your Input:</h3>";
        echo 'Nama = ' . htmlspecialchars($nama) . '<br />';
        echo 'NIS = ' . htmlspecialchars($nis) . '<br />';
        echo 'Jenis Kelamin = ' . htmlspecialchars($jenis_kelamin) . '<br />';
        echo 'Kelas = ' . htmlspecialchars($kelas) . '<br />';

        echo 'Ekstrakulikuler = ' . '<br/>';
        foreach ($ekskul as $key) {
            echo '' . $key . '<br/>';
        }
    }
    ?>
</body>

</html>