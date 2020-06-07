<?php
$app_name = "Technolifehacker.com";

$db = "mysql:host=localhost;dbname=cms";

try{
    $pdo = new PDO($db,'root','');
}catch(PDOException $e){
    echo $e->getMessage().":: Catch";
}


?>