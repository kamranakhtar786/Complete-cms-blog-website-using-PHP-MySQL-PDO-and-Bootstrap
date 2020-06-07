<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap/css/style.css">
    <link rel="stylesheet" href="../bootstrap/css/styles.css">
    <link rel="stylesheet" href="../fontawesome/css/all.css">
    <link rel="stylesheet" href="includes/style.css">
    <script src="../bootstrap/js/jquery.min.js"></script>
    <script type="text/javascript" src="../ckeditor/ckeditor.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
 <?php
if(isset($_GET["logout"])){
    session_destroy();
    Redirect_to("login.php");
  }
 ?>