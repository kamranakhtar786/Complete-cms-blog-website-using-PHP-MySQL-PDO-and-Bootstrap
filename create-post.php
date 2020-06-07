<?php
session_start();
require_once 'includes/db.php';
require_once 'includes/session.php';
require_once 'includes/function.php';
$username = $_SESSION["username"];
if(!isset($username)){
  Redirect_to("dashboard.php");
}

//insert into database
if (isset($_POST["submit"])) {
  date_default_timezone_set("Asia/Kolkata");
  $title = $_POST["title"];
  $slug = clean($title);
  $text = $_POST["text"];
  $category =  $_POST["category"];
  $date = time();
  $author = $username;
  $target ="uploads/".basename($_FILES["image"]["name"]);
  $image = $_FILES["image"]["name"];

    if (empty($title) || empty($text) || empty($category)  ||  empty($image) ) {
        $_SESSION["ErrorMessage"] ="All field are important";
    }
    else{
        global $pdo;
        $sql = "INSERT INTO posts(title,text,category,date,author,image,slug)";
        $sql .= "VALUES(:title,:text,:category,:date , :author,:image,:slug)";
        $stmt = $pdo->prepare($sql);
        $stmt ->bindValue(':title',$title);
        $stmt ->bindValue(':text',$text);
        $stmt ->bindValue(':category',$category);
        $stmt ->bindValue(':date',$date);
        $stmt ->bindValue(':author',$username);
        $stmt ->bindValue(':image',$image);
        $stmt ->bindValue(':slug',$slug);
        $execute = $stmt->execute();
        move_uploaded_file($_FILES["image"]["tmp_name"],$target);
        if ($execute) {
            $_SESSION["SuccessMessage"] = "Post Added Successfully.";
           // Redirect_to("categories.php");
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
    <?php
require_once 'includes/head.php';
    ?>
    <title>Create New Posts|<?php echo $app_name;?></title>
</head>
<body>
    <?php
require_once 'includes/header.php';
    ?>


<header class="bg-dark text-white py-3">

<div class="container">
<div class="row">
<div class="col-md-12">
<h1><i class="fas fa-edit text-info" ></i> Add New Post</h1>
</div>
</div>
</div>
</header>
<div class="container py-2 mb-4">
<div class="row">
<div class="offset-lg-1 col-lg-10" style="min-height:50px;">
<?php echo ErrorMessage();
      echo SuccessMessage();
      echo InfoMessage();
      ?>
<form action="create-post.php" method="post" enctype="multipart/form-data">
<div class="card  bg-secondary text-light mb-3">
<div class="card-header">
<h1>Add New Post</h1>

</div>
<div class="card-body bg-dark">
<div class="form-group">
<label for="title">Post Title : </label>
<input class="form-control" type="text" name="title" id="title" placeholder="Type title here">
</div>
<div class="form-group">
<label for="CategoryTitle">Choose Category : </label>
<select name="category" id="CategoryTitle" class="form-control">
<?php
global $pdo;
 $sql = "SELECT id,title FROM categories";
 $stmp = $pdo->query($sql);
 while ($data = $stmp->fetch()) {
     $id = $data["id"];
     $categoryName = $data["title"];
 echo "<option value=\"$categoryName \"> $categoryName</option>";
 }
?>


</select>
</div>

<div class="form-group mb1">
<div class="custom-file">
<input type="file" name="image" id="imageSelect" value="" class="custom-file-input">
<label for="ImageSelect" class="custom-file-label">Select Image</label>
</div>
</div>

<div class="form-group">
<label for="Post">Post  : </label>
<textarea name="text" class="form-control" id="Post" cols="80" rows="8"></textarea>
<script>
                        CKEDITOR.replace( 'text' );
                </script>
</div>

<button type="submit" class="btn btn-success btn-block" name="submit"><i class="fa fa-check"></i> Publish</button>


</div>
</div>
</form>
</div>
</div>
</div>

<?php
require_once 'includes/footer.php';
?>
</body>
</html>