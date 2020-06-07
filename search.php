<?php
session_start();
require_once 'includes/db.php';
require_once 'includes/session.php';
require_once 'includes/function.php';
$username = $_SESSION["username"];

$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 
"https" : "http") . "://" . $_SERVER['HTTP_HOST'] .  
$_SERVER['REQUEST_URI']; 

$search = $_GET['s'];

// Search substring  
$key = '?'; 
  
if (strpos($link, $key) == true) { 
     Redirect_to("../search/$search");
} 



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once 'includes/head.php';?>
    <title><?php echo $search;?></title>
</head>
<body>
    <?php require_once 'includes/header.php';?>
    <div class="bg-dark text-white py-1 mb-1">
<div class="container">

<div class="row">
<h3 class="col-md-12"><i class="fa fa-search text-info"></i>&nbsp;&nbsp;<?php echo $search;?></h3>
</div>
</div>
</div>
    <!-- header close here-->
<div class="container mt-3">

<div class="row">
<!--- sm8-->
<div class="col-sm-8" >
<?php 
echo ErrorMessage();
echo InfoMessage();
?>
<!-- content -->
<?php
 global $pdo;
 $sql = "SELECT * FROM posts WHERE title LIKE :search
 OR text LIKE :search
  OR category LIKE :search
   OR author LIKE :search 
   OR date LIKE :search ";
   $stmp = $pdo->prepare($sql);
   $stmp -> bindValue(':search','%'.$search.'%');
   $stmp -> execute();
   $totalPost = $stmp->fetchColumn();
   
 while ($data = $stmp->fetch()) {
     $id = $data["id"];
     $title  = $data["title"];
     $slug = $data["slug"];
     $category  = $data["category"];
    $date  = $data["date"];
     $date = date("d-M-Y h:i:s",$date); 
     $author  = $data["author"];
     $image  = $data["image"];
     $text = $data["text"];
     $sql2 = "SELECT * FROM categories WHERE id = $id";
$stmt2 = $pdo -> query($sql2);
while($data2 = $stmt2->fetch()){
    $categoryTitle = $data2["title"];
}

$sql3 = "SELECT * FROM users WHERE username ='$author'";
$stmt3 = $pdo -> query($sql3);
while($data3 = $stmt3->fetch()){
    $user = $data3["fullname"];
}

 
 ?>

<div class="card mt-3">

<img src="../uploads/<?php echo $image;?>" alt="" class="img-fluid card-img-top" style="max-height:450px">
<div class="card-body">
<h4 class="card-title"><?php echo $title;?></h4>
<small class="text-muted">Written By <?php echo $user?> on <?php echo $date;?> in <?php echo $category;?></small>
<span style="float:right" class="badge badge-dark text-light">Comment 2</span>
<hr>
<a href="../blog/<?php echo $slug;?>"><p class="btn btn-info" style="float:right">Read More >></p></a>


</div>
</div>
<?php } 
if ($totalPost <= 0)  {
   echo ' <p class="alert alert-danger py-2">Sorry! No Post Found! <Br> Try search with new keyword</p>'.$totalPost;
}
?>

<!-- content -->
</div>
<!--- sm8-->
<!--- sm4-->
<div class="col-sm-4" style="min-height:80px;">
<?php
require_once 'side.php';?>

</div>
<!--- sm4-->

</div>
</div>
    <?php require_once 'includes/footer.php';?>
</body>
</html>