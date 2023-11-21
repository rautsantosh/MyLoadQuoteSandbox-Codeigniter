var $FocusField = null;
var site_link = false;
$(document).ready(function () {

    //check if site was clicked somewhere on the page (within #wholePageWrapper)
    $(document).click(function (e) {
	var d = e.target;
	while (d != null && d['id'] != 'wholePageWrapper') {
	    d = d.parentNode;
	}
	var site_click = (d != null && d['id'] == 'wholePageWrapper');
	if (site_click) {
	    site_link = true;
	}
    });

    $("form").submit(function (event) {
	site_link = true;
    });

    $(window).bind('beforeunload', function (e) {
	if (!site_link) {
	    if (confirm('Are you sure you want to leave this site?')) {
		return true;
	    } else {
		if (window.event) {
		    window.event.returnValue = false;
		} else {
		    e.preventDefault();
		}
		return false;
	    }
	}
	site_link = false;
    });
});

function waitModal(flag) {
    if (flag) {
	$(".waitModal").show();
	$(".waitModal").fadeTo(0, 1);
    } else {
	$(".waitModal").hide();
    }
}
$(document).ready(function () {
    $(".numonly").keypress(function (e) {
	var allow = "1234567890.";
	var code;
	if (window.event)
	    code = e.keyCode;
	else
	    code = e.which;
	if (code === 8 || code === 0 || $.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1)
	    return true;
	var ch = keychar = String.fromCharCode(code);
	if (allow.indexOf(ch) === -1)
	    return false;
    });
    waitModal(false);
    var $duration = 400;
    var $animation = 'slide';
    updateProgress(1);
    $(".triminput").keyup(function () {
	/* var $val = $(this).val();
	 $val = $val.replace(/\s\s+/g, ' ');	
	 $(this).val($val); */
    });
    $(".triminput").blur(function () {
	/* var $val = $(this).val();
	 $val = $.trim($val);
	 $(this).val($val); */
    });
    var $PayFrequency = 0;
    $("#PayFrequency").change(function () {
	$("#FollowPayDate").prop('readonly', false);
	$("#NextPayDate").val("");
	$("#FollowPayDate").val("")
	var $val = $(this).val();
	if ($val === "WEEKLY") {
	    $PayFrequency = 7;
	}
	if ($val === "BIWEEKLY") {
	    $PayFrequency = 14;
	}
	if ($val === "SEMIMONTHLY") {
	    $PayFrequency = 15;
	}
	if ($val === "MONTHLY") {
	    $PayFrequency = 31;
	}

	var $enDate = $PayFrequency;
	$("#NextPayDate").datepicker('remove');
	$("#NextPayDate").datepicker({
	    format: 'mm/dd/yyyy',
	    daysOfWeekDisabled: [0, 6],
	    endDate: "+" + $enDate + "d",
	    autoclose: false
	});
    });
    $("#NextPayDate").datepicker({
	format: 'mm/dd/yyyy',
	daysOfWeekDisabled: [0, 6],
	autoclose: false
    }).on("changeDate", function () {
	$("#FollowPayDate").val("");
	$("#FollowPayDate").prop('readonly', false);
	var $NextPayDate1Val = $("#NextPayDate").val();
	$NextPayDate1Val = $NextPayDate1Val.split("/");
	//var $NextPayDate1 = Date.today().set({year: parseInt($NextPayDate1Val[2]), month: parseInt($NextPayDate1Val[0] - 1), day: parseInt($NextPayDate1Val[1])});
	if (true) {
	    //$NextPayDate1.today().add($PayFrequency).day();
	    if ($PayFrequency === 7 || $PayFrequency === 14 || $PayFrequency === 15) {
		var $Date = Date.today().set({year: parseInt($NextPayDate1Val[2]), month: parseInt($NextPayDate1Val[0] - 1), day: parseInt($NextPayDate1Val[1])}).add($PayFrequency).day();
		if ($Date.is().saturday()) {
		    $Date = $Date.add(2).day();
		}
		if ($Date.is().sunday()) {
		    $Date = $Date.add(1).day();
		}
	    } else {
		var $Date = Date.today().set({year: parseInt($NextPayDate1Val[2]), month: parseInt($NextPayDate1Val[0] - 1), day: parseInt($NextPayDate1Val[1])}).add(1).month().add(-1).day();
		if ($Date.is().saturday()) {
		    $Date = $Date.add(2).day();
		}
		if ($Date.is().sunday()) {
		    $Date = $Date.add(1).day();
		}
	    }
	    var $dateVal = ('0' + (parseInt($Date.getMonth()) + 1)).slice(-2) + "/" + ('0' + $Date.getDate()).slice(-2) + "/" + $Date.getFullYear();
	    $("#FollowPayDate").val($dateVal)
	    $("#FollowPayDate").prop('readonly', true);
	} else {

	    $("#FollowPayDate").datepicker('remove');
	    $('#FollowPayDate').datepicker({
		startDate: new Date($MinDate),
		daysOfWeekDisabled: [0, 6],
		endDate: new Date($MaxDate)
	    });
	}
    });
    /* 
     var $enDateVal = 1;
     var $enDate = "+7d";
     $("#PayFrequency").change(function () {
     var $val = $(this).val();	
     if ($val === "WEEKLY") {
     //$("#NextPayDate").attr('data-date-end-date', "+7d");
     $enDate = "+7d";
     $enDateVal = 7;
     }
     if ($val === "BIWEEKLY") {
     //$("#NextPayDate").attr('data-date-end-date', "+14d");
     $enDate = "+14d";
     $enDateVal = 14;
     }
     if ($val === "SEMIMONTHLY") {
     $enDate = "+15d";
     $enDateVal = 15;
     }
     if ($val === "MONTHLY") {
     //$("#NextPayDate").attr('data-date-end-date', "+30d");
     $enDate = "+31d";
     $enDateVal = 31;
     }
     $("#NextPayDate").datepicker('remove');
     $("#NextPayDate").datepicker({
     format: 'mm/dd/yyyy',
     daysOfWeekDisabled: [0, 6],
     endDate: $enDate,
     autoclose: false
     });
     });
     
     $("#FollowPayDate").datepicker({
     format: 'mm/dd/yyyy',
     daysOfWeekDisabled: [0, 6]
     });
     
     $("#NextPayDate").blur(function () {
     $("#FollowPayDate").val("");
     });
     
     $("#NextPayDate").datepicker({
     format: 'mm/dd/yyyy',
     daysOfWeekDisabled: [0, 6],
     autoclose: false
     }).on("changeDate", function () {
     var $dateVal = $("#NextPayDate").val();
     $dateVal = $dateVal.split("/");
     var $Date = new Date($dateVal[2], (parseInt($dateVal[0]) - 1), $dateVal[1]);
     var $MinDate = $Date.setDate($Date.getDate() + 1);
     var $MaxDate = $Date.setDate($Date.getDate() + 45);
     $("#FollowPayDate").datepicker('remove');
     $('#FollowPayDate').datepicker({
     startDate: new Date($MinDate),
     daysOfWeekDisabled: [0, 6],
     endDate: new Date($MaxDate)
     });
     }); */
    $(".phonemask").inputmask("phone", {
	regex: /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/,
	mask: "(999) 999-9999",
	greedy: true
    });
    $(".zipcodemask").inputmask("Regex", {
	regex: /^\d{5}$/,
	mask: "99999",
	greedy: true
    });
    $("#SSN").inputmask("Regex", {
	regex: /^\d{3}-?\d{2}-?\d{4}$/,
	mask: "999-99-9999",
	greedy: true
    });
    $("[data-action='NextStep']").on("click", function () {
	if (validateInputs($(this).attr('data-validate')) === false) {
	    $FocusField.focus();
	    $FocusField = null;
	    return;
	}
	var $step = $(this).parent('div').parent('div').parent('div').parent('li');
	var $current_step = $step.attr('data-step');
	$current_step = parseInt($current_step) + 1;
	if ($current_step === 5) {
	    postQuery();
	}
	updateProgress($current_step);
	var $nextstep = $($step).next('li');
	$step.hide($animation, {direction: 'right'}, $duration);
	setTimeout(function () {
	    $nextstep.show($animation, {direction: 'left'}, $duration);
	}, $duration + 8);
    });
    $("[data-action='BackStep']").on("click", function () {
	var $step = $(this).parent('div').parent('div').parent('div').parent('li');
	var $current_step = $step.attr('data-step');
	$current_step = parseInt($current_step) - 1;
	updateProgress($current_step);
	var $prevstep = $($step).prev('li');
	$step.hide($animation, {direction: 'left'}, $duration);
	setTimeout(function () {
	    $prevstep.show($animation, {direction: 'right'}, $duration);
	}, $duration + 10);

    });
    $("input[input-mask='true']").inputmask("Regex", {
	regex: new RegExp($(this).attr('data-regex')),
	mask: $(this).attr('mark-pattern')
    });
    $(".submitButton").click(function () {
	if (validateInputs($(this).attr('data-validate')) === false) {
	    $FocusField.focus();
	    $FocusField = null;
	    return;
	}
	if (validRoutingNumber($("#BankABA").val()) === false) {
	    swal("Invalid entry. Please provide a valid routing number.");
	    var $Field = $("#BankABA");
	    setFieldError($Field, true);
	    $(this).focus();
	    return;
	}
	if ($("#AccountNumber").val().length < 6) {
	    swal("Invalid entry. Please provide a valid account number.");
	    var $Field = $("#AccountNumber");
	    setFieldError($Field, true);
	    $(this).focus();
	    return;
	}
	var $AcceptError = $("#AcceptError");
	var $AcceptedTerms = $("#AcceptedTerms");
	$AcceptError.html('');
	if ($AcceptedTerms.is(":checked") === false) {
	    $AcceptError.html('<div class="alert alert-danger">You must accept the terms and conditions.</div>');
	} else {
	    $("#submitForm").submit();
	    return;
	    $(".submitButton").button('loading');
	    var $formdata = $("#submitForm").serialize();
	    waitModal(true);
	    $.ajax({
		type: 'POST',
		url: "action/postquery.php",
		data: $formdata,
		cache: false,
		success: function (data, textStatus, jqXHR) {
		    waitModal(false);
		    $(".submitButton").button('reset');
		    if (data.Status === "NOTSOLD") {
			window.location.href = data.RedirectURL;
		    } else if (data.Status === "SUCCESS") {
			window.location.href = data.RedirectURL;
		    } else {
			if (data.Status === "ERROR") {
			    console.log(data.Fields.length);
			    if (data.Fields.length > 0) {
				$.each(data.Fields, function (key, val) {
				    var $Field = $("#" + val);
				    setFieldError($Field, true);
				    if ($FocusField === null) {
					$FocusField = $Field;
				    }
				});
				MoveAtErrorFieldStep($FocusField);
				swal("Error", "Sorry, We have found some incorrect information with your application. Please correct highlighted fields and try again.", "error");
			    } else {
				swal("Error", "MyLoanQuote apologizes, but unfortunately we experienced an error when attempting to process your loan application.  Please refresh our browser window and resubmit your application.  Thank you.", "error");
			    }

			} else {
			    swal("Error", "MyLoanQuote apologizes, but unfortunately we experienced an error when attempting to process your loan application.  Please refresh our browser window and resubmit your application.  Thank you.", "error");
			}
		    }
		},
		error: function (jqXHR, textStatus, errorThrown) {
		    waitModal(false);
		    $(".submitButton").button('reset');
		}
	    });
	}
    });
});
function updateProgress($val) {
    var $total = $(".form-steps").children('li').length;
    $total = parseInt($total) + 1;
    $total = parseFloat(100 / $total);
    var $valPercent = parseFloat($total * ($val));
    $('.progress .progress-bar').prop('aria-valuenow', $valPercent);
    $('.progress .progress-bar .show').html("PROGRESS");
    $('.progress .progress-bar').css("width", $valPercent + "%");
}
function validateInputs($fields) {
    $fields = $fields.split("|");
    var $isvalid = false;
    var $Field = null;
    var $pattern = "";
    var $validcount = 0;
    var $ISDateValidate = false;
    var $DateFieldLabel = "";
    var $DateFields = ['MoveInAddressDate', 'BirthdayDate', 'EmploymentStartedDate', 'BankAccountOpenDate'];
    for (var $x = 0; $x < $DateFields.length; $x++) {
	var $DateField = $DateFields[$x];
	if ($.inArray($DateField, $fields) !== -1) {
	    $DateFieldLabel = $DateField;
	    $ISDateValidate = true;
	    break;
	}
    }
    for (var $i = 0; $i < $fields.length; $i++) {
	$Field = $("#" + $fields[$i]);
	if ($Field.prop('tagName') === "SELECT" || $Field.prop('tagName') === "select") {
	    if ($Field.val() !== "") {
		$validcount++;
		setFieldError($Field, false);
	    } else {
		$validcount--;
		setFieldError($Field, true);
		if ($FocusField === null) {
		    $FocusField = $Field;
		}
	    }
	} else if ($Field.prop('tagName') === "INPUT" || $Field.prop('tagName') === "input") {
	    $pattern = new RegExp($Field.attr('data-regex'));
	    if ($pattern.test($Field.val())) {
		if ($Field.prop('name') === 'PhoneWork') {
		    if ($Field.val() === $("#PhoneCell").val()) {
			swal("Work Phone and Cell Phone should not be same.");
			$validcount--;
			setFieldError($Field, true);
			if ($FocusField === null) {
			    $FocusField = $Field;
			}
		    } else {
			$validcount++;
			setFieldError($Field, false);
		    }
		} else if ($Field.prop('name') === 'StreetAddress' || $Field.prop('name') === 'EmpStreetAddress') {
		    var BlockedWords = /pobox|po box|p.o. box|p. o. box| p.o. b.o.x.|p. o.box|po.box|po. box|p o box|p o b ox|p o bo x|po b o x|po bo x|po b ox|p.o. b ox| p.o. b.o.x/;
		    if ($Field.val().length <= 5) {
			swal("Street address must only accepts alphas and numeric character entries");
			$validcount--;
			setFieldError($Field, true);
			if ($FocusField === null) {
			    $FocusField = $Field;
			}
		    } else if (BlockedWords.test($Field.val().replace(/\s\s+/g, ' ').toLowerCase())) {
			swal("Invalid address entry, please revise.");
			$validcount--;
			setFieldError($Field, true);
			if ($FocusField === null) { 
			    $FocusField = $Field;
			}
		    } else if ($Field.prop('name') === "EmpStreetAddress") {
			if ($.trim($Field.val()) === $.trim($("#StreetAddress").val())) {
			    swal("Employer Address Cannot Match With Home Address.");
			    $validcount--;
			    $FocusField = $Field;
			    setFieldError($Field, true);
			} else {
			    $validcount++;
			    setFieldError($Field, false);
			}
		    } else {
			$validcount++;
			setFieldError($Field, false);
		    }
		} else {
		    //swal("Street address must contains your house no with street name.");
		    setFieldError($Field, false);
		    $validcount++;
		}
	    } else {
		if ($Field.prop('name') === 'StreetAddress' || $Field.prop('name') === 'EmpStreetAddress') {
		    swal("Street address must only accepts alphas and numeric character entries");
		}
		$validcount--;
		setFieldError($Field, true);
		if ($FocusField === null) {
		    $FocusField = $Field;
		}
	    }
	}
    }
    if ($validcount === $fields.length) {
	$isvalid = true;
    }
    if ($isvalid && $ISDateValidate) {
	var $tempDate = new Date($("#" + $fields[0]).val() + "-" + $("#" + $fields[1]).val() + "-" + $("#" + $fields[2]).val());
	//console.log($fields);
	//console.log($tempDate);
	var $Age = _calculateAge($tempDate);
	
	var $year = parseInt($("#" + $fields[0]).val());
	var $month = parseInt($("#" + $fields[1]).val());
	var $date = parseInt($("#" + $fields[2]).val());
	var $tempDate = Date.today().set({year: $year, month: ($month - 1), day: $date});
	
	
	var $minAge  = Date.today().set({year:parseInt($TodayDate.getFullYear()), month:parseInt($TodayDate.getMonth()), day:parseInt($TodayDate.getDate())}).addYears(-18);
	
	var $minAddr  = Date.today().set({year:parseInt($TodayDate.getFullYear()), month:parseInt($TodayDate.getMonth()), day:parseInt($TodayDate.getDate())}).add(-3).month();
	
	var $minEmpDate  = Date.today().set({year:parseInt($TodayDate.getFullYear()), month:parseInt($TodayDate.getMonth()), day:parseInt($TodayDate.getDate())}).add(-3).month();
	
	var $minAccOpen  = Date.today().set({year:parseInt($TodayDate.getFullYear()), month:parseInt($TodayDate.getMonth()), day:parseInt($TodayDate.getDate())}).add(-3).month();
	
	
	
	///console.log(" Months : " + $Age);
	if ($Age === false) {
	    swal("Please Enter Valid Date.");
	    $FocusField = $("#" + $fields[0]);
	    $isvalid = false;
	}
	if ($tempDate.isAfter($minAge) && $DateFieldLabel === "BirthdayDate") {
	    swal("You must be 18 year old to apply.");
	    $FocusField = $("#" + $fields[0]);
	    $isvalid = false;
	}
	if ($tempDate.isAfter($minAddr)&& $DateFieldLabel === "MoveInAddressDate") {
	    swal("Your move at current address date must be 3 month or earlier.");
	    $FocusField = $("#" + $fields[0]);
	    $isvalid = false;
	}
	if ($tempDate.isAfter($minEmpDate) && $DateFieldLabel === "EmploymentStartedDate") {
	    swal("Your employment started date must be 3 month or earlier.");
	    $FocusField = $("#" + $fields[0]);
	    $isvalid = false;
	}
	if ($tempDate.isAfter($minAccOpen) && $DateFieldLabel === "BankAccountOpenDate") {
	    swal("Your bank account open date must be 3 month or earlier.");
	    $FocusField = $("#" + $fields[0]);
	    $isvalid = false;
	}

	//console.log($Age);
    }
    if ($.inArray('FirstName', $fields) != -1) {
	if ($.trim($("#FirstName").val()) == $.trim($("#LastName").val())) {
	    swal("First Name and Last Name should not be same.");
	    $FocusField = $("#LastName");
	    $isvalid = false;
	}
    }
    return $isvalid;
}
function setFieldError($Field, $IsError) {
    if ($IsError) {
	$Field.parent('div').parent().removeClass('has-success');
	$Field.parent('div').parent().addClass('has-error');
	$Field.next('.form-control-feedback').removeClass('glyphicon-ok');
	$Field.next('.form-control-feedback').addClass('glyphicon-remove');
    } else {
	$Field.parent('div').parent().removeClass('has-error');
	$Field.parent('div').parent().addClass('has-success');
	$Field.next('.form-control-feedback').removeClass('glyphicon-remove');
	$Field.next('.form-control-feedback').addClass('glyphicon-ok');
    }
}
function _calculateAge($tempDate) { // birthday is a date
    if ($tempDate >= $TodayDate) {
	return  false;
    }
    //var ageDifMs = $TodayDate - $tempDate.getTime();
    //var ageDate = new Date(ageDifMs); // miliseconds from epoch
    //return Math.abs(ageDate.getUTCFullYear() - 1970);
    var months;
    months = ($TodayDate.getFullYear() - $tempDate.getFullYear()) * 12;
    months -= $tempDate.getMonth() + 1;
    months += $TodayDate.getMonth() + 1;
    return months <= 0 ? 0 : months;
}

