<?php
require_once 'includes/function.php';
require_once 'includes/db.php';
require_once 'includes/session.php';
$username = $_SESSION["username"];
if(!isset($username)){
  Redirect_to("login.php");
}
$slug = $_POST["slug"];
$ref = $_POST['ref'];

if(empty($slug)){  
   Redirect_to("dashboard.php");
}

// Getting Data from Database //

global $pdo;
$sql = "SELECT * FROM posts WHERE slug = '$slug' LIMIT 1";
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
  $tags = $data["tags"];
}
if(empty($postId)){  //verify if post is not avalaible
    $_SESSION["NotFoundMessage"]="Sorry! Post is not available right now";
   Redirect_to("/");
    
}

$sql3 = "SELECT * FROM users WHERE username ='$author'";
$stmt3 = $pdo -> query($sql3);
while($data3 = $stmt3->fetch()){
    $user = $data3["fullname"];
}

// close getting data from Database //


// Insert the data into the database
//insert into database
if (isset($_POST["submit"])) {
    date_default_timezone_set("Asia/Kolkata");
    $title_update = $_POST["title"];
    $text_update = $_POST["text"];
    $category_update  =  $_POST["category"];
    $date_update  = time();
    $author_update  = $_POST["author"];
    $tags_update  = $_POST["tags"];
   
      if (empty($title_update ) || empty($text_update ) || empty($category_update ) ) {
          $_SESSION["ErrorMessage"] ="All field are important";
      }
      else{
          global $pdo;
          $sql = "UPDATE posts SET title = '$title_update',text = '$text_update', category = '$category_update',updatedate = '$date_update' , tags = '$tags_update' , author = '$author_update' WHERE slug = '$slug'";
          
         
    
          $execute = $pdo->query($sql);
        
          if ($execute) {
              $_SESSION["SuccessMessage"] = "Post Update Successfully.";
             Redirect_to("dashboard.php");
          }
          else {
              $_SESSION["ErrorMessage"] = "Something went wrong!";
             // Redirect_to("categories.php");
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
    <title>Edit Post</title>
</head>
<body>
<?php require_once 'includes/header.php';?>
<hr>
<div class="container">
<div class="row">
 <!-- right section -->
 <div class="col-lg-9">
 <?php echo ErrorMessage();
      echo SuccessMessage();
      echo InfoMessage();
      
      ?>
 <form action="edit-post.php" method="post" enctype="multipart/form-data">
 
<div class="card  bg-secondary text-light">

<div class="card-body bg-dark">
<!-- post title -->
<div class="form-group">
<input type="hidden" name="slug" value="<?php echo $slug;?>">
<label for="title"><span class="FieldInfo">Post Title</span></label>
<input class="form-control" type="text" name="title" id="title" placeholder="Post Title" value="<?php echo $title;?>">
</div>
<!-- post tags -->
<div class="form-group">
<label for="title"><span class="FieldInfo">Post Tags</span></label>
<input class="form-control" type="text" name="tags" id="title" placeholder="Post Tags"  value="<?php echo $tags;?>" >
</div>

<!-- post Author -->
<div class="form-group">
<label for="title"><span class="FieldInfo">Post Author</span></label>
<input class="form-control" type="text" name="author" id="title" placeholder="Post Author"  value="<?php echo $username;?>">
</div>
<!-- post \Category -->
<div class="form-group">
<label for="title"><span class="FieldInfo">Post Category</span></label>
<select name="category" id="CategoryTitle" class="form-control">
<?php
global $pdo;
 $sql = "SELECT id,title FROM categories";
 $stmp = $pdo->query($sql);
 while ($data = $stmp->fetch()) {
     $id = $data["id"];
     $categoryName_update = $data["title"];
    
 echo "<option value=\"$categoryName_update \"> $categoryName_update</option>";
 }
 echo "<option value=\"$category\" selected>$category (Previous)</option>";
?>


</select>
</div>
<!-- post Text-->
<div class="form-group">
<label for="title"><span class="FieldInfo">Post Text</span></label>
<textarea class="form-control" type="text" name="text" id="text" placeholder="Post Text" ><?php echo $text;?></textarea>
<script>CKEDITOR.replace( 'text' );</script>
</div>



<div class="row" style="min-height:50px;">
<div class="col-lg-6 mb-2 text-light">
<a href="dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Dashboard</a>
</div>
<div class="col-lg-6 mb-2">
<button type="submit" class="btn btn-success btn-block" name="submit"><i class="fas fa-check"></i> Update Post</button>

</div>
</div>


</div>
</div>
</form>
 </div>
 <!-- Right Section -->
<div class="col-lg-3 bg-dark text-light">
<small class="Fieldinfo">Select Feature Image : </small>
</div>
</div>
</div>





<?php require_once 'includes/footer.php';?>
</body>
</html>