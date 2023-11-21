<div class="hero-container">
    <div class="container"> 
	<?php include_once 'common/menu.php'; ?>		
    </div>   
    <section id="home-hero">
	<div class="container-fluid">
	    <div class="row">
		<div class="col-sm-12">
		    <div class="container">			    
			<div class="row">
			    <div id="formBox0">
				<div class="col-sm-12">
				    <h1 class="index-headline text-center animated fadeIn">SERVICE UNAVAILABLE</h1>
				</div>					
			    </div>				    
			</div>
		    </div>
		</div>
	    </div>
	</div>
    </section>    
</div>
<section>
    <div class="container-fluid">
	<div class="row">
	    <div class="col-sm-12">
		<div class="text-center">
		    <p>&nbsp;</p>
		    <div class="h2">Our system was unable to locate a provider for your location at this time.</div>
		    <a href="<?php echo base_url() ?>" class="btn btn-primary"><i class="fa fa-home"></i> Home Page</a>
		    <!-- <p>&nbsp;</p>
		    <div class="h4">Please wait while redirecting...</div>
		    <p>&nbsp;</p>		    
		    <img src="<?php echo base_url() ?>assets/images/loader.gif" alt=""/>
		    <p>&nbsp;</p>			    
		    <div class="">You will be redirected shortly</div>				
		    <p>&nbsp;</p>
		    <p>&nbsp;</p> -->			    
		</div>
	    </div>
	</div>
    </div>
</section>

<script type="text/javascript">
    setTimeout(function () {
	//window.location.replace("<?php echo $defaultRedirectURL; ?>");
    }, 3000);
</script>