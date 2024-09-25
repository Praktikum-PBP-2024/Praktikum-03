<!-- Nama    : Aditya Haidar Faishal -->
<!-- NIM     : 24060122120005        -->
<!-- LAB     : D2                    -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Validation</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="mt-24 bg-neutral-200" >
    <?php
        if (isset($_POST["submit"])) {
            $nis = test_input($_POST['nis']);
            if (empty($nis)) {
                $error_nis = "NIS harus diisi";
            } elseif (!preg_match("/^[0-9]{10}$/", $nis)) {
                $error_nis = "NIS harus terdiri atas 10 karakter dan hanya boleh berisi angka 0-9";
            }

            $nama = test_input($_POST['nama']);
            if (empty($nama)) {
                $error_nama = "Nama harus diisi";
            } elseif (!preg_match("/^[a-zA-Z ]*$/", $nama)) {
                $error_nama = "Nama hanya dapat berisi huruf dan spasi";
            }

            $jenisKelamin = test_input($_POST['jenis_kelamin']);
            if (empty($jenisKelamin)) {
                $error_jenisKelamin = "Jenis Kelamin harus diisi";
            }

            $kelas = $_POST['kelas'];
            if ($kelas == "X" || $kelas == "XI") {
                if (!isset($_POST['ekstrakurikuler']) || count($_POST['ekstrakurikuler']) < 1) {
                    $error_ekstra = "Pilih minimal 1 ekstrakurikuler.";
                } elseif (count($_POST['ekstrakurikuler']) > 3) {
                    $error_ekstra = "Pilih maksimal 3 ekstrakurikuler.";
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
    
<div class="max-w-lg mx-auto mt-10 p-6 bg-white rounded-lg shadow-lg">
    <form method="POST" autocomplete="on" action="" id="form" class="container mx-auto w-96 flex flex-col gap-y-4">
        <h1 class="font-bold text-center text-xl mb-2">Form Input Siswa</h1>
    
        <div class="flex flex-col">
            <label for="NIS">NIS</label>
            <input type="number" id="NIS" name="nis" class="border-2 border-gray-400">
            <div id="error_nis" class="error text-red-500"><?php if (isset($error_nis)) echo $error_nis; ?></div>
        </div>

        <div class="flex flex-col">
            <label for="Nama">Nama</label>
            <input type="text" id="Nama" name="nama" class="border-2 border-gray-400">
            <div id="error_nama" class="error text-red-500"><?php if (isset($error_nama)) echo $error_nama; ?></div>
        </div>

        <div class="flex flex-col">
            <label for="">Jenis Kelamin</label>
            <div>
                <input type="radio" id="Pria" name="jenis_kelamin" value="Pria">
                <label for="Pria">Pria</label>
            </div>
            <div>
                <input type="radio" id="Wanita" name="jenis_kelamin" value="Wanita">
                <label for="Wanita">Wanita</label>
            </div>
            <div id="error_jenisKelamin" class="error text-red-500"><?php if (isset($error_jenisKelamin)) echo $error_jenisKelamin; ?></div>
        </div>

        <div class="flex flex-col">
            <label for="Kelas">Kelas</label>
            <select name="kelas" id="Kelas" onchange="toggleEkstrakurikuler()" class="border-2 border-gray-400">
                <option value="X">X</option>
                <option value="XI">XI</option>
                <option value="XII">XII</option>
            </select>
        </div>

        <div id="ekstrakurikulerSection">
            <label for="">Ekstrakurikuler</label><br>
            <input type="checkbox" id="Pramuka" name="ekstrakurikuler[]" value="Pramuka">
            <label for="Pramuka">Pramuka</label><br>
            <input type="checkbox" id="SeniTari" name="ekstrakurikuler[]" value="Seni Tari">
            <label for="SeniTari">Seni Tari</label><br>
            <input type="checkbox" id="Sinematografi" name="ekstrakurikuler[]" value="Sinematografi">
            <label for="Sinematografi">Sinematografi</label><br>
            <input type="checkbox" id="Basket" name="ekstrakurikuler[]" value="Basket">
            <label for="Basket">Basket</label><br>
            <div id="error_ekstra" class="error text-red-500"><?php if (isset($error_ekstra)) echo $error_ekstra; ?></div>
        </div>

        <div class="flex gap-4">
            <input type="submit" name="submit" value="Submit" class="bg-indigo-500 px-4 py-2 rounded-lg text-white font-bold">
            <input type="reset" class="bg-red-600 px-4 py-2 rounded-lg text-white font-bold">
        </div>

        <?php
            if (isset($_POST["submit"]) && empty($error_nis) && empty($error_nama) && empty($error_jenisKelamin) && empty($error_ekstra)) {
                echo "<h3>Your Input:</h3>";
                echo 'NIS = ' . $_POST['nis'] . '<br />';
                echo 'Nama = ' . $_POST['nama'] . '<br />';
                echo 'Jenis Kelamin = ' . $_POST['jenis_kelamin'] . '<br />';
                echo 'Kelas = ' . $_POST['kelas'] . '<br />';
                if (!empty($_POST['ekstrakurikuler'])) {
                    echo 'Ekstrakurikuler yang dipilih: ';
                    foreach ($_POST['ekstrakurikuler'] as $ekstra) {
                        echo '<br />' . $ekstra;
                    }
                }
            }
        ?>
    </form>
</div>

    <script>
        function toggleEkstrakurikuler() {
            var kelas = document.getElementById('Kelas').value;
            var ekstraSection = document.getElementById('ekstrakurikulerSection');
            if (kelas === 'XII') {
                ekstraSection.style.display = 'none';
                var checkboxes = document.querySelectorAll('input[name="ekstrakurikuler[]"]');
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = false;
                });
            } else {
                ekstraSection.style.display = 'block';
            }
        }

        window.onload = function() {
            toggleEkstrakurikuler();

            document.getElementById('form').addEventListener('submit', function(event) {
        let errors = false;

        document.querySelectorAll('.error').forEach(function(errorDiv) {
            errorDiv.textContent = '';
        });

        const nis = document.getElementById('NIS').value;
        if (nis === '') {
            document.getElementById('error_nis').textContent = 'NIS harus diisi.';
            errors = true;
        } else if (!/^[0-9]{10}$/.test(nis)) {
            document.getElementById('error_nis').textContent = 'NIS harus terdiri atas 10 karakter angka.';
            errors = true;
        }

        const nama = document.getElementById('Nama').value;
        if (nama === '') {
            document.getElementById('error_nama').textContent = 'Nama harus diisi.';
            errors = true;
        } else if (!/^[a-zA-Z ]+$/.test(nama)) {
            document.getElementById('error_nama').textContent = 'Nama hanya dapat berisi huruf dan spasi.';
            errors = true;
        }

        const jenisKelamin = document.querySelector('input[name="jenis_kelamin"]:checked');
        if (!jenisKelamin) {
            document.getElementById('error_jenisKelamin').textContent = 'Jenis Kelamin harus diisi.';
            errors = true;
        }

        const kelas = document.getElementById('Kelas').value;
        const ekstraCheckboxes = document.querySelectorAll('input[name="ekstrakurikuler[]"]:checked');
        if ((kelas === 'X' || kelas === 'XI') && (ekstraCheckboxes.length < 1 || ekstraCheckboxes.length > 3)) {
            document.getElementById('error_ekstra').textContent = 'Pilih minimal 1 dan maksimal 3 ekstrakurikuler.';
            errors = true;
        }

        if (errors) {
            event.preventDefault();
        }
    });
        };
    </script>
</body>
</html>
