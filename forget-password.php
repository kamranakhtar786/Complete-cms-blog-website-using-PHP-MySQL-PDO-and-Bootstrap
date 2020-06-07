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
  $username = $_POST["username"];
  $password = $_POST["password"];
$salt = $username;
  $password = base64_encode(md5(md5($password.$salt)));
  if (empty($username) || empty($password)) {
    $_SESSION["ErrorMessage"] = "field can't be empty";
  }else{
     global $pdo;
     $sql ="SELECT * FROM users WHERE username= :userName AND password= :passWord LIMIT 1";
     $stmt = $pdo->prepare($sql);
     $stmt ->bindValue(':userName',$username);
     $stmt -> bindValue(':passWord',$password);
     $stmt -> execute();
     $Result = $stmt->rowCount();
     if ($Result == 1) {
      $_SESSION["username"] = $username;
    
      Redirect_to("dashboard.php");
     }else{
      $_SESSION["ErrorMessage"] = "Login failed!! ";
      $_SESSION["ErrorMessage"] .="Please check your Username or Password"; 
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
    <title>Login | <?php echo $app_name;?></title>
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
<h1 class="col-md-12"><i class="fa fa-user text-info"></i> Login</h1>
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
<h4 >Welcome!!</h4>

</div>

<div class="card-body bg-dark">
<form action="login.php" class="" method="post">
<div class="form-group">
<label for="username"><span class="FieldInfo">Username:</span></label>
<div class="input-group mb-3">
<div class="input-group-prepend">
<span class="input-group-text text-white bg-info" ><i class="fas fa-user"></i></span>
</div>
<input type="text"  class="form-control ml-0" name="username" id="username">
</div>
</div>
<div class="form-group">
<label for="password"><span class="FieldInfo">Password:</span></label>
<div class="input-group mb-3">
<div class="input-group-prepend">
<span class="input-group-text text-white bg-info" ><i class="fas fa-lock"></i></span>
</div>
<input type="password"  class="form-control ml-0" name="password" id="password">
</div>
</div>

<input type="submit" name="submit" value="Login" class="btn btn-info btn-block">
</form><br>
<small>Don't have an account? <a href="../register">Register</a></small>
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
