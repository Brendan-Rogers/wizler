<?php
	ini_set('display_errors',1);
	error_reporting(E_ALL);
	
	include('scripts/config.php');
	confirm_admin();

	$display = get_images(1);
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

<h2>These are currently in the gallery, <?php  echo ucwords($_SESSION['user_name']).'.';  ?> </h2>
<h3>You can choose to move them out of rotation.</h3>

<div class="imgSect">
	<?php while ($row = $display->fetch(PDO::FETCH_ASSOC)): ?>

	<div class="orgPoster">
		<img src="../images/user_images/<?php echo $row['file_name']; ?>" alt="">
		<br><br>
		
		<form action="admin_approved.php" method="post">
			<input type="submit" name="no_<?php echo $row['id']; ?>" value="Move to Archive">
			<br><br>
			<?php if (!$row['featured']): ?>

			<input type="submit" name="featured_<?php echo $row['id']; ?>" value="Feature this Poster">
			<br><br>

			<?php endif; ?>
		</form>
	</div>

	<?php 
		$id = $row['id'];
		$file = $row['file_name'];

		$no_post = 'no_'.$id;
		$feature_post = 'featured_'.$id;

		// they've clicked decline
		if (isset($_POST[$no_post])) {
			echo image_status($id, $file, '3');
		} else if (isset($_POST[$feature_post])) {
			echo image_status($id, $file, '4');
		}

		endwhile;	
	?>
</div>

<a href="admin_archive.php">ARCHIVE</a>
<a href="admin_index.php">INDEX</a>
<br>
<a href="admin_createuser.php">Create Moderator</a>
<a href="admin_edituser.php">Edit Moderator</a>
<a href="scripts/caller.php?caller_id=logout">Sign Out</a>

</main>

</body>

</html>






