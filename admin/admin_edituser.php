<?php
	require_once('scripts/config.php');
	
	confirm_admin();

	$id = $_SESSION['user_id'];
	$tbl = "tbl_users";
	$col = "user_id";

	$found_user_set = getSingle($tbl, $col, $id);

	if(is_string($pop_form)){
		$message = 'Failed to get user info!';
	}

	if(isset($_POST['submit'])){
		$fname = trim($_POST['fname']);
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		$email = trim($_POST['email']);

		if (empty($username) || empty($password) || empty($email)) {
			$message = 'please fill out the entire form';
		} else {
			$result = editUser($id, $fname, $username, $password, $email);
			$message = $result;
		}


		
	}

	$pop_form = $found_user_set->fetch(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Edit User</title>
</head>

<body>
	<h2>Edit User</h2>

	<?php if(!empty($message)){echo $message;} ?>

	<form action="admin_edituser.php" method="post">

		<label>First Name:</label>
		<input type="text" name="fname" value="<?php echo $pop_form['user_fname']; ?>"><br><br>
		<label>Username:</label>
		<input type="text" name="username" value="<?php echo $pop_form['user_name']; ?>"><br><br>
		<label>Password:</label>
		<input type="text" name="password" value="secret..."><br><br>
		<label>Email:</label>
		<input type="text" name="email" value="<?php echo $pop_form['user_email']; ?>"><br><br>

		<button type="submit" name="submit">Edit Account</button>
	</form>
</body>

</html>