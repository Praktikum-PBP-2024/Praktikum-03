<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <title>Praktikum PBP D2 | Pertemuan 3</title>

  <!--
    Penjelasan:
    Setelah semua selesai, isi form yang sebelumnya
    sudah ditampilkan dengan benar.
  -->

</head>
<body class="container">
<?php 
  $nis = $nama = $gender = $kelas = "";
  $ekstrakurikuler = [];

  if(isset($_POST['submit'])){
    // validasi nama: tidak boleh kosong, hanya dapat berisi huruf dan spasi
    $nis = test_input($_POST['nis']);
    if (empty($nis)) {
      $error_nis = "NIS harus diisi";
    } elseif (!preg_match("/^[0-9]{10}$/", $_POST["nis"])) {
      $error_nis = "NIS harus angka sepanjang 10 karakter";
    }

    // validasi email: tidak boleh kosong, format harus benar
    $nama = test_input($_POST['nama']);
    if (empty($nis)) {
      $error_nama = "Nama harus diisi";
    }

    // validasi jenis kelamin: tidak boleh kosong
    $jenis_kelamin = isset($_POST['jenis_kelamin']) ? $_POST['jenis_kelamin']: [];
    if ($jenis_kelamin == "") {
      $error_jenis_kelamin = "Jenis kelamin harus diisi";
    }

    // validasi kota: tidak boleh kosong
    $kelas = $_POST['kelas'];
    if ($kelas == "") {
      $error_kota = "Kelas harus dipilih";
    }

    // validasi minat: tidak boleh kosong
    $ekstrakurikuler = isset($_POST['ekstrakurikuler']) ? $_POST['ekstrakurikuler'] : [];
    if (empty($ekstrakurikuler)) {
      $error_minat = "Ekstrakulikuler harus dipilih";
    } elseif (count($ekstrakurikuler) > 3){
      $error_minat = "Ekstrakulikuler maksimal dipilih tiga";
    }
  }

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>

  <div class="card">
    <div class="card-header">Form Input Siswa</div>
    <div class="card-body">
      <form action="" method="POST" class="">
      <div class="form-group">
          <label for="nis">NIS:</label>
          <input type="text" class="form-control" id="nis" name="nis" value="<?php if(isset($nis)) echo $nis;?>">
          <div class="error text-danger"><?php if(isset($error_nis)) echo $error_nis;?></div>
        </div>
        <div class="form-group">
          <label for="nama">Nama:</label>
          <input type="text" class="form-control" id="nama" name="nama" maxlength="50" value="<?php if(isset($nama)) echo $nama;?>">
          <div class="error text-danger"><?php if(isset($error_nama)) echo $error_nama;?></div>
        </div>
        <label>Jenis Kelamin:</label>
        <div class="form-check">
          <label class="form-check-label">
            <input type="radio" class="form-check-input" id = "jenis_kelamin" name="jenis_kelamin" value="pria" <?php if(isset($jenis_kelamin) && $jenis_kelamin == "pria") echo "checked" ?> >Pria 
          </label>
        </div>
        <div class="form-check">
          <label class="form-check-label">
            <input type="radio" class="form-check-input" id = "jenis_kelamin" name="jenis_kelamin" value="wanita" <?php if(isset($jenis_kelamin) && $jenis_kelamin == "wanita") echo "checked" ?>>Wanita 
          </label>
        </div>
        <div class="error text-danger"><?php if(isset($error_jenis_kelamin)) echo $error_jenis_kelamin;?></div>
        <br>
        <div class="form-group">
          <label for="kelas">Kelas:</label>
          <select name="kelas" id="kelas" class="form-control">
            <option value="" <?php if ((isset($kelas)) && $kelas=="") echo 'selected="true"';?>>Pilih Kelas </option>
            <option value="x" <?php if ((isset($kelas)) && $kelas=="x") echo 'selected="true"';?> >X</option>
            <option value="xi" <?php if ((isset($kelas)) && $kelas=="xi") echo 'selected="true"';?> >XI</option>
            <option value="xii" <?php if ((isset($kelas)) && $kelas=="xii") echo 'selected="true"';?> >XII</option>
          </select>
          <div class="error text-danger"><?php if(isset($error_kota)) echo $error_kota;?></div></br>
        
        <div class="form-check" id='ekstrakurikulerSection' id="ekstrakurikulerSection" <?php if ($kelas === 'xii') echo 'style="display:none;"';?>>
        <label>Ekstrakulikuler: </label></br>
          <input type="checkbox" name="ekstrakurikuler[]" value="Pramuka" <?php if (in_array('Pramuka', $ekstrakurikuler)) echo "checked"; ?>> Pramuka<br>
          <input type="checkbox" name="ekstrakurikuler[]" value="Seni Tari" <?php if (in_array('Seni Tari', $ekstrakurikuler)) echo "checked"; ?>> Seni Tari<br>
          <input type="checkbox" name="ekstrakurikuler[]" value="Sinematografi" <?php if (in_array('Sinematografi', $ekstrakurikuler)) echo "checked"; ?>> Sinematografi<br>
          <input type="checkbox" name="ekstrakurikuler[]" value="Basket" <?php if (in_array('Basket', $ekstrakurikuler)) echo "checked"; ?>> Basket<br>
        </div>
        <div class="error text-danger"><?php if(isset($error_minat)) echo $error_minat;?></div>
        <br>
        <!-- submit, reset dan button -->
        <button type="submit" class="btn btn-primary" name="submit" value="submit">Submit</button>
        <button type="reset" class="btn btn-danger" value="reset">Reset</button>
      </form>
    </div>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  <script>
    const kelasSelect = document.getElementById('kelas');
    const ekstrakurikulerSection = document.getElementById('ekstrakurikulerSection');

    kelasSelect.addEventListener('change', function() {
      if (kelasSelect.value === 'x' || kelasSelect.value === 'xi') {
        ekstrakurikulerSection.style.display = 'block';
      } else {
        ekstrakurikulerSection.style.display = 'none';
      }
    });
  </script>
</body>
</html>
