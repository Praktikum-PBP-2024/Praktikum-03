<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Siswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        form {
            width: 400px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 8px;
            background-color: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: inline-block;
        }

        input[type="text"], select {
            width: 90%;
            padding: 8px;
            margin: 10px 0 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="radio"] {
            margin-right: 10px;
        }

        input[type="checkbox"] {
            margin-right: 5px;
        }

        button {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
        }

        button[type="submit"] {
            background-color: #007bff;
            color: white;
        }

        button[type="reset"] {
            background-color: #dc3545;
            color: white;
        }

        .error {
            color: red;
            font-size: 12px;
        }

        div {
            margin-bottom: 10px;
        }

        .form-title {
            text-align: center;
            font-size: 22px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        #ekstrakurikuler {
            margin-top: 10px;
        }

        .output {
            text-align: center;
            margin-top: 20px;
        }
    </style>
    <script>
        function PopEkstrakurikuler() {
            var kelas = document.getElementById('kelas').value;
            var ekskul = document.getElementById('ekstrakurikuler');
            if (kelas === 'X' || kelas === 'XI') {
                ekskul.style.display = 'block';
            } else {
                ekskul.style.display = 'none';
            }
        }
    </script>
</head>
<body>
    <?php
        $error_nis = $error_nama = $error_jeniskelamin = $error_kelas = $error_ekstrakurikuler = '';
        $nis = $nama = $jeniskelamin = $kelas= '';

        $kelas = isset($_POST['kelas']) ? $_POST['kelas'] : 'X';
        $ekstrakurikuler = isset($_POST['ekstrakurikuler']) ? $_POST['ekstrakurikuler'] : [];

        if (isset($_POST["submit"])){
            $nis = test_input($_POST['nis']);
            if (empty($nis)){
                $error_nis = "NIS harus diisi";
            }
            elseif (!preg_match("/^[0-9]*$/", $nis)){
                $error_nis = "NIS hanya boleh berisi angka dari 0-9";
            }
            elseif (strlen($nis) != 10){
                $error_nis = "NIS terdiri atas 10 karakter";
            }

            $nama = test_input($_POST['nama']);
            if (empty($nama)){
                $error_nama = "Nama harus diisi";
            }

            $jeniskelamin = isset($_POST['jeniskelamin']) ? $_POST['jeniskelamin'] : '';
            if (empty($jeniskelamin)){
                $error_jeniskelamin = "Jenis Kelamin harus diisi";
            }

            if (($kelas == 'X' || $kelas == 'XI') && empty($ekstrakurikuler)){
                $error_ekstrakurikuler = "Ekstrakurikuler harus diisi";
            }
            else if (count($ekstrakurikuler) > 3){
                $error_ekstrakurikuler = "Ekstrakurikuler maksimal dipilih yaitu 3";
            }
        }

        function test_input($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    ?>

    <div></div>
    <form action="" method="POST" autocomplete="on">
        <div class="form-title">
            <label>Form Input Siswa</label>
        </div>
        <div>
            <label>NIS:</label><br/>
            <input type="text" name="nis" value="<?php echo isset($nis) ? htmlspecialchars($nis) : ''; ?>"> 
            <div class="error"><?php if (!empty($error_nis)) echo $error_nis; ?></div>
        </div>
        <div>
            <label>Nama:</label><br/>
            <input type="text" name="nama" value="<?php echo isset($nama) ? htmlspecialchars($nama) : ''; ?>"> 
            <div class="error"><?php if (!empty($error_nama)) echo $error_nama; ?></div>
        </div>
        <label>Jenis Kelamin:</label>
        <div>
            <label>
                <input type="radio" name="jeniskelamin" value="pria" <?php if ($jeniskelamin == "pria") echo "checked"; ?>>
                Pria
            </label>
        </div>
        <div>
            <label>
                <input type="radio" name="jeniskelamin" value="wanita" <?php if ($jeniskelamin == "wanita") echo "checked"; ?>>
                Wanita
            </label>
        </div>
        <div class="error"><?php if (!empty($error_jeniskelamin)) echo $error_jeniskelamin; ?></div>
        <div>
            <label>Kelas:</label>
            <select name="kelas" id="kelas" onchange="PopEkstrakurikuler()">
                <option value="X" <?php if ($kelas == "X") echo "selected"; ?>>X</option>
                <option value="XI" <?php if ($kelas == "XI") echo "selected"; ?>>XI</option>
                <option value="XII" <?php if ($kelas == "XII") echo "selected"; ?>>XII</option>
            </select>
        </div>

        <div id="ekstrakurikuler" style="display: <?php echo ($kelas == 'X' || $kelas == 'XI') ? 'block' : 'none'; ?>">
                <h3>Ekstrakurikuler:</h3>
                <input type="checkbox" name="ekstrakurikuler[]" value="Pramuka" 
                    <?php if (in_array("Pramuka", $ekstrakurikuler)) echo "checked"; ?>>
                <label for="pramuka">Pramuka</label><br/>

                <input type="checkbox" name="ekstrakurikuler[]" value="Seni Tari" 
                    <?php if (in_array("Seni Tari", $ekstrakurikuler)) echo "checked"; ?>>
                <label for="seni_tari">Seni Tari</label><br/>

                <input type="checkbox" name="ekstrakurikuler[]" value="Sinematografi" 
                    <?php if (in_array("Sinematografi", $ekstrakurikuler)) echo "checked"; ?>>
                <label for="sinematografi">Sinematografi</label><br/>

                <input type="checkbox" name="ekstrakurikuler[]" value="Basket" 
                    <?php if (in_array("Basket", $ekstrakurikuler)) echo "checked"; ?>>
                <label for="basket">Basket</label><br/>
                <div class="error"><?php if (!empty($error_ekstrakurikuler)) echo $error_ekstrakurikuler; ?></div>
        </div>

        <br/>
        <button type="submit" name="submit" value="submit">
            Submit
        </button>
        <button type="reset" value="reset" value="reset">
            Reset
        </button>
    </form>
    
    <?php
        if (isset($_POST['submit'])){
            if (empty($error_nis) && empty($error_nama) && empty($error_jeniskelamin) && empty($error_ekstrakurikuler)) {
                echo '<div class="output">';
                echo "<h3>Your Input:</h3>";
                echo 'NIS = ' . htmlspecialchars($nis) . '<br/>';
                echo 'Nama = ' . htmlspecialchars($nama) . '<br/>';
                echo 'Jenis Kelamin = ' . htmlspecialchars($jeniskelamin) . '<br/>';
                echo 'Kelas = ' . htmlspecialchars($kelas) . '<br/>';

                if (!empty($ekstrakurikuler)) {
                    if ($kelas == 'X' || $kelas == 'XI'){
                        echo 'Ekstrakurikuler: ';
                        foreach ($ekstrakurikuler as $namaekskul) {
                            echo '<br />' . htmlspecialchars($namaekskul);
                        }
                    }
                }
                echo '</div>';
            }
        }
    ?>
</body>
</html>
