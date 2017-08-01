<html>
	<link href="../assets/css/style.css" rel="stylesheet" type="text/css" />
	<?php require_once('../public/head.php'); ?>

	<script type="text/javascript" src="../public/likedislike_ajax.js"></script>
	<body class="bg1">

	<img src="../assets/images/header2.png" style="height: 170px; width: 100%;">
	<div style="text-align: center;
		font-size: 40px;
		padding: 19px;
		font-weight: 800;
		color: hotpink;">Super Karlskrona</div>


	<div class="container-fluid">

		<?php require_once('../public/nav.php'); ?>
		<div class="row-fluid">
			<div class="span9">

				<div class="addtopicbutton">
					<a href="../backend/login.php" id="login" >Login</a> / <a href="../backend/register.php">Register</a> to be able to add topics
					<br><br>
				</div>


				<?php require_once('../backend/topicsVisitor.php'); ?>


			</div>
			<div class="sidepanel span3">

							<?php
								echo "Today is " . date("l") . " " . date("Y-m-d") . "<br>";
							?>

							<br>
							<a href="https://www.accuweather.com/en/us/new-york-ny/10007/weather-forecast/349727" class="aw-widget-legal">
							<!--
							By accessing and/or using this code snippet, you agree to AccuWeather’s terms and conditions (in English) which can be found at https://www.accuweather.com/en/free-weather-widgets/terms and AccuWeather’s Privacy Statement (in English) which can be found at https://www.accuweather.com/en/privacy.
							-->
							</a><div id="awcc1495544082354" class="aw-widget-current"  data-locationkey="" data-unit="c" data-language="en-us" data-useip="true" data-uid="awcc1495544082354"></div><script type="text/javascript" src="https://oap.accuweather.com/launch.js"></script>

							<legend>Adverts</legend>



							<div class="addtenantbutton">
								<a href="../backend/login.php" id="login" >Login</a> / <a href="../backend/register.php">Register</a> to be able to add adverts or mark interest
								<br><br>
							</div>

							<?php require_once('../backend/advertVisitor.php'); ?>

				</div>

		</div>
	</div>


	 <?php include_once 'qtdown.php';?>
	</body>
</html>
