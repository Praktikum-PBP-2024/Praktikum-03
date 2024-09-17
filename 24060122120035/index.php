<!-- Nama  : Abdul Majid -->
<!-- NIM   : 24060122120035  -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <?php
        $error_nis = $error_nama = $error_jenis_kelamin = $error_kelas = $error_Ekstra = '';
        $nis = $nama = $jenis_kelamin = $kelas= '';
        $Ekstra = [];

        if (isset($_POST["submit"])) {
            // Validasi NIS (harus 10 digit dan hanya angka)
            $nis = test_input($_POST['nis']);
            if(empty($nis)) {
                $error_nis = "NIS harus diisi";
            }else if ( !preg_match('/^[0-9]{10}$/', $nis)) {
                $error_nis = "NIS harus terdiri dari 10 karakter dan hanya boleh berisi angka.";
            }

            // Validasi Nama
            $nama = test_input($_POST['nama']);
            if (empty($nama)) {
                $error_nama = "Nama harus diisi.";
            } elseif (!preg_match("/^[a-zA-Z\s]*$/", $nama)) {
                $error_nama = "Nama hanya dapat berisi huruf dan spasi.";
            }

            // Validasi Jenis Kelamin
            $jenis_kelamin = isset($_POST['jenis_kelamin']) ? test_input($_POST['jenis_kelamin']) : '';
            if (empty($jenis_kelamin)) {
                $error_jenis_kelamin = "Jenis kelamin harus diisi.";
            }

            // Validasi Kelas
            $kelas = $_POST['Kelas'];
            if (empty($kelas)) {
                $error_kelas = "Kelas harus dipilih.";
            }

            // Validasi Ekstrakurikuler untuk kelas X dan XI
            if ($kelas === 'X' || $kelas === 'XI') {
                $Ekstra = isset($_POST['Ekstra']) ? $_POST['Ekstra'] : [];
                if (count($Ekstra) < 1 || count($Ekstra) > 3) {
                    $error_Ekstra = "Siswa kelas X dan XI wajib memilih minimal 1 dan maksimal 3 ekstrakurikuler.";
                }
            } elseif ($kelas === 'XII') {
                $Ekstra = []; // Siswa kelas XII tidak boleh memilih ekstrakurikuler
            }
        }

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    ?>
    <form action="" method="POST" autocomplete="on" >
        <div class="container mt-5">
            <table class="table table-bordered">
                <tr>
                    <td class="table-success">
                        Form Input Siswa
                    </td>
                </tr>
                <tr>
                    <td>
                        <!-- NIS -->
                        <div class="form-group">
                            <label for="nis">NIS (Nomor Induk Siswa)</label>
                            <input type="number" id="nis" name="nis" class="form-control" value="<?php echo htmlspecialchars($nis); ?>">
                            <div class="error text-danger"><?php if (!empty($error_nis)) echo $error_nis; ?></div>
                        </div>
                        
                        <br>

                        <!-- Nama -->
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($nama); ?>">
                            <div class="error text-danger"><?php if (!empty($error_nama)) echo $error_nama; ?></div>
                        </div>
                        
                        <br>

                        <!-- Jenis Kelamin -->
                        <label>Jenis Kelamin</label>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="jenis_kelamin" value="pria" <?php if ($jenis_kelamin == "pria") echo "checked"; ?>>
                            <label class="form-check-label">Pria</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="jenis_kelamin" value="wanita" <?php if ($jenis_kelamin == "wanita") echo "checked"; ?>>
                            <label class="form-check-label">Wanita</label>
                        </div>
                        <div class="error text-danger"><?php if (!empty($error_jenis_kelamin)) echo $error_jenis_kelamin; ?></div>
                        <br>

                        <!-- Kelas -->
                        <div class="form-group">
                            <label for="Kelas">Kelas</label>
                            <select id="Kelas" name="Kelas" class="form-control" onchange="toggleEkstra()">
                                <option value="">Pilih Kelas</option>
                                <option value="X" <?php if ($kelas == "X") echo "selected"; ?>>X</option>
                                <option value="XI" <?php if ($kelas == "XI") echo "selected"; ?>>XI</option>
                                <option value="XII" <?php if ($kelas == "XII") echo "selected"; ?>>XII</option>
                            </select>
                            <div class="error text-danger"><?php if (!empty($error_kelas)) echo $error_kelas; ?></div>
                        </div>
                        
                        <br>

                        <!-- Ekstrakurikuler (hanya untuk kelas X dan XI) -->
                        <div id="ekstraSection">
                            <label>Ekstrakurikuler</label>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="Ekstra[]" value="Pramuka" <?php if (in_array("Pramuka", $Ekstra)) echo "checked"; ?>>
                                <label class="form-check-label">Pramuka</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="Ekstra[]" value="SeniTari" <?php if (in_array("SeniTari", $Ekstra)) echo "checked"; ?>>
                                <label class="form-check-label">Seni Tari</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="Ekstra[]" value="Sinematografi" <?php if (in_array("Sinematografi", $Ekstra)) echo "checked"; ?>>
                                <label class="form-check-label">Sinematografi</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="Ekstra[]" value="Basket" <?php if (in_array("Basket", $Ekstra)) echo "checked"; ?>>
                                <label class="form-check-label">Basket</label>
                            </div>
                        </div>
                        <div class="error text-danger"><?php if (!empty($error_Ekstra)) echo $error_Ekstra; ?></div>
                        <br>

                        <button type="submit" class="btn btn-primary" name="submit" value="submit">Submit</button>
                        <button type="reset" class="btn btn-danger" onclick="window.location.href = window.location.href;">Reset</button>
                    </td>
                </tr>
            </table>
        </div>
    </form>

    <script>
        // Fungsi untuk menampilkan atau menyembunyikan pilihan ekstrakurikuler berdasarkan kelas yang dipilih
        function toggleEkstra() {
            var kelas = document.getElementById("Kelas").value;
            var ekstraSection = document.getElementById("ekstraSection");
            if (kelas === 'X' || kelas === 'XI') {
                ekstraSection.style.display = 'block';
            } else {
                ekstraSection.style.display = 'none';
            }
        }
    </script>

    <?php // Jika tidak ada error, tampilkan data yg dimasukan
        if (empty($error_nis) && empty($error_nama) && empty($error_jenis_kelamin) && empty($error_kelas) && empty($error_Ekstra)) {
            echo "<h3>Data yang Dimasukkan:</h3>";
            echo "NIS: " . htmlspecialchars($nis) . "<br>";
            echo "Nama: " . htmlspecialchars($nama) . "<br>";
            echo "Jenis Kelamin: " . htmlspecialchars($jenis_kelamin) . "<br>";
            echo "Kelas: " . htmlspecialchars($kelas) . "<br>";
            if (!empty($Ekstra)) {
                echo "Ekstrakurikuler yang dipilih: " ;
                foreach ($Ekstra as $Ektra_item) {
                    echo '<br />' . htmlspecialchars($Ektra_item);
                }
            }

        }
    ?>
</body>
</html>
