<?php 
    session_start();

    // mengembalikan user ke index apabila tidak terdapat session username
    if(!isset($_SESSION['username'])){
        header('location: index.php');
    }

    // logout
    if (isset($_POST['logout'])) {
        unset($_SESSION['username']);
        if (isset($_COOKIE['username'])) {
            setcookie("username", $_POST['username'], time() - 1);
        }
        // mengembalikan ke index
        header("location:index.php");
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>TABEL USER</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">WELCOME <?= $_SESSION['username']; ?></a>
        <ul class="navbar-nav">
        </ul>
    </div>
    </nav>

    <div class="row">
        <div class="col-lg-6 offset-lg-3 mt-3">

            <!-- MEMBUAT TABEL -->
                <table class="table table-striped table-bordered">
                    <tr>
                        <th>Nama</th>
                        <th>Nama Usaha</th>
                        <th>Alamat Usaha</th>
                        <th>Golongan Usaha</th>
                        <th>Modal Usaha</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>No Telepon</th>
                        <th>Email</th>
                    </tr>

                    <!-- Mengeluarkan isi database ke tabel -->
                    <?php
                    include 'koneksi.php';
                    $query = mysqli_query($koneksi,"select * from databaseclient where username = '$_SESSION[username]'; ");
                    while ($item = mysqli_fetch_array($query)) { ?>
                    <tr>
                        <td><?= $item['namaPemilik'];?></td>
                        <td><?= $item['namaUsaha'];?></td>
                        <td><?= $item['alamatUsaha'];?></td>
                        <td><?= $item['golonganUsaha'];?></td>
                        <td><?= $item['modalUsaha'];?></td>
                        <td><?= $item['tempatLahir'];?></td>
                        <td><?= $item['tanggalLahir'];?></td>
                        <td><?= $item['noTelepon'];?></td>
                        <td><?= $item['email'];?></td>
                    </tr>
                    <?php } ?>
                </table>

                <!-- Logout -->
                <form method="POST">
                    <button type="submit" name="logout" class="btn btn-danger">Log Out</button>
                </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  </body>
</html> 