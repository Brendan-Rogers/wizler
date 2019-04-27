<?php

	function logIn($username, $password, $ip) {

		require_once('connect.php');

		// get the amount of times the user has failed to login
		$check_legit_query = "SELECT user_failed, user_suspended FROM tbl_users WHERE user_name=:username";
		$user_legit = $pdo->prepare($check_legit_query);
		$user_legit->execute(
			array(
				':username'=>$username
			)
		);
		// if that number is more the THREE - boot them from the script
		while ($verifyuser = $user_legit->fetch(PDO::FETCH_ASSOC)) {
			if ($verifyuser['user_failed'] > 2) {
				return "Sorry, you've failed the login at least 3 times, so we've had to lockout your account. This is due to top secret information, such as DATE, TIME, and LAST SUCEESSFUL LOGIN being associated with this secure account. Contact the webmaster at webmaster@loginsystem.org to release your account.";
				exit;
			} // if user is suspended, boot the script
			if ($verifyuser['user_suspended'] > 0) {
				return "Sorry, your account has been suspended. Contact the webmaster at webmaster@loginsystem.org to release your account.";
				exit;
			}
		}


		// get the hashed password from the database
		$get_hashed_query = "SELECT user_pass FROM tbl_users WHERE user_name=:username";
		$hashed = $pdo->prepare($get_hashed_query);
		$hashed->execute(
			array(
				':username'=>$username
			)
		);
		while ($hashcheck = $hashed->fetch(PDO::FETCH_ASSOC)) {
			$value = $hashcheck['user_pass'];
		}		

		// only do ANYTHING is the $hashed (on the server) authenticates with the $password (provided by user)

		if (password_verify($password, $value)) {

			// query for the user (not a count)
			$get_user_query = 'SELECT * FROM tbl_users WHERE user_name=:username';
			$user_set = $pdo->prepare($get_user_query);
			$user_set->execute(
				array(
					':username'=>$username
				)
			);

			// scoped variable for new user check
			$newuser = '';
			// scoped variable for deadline check
			$time_since = '';
			// the DEADLINE for login after initial creation, in seconds. currently one day
			// make a much small number for testing
			$deadline = 86400;

			while($founduser = $user_set->fetch(PDO::FETCH_ASSOC)){
				// founduser is each matching user in the tbl_user
				$id = $founduser['user_id'];
				// set temporary session globalvariables, using the found user
				$_SESSION['user_id'] = $id;
				$_SESSION['user_name']= $founduser['user_fname'];

				// 1 - Administrator
				// 2 - Moderator
				$_SESSION['user_mod'] = $founduser['user_mod'];

				// 1 - user is new
				// 0 - user is returning
				$newuser = $founduser['user_new'];
				$time_since = mktime() - strtotime($founduser['user_date']);

				if (empty($id)) {
					echo 'login failed... This user has no ID';
				}

				$update_time = date('Y/m/d');
				// only update latest login now that the old one's been passed to session memory
				$update = "UPDATE tbl_users SET user_ip='{$ip}' WHERE user_id={$id}";
				$latest = "UPDATE tbl_users SET user_lastlogin='{$update_time}' WHERE user_id={$id}";

				$updateIP = $pdo->query($update);
				$updateDate = $pdo->query($latest);
			}

			// send user to INDEX if they're returning
			// send user to EDITUSER if they're new
			if ($newuser == 1) {

				// 1 - terminate login if deadline is past
				if ($time_since > $deadline) {
					echo 'You didnt log in after you were created, so we had to lock you out! Contact your webmaster to get this fixed.';
					exit;
				}

				// // 2 - decrement user_new to false
				$update = "UPDATE tbl_users SET user_new = 0 WHERE user_name=:username";
				$decrement_new = $pdo->prepare($update);
				$decrement_new->execute(
					array(
						':username'=>$username
					)
				);

				// // 3 - send them to edit user page
				redirect_to("admin_edituser.php");

			} else {
				// they're old, send to index
				redirect_to("admin_index.php");
			}

		}else{
			// they have failed to use the correct password: if there's a matching username, log a strike against them
			$update = "UPDATE tbl_users SET user_failed = user_failed + 1 WHERE user_name=:username";
			$increment_failed = $pdo->prepare($update);
			$increment_failed->execute(
				array(
					':username'=>$username
				)
			);
			echo "Please try again!";
		}
	}

?>