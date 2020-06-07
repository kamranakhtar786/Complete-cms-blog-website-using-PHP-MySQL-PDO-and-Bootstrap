<!-- card1 -->
<div class="card mt-3">
<div class="card-header bg-primary text-light">
<h2 class="lead">categories</h2>
</div>
<div class="card-body">
<?php
 global $pdo;
 $sql = "SELECT * FROM categories";
 $stmp = $pdo->query($sql);
 
 while ($data = $stmp->fetch()) {
     $id = $data["id"];
     $title  = $data["title"];
     $title_no_space = str_replace(" ","-",$title);

?>
<a href="../category/<?php echo $title_no_space;?>"><span class="heading"><?php echo $title;?></span></a><br>
 <?php }?>
</div>
</div>
<!-- card2 -->
<div class="card mt-3">
<div class="card-header bg-info text-white">
<h2 class="lead">Recent Posts</h2>
</div>
<div class="card-body">
<?php
global $pdo;
$sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
$stmt = $pdo->query($sql);
while ($data = $stmt->fetch()) {
    $id = $data["id"];
    $title = $data["title"];
    $title = substr($title,0,30)."...";
    $slug = $data["slug"];
    $date = $data["date"];
    $image = $data["image"];
    $date = date("M-d-Y h:m:s",$date);
?>
<div class="media">
<img src="../uploads/<?php echo $image;?>" class="d-block img-fluid align-self-start" alt="" width="90" height="94">
<div class="media-body ml-2">
<a href="../blog/<?php echo $slug;?>" target="_blank"><h6 class="lead"><?php echo $title;?></h6></a>
<p class="small"><?php echo $date;?></p>
</div>
</div>
<hr>
<?php } ?>
</div>
</div>
<!-- card3 -->
<div class="card mt-3">
<div class="card-header bg-primary text-light">
<h2 class="lead">Tags</h2>
</div>
<div class="card-body ">
<?php
 global $pdo;
 $sql = "SELECT * FROM posts";
 $stmp = $pdo->query($sql);
 
 while ($data = $stmp->fetch()) {
     $tags = $data["tags"];
     $tags = explode(",",$tags);
foreach($tags as $tag){
  $tag_no_space = str_replace(" ","-",$tag);

?>


    <a class="badge badge-primary text-wrap p-1 m-1 text-capitalize " href="../tag/<?php echo $tag_no_space ?>"><?php echo $tag;?>
</a>

 <?php } }?>
</div>
</div>
  
