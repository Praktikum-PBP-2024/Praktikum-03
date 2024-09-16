<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POST</title>
    <style>
        html, h1{
            font-family: 'Segoe UI';
            font-weight: 400;
        }
        .form-border, .header{
            border: solid 1px rgb(209, 209, 209);
            width: 640px;
        }
        .form-border{
            padding: 0px 17px 17px 17px;
        }
        .header{
            border-bottom: solid 1px rgb(240, 240, 240);
            padding: 0 17px 0 17px;
            background-color: rgb(240, 240, 240);
        }   
        h1{
            font-size: 20px;
        }
        .form-field{
            margin-bottom: 12px;
        }
        label{
            display: block;
        }
        .long-input{
            width: 600px;
            height:25px;
            border: 1px solid rgb(209, 209, 209);
        }
        button{
            color: white;
            border: 0;
            width: 65px;
            height: 30px;
            border-radius: 5px;
            margin-top: 20px;
        }
        button[type="submit"]{
            background-color: #007bff;
        }
        button[type="reset"]{
            background-color: #dc3545;
        }
        .error{
            color:red;
        }
    </style>
</head>
<body>
    <?php
        $error_nis = $error_nama = $error_jenis_kelamin = $error_kelas = $error_ekstra = '';
        $nis = $nama = $jenis_kelamin = $kelas = '';
        $ekstra = [];

        if (isset($_POST["submit"])) {

            // Validasi NIS
            $nis = test_input($_POST['nis']);
            if (empty($nis)) {
                $error_nis = "NIS harus diisi";
            } elseif (!preg_match("/^[0-9]{10}$/", $nis)) {
                $error_nis = "NIS harus terdiri dari 10 karakter berisi angka 0-9";
            }
            
            // Validasi Nama
            $nama = test_input($_POST['nama']);
            if (empty($nama)) {
                $error_nama = "Nama harus diisi";
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
            
            // Validasi Ekstrakulikuler
            $ekstra = isset($_POST['ekstra']) ? $_POST['ekstra'] : [];
            if ($kelas == "x" || $kelas == "xi"){
                if (empty($ekstra)) {
                    $error_ekstra = "Ekstrakulikuler harus diisi";
                }
                else if (sizeof($ekstra) > 3){
                    $error_ekstra = "Jumlah maksimal ekstrakulikuler yang diisi adalah 3";
                }
            }
            else{
                $ekstra = [];
            }
        }

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    ?>
    <div class="header"><h1>Form Input Siswa</h1></div>
        
        
    <div class="form-border">
        <form action="" method="POST" autocomplete="on">
            <!-- NIS -->
            <div class="form-field nis">
                <label for="nis">NIS:</label> 
                <input type="text" class="long-input" id="nis" name="nis" value="<?php echo isset($nis) ? htmlspecialchars($nis) : 'nis'; ?>">
                <div class="error"><?php if(!empty($error_nis)) echo $error_nis; ?></div>
            </div>
            
            <!-- Nama -->
            <div class="form-field nama ">
                <label for="nama">Nama:</label>
                <input type="text" class="long-input" id="nama" name="nama" value="<?php echo isset($nama) ? htmlspecialchars($nama) : ''; ?>">
                <div class="error"><?php if(!empty($error_nama)) echo $error_nama; ?></div>
            </div>

            <!-- Jenis Kelamin -->
            <div class="form-field jenis-kelamin">
                <label>Jenis Kelamin:</label> 
                <label>
                    <input type="radio" class="form-check-input" name="jenis_kelamin" value="pria" <?php if ($jenis_kelamin == "pria") echo "checked"; ?>>
                    Pria
                </label>
                <label>
                    <input type="radio" class="form-check-input" name="jenis_kelamin" value="wanita" <?php if ($jenis_kelamin == "wanita") echo "checked"; ?>>
                    Wanita
                </label>
                <div class="error"><?php if(!empty($error_jenis_kelamin)) echo $error_jenis_kelamin; ?></div>
            </div>

            <!-- Kelas -->
            <div class="form-field kelas">
                <label for="kelas">Kelas:</label>
                <select id="kelas" name="kelas" class="long-input">
                    <option value="">Pilih Kelas</option>
                    <option value="x" <?php if ($kelas == "x") echo "selected"; ?>>X</option>
                    <option value="xi" <?php if ($kelas == "xi") echo "selected"; ?>>XI</option>
                    <option value="xii" <?php if ($kelas == "xii") echo "selected"; ?>>XII</option>
                </select>
                <div class="error"><?php if(!empty($error_kelas)) echo $error_kelas; ?></div>
            </div>

            <!-- Ekstrakulikuler -->
            <div class="form-check" name="ekstras-div">
                <label name="ekstras-div">Ekstrakulikuler:</label>
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="ekstra[]" value="pramuka" <?php if (in_array("pramuka", $ekstra)) echo "checked"; ?>>
                    Pramuka
                </label> 
                <label class="form-check-label">
                <input type="checkbox" class="form-check-input" name="ekstra[]" value="seni_tari" <?php if (in_array("seni_tari", $ekstra)) echo "checked"; ?>>
                    Seni Tari
                </label> 
                <label class="form-check-label">
                <input type="checkbox" class="form-check-input" name="ekstra[]" value="sinematografi" <?php if (in_array("sinematografi", $ekstra)) echo "checked"; ?>>
                    Sinematografi
                </label>
                <label class="form-check-label">
                <input type="checkbox" class="form-check-input" name="ekstra[]" value="basket" <?php if (in_array("basket", $ekstra)) echo "checked"; ?>>
                    Basket
                </label>
                <div class="error"><?php if(!empty($error_ekstra)) echo $error_ekstra; ?></div>
            </div>

            <!-- submit, reset dan button -->
            <button type="submit" class="btn btn-primary" name="submit" value="submit">
                Submit
            </button>
            <button type="reset" value="reset" class="btn btn-danger" name="reset">
                Reset
            </button>
        </form>
    </div>

    <script>
        const pilihKelas = document.getElementById('kelas');

        function hideEkstras(){
            const ekstras = document.getElementsByName('ekstras-div');
            if (pilihKelas.value == "xii"){
                for (let i=0; i<ekstras.length; i++){
                    ekstras[i].setAttribute('hidden', 'true');
                }
            }  
            else{
                for (let i=0; i<ekstras.length; i++){
                    ekstras[i].removeAttribute('hidden');
                }
            }
        }

        window.onload = hideEkstras;
        pilihKelas.onchange = hideEkstras;
    </script>
    <?php
        // Jika tidak ada error, tampilkan input
        if (!empty($_POST) && empty($error_nis) && empty($error_nama) && empty($error_jenis_kelamin) && empty($error_kelas) && empty($error_ekstra)) {
            echo "<h3>Your Input:</h3>";
            echo 'NIS = ' .htmlspecialchars($nis) . '<br />';
            echo 'Nama = ' . htmlspecialchars($nama) . '<br />';
            echo 'Jenis Kelamin = ' . htmlspecialchars($jenis_kelamin) . '<br />';
            echo 'Kelas = ' . htmlspecialchars($kelas) . '<br />';
            
            if (!empty($ekstra)) {
                echo 'Esktrakulikuler yang dipilih: ';
                foreach ($ekstra as $ekstra_item) {
                    echo '<br />' . htmlspecialchars($ekstra_item);
                }
            }
        }
    ?>
</body>
</html>
