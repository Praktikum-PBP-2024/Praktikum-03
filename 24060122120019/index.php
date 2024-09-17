<?php
$nisError = $nameError = $genderError = $classError = $extracurricularError = "";
$nis = $name = $gender = $class = "";
$extracurricular = [];
$valid = true;
$showResults = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['nis'])) {
        $nisError = "NIS harus diisi.";
        $valid = false;
    } elseif (!preg_match('/^\d{10}$/', $_POST['nis'])) {
        $nisError = "NIS harus 10 karakter dan berisi angka.";
        $valid = false;
    } else {
        $nis = htmlspecialchars($_POST['nis']);
    }

    if (empty($_POST['name'])) {
        $nameError = "Nama harus diisi.";
        $valid = false;
    } else {
        $name = htmlspecialchars($_POST['name']);
    }

    if (empty($_POST['gender'])) {
        $genderError = "Pilih jenis kelamin.";
        $valid = false;
    } else {
        $gender = htmlspecialchars($_POST['gender']);
    }

    if (empty($_POST['class'])) {
        $classError = "Pilih kelas.";
        $valid = false;
    } else {
        $class = htmlspecialchars($_POST['class']);
    }

    if ($class === "X" || $class === "XI") {
        if (empty($_POST['extracurricular'])) {
            $extracurricularError = "Pilih minimal 1 dan maksimal 3 ekstrakurikuler.";
            $valid = false;
        } elseif (count($_POST['extracurricular']) > 3) {
            $extracurricularError = "Pilih maksimal 3 ekstrakurikuler.";
            $valid = false;
        } else {
            $extracurricular = $_POST['extracurricular'];
        }
    }

    if ($valid) {
        $showResults = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Siswa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Form Input Siswa</h2>
        <form id="studentForm" action="" method="post">
            <div class="form-group">
                <label for="nis">NIS:</label>
                <input type="text" class="form-control" id="nis" name="nis" value="<?= isset($_POST['nis']) ? htmlspecialchars($_POST['nis']) : '' ?>">
                <small class="text-danger"><?= $nisError ?></small>
            </div>
            <div class="form-group">
                <label for="name">Nama:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>">
                <small class="text-danger"><?= $nameError ?></small>
            </div>
            <div class="form-group">
                <label>Jenis Kelamin:</label><br>
                <input type="radio" name="gender" id="male" value="Pria" <?= (isset($_POST['gender']) && $_POST['gender'] === 'Pria') ? 'checked' : '' ?>> Pria
                <input type="radio" name="gender" id="female" value="Wanita" <?= (isset($_POST['gender']) && $_POST['gender'] === 'Wanita') ? 'checked' : '' ?>> Wanita
                <small class="text-danger"><?= $genderError ?></small>
            </div>
            <div class="form-group">
                <label for="class">Kelas:</label>
                <select class="form-control" id="class" name="class">
                    <option value="">Pilih Kelas</option>
                    <option value="X" <?= (isset($_POST['class']) && $_POST['class'] === 'X') ? 'selected' : '' ?>>X</option>
                    <option value="XI" <?= (isset($_POST['class']) && $_POST['class'] === 'XI') ? 'selected' : '' ?>>XI</option>
                    <option value="XII" <?= (isset($_POST['class']) && $_POST['class'] === 'XII') ? 'selected' : '' ?>>XII</option>
                </select>
                <small class="text-danger"><?= $classError ?></small>
            </div>
            <div class="form-group" id="extracurricularSection">
                <label>Ekstrakurikuler:</label><br>
                <input type="checkbox" name="extracurricular[]" value="Pramuka" <?= isset($_POST['extracurricular']) && in_array("Pramuka", $_POST['extracurricular']) ? 'checked' : '' ?>> Pramuka<br>
                <input type="checkbox" name="extracurricular[]" value="Seni Tari" <?= isset($_POST['extracurricular']) && in_array("Seni Tari", $_POST['extracurricular']) ? 'checked' : '' ?>> Seni Tari<br>
                <input type="checkbox" name="extracurricular[]" value="Sinematografi" <?= isset($_POST['extracurricular']) && in_array("Sinematografi", $_POST['extracurricular']) ? 'checked' : '' ?>> Sinematografi<br>
                <input type="checkbox" name="extracurricular[]" value="Basket" <?= isset($_POST['extracurricular']) && in_array("Basket", $_POST['extracurricular']) ? 'checked' : '' ?>> Basket<br>
                <small class="text-danger"><?= $extracurricularError ?></small>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="reset" class="btn btn-danger" id="resetButton">Reset</button>
        </form>

        <div id="resultSection" class="mt-5" style="display: <?= $showResults ? 'block' : 'none' ?>">
            <h3>Hasil Submission:</h3>
            <p><strong>NIS:</strong> <?= $nis ?></p>
            <p><strong>Nama:</strong> <?= $name ?></p>
            <p><strong>Jenis Kelamin:</strong> <?= $gender ?></p>
            <p><strong>Kelas:</strong> <?= $class ?></p>
            <?php if (!empty($extracurricular)): ?>
                <p><strong>Ekstrakurikuler:</strong> <?= implode(", ", $extracurricular) ?></p>
            <?php else: ?>
                <p><strong>Ekstrakurikuler:</strong> Tidak mengikuti ekstrakurikuler</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        const extracurricularSection = document.getElementById("extracurricularSection");
        const classField = document.getElementById("class");
        const resetButton = document.getElementById("resetButton");
        const resultSection = document.getElementById("resultSection");

        function updateExtracurricularSection() {
            const selectedClass = classField.value;
            if (selectedClass === "X" || selectedClass === "XI") {
                extracurricularSection.style.display = 'block';
            } else {
                extracurricularSection.style.display = 'none';
            }
        }

        updateExtracurricularSection();

        classField.addEventListener("change", updateExtracurricularSection);

        resetButton.addEventListener("click", function() {
            resultSection.style.display = 'none';  // Hide the result section on reset
        });
    </script>
</body>
</html>
