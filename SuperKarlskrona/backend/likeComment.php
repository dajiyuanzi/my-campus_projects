<?php
require_once('../database/db_con.php');

if(isset($_POST['cid'])){
	if(isset($_COOKIE["setcookie".$_POST['cid'].""])){//judge cookie to prevent dupicate submission
    	echo "Have Done";
    }
    else{
    	$sql="select `like` from comment where cid='".$_POST['cid']."';";
		$result=$con->query($sql) or die('MySQL Error: ' . mysqli_error());
		$row=$result->fetch_assoc();

		$row['like']++;
		$sql="update comment set `like`='".$row['like']."' where cid='".$_POST['cid']."';";
		$result=$con->query($sql) or die('MySQL Error: ' . mysqli_error());

		setcookie("setcookie".$_POST['cid']."", "1", time()+72000000); //set cookie to prevent dupicate submission-Yuan Ji achieve this logic for fixing bugs

		echo $row['like'];
    }
}
else{
	die('MySQL Error: ' . mysqli_error());
}

?>
