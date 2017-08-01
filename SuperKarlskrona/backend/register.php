<?php
require_once('../database/db_con.php');

$username = "";
$birthday = "";
$email = "";
$password = "";

if(isset($_POST['username'])&&isset($_POST['birthday'])&&isset($_POST['email'])&&isset($_POST['password'])){
	$username=$_POST['username'];
	$birthday=$_POST['birthday'];
	$email=$_POST['email'];
	$password=$_POST['password'];
}


if($username != "")
{
    $result = $con->query("SELECT * FROM user WHERE name='".$username."';");
    if ($result && $result->num_rows > 0)
    {
        echo "<script>alert('This username has bee used! Try another!');</script>";
    }
    else
    {
        $sql = "INSERT INTO user(name, birthday ,email, code) VALUES ('".$username."', '".$birthday."', '".$email."', '".$password."');";
        if (!$con->query($sql)) {
            echo 'Mysql error: ' . mysql_error();
            exit;
        } else {
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
										$_SESSION['birthday']=$row['birthday'];
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
        }
        header("Location:../frontend/indexLogedin.php");
    }
}

?>

<title>Register - Super Karlskrona</title>
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
			Register
			<form action="../backend/register.php" method="post">
				<p>
					<label for="username" class="label">Username:</label>
					<br>
					<input id="username" name="username" type="text" class="input" />
				<p/>
        <p>
          <label for="birthday" class="label">Birthday</label>
					<br>
					<input id="birthday" type="date" name="birthday" />
				<p/>
				<p>
					<label for="email" class="label">Email</label>
					<br>
					<input id="email" name="email" type="email" class="input" />
				<p/>
			  <p>
					<label for="password" class="label">Password</label>
					<br>
					<input id="password" name="password" type="password" class="input" />
				<p/>
				<p>
					<input type="submit" name="register" value="Register" class="left" />
					<br>
					<br>
					Already a member? <a href="../backend/login.php">Login</a>
			  </p>
			</form>
