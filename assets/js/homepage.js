$(document).ready(function () {
    $(".zipcodemask").inputmask("Regex", {
	regex: /^\d{5}$/,
	mask: "99999",
	greedy: true
    });
    $(".submitzip").click(function (e) {
	e.preventDefault();
	var $form = $("#form-miniform");
	var $formdata = $("#form-miniform").serialize();
	var $button = $(".submitzip");
	$button.button('loading');
	$.ajax({
	    type: 'POST',
	    url: "validatezip",
	    data: $formdata,
	    cache: false,
	    success: function (data, textStatus, jqXHR) {		
		if(data.type === "success"){
		    $form.submit();
		}else{
		    $button.button('reset');
		    swal(data);
		}
	    },
	    error: function (jqXHR, textStatus, errorThrown) {
		$button.button('reset');
		swal("Error!", "There is some error while processing your request.", "error");
	    }
	});
    });
});