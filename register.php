<?php
session_start();

require_once 'includes/db.php';
require_once 'includes/session.php';
require_once 'includes/function.php';
$username = $_SESSION["username"];
if(isset($username)){
  Redirect_to("dashboard.php");
}
if(isset($_POST["submit"])){
    date_default_timezone_set("Asia/Kolkata");
  $username = $_POST["username"];
  $email = $_POST["email"];
  $fullname = $_POST["fullname"];
  $status = 0;
  $time = time();
  $salt = $username;
  $NoEncryptedPassword = randomString(6,$username,$time);
  $password = base64_encode(md5(md5($NoEncryptedPassword.$salt)));
  
  //$password = base64_encode(md5(md5($password))); //Encoding
  if (empty($username) || empty($email)) {
    $_SESSION["ErrorMessage"] = "field can't be empty";
  }else{
     global $pdo;
      $sql_check = "SELECT count(*) FROM users WHERE username = '$username' OR email = '$email'";
      $result = $pdo->prepare($sql_check);
      $result->execute();
      $noOfRows = $result->fetchColumn();

      if ($noOfRows > 0 || $noOfRows != 0) {
         $_SESSION["ErrorMessage"] = "Username or Email i'd is already used!";
      }
      else{

       
        $sql_insert = "INSERT INTO users(username,fullname,email,password,time,status)";
        $sql_insert .= "VALUES(:username,:fullname,:email,:password,:time,:status)";
        $stmt = $pdo->prepare($sql_insert);
        $stmt ->bindValue(':username',$username); 
        $stmt ->bindValue(':fullname',$fullname);
        $stmt ->bindValue(':email',$email);
        $stmt ->bindValue(':password',$password);
        $stmt ->bindValue(':time',$time);
        $stmt ->bindValue(':status',$status);

        $Execute = $stmt ->execute();
        if ($Execute) {
$subject = "Your Credential for kafarooqui.in";
$message = "Hello".$fullname." ";
$message .="Your Username is $username and Password is $NoEncryptedPassword";
if (mail($email,$subject,$message)) {
  $_SESSION["SuccessMessage"] = "Registered successfully !\n";
  $_SESSION["SuccessMessage"] .= "Username and Password will be sent to your email id shortly \n";
}
else{
    $SESSION["ErrorMessage"] = "Can't sent Email";
}


          
         
        }
        else{
          $_SESSION["ErrorMessage"] = "Something went wrong!";
        }

      }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="includes/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register - <?php echo $app_name;?></title>
   <?php require_once 'includes/head.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    
<?php
require_once 'includes/db.php';
?>
<div class="bg-info" style="height:10px;"></div>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="../index.php"><?php echo $app_name;?></a>


  
</nav>
<div class="bg-info" style="height:10px;"></div>

<div class="bg-dark text-white py-3 mb-3">
<div class="container">

<div class="row">
<h1 class="col-md-12"><i class="fa fa-user text-info"></i> Register</h1>
</div>
</div>
</div>

<section class="container py-2 mb-4">
<div class="row">
<div class="offset-sm-3 col-sm-6" style="min-height:400px">
<?php
echo ErrorMessage();
echo SuccessMessage();
echo InfoMessage();
?>
<br><br>
<div class="card bg-secondary text-light">
<div class="card-header">
<h4 >Register</h4>

</div>

<div class="card-body bg-dark">
<form action="register.php" class="" method="post">

<div class="form-group">
<label for="username"><span class="FieldInfo">Username:</span></label>
<div class="input-group mb-3">
<div class="input-group-prepend">
<span class="input-group-text text-white bg-info" ><i class="fas fa-at"></i></span>
</div>
<input type="text"  class="form-control ml-0" name="username" id="username" placeholder="Enter Username.." >
</div>
</div>

<div class="form-group">
<label for="fullname"><span class="FieldInfo">Fullname:</span></label>
<div class="input-group mb-3">
<div class="input-group-prepend">
<span class="input-group-text text-white bg-info" ><i class="fas fa-user"></i></span>
</div>
<input type="text"  class="form-control ml-0" name="fullname" id="fullname" placeholder="Enter your Fullname..">
</div>
</div>

<div class="form-group">
<label for="email"><span class="FieldInfo">Email:</span></label>
<div class="input-group mb-3">
<div class="input-group-prepend">
<span class="input-group-text text-white bg-info" ><i class="fas fa-envelope"></i></span>
</div>
<input type="email"  class="form-control ml-0" name="email" id="email" placeholder="Enter your email..">
</div>
</div>

<input type="submit" name="submit" value="Register" class="btn btn-info btn-block">
<br>
<small>Already have account? <a href="../login">Sign In</a></small>
</form>

</div>
</div>
</div>
</div>
</section>



<?php
require_once 'includes/footer.php';
?>
</body>
</html>
