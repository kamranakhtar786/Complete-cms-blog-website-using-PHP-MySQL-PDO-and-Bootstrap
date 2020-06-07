<?php

date_default_timezone_set("Asia/Kolkata");
session_start();
require_once 'includes/db.php';
require_once 'includes/session.php';
require_once 'includes/function.php';
$username = $_SESSION["username"];
$postId ="";
$slug = $_GET['slug'];

if($slug == null){
    $_SESSION["ErrorMessage"]="Bad Request!!";
    Redirect_to("posts.php");
}

if(isset($_GET["logout"])){
  session_destroy();
  Redirect_to("login.php");
}
 
 global $pdo;
 if(isset($slug)){
    $sql = "SELECT * FROM posts WHERE slug = '$slug' LIMIT 1";
 }
 
  $stmp = $pdo->query($sql);
    
 
  while ($data = $stmp->fetch()) {
      $id = $data["id"];
      $postId = $data["id"];
      $title  = $data["title"];
      $category  = $data["category"];
     $date  = $data["date"];
      $date = date("d-M-Y H:i:s",$date); 
      $author  = $data["author"];
      $image  =$data["image"];
      $text = $data["text"];
    
  }
  if(empty($postId)){
    $_SESSION["NotFoundMessage"]="Sorry! The Post you are searching for is not available";
   Redirect_to("/");
    
}
 
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

 if(isset($_POST['submit_comment'])){
 $CommenterName = $_POST['CommenterName'];
 $CommenterEmail = $_POST['CommenterEmail'];
 $CommenterText = $_POST['CommenterText'];
 $CommentStatus = 0;
 $CommentDate = time();
 $CommentPostId = $postId;
 $CommentPostSlug = $slug;
 if (empty($CommenterName) || empty($CommenterEmail) || empty($CommenterText)) {
    $_SESSION["ErrorMessage"] = "field can't be empty";
 }
 else{
       $sql_insert_comment = "INSERT INTO comments(name,text,email,post_id,status,date,post_slug)";
       $sql_insert_comment .= "VALUES(:name,:text,:email,:post_id,:status,:date,:post_slug)";

       $stmt_insert_comment = $pdo ->prepare($sql_insert_comment);
       $stmt_insert_comment->bindValue(':name',$CommenterName);
       $stmt_insert_comment->bindValue(':text',$CommenterText);
       $stmt_insert_comment->bindValue(':email',$CommenterEmail);
       $stmt_insert_comment->bindValue(':post_id',$CommentPostId);
       $stmt_insert_comment->bindValue(':status',$CommentStatus);
       $stmt_insert_comment->bindValue(':date',$CommentDate);
       $stmt_insert_comment->bindValue(':post_slug',$CommentPostSlug);
       $Execute_insert_comment = $stmt_insert_comment->execute();
       if ($Execute_insert_comment) {
           $_SESSION["SuccessMessage"] = "Your Comment is submitted successfully";
       }else{
        $_SESSION["ErrorMessage"] = "Something went wrong!";
       }

 }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once 'includes/head.php';?>
    <title><?php echo $title;?>| <?php echo $app_name;?></title>
</head>
<body>
    <?php require_once 'includes/header.php';?>
    
<div class="container">
<div class="row">
<!--- sm8-->
<div class="col-sm-8" >
<!-- content -->
<div class="card">
<?php
echo ErrorMessage();
echo SuccessMessage();
echo InfoMessage();

?>

<img src="../uploads/<?php echo $image;?>" alt="" class="img-fluid card-img-top" style="max-height:450px">
<div class="card-body">
<h4 class="card-title"><?php echo $title;?></h4>
<small class="text-muted">Written By <?php echo $user?> on <?php echo $date;?></small>
<span style="float:right" class="badge badge-dark text-light">Comment <?php $sql = "SELECT count(*) FROM comments WHERE post_id=$postId"; 
$result = $pdo->prepare($sql); 
$result->execute(); 
$number_of_rows = $result->fetchColumn();
echo $number_of_rows;
?></span>
<hr>
<p class="card-text"><?php echo $text;?></p>
</div>
</div>
<br>
<!-- comment -->
<!-- fetch comment -->
<span class="FieldInfo">Comments</span>
<br><br>
<?php


$sqlComment = "SELECT * FROM comments WHERE post_id = $postId AND status = 1";
$stmtComment = $pdo->query($sqlComment);
  
while ($dataComment = $stmtComment->fetch()) {
    
    $id = $dataComment["id"];
    $CommenterName = $dataComment["name"];
    $CommentDate = $dataComment["date"];
    $CommentText = $dataComment["text"];
     $CommentDate = date("d-m-y h:m:s a",time());
?>
<div>

<div class="media CommentBlock" id="<?php echo "comment-".$id;?>">
<img src="../uploads/avatar.png" style="width:100px;height:100px;" alt="" class="d-block img-fluid align-self-start">
<div class="media-body ml-2">
<h6 class="lead"><?php echo $CommenterName;?></h6>
<p class="small"><?php echo $CommentDate;?></p>
<p><?php echo $CommentText;?></p>
</div>
</div>
</div>
<hr>
<?php } ?>
<!-- fetch comment -->
<!-- insert comment -->
<div class="mt-5">
<form class="form" action="../blog/<?php echo $slug;?>" method="post">
<div class="card mb-3">
<div class="card-header">
<h5 class="FieldInfo">Share your thoughts about this post</h5>
</div>
<div class="card-body">

<div class="form-group">
<div class="input-group">
<div class="input-group-prepend">
<span class="input-group-text"><i class="fas fa-user"></i></span>
</div>
<input type="text" name="CommenterName" id="" placeholder="Name" class="form-control">
</div>
</div>

<div class="form-group">
<div class="input-group">

<div class="input-group-prepend">
<span class="input-group-text"><i class="fas fa-envelope"></i></span>
</div>
<input type="email" name="CommenterEmail" id="" placeholder="Email" class="form-control">
</div>
</div>

<div class="form-group">
<textarea name="CommenterText" placeholder="Enter your thoughts here..." id="" cols="80" rows="6" class="form-control"></textarea>
</div>

<div class="">
<button type="submit" class="btn btn-primary" name="submit_comment">Submit</button>
</div>

</div>
</div>
</form>
</div>


<!-- comment -->
<!-- content -->
</div>
<!--- sm8-->
<!--- sm4-->
<div class="col-sm-4" style="min-height:80px;">
<?php require_once 'side.php';

?>

</div>
<!--- sm4-->

</div>
</div>
    <?php require_once 'includes/footer.php';?>
</body>
</html>