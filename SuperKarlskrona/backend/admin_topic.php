<?php
require_once('../database/db_con.php');
require_once('../public/login_check.php');

if($_SESSION['username']!="admin"){
	header("Location:../backend/logout.php");
}

$result = $con->query("select * from topic;");

if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		echo "<tr><td>".$row['tid']."</td><td>".$row['name']."</td><td>".$row['like']."</td><td>".$row['dislike']."</td><td>".$row['color']."</td><td>".$row['description']."</td><td>".$row['code']."</td><td>".$row['uid']."</td></tr>";
	}
}

if(isset($_POST['tid'])){
	@$con->query("delete from topic where tid='".$_POST['tid']."';") or die('MySQL Error: ' . mysqli_error());
	@$con->query("delete from comment where tid='".$_POST['tid']."';") or die('MySQL Error: ' . mysqli_error());
	echo "<script language=JavaScript> location.replace(location.href);</script>";
}

?>
