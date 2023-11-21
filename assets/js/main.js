$(document).ready(function () {

     if ($('#primary-nav').length) {
	$('html, body').animate({
	    scrollTop: $('#primary-nav').offset().top
	}, 1);

	num = $('#primary-nav').offset().top + 80;
	$(window).bind('scroll', function () {
	    if ($(window).scrollTop() > num) {
		$('#primary-nav').addClass('navbar-fixed-top');
		$('#primary-nav').css({"background": "#fff", "transition": "all 0.3s ease 0s"});
		$('a').css({"text-decoration": "none"});
		$('a.logo').html('<img src="assets/images/logo.png"  style="position:absolute;top:0;"><h1 style="color:#333;;margin-left:100px;font-size:20pt;">Personalized Loan Quote</h1>');
	    } else {
		$('#primary-nav').removeClass('navbar-fixed-top');
		$('#primary-nav').css({"background": "none", "transition": "all 0.4s ease 0s"});
		$('a').css({"text-decoration": "none"});
		$('a.logo').html('<img src="assets/images/logo.png" style="position:relative;top:-18px;"><h1  style="color:#fff;margin-left:100px;font-size:20pt;">Personalized Loan Quote</h1>');
	    }
	});
    } 

});