<div class="hero-container">
    <div class="container"> 
	<?php include_once 'common/menu.php'; ?>	
    </div>
    <section id="home-hero">
	<div class="container-fluid">
	    <div class="row">
		<div class="col-sm-12">
		    <div class="container home-hero-content">			    
			<div class="row">
			    <div id="formBox0">
				<div class="col-sm-12">
				    <h1 class="index-headline text-center animated fadeIn">Make Your Bank Account Happy <br>Secure a Personal Loan Today</h1>
				</div>
				<div class="col-sm-10 col-sm-offset-1 animated bounceIn">
				    <div>
					<div class="row">						    
					    <div class="col-sm-8 col-sm-offset-2">
						<form action="<?php echo base_url("apply") ?>" id="form-miniform" method="post" class="form-inline" novalidate role="form">
						    <input type="hidden" name="s1" value="<?php echo $s1 ?>">
						    <input type="hidden" name="s2" value="<?php echo $s2 ?>">
						    <input type="hidden" name="s3" value="<?php echo $s3 ?>">
						    <input type="hidden" name="s4" value="<?php echo $s4 ?>">
						    <div class="input-wrapper input-zipcode form-group">
							<input id="zipcode" name="zipcode" required placeholder="Zip Code" class="zipcodemask form-control infield-label input-lg zipcodemask" type="tel" autocomplete="off" maxlength="5" data-valid="" data-type="zipcode" value="<?php echo $POSTALCODE ?>">
						    </div>
						    <div class="input-wrapper input-button">
							<button  type="submit" name="submit-btn" value="1" class="btn btn-lg btn-warning bigbutton submitzip" data-loading-text="Processing..">
							    <h3>GO <i class="fa fa-arrow-circle-right"></i></h3>
							</button>
						    </div>							
						</form> 
					    </div>
					</div>
					<div class="row">
					    <div class="col-sm-8 col-sm-offset-2 text-center">
						<p class="miniform-disclaimer"><small><span class="ny-disclaimer t-d-n">By submitting a loan application you knowingly agree to the privacy policy, terms of use and e-consent. All application data is securely captured via a 256-bit SSL encryption process. Loans are not available in all states.</span></small> </p>
					    </div>
					</div>
				    </div>
				</div>
			    </div>				    
			</div>
		    </div>
		</div>
	    </div>
	</div>
    </section>
