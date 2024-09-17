<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>user_form_post2</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php
    $nis = $nama = $jenis_kelamin = $kelas = '';
    if (isset($_POST['submit'])) {
        // validasi nis: nis tidak boleh kosong, hanya dapat berisi angka 0-9, dan maks array nis adalah 10
        $nis = test_input($_POST['nis']);
        if (empty($nis)) {
            $error_nis = "NIS harus diisi";
        } elseif (!preg_match("/^[0-9]{10}$/", $nis)) {
            $error_nis = "NIS harus berisi 10 karakter dan hanya terdiri dari angka 0-9";
        }
    
        //validasi nama: tidak boleh kosong, hanya dapat berisi huruf dan spasi 
        $nama = test_input($_POST['nama']);
        if (empty($nama)) {
        $error_nama = "Nama harus diisi";
        } elseif (!preg_match("/^[a-zA-Z ]*$/", $nama)) {
        $error_nama = "Nama hanya dapat berisi huruf dan spasi";
        }

        // Validasi jenis kelamin: tidak boleh kosong
        $jenis_kelamin = isset($_POST['jenis_kelamin']) ? test_input($_POST['jenis_kelamin']) : '';
        if (empty($jenis_kelamin)) {
            $error_jenis_kelamin = "Jenis kelamin harus diisi";
        }
        // Validasi kelas: tidak boleh kosong
        $kelas = isset($_POST['kelas']) ? test_input($_POST['kelas']) : '';
        if (empty($kelas)) {
            $error_kelas = "Kelas harus diisi";
        }
    
        // Validasi ekstrakurikuler
        $ekstrakurikuler = isset($_POST['ekstrakurikuler']) ? $_POST['ekstrakurikuler'] : [];
        if (empty($ekstrakurikuler) && (isset($_POST['kelas']) && $_POST['kelas'] != 'XII')) {
            $error_ekstrakurikuler = "Ekstrakurikuler harus dipilih jika bukaln kelas XII";
        } elseif (isset($_POST['kelas']) && $_POST['kelas'] == 'XII' && !empty($ekstrakurikuler)) {
            $error_ekstrakurikuler = "Siswa kelas XII tidak boleh mengikuti kegiatan ekstrakurikuler";
        } elseif (isset($_POST['kelas']) && $_POST['kelas'] != 'XII' && count($ekstrakurikuler) > 3) {
            $error_ekstrakurikuler = "Siswa hanya boleh memilih maksimal 3 kegiatan ekstrakurikuler";
        }

        $nis = test_input($_POST['nis']);
        $nama = test_input($_POST['nama']);
        $jenis_kelamin = isset($_POST['jenis_kelamin']) ? test_input($_POST['jenis_kelamin']) : '';
        $kelas = isset($_POST['kelas']) ? test_input($_POST['kelas']) : '';
    }

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>
    <div class="container"><br/>
        <div class="card"> 
            <div class="card-header">
                <p class="mb-0">Form Input Siswa</p> 
            </div>
                    
            <div class="card-body">
                <form action="" method="POST" autocomplete="on">
                    <div class="form-group">
                        <label for="nis">NIS: </label>
                        <input type="text" class="form-control" id="nis" name="nis" value="<?php if(isset($nis)) {echo $nis;} ?>">
                        <div class="error"><?php if (isset($error_nis)) echo $error_nis;?></div>
                    </div>

                    <div class="form-group">
                        <label for="nama">Nama: </label>
                        <input type="text" class="form-control" id="nama" name="nama" maxlength="50" value="<?php if(isset($nama)) {echo $nama;} ?>">
                        <div class="error"><?php if (isset($error_nama)) echo $error_nama;?></div>
                    </div>

                    <label>Jenis Kelamin: </label>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="jenis_kelamin" value="Pria"
                            <?php if (isset($jenis_kelamin) && $jenis_kelamin=="pria") echo "checked";?>>Pria
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="jenis_kelamin" value="Wanita"
                            <?php if (isset($jenis_kelamin) && $jenis_kelamin=="wanita") echo "checked";?>>Wanita
                        </label>
                        <div class="error"><?php if (isset($error_jenis_kelamin)) echo $error_jenis_kelamin; ?></div>
                    </div>

                    <div class="form-group">
                        <label for="kelas">Kelas: </label>
                        <select class="form-select" id="kelas" name="kelas" onchange="ekstrakurikuler()">
                            <option value="">Pilih Kelas</option>
                            <option value="X" <?php if (isset($_POST['kelas']) && $_POST['kelas'] == 'X') echo 'selected'; ?>>X</option>
                            <option value="XI" <?php if (isset($_POST['kelas']) && $_POST['kelas'] == 'XI') echo 'selected'; ?>>XI</option>
                            <option value="XII" <?php if (isset($_POST['kelas']) && $_POST['kelas'] == 'XII') echo 'selected'; ?>>XII</option>
                        </select>
                        <div class="error"><?php if (isset($error_kelas)) echo $error_kelas;?></div>
                    </div>

                    <label>Ekstrakurikuler:</label>
                    <div id="ekstrakurikuler" style="<?php echo (isset($_POST['kelas']) && $_POST['kelas'] == 'XII') ? 'display:none;' : ''; ?>">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="ekstrakurikuler[]" value="Pramuka"
                                <?php if (isset($ekstrakurikuler) && in_array('pramuka', $ekstrakurikuler)) echo "checked";?>>Pramuka
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="ekstrakurikuler[]" value="seni_tari"
                                <?php if (isset($ekstrakurikuler) && in_array('seni_tari', $ekstrakurikuler)) echo "checked";?>>Seni Tari
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="ekstrakurikuler[]" value="sinematografi"
                                <?php if (isset($ekstrakurikuler) && in_array('sinematografi', $ekstrakurikuler)) echo "checked";?>>Sinematografi
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="ekstrakurikuler[]" value="basket"
                                <?php if (isset($ekstrakurikuler) && in_array('basket', $ekstrakurikuler)) echo "checked";?>>Basket
                            </label>
                            <div class="error"><?php if (isset($error_ekstrakurikuler)) echo $error_ekstrakurikuler; ?></div>
                        </div>
                    </div>
                    <br>

                    <!-- submit dan reset buttons -->
                    <button type="submit" class="btn btn-primary" name="submit" value="submit">Submit </button>
                    <button type="button" class="btn btn-danger" onclick="resetForm()">Reset</button>
                </form>
            </div>
        </div>

        <!-- Tampilan jika tidak ada error -->
        <?php
        if (isset($_POST["submit"]) && empty($error_nis) && empty($error_nama) && empty($error_jenis_kelamin) && empty($error_ekstrakurikuler)) {
            echo "<h3>Your Input:</h3>";
            echo 'NIS = '.$_POST['nis'].'<br />';
            echo 'Nama = '.$_POST['nama'].'<br />';
            echo 'Kelas = '.$_POST['kelas'].'<br />';
            echo 'Jenis Kelamin = '.$_POST['jenis_kelamin'].'<br />';
            
            $ekstrakurikuler = isset($_POST['ekstrakurikuler']) ? $_POST['ekstrakurikuler'] : [];
            if (!empty($ekstrakurikuler)) {
                echo 'Ekstrakurikuler yang dipilih: ';
                foreach ($ekstrakurikuler as $ekstrakurikuler_item) {
                    echo '<br />'.$ekstrakurikuler_item;
                }
            }
        }
        ?>
    </div>

    <script>
      function ekstrakurikuler() {
        var kelas = document.getElementById('kelas').value;
        var ekstra = document.getElementById('ekstrakurikuler');

        if (kelas == 'X' || kelas == 'XI') {
          ekstra.style.display = 'block';
        }
        else {
          ekstra.style.display = 'none';
        }
      }

      function resetForm() {
        // Reset form fields
        document.querySelector('form').reset();
        
        // Clear the error messages
        const errorMessages = document.querySelectorAll('.error');
        errorMessages.forEach(function(error) {
          error.innerHTML = '';
        });
      }
    </script>

</body>

</html>
