<?php
require_once('../database/db_con.php');

if(isset($_POST['username'])&&isset($_POST['password'])){
	$sql="select * from user where name='".$_POST['username']."' and code=".$_POST['password'].";";
	$result=$con->query($sql) or die('MySQL Error: ' . mysqli_error());
	$row=$result->fetch_assoc();

	if (!$row) {
		echo "<script>alert('Wrong username or password');</script>";
	}
	else{
		if(!isset($_SESSION)){
			session_start();
	        $_SESSION['username']=$row['name'];
	        $_SESSION['email']=$row['email'];
	        $_SESSION['uid']=$row['uid'];
	        $_SESSION['password']=$row['code'];
	        if($_SESSION['username']=="admin"){
	        	header("Location:../frontend/admin.php");
	        }
	        else{
	        	header("Location:../frontend/indexLogedin.php");
	        }
		}
	}
}

?>

<title>Login - Super Karlskrona</title>
<link href="../assets/css/style.css" rel="stylesheet" type="text/css" />

<h1 class="title">Super Karlskrona</h1>

<div class="log">
	<div class="log1">
		<div class="innerbut">
			<a href="../frontend/index.php"><button>Go Back</button></a>
			<br>
			<br>
		</div>
		<div class="innerLog">
			Login
			<form action="../backend/login.php" method="post">
				<p>
					<label for="username" class="label">Username:</label>
					<br>
					<input id="username" name="username" type="text" class="input" />
				<p/>
				<p>
					<label for="password" class="label">Password</label>
					<br>
					<input id="password" name="password" type="password" class="input" />
				<p/>
				<p>
					<input type="submit" name="login" value="Login" class="left" />
					<br>
					<br>
					Not a member yet? <a href="../backend/register.php">Register</a>
				</p>
			</form>
		</div>
	 </div>
  </div>
