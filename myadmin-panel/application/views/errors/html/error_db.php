<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Database Error</title>
<style type="text/css">
  body{
	font: 13px/20px normal Helvetica, Arial, sans-serif;
	background-color: #F5F5F5;
	margin: 40px;
	
    }
    #container{
	margin: 0 auto;
	background: #fff;
	position: absolute;
	top: 30%;
	left: 50%;
	margin-left: -280px;
	width: 400px;
	border: 1px solid #D0D0D0;
	text-align: center;
	padding: 80px;
    }
    h1 {
	color: #444;
	background-color: transparent;
	//border-bottom: 1px solid #D0D0D0;
	font-size: 29px;
	font-weight: normal;
	margin: 0 0 14px 0;
	padding: 14px 15px 10px 15px;
}
</style>
</head>
<body>
	<div id="container">
		<h1><?php echo $heading; ?></h1>
		<?php echo $message; ?>
	</div>
</body>
</html>