<link href="../assets/css/style.css" rel="stylesheet" type="text/css" />

<body class="bg1">

	<img src="../assets/images/header2.png" style="height: 170px; width: 100%;">
<div style="text-align: center;
  font-size: 40px;
  padding: 19px;
  font-weight: 800;
  color: hotpink;">Super Karlskrona</div>
	<div class="container-fluid">

	<?php
		require_once('../public/head.php');
		require_once('../public/navLogedin.php');
	?>
	<div class="row-fluid">
    	<a href="../frontend/indexLogedin.php"><button>Go Back</button></a>
	<br/><br/>

    <script type="text/javascript" >
function validate(){
 var username = document.getElementsByName("username")[0];
 var password = document.getElementsByName("password")[0];
 var password2 = document.getElementsByName("password2")[0];
 var email = document.getElementsByName("email")[0];

 if(username.value.length < 1){
     alert("Enter your new name please!");
     return false;

 } else if(username.value.length > 10){

 	alert("The new name should be less than 10!");
     return false;
 }

   if(password.value.length < 1){

     alert("Enter your new password please!");
     return false;

  } else if(password.value.length > 20){

 	alert("The password should be less than 20!");
     return false;
 }
    if(password2.value.length < 1){

     alert("Enter your new password again please!");
     return false;


  } else if(password2.value.length > 20){

 	alert("The password should be less than 20!");
     return false;
 }

 if(password.value!=password2.value){
 	alert("The password input should be same!");
    return false;
 }

  if(email.value.length < 1){

     alert("Enter your new email please!");
     return false;

 } else if(email.value.length > 20){

 	input.password="";
 	alert("The email should be less than 20!");
    return false;
 }
    return true;
 }
</script>


		<?php require_once('../backend/profile.php'); ?>

		<br>
		<br>
		<legend>Alter Profile</legend>
		<form method="post" action="../frontend/profile.php">
			<p>
				<label for="username" class="label">New User Name:</label>
				<input id="username" name="username" type="text" class="input" />
			<p/>
			<p>
				<label for="password" class="label">New Password</label>
				<input id="password" name="password" type="password" class="input" />
			<p/>
            <p>
				<label for="email" class="label">New Email</label>
				<input id="email" name="email" type="email" class="input" />
		  	<p/>
			<p>
				<label for="birthday" class="label">Change birthday</label>
				<input id="birthday" type="date" name="birthday" />
		  <p/>
			<p>
				<input type="submit" name="profile" value="Alter" class="left" />
			</p>
		</form>

	</div>
	 <?php include_once 'qtdown.php';?>
</body>
