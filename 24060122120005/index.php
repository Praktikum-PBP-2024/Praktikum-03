<!-- Nama   : Aditya Haidar Faishal -->
<!-- NIM    : 24060122120005 -->
<!-- Lab    : D2 -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Validation with Tailwind</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
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
        <h1 class="text-2xl font-bold text-center mb-6">Form Input Siswa</h1>

        <form method="POST" autocomplete="on" action="">
            <div class="mb-4">
                <label for="NIS" class="block text-gray-700 font-medium">NIS</label>
                <input type="number" id="NIS" name="nis" placeholder="Masukkan NIS" class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <div id="error_nis" class="text-red-500 text-sm mt-1"><?php if (isset($error_nis)) echo $error_nis; ?></div>
            </div>

            <div class="mb-4">
                <label for="Nama" class="block text-gray-700 font-medium">Nama</label>
                <input type="text" id="Nama" name="nama" placeholder="Masukkan Nama" class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <div id="error_nama" class="text-red-500 text-sm mt-1"><?php if (isset($error_nama)) echo $error_nama; ?></div>
            </div>

            <div class="mb-4">
                <label for="" class="block text-gray-700 font-medium">Jenis Kelamin</label>
                <div class="flex items-center mt-2">
                    <input type="radio" id="Pria" name="jenis_kelamin" value="Pria" class="mr-2">
                    <label for="Pria" class="text-gray-700">Pria</label>
                </div>
                <div class="flex items-center mt-2">
                    <input type="radio" id="Wanita" name="jenis_kelamin" value="Wanita" class="mr-2">
                    <label for="Wanita" class="text-gray-700">Wanita</label>
                </div>
                <div id="error_jenisKelamin" class="text-red-500 text-sm mt-1"><?php if (isset($error_jenisKelamin)) echo $error_jenisKelamin; ?></div>
            </div>

            <div class="mb-4">
                <label for="Kelas" class="block text-gray-700 font-medium">Kelas</label>
                <select name="kelas" id="Kelas" onchange="toggleEkstrakurikuler()" class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="X">X</option>
                    <option value="XI">XI</option>
                    <option value="XII">XII</option>
                </select>
            </div>

            <div id="ekstrakurikulerSection" class="mb-4">
                <label for="" class="block text-gray-700 font-medium">Ekstrakurikuler</label><br>
                <div class="flex items-center mt-2">
                    <input type="checkbox" id="Pramuka" name="ekstrakurikuler[]" value="Pramuka" class="mr-2">
                    <label for="Pramuka" class="text-gray-700">Pramuka</label>
                </div>
                <div class="flex items-center mt-2">
                    <input type="checkbox" id="SeniTari" name="ekstrakurikuler[]" value="Seni Tari" class="mr-2">
                    <label for="SeniTari" class="text-gray-700">Seni Tari</label>
                </div>
                <div class="flex items-center mt-2">
                    <input type="checkbox" id="Sinematografi" name="ekstrakurikuler[]" value="Sinematografi" class="mr-2">
                    <label for="Sinematografi" class="text-gray-700">Sinematografi</label>
                </div>
                <div class="flex items-center mt-2">
                    <input type="checkbox" id="Basket" name="ekstrakurikuler[]" value="Basket" class="mr-2">
                    <label for="Basket" class="text-gray-700">Basket</label>
                </div>
                <div id="error_ekstra" class="text-red-500 text-sm mt-1"><?php if (isset($error_ekstra)) echo $error_ekstra; ?></div>
            </div>

            <div class="flex justify-between mt-6">
                <input type="submit" name="submit" value="Submit" class="bg-indigo-500 text-white px-6 py-2 rounded-md shadow-sm hover:bg-indigo-600">
                <input type="reset" value="Reset" class="bg-red-500 text-white px-6 py-2 rounded-md shadow-sm hover:bg-red-600">
            </div>

            <?php
                if (isset($_POST["submit"]) && empty($error_nis) && empty($error_nama) && empty($error_jenisKelamin) && empty($error_ekstra)) {
                    echo "<h3 class='text-lg font-bold mt-4'>Your Input:</h3>";
                    echo '<p>NIS = ' . $_POST['nis'] . '</p>';
                    echo '<p>Nama = ' . $_POST['nama'] . '</p>';
                    echo '<p>Jenis Kelamin = ' . $_POST['jenis_kelamin'] . '</p>';
                    echo '<p>Kelas = ' . $_POST['kelas'] . '</p>';
                    if (!empty($_POST['ekstrakurikuler'])) {
                        echo '<p>Ekstrakurikuler yang dipilih:</p>';
                        foreach ($_POST['ekstrakurikuler'] as $ekstra) {
                            echo '<p>' . $ekstra . '</p>';
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
        };
    </script>
</body>
</html>
