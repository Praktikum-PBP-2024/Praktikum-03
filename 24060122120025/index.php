<!-- 
    NAMA   : DIMAS YUDHA SAPUTRA
    NIM    : 24060122120025
    LAB    : D2
    MATERI : PEMROSESAN FORM
    TANGGAL: 17/09/2024
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Siswa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .error {
            color: red;
        }
    </style>
    <script>
        function showekskul() {
            var kelas = document.getElementById('kelas').value;
            var ekskulSection = document.getElementById('ekstrakurikuler');
            
            // Cek apakah kelas XII
            if (kelas === 'XII') {
                ekskulSection.style.display = 'none'; // Sembunyikan ekstrakurikuler
            } else {
                ekskulSection.style.display = 'block'; // Tampilkan ekstrakurikuler
            }
        }

        function succesSubmit() {
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Form Input Siswa Successfully!',
                showConfirmButton: false,
                timer: 1500
            });
        }
    </script>
</head>
<body>
    <div class="card m-5">
        <div class="card-header">Form Input Siswa</div>
        <div class="card-body">
            <?php 
            // Inisialisasi variabel error dan input
            $error_nis = '';
            $error_nama = '';
            $error_jenis_kelamin = '';
            $error_kelas = ''; 
            $error_ekstrakurikuler = '';

            $nis = '';
            $nama = '';
            $jenis_kelamin = '';
            $kelas = '';
            $ekstrakurikuler = [];

            function test_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }

            if(isset($_POST["submit"])) {
                // Validasi NIS
                $nis = test_input($_POST['nis']);
                if(empty($nis)) {
                    $error_nis = "NIS harus diisi";
                } else if(!preg_match("/^[0-9]*$/", $nis)) {
                    $error_nis = "NIS hanya boleh berisi angka 0..9";
                } else if(strlen($nis) != 10) {
                    $error_nis = "NIS harus terdiri atas 10 karakter";
                }

                // Validasi Nama
                $nama = test_input($_POST['nama']);
                if(empty($nama)) {
                    $error_nama = "Nama harus diisi";
                } else if(!preg_match("/^[a-zA-Z\s]*$/",$nama)) {
                    $error_nama = "Nama harus terdiri atas karakter/huruf";
                }

                // Validasi Jenis Kelamin
                $jenis_kelamin = isset($_POST['jenis_kelamin']) ? test_input($_POST['jenis_kelamin']) : '';
                if(empty($jenis_kelamin)) {
                    $error_jenis_kelamin = "Jenis kelamin harus diisi";
                }

                // Validasi Kelas
                $kelas = isset($_POST['kelas']) ? $_POST['kelas'] : '';
                if(empty($kelas)) {
                    $error_kelas = "Kelas harus diisi";
                }

                // Validasi Ekstrakurikuler untuk Kelas X dan XI
                if ($kelas == 'X' || $kelas == 'XI') {
                    $ekstrakurikuler = isset($_POST['ekstrakurikuler']) ? $_POST['ekstrakurikuler'] : [];
                    if (empty($ekstrakurikuler)) {
                        $error_ekstrakurikuler = "Ekstrakurikuler harus diisi dan minimal 1";
                    } else {
                        if (count($ekstrakurikuler) > 3) {
                            $error_ekstrakurikuler = "Ekstrakurikuler maksimal 3";
                        }
                    }
                }

                // Tampilkan pop-up jika tidak ada error 
                if(empty($error_nis) && empty($error_nama) && empty($error_jenis_kelamin) && empty($error_kelas) && empty($error_ekstrakurikuler)) {
                    echo "<script>window.onload = function() { succesSubmit(); }</script>";
                }
            }
            ?>
            
            <form action="" method="POST" autocomplete="on">
                <!-- NIS -->
                <div class="form-group">
                    <label for="nis">NIS:</label>
                    <input type="text" class="form-control" id="nis" name="nis" value="<?= htmlspecialchars($nis); ?>">
                    <div class="error"><?php if(!empty($error_nis)) echo $error_nis; ?></div>
                </div>

                <!-- Nama -->
                <div class="form-group">
                    <label for="nama">Nama:</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($nama); ?>">
                    <div class="error"><?php if(!empty($error_nama)) echo $error_nama; ?></div>
                </div>

                <!-- Jenis Kelamin -->
                <div class="form-group">
                    <label>Jenis Kelamin:</label>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="jenis_kelamin" value="pria" <?= ($jenis_kelamin == "pria") ? "checked" : ""; ?>>Pria
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="jenis_kelamin" value="wanita" <?= ($jenis_kelamin == "wanita") ? "checked" : ""; ?>>Wanita
                        </label>
                    </div>
                    <div class="error"><?php if (!empty($error_jenis_kelamin)) echo $error_jenis_kelamin; ?></div>
                </div>

                <!-- Kelas -->
                <div class="form-group">
                    <label for="kelas">Kelas:</label>
                    <select id="kelas" name="kelas" class="form-control" onchange="showekskul()">
                        <option value="" disabled <?= $kelas == '' ? 'selected' : ''; ?>>--Pilih Kelas--</option>
                        <option value="X" <?= ($kelas == "X") ? "selected" : ""; ?>> X </option>
                        <option value="XI" <?= ($kelas == "XI") ? "selected" : ""; ?>> XI </option>
                        <option value="XII" <?= ($kelas == "XII") ? "selected" : ""; ?>> XII </option>
                    </select>
                    <div class="error"><?php if(!empty($error_kelas)) echo $error_kelas; ?></div>
                </div>

                <!-- Ekstrakurikuler -->
                <div class="form-group" id="ekstrakurikuler" style="display: <?= ($kelas == 'XII') ? 'none' : 'block'; ?>;">
                    <label>Ekstrakurikuler:</label>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="ekstrakurikuler[]" value="Pramuka" <?= in_array("Pramuka", $ekstrakurikuler) ? "checked" : ""; ?>>Pramuka
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="ekstrakurikuler[]" value="Seni Tari" <?= in_array("Seni Tari", $ekstrakurikuler) ? "checked" : ""; ?>>Seni Tari
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="ekstrakurikuler[]" value="Sinematografi" <?= in_array("Sinematografi", $ekstrakurikuler) ? "checked" : ""; ?>>Sinematografi
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="ekstrakurikuler[]" value="Basket" <?= in_array("Basket", $ekstrakurikuler) ? "checked" : ""; ?>>Basket
                        </label>
                    </div>
                    <div class="error"><?php if(!empty($error_ekstrakurikuler)) echo $error_ekstrakurikuler; ?></div>
                </div>

                <!-- Submit dan Reset -->
                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                <button type="reset" class="btn btn-danger" onclick="window.location.href = window.location.href;">Reset</button>
            </form>
        </div>
    </div>


    <?php
    if (!empty($_POST) && empty($error_nis) && empty($error_nama) && empty($error_jenis_kelamin) && empty($error_kelas) && empty($error_ekstrakurikuler)) {
        echo '<div class="alert alert-success" role="alert">';
        echo '<h4 class="alert-heading">Your Input</h4>';
        echo '<ul class="list-unstyled">';
        echo '<li><strong>NIS                           :</strong> ' . htmlspecialchars($nis) . '</li>';
        echo '<li><strong>Nama                          :</strong> ' . htmlspecialchars($nama) . '</li>';
        echo '<li><strong>Jenis Kelamin                 :</strong> ' . htmlspecialchars($jenis_kelamin) . '</li>';
        echo '<li><strong>Kelas                         :</strong> ' . htmlspecialchars($kelas) . '</li>';
        echo '<li><strong>Ekstrakurikuler yang dipilih  :</strong> ';
        if (!empty($ekstrakurikuler)) {
            echo '<ul>';
            $i = 1;
            foreach ($ekstrakurikuler as $ekstrakurikuler_pilihan) {
                echo '<li>' . $i . '. ' . htmlspecialchars($ekstrakurikuler_pilihan) . '</li>';
                $i++;
            }
            echo '</ul>';
        } else {
            echo 'Tidak ada ekstrakurikuler yang dipilih.';
        }
        echo '</li>';
        echo '</ul>';
        echo '</div>';
    }
    ?>
</body>
</html>
