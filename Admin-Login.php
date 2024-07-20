<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$Password = $_POST['txtPassword'];

	if($Password == "SuperAdmin"){
		$_SESSION['user'] = "SuperAdmin";
		header("Location: Admin.php");
	}
}

 
?>
<!DOCTYPE html>
<html>
<head>
	<title> Login </title>
	<link rel="stylesheet" href="style.css" >
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</head>
<body class="login-box">
	<h1>Admin - LOGIN</h1>
	<form action="" method="POST" class="login-form">
	<ul class="form-list">
	<li>
		<div class="label-block"> <label for="login:password">Password</label> </div>
		<div class="input-box"> <input type="password" id="login:password" name="txtPassword" placeholder="Password" /> </div>
	</li>
	<li>
		<input type="submit" value="Login" class="submit_button" />
	</li>
	</ul>
	</form>
</body>
</html>