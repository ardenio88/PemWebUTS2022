<?php
    include "koneksi.php";
    // Menjalankan ketika memencet submit button
    if(isset($_POST['submit'])) {
        // Check apakah sudah mengisi recaptcha
        if($_POST['g-recaptcha-response'] == ''){
            // Mengembalikan GET Announcement/warning untuk ditampilkan
            header("location:signup.php?announcement=Mohon isi Recaptcha");            
        }
        // Membuat variable file KTP
        $target_dirKTP = "uploads/fileKTP/";
        $target_fileKTP = $target_dirKTP . basename($_FILES["fotoKTP"]["name"]);
        $uploadOKKTP = 1;
        $imageFileTypeKTP = strtolower(pathinfo($target_fileKTP,PATHINFO_EXTENSION));
        // Check file KTP merupakan gambar atau bukan
        if(isset($_POST["submit"])) {
          $check = getimagesize($_FILES["fotoKTP"]["tmp_name"]);
          if($check !== false) {
            $uploadOKKTP = 1;
          }
        // Mengembalikan GET Announcement/warning untuk ditampilkan
          else {
            header("location:signup.php?announcement='File KTP bukan gambar'");
            $uploadOKKTP = 0;
          }
        }
        // Check filetype file KTP
        if($imageFileTypeKTP != "jpg" && $imageFileTypeKTP != "png") {
            // Mengembalikan GET Announcement/warning untuk ditampilkan
            header("location:signup.php?announcement='File type KTP salah'");
            $uploadOKKTP = 0;
        }
        // Upload file KTP
        if ($uploadOKKTP = 1){
          if (move_uploaded_file($_FILES["fotoKTP"]["tmp_name"], $target_fileKTP)) {
            $_SESSION['namafileKTP'] = htmlspecialchars( basename( $_FILES["fotoKTP"]["name"]));
          }
         }
        // Membuat Variable file NPWP 
        $target_dirNPWP = "uploads/fileNPWP/";
        $target_fileNPWP = $target_dirNPWP . basename($_FILES["fotoNPWP"]["name"]);
        $uploadOKNPWP = 1;
        $imageFileTypeNPWP = strtolower(pathinfo($target_fileNPWP,PATHINFO_EXTENSION));
        // Check file NPWP merupakan gambar atau bukan
        if(isset($_POST["submit"])) {
          $check = getimagesize($_FILES["fotoNPWP"]["tmp_name"]);
          if($check !== false) {
            $uploadOKNPWP = 1;
          } 
        // Mengembalikan GET Announcement/warning untuk ditampilkan
          else {
            header("location:signup.php?announcement='File NPWP bukan gambar'");
            $uploadOKNPWP = 0;
          }
        }
        // Check filetype file NPWP
        if($imageFileTypeNPWP != "jpg" && $imageFileTypeNPWP != "png" ) {
            // Mengembalikan GET Announcement/warning untuk ditampilkan
            header("location:signup.php?announcement='File type NPWP bukan JPG/PNG'");
            $uploadOKNPWP = 0;
        }
        // Upload file NPWP

        if ($uploadOKNPWP = 1){
          if (move_uploaded_file($_FILES["fotoNPWP"]["tmp_name"], $target_fileNPWP)) {
            $_SESSION['namafileNPWP'] = htmlspecialchars( basename( $_FILES["fotoNPWP"]["name"]));
          }
         }
        // Check syarat password 
        $passValid = 1;

        // Check syarat > 8
        if(strlen($_POST['password']) < 8){
            header("location:signup.php?announcement='Password kurang dari 8 karakter'");
            $passValid = 0;
        }

        // Check syarat angka
        if (preg_match('`[0-9]`',$_POST['password'])) {}
        else{
            header("location:signup.php?announcement='Password tidak mengandung angka'");
            $passValid = 0;
        }

        // Check syarat huruf kapital
        if (preg_match('`[A-Z]`',$_POST['password'])) {}
        else{
            header("location:signup.php?announcement='Password tidak mengandung huruf kapital'");
            $passValid = 0;
        }

        // Check syarat huruf lowercase
        if (preg_match('`[a-z]`',$_POST['password'])) {}
        else{
            header("location:signup.php?announcement='Password tidak mengandung lowercase'");
            $passValid = 0;
        }

        // Check apakah repassword / verifpassword sesuai
        if ($_POST['password'] != $_POST['repassword']) {
            // Mengembalikan GET Announcement/warning untuk ditampilkan
            header("location:signup.php?announcement='Verif Password Salah'");

        }

        // Check apakah input tanggal lahir lebih dari hari ini
        $date_now = date("Y-m-d"); 

        if ($date_now < $_POST['tglLahir']) {
            // Mengembalikan GET Announcement/warning untuk ditampilkan
            header("location:signup.php?announcement='Tanggal lahir lebih dari hari ini!'");
        }

        // Variable modal usaha
        $modalUsahaArr = $_POST['modalUsaha'];
        if (isset($modalUsahaArr)) {
            // Menghitung jumlah modal usaha
            $jumlahModal = count($modalUsahaArr);
            // Apabila modal usaha lebih dari 1
            if ($jumlahModal > 1) {
                $modalUsahaInput = implode(",",$modalUsahaArr);
            }
            else{
                $modalUsahaInput = $modalUsahaArr[0];
            }
        }
        // Mengembalikan GET Announcement/warning untuk ditampilkan
        else{
            header("location:signup.php?announcement='Mohon pilih modal usaha!'");
        }

        // Username Valid
        $usernameValid = 1;
        $queryUname = mysqli_query($koneksi,"SELECT username FROM databaseclient WHERE username = '$_POST[username]'");
        $fetchArray = mysqli_fetch_array($queryUname);
        if (isset($fetchArray['username'])) {
            // Menembalikan GET Announcement/warning untuk ditampilkan
            $usernameValid = 0;
            header("location:signup.php?announcement='Username sudah ada!'");
        }
        // Menjalankan code untuk upload ke database apabila file KTP & NPWP sesuai, repassword sesuai, sudah mengisi recaptcha, tanggal lahir valid, dan sudah mengisi modal usaha
        if ($uploadOKKTP == 1 && $uploadOKNPWP == 1 && $_POST['password'] == $_POST['repassword'] && null !== isset($_POST['g-recaptcha-response']) && $passValid == 1 && $date_now > $_POST['tglLahir'] && isset($modalUsahaArr)) {
            // Membuat variable untuk dimasukkan value yang akan diinput ke Database
            $username = $_POST['username'];
            $password = md5($_POST['password']);
            $nama_usaha = $_POST['namaUsaha'];
            $alamat = $_POST['alamat'];
            $golongan_usaha = $_POST['golonganUsaha'];
            $modal_usaha = $modalUsahaInput;
            $nama_pemilik = $_POST['namaPemilik'];
            $tempat_lahir = $_POST['tempatLahir'];
            $tanggal_lahir = $_POST['tglLahir'];
            $no_telepon = $_POST['telepon'];
            $email = $_POST['email'];
            $ktp = $_SESSION['namafileKTP'];
            $npwp = $_SESSION['namafileNPWP'];

            // Memasukkan variable diatas kedalam database
            $query = "INSERT INTO `databaseclient` (`username`, `password`, `namaUsaha`, `alamatUsaha`, `golonganUsaha`, `modalUsaha`, `namaPemilik`, `tempatLahir`, `tanggalLahir`, `noTelepon`, `email`, `fileKTP`, `fileNPWP`) VALUES ('". $username ."', '". $password ."', '". $nama_usaha ."', '". $alamat ."', '". $golongan_usaha ."', '". $modal_usaha ."', '". $nama_pemilik ."', '". $tempat_lahir ."', '". $tanggal_lahir ."', '". $no_telepon ."', '". $email."', '". $ktp ."', '". $npwp ."')";
            $koneksi->query($query);
            // Me-reset Announcement/warning apabila ada
            if (isset($_GET['announcement'])) {
                $_GET['announcement'] = "";
            }
            // Menampilkan Alert ketika berhasil register
            ?>
            <script type="text/javascript">alert("REGISTER BERHASIL")</script>
            <?php
        }else{
            // Mengembalikan GET Announcement/warning untuk ditampilkan
            $_GET['announcement'] = "GAGAL REGISTER";
        }
    }
