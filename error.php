<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oops!!!</title>
    <style>
body{
    background-color:black;
    color:white;
    text-align:center;
}
    </style>
</head>
<body>
    
    <?php 
    require_once 'includes/function.php';

    echo php_slug("Hello World jhfj jhk");
// Program to display current page URL. 
  
$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 
                "https" : "http") . "://" . $_SERVER['HTTP_HOST'] .  
                $_SERVER['REQUEST_URI']; 
  

?> 
<p>The link <h2>"<?php echo $link?>"</h2> you are trying to visit is not available on this website</p>
</body>
</html>