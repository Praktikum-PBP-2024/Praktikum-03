<!-- Nama : Rania  -->
<!-- NIM  : 24060122120013  -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Siswa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 50px;
            max-width: 600px;
        }
        .btn-submit {
            background-color: #007bff;
            color: white;
        }
        .btn-reset {
            background-color: #dc3545;
            color: white;
        }
        .form-buttons {
            display: flex;
            justify-content: flex-start;
        }
        .form-buttons button {
            margin-right: 10px;
        }
    </style>
</head>
<body>

<?php
    $nis = $nama = $gender = $kelas = '';
    $ekskul = [];
    $error_nis = $error_nama = $error_gender = $error_kelas = $error_ekskul = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validasi NIS
        if (empty($_POST["nis"])) {
            $error_nis = "NIS harus diisi";
        } elseif (!preg_match("/^[0-9]{10}$/", $_POST["nis"])) {
            $error_nis = "NIS harus 10 digit angka";
        } else {
            $nis = test_input($_POST["nis"]);
        }

        // Validasi Nama
        if (empty($_POST["nama"])) {
            $error_nama = "Nama harus diisi";
        } else {
            $nama = test_input($_POST["nama"]);
        }

        // Validasi Jenis Kelamin
        if (empty($_POST["gender"])) {
            $error_gender = "Jenis kelamin harus diisi";
        } else {
            $gender = test_input($_POST["gender"]);
        }

        // Validasi Kelas
        if (empty($_POST["kelas"])) {
            $error_kelas = "Kelas harus dipilih";
        } else {
            $kelas = test_input($_POST["kelas"]);
        }

        // Validasi Ekstrakurikuler jika kelas X atau XI
        if ($kelas == "X" || $kelas == "XI") {
            if (empty($_POST["ekskul"])) {
                $error_ekskul = "Pilih minimal 1 ekstrakurikuler";
            } elseif (count($_POST["ekskul"]) > 3) {
                $error_ekskul = "Pilih maksimal 3 ekstrakurikuler";
            } else {
                $ekskul = $_POST["ekskul"];
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

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4>Form Input Siswa</h4>
            </div>
            <div class="card-body">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <div class="form-group">
                        <label for="nis">NIS:</label>
                        <input type="text" class="form-control" id="nis" name="nis" value="<?php echo $nis; ?>" placeholder="Masukkan NIS">
                        <span class="text-danger"><?php echo $error_nis;?></span>
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama:</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama; ?>" placeholder="Masukkan Nama">
                        <span class="text-danger"><?php echo $error_nama;?></span>
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin:</label><br>
                        <input type="radio" id="pria" name="gender" value="Pria" <?php if ($gender == "Pria") echo "checked"; ?>> Pria<br>
                        <input type="radio" id="wanita" name="gender" value="Wanita" <?php if ($gender == "Wanita") echo "checked"; ?>> Wanita
                        <br>
                        <span class="text-danger"><?php echo $error_gender;?></span>
                    </div>
                    <div class="form-group">
                        <label for="kelas">Kelas:</label>
                        <select id="kelas" name="kelas" class="form-control">
                            <option value="">Pilih Kelas</option>
                            <option value="X" <?php if ($kelas == "X") echo "selected"; ?>>X</option>
                            <option value="XI" <?php if ($kelas == "XI") echo "selected"; ?>>XI</option>
                            <option value="XII" <?php if ($kelas == "XII") echo "selected"; ?>>XII</option>
                        </select>
                        <span class="text-danger"><?php echo $error_kelas;?></span>
                    </div>
                    <div class="form-group" id="ekskul" style="<?php if ($kelas == 'X' || $kelas == 'XI') echo 'display:block;'; else echo 'display:none;'; ?>">
                        <label>Ekstrakurikuler:</label><br>
                        <input type="checkbox" name="ekskul[]" value="Pramuka" <?php if (in_array("Pramuka", $ekskul)) echo "checked"; ?>> Pramuka<br>
                        <input type="checkbox" name="ekskul[]" value="Seni Tari" <?php if (in_array("Seni Tari", $ekskul)) echo "checked"; ?>> Seni Tari<br>
                        <input type="checkbox" name="ekskul[]" value="Sinematografi" <?php if (in_array("Sinematografi", $ekskul)) echo "checked"; ?>> Sinematografi<br>
                        <input type="checkbox" name="ekskul[]" value="Basket" <?php if (in_array("Basket", $ekskul)) echo "checked"; ?>> Basket<br>
                        <span class="text-danger"><?php echo $error_ekskul;?></span>
                    </div>
                    <div class="form-buttons">
                        <button type="submit" class="btn btn-submit">Submit</button>
                        <button type="reset" class="btn btn-reset">Reset</button>
                    </div>
                </form>
            </div>
        </div>

        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($error_nis) && empty($error_nama) && empty($error_gender) && empty($error_kelas) && empty($error_ekskul)) {
                echo "<h3>Data yang Dimasukkan:</h3>";
                echo "NIS: " . $nis . "<br>";
                echo "Nama: " . $nama . "<br>";
                echo "Jenis Kelamin: " . $gender . "<br>";
                echo "Kelas: " . $kelas . "<br>";
                if (!empty($ekskul)) {
                    echo "Ekstrakurikuler yang dipilih: " . implode(", ", $ekskul) . "<br>";
                }
            }
        ?>
    </div>

    <script>
        document.getElementById('kelas').addEventListener('change', function() {
            var kelas = this.value;
            var ekskulDiv = document.getElementById('ekskul');

            if (kelas === 'X' || kelas === 'XI') {
                ekskulDiv.style.display = 'block';  // Menampilkan pilihan ekstrakurikuler
            } else {
                ekskulDiv.style.display = 'none';   // Menyembunyikan pilihan ekstrakurikuler jika kelas XII
            }
        });
    </script>

</body>
</html>
