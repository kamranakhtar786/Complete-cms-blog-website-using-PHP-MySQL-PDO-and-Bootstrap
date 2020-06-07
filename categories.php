<?php
session_start();

require_once 'includes/function.php';
require_once 'includes/db.php';
require_once 'includes/session.php';
$username = $_SESSION["username"]; //UserName
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
    <?php
require_once 'includes/head.php';
    ?>
    <title>Manage Category | <?php echo $app_name;?></title>
</head>
<body>
    <?php
require_once 'includes/header.php';
    ?>
<?php
if (isset($_POST["submit"])) {
    $category = $_POST["Category"];
    
    if (empty($category)) {
        $_SESSION["ErrorMessage"] = "All field must be field out!";
        
    }
    else {
        global $pdo;
        $sql = "INSERT INTO categories(id,title,author)";
        $sql .= "VALUES(:id,:category , :username)";
        $stmt = $pdo->prepare($sql);
        $stmt ->bindValue(':id',NULL);
        $stmt ->bindValue(':category',$category);
        $stmt ->bindValue(':username',$username);
       
        $execute = $stmt->execute();
        if ($execute) {
            $_SESSION["SuccessMessage"] = "Category Added Successfully.";
           // Redirect_to("categories.php");
        }
        else {
            $_SESSION["ErrorMessage"] = "Something went wrong!";
           // Redirect_to("categories.php");
        }
    }
}

?>

<header class="bg-dark text-white py-3">
<div class="container">
<div class="row">
<div class="col-md-12">
<h1><i class="fas fa-edit text-info" ></i> Manage Categories</h1>
</div>
</div>
</div>
</header>
<div class="container py-2 mb-4">
<div class="row">
<div class="offset-lg-1 col-lg-10" style="min-height:50px;">
<?php
echo SuccessMessage();
echo ErrorMessage();
?>
<form action="categories.php" method="post">
<div class="card  bg-secondary text-light mb-3">
<div class="card-header">
<h1>Add New Category</h1>
</div>
<div class="card-body bg-dark">
<div class="form-group">
<label for="Categorytitle">Category Title : </label>
<input class="form-control" type="text" name="Category" id="Categorytitle" placeholder="Type title here" >
</div>
<div class="row" style="min-height:50px;">
<div class="col-lg-6 mb-2 text-light">
<a href="dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Dashboard</a>
</div>
<div class="col-lg-6 mb-2">
<button type="submit" class="btn btn-success btn-block" name="submit"><i class="fas fa-check"></i> Publish</button>

</div>
</div>

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


