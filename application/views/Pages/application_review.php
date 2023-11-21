<?php
$zipcode = sprintf("%05d", $zipcode);
?>
<div class="hero-container">
    <div class="container">
	<?php include_once 'common/menu.php'; ?>
    </div>
    <section id="home-hero">
	<div class="container-fluid">
	    <div class="row">
		<div class="col-sm-12">
		    <div class="container home-hero-content appy_form_container">			    
			<div class="row">
			    <div class="col-sm-12" id="FormBox">
				<div class="col-sm-12">
				    <div class="progress">
					<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="10" aria-valuemin="" aria-valuemax="100" style="width:0%">
					    <span class="show">PROGRESS</span>
					</div>
				    </div>
				</div>
				<div class="col-sm-12">
				    <form action="apply" id="submitForm" method="post"> 
					<input type="hidden" name="PostAction" value="<?php echo uniqid() ?>">
					<input type="hidden" name="s1" value="<?php echo $s1 ?>">
					<input type="hidden" name="s2" value="<?php echo $s2 ?>">
					<input type="hidden" name="s3" value="<?php echo $s3 ?>">
					<input type="hidden" name="s4" value="<?php echo $s4 ?>">

					<ul class="form-steps">
					    <li data-step="1">							
						<div class="col-sm-12 boxshadow">							    
						    <div class="col-sm-12 text-center form-group">
							<div class="head_title">How much do you need ?</div>
							<div class="head_text">Please choose the amount you need. You can take from $300 to $1000. The final amount may also depend on lender.</div>
						    </div>
						    <div class="col-sm-4 col-sm-offset-4">
							<div class="form-group">
							    <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-money"></i></span>
								<select name="RequestedAmount" id="RequestedAmount" class="form-control" required="">
								    <option value=""> - Select -</option>
								    <option <?php echo ($App->LoanAmount == 1000) ? "selected=\"true\"" : ""; ?> value="1000">$1000 or MORE</option>
								    <option <?php echo ($App->LoanAmount == 900) ? "selected=\"true\"" : ""; ?> value="900">$900</option>
								    <option <?php echo ($App->LoanAmount == 800) ? "selected=\"true\"" : ""; ?> value="800">$800</option>
								    <option <?php echo ($App->LoanAmount == 700) ? "selected=\"true\"" : ""; ?> value="700">$700</option>
								    <option <?php echo ($App->LoanAmount == 600) ? "selected=\"true\"" : ""; ?> value="600">$600</option>
								    <option <?php echo ($App->LoanAmount == 500) ? "selected=\"true\"" : ""; ?> value="500">$500</option>
								    <option <?php echo ($App->LoanAmount == 400) ? "selected=\"true\"" : ""; ?> value="400">$400</option>
								    <option <?php echo ($App->LoanAmount == 300) ? "selected=\"true\"" : ""; ?> value="300">$300</option>
								</select>
								<span class="glyphicon form-control-feedback"></span>
							    </div>
							</div>
							<div class="form-group">
							    <div data-action="BackStep" class="pull-left btn btn-default hidden"><i class="fa fa-arrow-left"></i> &nbsp;</div>
							    <div data-action="NextStep" class="pull-right btn btn-info" data-validate="RequestedAmount">Continue <i class="fa fa-arrow-right"></i></div>
							    <div class="clearfix"></div>
							</div>
						    </div>							
						</div>
						<div class="col-sm-12 bg-info">
						    <div class="form-group text-center">
							<p><label>Your security is important to us!</label><br>This site is secured by <a href="https://ssl.comodo.com/wildcard-ssl-certificates.php"target="_blank"><img src="assets/images/comodo_secure_seal_76x26_transp.png" alt="Wildcard SSL" width="76" height="26" style="border: 0px;"></a>, an industry standard for site and information security. Your data is encrypted with 256-bit SSL technology to protect your identity and privacy.</p>							    
						    </div>
						</div>						    
					    </li>
					    <li data-step="2">							
						<div class="col-sm-12 boxshadow">
						    <div class="col-sm-12 text-center form-group">
							<div class="head_title">Are you in the military?</div>
							<div class="head_text">Please let us know if you are employed by military services.</div>
						    </div>
						    <div class="col-sm-4 col-sm-offset-4">
							<div class="col-sm-12 form-group">
							    <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-flag"></i></span>
								<select name="ActiveMilitary" id="ActiveMilitary" class="form-control" required="">
								    <option value="">- Select -</option>
								    <option <?php echo ($App->MilitaryService == 0) ? "selected=\"true\"" : ""; ?> value="0" selected="">No</option>
								    <option <?php echo ($App->MilitaryService == 1) ? "selected=\"true\"" : ""; ?> value="1">Yes</option>
								</select>
								<span class="glyphicon form-control-feedback"></span>
							    </div>
							</div>
							<div class="col-sm-12 form-group">
							    <div data-action="BackStep" class="pull-left btn btn-default"><i class="fa fa-arrow-left"></i> &nbsp;</div>
							    <div data-action="NextStep" class="pull-right btn btn-info" data-validate="ActiveMilitary">Continue <i class="fa fa-arrow-right"></i></div>
							    <div class="clearfix"></div>
							</div>
						    </div>
						</div>
						<div class="col-sm-12 bg-info">
						    <div class="form-group text-center">
							<p><label>Your security is important to us!</label><br>This site is secured by <a href="https://ssl.comodo.com/wildcard-ssl-certificates.php"target="_blank"><img src="assets/images/comodo_secure_seal_76x26_transp.png" alt="Wildcard SSL" width="76" height="26" style="border: 0px;"></a>, an industry standard for site and information security. Your data is encrypted with 256-bit SSL technology to protect your identity and privacy.</p>							    
						    </div>
						</div>
					    </li>
					    <li data-step="3">							
						<div class="col-sm-12 boxshadow">
						    <div class="col-sm-12 text-center form-group">
							<div class="head_title">Your Name</div>
							<div class="head_text">Please enter your name as it is shown on your ID. If it consist multiple words you leave space between them.</div>
						    </div>
						    <div class="col-sm-4 col-sm-offset-4">
							<div class="form-group no-padding">
							    <div class="input-group">		
								<span class="input-group-addon"><i class="fa fa-user"></i></span>
								<select name="Title" id="Title" class="form-control">
								    <option <?php echo ($App->Title == "Mr") ? "selected=\"true\"" : ""; ?> value="Mr">Mr</option>
								    <option <?php echo ($App->Title == "Mrs") ? "selected=\"true\"" : ""; ?> value="Mrs">Mrs</option>
								    <option <?php echo ($App->Title == "Ms") ? "selected=\"true\"" : ""; ?> value="Ms">Ms</option>
								    <option <?php echo ($App->Title == "Miss") ? "selected=\"true\"" : ""; ?> value="Miss">Miss</option>
								</select>
							    </div>
							</div>
							<div class="form-group">
							    <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-user"></i></span>
								<input type="text" name="FirstName" id="FirstName" class="form-control triminput" placeholder="First Name" required maxlength="50" data-regex="^[a-zA-Z .]{2,}$" value="<?php echo $App->FirstName ?>">
								<span class="glyphicon form-control-feedback"></span>
							    </div>								
							</div>
							<div class="form-group">
							    <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-user"></i></span>
								<input type="text" name="LastName" id="LastName" class="form-control triminput" placeholder="Last Name" required maxlength="50" data-regex="^[a-zA-Z .]{2,}$" value="<?php echo $App->LastName ?>">
								<span class="glyphicon form-control-feedback"></span>
							    </div>
							</div>
							<div class="form-group">
							    <div data-action="BackStep" class="pull-left btn btn-default"><i class="fa fa-arrow-left"></i> &nbsp;</div>
							    <div data-action="NextStep" class="pull-right btn btn-info"  data-validate="FirstName|LastName">Continue <i class="fa fa-arrow-right"></i></div>
							    <div class="clearfix"></div>
							</div>
						    </div>
						</div>
						<div class="col-sm-12 bg-info">
						    <div class="form-group text-center">
							<p><label>Your security is important to us!</label><br>This site is secured by <a href="https://ssl.comodo.com/wildcard-ssl-certificates.php"target="_blank"><img src="assets/images/comodo_secure_seal_76x26_transp.png" alt="Wildcard SSL" width="76" height="26" style="border: 0px;"></a>, an industry standard for site and information security. Your data is encrypted with 256-bit SSL technology to protect your identity and privacy.</p>							    
						    </div>
						</div>
					    </li>
					    <li data-step="4">							
						<div class="col-sm-12 boxshadow">
						    <div class="col-sm-12 text-center form-group">
							<div class="head_title">Please Enter Your Email</div>
							<div class="head_text">Please enter your valid email address. Lender can contact you on this email. For example: your_email@example.com</div>
						    </div>
						    <div class="col-sm-4 col-sm-offset-4">
							<div class="col-sm-12 form-group">
							    <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
								<input type="email" name="Email" id="Email" class="form-control" placeholder="youremail@domain.com" required data-regex="^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$" value="<?php echo $App->Email; ?>">
								<span class="glyphicon form-control-feedback"></span>
							    </div>
							</div>
							<div class="col-sm-12 form-group">
							    <div data-action="BackStep" class="pull-left btn btn-default"><i class="fa fa-arrow-left"></i> &nbsp;</div>
							    <div data-action="NextStep" class="pull-right btn btn-info" data-validate="Email">Continue <i class="fa fa-arrow-right"></i></div>
							    <div class="clearfix"></div>
							</div>
						    </div>
						</div>
						<div class="col-sm-12 bg-info">
						    <div class="form-group text-center">
							<p><label>Your security is important to us!</label><br>This site is secured by <a href="https://ssl.comodo.com/wildcard-ssl-certificates.php"target="_blank"><img src="assets/images/comodo_secure_seal_76x26_transp.png" alt="Wildcard SSL" width="76" height="26" style="border: 0px;"></a>, an industry standard for site and information security. Your data is encrypted with 256-bit SSL technology to protect your identity and privacy.</p>							    
						    </div>
						</div>
					    </li>
					    <li data-step="5">							
						<div class="col-sm-12 boxshadow">
						    <div class="col-sm-12 text-center form-group">
							<div class="head_title">Your Phone</div>
							<div class="head_text">Please enter your cell phone and work phone number. The lender could reach you on this number to discuss about your loan. Important: both number should not be same.</div>
						    </div>
						    <div class="col-sm-4 col-sm-offset-4">
							<div class="col-sm-12">
							    <div class="form-group"> 
								<div class="input-group">
								    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
								    <input type="tel" name="PhoneCell" id="PhoneCell" class="form-control phonemask" placeholder="Phone Cell" maxlength="14" value="<?php echo $App->PhoneCell ?>" required data-regex="^(?:(?:\+?1\s*(?:[.-]\s*)?)?(?:\(\s*([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9])\s*\)|([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9]))\s*(?:[.-]\s*)?)?([2-9]1[02-9]|[2-9][02-9]1|[2-9][02-9]{2})\s*(?:[.-]\s*)?([0-9]{4})(?:\s*(?:#|x\.?|ext\.?|extension)\s*(\d+))?$" >
								    <span class="glyphicon form-control-feedback"></span>
								</div>
							    </div>
							    <div class="form-group"> 
								<div class="input-group">
								    <span class="input-group-addon"><i class="fa fa-university"></i></span>
								    <input type="tel" name="PhoneWork" id="PhoneWork" class="form-control phonemask" placeholder="Phone Office" maxlength="14" required value="<?php echo $App->PhoneWork ?>" data-regex="^(?:(?:\+?1\s*(?:[.-]\s*)?)?(?:\(\s*([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9])\s*\)|([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9]))\s*(?:[.-]\s*)?)?([2-9]1[02-9]|[2-9][02-9]1|[2-9][02-9]{2})\s*(?:[.-]\s*)?([0-9]{4})(?:\s*(?:#|x\.?|ext\.?|extension)\s*(\d+))?$">
								    <span class="glyphicon form-control-feedback"></span>
								</div>
							    </div>
							    <div class="form-group">
								<div class="input-group">
								    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
								    <select name="BestTimeToCall" id="BestTimeToCall" required="" class="form-control">
									<option value=""> - Best Time To Call - </option>
									<option <?php echo ($App->BestTimeToCall == "ANYTIME") ? "selected=\"true\"" : "" ?> value="ANYTIME">ANYTIME</option>
									<option <?php echo ($App->BestTimeToCall == "MORNING") ? "selected=\"true\"" : "" ?> value="MORNING">MORNING</option>
									<option <?php echo ($App->BestTimeToCall == "AFTERNOON") ? "selected=\"true\"" : "" ?> value="AFTERNOON">AFTERNOON</option>
									<option <?php echo ($App->BestTimeToCall == "EVENING") ? "selected=\"true\"" : "" ?> value="EVENING">EVENING</option>
								    </select>
								    <span class="glyphicon form-control-feedback"></span>
								</div>
							    </div>
							</div>
							<div class="col-sm-12 form-group">
							    <div data-action="BackStep" class="pull-left btn btn-default"><i class="fa fa-arrow-left"></i> &nbsp;</div>
							    <div data-action="NextStep" class="pull-right btn btn-info" data-validate="PhoneCell|PhoneWork|BestTimeToCall">Continue <i class="fa fa-arrow-right"></i></div>
							    <div class="clearfix"></div>
							</div>
						    </div>
						</div>
						<div class="col-sm-12 bg-info">
						    <div class="form-group text-center">
							<p><label>Your security is important to us!</label><br>This site is secured by <a href="https://ssl.comodo.com/wildcard-ssl-certificates.php"target="_blank"><img src="assets/images/comodo_secure_seal_76x26_transp.png" alt="Wildcard SSL" width="76" height="26" style="border: 0px;"></a>, an industry standard for site and information security. Your data is encrypted with 256-bit SSL technology to protect your identity and privacy.</p>							    
						    </div>
						</div>
					    </li>
					    <li data-step="6">							
						<div class="col-sm-12 boxshadow">
						    <div class="col-sm-12 text-center form-group">
							<div class="head_title">What Is Your Residential Status?</div>
							<div class="head_text">Please select your residential status.</div>
						    </div>
						    <div class="col-sm-4 col-sm-offset-4">
							<div class="col-sm-12">								
							    <div class="form-group">
								<div class="input-group">
								    <span class="input-group-addon"><i class="fa fa-home"></i></span>
								    <select name="OwnHome" id="OwnHome" required="" class="form-control">
									<option value=""> - Select - </option>
									<option <?php echo ($App->Housing == "HomeOwner") ? "selected=\"true\"" : "" ?> value="HomeOwner">Home Owner</option>
									<option <?php echo ($App->Housing == "PrivateTenant") ? "selected=\"true\"" : "" ?> value="PrivateTenant">Private Tenant</option>
									<option <?php echo ($App->Housing == "CouncilTenant") ? "selected=\"true\"" : "" ?> value="CouncilTenant">Council Tenant</option>
									<option <?php echo ($App->Housing == "LivingWithParents") ? "selected=\"true\"" : "" ?> value="LivingWithParents">Living With Parents</option>
									<option <?php echo ($App->Housing == "LivingWithFriends") ? "selected=\"true\"" : "" ?> value="LivingWithFriends">Living With Friends</option>
									<option <?php echo ($App->Housing == "Other") ? "selected=\"true\"" : "" ?> value="Other">Other</option>
								    </select>
								    <span class="glyphicon form-control-feedback"></span>
								</div>
							    </div>
							</div>
							<div class="col-sm-12 form-group">
							    <div data-action="BackStep" class="pull-left btn btn-default"><i class="fa fa-arrow-left"></i> &nbsp;</div>
							    <div data-action="NextStep" class="pull-right btn btn-info" data-validate="OwnHome">Continue <i class="fa fa-arrow-right"></i></div>
							    <div class="clearfix"></div>
							</div>
						    </div>
						</div>
						<div class="col-sm-12 bg-info">
						    <div class="form-group text-center">
							<p><label>Your security is important to us!</label><br>This site is secured by <a href="https://ssl.comodo.com/wildcard-ssl-certificates.php"target="_blank"><img src="assets/images/comodo_secure_seal_76x26_transp.png" alt="Wildcard SSL" width="76" height="26" style="border: 0px;"></a>, an industry standard for site and information security. Your data is encrypted with 256-bit SSL technology to protect your identity and privacy.</p>							    
						    </div>
						</div>
					    </li>						    
					    <li data-step="7">							
						<div class="col-sm-12 boxshadow">
						    <div class="col-sm-12 text-center form-group">
							<div class="head_title">Your Address</div>
							<div class="head_text">Please enter the address you currently live at, which includes your house number, house or apartment name, street name, city state postal code.</div>
						    </div>
						    <div class="col-sm-8 col-sm-offset-2">								
							<!-- <div class="form-group col-sm-12 col-lg-6">
							    <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-location-arrow"></i></span>
								<input type="text" name="HouseNumber" id="HouseNumber" class="form-control" placeholder="House Number"  required="" maxlength="20" data-regex="^[a-zA-Z0-9\s#?.?,?/?\-?_?]{3,}$">
								<span class="glyphicon form-control-feedback"></span>
							    </div>
							</div> 
							<div class="form-group col-sm-12 col-lg-6">
							    <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-location-arrow"></i></span>
								<input type="text" name="HouseName" id="HouseName" class="form-control" placeholder="Your House or Apartment Name"  required="" maxlength="50" data-regex="^[a-zA-Z0-9\s#?.?,?/?\-?_?]{3,}$">
								<span class="glyphicon form-control-feedback"></span>
							    </div>
							</div>-->
							<div class="form-group col-sm-12 col-lg-6">
							    <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-location-arrow"></i></span>
								<input type="text" name="StreetAddress" id="StreetAddress" class="form-control triminput" placeholder="Your Street Address Ex: 123 Street Name"  required="" maxlength="50" data-regex="^\d+[a-zA-Z0-9\s#?.?,?/?\-?_?]{5,}$"  value="<?php echo $App->StreetAddress ?>">
								<span class="glyphicon form-control-feedback"></span>
							    </div>
							</div>
							<div class="form-group col-sm-12 col-lg-6">
							    <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-location-arrow"></i></span>
								<input type="tel" name="Zipcdoe" id="Zipcdoe" class="form-control zipcodemask" placeholder="Zipcode"  required="" maxlength="5" data-regex="^\d{5}$" value="<?php echo $zipcode ?>">
								<span class="glyphicon form-control-feedback"></span>
							    </div>
							</div>
							<div class="form-group col-sm-12 col-lg-6">
							    <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-location-arrow"></i></span>
								<input type="text" name="City" id="City" class="form-control triminput" placeholder="City"  required="" maxlength="50"  data-regex="^[a-zA-Z .]{3,}$" value="<?php echo $city; ?>">
								<span class="glyphicon form-control-feedback"></span>
							    </div>
							</div>
							<div class="form-group col-sm-12 col-lg-6">
							    <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-location-arrow"></i></span>
								<select name="State" id="State" class="form-control">
								    <option value="">- Select State -</option> 
								    <?php foreach (state_list() as $code => $name): ?>
								    <option <?php echo ($code == trim($state)) ? "selected=\"true\"" : ""; ?> value="<?php echo $code ?>"><?php echo $name ?></option>
								    <?php endforeach; ?>
								</select>
								<span class="glyphicon form-control-feedback"></span>
							    </div>
							</div>
							<div class="col-sm-12 form-group">
							    <div data-action="BackStep" class="pull-left btn btn-default"><i class="fa fa-arrow-left"></i> &nbsp;</div>
							    <div data-action="NextStep" class="pull-right btn btn-info" data-validate="StreetAddress|Zipcdoe|City|State">Continue <i class="fa fa-arrow-right"></i></div>
							    <div class="clearfix"></div>
							</div>
						    </div>							    
						</div>
						<div class="col-sm-12 bg-info">
						    <div class="form-group text-center">
							<p><label>Your security is important to us!</label><br>This site is secured by <a href="https://ssl.comodo.com/wildcard-ssl-certificates.php"target="_blank"><img src="assets/images/comodo_secure_seal_76x26_transp.png" alt="Wildcard SSL" width="76" height="26" style="border: 0px;"></a>, an industry standard for site and information security. Your data is encrypted with 256-bit SSL technology to protect your identity and privacy.</p>							    
						    </div>
						</div>
					    </li>
					    <li data-step="8">							
						<div class="col-sm-12 boxshadow">
						    <div class="col-sm-12 text-center form-group">
							<div class="head_title">Your Employer Address</div>
							<div class="head_text">Please enter the employer address you currently working at, which includes street name, city, state and postal code.</div>
						    </div>
						    <div class="col-sm-8 col-sm-offset-2">																
							<div class="form-group col-sm-12 col-lg-6">
							    <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-location-arrow"></i></span>
								<input type="text" name="EmpStreetAddress" id="EmpStreetAddress" class="form-control triminput" placeholder="Your Employer Address"  required="" maxlength="50" data-regex="^[a-zA-Z0-9\s#?.?,?/?\-?_?]{3,}$" value="<?php echo $App->EmpStreet ?>">
								<span class="glyphicon form-control-feedback"></span>
							    </div>
							</div>
							<div class="form-group col-sm-12 col-lg-6">
							    <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-location-arrow"></i></span>
								<input type="tel" name="EmpZipcdoe" id="EmpZipcdoe" class="form-control zipcodemask" placeholder="Zipcode"  required="" maxlength="5" data-regex="^\d{5}$" value="<?php echo $App->EmpZipcode; ?>">
								<span class="glyphicon form-control-feedback"></span>
							    </div>
							</div>
							<div class="form-group col-sm-12 col-lg-6">
							    <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-location-arrow"></i></span>
								<input type="text" name="EmpCity" id="EmpCity" class="form-control triminput" placeholder="City"  required="" maxlength="50"  data-regex="^[a-zA-Z .]{3,}$" value="<?php echo $App->EmpCity; ?>">
								<span class="glyphicon form-control-feedback"></span>
							    </div>
							</div>
							<div class="form-group col-sm-12 col-lg-6">
							    <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-location-arrow"></i></span>
								<select name="EmpState" id="EmpState" class="form-control">
								    <option value="">- Select State -</option> 
								    <?php foreach (state_list() as $code => $name): ?>
								    <option <?php echo ($code == trim($App->EmpState)) ? "selected=\"true\"" : ""; ?> value="<?php echo $code ?>"><?php echo $name ?></option>
								    <?php endforeach; ?>
								</select>
								<span class="glyphicon form-control-feedback"></span>
							    </div>
							</div>
							<div class="col-sm-12 form-group">
							    <div data-action="BackStep" class="pull-left btn btn-default"><i class="fa fa-arrow-left"></i> &nbsp;</div>
							    <div data-action="NextStep" class="pull-right btn btn-info" data-validate="EmpStreetAddress|EmpZipcdoe|EmpCity|EmpState">Continue <i class="fa fa-arrow-right"></i></div>
							    <div class="clearfix"></div>
							</div>
						    </div>							    
						</div>
						<div class="col-sm-12 bg-info">
						    <div class="form-group text-center">
							<p><label>Your security is important to us!</label><br>This site is secured by <a href="https://ssl.comodo.com/wildcard-ssl-certificates.php"target="_blank"><img src="assets/images/comodo_secure_seal_76x26_transp.png" alt="Wildcard SSL" width="76" height="26" style="border: 0px;"></a>, an industry standard for site and information security. Your data is encrypted with 256-bit SSL technology to protect your identity and privacy.</p>							    
						    </div>
						</div>
					    </li>
					    <li data-step="9">							
						<div class="col-sm-12 boxshadow">
						    <div class="col-sm-12 text-center form-group">
							<div class="head_title">When Did You Move into Your Current Residence ?</div>
							<div class="head_text">Please select a date when move at your listed residence.</div>
						    </div>
						    <div class="col-sm-6 col-sm-offset-3">
							<div class="col-sm-12 form-group">
							    <div class="col-sm-4 no-padding">
								<div class="input-group">
								    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								    <select name="MoveInAddressYear" id="MoveInAddressYear" class="form-control">
									<option value="">Year:</option> 
									<?php for ($i = intval(date("Y")); $i > (intval(date("Y")) - 100); $i--): ?>
									<option value="<?php echo $i; ?>" <?php echo (date("Y",  strtotime($App->AddressMoveIn)) == $i) ? "selected=\"true\"" : ""; ?>><?php echo $i; ?></option>
									<?php endfor; ?>
								    </select>
								    <span class="glyphicon form-control-feedback"></span>
								</div>
							    </div>
							    <div class="col-sm-4 no-padding">
								<div class="">									    
								    <select name="MoveInAddressMonth" id="MoveInAddressMonth" class="form-control">
									<option value="">Month:</option>
									<option value="01" <?php echo (date("m",  strtotime($App->AddressMoveIn)) == "01") ? "selected=\"true\"" : ""; ?>>Jan</option>
									<option value="02" <?php echo (date("m",  strtotime($App->AddressMoveIn)) == "02") ? "selected=\"true\"" : ""; ?>>Feb</option>
									<option value="03" <?php echo (date("m",  strtotime($App->AddressMoveIn)) == "03") ? "selected=\"true\"" : ""; ?>>Mar</option>
									<option value="04" <?php echo (date("m",  strtotime($App->AddressMoveIn)) == "04") ? "selected=\"true\"" : ""; ?>>Apr</option>
									<option value="05" <?php echo (date("m",  strtotime($App->AddressMoveIn)) == "05") ? "selected=\"true\"" : ""; ?>>May</option>
									<option value="06" <?php echo (date("m",  strtotime($App->AddressMoveIn)) == "06") ? "selected=\"true\"" : ""; ?>>Jun</option>
									<option value="07" <?php echo (date("m",  strtotime($App->AddressMoveIn)) == "07") ? "selected=\"true\"" : ""; ?>>Jul</option>
									<option value="08" <?php echo (date("m",  strtotime($App->AddressMoveIn)) == "08") ? "selected=\"true\"" : ""; ?>>Aug</option>
									<option value="09" <?php echo (date("m",  strtotime($App->AddressMoveIn)) == "09") ? "selected=\"true\"" : ""; ?>>Sep</option>
									<option value="10" <?php echo (date("m",  strtotime($App->AddressMoveIn)) == "10") ? "selected=\"true\"" : ""; ?>>Oct</option>
									<option value="11" <?php echo (date("m",  strtotime($App->AddressMoveIn)) == "11") ? "selected=\"true\"" : ""; ?>>Nov</option>
									<option value="12" <?php echo (date("m",  strtotime($App->AddressMoveIn)) == "12") ? "selected=\"true\"" : ""; ?>>Dec</option>
								    </select>
								    <span class="glyphicon form-control-feedback"></span>
								</div>
							    </div>
							    <div class="col-sm-4 no-padding">
								<div class="">									    
								    <select name="MoveInAddressDate" id="MoveInAddressDate" class="form-control">
									<option value="">Date:</option>
									<option value="<?php echo date("d",  strtotime($App->AddressMoveIn)) ?>" selected="true"><?php echo date("d",  strtotime($App->AddressMoveIn)) ?></option>
								    </select>
								    <span class="glyphicon form-control-feedback"></span>
								</div>
							    </div>								    
							</div>
							<div class="col-sm-12 form-group">
							    <div data-action="BackStep" class="pull-left btn btn-default"><i class="fa fa-arrow-left"></i> &nbsp;</div>
							    <div data-action="NextStep" class="pull-right btn btn-info" data-validate="MoveInAddressYear|MoveInAddressMonth|MoveInAddressDate">Continue <i class="fa fa-arrow-right"></i></div>
							    <div class="clearfix"></div>
							</div>
						    </div>
						</div>
						<div class="col-sm-12 bg-info">
						    <div class="form-group text-center">
							<p><label>Your security is important to us!</label><br>This site is secured by <a href="https://ssl.comodo.com/wildcard-ssl-certificates.php"target="_blank"><img src="assets/images/comodo_secure_seal_76x26_transp.png" alt="Wildcard SSL" width="76" height="26" style="border: 0px;"></a>, an industry standard for site and information security. Your data is encrypted with 256-bit SSL technology to protect your identity and privacy.</p>							    
						    </div>
						</div>
					    </li>
					    <li data-step="10">							
						<div class="col-sm-12 boxshadow">
						    <div class="col-sm-12 text-center form-group">
							<div class="head_title">What is Your Birthday?</div>
						    </div>
						    <div class="col-sm-6 col-sm-offset-3">
							<!-- <div class="col-sm-12 form-group">
							    <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								<input type="text" name="Birthdate" id="Birthdate" class="form-control calendar" placeholder="Date of Birth" required maxlength="0" data-regex="^(0[1-9]|1[0-2])\/(0[1-9]|1\d|2\d|3[01])\/(19|20)\d{2}$" data-date-end-date="-18y">
								<span class="glyphicon form-control-feedback"></span>
							    </div>
							</div> -->
							<div class="col-sm-12 form-group">
							    <div class="col-sm-4 no-padding">
								<div class="input-group">
								    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								    <select name="BirthdayYear" id="BirthdayYear" class="form-control">
									<option value="">Year:</option> 
									<?php for ($i = intval(date("Y", strtotime("-18 years"))); $i > (intval(date("Y")) - 100); $i--): ?>
    									<option value="<?php echo $i; ?>" <?php echo (date("Y",  strtotime($App->Birthday)) == $i) ? "selected=\"true\"" : ""; ?>><?php echo $i; ?></option>
									<?php endfor; ?>
								    </select>
								    <span class="glyphicon form-control-feedback"></span>
								</div>
							    </div>
							    <div class="col-sm-4 no-padding">
								<select name="BirthdayMonth" id="BirthdayMonth" class="form-control">
								    <option value="">Month:</option>
								    <option value="01" <?php echo (date("m",  strtotime($App->Birthday)) == "01") ? "selected=\"true\"" : ""; ?>>Jan</option>
								    <option value="02" <?php echo (date("m",  strtotime($App->Birthday)) == "02") ? "selected=\"true\"" : ""; ?>>Feb</option>
								    <option value="03" <?php echo (date("m",  strtotime($App->Birthday)) == "03") ? "selected=\"true\"" : ""; ?>>Mar</option>
								    <option value="04" <?php echo (date("m",  strtotime($App->Birthday)) == "04") ? "selected=\"true\"" : ""; ?>>Apr</option>
								    <option value="05" <?php echo (date("m",  strtotime($App->Birthday)) == "05") ? "selected=\"true\"" : ""; ?>>May</option>
								    <option value="06" <?php echo (date("m",  strtotime($App->Birthday)) == "06") ? "selected=\"true\"" : ""; ?>>Jun</option>
								    <option value="07" <?php echo (date("m",  strtotime($App->Birthday)) == "07") ? "selected=\"true\"" : ""; ?>>Jul</option>
								    <option value="08" <?php echo (date("m",  strtotime($App->Birthday)) == "08") ? "selected=\"true\"" : ""; ?>>Aug</option>
								    <option value="09" <?php echo (date("m",  strtotime($App->Birthday)) == "09") ? "selected=\"true\"" : ""; ?>>Sep</option>
								    <option value="10" <?php echo (date("m",  strtotime($App->Birthday)) == "10") ? "selected=\"true\"" : ""; ?>>Oct</option>
								    <option value="11" <?php echo (date("m",  strtotime($App->Birthday)) == "11") ? "selected=\"true\"" : ""; ?>>Nov</option>
								    <option value="12" <?php echo (date("m",  strtotime($App->Birthday)) == "12") ? "selected=\"true\"" : ""; ?>>Dec</option>
								</select>
								<span class="glyphicon form-control-feedback"></span>									
							    </div>
							    <div class="col-sm-4 no-padding">
								<select name="BirthdayDate" id="BirthdayDate" class="form-control">
								    <option value="">Date:</option>
								    <option selected="true" value="<?php echo date("d",  strtotime($App->Birthday)) ?>"><?php echo date("d",  strtotime($App->Birthday)) ?></option>
								</select>
								<span class="glyphicon form-control-feedback"></span>									
							    </div>								    
							</div>
							<div class="col-sm-12 form-group">
							    <div data-action="BackStep" class="pull-left btn btn-default"><i class="fa fa-arrow-left"></i> &nbsp;</div>
							    <div data-action="NextStep" class="pull-right btn btn-info" data-validate="BirthdayYear|BirthdayMonth|BirthdayDate">Continue <i class="fa fa-arrow-right"></i></div>
							    <div class="clearfix"></div>
							</div>
						    </div>
						</div>
						<div class="col-sm-12 bg-info">
						    <div class="form-group text-center">
							<p><label>Your security is important to us!</label><br>This site is secured by <a href="https://ssl.comodo.com/wildcard-ssl-certificates.php"target="_blank"><img src="assets/images/comodo_secure_seal_76x26_transp.png" alt="Wildcard SSL" width="76" height="26" style="border: 0px;"></a>, an industry standard for site and information security. Your data is encrypted with 256-bit SSL technology to protect your identity and privacy.</p>							    
						    </div>
						</div>
					    </li>
					    <li data-step="11">							
						<div class="col-sm-12 boxshadow">
						    <div class="col-sm-12 text-center form-group">
							<div class="head_title">Social Security Number</div>
							<div class="head_text">Please enter your Social Security Number that is unique to you. Lenders only ask for your SSN to verify your identity.</div>
						    </div>
						    <div class="col-sm-4 col-sm-offset-4">
							<div class="col-sm-12 form-group">
							    <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-lock"></i></span>
								<input type="tel" name="SSN" id="SSN" class="form-control" placeholder="Social Security Number" required maxlength="11" data-regex="^\d{3}-?\d{2}-?\d{4}$" value="<?php echo $App->SSN ?>">
								<span class="glyphicon form-control-feedback"></span>
							    </div>
							</div>
							<div class="col-sm-12 form-group">
							    <div data-action="BackStep" class="pull-left btn btn-default"><i class="fa fa-arrow-left"></i> &nbsp;</div>
							    <div data-action="NextStep" class="pull-right btn btn-info" data-validate="SSN">Continue <i class="fa fa-arrow-right"></i></div>
							    <div class="clearfix"></div>
							</div>
						    </div>
						</div>
						<div class="col-sm-12 bg-info">
						    <div class="form-group text-center">
							<p><label>Your security is important to us!</label><br>This site is secured by <a href="https://ssl.comodo.com/wildcard-ssl-certificates.php"target="_blank"><img src="assets/images/comodo_secure_seal_76x26_transp.png" alt="Wildcard SSL" width="76" height="26" style="border: 0px;"></a>, an industry standard for site and information security. Your data is encrypted with 256-bit SSL technology to protect your identity and privacy.</p>							    
						    </div>
						</div>
					    </li>
					    <li data-step="12">							
						<div class="col-sm-12 boxshadow">
						    <div class="col-sm-12 text-center form-group">
							<div class="head_title">Driving License Number / #State</div>
							<div class="head_text">Please enter your driving license number with state where your driver's license card issued.</div>
						    </div>
						    <div class="col-sm-4 col-sm-offset-4">							    
							<div class="col-sm-12 form-group">
							    <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-car"></i></span>
								<input type="text" name="DrivingLicenseNumber" id="DrivingLicenseNumber" class="form-control triminput" placeholder="Driving License Number" required maxlength="50" data-regex="^[a-zA-Z0-9\s]{3,50}$" value="<?php echo $App->DriverLicenseNumber ?>">
								<span class="glyphicon form-control-feedback"></span>
							    </div>
							</div>
							<div class="col-sm-12 form-group">
							    <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-flag"></i></span>
								<select name="DrivingLicenseState" id="DrivingLicenseState" class="form-control">
								    <option value="">State</option> 
								    <?php foreach (state_list() as $code => $name): ?>
    								    <option <?php echo ($code == $state) ? "selected=\"true\"" : ""; ?> value="<?php echo $code ?>" <?php echo ($App->DriversLicenseState == $code) ? "selected=\"true\"" : ""; ?>><?php echo $name ?></option>
								    <?php endforeach; ?>
								</select>
								<span class="glyphicon form-control-feedback"></span>
							    </div>
							</div>
							<div class="clearfix"></div>								
							<div class="col-sm-12 form-group">
							    <div data-action="BackStep" class="pull-left btn btn-default"><i class="fa fa-arrow-left"></i> &nbsp;</div>
							    <div data-action="NextStep" class="pull-right btn btn-info" data-validate="DrivingLicenseNumber|DrivingLicenseState">Continue <i class="fa fa-arrow-right"></i></div>
							    <div class="clearfix"></div>
							</div>
						    </div>
						</div>
						<div class="col-sm-12 bg-info">
						    <div class="form-group text-center">
							<p><label>Your security is important to us!</label><br>This site is secured by <a href="https://ssl.comodo.com/wildcard-ssl-certificates.php"target="_blank"><img src="assets/images/comodo_secure_seal_76x26_transp.png" alt="Wildcard SSL" width="76" height="26" style="border: 0px;"></a>, an industry standard for site and information security. Your data is encrypted with 256-bit SSL technology to protect your identity and privacy.</p>							    
						    </div>
						</div>
					    </li>
					    <li data-step="13">							
						<div class="col-sm-12 boxshadow">
						    <div class="col-sm-12 text-center form-group">
							<div class="head_title">Credit Rating</div>
							<div class="head_text">Please select your credit rating score.</div>
						    </div>
						    <div class="col-sm-4 col-sm-offset-4">
							<div class="col-sm-12 form-group">
							    <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-usd"></i></span>
								<select name="CreditRating" id="CreditRating" class="form-control">
								    <option value=""> - Select -</option>
								    <option value="EXCELLENT" <?php echo ($App->CreditRating == "EXCELLENT") ? "selected=\"true\"" : "";  ?>> Excellent Credit(750+)</option>
								    <option value="VERYGOOD" <?php echo ($App->CreditRating == "VERYGOOD") ? "selected=\"true\"" : "";  ?>> Very Good(700-749) </option>
								    <option value="GOOD" <?php echo ($App->CreditRating == "GOOD") ? "selected=\"true\"" : "";  ?>> Good Credit(650-699) </option>
								    <option value="FAIR" <?php echo ($App->CreditRating == "FAIR") ? "selected=\"true\"" : "";  ?>> Fair Credit(600-649) </option>
								    <option value="POOR" <?php echo ($App->CreditRating == "POOR") ? "selected=\"true\"" : "";  ?>> Poor Credit(550-599)</option>
								    <option value="VERYPOOR" <?php echo ($App->CreditRating == "VERYPOOR") ? "selected=\"true\"" : "";  ?>> Very Poor Credit(549 and under)</option>
								    <option value="UNSURE" <?php echo ($App->CreditRating == "UNSURE") ? "selected=\"true\"" : "";  ?>> NOT KNOW </option>
								</select>
								<span class="glyphicon form-control-feedback"></span>
							    </div>
							</div>
							<div class="col-sm-12 form-group">
							    <div data-action="BackStep" class="pull-left btn btn-default"><i class="fa fa-arrow-left"></i> &nbsp;</div>
							    <div data-action="NextStep" class="pull-right btn btn-info" data-validate="CreditRating">Continue <i class="fa fa-arrow-right"></i></div>
							    <div class="clearfix"></div>
							</div>
						    </div>
						</div>
						<div class="col-sm-12 bg-info">
						    <div class="form-group text-center">
							<p><label>Your security is important to us!</label><br>This site is secured by <a href="https://ssl.comodo.com/wildcard-ssl-certificates.php"target="_blank"><img src="assets/images/comodo_secure_seal_76x26_transp.png" alt="Wildcard SSL" width="76" height="26" style="border: 0px;"></a>, an industry standard for site and information security. Your data is encrypted with 256-bit SSL technology to protect your identity and privacy.</p>							    
						    </div>
						</div>
					    </li>
					    <li data-step="14">							
						<div class="col-sm-12 boxshadow">
						    <div class="col-sm-12 text-center form-group">
							<div class="head_title">Monthly Income</div>
							<div class="head_text">Please select your Net monthly income after taxes.</div>
						    </div>
						    <div class="col-sm-4 col-sm-offset-4">
							<div class="col-sm-12 form-group">
							    <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-dollar"></i></span>
								<select name="MonthlyIncome" id="MonthlyIncome" class="form-control">
								    <option value=""> - Select -</option>
								    <option value="7500" <?php echo ($App->MonthlyIncome == "7500") ? "selected=\"true\"" : ""; ?>>$7,500 or more</option> 
								    <option value="6500" <?php echo ($App->MonthlyIncome == "6500") ? "selected=\"true\"" : ""; ?>>$6,000 - $6,500</option>
								    <option value="6000" <?php echo ($App->MonthlyIncome == "6000") ? "selected=\"true\"" : ""; ?>>$5,500 - $6,000</option> 
								    <option value="5500" <?php echo ($App->MonthlyIncome == "5500") ? "selected=\"true\"" : ""; ?>>$5,000 - $5,500</option> 
								    <option value="5000" <?php echo ($App->MonthlyIncome == "5000") ? "selected=\"true\"" : ""; ?>>$4,500 - $5,000</option> 
								    <option value="4500" <?php echo ($App->MonthlyIncome == "4500") ? "selected=\"true\"" : ""; ?>>$4,000 - $4,500</option> 
								    <option value="4000" <?php echo ($App->MonthlyIncome == "4000") ? "selected=\"true\"" : ""; ?>>$3,500 - $4,000</option> 
								    <option value="3500" <?php echo ($App->MonthlyIncome == "3500") ? "selected=\"true\"" : ""; ?>>$3,000 - $3,500</option> 
								    <option value="3000" <?php echo ($App->MonthlyIncome == "3000") ? "selected=\"true\"" : ""; ?>>$2,500 - $3,000</option> 
								    <option value="2500" <?php echo ($App->MonthlyIncome == "2500") ? "selected=\"true\"" : ""; ?>>$2,000 - $2,500</option> 
								    <option value="2000" <?php echo ($App->MonthlyIncome == "2000") ? "selected=\"true\"" : ""; ?>>$1,500 - $2,000</option> 
								    <option value="1500" <?php echo ($App->MonthlyIncome == "1500") ? "selected=\"true\"" : ""; ?>>$1,000 - $1,500</option> 
								    <option value="750" <?php echo ($App->MonthlyIncome == "750") ? "selected=\"true\"" : ""; ?>>Under $1,000</option> 
								</select>
								<span class="glyphicon form-control-feedback"></span>
							    </div>
							</div>
							<div class="col-sm-12 form-group">
							    <div data-action="BackStep" class="pull-left btn btn-default"><i class="fa fa-arrow-left"></i> &nbsp;</div>
							    <div data-action="NextStep" class="pull-right btn btn-info" data-validate="MonthlyIncome">Continue <i class="fa fa-arrow-right"></i></div>
							    <div class="clearfix"></div>
							</div>
						    </div>
						</div>
						<div class="col-sm-12 bg-info">
						    <div class="form-group text-center">
							<p><label>Your security is important to us!</label><br>This site is secured by <a href="https://ssl.comodo.com/wildcard-ssl-certificates.php"target="_blank"><img src="assets/images/comodo_secure_seal_76x26_transp.png" alt="Wildcard SSL" width="76" height="26" style="border: 0px;"></a>, an industry standard for site and information security. Your data is encrypted with 256-bit SSL technology to protect your identity and privacy.</p>							    
						    </div>
						</div>
					    </li>
					    <li data-step="15">							
						<div class="col-sm-12 boxshadow">
						    <div class="col-sm-12 text-center form-group">
							<div class="head_title">Income Type</div>
							<div class="head_text">Please select type of employment that best described your Income source.</div>
						    </div>
						    <div class="col-sm-4 col-sm-offset-4">
							<div class="col-sm-12 form-group">
							    <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-money"></i></span>
								<select name="IncomeType" id="IncomeType" class="form-control">
								    <option value="">- Select -</option> 
								    <option value="Employed" <?php echo ($App->IncomeSource == "Employed") ? "selected=\"true\"" : ""; ?>>Employed</option> 
								    <option value="Self Employed" <?php echo ($App->IncomeSource == "Self Employed") ? "selected=\"true\"" : ""; ?>>Self Employed</option> 
								    <option value="Social Security" <?php echo ($App->IncomeSource == "Social Security") ? "selected=\"true\"" : ""; ?>>Social Security</option> 
								    <option value="Pension" <?php echo ($App->IncomeSource == "Pension") ? "selected=\"true\"" : ""; ?>>Pension</option> 
								    <option value="Disability" <?php echo ($App->IncomeSource == "Disability") ? "selected=\"true\"" : ""; ?>>Disability</option> 
								</select>
								<span class="glyphicon form-control-feedback"></span>
							    </div>
							</div>
							<div class="col-sm-12 form-group">
							    <div data-action="BackStep" class="pull-left btn btn-default"><i class="fa fa-arrow-left"></i> &nbsp;</div>
							    <div data-action="NextStep" class="pull-right btn btn-info" data-validate="IncomeType">Continue <i class="fa fa-arrow-right"></i></div>
							    <div class="clearfix"></div>
							</div>
						    </div>
						</div>
						<div class="col-sm-12 bg-info">
						    <div class="form-group text-center">
							<p><label>Your security is important to us!</label><br>This site is secured by <a href="https://ssl.comodo.com/wildcard-ssl-certificates.php"target="_blank"><img src="assets/images/comodo_secure_seal_76x26_transp.png" alt="Wildcard SSL" width="76" height="26" style="border: 0px;"></a>, an industry standard for site and information security. Your data is encrypted with 256-bit SSL technology to protect your identity and privacy.</p>							    
						    </div>
						</div>
					    </li>
					    <li data-step="16">							
						<div class="col-sm-12 boxshadow">
						    <div class="col-sm-12 text-center form-group">
							<div class="head_title">Pay Frequency</div>
							<div class="head_text">Please choose how often you get your paycheck.</div>
						    </div>
						    <div class="col-sm-4 col-sm-offset-4">
							<div class="col-sm-12 form-group">
							    <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								<select name="PayFrequency" id="PayFrequency" class="form-control">
								    <option value="">- Select -</option>
								    <option value="WEEKLY" <?php echo ($App->PayFrequency == "WEEKLY") ? "selected=\"true\"" : "" ?>>Weekly</option>
								    <option value="BIWEEKLY" <?php echo ($App->PayFrequency == "BIWEEKLY") ? "selected=\"true\"" : "" ?>>Every 2 Weeks</option>
								    <option value="MONTHLY" <?php echo ($App->PayFrequency == "MONTHLY") ? "selected=\"true\"" : "" ?>>Monthly</option>
								</select>
								<span class="glyphicon form-control-feedback"></span>
							    </div>
							</div>
							<div class="col-sm-12 form-group">
							    <div data-action="BackStep" class="pull-left btn btn-default"><i class="fa fa-arrow-left"></i> &nbsp;</div>
							    <div data-action="NextStep" class="pull-right btn btn-info" data-validate="PayFrequency">Continue <i class="fa fa-arrow-right"></i></div>
							    <div class="clearfix"></div>
							</div>
						    </div>
						</div>
						<div class="col-sm-12 bg-info">
						    <div class="form-group text-center">
							<p><label>Your security is important to us!</label><br>This site is secured by <a href="https://ssl.comodo.com/wildcard-ssl-certificates.php"target="_blank"><img src="assets/images/comodo_secure_seal_76x26_transp.png" alt="Wildcard SSL" width="76" height="26" style="border: 0px;"></a>, an industry standard for site and information security. Your data is encrypted with 256-bit SSL technology to protect your identity and privacy.</p>							    
						    </div>
						</div>
					    </li>
					    <li data-step="17">							
						<div class="col-sm-12 boxshadow">
						    <div class="col-sm-12 text-center form-group">
							<div class="head_title">Employer Name</div>
							<div class="head_text">Please enter organization where you received you income from. If you work for yourself, indicate you are self employed or enter your business name.</div>
						    </div>
						    <div class="col-sm-4 col-sm-offset-4">
							<div class="col-sm-12 form-group">
							    <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-building"></i></span>
								<input type="text" name="EmployerName" id="EmployerName" class="form-control triminput" placeholder="Employer Name" maxlength="50" data-regex="^[a-zA-Z0-9 &?*#?,?!?\-?'?.?]{2,}$" value="<?php echo $App->EmployerName; ?>">
								<span class="glyphicon form-control-feedback"></span>
							    </div>
							</div>
							<div class="col-sm-12 form-group">
							    <div data-action="BackStep" class="pull-left btn btn-default"><i class="fa fa-arrow-left"></i> &nbsp;</div>
							    <div data-action="NextStep" class="pull-right btn btn-info" data-validate="EmployerName">Continue <i class="fa fa-arrow-right"></i></div>
							    <div class="clearfix"></div>
							</div>
						    </div>
						</div>
						<div class="col-sm-12 bg-info">
						    <div class="form-group text-center">
							<p><label>Your security is important to us!</label><br>This site is secured by <a href="https://ssl.comodo.com/wildcard-ssl-certificates.php"target="_blank"><img src="assets/images/comodo_secure_seal_76x26_transp.png" alt="Wildcard SSL" width="76" height="26" style="border: 0px;"></a>, an industry standard for site and information security. Your data is encrypted with 256-bit SSL technology to protect your identity and privacy.</p>
						    </div>
						</div>
					    </li>
					    <li data-step="18">							
						<div class="col-sm-12 boxshadow">
						    <div class="col-sm-12 text-center form-group">
							<div class="head_title">JOB Title</div>
							<div>Please enter what is job role with your employer.</div>
						    </div>
						    <div class="col-sm-4 col-sm-offset-4">
							<div class="col-sm-12 form-group">
							    <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-user-md"></i></span>
								<input type="text" name="JOBTitle" id="JOBTitle" class="form-control triminput" placeholder="JOB Title" maxlength="50" data-regex="^[a-zA-Z0-9 &?*#?,?!?\-?'?.?]{2,}$" value="<?php echo $App->JobTitle ?>">
								<span class="glyphicon form-control-feedback"></span>
							    </div>
							</div>
							<div class="col-sm-12 form-group">
							    <div data-action="BackStep" class="pull-left btn btn-default"><i class="fa fa-arrow-left"></i> &nbsp;</div>
							    <div data-action="NextStep" class="pull-right btn btn-info" data-validate="JOBTitle">Continue <i class="fa fa-arrow-right"></i></div>
							    <div class="clearfix"></div>
							</div>
						    </div>
						</div>
						<div class="col-sm-12 bg-info">
						    <div class="form-group text-center">
							<p><label>Your security is important to us!</label><br>This site is secured by <a href="https://ssl.comodo.com/wildcard-ssl-certificates.php"target="_blank"><img src="assets/images/comodo_secure_seal_76x26_transp.png" alt="Wildcard SSL" width="76" height="26" style="border: 0px;"></a>, an industry standard for site and information security. Your data is encrypted with 256-bit SSL technology to protect your identity and privacy.</p>							    
						    </div>
						</div>
					    </li>
					    <li data-step="19">							
						<div class="col-sm-12 boxshadow">
						    <div class="col-sm-12 text-center form-group">
							<div class="head_title">Employment Started</div>
							<div class="head_text">When did you start your job, please specify date.</div>
						    </div>
						    <div class="col-sm-6 col-sm-offset-3">
							<!-- <div class="col-sm-12 form-group">
							    <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								<input type="text" name="EmploymentStarted" id="EmploymentStarted" class="form-control calendar" placeholder="Employment Start Date"  data-regex="^(0[1-9]|1[0-2])\/(0[1-9]|1\d|2\d|3[01])\/(19|20)\d{2}$" maxlength="0"  data-date-end-date="-2m" data-date-start-date="-230m">
								<span class="glyphicon form-control-feedback"></span>
							    </div>
							</div> --> 
							<div class="col-sm-12 form-group">
							    <div class="col-sm-4 no-padding">
								<div class="input-group">
								    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								    <select name="EmploymentStartedYear" id="EmploymentStartedYear" class="form-control">
									<option value="">Year:</option> 
									<?php for ($i = intval(date("Y")); $i > (intval(date("Y")) - 100); $i--): ?>
									<option value="<?php echo $i; ?>" <?php echo (date("Y",  strtotime($App->EmploymentStarted)) == $i) ? "selected=\"true\"" : "" ?>><?php echo $i; ?></option>
									<?php endfor; ?>
								    </select>
								    <span class="glyphicon form-control-feedback"></span>
								</div>
							    </div>
							    <div class="col-sm-4 no-padding">
								<div class="">									    
								    <select name="EmploymentStartedMonth" id="EmploymentStartedMonth" class="form-control">
									<option value="">Month:</option>
									<option value="01" <?php echo (date("m",  strtotime($App->EmploymentStarted)) == "01") ? "selected=\"true\"" : "" ?>>Jan</option>
									<option value="02" <?php echo (date("m",  strtotime($App->EmploymentStarted)) == "02") ? "selected=\"true\"" : "" ?>>Feb</option>
									<option value="03" <?php echo (date("m",  strtotime($App->EmploymentStarted)) == "03") ? "selected=\"true\"" : "" ?>>Mar</option>
									<option value="04" <?php echo (date("m",  strtotime($App->EmploymentStarted)) == "04") ? "selected=\"true\"" : "" ?>>Apr</option>
									<option value="05" <?php echo (date("m",  strtotime($App->EmploymentStarted)) == "05") ? "selected=\"true\"" : "" ?>>May</option>
									<option value="06" <?php echo (date("m",  strtotime($App->EmploymentStarted)) == "06") ? "selected=\"true\"" : "" ?>>Jun</option>
									<option value="07" <?php echo (date("m",  strtotime($App->EmploymentStarted)) == "07") ? "selected=\"true\"" : "" ?>>Jul</option>
									<option value="08" <?php echo (date("m",  strtotime($App->EmploymentStarted)) == "08") ? "selected=\"true\"" : "" ?>>Aug</option>
									<option value="09" <?php echo (date("m",  strtotime($App->EmploymentStarted)) == "09") ? "selected=\"true\"" : "" ?>>Sep</option>
									<option value="10" <?php echo (date("m",  strtotime($App->EmploymentStarted)) == "10") ? "selected=\"true\"" : "" ?>>Oct</option>
									<option value="11" <?php echo (date("m",  strtotime($App->EmploymentStarted)) == "11") ? "selected=\"true\"" : "" ?>>Nov</option>
									<option value="12" <?php echo (date("m",  strtotime($App->EmploymentStarted)) == "12") ? "selected=\"true\"" : "" ?>>Dec</option>
								    </select>
								    <span class="glyphicon form-control-feedback"></span>
								</div>
							    </div>
							    <div class="col-sm-4 no-padding">
								<div class="">									    
								    <select name="EmploymentStartedDate" id="EmploymentStartedDate" class="form-control">
									<option value="">Date:</option>
									<option selected="" value="<?php echo date("d",  strtotime($App->EmploymentStarted)) ?>"><?php echo date("d",  strtotime($App->EmploymentStarted)) ?></option>
								    </select>
								    <span class="glyphicon form-control-feedback"></span>
								</div>
							    </div>								    
							</div>
							<div class="col-sm-12 form-group">
							    <div data-action="BackStep" class="pull-left btn btn-default"><i class="fa fa-arrow-left"></i> &nbsp;</div>
							    <div data-action="NextStep" class="pull-right btn btn-info" data-validate="EmploymentStartedYear|EmploymentStartedMonth|EmploymentStartedDate">Continue <i class="fa fa-arrow-right"></i></div>
							    <div class="clearfix"></div>
							</div>
						    </div>
						</div>
						<div class="col-sm-12 bg-info">
						    <div class="form-group text-center">
							<p><label>Your security is important to us!</label><br>This site is secured by <a href="https://ssl.comodo.com/wildcard-ssl-certificates.php"target="_blank"><img src="assets/images/comodo_secure_seal_76x26_transp.png" alt="Wildcard SSL" width="76" height="26" style="border: 0px;"></a>, an industry standard for site and information security. Your data is encrypted with 256-bit SSL technology to protect your identity and privacy.</p>
						    </div>
						</div>
					    </li>
					    <li data-step="20">							
						<div class="col-sm-12 boxshadow">
						    <div class="col-sm-12 text-center form-group">
							<div class="head_title">How do you received your paycheck ?</div>
							<div class="head_text">Please choose the method by the employer to pay your salary.</div>
						    </div>
						    <div class="col-sm-4 col-sm-offset-4">
							<div class="col-sm-12 form-group">
							    <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
								<select name="PaymentType" id="PaymentType" class="form-control"> 
								    <option value="">- Select -</option>
								    <option value="1" <?php echo ($App->DirectDeposit == "1") ? "selected=\"true\"" : ""; ?>>Direct Deposit</option>									
								    <option value="0" <?php echo ($App->DirectDeposit == "0") ? "selected=\"true\"" : ""; ?>>Paper Check</option> 
								</select>
								<span class="glyphicon form-control-feedback"></span>
							    </div>
							</div>
							<div class="col-sm-12 form-group">
							    <div data-action="BackStep" class="pull-left btn btn-default"><i class="fa fa-arrow-left"></i> &nbsp;</div>
							    <div data-action="NextStep" class="pull-right btn btn-info" data-validate="PaymentType">Continue <i class="fa fa-arrow-right"></i></div>
							    <div class="clearfix"></div>
							</div>
						    </div>
						</div>
						<div class="col-sm-12 bg-info">
						    <div class="form-group text-center">
							<p><label>Your security is important to us!</label><br>This site is secured by <a href="https://ssl.comodo.com/wildcard-ssl-certificates.php"target="_blank"><img src="assets/images/comodo_secure_seal_76x26_transp.png" alt="Wildcard SSL" width="76" height="26" style="border: 0px;"></a>, an industry standard for site and information security. Your data is encrypted with 256-bit SSL technology to protect your identity and privacy.</p>							    
						    </div>
						</div>
					    </li>						    
					    <li data-step="21">							
						<div class="col-sm-12 boxshadow">
						    <div class="col-sm-12 text-center form-group">
							<div class="head_title">Next Pay Date</div>
							<div class="head_text">Please enter the next date when your salary is due to be paid.</div>
						    </div>
						    <div class="col-sm-4 col-sm-offset-4">
							<div class="col-sm-12 form-group">
							    <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								<input type="text" name="NextPayDate" id="NextPayDate" class="form-control calendar" placeholder="Next Pay Date" data-regex="^(0[1-9]|1[0-2])\/(0[1-9]|1\d|2\d|3[01])\/(19|20)\d{2}$" maxlength="0" data-date-start-date="+1d" data-date-end-date="+30d" value="<?php  echo date("m/d/Y",  strtotime($App->NextPayDate1)); ?>">
								<span class="glyphicon form-control-feedback"></span>
							    </div>
							</div>
							<div class="col-sm-12 form-group">
							    <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								<input type="text" name="FollowPayDate" id="FollowPayDate" class="form-control calendar" placeholder="Follow Pay Date" data-regex="^(0[1-9]|1[0-2])\/(0[1-9]|1\d|2\d|3[01])\/(19|20)\d{2}$" maxlength="0" data-date-start-date="+1d" data-date-end-date="+30d">
								<span class="glyphicon form-control-feedback"></span>
							    </div>
							</div>
							<div class="col-sm-12 form-group">
							    <div data-action="BackStep" class="pull-left btn btn-default"><i class="fa fa-arrow-left"></i> &nbsp;</div>
							    <div data-action="NextStep" class="pull-right btn btn-info" data-validate="NextPayDate|FollowPayDate">Continue <i class="fa fa-arrow-right"></i></div>
							    <div class="clearfix"></div>
							</div>
						    </div>
						</div>
						<div class="col-sm-12 bg-info">
						    <div class="form-group text-center">
							<p><label>Your security is important to us!</label><br>This site is secured by <a href="https://ssl.comodo.com/wildcard-ssl-certificates.php"target="_blank"><img src="assets/images/comodo_secure_seal_76x26_transp.png" alt="Wildcard SSL" width="76" height="26" style="border: 0px;"></a>, an industry standard for site and information security. Your data is encrypted with 256-bit SSL technology to protect your identity and privacy.</p>
						    </div>
						</div>
					    </li>
					    <li data-step="22">							
						<div class="col-sm-12 boxshadow">
						    <div class="col-sm-12 text-center form-group">
							<div class="head_title">Time with Bank Account</div>
							<div class="head_text">When did you open your bank account, please specify date.</div>
						    </div>
						    <div class="col-sm-6 col-sm-offset-3">
							<!-- <div class="col-sm-12 form-group">
							    <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								<input type="text" name="BankAccountOpen" id="BankAccountOpened" class="form-control calendar" placeholder="Bank Account Open Date" data-regex="^(0[1-9]|1[0-2])\/(0[1-9]|1\d|2\d|3[01])\/(19|20)\d{2}$" maxlength="0" data-date-end-date="-1d" data-date-start-date="-40y">
								<span class="glyphicon form-control-feedback"></span>
							    </div>
							</div> -->
							<div class="col-sm-12 form-group">
							    <div class="col-sm-4 no-padding">
								<div class="input-group">
								    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								    <select name="BankAccountOpenYear" id="BankAccountOpenYear" class="form-control">
									<option value="">Year:</option> 
									<?php for ($i = intval(date("Y")); $i > (intval(date("Y")) - 100); $i--): ?>
									<option value="<?php echo $i; ?>" <?php echo (date("Y",  strtotime($App->AccountOpenDate)) == $i) ? "selected=\"true\"" : "" ?>><?php echo $i; ?></option>
									<?php endfor; ?>
								    </select>
								    <span class="glyphicon form-control-feedback"></span>
								</div>
							    </div>
							    <div class="col-sm-4 no-padding">
								<div class="">									    
								    <select name="BankAccountOpenMonth" id="BankAccountOpenMonth" class="form-control">
									<option value="">Month:</option>
									<option value="01" <?php echo (date("m",  strtotime($App->AccountOpenDate)) == "01") ? "selected=\"true\"" : "" ?>>Jan</option>
									<option value="02" <?php echo (date("m",  strtotime($App->AccountOpenDate)) == "02") ? "selected=\"true\"" : "" ?>>Feb</option>
									<option value="03" <?php echo (date("m",  strtotime($App->AccountOpenDate)) == "03") ? "selected=\"true\"" : "" ?>>Mar</option>
									<option value="04" <?php echo (date("m",  strtotime($App->AccountOpenDate)) == "04") ? "selected=\"true\"" : "" ?>>Apr</option>
									<option value="05" <?php echo (date("m",  strtotime($App->AccountOpenDate)) == "05") ? "selected=\"true\"" : "" ?>>May</option>
									<option value="06" <?php echo (date("m",  strtotime($App->AccountOpenDate)) == "06") ? "selected=\"true\"" : "" ?>>Jun</option>
									<option value="07" <?php echo (date("m",  strtotime($App->AccountOpenDate)) == "07") ? "selected=\"true\"" : "" ?>>Jul</option>
									<option value="08" <?php echo (date("m",  strtotime($App->AccountOpenDate)) == "08") ? "selected=\"true\"" : "" ?>>Aug</option>
									<option value="09" <?php echo (date("m",  strtotime($App->AccountOpenDate)) == "09") ? "selected=\"true\"" : "" ?>>Sep</option>
									<option value="10" <?php echo (date("m",  strtotime($App->AccountOpenDate)) == "10") ? "selected=\"true\"" : "" ?>>Oct</option>
									<option value="11" <?php echo (date("m",  strtotime($App->AccountOpenDate)) == "11") ? "selected=\"true\"" : "" ?>>Nov</option>
									<option value="12" <?php echo (date("m",  strtotime($App->AccountOpenDate)) == "12") ? "selected=\"true\"" : "" ?>>Dec</option>
								    </select>
								    <span class="glyphicon form-control-feedback"></span>
								</div>
							    </div>
							    <div class="col-sm-4 no-padding">
								<div class="">									    
								    <select name="BankAccountOpenDate" id="BankAccountOpenDate" class="form-control">
									<option value="">Date:</option>
									<option selected="" value="<?php echo date("d",  strtotime($App->AccountOpenDate)) ?>"><?php echo date("d",  strtotime($App->AccountOpenDate)) ?></option>
								    </select>
								    <span class="glyphicon form-control-feedback"></span>
								</div>
							    </div>								    
							</div>
							<div class="col-sm-12 form-group">
							    <div data-action="BackStep" class="pull-left btn btn-default"><i class="fa fa-arrow-left"></i> &nbsp;</div>
							    <div data-action="NextStep" class="pull-right btn btn-info" data-validate="BankAccountOpenYear|BankAccountOpenMonth|BankAccountOpenDate">Continue <i class="fa fa-arrow-right"></i></div>
							    <div class="clearfix"></div>
							</div>
						    </div>
						</div>
						<div class="col-sm-12 bg-info">
						    <div class="form-group text-center">
							<p><label>Your security is important to us!</label><br>This site is secured by <a href="https://ssl.comodo.com/wildcard-ssl-certificates.php"target="_blank"><img src="assets/images/comodo_secure_seal_76x26_transp.png" alt="Wildcard SSL" width="76" height="26" style="border: 0px;"></a>, an industry standard for site and information security. Your data is encrypted with 256-bit SSL technology to protect your identity and privacy.</p>							    
						    </div>
						</div>
					    </li>					    					
					    <li data-step="23">							
						<div class="col-sm-12 boxshadow">
						    <div class="col-sm-12 text-center form-group">
							<div class="head_title">Type of Bank Account</div>
							<div class="head_text">Which type of bank account your have ?</div>
						    </div>
						    <div class="col-sm-4 col-sm-offset-4">
							<div class="col-sm-12 form-group">
							    <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-credit-card"></i></span>								    
								<select name="BankAccountType" id="BankAccountType" class="form-control" required="">
								    <option value="">- Select - </option>
								    <option value="CHECKING" <?php echo ($App->BankAccountType == "CHECKING") ? "selected=\"true\"" : ""  ?> >CHECKING</option>
								    <option value="SAVINGS" <?php echo ($App->BankAccountType == "SAVINGS") ? "selected=\"true\"" : ""  ?>>SAVING</option>
								</select>
								<span class="glyphicon form-control-feedback"></span>
							    </div>
							</div>
							<div class="col-sm-12 form-group">
							    <div data-action="BackStep" class="pull-left btn btn-default"><i class="fa fa-arrow-left"></i> &nbsp;</div>
							    <div data-action="NextStep" class="pull-right btn btn-info" data-validate="BankAccountType">Continue <i class="fa fa-arrow-right"></i></div>
							    <div class="clearfix"></div>
							</div>
						    </div>							
						</div>
						<div class="col-sm-12 bg-info">
						    <div class="form-group text-center">
							<p><label>Your security is important to us!</label><br>This site is secured by <a href="https://ssl.comodo.com/wildcard-ssl-certificates.php"target="_blank"><img src="assets/images/comodo_secure_seal_76x26_transp.png" alt="Wildcard SSL" width="76" height="26" style="border: 0px;"></a>, an industry standard for site and information security. Your data is encrypted with 256-bit SSL technology to protect your identity and privacy.</p>							    
						    </div>
						</div>
					    </li>
					    <li data-step="24">							
						<div class="col-sm-12 boxshadow">
						    <div class="col-sm-12 text-center form-group">
							<div class="head_title">Bank Details</div>
							<div>Please enter the account detail you would like to get the money deposited into.</div>
						    </div>
						    <div class="col-sm-4 col-sm-offset-4">
							<div class="col-sm-12">
							    <div class="form-group">
								<div class="input-group">
								    <span class="input-group-addon"><i class="fa fa-bank"></i></span>
								    <input type="text" name="BankName" id="BankName" class="form-control triminput" placeholder="Bank Name" maxlength="50" data-regex="^[a-zA-Z .]{2,}$" value="<?php echo $App->BankName ?>">
								    <span class="glyphicon form-control-feedback"></span>
								</div>
							    </div>
							    <div class="form-group">
								<div class="input-group">
								    <span class="input-group-addon"><i class="fa fa-credit-card-alt"></i></span>
								    <input type="tel" name="BankABA" id="BankABA" class="form-control numonly" placeholder="ABA/Routing Number" maxlength="9" data-regex="[^5]{1}[0-9]{8}$" value="<?php echo $App->BankABA ?>">
								    <span class="glyphicon form-control-feedback"></span>
								</div>
							    </div>
							    <div class="form-group">
								<div class="input-group">
								    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
								    <input type="tel" name="AccountNumber" id="AccountNumber numonly" class="form-control" placeholder="Account Number" maxlength="30" data-regex="[0-9]{4}$" value="<?php echo $App->BankAccountNumber ?>">
								    <span class="glyphicon form-control-feedback"></span>
								</div>
							    </div>
							    <div class="form-group">
								<label class="checkbox-inline">
								    <input type="checkbox" name="AcceptedTerms" id="AcceptedTerms" value="1">
								    I Accept Terms & Conditions.
								</label>
								<div id="AcceptError"></div>
							    </div>
							    <div class="col-sm-12 form-group text-center">
								<button type="button" data-loading-text="Processing.." class="btn btn-primary btn-block submitButton" data-validate="BankName|BankABA|AccountNumber"><i class="fa fa-lock fa-fw"></i> Submit Now</button>
							    </div>
							</div>
							<div class="col-sm-12 form-group text-center">
							    <div data-action="BackStep" class="pull-left btn btn-default"><i class="fa fa-arrow-left"></i> &nbsp;</div>								
							    <div class="clearfix"></div>
							</div>							    
						    </div>							
						</div>
						<div class="col-sm-12 bg-info">
						    <div class="form-group text-center">
							<p><label>Your security is important to us!</label><br>This site is secured by <a href="https://ssl.comodo.com/wildcard-ssl-certificates.php"target="_blank"><img src="assets/images/comodo_secure_seal_76x26_transp.png" alt="Wildcard SSL" width="76" height="26" style="border: 0px;"></a>, an industry standard for site and information security. Your data is encrypted with 256-bit SSL technology to protect your identity and privacy.</p>							    
						    </div>
						</div>
					    </li>
					</ul>						
				    </form>
				</div>
			    </div>
			</div>
		    </div>
		</div>
	    </div>
	</div>
    </section>  
</div>
<script type="text/javascript"> var $TodayDate = new Date("<?php echo date("Y-m-d") ?>"); </script>
<script src="<?php echo base_url() ?>assets/brower_component/jqueryui/jquery-ui.js" type="text/javascript"></script>    
<script src="<?php echo base_url() ?>assets/brower_component/inputmask/inputmask/inputmask.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/brower_component/inputmask/inputmask/jquery.inputmask.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/brower_component/inputmask/inputmask/inputmask.extensions.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/brower_component/inputmask/inputmask/inputmask.phone.extensions.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/brower_component/inputmask/inputmask/inputmask.regex.extensions.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/brower_component/datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/brower_component/salert/sweetalert.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/js/applyform.js" type="text/javascript"></script>