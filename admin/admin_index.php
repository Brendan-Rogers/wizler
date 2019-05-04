<?php
	ini_set('display_errors',1);
	error_reporting(E_ALL);
	
	include('scripts/config.php');
	confirm_logged_in();

	$display = get_images(0);
?>

<!doctype html>
<html>

<head>
	<meta charset="UTF-8">
	<title>ADMINISTRATOR PANEL</title>
	<link rel="stylesheet" href="../css/master.css">
</head>

<body>
<main>
		
<h2 class="titleSmall" style="margin-top: 1em; margin-left: 1em;"> MOD PANEL </h2>

<div class="imgSect">

	<?php while ($row = $display->fetch(PDO::FETCH_ASSOC)): ?>

	<?php 
		$mod_approve = explode(",", $row['mod_approve']);
		$mod_decline = explode(",", $row['mod_decline']);

		// only display image if user hasn't approved or declined it
		if (!in_array($_SESSION['user_id'], $mod_approve) && !in_array($_SESSION['user_id'], $mod_decline)):
	 ?>

	<div class="orgPoster">
		<img src="../images/user_images/<?php echo $row['file_name']; ?>" alt="">
		<br><br>
		
		<form action="admin_index.php" method="post">
			<input type="submit" name="yes_<?php echo $row['id']; ?>" value="Approve">
			<br><br>
			<input type="submit" name="no_<?php echo $row['id']; ?>" value="Decline">
			<br><br>
		</form>
	</div>

	<?php 

		endif;

		$id = $row['id'];
		$file = $row['file_name'];
		$yes_post = 'yes_'.$id;
		$no_post = 'no_'.$id;

		// they've clicked approve
		if (isset($_POST[$yes_post])) {
			echo image_status($id, $file, '1');
		}
		// they've clicked decline
		if (isset($_POST[$no_post])) {
			echo image_status($id, $file, '2');
		}

		endwhile;	
	?>
</div>

<footer style="padding-top: 1em; padding-left: 2em;">

	<a href="admin_archive.php" style="color: white;">ARCHIVED</a>

	<!-- Only show if the user is admin  -->
	<?php if ($_SESSION['user_mod'] == 1) {
		echo '
			<a href="admin_approved.php" style="color: white">View ITEMS in GALLERY</a>
			<a href="admin_createuser.php" style="color: white">Create Moderator</a>
			<a href="admin_edituser.php" style="color: white">Edit Moderator</a>
		';
	} ?>
	<br><br>
	<a href="scripts/caller.php?caller_id=logout" style="color: white">Sign Out</a>

</footer>

</main>

</body>

</html>






