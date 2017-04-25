<html>
	<head>
		<title>iGroshYou--Admin</title>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"> 
		<script type="text/javascript" src="http://www.francescomalagrino.com/BootstrapPageGenerator/3/js/jquery-2.0.0.min.js"></script>
		<script type="text/javascript" src="http://www.francescomalagrino.com/BootstrapPageGenerator/3/js/jquery-ui"></script>
		<link href="http://www.francescomalagrino.com/BootstrapPageGenerator/3/css/bootstrap-combined.min.css" rel="stylesheet" media="screen">
		<script type="text/javascript" src="http://www.francescomalagrino.com/BootstrapPageGenerator/3/js/bootstrap.min.js"></script>

		<link rel="stylesheet" type="text/css" href="admin.css">
	</head>
	<body class="bg1">
		<div class="container-fluid">
			<?php require_once('navbar.html'); ?>
			
			<div class="row-fluid">
				<div class="span8 offset2 bg2">
					<form class="form-signin form_style">
						<div class="inputbg">
							<fieldset>
								<legend>Admin: Food Update</legend>
								<label>Food Name</label>
			                    <input type="text" name="fdname" />

								<label>Put Calorie value</label>
			                    <input type="number" name="calorie" />

			                    <label>Protein value</label>
			                    <input type="number" name="protein" />
			                     
			                    <label>Carb value</label>
			                    <input type="number" name="carb" />
			                     
			                    <label>Fat value</label>
			                    <input type="number" name="fat" />
							</fieldset>
						</div>
						<br/>
						<button class="btn" type="submit">Update</button>			
					</form>
				</div>
			</div>
		</div>    
	</body> 
</htm