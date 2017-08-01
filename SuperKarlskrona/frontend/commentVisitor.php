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
		require_once('../public/nav.php');
	?>
	<div class="row-fluid">
	<!--<form action="indexLogedin.php"><input type="submit" value="Go back" /></form>-->
	<a href="../frontend/index.php"><button>Go Back</button></a>
	<br/><br/>
	<a href="../backend/login.php" id="login" >Login</a> / <a href="../backend/register.php">Register</a> to be able to comment on topics

	<br/><br/>

		<?php require_once('../backend/commentVisitor.php'); ?>

		<br>
		<br>
		</div>
	</div>
	 <?php include_once 'qtdown.php';?>
</body>
