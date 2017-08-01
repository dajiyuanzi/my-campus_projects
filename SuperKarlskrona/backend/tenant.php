<?php
include_once('../database/db_con.php');
require_once('../public/login_check.php');


if(isset($_GET['act'])&&$_GET['act']=="publish"){
	if(isset($_POST['address'])&&isset($_POST['description'])&&isset($_POST['contact'])&&isset($_SESSION['uid'])){
		$sql="insert into room(address, description, contact, uid) values('".$_POST['address']."', '".$_POST['description']."', '".$_POST['contact']."', '".$_SESSION['uid']."');";
		$con->query($sql);
		unset($_GET['act']);
		echo "<script language=JavaScript> location.replace(location.href);</script>";
	}
	else{
		//echo "<script>alert('Please Fill Form');</script>";
	}
}
elseif(isset($_GET['act'])&&$_GET['act']=="apply") {
	if(isset($_POST['description'])&&isset($_POST['contact'])&&isset($_POST['rid'])&&isset($_SESSION['uid'])){
		$result = $con->query("select * from room where rid='".$_POST['rid']."';");
		if($result->num_rows > 0){
			$sql="insert into application(description, contact, rid, uid) values('".$_POST['description']."', '".$_POST['contact']."', '".$_POST['rid']."', '".$_SESSION['uid']."');";
			$con->query($sql);
			unset($_GET['act']);
			echo "<script language=JavaScript> location.replace(location.href);</script>";
		}
		else{
			echo "<script>alert('Please Choose Available Room ID');</script>";
		}
	}
	else{
		//echo "<script>alert('Please Fill Form');</script>";
	}
}
elseif(isset($_GET['act'])&&$_GET['act']=="close") {
	$con->query("delete from application where rid=(select rid from room where uid='".$_SESSION['uid']."');") or die('MySQL Error: ' . mysqli_error());
	// room has to be deleted later or application cannot be deleted!!!!
	$con->query("delete from room where uid='".$_SESSION['uid']."';") or die('MySQL Error: ' . mysqli_error());

	unset($_GET['act']);
	header("Location:../frontend/tenant.php");
}


?>