?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Captcha JS -->
     <script src='https://www.google.com/recaptcha/api.js' async defer></script>
    <title>Daftar</title>
  </head>
  <body>
  <div class="container-md">
      <h1 style="text-align: center;">DAFTAR PANRB</h1>
      <h7 style="text-align: center; color: red;"><?php if(isset($_GET['announcement'])){ echo $_GET['announcement'];}?></h7>
      <!-- Membuat form signup -->
    <form method="POST" action="" class="row g-3" enctype="multipart/form-data">
    <div class="col-12">
        <label for="inputEmail4" class="form-label">Username</label>
        <input type="text" name="username" class="form-control" >
    </div>
    <div class="col-md-6">
        <label for="inputPassword4" class="form-label">Password</label>
        <input type="password" name="password" class="form-control" >
    </div>
    <div class="col-md-6">
        <label for="input_password" class="form-label">Ulangi Password</label>
        <input type="password" name="repassword" class="form-control" >
    </div>
    <div class="col-12">
        <label for="inputEmail4" class="form-label">Nama Pemilik</label>
        <input type="text" name="namaPemilik" class="form-control" >
    </div>    
    <div class="col-12">
        <label for="namaLengkap" class="form-label">Nama Usaha</label>
        <input type="text" name="namaUsaha" class="form-control" >
    </div>
    <div class="col-md-6">
        <label for="inputCity" class="form-label">Tempat Lahir</label>
        <input type="text" name="tempatLahir" class="form-control" required>
    </div>
    <div class="col-md-6">
        <label for="date" class="form-label">Tanggal Lahir</label>
        <input type="date" name="tglLahir" class="form-control" required>
    </div>
    <label class="form-label col-md-6">Modal Usaha</label>
    <label for="golonganUsaha" class="form-label col-md-6">Golongan Usaha</label>
    <div class="col-md-6">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name= "modalUsaha[]" id="modalUsaha1" value="Bank">
            <label class="form-check-label" for="modalUsaha1">Bank</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name ="modalUsaha[]" id="modalUsaha2" value="Koperasi">
            <label class="form-check-label" for="modalUsaha2">Koperasi</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="modalUsaha[]" id="modalUsaha3" value="Bantuan Sosial" >
            <label class="form-check-label" for="modalUsaha3">Bantuan Sosial</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="modalUsaha[]" id="modalUsaha4" value="Lainnya" >
            <label class="form-check-label" for="modalUsaha4">Lainnya</label>
        </div>
    </div>
    <div class="btn-group col-md-6" role="group" aria-label="Basic radio toggle button group">
        <input type="radio" class="btn-check" name="golonganUsaha" value="mikro" id="btnradio1" autocomplete="off" checked>
        <label class="btn btn-outline-primary" for="btnradio1">Mikro</label>

        <input type="radio" class="btn-check" name="golonganUsaha" value="kecil" id="btnradio2" autocomplete="off" >
        <label class="btn btn-outline-primary" for="btnradio2">Kecil</label>

        <input type="radio" class="btn-check" name="golonganUsaha" value="menengah" id="btnradio3" autocomplete="off" >
        <label class="btn btn-outline-primary" for="btnradio3">Menengah</label>
    </div>
    <div class="col-12">
        <label for="alamat" class="form-label">Alamat Usaha</label>
        <input type="textarea" name="alamat" class="form-control" id="inputCity" required>
    </div>
    <div class="col-md-6">
        <label for="telepon" class="form-label">No Telepon</label>
        <input type="textarea" name="telepon" class="form-control" id="telepon" required>
    </div>
    <div class="col-md-6">
        <label for="inputEmail4" class="form-label">Email</label>
        <input type="text" name="email" class="form-control" id="inputEmail4" required>
    </div>
    <div class="col-md-6">
        <label for="formFile1" class="form-label">Foto KTP</label>
        <input class="form-control" name="fotoKTP" type="file" id="formFile1" required>
    </div>
    <div class="col-md-6">
        <label for="formFile2" class="form-label">Foto NPWP</label>
        <input class="form-control" name="fotoNPWP" type="file" id="formFile2" required>
    </div>
    <!-- Recaptcha -->
    <div class="mb-3 g-recaptcha" data-sitekey="6Lfo3KoiAAAAAMYyyIYcxOKP_Bj5SBYlB5rhXGlo"></div>     
    <div class="col-12">
        <div class="form-check">
            <!-- Wajib Setuju terms / perjanjian di awal -->
            <input class="form-check-input is-invalid" type="checkbox" value="" id="invalidCheck3" aria-describedby="invalidCheck3Feedback" required>
            <label class="form-check-label" for="invalidCheck3">
                Agree to terms and conditions
            </label>
            <div id="invalidCheck3Feedback" class="invalid-feedback">
                You must agree before submitting.
            </div>
        </div>
    </div>
    <!-- Signup -->
    <div class="col-12">
        <button type="submit" name="submit" class="btn btn-primary">Sign up</button>
    </form>
    <!-- Home -->
    <a href="index.php"><button type="button" name="goToIndex" class="btn btn-success">Home</button></a> 
    </div>
  </div>  
  </body>
</html>