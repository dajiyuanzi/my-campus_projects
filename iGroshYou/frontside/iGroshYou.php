<html>
	<head>
		<title>iGroshYou--Home Page</title>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"> 
		<script type="text/javascript" src="http://www.francescomalagrino.com/BootstrapPageGenerator/3/js/jquery-2.0.0.min.js"></script>
		<script type="text/javascript" src="http://www.francescomalagrino.com/BootstrapPageGenerator/3/js/jquery-ui"></script>
		<link href="http://www.francescomalagrino.com/BootstrapPageGenerator/3/css/bootstrap-combined.min.css" rel="stylesheet" media="screen">
		<script type="text/javascript" src="http://www.francescomalagrino.com/BootstrapPageGenerator/3/js/bootstrap.min.js"></script>

		<link rel="stylesheet" type="text/css" href="iGroshYou.css">
	</head>
	<body class="bg1">
	<div class="container-fluid">
		<?php require_once('navbar.html'); ?>
		<div class="row-fluid">
			<div class="span4 bg2">
				<form class="form_style">
					<fieldset>
						<h2>Create list</h2>

	                    <label>Put Calorie value</label>
	                    <input type="number" />

	                    <label>Protein value</label>
	                    <input type="number" />
	                     
	                    <label>Carb value</label>
	                    <input type="number" />
	                     
	                    <label>Fat value</label>
	                    <input type="number" />
	                    <br/>
	                    <br/>

	                    <button type="submit" class="btn">Submit</button>
					</fieldset>
				</form>
			</div>
			<div class="span8 bg3">
				<h2>Generated Grocery List</h2>
	            <div id="output" class="bg4"> 
	            	<!--The food list is to be displayed in this DIV-->
	            </div>
	            <button id="send" class="btn">Send List to Mail</button>
	            <button id="dislike" class="btn">Dislike This List</button>
			</div>
		</div>
	</div>
	</body>
</html>
