$(function () {
    $(".calendar").datepicker({
	format: 'mm/dd/yyyy',
	startDate: '1d'
    }).on('changeDate', function (ev) {
	$(this).attr("data-valid", "1");
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
    $("#SocailSecurityNumber").inputmask("Regex", {
	regex: /^\d{3}-?\d{2}-?\d{4}$/,
	mask: "999-99-9999",
	greedy: true
    });
    /* 
     $(".phonemask").keyup(function () {
     var $val = $(this).val();
     var $regex = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
     var $flag = $regex.test($val);
     console.log($flag);
     });
     $(".zipcodemask").keyup(function () {
     var $val = $(this).val();
     var $regex = /^\d{5}$/;
     var $flag = $regex.test($val);
     if ($flag) {
     $(this).attr("data-valid", "1");
     console.log("valid");
     } else {
     $(this).attr("data-valid", "0");
     }
     });
     */

    $("select").change(function () {
	console.log($(this).attr('name'));
	if ($(this).val() !== "" && $(this).val().length > 0) {
	    $(this).attr('data-valid', "1");
	} else {
	    $(this).attr('data-valid', "0");
	}
    });
    $("input").keyup(function () {
	var $type = $(this).attr('data-type');
	var $flag = false;
	var $val = $(this).val();
	$flag = validationRules($type, $val);
	if ($flag) {
	    $(this).attr('data-valid', "1");
	} else {
	    $(this).attr('data-valid', "0");
	}
    });
    $("input").change(function () {
	var $type = $(this).attr('data-type');
	var $flag = false;
	var $val = $(this).val();
	$flag = validationRules($type, $val);
	if ($flag) {
	    $(this).attr('data-valid', "1");
	} else {
	    $(this).attr('data-valid', "0");
	}
    });

    $("#formBox").hide();
    $("#form-miniform").on("submit", function (e) {
	e.preventDefault();
	if ($("#zipcode").attr("data-valid") !== "1") {
	    $("#zipcode").attr("title", "Please enter valid postal code.");
	    $("#zipcode").tooltip({placement: 'top'}).tooltip('show');
	    return;
	}
	$("#zipcode").tooltip('destroy');
	var $formdata = $(this).serialize();
	var $button = $(this).children('.input-button').children('button');
	$button.button('loading');
	$.ajax({
	    type: 'POST',
	    url: "action/zip_validate.php",
	    data: $formdata,
	    cache: false,
	    success: function (data, textStatus, jqXHR) {
		$button.button('reset');
		if (data === "1") {
		    show_step();
		}
	    },
	    error: function (jqXHR, textStatus, errorThrown) {
		$button.button('reset');
		alert('Error in connection.');
	    }
	});
    });
    updateProgress(1);
    var $duration = 400;
    var $animation = 'slide';
    /* $("select").on("change",function (){
     if($(this).val() != ""){
     $(this).parent('div').parent('div').next('div').children('button').trigger("click");
     } 
     }) */
    $(".next").on("click", function (e) {
	var $btn = $(this);
	var $validateField = $btn.attr('data-validate');
	$validateField = $validateField.split("|");
	var $i = 0;
	var $isValid = true;
	var $FieldId = null;
	while ($i < $validateField.length) {
	    if (!validateField($validateField[$i])) {
		if ($FieldId === null) {
		    $FieldId = $("#" + $validateField[$i]);
		}
		if ($isValid) {
		    $isValid = false;
		}
	    }
	    $i++;
	}
	if ($isValid === false) {
	    if ($FieldId !== null) {
		$FieldId.focus();
	    }
	    return;
	}
	var $next_step = parseInt($btn.attr('data-next'));
	var $current_step = $next_step - 1;
	$(".progress-" + $current_step).hide($animation, {direction: 'left'}, $duration);
	setTimeout(function () {
	    $(".progress-" + $next_step).show($animation, {direction: 'right'}, $duration);
	}, $duration + 10);
	updateProgress($next_step);
    });
    $(".prev").on("click", function () {
	var $btn = $(this);
	var $prev_step = parseInt($btn.attr('data-prev'));
	var $current_step = $prev_step + 1;
	$(".progress-" + $current_step).hide($animation, {direction: 'right'}, $duration);
	setTimeout(function () {
	    $(".progress-" + $prev_step).show($animation, {direction: 'left'}, $duration);
	}, $duration + 10);
	updateProgress($prev_step);
    });
    $("#RequestForm").submit(function (e){
	var $flag = false;
	$("#AccountNumber").tooltip('destroy');
	$("#AccountNumber").parent('div').parent('div').removeClass('has-error');
	
	$("#RoutingNumber").tooltip('destroy');
	$("#RoutingNumber").parent('div').parent('div').removeClass('has-error');
	
	$("#BankName").tooltip('destroy');
	$("#BankName").parent('div').parent('div').removeClass('has-error');
	
	if ($("#AccountNumber").attr("data-valid") !== "1") {
	    $("#AccountNumber").attr("title", "Please enter valid Account Number.");
	    $("#AccountNumber").tooltip({placement: 'top'}).tooltip('show');	 
	    $("#AccountNumber").parent('div').parent('div').addClass('has-error');
	    $flag = true;
	}else if ($("#RoutingNumber").attr("data-valid") !== "1") {
	    $("#RoutingNumber").attr("title", "Please enter valid Routing Number.");
	    $("#RoutingNumber").tooltip({placement: 'top'}).tooltip('show');	    
	    $("#RoutingNumber").parent('div').parent('div').addClass('has-error');
	    $flag = true;
	}else if ($("#BankName").attr("data-valid") !== "1") {
	    $("#BankName").attr("title", "Please enter valid Bank Name.");
	    $("#BankName").tooltip({placement: 'top'}).tooltip('show');
	    $("#BankName").parent('div').parent('div').addClass('has-error');
	    $flag = true;	    
	}	
	if($flag){
	    e.preventDefault();
	    return;
	}
    });
});

function validationRules($type, $val) {
    var $flag = false;
    if ($type === "zipcode") {
	var $pattern = /^\d{5}$/;
	$flag = $pattern.test($val);
    } else if ($type === "name") {
	var $pattern = /^[a-zA-Z .]+$/;
	$flag = $pattern.test($val);
    } else if ($type === "address") {
	var $pattern = /^[a-zA-Z\s\d\/]*\d[a-zA-Z\s\d\/]*$/;
	$flag = $pattern.test($val);
    } else if ($type === "email") {
	var $pattern = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;
	$flag = $pattern.test($val);
    } else if ($type === "phone") {
	var $pattern = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
	$flag = $pattern.test($val);
    } else if ($type === "licenseno") {
	var $pattern = /[a-zA-Z0-9]+$/;
	$flag = $pattern.test($val);
    } else if ($type === "ssnno") {
	var $pattern = /^\d{3}-?\d{2}-?\d{4}$/;
	$flag = $pattern.test($val);
    } else if ($type === "employer") {
	var $pattern = /^[a-zA-Z0-9 .]+$/;
	$flag = $pattern.test($val);
    } else if ($type === "date") {
	var $pattern = /^(0[1-9]|1[0-2])\/(0[1-9]|1\d|2\d|3[01])\/(19|20)\d{2}$/;
	$flag = $pattern.test($val);
    } else {
	if ($val.length > 1) {
	    $flag = true;
	}
    }
    return  $flag;
}

function show_step() {
    $("#formBox0").hide();
    $("#formBox").show();
    $(".progress-1").addClass('active');
}
function validateField(fieldId) {
    var $element = $("#" + fieldId);
    if ($element.attr('data-valid') !== "1") {
	$element.parent('div').parent('div').addClass('has-error');
	$element.attr("title", "This field is required.");
	$element.tooltip({placement: 'top'}).tooltip('show');
	return false;
    } else {
	$element.tooltip('destroy');
	$element.parent('div').parent('div').removeClass('has-error');
	return true;
    }
}
function updateProgress($val) {
    var $total = 3.71;
    var $valPercent = parseFloat($total * ($val));
    var $label = parseInt($valPercent) + "%"
    $('.progress .progress-bar').prop('aria-valuenow', $valPercent);
    $('.progress .progress-bar').html($label);
    $('.progress .progress-bar').css("width", $valPercent + "%");
}