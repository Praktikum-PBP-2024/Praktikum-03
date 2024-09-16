<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Siswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 50%;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
        }

        h3 {
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input[type="text"], 
        .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-group input[type="radio"],
        .form-group label.inline {
            display: inline;
        }

        .form-group input[type="checkbox"] {
            margin-right: 10px;
        }

        .btn-group {
            text-align: center;
        }

        .btn-group button {
            padding: 10px 15px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-submit {
            background-color: blue;
            color: white;
        }

        .btn-reset {
            background-color: red;
            color: white;
        }

        .text-danger {
            color: red;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Form Input Siswa</h3>

        <?php
        // Inisialisasi variabel untuk menghindari "undefined variable"
        $nis = $nama = $gender = $kelas = "";
        $nisErr = $namaErr = $genderErr = $kelasErr = $ekskulErr = "";
        $isSubmitted = false;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Validasi NIS
            if (empty($_POST["nis"])) {
                $nisErr = "NIS harus diisi";
            } else {
                $nis = $_POST["nis"];
                // Validasi panjang NIS dan hanya angka
                if (!preg_match("/^[0-9]{10}$/", $nis)) {
                    $nisErr = "NIS harus 10 digit angka";
                }
            }

            // Validasi Nama
            if (empty($_POST["nama"])) {
                $namaErr = "Nama harus diisi";
            } else {
                $nama = $_POST["nama"];
            }

            // Validasi Jenis Kelamin
            if (empty($_POST["gender"])) {
                $genderErr = "Jenis kelamin harus dipilih";
            } else {
                $gender = $_POST["gender"];
            }

            // Validasi Kelas
            if (empty($_POST["kelas"])) {
                $kelasErr = "Kelas harus dipilih";
            } else {
                $kelas = $_POST["kelas"];
            }

            // Validasi Ekstrakurikuler (hanya jika kelas X atau XI)
            if ($kelas == "X" || $kelas == "XI") {
                if (empty($_POST["ekskul"])) {
                    $ekskulErr = "Pilih minimal 1 ekstrakurikuler";
                } elseif (count($_POST["ekskul"]) > 3) {
                    $ekskulErr = "Pilih maksimal 3 ekstrakurikuler";
                }
            }
            // Jika tidak ada error, set flag isSubmitted menjadi true
            if (empty($nisErr) && empty($namaErr) && empty($genderErr) && empty($kelasErr) && empty($ekskulErr)) {
                $isSubmitted = true;
            }
        }
        ?>

        <?php if ($isSubmitted): ?>
            <script>alert('Form submitted successfully')</script>
        <?php endif; ?>

        <form id="myForm" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
            <div class="form-group">
                <label for="nis">NIS:</label>
                <input type="text" id="nis" name="nis" value="<?php echo htmlspecialchars($nis);?>">
                <span class="text-danger"><?php echo $nisErr;?></span>
            </div>

            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($nama);?>">
                <span class="text-danger"><?php echo $namaErr;?></span>
            </div>

            <div class="form-group">
                <label>Jenis Kelamin:</label><br>
                <input type="radio" id="pria" name="gender" value="Pria" <?php if (isset($gender) && $gender == "Pria") echo "checked";?>>
                <label class="inline" for="pria">Pria</label><br>
                <input type="radio" id="wanita" name="gender" value="Wanita" <?php if (isset($gender) && $gender == "Wanita") echo "checked";?>>
                <label class="inline" for="wanita">Wanita</label><br>
                <span class="text-danger"><?php echo $genderErr;?></span>
            </div>

            <div class="form-group">
                <label for="kelas">Kelas:</label>
                <select id="kelas" name="kelas" onchange="showEkskul()">
                    <option value="">Pilih Kelas</option>
                    <option value="X" <?php if ($kelas == "X") echo "selected";?>>X</option>
                    <option value="XI" <?php if ($kelas == "XI") echo "selected";?>>XI</option>
                    <option value="XII" <?php if ($kelas == "XII") echo "selected";?>>XII</option>
                </select>
                <span class="text-danger"><?php echo $kelasErr;?></span>
            </div>

            <div class="form-group" id="ekskul-section" style="display:none;">
                <label>Ekstrakurikuler:</label><br>
                <input type="checkbox" id="pramuka" name="ekskul[]" value="Pramuka" <?php if (isset($_POST['ekskul']) && in_array("Pramuka", $_POST['ekskul'])) echo "checked";?>>
                <label class="inline" for="pramuka">Pramuka</label><br>
                <input type="checkbox" id="senitari" name="ekskul[]" value="Seni Tari" <?php if (isset($_POST['ekskul']) && in_array("Seni Tari", $_POST['ekskul'])) echo "checked";?>>
                <label class="inline" for="senitari">Seni Tari</label><br>
                <input type="checkbox" id="sinematografi" name="ekskul[]" value="Sinematografi" <?php if (isset($_POST['ekskul']) && in_array("Sinematografi", $_POST['ekskul'])) echo "checked";?>>
                <label class="inline" for="sinematografi">Sinematografi</label><br>
                <input type="checkbox" id="basket" name="ekskul[]" value="Basket" <?php if (isset($_POST['ekskul']) && in_array("Basket", $_POST['ekskul'])) echo "checked";?>>
                <label class="inline" for="basket">Basket</label><br>
                <span class="text-danger"><?php echo $ekskulErr;?></span>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn-submit">Submit</button>
                <button type="button" class="btn-reset" onclick="resetForm()">Reset</button>
            </div>
        </form>
    </div>

    <script>
        // Fungsi untuk menampilkan atau menyembunyikan pilihan ekstrakurikuler berdasarkan kelas yang dipilih
        function showEkskul() {
            var kelas = document.getElementById("kelas").value;
            var ekskulSection = document.getElementById("ekskul-section");

            if (kelas === "X" || kelas === "XI") {
                ekskulSection.style.display = "block";
            } else {
                ekskulSection.style.display = "none";
            }
        }

        // Fungsi untuk mereset form dan menghapus pesan error
        function resetForm() {
            // Reset semua input dalam form
            document.getElementById("myForm").reset();

            // Menghapus pesan error
            const errorMessages = document.querySelectorAll(".error-message");
            errorMessages.forEach(function(message) {
                message.textContent = "";
            });
        }

    // Menjalankan kedua fungsi saat halaman dimuat
    window.onload = function() {
        showEkskul();
        resetForm();
    };
    </script>
</body>
</html>
