<?php

require_once('../database/db_con.php');
require_once('../public/login_check.php');

if($_SESSION['username']!="admin"){
	header("Location:../backend/logout.php");
}

$result = $con->query("select * from room;");

if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		echo "<tr><td>".$row['rid']."</td><td>".$row['address']."</td><td>".$row['description']."</td><td>".$row['contact']."</td><td>".$row['uid']."</td></tr>";
	}
}

if(isset($_POST['rid'])){
	@$con->query("delete from room where rid='".$_POST['rid']."';") or die('MySQL Error: ' . mysqli_error());
	@$con->query("delete from application where rid='".$_POST['rid']."';") or die('MySQL Error: ' . mysqli_error());
	echo "<script language=JavaScript> location.replace(location.href);</script>";
}

?>