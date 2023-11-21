<!DOCTYPE HTML>
<html>
    <head>
	<title>Processing..</title>
	<link href="<?php echo base_url() ?>assets/brower_component/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<style type="text/css">
	    body{
		background: #FFFFFF;
	    }
	    .container{
		background: #ffffff;				
	    }
	    .wait-container{
		margin-top: 10%;
		padding: 50px;
		border: 2px solid #FE9700;
		background: #FFFFFF;
		border-radius: 15px;
		-webkit-border-radius: 15px;
		-moz-border-radius: 15px;
		height: auto;
	    }
	</style>
    </head>
    <body>
	<div class="container text-center">
	    <div class="row">
		<div class="col-sm-12 text-center">
		    <div class="wait-container">
			<form action="<?php echo base_url("processApplication"); ?>" id="MyForm" method="post">
			    <?php foreach ($_POST as $key => $val): ?>
    			    <input type="hidden" name="<?php echo $key ?>" value="<?php echo $val ?>">
			    <?php endforeach; ?>
			</form>
			<p><br></p>
			<img src="<?php echo base_url() ?>assets/images/logo.png" alt="My Loan Quote"/>		    
			<div class="col-sm-12">
			    <div class="h3">We are searching our lending partnerships for the best match..</div>			    
			    <div>
				<br>
				<img src="<?php echo base_url() ?>assets/images/loader_wait.gif" alt=""/>
				<br>
			    </div>				
			    <div>Please do not close/refresh this window.  You will be redirected shortly.</div>			    
			</div>
			<div class="clearfix"></div>
			<script type="text/javascript">
			    setTimeout(function () {
				document.getElementById("MyForm").submit();
			    }, 500);
			</script>			
		    </div>
		</div>
	    </div>
	</div>
    </body>
</html>