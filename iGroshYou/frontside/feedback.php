<html>
	<head>
		<title>iGroshYou--Feedback</title>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"> 
		<script type="text/javascript" src="http://www.francescomalagrino.com/BootstrapPageGenerator/3/js/jquery-2.0.0.min.js"></script>
		<script type="text/javascript" src="http://www.francescomalagrino.com/BootstrapPageGenerator/3/js/jquery-ui"></script>
		<link href="http://www.francescomalagrino.com/BootstrapPageGenerator/3/css/bootstrap-combined.min.css" rel="stylesheet" media="screen">
		<script type="text/javascript" src="http://www.francescomalagrino.com/BootstrapPageGenerator/3/js/bootstrap.min.js"></script>

		<link rel="stylesheet" type="text/css" href="feedback.css">
	</head>
	<body class="bg1">
		<div class="container-fluid">
			<?php require_once('navbar.html'); ?>
			<div class="row-fluid">
				<div class="span4 offset4 bg2">
					<form class="form-signin form_style" id="feedbackform">
						<h1 class="form-signin-heading">Feedback</h1>
						<div class="control-group">
							<div class="controls">
								<textarea form="feedbackform" cols="150" rows="10"></textarea>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="inputEmail">Email</label>
							<div class="controls">
								<input id="inputEmail" type="email" />
							</div>
						</div>
						<div class="control-group">
							<div class="controls">
								<button class="btn" type="submit">Submit</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>    
	</body> 
</html>