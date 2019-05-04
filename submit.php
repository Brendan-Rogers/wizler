<?php
   require_once('admin/scripts/config.php');

   if(isset($_FILES['image'])){

      $errors= array();
      $file_name = $_FILES['image']['name'];
      $file_size =$_FILES['image']['size'];
      $file_tmp = $_FILES['image']['tmp_name'];
      $file_type = $_FILES['image']['type'];
      $file_ext = strtolower(end(explode('.',$_FILES['image']['name'])));

      $fileinfo = getimagesize($_FILES["image"]["tmp_name"]);
      $width = $fileinfo[0];
      $height = $fileinfo[1];

      $f_name = $_POST['f_name'];
      $l_name = $_POST['l_name'];
      $terms = $_POST['terms'];
      $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
      
      $extensions= array("jpeg","jpg","png");

      if (!$email) {
         $errors[] = 'That is not an email address. Nice try!';
      }
      if(in_array($file_ext,$extensions)=== false){
         $errors[]="extension not allowed, please choose a JPEG or PNG file.";
      }
      if($file_size > 2097152){
         $errors[]='File size must be less then 2 MB';
      }
      if ($width != 800 || $height != 1114) {
         $errors[] = 'File must be exactly 800px wide by 1114px tall';
      } if (!$terms) {
         $errors[] = 'The checkbox was not checked';
      }
      
      if(empty($errors)==true){
         $new_file_name = strtolower($f_name).'_'.time().'.'.$file_ext;

         move_uploaded_file($file_tmp,'images/user_images/'.$new_file_name);
         echo image_submit($f_name, $l_name, $email, $new_file_name).$width.$height;

      }else{
         print_r($errors);
      }
   }
?>

<!DOCTYPE html>
<html>
<head>
   <title>SUBMISSION PAGE</title>
   <link rel="stylesheet" href="css/master.css">
   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
</head>
<body>

</body>
</html>

   <body id="form">

      <div id="formContainer">
         <form class="form" action="" method="POST" enctype="multipart/form-data">
            <h2>Submit your Work</h2>
           <!-- <label class="hidden">First Name:</label>-->
            <input type="text" name="f_name" placeholder="First Name">
            <br><br>
            <!--<label>Last Name:</label>-->
            <input type="text" name="l_name" placeholder="Last Name">

            <br><br> 

            <!--<label>Email Address:</label>-->
            <input type="email" name="email" placeholder="Email Address">

            <br><br>
          
            <input type="file" name="image" accept="image/*" />

            <br><br><br>

            <input class="formBtn" type="submit" value="Submit Entry" />
         </form>
      </div>

      <a href="admin/admin_login.php" class="adminLink"><img class="adminLock" src="images/lock-icon.svg" alt="admin link"></a>



<script src="js/nav.js"></script>

</body>
</html>






