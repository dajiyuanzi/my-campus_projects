<script type="text/javascript" src="../public/likedislike_ajax.js"></script>
<script type="text/javascript" src="../public/likedislikeComment_ajax.js"></script>


<?php
include_once('../database/db_con.php');
require_once('../public/login_check.php');

$tid=$_GET['tid'];
$uid=$_SESSION['uid'];

$sql = 	"SELECT `tid`, `color`, `description`, `like`, `dislike`, `dateTimeStamp` FROM `topic` where tid='".$tid."';";
$color = "";
$result = $con->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    echo "<div class='topicBox' style='background-color:".$row["color"].";' >";
    echo "  <div style=''>".$row["dateTimeStamp"]."</div>";
    echo "  <p><a href='../frontend/comment.php?tid=".$row['tid']."'>".htmlspecialchars($row["description"])."</a><br>Likes: <span id='liketid".$row['tid']."'>".$row["like"]."</span> Dislikes: <span id='disliketid".$row['tid']."'>".$row["dislike"]."</span></p>";
    echo "  <div style='margin-left: 12px; display: inline-block; ' onclick='like(".$row['tid'].");'><img style='width: 30px;' src='../assets/images/up.png'></div>";
    echo "  <div style='display: inline-block; width:20px;'></div>";
    echo "  <div style='display: inline-block;'  onclick='dislike(".$row['tid'].");'><img style='width: 30px;' src='../assets/images/down.png'></div>";
    echo "</div>";
    $color = $row["color"];
  }
} else {
  echo "Something went wrong!";
}

echo "<br><legend>Comments: </legend>";


$result = $con->query("select `cid`, `comment`, `like`, `dislike`, `dateTimeStamp` from comment where tid='".$tid."';");

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      	echo "<div class='topicBox' style='background-color:$color;' >";
        echo "  <div style=''>".$row["dateTimeStamp"]."</div>";
      	//echo "  <p>".$_SESSION["username"].":</p><br>";
      	echo "  <p>".htmlspecialchars($row["comment"])."<br>";
        echo "  Likes: <span id='likecid".$row['cid']."'>".$row["like"]."</span> Dislikes: <span id='dislikecid".$row['cid']."'>".$row["dislike"]."</span></p>";
        echo "  <div style='margin-left: 12px; display: inline-block; cursor: pointer;' onclick='likeComment(".$row['cid'].");'><img style='width: 30px;' src='../assets/images/up.png'></div>";
        echo "  <div style='display: inline-block; width:20px;'></div>";
        echo "  <div style='display: inline-block; cursor: pointer;'  onclick='dislikeComment(".$row['cid'].");'><img style='width: 30px;' src='../assets/images/down.png'></div>";
      	echo "</div>";
    }
}
else {
   	echo "<div class='topicBox' style='background-color:white;' >";
    echo "  <p>No Comments</p><br>";
    echo "</div>";
}

if(isset($_POST['comment'])&&!empty($_POST['comment'])){
	$comment=$_POST['comment'];
	$sql = "INSERT INTO comment(tid, uid, comment) VALUES ('".$tid."', '".$uid."', '".$comment."');";
    if (!$con->query($sql)) {
        echo 'Mysql error: ' . mysql_error();
        exit;
    }
    //header("Location:../frontend/comment.php?tid=".$tid."");
		//replace with below to fix header already sent issue
		echo("<script>location.href = '../frontend/comment.php?tid=".$tid."';</script>");
}

?>
