<!-- Syakira Nada Nirwana -->
<!-- 24060122130049 -->
<!-- Lab D2 PBP -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tugas 3 Praktikum PBP</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php
        $error_nis = $error_nama = $error_jenis_kelamin = $error_kelas = $error_ekstrakurikuler = '';
        $nis = $nama = $jenis_kelamin = $kelas = $ekstrakurikuler = '';
        $ekstrakurikuler = [];

        if (isset($_POST["submit"])) {
            // Validasi NIS
            $nis = test_input($_POST['nis']);
            if (empty($nis)) {
                $error_nis = "NIS harus diisi";
            } elseif (!preg_match("/^[0-9]{10}$/", $nis)) {
                $error_nis = "NIS harus terdiri dari 10 digit angka";
            }

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
            
            // Validasi Kelas
            $kelas = isset($_POST['kelas']) ? test_input($_POST['kelas']) : '';
            if (empty($kelas)) {
                $error_kelas = "Kelas harus diisi";
            }
            
            // Validasi Ekstrakurikuler
            if ($kelas == "X" || $kelas == "XI") {
                if (empty($_POST['ekstrakurikuler'])) {
                    $error_ekstrakurikuler = "Ekstrakurikuler harus diisi minimal 1";
                } elseif (count($_POST['ekstrakurikuler']) > 3) {
                    $error_ekstrakurikuler = "Pilih maksimal 3 ekstrakurikuler";
                } else {
                    $ekstrakurikuler = $_POST['ekstrakurikuler'];
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
        <div class="card mt-4">
            <div class="card-header">
                <h4>Form Input Siswa</h4>
            </div>
            <div class="card-body">
                <form action="" method="POST" autocomplete="on">
                    <div class="form-group">
                        <label for="nis">NIS:</label>
                        <input type="text" class="form-control" id="nis" name="nis" maxlength="10" value="<?php echo isset($nis) ? htmlspecialchars($nis) : ''; ?>">
                        <div class="error" style="color: red;"><?php if(!empty($error_nis)) echo $error_nis; ?></div>
                    </div>
                    
                    <div class="form-group">
                        <label for="nama">Nama:</label>
                        <input type="text" class="form-control" id="nama" name="nama" maxlength="50" value="<?php echo isset($nama) ? htmlspecialchars($nama) : ''; ?>">
                        <div class="error" style="color: red;"><?php if(!empty($error_nama)) echo $error_nama; ?></div>
                    </div>
                    
                    <label>Jenis Kelamin:</label>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="jenis_kelamin" value="Pria" <?php if ($jenis_kelamin == "Pria") echo "checked"; ?>>
                            Pria
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="jenis_kelamin" value="Wanita" <?php if ($jenis_kelamin == "Wanita") echo "checked"; ?>>
                            Wanita
                        </label>
                    </div>
                    <div class="error" style="color: red;"><?php if(!empty($error_jenis_kelamin)) echo $error_jenis_kelamin; ?></div>
                    <br>
        
                    <div class="form-group">
                        <label for="kelas">Kelas:</label>
                        <select id="kelas" name="kelas" class="form-control" onchange="toggleEkstrakurikuler()">
                            <option value="">Pilih Kelas</option>
                            <option value="X" <?php if ($kelas == "X") echo "selected"; ?>>X</option>
                            <option value="XI" <?php if ($kelas == "XI") echo "selected"; ?>>XI</option>
                            <option value="XII" <?php if ($kelas == "XII") echo "selected"; ?>>XII</option>
                        </select>
                        <div class="error" style="color: red;"><?php if(!empty($error_kelas)) echo $error_kelas; ?></div>
                    </div>
                    
                    <div id="ekstrakurikuler-section" style="display: none;">
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
                                <input type="checkbox" class="form-check-input" name="ekstrakurikuler[]" value="Basket" <?php if (in_array("Basket", $ekstrakurikuler)) echo "checked"; ?>>
                                Basket
                            </label>
                        </div>
                        <div class="error" style="color: red;"><?php if(!empty($error_ekstrakurikuler)) echo $error_ekstrakurikuler; ?></div>
                    </div>
                    <br>
        
                    <button type="submit" class="btn btn-primary" name="submit" value="submit">
                        Submit
                    </button>
                    <button type="reset" class="btn btn-danger ml-2" onclick="window.location.href=''">
                        Reset
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        function toggleEkstrakurikuler() {
            var kelas = document.getElementById('kelas').value;
            var ekstrakurikulerSection = document.getElementById('ekstrakurikuler-section');
            if (kelas === 'X' || kelas === 'XI') {
                ekstrakurikulerSection.style.display = 'block';
            } else {
                ekstrakurikulerSection.style.display = 'none';
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            toggleEkstrakurikuler();
        });
    </script>

    <?php
        // Jika tidak ada error, tampilkan input
        if (isset($_POST["submit"]) && empty($error_nis) && empty($error_nama) && empty($error_jenis_kelamin) && empty($error_kelas) && empty($error_ekstrakurikuler)) {
            echo '
            <div style="display: flex; justify-content: center; align-items: center; text-align: center;">
                <div>
                    <h3>Your Input:</h3>
                    NIS : ' . htmlspecialchars($nis) . '<br />
                    Nama : ' . htmlspecialchars($nama) . '<br />
                    Jenis Kelamin : ' . htmlspecialchars($jenis_kelamin) . '<br />
                    Kelas : ' . htmlspecialchars($kelas) . '<br />';

            if (!empty($ekstrakurikuler)) {
                echo 'Ekstrakurikuler yang dipilih : ';
                foreach ($ekstrakurikuler as $ekstrakurikuler_item) {
                    echo '<br />' . htmlspecialchars($ekstrakurikuler_item);
                }
            }

            echo '
                </div>
            </div>';
        }
    ?>
</body>
</html>
