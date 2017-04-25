<html>
	<head>
		<title>iGroshYou--Profile</title>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"> 
		<script type="text/javascript" src="http://www.francescomalagrino.com/BootstrapPageGenerator/3/js/jquery-2.0.0.min.js"></script>
		<script type="text/javascript" src="http://www.francescomalagrino.com/BootstrapPageGenerator/3/js/jquery-ui"></script>
		<link href="http://www.francescomalagrino.com/BootstrapPageGenerator/3/css/bootstrap-combined.min.css" rel="stylesheet" media="screen">
		<script type="text/javascript" src="http://www.francescomalagrino.com/BootstrapPageGenerator/3/js/bootstrap.min.js"></script>

		<link rel="stylesheet" type="text/css" href="profile.css">
	</head>
	<body class="bg1">
		<div class="container-fluid">
			<?php require_once('navbar.html'); ?>
			<div class="row-fluid">
				<div class="span4 offset1 bg2">
					<form class="form-signin form_style">
						<h1 class="form-signin-heading">Profile</h1>
						<label class="control-label" for="inputEmail">Email</label>
						<input id="inputEmail" type="email" />
						<label class="control-label" for="inputPassword">Password</label>
						<input id="inputPassword" type="password" />
						<label class="control-label" for="inputgender">Gender</label>
						Male:<input id="inputgender" type="radio" name="gender" value="male" />
						Female:<input id="inputgender" type="radio" name="gender" value="female" />
						<label class="control-label" for="inputweight">Weight(KG)</label>
						<input id="inputweight" type="number" />
						<label class="control-label" for="inputheight">Height(CM)</label>
						<input id="inputheight" type="number" />
						<label class="control-label" for="dislike">Dislike Food</label>
						<div id="dislike" style="width:200px; height:80px; overflow:scroll;"> 
						<!--Disliked food is generated from backside-->
							haha<input type="checkbox" value="haha"><br/>
							haha<input type="checkbox" value="haha"><br/>
							haha<input type="checkbox" value="haha"><br/>
							haha<input type="checkbox" value="haha"><br/>
							haha<input type="checkbox" value="haha"><br/>
							haha<input type="checkbox" value="haha"><br/>
						</div>
						<br/>
						<button class="btn" type="submit">Alter</button>			
					</form>
				</div>
			</div>
		</div>    
	</body> 
</html>