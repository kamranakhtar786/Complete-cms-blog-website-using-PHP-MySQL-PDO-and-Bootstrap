<?php
session_start();
require_once 'includes/db.php';
require_once 'includes/session.php';
require_once 'includes/function.php';
$username = $_SESSION["username"];
global $pdo;
if (empty($username)) {
  $_SESSION["InfoMessage"]="Please login first!!";
  Redirect_to("login.php");
  
}
if(isset($_GET["logout"])){
  session_destroy();
  
}
 
if (isset($_POST["approve"])) {
  $username = $_SESSION["username"];
   $CommentId = $_POST['CommentId'];
  $sql_approve = "UPDATE `comments` SET `approved_by` = '$username' , `status` = '1' WHERE `comments`.`id` = '$CommentId'";
  $Execute = $pdo->query($sql_approve);
  if($Execute){
   $_SESSION["SuccessMessage"] = "Comment Approved Successfully";
  }else{
    $_SESSION["ErrorMessage"] = "Something went wrong!";
  }

}

if (isset($_POST["disapprove"])) {
  $username = $_SESSION["username"];

  $CommentId = $_POST['CommentId'];
  $sql_disapprove = "UPDATE `comments` SET `disapprove_by` = '$username' ,`status` = '0' WHERE `comments`.`id` = '$CommentId'";
  $Execute = $pdo->query($sql_disapprove);
  if($Execute){
   $_SESSION["SuccessMessage"] = "Comment DisApproved Successfully";
  }else{
    $_SESSION["ErrorMessage"] = "Something went wrong!";
  }

}
if (isset($_POST["delete"])) {
  $CommentId = $_POST['CommentId'];
  $sql_delete = "DELETE FROM comments  WHERE id = $CommentId";
  $Execute = $pdo->query($sql_delete);
  if($Execute){
    $_SESSION["SuccessMessage"] = "Comment Delete Successfully";
   }else{
     $_SESSION["ErrorMessage"] = "Something went wrong!";
   }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php
require_once 'includes/head.php';
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Comments</title>
</head>
<body>
<?php include_once 'includes/header.php';
?>
<div class="bg-dark text-white py-3 mb-3">
<div class="container">

<div class="row">
<h1 class="col-md-12"><i class="fa fa-comments text-info"></i>&nbsp;&nbsp;Manage Comments</h1>
</div>
</div>
</div>
<!-- Header close here -->
<section class="container py-2 mb-4">
<?php
echo ErrorMessage();
echo SuccessMessage();
echo InfoMessage();
?>
<!-- unapproved comment -->
<div class="row" style="min-height:30px">

<div class="col-lg-12" style="min-height:200px">

<h2>Un-Approve Comments</h2>
<table class="table table-striped table-hover">
<thead class="thead-dark">
<tr>
<th>No.</th>
<th>Name</th>
<th>Date</th>
<th>Comment</th>
<th>Approve</th>
<th>Delete</th>
<th>Preview</th>
</tr>
</thead>


<?php
$sql = "SELECT * FROM comments WHERE status = '0' ORDER BY id desc";
$Execute = $pdo->query($sql);
$SrNo = 0;
date_default_timezone_set("Asia/Kolkata");
while ($data = $Execute->fetch()) {
  $CommentId = $data["id"];
  $date = $data["date"];
  $date = date("M-d-y h:m:s A",$date);
  $Commenter = $data["name"];
  $CommentContent = $data["text"];
  $CommentPostId = $data["post_id"];
  $CommentPostSlug = $data["post_slug"];
  $SrNo++;
if(strlen($Commenter) >10){$Commenter = substr($Commenter,0,10).'..';}
if(strlen($date) >11){$date = substr($date,0,11).'..';}


?>
<tbody>
<tr>
<td><?php echo htmlentities($SrNo);?></td>
<td><?php echo htmlentities($Commenter);?></td>
<td><?php echo htmlentities($date); ?></td>
<td><?php echo htmlentities($CommentContent); ?></td>
<td><form action="comments.php" method="post"><input type="hidden" name="CommentId" value="<?php echo $CommentId;?>"> <button type="submit" name="approve"  class="btn btn"><i class="fas fa-check" style="color:green"></i></button></form></td> 
<td><form action="comments.php" method="post"><input type="hidden" name="CommentId" value="<?php echo $CommentId;?>"> <button type="submit" name="delete" class="btn btn"><i class="fas fa-trash-alt" style="color:red"></i></button></form></td> 
<td><a href="/blog/<?php echo $CommentPostSlug."#comment-".$CommentId;?>"><i class="fas fa-eye"></i> </a> </td>
</tr>
</tbody>
<?php } ?>
</table>
</div>
<!-- Un-Approved comment -->
<!-- Approved Comment -->
<div class="col-lg-12" style="min-height:200px">

<h2>Approved Comments</h2>
<table class="table table-striped table-hover">
<thead class="thead-dark">
<tr>
<th>No.</th>
<th>Name</th>
<th>Date</th>
<th>Comment</th>
<th>DisApprove</th>
<th>Delete</th>
<th>Preview</th>
</tr>
</thead>


<?php
$sql = "SELECT * FROM comments WHERE status = '1' ORDER BY id desc";
$Execute = $pdo->query($sql);
$SrNo = 0;
date_default_timezone_set("Asia/Kolkata");
while ($data = $Execute->fetch()) {
  $CommentId = $data["id"];
  $date = $data["date"];
  $date = date("M-d-y h:m:s A",$date);
  $Commenter = $data["name"];
  $CommentContent = $data["text"];
  $CommentPostId = $data["post_id"];
  $CommentPostSlug = $data["post_slug"];
  $SrNo++;
if(strlen($Commenter) >10){$Commenter = substr($Commenter,0,10).'..';}
if(strlen($date) >11){$date = substr($date,0,11).'..';}


?>
<tbody>
<tr>
<td><?php echo htmlentities($SrNo);?></td>
<td><?php echo htmlentities($Commenter);?></td>
<td><?php echo htmlentities($date); ?></td>
<td><?php echo htmlentities($CommentContent); ?></td>
<td><form action="comments.php" method="post"><input type="hidden" name="CommentId" value="<?php echo $CommentId;?>"> <button type="submit" name="disapprove"  class="btn btn"><i class="fas fa-times" style="color:red"></i></button></form></td> 
<td><form action="comments.php" method="post"><input type="hidden" name="CommentId" value="<?php echo $CommentId;?>"> <button type="submit" name="delete" class="btn btn"><i class="fas fa-trash-alt" style="color:red"></i></button></form></td> 
<td><a href="/blog/<?php echo $CommentPostSlug."#comment-".$CommentId;?>"><i class="fas fa-eye"></i> </a> </td>
</tr>
</tbody>
<?php } ?>
</table>
</div>
<!-- Approved comments -->
</div>
</section>

</body>
</html>