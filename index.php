<?php
session_start();
require_once 'includes/db.php';
require_once 'includes/session.php';
require_once 'includes/function.php';
$username = $_SESSION["username"];
$categoryId = $_GET['category'];
$tag = $_GET["tag"];

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
    <title><?php echo $app_name;?></title>
</head>
<body>
    <?php require_once 'includes/header.php';?>
    
<div class="container mt-3">

<div class="row">
<!--- sm8-->
<div class="col-sm-8" >
<?php 
echo ErrorMessage();
echo InfoMessage();
echo NotFoundMessage();
?>
<!-- content -->
<?php

 global $pdo;
 $sql = "SELECT * FROM posts ORDER BY id DESC LIMIT 1,4";
 if (isset($_GET["page"])) {
   $page = $_GET["page"];
   if ($page == 0 || $page < 1) {
     $ShowPostFrom = 0;
   }
   else{
    $ShowPostFrom = ($page*5)-5;
   }
 
  $sql = "SELECT * FROM posts ORDER BY id desc LIMIT $ShowPostFrom,4";

 }
 if(isset($categoryId)){
  $categoryId = str_replace("-"," ",$categoryId);
    $sql = "SELECT * FROM posts WHERE LOWER(category) LIKE LOWER('%$categoryId%') ORDER BY id DESC";

    $sql_count = "SELECT count(*) FROM posts WHERE LOWER(category) LIKE LOWER('%$categoryId%') ";
    $result = $pdo->prepare($sql_count);
    $result ->execute();
    $NumberOfPosts = $result->fetchColumn();
    
   echo "<div class='card card-body card-title bg-dark text-light'><h2>Category : $categoryId</h2></div>";
if ($NumberOfPosts == 0){
    echo "<div class=\"alert alert-danger\">Sorry No Post available in this Category</div>";
} 

 }

 if(isset($tag)){
$tag = str_replace("-"," ",$tag);

  $sql = "SELECT * FROM posts WHERE tags LIKE '%$tag%' ORDER BY id DESC";

  $sql_count = "SELECT count(*) FROM posts WHERE tags LIKE '%$tag%' ";
  $result = $pdo->prepare($sql_count);
  $result ->execute();
  $NumberOfPosts = $result->fetchColumn();
  
 echo "<div class='card card-body card-title bg-dark text-light'><h2>Tag : $tag</h2></div>";
if ($NumberOfPosts == 0){
  echo "<div class=\"alert alert-danger\">Sorry No Post available from this tag</div>";
} 

}
 $stmp = $pdo->query($sql);
 
 while ($data = $stmp->fetch()) {
     $id = $data["id"];
     $title  = $data["title"];
     $category  = $data["category"];
     $slug = $data["slug"];
    $date  = $data["date"];
     $date = date("d-M-Y H:i:s",$date); 
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
<small class="text-muted">Written By <?php echo $user?> on <?php echo $date;?></small>
<span style="float:right" class="badge badge-dark text-light">Comment <?php 
$sql = "SELECT count(*) FROM comments WHERE post_id = '$id'";
$result = $pdo->prepare($sql);
$result -> execute();
 echo $result ->fetchColumn();
?></span>
<hr>
<a href="/blog/<?php echo $slug;?>"><p class="btn btn-info" style="float:right">Read More >></p></a>


</div>
</div>
<?php } ?>
<!-- Pagination -->
<hr>
<nav style="display:<?php if(isset($categoryId) || isset($tag)){ echo "none"; }else{echo "block";}?>">
  <ul class="pagination pagination-lg">
  <?php  if(isset($page)) { if($page > 1){?>
  <li class="page-item">
   <a href="/page/<?php echo $page-1;?>" class="page-link">&laquo;</a>
 </li>
<?php }}?>

 <?php
 
global $pdo;
$sql = "SELECT count(*) FROM posts";
$stmt = $pdo ->query($sql);
$RowPagination = $stmt -> fetch();
$TotalPosts = array_shift($RowPagination);

$PostPagination = $TotalPosts/5;
$PostPagination = ceil($PostPagination);


for ($i=1; $i <= $PostPagination ; $i++) { 

 ?>
 <li class="page-item <?php if($i == $page){echo "active";} ?>">
   <a href="/page/<?php echo $i;?>" class="page-link"><?php echo $i;?></a>
 </li>
<?php } if(isset($page) && !empty($page)) { if($page+1 <= $PostPagination){?>
  <li class="page-item">
   <a href="/page/<?php echo $page+1;?>" class="page-link">&raquo;</a>
 </li>
<?php }}?>
  </ul>
</nav>  


<!-- Pagination -->
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