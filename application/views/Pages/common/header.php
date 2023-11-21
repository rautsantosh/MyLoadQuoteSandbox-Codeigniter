<!DOCTYPE HTML>
<html lang="en">
    <head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="Pragma" content="no-cache">
	<meta name="viewport" content="width=device-width,  initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="description" content="">
	<link rel="Shortcut Icon" href="<?php echo base_url() ?>assets/images/fevicon.png" type="image/x-icon">
        <title> My Loan Quote </title>    
	<link href="<?php echo base_url() ?>assets/brower_component/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo base_url() ?>assets/brower_component/fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>	
	<link href="<?php echo base_url() ?>assets/brower_component/animate/animate.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo base_url() ?>assets/css/main.css" rel="stylesheet" type="text/css"/> 
	<link href="<?php echo base_url() ?>assets/css/mycss.css" rel="stylesheet" type="text/css"/>	
	<link href="<?php echo base_url() ?>assets/brower_component/normalize/normalize.min.css" rel="stylesheet" type="text/css"/>
	<?php if ($IsApplyForm): ?>
    	<link href="<?php echo base_url() ?>assets/css/applyform.css" rel="stylesheet" type="text/css"/>
	<?php endif; ?>
	<script src="<?php echo base_url() ?>assets/brower_component/jquery/jquery-1.9.1.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url() ?>assets/brower_component/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>		
	<style type="text/css">
	    #PageLoader{
		position: fixed;
		left: 0px;
		top: 0px;
		width: 100%;
		height: 100%;
		z-index: 9999;
		background: url('assets/images/progress.gif') 50% 50% no-repeat #FFFFFF;
	    }
	</style>
	<script type="text/javascript">
	    $(document).ready(function () {
		$(window).load(function () {
		    $("#PageLoader").fadeOut("slow");
		});
	    });
	</script>
	<script>(function(w,d,t,r,u){var f,n,i;w[u]=w[u]||[],f=function(){var o={ti:"5613730"};o.q=w[u],w[u]=new UET(o),w[u].push("pageLoad")},n=d.createElement(t),n.src=r,n.async=1,n.onload=n.onreadystatechange=function(){var s=this.readyState;s&&s!=="loaded"&&s!=="complete"||(f(),n.onload=n.onreadystatechange=null)},i=d.getElementsByTagName(t)[0],i.parentNode.insertBefore(n,i)})(window,document,"script","//bat.bing.com/bat.js","uetq");</script>
	<noscript><img src="//bat.bing.com/action/0?ti=5613730&Ver=2" height="0" width="0" style="display:none; visibility: hidden;" /></noscript> 
    </head> 
    <body class="page-home">
	<div id="PageLoader"></div>