function postQuery() {
    var $data = $("#submitForm").serialize();
    $.ajax({
	type: 'POST',
	url: 'verify',
	data: $data,
	success: function (data, textStatus, jqXHR) {
	    console.log(data);
	},
	error: function (jqXHR, textStatus, errorThrown) {
	    console.log(jqXHR);
	}
    });
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

    // ---------------------------------

    $("#MoveInAddressMonth").on("change", function () {
	var $month = $(this).val();
	$month = parseInt($month);
	var $year = $("#MoveInAddressYear").val();
	if ($month === 2) {
	    if ($year % 4 === 0) {
		populateDates($monthsday[$month - 1], 'MoveInAddressDate');
	    } else {
		populateDates($monthsday[$month - 1] - 1, 'MoveInAddressDate');
	    }
	} else {
	    populateDates($monthsday[$month - 1], 'MoveInAddressDate');
	}
    });
    $("#MoveInAddressYear").on("change", function () {
	$dob_day = $(this).val();
    });
    $("#MoveInAddressYear").on("change", function () {
	var $month = $("#MoveInAddressMonth").val();
	var $year = $(this).val();

	$month = parseInt($month);
	$year = parseInt($year);

	if ($month === 2) {
	    if ($year % 4 === 0) {
		populateDates($monthsday[$month - 1], 'MoveInAddressDate');
	    } else {
		populateDates($monthsday[$month - 1] - 1, 'MoveInAddressDate');
	    }
	} else {
	    populateDates($monthsday[$month - 1], 'MoveInAddressDate');
	}
    });

    // ---------------------------------

    $("#EmploymentStartedMonth").on("change", function () {
	var $month = $(this).val();
	$month = parseInt($month);
	var $year = $("#EmploymentStartedYear").val();
	if ($month === 2) {
	    if ($year % 4 === 0) {
		populateDates($monthsday[$month - 1], 'EmploymentStartedDate');
	    } else {
		populateDates($monthsday[$month - 1] - 1, 'EmploymentStartedDate');
	    }
	} else {
	    populateDates($monthsday[$month - 1], 'EmploymentStartedDate');
	}
    });
    $("#EmploymentStartedYear").on("change", function () {
	$dob_day = $(this).val();
    });
    $("#EmploymentStartedYear").on("change", function () {
	var $month = $("#EmploymentStartedMonth").val();
	var $year = $(this).val();

	$month = parseInt($month);
	$year = parseInt($year);

	if ($month === 2) {
	    if ($year % 4 === 0) {
		populateDates($monthsday[$month - 1], 'EmploymentStartedDate');
	    } else {
		populateDates($monthsday[$month - 1] - 1, 'EmploymentStartedDate');
	    }
	} else {
	    populateDates($monthsday[$month - 1], 'EmploymentStartedDate');
	}
    });

    // ---------------------------------

    $("#BankAccountOpenMonth").on("change", function () {
	var $month = $(this).val();
	$month = parseInt($month);
	var $year = $("#BankAccountOpenYear").val();
	if ($month === 2) {
	    if ($year % 4 === 0) {
		populateDates($monthsday[$month - 1], 'BankAccountOpenDate');
	    } else {
		populateDates($monthsday[$month - 1] - 1, 'BankAccountOpenDate');
	    }
	} else {
	    populateDates($monthsday[$month - 1], 'BankAccountOpenDate');
	}
    });
    $("#BankAccountOpenYear").on("change", function () {
	$dob_day = $(this).val();
    });
    $("#BankAccountOpenYear").on("change", function () {
	var $month = $("#BankAccountOpenMonth").val();
	var $year = $(this).val();

	$month = parseInt($month);
	$year = parseInt($year);

	if ($month === 2) {
	    if ($year % 4 === 0) {
		populateDates($monthsday[$month - 1], 'BankAccountOpenDate');
	    } else {
		populateDates($monthsday[$month - 1] - 1, 'BankAccountOpenDate');
	    }
	} else {
	    populateDates($monthsday[$month - 1], 'BankAccountOpenDate');
	}
    });
});
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
function MoveAtErrorFieldStep($Field) {
    var $step = $Field.parents('li');
    $step = $step[0];
    console.log($step);
    var $current_step = $($step).attr('data-step');
    $current_step = parseInt($current_step) - 1;
    updateProgress($current_step);
    $("[data-step]").hide();
    $($step).css('display', 'block');
}

var validRoutingNumber = function (routing) {

    // all valid routing numbers are 9 numbers in length
    if (routing.length !== 9) {
	return false;
    }

    // if it aint a number, it aint a routin' number
    if (!$.isNumeric(routing)) {
	return false;
    }

    // routing numbers starting with 5 are internal routing numbers
    // usually found on bank deposit slips
    if (routing[0] == '5') {
	return false;
    }

    // http://en.wikipedia.org/wiki/Routing_transit_number#MICR_Routing_number_format
    var checksumTotal = (7 * (parseInt(routing.charAt(0), 10) + parseInt(routing.charAt(3), 10) + parseInt(routing.charAt(6), 10))) +
	    (3 * (parseInt(routing.charAt(1), 10) + parseInt(routing.charAt(4), 10) + parseInt(routing.charAt(7), 10))) +
	    (9 * (parseInt(routing.charAt(2), 10) + parseInt(routing.charAt(5), 10) + parseInt(routing.charAt(8), 10)));

    var checksumMod = checksumTotal % 10;
    if (checksumMod !== 0) {
	return false;
    } else {
	return true;
    }
};