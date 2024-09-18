<!-- Nama : Tiara Putri Wibowo -->
<!-- NIM : 24060122120026 -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Siswa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f8f9fa;
        }
        .form-container {
            width: 100%;
            max-width: 600px;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <?php
        $error_nis = $error_nama = $error_jk = $error_kelas = $error_ekstrakurikuler = '';
        $nis = $nama = $jk = $jk = $kelas = '';
        $ekstrakurikuler = [];

        if (isset($_POST["submit"])) {
            //validasi nis
            $nis = test_input($_POST['nis']);
            if (empty($nis)) {
                $error_nis = "NIS harus diisi";
            } elseif (!preg_match("/^[0-9]{10}$/", $_POST["nis"])) {
                $error_nis = "NIS harus terdiri atas 10 karakter dan hanya boleh berisi angka 0..9";
            }

            //validasi nama
            $nama = test_input($_POST['nama']);
            if (empty($nama)) {
                $error_nama = "Nama harus diisi";
            } elseif (!preg_match("/^[a-zA-Z\s]*$/", $nama)) {
                $error_nama = "Nama hanya dapat berisi huruf dan spasi";
            }

            //validasi jenis kelamin
            $jk = isset($_POST['jk']) ? test_input($_POST['jk']) : '';
            if (empty($jk)) {
                $error_jk = "Jenis kelamin harus diisi";
            }

            //validasi kelas
            $kelas = isset($_POST['kelas']) ? $_POST['kelas'] : '';
            if (empty($kelas)) {
                $error_kelas = "Kelas harus diisi";
            }

            //validasi ekstrakurikuler
            $ekstrakurikuler = isset($_POST['ekstrakurikuler']) ? $_POST['ekstrakurikuler'] : [];
            if ($kelas === "X" || $kelas === "XI") {
                if (empty($_POST["ekstrakurikuler"])) {
                    $error_ekstrakurikuler = "Minimal pilih 1 kegiatan ekstrakurikuler";
                } elseif (count($_POST["ekstrakurikuler"]) > 3) {
                    $error_ekstrakurikuler = "Maksimal pilih 3 kegiatan ekstrakurikuler";
                } else {
                    $ekstrakurikuler = $_POST["ekstrakurikuler"];
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

    <div class="form-container">
        <form action="" method="post">
            <h3 class="text-center">Form Input Siswa</h3>
            <div class="form-group">
                <label for="nis">NIS:</label>
                <input type="text" class="form-control" name="nis" id="nis" value="<?php echo isset($nis) ? htmlspecialchars($nis) : ''; ?>">
                <div class="error"><?php if(!empty($error_nis)) echo $error_nis; ?></div>
            </div>

            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" class="form-control" name="nama" id="nama" value="<?php echo isset($nama) ? htmlspecialchars($nama) : ''; ?>">
                <div class="error"><?php if(!empty($error_nama)) echo $error_nama; ?></div>
            </div>

            <label for="jk">Jenis Kelamin:</label>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="jk" value="pria" <?php if ($jk == "pria") echo "checked"; ?>>
                    Pria
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="jk" value="wanita" <?php if ($jk == "wanita") echo "checked"; ?>>
                    Wanita
                </label>
            </div>

            <div class="form-group">
                <label for="kelas">Kelas:</label>
                <select name="kelas" id="kelas" class="form-control">
                    <option value="X" <?php if ($kelas == "X") echo "selected"; ?>>X</option>
                    <option value="XI" <?php if ($kelas == "XI") echo "selected"; ?>>XI</option>
                    <option value="XII" <?php if ($kelas == "XII") echo "selected"; ?>>XII</option>
                </select>
                <div class="error"><?php if(!empty($error_kelas)) echo $error_kelas; ?></div>
            </div>

            <div class="form-group">
                <?php if ($kelas === "X" || $kelas === "XI") { ?>
                    <label for="ekstrakurikuler">Ekstrakurikuler:</label>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="ekstrakurikuler[]" value="Pramuka" <?php if (in_array("Pramuka", $ekstrakurikuler)) echo "checked"; ?>> Pramuka
                        </label>
                    </div>

                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="ekstrakurikuler[]" value="Seni Tari" <?php if (in_array("Seni Tari", $ekstrakurikuler)) echo "checked"; ?>> Seni Tari
                        </label>
                    </div>

                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="ekstrakurikuler[]" value="Sinematografi" <?php if (in_array("Sinematografi", $ekstrakurikuler)) echo "checked"; ?>> Sinematografi
                        </label>
                    </div>

                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="ekstrakurikuler[]" value="Basket" <?php if (in_array("Basket", $ekstrakurikuler)) echo "checked"; ?>> Basket
                        </label>
                    </div>
                    <div class="error"><?php if(!empty($error_ekstrakurikuler)) echo $error_ekstrakurikuler; ?></div>
            <?php } ?>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary" name="submit" value="submit">Submit</button>
                <button type="reset" class="btn btn-danger">Reset</button>
            </div>
        </form>

        <script>
            document.querySelector('form').addEventListener('reset', function(event) {
            console.log('Form reset');
            });
        </script>

        <?php
            // Jika tidak ada error, tampilkan input
            if (empty($error_nis) && empty($error_nama) && empty($error_jk) && empty($error_kelas) && empty($error_ekstrakurikuler)) {
                echo "<h3>Your Input:</h3>";
                echo 'NIS = ' . htmlspecialchars($nis) . '<br />';
                echo 'Nama = ' . htmlspecialchars($nama) . '<br />';
                echo 'Jenis Kelamin = ' . htmlspecialchars($jk) . '<br />';
                echo 'Kelas = ' . htmlspecialchars($kelas) . '<br />';
                
                if (!empty($ekstrakurikuler)) {
                    echo 'Ekstrakurikuler yang dipilih: ';
                    foreach ($ekstrakurikuler as $ekstrakurikuler_item) {
                        echo '<br /> -' . htmlspecialchars($ekstrakurikuler_item);
                    }
                }
            }
        ?>
    </div>
</body>
</html>