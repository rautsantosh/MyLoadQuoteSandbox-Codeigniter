<div class="col-sm-12">
    <div class="btn-group dash-type">
	<button class="btn btn-sm btn-default active" data-type="Today">Today</button>
	<button class="btn btn-sm btn-default" data-type="Weekly">Last 7 Days</button>
	<button class="btn btn-sm btn-default" data-type="Monthly">Last 30 Days</button>
	<button class="btn btn-sm btn-default" data-type="LifeTime">Life Time</button>
    </div>
</div>
<div class="col-sm-12">
    <div class="panel panel-default">
	<div class="panel-body">
	    <div class="col-sm-12 dashboard-state">

	    </div>
	</div>
    </div>
</div>
<!-- 

-->
<script type="text/javascript">
    $(function () {
	var $Loader = '<div class="text-center"><img src="<?php echo base_url("assets/images/sm-loader.gif") ?>"></div>';	
	$(".dash-type > .btn").on("click", function () {
	    var $Type = $(this).attr('data-type');
	    $(".dashboard-state").html($Loader); 
	    $(".dash-type > .btn").removeClass('active');
	    $(this).addClass('active');
	    $.ajax({
		type: 'GET',
		url: "./dashboard/" + $Type,
		success: function (data, textStatus, jqXHR) {
		    $(".dashboard-state").html(data);
		},
		error: function (jqXHR, textStatus, errorThrown) {
		    $(".dashboard-state").html('<div class="alert alert-danger">Error while processing your request.</div>');
		}
	    });
	});
	$(".dash-type > .active").trigger("click");
    });
</script>