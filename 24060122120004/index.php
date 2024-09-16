<!-- 
Nama : Abisatya Hastarangga P
NIM  : 224060122120004
Tgl  : 11 September 2024 
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POST</title>
    <link rel="stylesheet" 
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php
        $error_nis = $error_nama = $error_jenis_kelamin = $error_kelas = $error_ekskul = '';
        $nis = $nama = $jenis_kelamin = $kelas = '';
        $ekskul = [];
        if (isset($_POST["submit"]) || isset($_POST["kelas"])) {
            $nis = test_input($_POST['nis']);
            if (empty($nis)) {
                $error_nis = "NIS harus diisi";
            } elseif (!preg_match("/^[0-9]{10}$/", $nis)) {
                $error_nis = "NIS harus terdiri dari 10 digit angka";
            }
            $nama = test_input($_POST['nama']);
            if (empty($nama)) {
                $error_nama = "Nama harus diisi";
            } elseif (!preg_match("/^[a-zA-Z\s]*$/", $nama)) {
                $error_nama = "Nama hanya boleh mengandung huruf dan spasi";
            }
            $jenis_kelamin = isset($_POST['jenis_kelamin']) ? 
            test_input($_POST['jenis_kelamin']) : '';
            if (empty($jenis_kelamin)) {
                $error_jenis_kelamin = "Jenis kelamin harus dipilih";
            }
            $kelas = isset($_POST['kelas']) ? $_POST['kelas'] : '';
            if (empty($kelas)) {
                $error_kelas = "Kelas harus dipilih";
            }
            if ($kelas == "X" || $kelas == "XI") {
                $ekskul = isset($_POST['ekskul']) ? $_POST['ekskul'] : [];
                if (empty($ekskul)) {
                    $error_ekskul = "Minimal pilih 1 ekstrakurikuler";
                } elseif (count($ekskul) > 3) {
                    $error_ekskul = "Maksimal pilih 3 ekstrakurikuler";
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
        <h2>Form Input Siswa</h2>
        <form action="" method="POST" autocomplete="on">
            <div class="form-group">
                <label for="nis">NIS (Nomor Induk Siswa):</label>
                <input type="text" class="form-control" id="nis" name="nis" maxlength="10" 
                value="<?php echo isset($nis) ? htmlspecialchars($nis) : ''; ?>">
                <div class="error text-danger"><?php if(!empty($error_nis)) 
                echo $error_nis; ?></div>
            </div>

            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" class="form-control" id="nama" name="nama" maxlength="50" 
                value="<?php echo isset($nama) ? htmlspecialchars($nama) : ''; ?>">
                <div class="error text-danger"><?php if(!empty($error_nama)) 
                echo $error_nama; ?></div>
            </div>

            <label>Jenis Kelamin:</label><br>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="jenis_kelamin" 
                    value="pria" 
                    <?php if ($jenis_kelamin == "pria") echo "checked"; ?>> Pria
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="jenis_kelamin" 
                    value="wanita" 
                    <?php if ($jenis_kelamin == "wanita") echo "checked"; ?>> Wanita
                </label>
            </div>
            <div class="error text-danger"><?php if(!empty($error_jenis_kelamin)) 
            echo $error_jenis_kelamin; ?></div>
            <br>

            <div class="form-group">
                <label for="kelas">Kelas:</label>
                <select id="kelas" name="kelas" class="form-control" onchange="this.form.submit()">
                    <option value="">Pilih Kelas</option>
                    <option value="X" <?php if ($kelas == "X") echo "selected"; ?>>X</option>
                    <option value="XI" <?php if ($kelas == "XI") echo "selected"; ?>>XI</option>
                    <option value="XII" <?php if ($kelas == "XII") echo "selected"; ?>>XII</option>
                </select>
                <div class="error text-danger"><?php if(!empty($error_kelas)) 
                echo $error_kelas; ?></div>
            </div>

            <?php if ($kelas == "X" || $kelas == "XI"): ?>
            <div class="form-group">
                <label>Pilih Ekstrakurikuler (Minimal 1, Maksimal 3):</label><br>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="ekskul[]" 
                    value="pramuka" <?php if (in_array("pramuka", $ekskul)) 
                    echo "checked"; ?>> Pramuka
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="ekskul[]" 
                    value="seni_tari" <?php if (in_array("seni_tari", $ekskul)) 
                    echo "checked"; ?>> Seni Tari
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="ekskul[]" 
                    value="sinematografi" <?php if (in_array("sinematografi", $ekskul)) 
                    echo "checked"; ?>> Sinematografi
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="ekskul[]" 
                    value="basket" <?php if (in_array("basket", $ekskul)) 
                    echo "checked"; ?>> Basket
                </div>
                <div class="error text-danger"><?php if(!empty($error_ekskul)) 
                echo $error_ekskul; ?></div>
            </div>
            <?php endif; ?>
            <button type="submit" class="btn btn-primary" name="submit" 
            value="submit">Submit</button>
            <button type="reset" class="btn btn-danger" 
            onclick="window.location.href=''">Reset</button>
        </form>
    </div>

    <?php
        if (isset($_POST["submit"]) && empty($error_nis) 
        && empty($error_nama) && empty($error_jenis_kelamin) 
        && empty($error_kelas) && empty($error_ekskul)) {
            echo "<h3>Your Input:</h3>";
            echo 'NIS: ' . htmlspecialchars($nis) . '<br>';
            echo 'Nama: ' . htmlspecialchars($nama) . '<br>';
            echo 'Jenis Kelamin: ' . htmlspecialchars($jenis_kelamin) . '<br>';
            echo 'Kelas: ' . htmlspecialchars($kelas) . '<br>';
            if (!empty($ekskul)) {
                echo 'Ekstrakurikuler yang dipilih: ' . implode(", ", $ekskul) . '<br>';
            }
        }
    ?>
</body>
