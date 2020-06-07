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
    <title>Manage Posts <?php echo $app_name;?></title>
   <?php require_once 'includes/head.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    
<?php
require_once 'includes/header.php';
echo InfoMessage();

?>

<div class="bg-dark text-white py-3 mb-3">
<div class="container">

<div class="row">
<h1 class="col-md-12"><i class="fa fa-blog"></i> Manage Posts</h1>




</div>

</div>
</div>
<div class="container">
<div class="row">
<div class="col-lg-12" style="margin-right:0px">

<table class="table table-striped table-hover">
<?php echo WelcomeMessage();
echo ErrorMessage();
echo InfoMessage();
?>
<h1>All Posts</h1>
  <thead class="thead-dark">
    <tr>
      <th >No.</th>
      <th >Title</th>
      <th>Image</th>
      <th >Time</th>
      <th >Author</th>
      <th >Comments</th>
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
     $SrNo++;
 
?>
  <tbody>
    <tr>
      <th scope="row"><?php echo $SrNo;?></th>
      <td><?php echo $title;?></td>
      <td><img src="../uploads/<?php echo $image;?>" alt="Featured Image" style="width:200px;height:100px;"></td>
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
      <td><a href="/<?php echo $slug;?>" type="button" ><i class="fas fa-eye"></i></a></td>
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
