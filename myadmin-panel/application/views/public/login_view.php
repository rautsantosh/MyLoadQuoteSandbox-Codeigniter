<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Lead System Login</title>
	<link href="<?php echo base_url() ?>assets/component/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo base_url() ?>assets/component/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo base_url() ?>assets/css/login.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
	<div class="container">
	    <div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12">
		    <div class="col-sm-4 col-sm-offset-4">
			<div class="panel panel-default loginpanel">
			    <div class="panel-heading panel-title">Sign In</div>
			    <div class="panel-body">
				<div class="col-md-12 col-sm-12">
				    <form class="form-horizontal" novalidate="" data-toggle="validator" role="form" method="post">
					<?php echo '<div class="text-danger form-group">' . $message . '</div>'; ?>
					<div class="form-group <?php echo ($has_error) ? "has-error" : ""; ?>">
					    <label class="control-label" for="email">Email:</label>
					    <input type="email" class="form-control" id="Email" name="Email" placeholder="Enter email" autocomplete="off" autofocus="" required="" value="<?php $email ?>">					
					</div>
					<div class="form-group <?php echo ($has_error) ? "has-error" : ""; ?>">
					    <label class="control-label" for="pwd">Password:</label>					
					    <input type="password" class="form-control" id="Password" name="Password" placeholder="Enter password" autocomplete="off" required="">					
					</div>				    
					<div class="form-group">					
					    <button type="submit" class="btn btn-block btn-default">Sign In</button>					
					</div>
				    </form>
				</div>
			    </div>
			</div>			
		    </div>
		</div>
	    </div>
	</div>
	<script src="<?php echo base_url() ?>assets/component/jquery/jquery-1.12.4.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url() ?>assets/component/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url() ?>assets/component/validator/validator.min.js" type="text/javascript"></script>
    </body>
</html>
