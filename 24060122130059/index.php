<!-- 
  File      : index.php   18/09/24
  Penulis   : Arifin Nurmuhammad Haris
  Deskripsi : Form Input Siswa
-->

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- cdn bootstrap  -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<title>Form Input Siswa</title>
	<style>
		.error {
			color: #FF0000;
		}
	</style>
</head>

<body>
	<?php
	if (isset($_POST['submit'])) {
		$nama = test_input($_POST['nama']);
		if (empty($nama)) {
			$error_nama = "Nama harus diisi";
		} elseif (!preg_match("/^[a-zA-Z ]*$/", $nama)) {
			$error_nama = "Nama hanya dapat berisi huruf dan spasi";
		}

		$nis = test_input($_POST['nis']);
		if (empty($nis)) {
			$error_nis = "NIS harus diisi";
		} elseif (!preg_match('/^[0-9]{10}$/', $nis)) {
			$error_nis = "Format NIS salah";
		}

		$kelas = test_input($_POST['kelas']);
		if (empty($kelas)) {
			$error_kelas = "Kelas harus diisi";
		}
		if (!isset($_POST['jenis_kelamin'])) {
			$error_jenis_kelamin = "Jenis kelamin harus diisi";
		}
		if ($kelas != 'XII') {
			// Jika kelas X atau XI, validasi ekstrakurikuler
			if (!isset($_POST['ekskul']) || count($_POST['ekskul']) < 1 || count($_POST['ekskul']) > 3) {
				$error_ekskul = "Pilih 1-3 ekstrakurikuler";
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

	<div class="card m-5">
		<div class="card-header">
			Form Input Siswa
		</div>
		<form action="" autocomplete="on" method="POST" class="m-4">

			<div class="form-group">
				<label for="nis">NIS:</label>
				<input type="number" name="nis" id="nis" class="form-control" minlength="10" maxlength="10" value="<?php if (isset($nis)) echo $nis ?>">
				<div class="error"><?php if (isset($error_nis)) echo $error_nis ?></div>
			</div>

			<div class="form-group">
				<label for="nama">Nama:</label>
				<input type="text" name="nama" id="nama" class="form-control" maxlength="50" value="<?php if (isset($nama)) echo $nama ?>">
				<div class="error"> <?php if (isset($error_nama)) echo $error_nama ?></div>
			</div>

			<label>Jenis Kelamin</label>
			<div class="form-check">
				<label class="form-check-label">
					<input type="radio" class="form-check-input" name="jenis_kelamin" value="pria" <?php if (isset($jenis_kelamin) && $jenis_kelamin == "pria") echo "checked" ?>>Pria
				</label>
			</div>
			<div class="form-check">
				<label class="form-check-label">
					<input type="radio" class="form-check-input" name="jenis_kelamin" value="wanita" <?php if (isset($jenis_kelamin) && $jenis_kelamin == "wanita") echo "checked" ?>>Wanita
				</label>
			</div>
			<div class="error"><?php if (isset($error_jenis_kelamin)) echo $error_jenis_kelamin ?></div>

			<div class="form-group">
				<label for="kelas">Kelas</label>
				<select name="kelas" id="kelas" class="form-control" onchange="toggleEkstrakurikuler()">
					<option value="X" <?php if (isset($kelas) && $kelas == "X") echo 'selected="true"' ?>>X</option>
					<option value="XI" <?php if (isset($kelas) && $kelas == "XI") echo 'selected="true"' ?>>XI</option>
					<option value="XII" <?php if (isset($kelas) && $kelas == "XII") echo 'selected="true"' ?>>XII
					</option>
				</select>
				<div class="error"><?php if (isset($error_kelas)) echo $error_kelas ?></div>
			</div>

			<div id="ekstrakurikuler">
				<label>Ekstrakurikuler</label>
				<div class="form-check">
					<label class="form-check-label">
						<input type="checkbox" class="form-check-input" name="ekskul[]" value="Pramuka">Pramuka
					</label>
				</div>

				<div class="form-check">
					<label class="form-check-label">
						<input type="checkbox" class="form-check-input" name="ekskul[]" value="Seni Tari">Seni Tari
					</label>
				</div>

				<div class="form-check">
					<label class="form-check-label">
						<input type="checkbox" class="form-check-input" name="ekskul[]"
							value="Sinematografi">Sinematografi
					</label>
				</div>

				<div class="form-check">
					<label class="form-check-label">
						<input type="checkbox" class="form-check-input" name="ekskul[]" value="Basket">Basket
					</label>
					<div class="error">
						<?php if (isset($error_ekskul)) echo $error_ekskul ?>
					</div>
				</div>
			</div>

			<br>
			<!-- submit, reset dan button -->
			<button type="submit" class="btn btn-primary" name="submit" value="submit">Submit</button>
			<button type="reset" class="btn btn-danger">Reset</button>
		</form>
	</div>

	<?php
	if (isset($_POST["submit"])) {
		echo "<h3>Your Input</h3>";
		echo "NIS: " . $_POST["nis"] . "<br/>";
		echo "Nama: " . $_POST["nama"] . "<br/>";
		if (!isset($_POST["jenis_kelamin"])) {
			echo "Jenis kelamin belum dipilih<br/>";
		} else {
			echo "Jenis kelamin: " . $_POST["jenis_kelamin"] . "<br/>";
		}
		echo "Kelas: " . $_POST["kelas"] . "<br/>";

		if ($kelas != 'XII') {
			// Jika kelas X atau XI, tampilkan ekstrakurikuler yang dipilih
			if (!isset($_POST['ekskul']) || count($_POST['ekskul']) < 1 || count($_POST['ekskul']) > 3) {
				echo "Ekstrakurikuler belum dipilih";
			} else {
				echo "Ekstrakurikuler: ";
				foreach ($_POST['ekskul'] as $ekskul) {
					echo $ekskul . ", ";
				}
			}
		}
	}
	?>

	<script>
		function toggleEkstrakurikuler() {
			var kelasSelect = document.getElementById("kelas");
			var ekstrakurikulerDiv = document.getElementById("ekstrakurikuler");

			if (kelasSelect.value == "XII") {
				ekstrakurikulerDiv.style.display = "none";
			} else {
				ekstrakurikulerDiv.style.display = "block";
			}
		}
	</script>
</body>

</html>
