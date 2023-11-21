var $FocusField = null;
/* 
 $isNavigate = false;
 $(function () {
 $(window).bind('beforeunload', function (e) {
 if (!$isNavigate) {
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
 $isNavigate = false;
 });
 });
 */
function waitModal(flag) {
    if (flag) {
	$(".waitModal").show();
	$(".waitModal").fadeTo(0, 1);
    } else {
	$(".waitModal").hide();
    }
}
$(document).ready(function () {
    console.log("form loaded");
    waitModal(false);
    var $duration = 400;
    var $animation = 'slide';
    updateProgress(1);
    $(".calendar").datepicker({
	format: 'mm/dd/yyyy',
	daysOfWeekDisabled: [0, 6]
    });
    $(".phonemask").inputmask("phone", {
	regex: /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/,
	mask: "(999) 999-9999",
	greedy: true
    });
    $(".zipcodemask").inputmask("Regex", {
	regex: /^\d{5}$/,
	mask: "99999",
	greedy: false
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
	var $AcceptError = $("#AcceptError");
	var $AcceptedTerms = $("#AcceptedTerms");
	$AcceptError.html('');
	if ($AcceptedTerms.is(":checked") === false) {
	    $AcceptError.html('<div class="alert alert-danger">You must accept the terms and conditions.</div>');
	} else {
	    //$("#submitForm").submit();

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
		    }else if (data.Status === "SUCCESS") {
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
			$validcount--;
			setFieldError($Field, true);
			if ($FocusField === null) {
			    $FocusField = $Field;
			}
		    } else {
			$validcount++;
			setFieldError($Field, false);
		    }
		} else {
		    setFieldError($Field, false);
		    $validcount++;
		}
	    } else {
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
function postQuery() {
    var $data = $("#submitForm").serialize();
    $.ajax({
	type: 'POST',
	url: 'action/verify.php',
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
