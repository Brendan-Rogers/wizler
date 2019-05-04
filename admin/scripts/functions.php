<?php 

function redirect_to($location) {
	if($location != NULL) {
		header("Location: {$location}");
		exit;
	}
}

function getSingle($tbl, $col, $id) {

	include('connect.php');

	$querySingle = "SELECT * FROM {$tbl} WHERE {$col} = {$id}";
	$runSingle = $pdo->query($querySingle);
	
	if($runSingle){
		return $runSingle;
	}else{
		$error = "There was a problem accessing this information.  Sorry about your luck ;)";
		return $error;
	}
}

function generatePassword($length) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function index_photos($index) {

	include('connect.php');

	if ($index == 'recent') {
		$get_images_query = 'SELECT * FROM tbl_images WHERE upload_time BETWEEN date_sub(now(),INTERVAL 1 WEEK) AND now() AND img_status = 1';
	} else if ($index == 'featured') {
		$get_images_query = 'SELECT * FROM tbl_images WHERE featured = TRUE AND img_status = 1';
	} else {
		$get_images_query = "SELECT * FROM tbl_images WHERE img_status = 1";
	}

	$get_images_set = $pdo->query($get_images_query);

	if ($get_images_set) {
		return $get_images_set;
	} else {
		return 'There are no images currently on display in the gallery.';
	}

}

 ?>