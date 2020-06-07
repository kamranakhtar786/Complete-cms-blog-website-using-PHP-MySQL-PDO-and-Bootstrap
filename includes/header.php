<?php
require_once 'includes/db.php';
date_default_timezone_set("Asia/Kolkata");
?>
<div class="bg-info" style="height:10px;"></div>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#"><?php echo $app_name;?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="../index.php"><i class="fa fa-home" ></i> Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../dashboard.php"><i class="fa fa-tachometer-alt" aria-hidden="true"></i> Dashboard</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../posts.php"><i class="fa fa-blog" aria-hidden="true"></i> Posts</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-plus"></i> Add New
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="../create-post.php">Add New Post</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="../categories.php">Add New Category</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="../comments.php">Approve Comments</a>
          <div class="dropdown-divider"></div>
          
        </div>
      </li>
      <li class="nav-item">
      <?php
if(empty($username)){
 echo  '<a class="nav-link" href="../register" tabindex="-1" ><span class="fa fa-user-plus"></span> Sign Up</a>';
 }else{
  echo  ' <a class="nav-link" href="../profile.php"><i class="fa fa-user"></i> My Profile</a>';
 }
       ?>
       
      </li>
      <li class="nav-item right">
       <?php
if(empty($username)){
 echo  '<a class="nav-link" href="../login" tabindex="-1" ><span class="fa fa-sign-in-alt"></span> Login</a>';
 }else{
  echo  '<a class="nav-link text-danger" href="?logout" tabindex="-1"><i class="fas fa-sign-out-alt"></i> Logout</a>';
 }
       ?>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0" method="get" action="../search">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="s">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>
<div class="bg-info" style="height:10px;"></div>