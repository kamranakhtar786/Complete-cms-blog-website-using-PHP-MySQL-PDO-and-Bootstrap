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
<link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CMS</title>
   <?php require_once 'includes/head.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | <?php echo $app_name;?></title>
</head>
<body>
    
<?php
require_once 'includes/header.php';
echo InfoMessage();

?>

<div class="bg-dark text-white py-3 mb-3">
<div class="container">

<div class="row">
<h1 class="col-md-12"><i class="fa fa-tachometer-alt"></i> Dashboard</h1>

<div class="col-lg-3 mb-1"><a href="create-post.php" type="button" class="btn btn-primary btn-block"><i class="fas fa-edit"></i> Add New Post</a></div>
<div class="col-lg-3 mb-1"><a href="categories.php" class="btn btn-info btn-block"><i class="fas fa-folder-plus"></i> Add New Category</a></div>
<div class="col-lg-3 mb-1"><a href="#" class="btn btn-danger btn-block"><i class="fas fa-user-plus"></i> Add New User</a></div>
<div class="col-lg-3 mb-1"><a href="comments.php"  class="btn btn-success btn-block"><i class="fas fa-check"></i> Approve Comments</a></div>


</div>

</div>
</div>
<div class="container">
<div class="row">
<div class="col-lg-2">
<div class="float-center bg-dark text-white p-5 mb-3 rounded text-center">Posts<br><i class="fas fa-book-open"></i> 
<?php
global $pdo;
$sql = "SELECT count(*) FROM posts"; 
$result = $pdo->prepare($sql); 
$result->execute(); 
$number_of_rows = $result->fetchColumn();
 echo " ".$number_of_rows;
?>
</div>
<div class="bg-dark text-white p-5 mb-3 rounded text-center">Category<br><i class="fas fa-folder"></i>
<?php
global $pdo;
$sql = "SELECT count(*) FROM categories"; 
$result = $pdo->prepare($sql); 
$result->execute(); 
$number_of_rows = $result->fetchColumn();
 echo " ".$number_of_rows;
?></div>
<div class="bg-dark text-white p-5 mb-3 rounded text-center">Users<br><i class="fas fa-users"></i> 
<?php
global $pdo;
$sql = "SELECT count(*) FROM users"; 
$result = $pdo->prepare($sql); 
$result->execute(); 
$number_of_rows = $result->fetchColumn();
 echo " ".$number_of_rows;
?>
</div>
<div class="bg-dark text-white p-5 mb-3 rounded text-center">Comments<br><i class="fas fa-comments"></i> 
<?php
global $pdo;
$sql = "SELECT count(*) FROM comments"; 
$result = $pdo->prepare($sql); 
$result->execute(); 
$number_of_rows = $result->fetchColumn();
 echo " ".$number_of_rows;
?>
</div>
</div>

<div class="col-lg-10" style="margin-right:0px">

<table class="table table-striped table-hover">
<?php echo WelcomeMessage();
echo ErrorMessage();
echo InfoMessage();
echo SuccessMessage();
?>
<h1>Top Posts</h1>
  <thead class="thead-dark">
    <tr>
      <th >No.</th>
      <th >Title</th>
      <th >Time</th>
      <th >Author</th>
      <th >Comments</th>
      <th >Action</th>
      <th >Details</th>
    </tr>
  </thead>
  <?php
global $pdo;
 $sql = "SELECT * FROM posts";
 $stmp = $pdo->query($sql);
 
 while ($data = $stmp->fetch()) {
     $id = $data["id"];
     $title  = $data["title"];
     $category  = $data["category"];
    $slug = $data["slug"];
     $date  = $data["date"];
     $date = date("d-M-y H:i:s",$date); 
     $author  = $data["author"];
     $image  = $data["image"];
 
?>
  <tbody>
    <tr>
      <th scope="row"><?php echo $id;?></th>
      <td><?php echo $title;?></td>
      <td><?php echo $date;?></td>
      <td><?php echo $author;?></td>
      <td>
      <span class="badge badge-success"><?php
global $pdo;
$sql = "SELECT count(*) FROM comments WHERE status ='1' AND post_id = '$id'"; 
$result = $pdo->prepare($sql); 
$result->execute(); 
$number_of_rows = $result->fetchColumn();
 echo " ".$number_of_rows;
?></span>
      <span class="badge badge-danger"><?php
global $pdo;
$sql = "SELECT count(*) FROM comments WHERE status = '0'  AND post_id = '$id'"; 
$result = $pdo->prepare($sql); 
$result->execute(); 
$number_of_rows = $result->fetchColumn();
 echo " ".$number_of_rows;
?></span>
      </td>
      <td><form action="edit-post.php" method="post"><input type="hidden" name="slug" value="<?php echo $slug;?>"><input type="hidden" name="ref" value="dashboard"><button class="fas fa-edit" style="border:none;color:#007bff"></button></form></td>
      <td><a href="/blog/<?php echo $slug;?>" type="button" ><i class="fas fa-eye"></i></a></td>
      
    </tr>
   </tbody>
<?php } ?>
</table>
</div>
</div>



</div>
<?php
require_once 'includes/footer.php';
?>
</body>
</html>
