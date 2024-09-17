<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Siswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            width: 100%;
            padding: 20px 0;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #555;
        }

        input[type="text"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="radio"],
        input[type="checkbox"] {
            margin-right: 10px;
        }

        .gender-options,
        .ekskul-options {
            margin-bottom: 20px;
        }

        .error {
            color: red;
            font-size: 14px;
        }

        .Hasil {
            color: black;
            font-size: 14px;
        }

        .buttons {
            display: flex;
            justify-content: flex-start;
        }

        .buttons input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .buttons input[type="reset"] {
            background-color: #dc3545;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 10px;
        }

        .buttons input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .buttons input[type="reset"]:hover {
            background-color: #c82333;
        }

        #ekskulDiv {
            display: none;
        }
    </style>
</head>
<body>

<div class="container">
    <?php
    $nisErr = $namaErr = $genderErr = $kelasErr = $ekskulErr = $nis = $nama = $gender = $kelas = "";
    $ekskul = [];

    if (isset($_POST['submit'])) {
        $valid = true;

        if (empty($_POST["nis"])) {
            $nisErr = "NIS harus diisi";
            $valid = false;
        } elseif (!preg_match("/^[0-9]{10}$/", $_POST["nis"])) {
            $nisErr = "NIS harus terdiri dari 10 angka";
            $valid = false;
        } else {
            $nis = $_POST["nis"];
        }

        if (empty($_POST["nama"])) {
            $namaErr = "Nama harus diisi";
            $valid = false;
        } else {
            $nama = $_POST["nama"];
        }


        if (empty($_POST["gender"])) {
            $genderErr = "Jenis kelamin harus dipilih";
            $valid = false;
        } else {
            $gender = $_POST["gender"];
        }


        if (empty($_POST["kelas"])) {
            $kelasErr = "Kelas harus dipilih";
            $valid = false;
        } else {
            $kelas = $_POST["kelas"];
            if ($kelas == "X" || $kelas == "XI") {
                if (empty($_POST["ekskul"])) {
                    $ekskulErr = "Minimal pilih 1 ekstrakurikuler";
                    $valid = false;
                } elseif (count($_POST["ekskul"]) > 3) {
                    $ekskulErr = "Maksimal pilih 3 ekstrakurikuler";
                    $valid = false;
                } else {
                    $ekskul = $_POST["ekskul"];
                }
            }
        }
    }
    ?>

    <h2>Form Input Siswa</h2>
    <form method="post" action="">
        <label>NIS:</label>
        <input type="text" name="nis" value="<?php echo $nis; ?>">
        <span class="error"> <?php echo $nisErr; ?></span>
        <br><br>

        <label>Nama:</label>
        <input type="text" name="nama" value="<?php echo $nama; ?>">
        <span class="error"> <?php echo $namaErr; ?></span>
        <br><br>

        <label>Jenis Kelamin:</label>
        <div class="gender-options">
            <input type="radio" name="gender" value="Pria" <?php if ($gender == "Pria") echo "checked"; ?>> Pria
            <input type="radio" name="gender" value="Wanita" <?php if ($gender == "Wanita") echo "checked"; ?>> Wanita
        </div>
        <span class="error"> <?php echo $genderErr; ?></span>
        <br><br>

        <label>Kelas:</label>
        <select name="kelas" id="kelas" onchange="toggleEkskul()">
            <option value="">Pilih Kelas</option>
            <option value="X" <?php if ($kelas == "X") echo "selected"; ?>>X</option>
            <option value="XI" <?php if ($kelas == "XI") echo "selected"; ?>>XI</option>
            <option value="XII" <?php if ($kelas == "XII") echo "selected"; ?>>XII</option>
        </select>
        <span class="error"> <?php echo $kelasErr; ?></span>
        <br><br>

        <div id="ekskulDiv">
            <label>Ekstrakurikuler (pilih 1-3):</label>
            <div class="ekskul-options">
                <input type="checkbox" name="ekskul[]" value="Pramuka" <?php if (in_array("Pramuka", $ekskul)) echo "checked"; ?>> Pramuka<br>               
                <input type="checkbox" name="ekskul[]" value="Seni Tari" <?php if (in_array("Seni Tari", $ekskul)) echo "checked"; ?>> Seni Tari<br>            
                <input type="checkbox" name="ekskul[]" value="Sinematografi" <?php if (in_array("Sinematografi", $ekskul)) echo "checked"; ?>> Sinematografi<br>
                <input type="checkbox" name="ekskul[]" value="Basket" <?php if (in_array("Basket", $ekskul)) echo "checked"; ?>> Basket<br>
            </div>
            <span class="error"> <?php echo $ekskulErr; ?></span>
        </div>
        <br>

        <div class="buttons">
            <input type="submit" name="submit" value="Submit">
            <input type="reset" value="Reset">
        </div>
        <span> <?php 
            if ($valid) {
                echo "<h4>Data berhasil di-submit!</h4>";
                echo "NIS: $nis<br>";
                echo "Nama: $nama<br>";
                echo "Jenis Kelamin: $gender<br>";
                echo "Kelas: $kelas<br>";
                if (!empty($ekskul)) {
                    echo "Ekstrakurikuler: " . implode(", ", $ekskul) . "<br>";
                }
            }
        ?></span>
    </form>
</div>

<script>
    function toggleEkskul() {
        var kelas = document.getElementById("kelas").value;
        var ekskulDiv = document.getElementById("ekskulDiv");
        if (kelas == "X" || kelas == "XI") {
            ekskulDiv.style.display = "block";
        } else {
            ekskulDiv.style.display = "none";
        }
    }
    toggleEkskul();
</script>
</body>
</html>
