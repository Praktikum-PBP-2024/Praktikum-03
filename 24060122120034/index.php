<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Mahasiswa</title>
    <!-- Tambahkan link ke CSS Bootstrap jika digunakan -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

    <?php
        $error_nis = $error_nama = $error_jenis_kelamin = $kelas_error = $error_ekstra = '';

        $nis = $nama = $jenis_kelamin = $kelas = '';
        $ekstrakurikuler = [];
        $ekstra_options = ["Pramuka", "Basket", "Paduan Suara", "Futsal", "Karate"];

        if (isset($_POST["submit"])) {
            // Validasi NIS
            $nis = test_input($_POST['nis']);
            if (empty($nis)) {
                $error_nis = "NIS harus diisi";
            } elseif (!preg_match("/^[0-9]{10}$/", $_POST["nis"])) {
                $error_nis = "NIS harus terdiri dari 10 angka.";
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
                if (empty($_POST["ekstrakurikuler"])) {
                    $error_ekstra = "Pilih minimal 1 ekstrakurikuler.";
                } elseif (count($_POST["ekstrakurikuler"]) > 3) {
                    $error_ekstra = "Pilih maksimal 3 ekstrakurikuler.";
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

    <div class="container mt-5">
        <div class="card"> 
            <div class="card-header bg-light">
                <h3>Form Input Mahasiswa</h3>
            </div>
            <div class="card-body">
                <form id="form" action="" method="POST" autocomplete="on">
                    <div class="form-group">
                        <label for="nis">NIS:</label>
                        <input type="text" class="form-control" id="nis" name="nis" value="<?php echo isset($nis) ? htmlspecialchars($nis) : ''; ?>">
                        <div class="error" style="color:red"><?php if(!empty($error_nis)) echo $error_nis; ?></div>
                    </div>

                    <div class="form-group">
                        <label for="nama">Nama:</label>
                        <input type="text" class="form-control" id="nama" name="nama" maxlength="50" value="<?php echo isset($nama) ? htmlspecialchars($nama) : ''; ?>">
                        <div class="error" style="color:red"><?php if(!empty($error_nama)) echo $error_nama; ?></div>
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
                    <div class="error" style="color:red"><?php if(!empty($error_jenis_kelamin)) echo $error_jenis_kelamin; ?></div>
                    <br>
                    
                    <div class="form-group">
                        <label for="kelas">Kelas:</label><br>
                        <select name="kelas" id="kelas" class="form-control" onchange="toggleEkstrakurikuler()">
                            <option value="">Pilih kelas</option>
                            <option value="X" <?php if($kelas == "X") echo 'selected'; ?>>X</option>
                            <option value="XI" <?php if($kelas == "XI") echo 'selected'; ?>>XI</option>
                            <option value="XII" <?php if($kelas == "XII") echo 'selected'; ?>>XII</option>
                        </select>
                        <div class="error" style="color:red"><?php if(!empty($error_kelas)) echo $error_kelas; ?></div>
                    </div>
                    
                    <div id="ekstrakurikuler-options" style="display:none;">
                        <label>Ekstrakurikuler:</label><br>
                        <?php foreach ($ekstra_options as $option): ?>
                            <input type="checkbox" name="ekstrakurikuler[]" value="<?php echo $option; ?>"<?php if (is_array($ekstrakurikuler) && in_array($option, $ekstrakurikuler)) echo "checked"; ?>> <?php echo $option; ?><br>
                        <?php endforeach; ?>
                        <div class="error" style="color:red"><?php if(!empty($error_ekstra)) echo $error_ekstra; ?></div>
                        <br>
                    </div>

                    <!-- submit, reset dan button -->
                    <button type="submit" class="btn btn-primary" name="submit" value="submit" id="submitBtn">
                        Submit
                    </button>
                    <button type="reset" class="btn btn-danger">
                        Reset
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.querySelector('form').addEventListener('reset', function(event) {
        console.log('Form reset');

        var ekstraSection = document.getElementById('ekstrakurikuler-options');
        if (ekstraSection) {
            ekstraSection.style.display = 'none';
        }
    });

    function toggleEkstrakurikuler() {
        var kelas = document.getElementById('kelas').value;
        var ekstraSection = document.getElementById('ekstrakurikuler-options');
        
        if (kelas == "X" || kelas == "XI") {
            ekstraSection.style.display = "block";
        } else {
            ekstraSection.style.display = "none";
        }
    }
    toggleEkstrakurikuler();
    </script>
</body>
</html>