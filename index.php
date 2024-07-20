<?php
include('config.php');

session_start();
$reqErr = $loginErr = "";

///----------Customer--------------

function cusdata($name,$pass) {
    //$url = SUPABASE_URL . "/rest/v1/Customer";
    $url = SUPABASE_URL . "/rest/v1/Customer?name=eq.".($name);

    $options = [
        'http' => [
            'header' => "apikey: " . SUPABASE_API_KEY . "\r\n",
            'method' => 'GET',
        ],
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result === FALSE) {
        die('Error retrieving data');
    }else{
        $_SESSION['username'] = $name;
        header('Location: Customer.php');
    }
    


            

}

///--------------- calling down -----------------


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if(!empty($_POST['txtUsername']) && !empty($_POST['txtPassword'])) {
        //session_start();
        $username = $_POST['txtUsername'];
        $password = $_POST['txtPassword'];
        cusdata($username,$password);
    } else {
        $reqErr = "* All fields are required.";
    }
}
?>


<!-- Your HTML code here -->
 
<!DOCTYPE html>
<html>
<head>
	<title> Login </title>
	<link rel="stylesheet" href="style.css" >
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</head>
<body class="login-box">
	<h1>LOGIN</h1>
	<form action="" method="POST" class="login-form">
	<ul class="form-list">
	<li>
		<div class="label-block"> <label for="login:username">Username</label> </div>
		<div class="input-box"> <input type="text" id="login:username" name="txtUsername" placeholder="Username" /> </div>
	</li>
	<li>
		<div class="label-block"> <label for="login:password">Password</label> </div>
		<div class="input-box"> <input type="password" id="login:password" name="txtPassword" placeholder="Password" /> </div>
	</li>
	<li>
		<input type="submit" value="Login" class="submit_button btn btn-primary" /> <span class="error_message"> <?php echo $loginErr; echo $reqErr; ?> </span>
	</li>
    </ul>
    </form>	
    <div class="container my-3 mb-3">
    <a href="NewAc.php"><Button class="btn btn-primary"> Create New Account </Button></a> <a href="Customer.php"><Button Class="btn btn-success"> Continue as guest </Button></a>
    </div>
    
</body>
</html>