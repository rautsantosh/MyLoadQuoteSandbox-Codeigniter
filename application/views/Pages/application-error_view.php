<div class="hero-container">
    <div class="container"> 
	<?php include_once 'common/menu.php'; ?>		
    </div>       
</div>
<div class="container">
    <div class="row">    
	<div class="col-sm-12">
	    <div class="text-center text-danger">
		<div class="form-group">
		    <div class="h3">Error while processing your loan application.</div>
		</div>
		<div class="form-group">
		    <div class="h4">We have found some incorrect or mismatch values with your loan application. Please correct below error and try again.</div>
		</div>
	    </div>
	</div>	
	<div class="form-group"><p><br></p></div>
	<div class="col-sm-12">	    
	    <?php foreach ($errors as $key => $val): ?>		
    	    <div class="form-group">
		<div class="alert alert-danger"><b>Incorrect <?php echo $key ?></b>: <?php  echo $val; ?></div>
    	    </div>		
	    <?php endforeach; ?>
	</div>
	<div class="form-group"><p><br></p></div>
	<div class="col-sm-12">	    	    
	    <form action="<?php echo base_url("apply") ?>" method="post">
		<input type="hidden" name="ReviewApp" value="1">
		<?php foreach ($AppData as $key => $val): ?>
    		<input type="hidden" name="<?php echo $key ?>" value="<?php echo $val ?>">
		<?php endforeach; ?>
		<div class="text-center form-group">
		    <!-- <button class="btn btn-primary btn-lg">Resubmit Your Application</button>-->
		    <a class="btn btn-primary btn-lg" href="<?php echo base_url() ?>">Resubmit Your Application</a>
		</div>
	    </form>	    
	</div>
    </div>
</div>