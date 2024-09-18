<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!--CSS-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        input[type="text"],
        .small-select   {
            width: 400px;
        }

        #ekstrakulikuler {
            display: none;
        }

        .error {
            color: red;
        }

        form {
            margin: 20px;
            padding: 20px;
            max-width: 480px;
            width: 100%;
            border: 2px solid;
            border-color: blue;
            border-radius: 8px;
        }
    </style>

    <!--JavaScript-->
    <script>
        //menampilkan ekstrakulikuler untuk kelas X dan XI
        function viewEkstrakulikuler() {
            var kelas = document.getElementById('kelas').value;
            var ekskul = document.getElementById('ekstrakulikuler');

            if (kelas === 'X' || kelas === 'XI') {
                ekskul.style.display = 'block';
            } else {
                ekskul.style.display = 'none';
            }
        }

        window.onload = function() {
            viewEkstrakulikuler(); 
        }

        document.getElementById('reset').addEventListener('click', function() {
            document.querySelector('form').reset();
        });
    </script>
</head>
<body>

    <?php
        $error_nis = $error_nama = $error_jenis_kelamin = $error_kelas = $error_ekstrakulikuler = '';
        $nis = $nama = $jenis_kelamin = $kelas = '';
        $ekstrakuliker = [];
        
        if (isset($_POST["submit"])) {
            //Validasi nis
            $nis = test_input($_POST['nis']);
            if (empty($nis)) {
                $error_nis = "Nis harus diisi";
            } elseif (!preg_match("/^[0-9\s]{10}$/", $nis)) {
                $error_nis = "NIS hanya dapat berisi angka dari 0-9 dan 10 angka.";
            }

            //Validasi nama
            $nama = test_input($_POST['nama']);
            if (empty($nama)) {
                $error_nama = "Nama harus diisi";
            }

            //Validasi jenis kelamin
            $jenis_kelamin = isset($_POST['jenis_kelamin']) ? test_input($_POST['jenis_kelamin']) : '';
            if (empty($jenis_kelamin)) {
                $error_jenis_kelamin = "Jenis kelamin harus diisi";
            }

            //Validasi kelas
            $kelas = isset($_POST['kelas']) ? $_POST['kelas'] : '';
            if (empty($kelas)) {
                $error_kelas = "Kelas harus diisi";
            }

            //Validasi ekskul
            if ($kelas == "X" || $kelas == "XI") {
                if (empty($_POST['ekstrakulikuler'])) {
                    $error_ekstrakulikuler = "Ekstrakulikuler harus diisi";
                } elseif (count($_POST['ekstrakulikuler']) > 3) {
                    $error_ekstrakulikuler = "Hanya boleh memilih maksimal 3 kegiatan ekstrakulikuler";
                } else {
                    $ekstrakuliker = $_POST['ekstrakulikuler'];
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
    
    <form method="POST" action="" autocomplete="on">
        <div class="form-group">
            <label for="nis">NIS:</label>
            <input type="text" class="form-control" id="nis" name="nis" maxlength="10" value="<?php echo isset($nis) ? htmlspecialchars($nis) : ''; ?>">
            <div class="error"><?php if(!empty($error_nis)) echo $error_nis ?></div>
        </div>

        <div class="form-group">
            <label for="nama">Nama:</label>
            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo isset($nama) ? htmlspecialchars($nama) : ''; ?>">
            <div class="error"><?php if(!empty($error_nama)) echo $error_nama ?></div>
        </div>

        <label>Jenis Kelamin:</label>
        <div class="form-check">
            <label class="form-check-label">
                <input type="radio" class="form-check-input" name="jenis_kelamin" value="pria" 
                <?php if(!empty($jenis_kelamin) && $jenis_kelamin == "pria") echo "checked"; ?>>Pria
            </label>
        </div>
        <div class="form-check">
            <label class="form-check-label">
                <input type="radio" class="form-check-input" name="jenis_kelamin" value="wanita" 
                <?php if(!empty($jenis_kelamin) && $jenis_kelamin == "wanita") echo "checked"; ?>>wanita
            </label>
        </div>
        <div class="error"><?php if(!empty($error_jenis_kelamin)) echo $error_jenis_kelamin ?></div>

        <br>
        <div class="form-group">
            <label for="kelas">Kelas:</label>
            <select id="kelas" name="kelas" class="form-control small-select" onchange="viewEkstrakulikuler()">
                <option value="">--Pilih Kelas--</option> 
                <option value="X" <?php if($kelas == "X") echo "selected" ?>>X</option>
                <option value="XI" <?php if($kelas == "XI") echo "selected" ?>>XI</option>
                <option value="XII" <?php if($kelas == "XII") echo "selected" ?>>XII</option>
            </select>
            <div class="error"><?php if(!empty($error_kelas)) echo $error_kelas ?></div>
        </div>

        <div id="ekstrakulikuler" >
            <label>Ekstrakulikuler:</label>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="ekstrakulikuler[]" value="Pramuka" 
                    <?php if(!empty($ekstrakuliker) && in_array('Pramuka', $ekstrakuliker)) echo "checked"; ?>>Pramuka
                </label> 
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="ekstrakulikuler[]" value="Senitari" 
                    <?php if(!empty($ekstrakuliker) && in_array('Senitari', $ekstrakuliker)) echo "checked"; ?>>Senitari
                </label> 
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="ekstrakulikuler[]" value="Sinematografi" 
                    <?php if(!empty($ekstrakuliker) && in_array('Sinematografi', $ekstrakuliker)) echo "checked"; ?>>Sinematografi
                </label> 
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="ekstrakulikuler[]" value="Basket" 
                    <?php if(!empty($ekstrakuliker) && in_array('Basket', $ekstrakuliker)) echo "checked"; ?>>Basket
                </label> 
            </div>
            <div class="error"><?php if(!empty($error_ekstrakulikuler)) echo $error_ekstrakulikuler ?></div>
        </div>
        <br>

        <button type="submit" class="btn btn-primary" name="submit" value="submit">
            Submit
        </button>
        <button type="reset" class="btn btn-danger" id="reset">
            Reset
        </button>
    </form>

    <?php
        if (empty($error_nis) && empty($error_nama) && empty($error_jenis_kelamin) && empty($error_kelas) && empty($error_ekstrakulikuler)) {
            echo '<div style="margin: 20px;">';
            echo "<h3>Your Input:</h3>";
            echo 'NIS = ' . htmlspecialchars($nis) . '<br />';
            echo 'Nama = ' . htmlspecialchars($nama) . '<br />';
            echo 'Jenis Kelamin = ' . htmlspecialchars($jenis_kelamin) . '<br />';
            echo 'Kelas = ' . htmlspecialchars($kelas) . '<br />';

            if ($kelas == "X" || $kelas == "XI"){
                if (!empty($ekstrakuliker)) {
                    echo "Ekstrakulikuler yang dipilih: ";
                    foreach ($ekstrakuliker as $ekstrakuliker_item) {
                        echo '<br />' . htmlspecialchars($ekstrakuliker_item);
                    }
                }
            }
            echo "</div>";
        }
    ?>
</body>
</html>
