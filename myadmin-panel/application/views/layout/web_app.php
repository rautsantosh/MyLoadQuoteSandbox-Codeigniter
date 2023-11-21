<!DOCTYPE html>
<html lang="en">
    <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">	
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="<?php echo base_url() ?>assets/images/fevicon.png">    
	<title>My Loan Quote | Admin Panel</title>
	<link href="<?php echo base_url(); ?>assets/component/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo base_url(); ?>assets/component/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css"/>	
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<script src="<?php echo base_url(); ?>assets/component/jquery/jquery-1.12.4.min.js" type="text/javascript"></script>		
	<script type="text/javascript"> var BASEURL = "<?php echo base_url() ?>"; </script>
    </head>
    <body>	
	<nav class="navbar navbar-inverse navbar-fixed-top">
	    <div class="container-fluid">
		<div class="navbar-header">
		    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		    </button>
		    <a class="navbar-brand" href="#"><img height="30" src="<?php echo base_url() ?>assets/images/logo.png" alt=""/></a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
		    <ul class="nav navbar-nav">
			<li class="<?php echo ($active_menu == 1) ? "active" : ""; ?>"><a href="<?php echo base_url(); ?>"><i class="glyphicon glyphicon-dashboard"></i> Dashboard</a></li>
			<li class="<?php echo ($active_menu == 2) ? "active" : ""; ?>"><a href="<?php echo base_url("leads"); ?>"><i class="glyphicon glyphicon-tasks"></i> Lead Information</a></li>
			<!-- <li class="<?php echo ($active_menu == 3) ? "active" : ""; ?>"><a href="<?php echo base_url(); ?>"><i class="glyphicon glyphicon-user"></i> Users</a></li> -->
		    </ul>
		    <ul class="nav navbar-nav navbar-right">
			<li class="dropdown">
			    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Hi <?php echo ucwords(strtolower($user->Name)); ?> <span class="caret"></span></a>
			    <ul class="dropdown-menu">				
				<li role="separator" class="divider"></li>
				<li><a href="<?php echo base_url("logout"); ?>"><i class="glyphicon glyphicon-log-out"></i> Logout</a></li>
			    </ul>
			</li>						
		    </ul>		    
		</div>
		<div class="clearfix"></div>
	    </div>
	</nav>	
	<div class="container-fluid">
	    <div class="row">
		<p>&nbsp;</p>
		<div class="col-lg-12 col-md-12 col-sm-12 main-container">
		    <div class="panel panel-default">
			<div class="panel-body">
			    <div><?php echo $yield; ?></div>
			</div>
		    </div>
		</div>
	    </div>	    
	</div>	
	<footer>
	    
	</footer>
	<script src="<?php echo base_url(); ?>assets/component/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>	
    </body>
</html>
