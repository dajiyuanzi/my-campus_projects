<?php
require_once('../database/db_con.php');
require_once('../public/login_check.php');


$uid=$_SESSION['uid'];

$result = $con->query("select * from topic where uid=".$uid.";");

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
   		$popularity = $row["like"] - $row["dislike"];
     	echo "<div class='topicBox' style='background-color:".$row["color"].";' >";
      	echo "  <p><a href='../frontend/comment.php?tid=".$row['tid']."'>".$row["description"]."</a><br>Likes: <span id='liketid".$row['tid']."'>".$row["like"]."</span> Dislikes: <span id='disliketid".$row['tid']."'>".$row["dislike"]."</span> Popularity: <span id='popularityid".$row['tid']."'>$popularity</span></p>";
      	//echo "  <div style='margin-left: 12px; display: inline-block; ' onclick='like(".$row['tid'].");'><img style='width: 30px;' src='../assets/images/up.png'></div>";
      	//echo "  <div style='display: inline-block; width:20px;'></div>";
      	//echo "  <div style='display: inline-block;'  onclick='dislike(".$row['tid'].");'><img style='width: 30px;' src='../assets/images/down.png'></div>";
      	echo "</div>";
    }
}
else{
    echo "No Topics";
}

?>