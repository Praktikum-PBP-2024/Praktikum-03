<!-- Nama: Sultan Alamsyah Borneo Arifin 
     NIM : 24060122130079               -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POST</title>
    <!-- Tambahkan link ke CSS Bootstrap jika digunakan -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

    <?php
        $error_nama = $error_NIS = $error_jenis_kelamin = $error_kelas = $error_ekstrakurikuler = '';
        $nama = $NIS = $jenis_kelamin = $kelas = '';
        $ekstrakurikuler = [];

        if (isset($_POST["submit"])) {
            // Validasi Nama
            $nama = test_input($_POST['nama']);
            if (empty($nama)) {
                $error_nama = "Nama harus diisi";
            } elseif (!preg_match("/^[a-zA-Z\s]*$/", $nama)) {
                $error_nama = "Nama hanya dapat berisi huruf dan spasi";
            }

            // Validasi NIS
            $NIS = test_input($_POST['NIS']);
            if (empty($NIS)) {
                $error_NIS = "NIS harus diisi";
            } elseif (!preg_match("/^[0-9]{10}/", $NIS)) {
                $error_NIS = "Format NIS tidak benar (Harus berupa angka dan terdiri dari 10 karakter angka)";
            }

            // Validasi Jenis Kelamin
            $jenis_kelamin = isset($_POST['jenis_kelamin']) ? test_input($_POST['jenis_kelamin']) : '';
            if (empty($jenis_kelamin)) {
                $error_jenis_kelamin = "Jenis kelamin harus diisi";
            }

            // Validasi Kelas
            $kelas = isset($_POST['kelas']) ? $_POST['kelas'] : '';
            if (empty($kelas)) {
                $error_kelas = "Kelas harus diisi";
            }

            // Validasi Ekstrakurikuler (hanya untuk kelas X dan XI)
            if ($kelas === "X" || $kelas === "XI") {
                $ekstrakurikuler = isset($_POST['ekstrakurikuler']) ? $_POST['ekstrakurikuler'] : [];
                if (empty($ekstrakurikuler)) {
                    $error_ekstrakurikuler = "Ekstrakurikuler harus dipilih";
                } elseif (count($ekstrakurikuler) > 3) {
                    $error_ekstrakurikuler = "Maksimal ekstrakurikuler yang dipilih adalah 3";
                }
            }
        }

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    ?>

    <form action="" method="POST" autocomplete="on">
        <fieldset>
        <legend>Form Input Siswa</legend>
        <div class="form-group">
            <label for="NIS">NIS:</label>
            <input type="text" class="form-control" id="NIS" name="NIS" value="<?php echo isset($NIS) ? htmlspecialchars($NIS) : ''; ?>">
            <div class="error"><?php if (!empty($error_NIS)) echo $error_NIS; ?></div>
        </div>
        <div class="form-group">
            <label for="nama">Nama:</label>
            <input type="text" class="form-control" id="nama" name="nama" maxlength="50" value="<?php echo isset($nama) ? htmlspecialchars($nama) : ''; ?>">
            <div class="error"><?php if (!empty($error_nama)) echo $error_nama; ?></div>
        </div>
        <div class="form-group">
            <label for="kelas">Kelas:</label>
            <select id="kelas" name="kelas" class="form-control" onchange="showEkstrakurikuler(this.value)">
                <option value="">Pilih Kelas</option>
                <option value="X" <?php if ($kelas == "X") echo "selected"; ?>>X</option>
                <option value="XI"<?php if ($kelas == "XI") echo "selected"; ?>>XI</option>
                <option value="XII"<?php if ($kelas == "XII") echo "selected"; ?>>XII</option>
            </select>
            <div class="error"><?php if (!empty($error_kelas)) echo $error_kelas; ?></div>
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
            <div class="error"><?php if (!empty($error_jenis_kelamin)) echo $error_jenis_kelamin; ?></div>
        </div>
        <br>
        <!-- Ekstrakurikuler Section -->
        <div id="ekstrakurikuler" style="display: none;">
            <label>Ekstrakurikuler:</label>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="ekstrakurikuler[]" value="Pramuka" <?php if (in_array("Pramuka", $ekstrakurikuler)) echo "checked"; ?>>
                    Pramuka
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="ekstrakurikuler[]" value="Seni Tari" <?php if (in_array("Seni Tari", $ekstrakurikuler)) echo "checked"; ?>>
                    Seni Tari
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="ekstrakurikuler[]" value="Sinematografi" <?php if (in_array("Sinematografi", $ekstrakurikuler)) echo "checked"; ?>>
                    Sinematografi
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="ekstrakurikuler[]" value="Basket" <?php if (in_array("Basket", $ekstrakurikuler)) echo "checked"; ?> >
                    Basket
                </label>
                <div class="error"><?php if (!empty($error_ekstrakurikuler)) echo $error_ekstrakurikuler; ?></div>
            </div>
        </div>
        <br>
        <!-- submit, reset dan button -->
        <button type="submit" class="btn btn-primary" name="submit" value="submit">
            Submit
        </button>
        <button type="reset" class="btn btn-danger" onclick="window.location.href = window.location.href;">
            Reset
        </button>
        </fieldset>
    </form>

    <script>
        // Fungsi untuk menampilkan/menghilangkan bagian ekstrakurikuler
        function showEkstrakurikuler(kelas) {
            var ekstraDiv = document.getElementById('ekstrakurikuler');
            if (kelas == 'X' || kelas == 'XI') {
                ekstraDiv.style.display = 'block';
            } else {
                ekstraDiv.style.display = 'none';
            }
        }
        
        // Fungsi untuk mereset form ketika tombol reset ditekan
        document.querySelector('form').addEventListener('reset', function(event) {
            // Reset semua input form termasuk error
            document.querySelectorAll('.form-control').forEach(function(input) {
                input.value = '';
            });
            document.querySelectorAll('input[type=radio]').forEach(function(radio) {
                radio.checked = false;
            });
            document.querySelectorAll('input[type=checkbox]').forEach(function(checkbox) {
                checkbox.checked = false;
            });
            

            // Reset dropdown kelas
            document.getElementById('kelas').selectedIndex = 0;

            // Sembunyikan bagian ekstrakurikuler
            document.getElementById('ekstrakurikuler').style.display = 'none';

            // Hapus semua pesan error
            document.querySelectorAll('.error').forEach(function(error) {
                error.innerHTML = '';
            });
        });

        // Jalankan ketika halaman pertama kali di-load
        window.onload = function() {
            var kelasTerpilih = document.getElementById('kelas').value;
            showEkstrakurikuler(kelasTerpilih);
        }
    </script>

    <?php
        // Jika tidak ada error, tampilkan input
        if (empty($error_nama) && empty($error_NIS) && empty($error_jenis_kelamin) && empty($error_kelas) && empty($error_ekstrakurikuler)) {
            if (isset($_POST["submit"])) {
                echo "<h2>Your Input:</h2>";
                echo "Nama: " . $nama . "<br>";
                echo "NIS: " . $NIS . "<br>";
                echo "Jenis Kelamin: " . $jenis_kelamin . "<br>";
                echo "Kelas: " . $kelas . "<br>";
                if (!empty($ekstrakurikuler)) {
                    echo "Ekstrakurikuler: " . implode(", ", $ekstrakurikuler) . "<br>";
                }
            }
        }
    ?>

</body>
</html>
