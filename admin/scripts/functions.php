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

// function generatePassword($length) {
// 	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
//     $charactersLength = strlen($characters);
//     $randomString = '';
//     for ($i = 0; $i < $length; $i++) {
//         $randomString .= $characters[rand(0, $charactersLength - 1)];
//     }
//     return $randomString;
// }

 ?>