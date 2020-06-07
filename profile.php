<?php
session_start();
require_once 'includes/db.php';
require_once 'includes/session.php';
require_once 'includes/function.php';
$username = $_SESSION["username"];
if (empty($username)) {
  $_SESSION["InfoMessage"]="Please login first!!";
  Redirect_to("login.php");
}
if(isset($_GET["logout"])){
  session_destroy();
  Redirect_to("login.php");
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once 'includes/head.php';?>
    <title>Profile</title>
</head>
<body>
    <?php require_once 'includes/header.php';?>
    <div class="bg-dark text-white py-3 mb-3">
<div class="container">

<div class="row">
<h1 class="col-md-12"><i class="fa fa-user text-info"></i> My Profile</h1>
</div>
</div>
</div>

<section class="container py-3 mb-4">
<div class="row">
<!-- Left Area-->
<?php
global $pdo;
$sql = "SELECT * FROM users WHERE username='$username'";
$stmp = $pdo->query($sql);

while ($data = $stmp->fetch()) {
    $id = $data["id"];
   $fullname = $data["fullname"];
   $email = $data["email"];
}
if(isset($_POST["change_password"])){
  $p1 = $_POST["password1"];
  $p2 = $_POST["password2"];
$salt = $username;
  $NoEncryptedPassword = $p1;
  $password = base64_encode(md5(md5($NoEncryptedPassword.$salt)));

 
  
  if($p1 != $p2){
    $_SESSION["ErrorMessage"]= "Password not matched!";
  }
  else{
    //$_SESSION["SuccessMessage"] = "Password Matched";
     global $pdo;
     $sql ="UPDATE users SET password = '$password' WHERE username = '$username'";
     $Execute = $pdo->query($sql);
     if ($Execute) {
// To send HTML mail, the Content-type header must be set
$headers = 'MIME-Version: 1.0';
$headers .= 'Content-type: text/html; charset=iso-8859-1';

// Additional headers
$headers .= 'From: K A FAROOQUI <info@kafarooqui.in>';


      $subject = "Your Credential for kafarooqui.in";
      $message = '
      <html>
      <head>
        <title>Password Changed!</title>
      </head>
      <body>
        <p>Hello '.$fullname.'</p><br>
        <p>Password is changed successfully</p>
        <h4 align="center">Login Details</h4>
        <table>
          <tr>
            <th>Username</th><th>Password</th>
          </tr>
          <tr>
            <td>'.$username.'</td><td>'.$NoEncryptedPassword.'</td>
          </tr>
          
        </table><br><br>
        <b>Regard :<br>K A FAROOQUI (founder)<b>
      </body>
      </html>
      ';

       $_SESSION["SuccessMessage"] = "Password Changed Successfully";
       if (mail($email,$subject,$message,$headers)) {
        $_SESSION["SuccessMessage"] .= " An email containing your username and password will be send to you shortly. \n";
      }
      else{
          $SESSION["ErrorMessage"] = "Can't sent Email";
      }
     }
     else{
       $_SESSION["ErrorMessage"] ="Something went wrong!";
     }
  }
}
?>
 <div class="col-md-3">
 <div class="card">
 <div class="card-header bg-dark text-light">
 <h5 class="text-center"><?php echo $fullname;?></h5>
 
 </div>
 <div class="card-body">
 <img src="uploads/avatar.png" alt="" class="block img-fluid mb-3">
 <div class="">
 Lorekjbncfjkvbh sdfuyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyvb 
 </div>
 </div>
 </div>
 </div>
 <!-- right section -->
 <div class="col-md-9">
 <?php echo ErrorMessage();
      echo SuccessMessage();
      echo InfoMessage();
      
      ?>
 <form action="profile.php" method="post" enctype="multipart/form-data">
<div class="card  bg-secondary text-light mb-3">

<div class="card-body bg-dark">
<div class="form-group">
<label for="title"><span class="FieldInfo">New Password</span></label>
<input class="form-control" type="password" name="password1" id="title" placeholder="Password">
</div>

<div class="form-group">
<label for="title"><span class="FieldInfo">Confirm Password</span></label>
<input class="form-control" type="text" name="password2" id="title" placeholder="Confirm Password">
</div>




<div class="row" style="min-height:50px;">
<div class="col-lg-6 mb-2 text-light">
<a href="dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Dashboard</a>
</div>
<div class="col-lg-6 mb-2">
<button type="submit" class="btn btn-success btn-block" name="change_password"><i class="fas fa-check"></i> Change Password</button>

</div>
</div>


</div>
</div>
</form>
 </div>

</div>
</section>
</body>
</html>