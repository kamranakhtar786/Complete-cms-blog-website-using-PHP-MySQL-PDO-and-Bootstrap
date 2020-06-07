<?php
function Redirect_to($New_Location){
    header("Location:".$New_Location);
    exit;
}
function php_slug($string){
    $slug = preg_replace('/[^a-z0-9-]+/','-',strtolower($string));
    return $slug;
}

function clean($string) {
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
    $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
 $string =  preg_replace('/-+/', '-', strtolower($string)); // Replaces multiple hyphens with single one.
 $lastLetter =  substr($string, -1);
 if($lastLetter == "-"){
     return substr($string, 0, -1);
}else{
    return $string;
}
 }

 function randomString($length,$string1,$string2){
   
    $character = $string1.$string2;
    $characterlength = strlen($character);
    $randomString ='';
    for($i = 0 ; $i< $length ; $i++){
        $randomString .= $character[rand(0,$characterlength - 1)];

    }
    return $randomString;
}

?>