<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>404 Page Not Found- My Loan Quote</title>
	<link href="<?php echo base_url() ?>assets/brower_component/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo base_url() ?>assets/brower_component/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
	<style type="text/css">
	    .error_block{ margin-top: 15%; }	    
	</style>
    </head>
    <body>
	<div class="container">	    
	    <div class="col-lg-12 col-md-12 col-sm-12">
		<div class="form-group">
		    <div class="col-sm-12"><h1>&nbsp;</h1></div>
		</div>
		<img src="<?php echo base_url() ?>assets/images/logo.png" alt=""/>
	    </div>
	    <div class="col-lg-12 col-md-12 col-sm-12">
		<div class="col-sm-12 col-md-8 col-lg-8">
		    <div class="form-group error_block">
			<h1 class="text-jumbo text-ginormous">Oops!</h1>
			<h2>We can't seem to find the page you're looking for.</h2>
			<h4>Error code: 404</h4>
		    </div>
		</div>
		<div class="col-sm-12 col-md-4 col-lg">
		    <h4>Here are some helpful links instead:</h4>
		    <div class="form-group"></div>
		    <div class="btn btn-group">
			<a class="btn btn-default btn-block" href="<?php echo base_url() ?>">Home</a>
			<a class="btn btn-default btn-block" href="<?php echo base_url() ?>">Contact Us</a>
			<a class="btn btn-default btn-block" href="<?php echo base_url("privacy-policy") ?>">Privacy Policy</a>
			<a class="btn btn-default btn-block" href="<?php echo base_url("terms-of-services") ?>">Terms &amp; Conditions</a>
			<a class="btn btn-default btn-block" href="<?php echo base_url("e-consent") ?>">E-Consent</a>			
		    </div>		    
		</div>		
	    </div>
	</div>
    </body>
</html>
