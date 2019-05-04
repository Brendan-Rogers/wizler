<?php

	function createUser($fname, $username, $email) {

		include('connect.php');

		// 1 - random a password, save it for email

		$base_pass = generatePassword(10);


		// 2 - hash the password

		$password = password_hash($base_pass, PASSWORD_BCRYPT);

		// 3 - send hashed password (and other new attributes) to database

		$userstring = "INSERT INTO tbl_users(user_fname,user_name,user_pass,user_email) VALUES(:fname, :username, :password, :email)";
		$create_user_set = $pdo->prepare($userstring);
		$create_user_set->execute(
			array(
				':fname'=>$fname,
				':username'=>$username,
				':password'=>$password,
				':email'=>$email
			)
		);
		


		if($create_user_set) {

			echo 'Youve created a user! Their real password is '.$base_pass.' and their hashed password is '.$password.'<br> Their name is '.$fname.'and their username is '.$username.'<br>If you were to send an email, youd be sending it to '.$email.'<br>Well done!';

			$message = 'Hello '.$fname.' Welcome to Brendan Rogers Online! Youre auto-generated, secure password is <br><b>'.$base_pass.'</b><br> Yours,<br>Brendan.';

			// mail($email, 'Youve been signed up!', $message);

			// redirect_to('admin_index.php');
		}else{
			$message = 'Somehow, some way, youve managed to create an incompatible human. Whoops! <br>USERNAME: '.$username.'<br>PASSWORD: '.$password.'<br>FIRST NAME: '.$fname.'<br>EMAIL: '.$email;
			return $message;
		}
	}

	function editUser($id, $fname, $username, $password, $email) {

		include('connect.php');

		// 1 - Rehash that password

		$newpass = password_hash($password, PASSWORD_BCRYPT);
		
		// 2 - Send new infomation to the database, where session_id = user_id

		$updatestring = "UPDATE tbl_users SET user_fname=:fname, user_name=:username, user_pass=:password, user_email=:email WHERE user_id=:id";

		$updatequery = $pdo->prepare($updatestring);
		$updatequery->execute(
			array(
				':fname'=>$fname,
				':username'=>$username,
				':password'=>$newpass,
				':email'=>$email,
				':id'=>$id
			)
		);

		// If the edit is successful, return to index

		if($updatequery) {
			redirect_to("admin_index.php");
		}else{
			$message = 'ERROR REPORT...<br>'.$id.'<br>'.$fname.'<br>'.$username.'<br>'.$password.'<br>'.$email.'<br>';
			return $message;
		}

	}







	

?>