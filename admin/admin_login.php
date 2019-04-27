<?php
	require_once('scripts/config.php');
	$ip = $_SERVER['REMOTE_ADDR'];
	//echo $ip;
	if(isset($_POST['submit'])){
		//echo "Works";
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		if($username !== "" && $password !== ""){
			$result = logIn($username, $password, $ip);
			$message = $result;
		}else{
			$message = "Please fill out the required fields.";
		}
	}
?>
<!doctype html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta charset="UTF-8">
	<title>ADMIN PANEL LOGIN</title>
    <link rel="stylesheet" href="../css/master.css">
</head>

<body class="adminBody">
	<?php if(!empty($message)){ echo $message;} ?>

	<a href="../index.html" class="siteLink"><h2 class="siteTitle">ODP</h2></a>

	<div class="adminLog">
	
		<h2 class="adminTitle">ENTER YOUR LOGIN INFORMATION BELOW:</h2>

		<form action="admin_login.php" method="post" class="adminForm">
			<label>Username:</label>
			<input type="text" name="username" value="">
			<br>
			<label>Password:</label>
			<input type="password" name="password" value="">
			<br><br>
			<input type="submit" name="submit" value="Login">
		</form>
	</div>

</body>

</html>