<?php
session_start();

// set session dan menghapus session username apabila ada
if (isset($_SESSION['username'])) {
	unset($_SESSION['username']);
}

// connect ke mySQL
include "koneksi.php";

// buat variable
$announcement = "";
$usernameLogin = "";
$passwordLogin = "";

// check username & password match
if (isset($_POST['login'])){
	$query = mysqli_query($koneksi,"SELECT * FROM databaseclient WHERE username = '$_POST[username]'");
	$fetchArray = mysqli_fetch_array($query);

	// apabila username yang diinput tidak ada di database
	if (!isset($fetchArray['username'])) {
		$announcement = "Username tidak tersedia";
	}

	// apabila username tersedia tapi password tidak sesuai
	elseif($fetchArray['password'] != md5($_POST['password'])){
		$announcement = "Password tidak match dengan username";
	}

	// apabila username dan password tersedia dan sesuai
	else{
		$announcement = "";
	}

	// set session dan masuk ke tabel data user
	if ($announcement == "") {
		$_SESSION['username'] = $_POST['username'];

		// set cookies / remember me
		if (isset($_POST['remember'])) {
			setcookie("username", $_POST['username'], time() + (60*60*24));
		}

		// menuju tabel
		header("location:page.php");
	}
}

// auto login apabila sudah ada cookies
if (isset($_COOKIE['username'])) {
	$_SESSION['username'] = $_COOKIE['username'];
	header("location:page.php");
}

// Menuju sign up
if (isset($_POST['signup'])) {
	header("location:signup.php");
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
	<center>
	<div>
		<h1 style="text-align: center;">LOGIN PANRB</h1>
		<form method="POST">
		<div class="mb-3">
			<label class="form-label">Username</label>
			<input type="text" class="w-25 form-control" name="username" required>
		</div>
		<div class="mb-3">
			<label class="form-label">Password</label>
			<input type="password" class="w-25 form-control" name="password" required>
		</div>
		<div class="mb-3 form-check">
			<input type="checkbox" name="remember">
			<label class="form-label">Remember Me</label>
		</div>
		<button type="submit" name="login" class="btn btn-success">Log In</button>	
		</form>
		<form method="POST" action="">
			<button type="submit" name="signup" class="btn btn-warning">Sign Up</button>
		</form>
		<a style="text-align: center; color: red;"><?= $announcement; ?></a>
	</div>
	</center>
</body>
</html>