</div>
<?php include_once 'common/header_bottom.php'; ?>
<section id="home-promos" class="section-padding section-padding-1">
    <div class="container-fluid">
	<div class="row">
	    <div class="col-sm-12 col-xs-12">
		<div class="container">
		    <div class="row">
			<div class="col-sm-6 col-xs-12 promo-trust feature-left">
			    <h3 class="text-left"><i class="fa fa-hand-o-right" aria-hidden="true"></i> You Can Trust Us</h3>
			    <p class="text-left lead">
				This site is secured by <a href="https://ssl.comodo.com/wildcard-ssl-certificates.php"target="_blank"><img src="https://ssl.comodo.com/images/comodo_secure_seal_76x26_transp.png" alt="Wildcard SSL" width="76" height="26" style="border: 0px;"></a> an industry standard for site and information security. Data is encrypted with 256-bit SSL technology to protect applicant’s identity and privacy.<!--We make it easier to get the funds you need. Simply fill out our form, and we'll do the rest! We use Thawte, 256-bit encryption technology and other leading security safeguards.--></p>
			</div>
			<div class="col-sm-6 col-xs-12 promo-howitworks feature-right">
			    <h3 class="text-left"><i class="fa fa-check-square-o" aria-hidden="true"></i> Know the Process</h3>
			    <p class="text-left lead"><a href="#home-hero"></a>After submitting an application you will be redirected to a lender's website to review loan terms. If terms are accepted, money will be deposited into your bank account as soon as the next business day.</p>

			</div>
		    </div>
		    <div class="row">
			<div class="col-sm-6 col-xs-12 promo-howitworks feature-left">
			    <h3 class="text-left"><i class="fa fa-paper-plane-o" aria-hidden="true"></i> Simple<span class="dot">.</span> Fast<span class="dot">.</span> Easy<span class="dot">.</span></h3>
			    <p class="text-left lead">Our loan application platform immediately connects you with personal, installment and short-term lenders.</p>
			    <p class="text-left lead">The application only takes a few minutes to complete. Just tell us about your lending needs, then one of MyLoanQuote’s friendly and helpful financial partners will contact you to discuss the lending options available.</p>
			    <p class="text-left lead">Stop driving to the bank or the check cashing store. Submit your online lending request today. Why wait? </p>
			</div>
			<div class="col-sm-6 col-xs-12 promo-customerservice feature-right">
			    <h3 class="text-left"><i class="fa fa-clock-o" aria-hidden="true"></i> Why Wait? Time is Ticking!</h3>
			    <p class="text-left lead">We look forward to hearing from you!</p>
			    <div class="row">
				<div class="col-md-9 col-xs-12">
				    <ul class="list-unstyled list-unstyled-1">
					<li><i class="fa fa-check" aria-hidden="true"></i> Fast, Friendly, Trusted</li>
					<li><i class="fa fa-check" aria-hidden="true"></i> All Credit Types Accepted</li>
					<li><i class="fa fa-check" aria-hidden="true"></i> Applications Processed Real-Time</li>
					<li><i class="fa fa-check" aria-hidden="true"></i> Bank Account Direct Deposits</li>
				    </ul>
				</div>
			    </div>
			</div>
		    </div>

		    <div class="row">
			<div class="col-sm-6 col-xs-12 promo-howitworks feature-left">
			    <h3 class="text-left"><i class="fa fa-home" aria-hidden="true"></i> Personal Loans</h3>
			    <p class="text-left lead">Personal loans cover “unsecured” debts, because they are not backed by collateral, i.e. all types of short-term borrowing needs, such as debt consolidation, higher education and college expenses, wedding/honeymoon, home improvement, medical expenses, moving costs, etc. Our lending partners will use your credit score to help determine whether to give you a personal loan and at what interest rate.</p>

			</div>
			<div class="col-sm-6 col-xs-12 promo-customerservice feature-right">
			    <h3 class="text-left"><i class="fa fa-money" aria-hidden="true"></i> Installment Loans</h3>
			    <p class="text-left lead">Installment loans are repaid over time with a set number of scheduled payments; helping consumers repay loans within a manageable  timeframe on a monthly or bi-monthly basis. The term of the loan may be as little as a few months and as long as 30 years with or without variable interest rates.</p>
			</div>
		    </div>

		    <div class="row">
			<div class="col-sm-6 col-xs-12 promo-howitworks feature-left">
			    <h3 class="text-left"><i class="fa fa-briefcase" aria-hidden="true"></i> Business Loans</h3>
			    <p class="text-left lead">This type of loan can fund, expand or re-finance a qualifying business venture. Amounts can go up to $1,500,000 and be funded in 3 days. Our partner offers high approval rates, can work with bad credit and extend flexible payment terms 3-24 months in duration. <a target="_blank" href="https://mychoicefin.adtrk.biz/?a=12&c=4&p=r&s1=#affid#&s2=#s1#&s3=#reqid#&s4=#oid#&s5=#s1#;#s2#;#s3#;#s4#;#s5#">LEARN MORE</a>
			    </p>
			</div>
			<div class="col-sm-6 col-xs-12 promo-customerservice feature-right">
			</div>
		    </div>				
		</div>
	    </div>
	</div>
    </div>
</section>
<link href="<?php echo base_url() ?>assets/brower_component/salert/sweetalert.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url() ?>assets/brower_component/inputmask/inputmask/inputmask.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/brower_component/inputmask/inputmask/jquery.inputmask.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/brower_component/inputmask/inputmask/inputmask.extensions.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/brower_component/inputmask/inputmask/inputmask.regex.extensions.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/brower_component/inputmask/min/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/brower_component/salert/sweetalert.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/js/homepage.js" type="text/javascript"></script>