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
		?>

		<div class="row-fluid">
			<div class="span12">
				<ul class="nav nav-tabs navbg">
					<?php
					  $page = "";

					  if (isset($_GET['page']))
					  {
					    if ($_GET['page'] != "")
					    {
					      $page = $_GET['page'];
					    }
					  }

						$pageTopic = "disabled";
						$pageTenant = "disabled";

						if ($page == "tenant") {
								$pageTenant = "active";
						}
						else {
							$pageTopic = "active";
						}

						echo
						'<li class="'.$pageTopic.'">
							<a href="../frontend/admin.php">Topic management</a>
						</li>
						<li class="'.$pageTenant.'">
							<a href="../frontend/admin.php?page=tenant">Advert management</a>
						</li>
						';
					?>

					<li class="dropdown pull-right">
						<a href="#" data-toggle="dropdown" class="dropdown-toggle">Menu<strong class="caret"></strong></a>
						<ul class="dropdown-menu">
							<li>
								<a href="../frontend/logmode.html">Main frame</a>
							<li class="divider">
							</li>
							<li>
								<a href="../backend/logout.php">Log Out</a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</div>


		<div class="row-fluid">
			<!--<form action="indexLogedin.php"><input type="submit" value="Go back" /></form>-->
			<a href="../frontend/indexLogedin.php"><button>Go Back</button></a>

			<?php
				$page ="";

			    if (isset($_GET['page']))
			    {
			      if ($_GET['page'] != "")
			      {
			        $page = $_GET['page'];
			      }
			    }

			    if($page=='tenant'){
			    	require_once('../frontend/admin_tenant.php');
			    }
			    else{
			    	require_once('../frontend/admin_topic.php');
			    }

			?>

		</div>

	</div>
	 <?php include_once 'qtdown.php';?>
</body>
