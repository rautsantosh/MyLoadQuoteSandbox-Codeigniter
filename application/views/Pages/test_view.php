<!DOCTYPE HTML>
<html>
    <head>
	<title>Processing..</title>
	<link href="<?php echo base_url() ?>assets/brower_component/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo base_url() ?>assets/brower_component/datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css"/>

	<script src="<?php echo base_url() ?>assets/brower_component/jquery/jquery-1.9.1.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url() ?>assets/brower_component/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url() ?>assets/brower_component/datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
    </head>
    <body>
	<div class="container"> 
	    <p><br></p>
	    <div class="form-group">
		<div class="col-sm-12 form-group">
		    <div class="col-sm-4 no-padding">
			<div class="input-group">
			    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
			    <select name="BirthdayYear" id="BirthdayYear" class="form-control">
				<option value="">Year:</option> 
				<?php for ($i = intval(date("Y", strtotime("-18 years"))); $i > (intval(date("Y")) - 100); $i--): ?>
    				<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php endfor; ?>
			    </select>
			    <span class="glyphicon form-control-feedback"></span>
			</div>
		    </div>
		    <div class="col-sm-4 no-padding">
			<select name="BirthdayMonth" id="BirthdayMonth" class="form-control">
			    <option value="">Month:</option>
			    <option value="01">Jan</option>
			    <option value="02">Feb</option>
			    <option value="03">Mar</option>
			    <option value="04">Apr</option>
			    <option value="05">May</option>
			    <option value="06">Jun</option>
			    <option value="07">Jul</option>
			    <option value="08">Aug</option>
			    <option value="09">Sep</option>
			    <option value="10">Oct</option>
			    <option value="11">Nov</option>
			    <option value="12">Dec</option>
			</select>
			<span class="glyphicon form-control-feedback"></span>									
		    </div>
		    <div class="col-sm-4 no-padding">
			<select name="BirthdayDate" id="BirthdayDate" class="form-control">
			    <option value="">Date:</option>
			</select>
			<span class="glyphicon form-control-feedback"></span>									
		    </div>								    
		</div>
	    </div>
	    <div class="form-group">
		<button id="btn">Check Now</button>
	    </div>
	</div>
	<script type="text/javascript">
	    $Today = new Date("<?php echo date("Y-m-d"); ?>");

	    $("#btn").click(function () {
		var $temp = $("#BirthdayYear").val() + "-" + $("#BirthdayMonth").val() + "-" + $("#BirthdayDate").val();
		var $Birthday = new Date($temp)
		var $Age = _calculateAge($Birthday);
		console.log("Your Age " + $Age);
	    });

	    function _calculateAge(birthday) { // birthday is a date
		var ageDifMs = $Today - birthday.getTime();
		var ageDate = new Date(ageDifMs); // miliseconds from epoch
		return Math.abs(ageDate.getUTCFullYear() - 1970);
	    }
	    function populateDates($limit, $Id) {
		$("#" + $Id).html('<option value="">Date:</option>');
		for (var $i = 0; $i < $limit; $i++) {
		    if (($i + 1) === $dob_day) {
			$("#" + $Id).append('<option selected="" value="' + ($i + 1) + '">' + ($i + 1) + '</option>');
		    } else {
			$("#" + $Id).append('<option value="' + ($i + 1) + '">' + ($i + 1) + '</option>');
		    }
		}
	    }

	    var $dob_day = null;
	    $(function () {
		//var $month, $day, $year = "";		
		var $monthsday = [31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
		$("#BirthdayMonth").on("change", function () {
		    var $month = $(this).val();
		    $month = parseInt($month);
		    var $year = $("#BirthdayYear").val();
		    if ($month === 2) {
			if ($year % 4 === 0) {
			    populateDates($monthsday[$month - 1], 'BirthdayDate');
			} else {
			    populateDates($monthsday[$month - 1] - 1, 'BirthdayDate');
			}
		    } else {
			populateDates($monthsday[$month - 1], 'BirthdayDate');
		    }
		});
		$("#BirthdayYear").on("change", function () {
		    $dob_day = $(this).val();
		});
		$("#BirthdayYear").on("change", function () {
		    var $month = $("#BirthdayMonth").val();
		    var $year = $(this).val();

		    $month = parseInt($month);
		    $year = parseInt($year);

		    if ($month === 2) {
			if ($year % 4 === 0) {
			    populateDates($monthsday[$month - 1], 'BirthdayDate');
			} else {
			    populateDates($monthsday[$month - 1] - 1, 'BirthdayDate');
			}
		    } else {
			populateDates($monthsday[$month - 1]);
		    }
		});
	    });
	</script>

	<script language = "Javascript">
	    /**
	     * DHTML phone number validation script. Courtesy of SmartWebby.com (http://www.smartwebby.com/dhtml/)
	     */

// Declaring required variables
	    var digits = "0123456789";
// non-digit characters which are allowed in phone numbers
	    var phoneNumberDelimiters = "()- ";
// characters which are allowed in international phone numbers
// (a leading + is OK)
	    var validWorldPhoneChars = phoneNumberDelimiters + "+";
// Minimum no of digits in an international phone no.
	    var minDigitsInIPhoneNumber = 10;
// Maximum no of digits in an america phone no.
	    var maxDigitsInIPhoneNumber = 13;
//US Area Code
	    var AreaCode = new Array(205, 251, 659, 256, 334, 907, 403, 780, 264, 268, 520, 928, 480, 602, 623, 501, 479, 870, 242, 246, 441, 250, 604, 778, 284, 341, 442, 628, 657, 669, 747, 752, 764, 951, 209, 559, 408, 831, 510, 213, 310, 424, 323, 562, 707, 369, 627, 530, 714, 949, 626, 909, 916, 760, 619, 858, 935, 818, 415, 925, 661, 805, 650, 600, 809, 345, 670, 211, 720, 970, 303, 719, 203, 475, 860, 959, 302, 411, 202, 767, 911, 239, 386, 689, 754, 941, 954, 561, 407, 727, 352, 904, 850, 786, 863, 305, 321, 813, 470, 478, 770, 678, 404, 706, 912, 229, 710, 473, 671, 808, 208, 312, 773, 630, 847, 708, 815, 224, 331, 464, 872, 217, 618, 309, 260, 317, 219, 765, 812, 563, 641, 515, 319, 712, 876, 620, 785, 913, 316, 270, 859, 606, 502, 225, 337, 985, 504, 318, 318, 204, 227, 240, 443, 667, 410, 301, 339, 351, 774, 781, 857, 978, 508, 617, 413, 231, 269, 989, 734, 517, 313, 810, 248, 278, 586, 679, 947, 906, 616, 320, 612, 763, 952, 218, 507, 651, 228, 601, 557, 573, 636, 660, 975, 314, 816, 417, 664, 406, 402, 308, 775, 702, 506, 603, 551, 848, 862, 732, 908, 201, 973, 609, 856, 505, 575, 585, 845, 917, 516, 212, 646, 315, 518, 347, 718, 607, 914, 631, 716, 709, 252, 336, 828, 910, 980, 984, 919, 704, 701, 283, 380, 567, 216, 614, 937, 330, 234, 440, 419, 740, 513, 580, 918, 405, 905, 289, 647, 705, 807, 613, 519, 416, 503, 541, 971, 445, 610, 835, 878, 484, 717, 570, 412, 215, 267, 814, 724, 902, 787, 939, 438, 450, 819, 418, 514, 401, 306, 803, 843, 864, 605, 869, 758, 784, 731, 865, 931, 423, 615, 901, 325, 361, 430, 432, 469, 682, 737, 979, 214, 972, 254, 940, 713, 281, 832, 956, 817, 806, 903, 210, 830, 409, 936, 512, 915, 868, 649, 340, 385, 435, 801, 802, 276, 434, 540, 571, 757, 703, 804, 509, 206, 425, 253, 360, 564, 304, 262, 920, 414, 715, 608, 307, 867)

	    function isInteger(s)
	    {
		var i;
		for (i = 0; i < s.length; i++)
		{
		    // Check that current character is number.
		    var c = s.charAt(i);
		    if (((c < "0") || (c > "9")))
			return false;
		}
		// All characters are numbers.
		return true;
	    }

	    function stripCharsInBag(s, bag)
	    {
		var i;
		var returnString = "";
		// Search through string's characters one by one.
		// If character is not in bag, append to returnString.
		for (i = 0; i < s.length; i++)
		{
		    // Check that current character isn't whitespace.
		    var c = s.charAt(i);
		    if (bag.indexOf(c) == -1)
			returnString += c;
		}
		return returnString;
	    }
	    function trim(s)
	    {
		var i;
		var returnString = "";
		// Search through string's characters one by one.
		// If character is not a whitespace, append to returnString.
		for (i = 0; i < s.length; i++)
		{
		    // Check that current character isn't whitespace.
		    var c = s.charAt(i);
		    if (c != " ")
			returnString += c;
		}
		return returnString;
	    }
	    function checkInternationalPhone(strPhone) {
		strPhone = trim(strPhone)
		if (strPhone.indexOf("00") == 0)
		    strPhone = strPhone.substring(2)
		if (strPhone.indexOf("+") > 1)
		    return false
		if (strPhone.indexOf("+") == 0)
		    strPhone = strPhone.substring(1)
		if (strPhone.indexOf("(") == -1 && strPhone.indexOf(")") != -1)
		    return false
		if (strPhone.indexOf("(") != -1 && strPhone.indexOf(")") == -1)
		    return false
		s = stripCharsInBag(strPhone, validWorldPhoneChars);
		if (strPhone.length > 10) {
		    var CCode = s.substring(0, s.length - 10);
		}
		else {
		    CCode = "";
		}
		if (strPhone.length > 7) {
		    var NPA = s.substring(s.length - 10, s.length - 7);
		}
		else {
		    NPA = ""
		}
		var NEC = s.substring(s.length - 7, s.length - 4)
		if (CCode != "" && CCode != null) {
		    if (CCode != "1" && CCode != "011" && CCode != "001")
			return false
		}
		if (NPA != "") {
		    if (checkAreaCode(NPA) == false) { //Checking area code is vaid or not
			return false
		    }
		}
		else {
		    return false
		}
		return (isInteger(s) && s.length >= minDigitsInIPhoneNumber && s.length <= maxDigitsInIPhoneNumber);
	    }
//Checking area code is vaid or not
	    function checkAreaCode(val) {
		var res = false;
		for (var i = 0; i < AreaCode.length; i++) {
		    if (AreaCode[i] == val)
			res = true;
		}
		return res
	    }

	    function ValidateForm() {
		var Phone = document.frmSample.txtPhone

		if ((Phone.value == null) || (Phone.value == "")) {
		    alert("Please Enter your Phone Number")
		    Phone.focus()
		    return false
		}
		if (checkInternationalPhone(Phone.value) == false) {
		    alert("Please Enter a Valid Phone Number")
		    Phone.value = ""
		    Phone.focus()
		    return false
		}
		return true
	    }
	</script>
    </body>
</html>