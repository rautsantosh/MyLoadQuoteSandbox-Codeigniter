<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
	<table id="Grid" class="table table-bordered table-condensed table-hover table-striped"></table>
	<div id="Pager"></div>	
    </div>    
</div>
<div class="modal fade" id="InfoModal" data-backdrop="static" data-keyboard="false" role="dialog">
    <div class="modal-dialog modal-lg">
	<div class="modal-content">
	    <div class="modal-body">
		<button type="button" class="close pull-right" data-dismiss="modal">&times;</button>
		<div class="clearfix"></div>
		<div class="col-sm-12">
		    <div id="Info"></div>
		</div>
		<div class="clearfix"></div>
	    </div>
	</div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/component/jq-grid/js/grid.locale-en.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/component/jq-grid/js/jquery.jqGrid.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/component/jq-grid/js/grid.setcolumns.js" type="text/javascript"></script>
<script type="text/javascript">
    var $Loader = '<div class="text-center"><img src="<?php echo base_url("assets/images/sm-loader.gif") ?>"></div>';
    $(function () {
	$("#Grid").jqGrid({
	    url: './leads/list',
	    mtype: "GET",
	    styleUI: "Bootstrap",
	    datatype: "json",
	    colModel: [
		{label: 'Id', name: 'Id', index: 'Id', key: true, width: 40, search: true},
		{label: 'Loan Amount', name: 'LoanAmount', index: 'LoanAmount', width: 40, search: true, align:"right"},
		{label: 'First Name', name: 'FirstName', index: 'FirstName', width: 80, search: true},
		{label: 'Last Name', name: 'LastName', index: 'LastName', width: 80, search: true},
		{label: 'Birthday', name: 'Birthday', index: 'Birthday', width: 50, search: true},
		{label: 'Email', name: 'Email', index: 'Email', width: 120, search: true},
		{label: 'Phone Cell', name: 'PhoneCell', index: 'PhoneCell', width: 80, search: true},
		{label: 'Zipcode', name: 'Zipcode', index: 'Zipcode', width: 50, search: true},
		{label: 'City', name: 'City', index: 'City', width: 80, search: true},
		{label: 'State', name: 'State', index: 'State', width: 40, search: true},
		{label: 'OptinIP', name: 'OptinIP', index: 'OptinIP', width: 60, search: true},
		{label: 'IsPost', name: 'IsPost', index: 'IsPost', width: 60, search: true, align:"center"},
		{label: 'LeadId', name: 'LeadId', index: 'LeadId', width: 80, search: true},
		{label: 'LeadTime', name: 'LeadTime', index: 'LeadTime', width: 80, search: true},
		{label: 'Action', name: 'Action', index: 'Action', width: 40, search: false}
	    ],
	    viewrecords: true,
	    rowList: [50, 100, 200, 500, 1000],
	    sortname: 'Id',
	    sortorder: "desc",
	    width: $("#Grid").parent().width() - 20,
	    height: 700,
	    rowNum: 50,
	    multiselect: false,
	    pager: "#Pager",
	    gridview: true,
	    sortable: true,
	    scrollerbar: true,
	    emptyrecords: 'Nothing to display',
	    subGrid: true,
	    subGridRowExpanded: function (subgrid_id, row_id) {
		var subgrid_table_id, pager_id;
		subgrid_table_id = subgrid_id + "_t";
		pager_id = "p_" + subgrid_table_id;
		$("#" + subgrid_id).html("<table class=\"table table-bordered table-condensed table-hover table-striped\" id='" + subgrid_table_id + "' class='scroll'></table><div id='" + pager_id + "' class='scroll'></div>");
		$("#" + subgrid_table_id).jqGrid({
		    url: "./leads/response/" + row_id,
		    datatype: "json",
		    styleUI: "Bootstrap",
		    colNames: ['Id','Provider','ApplicationId','Status','CampaignId','LeadId','Tier','Price','RedirectURL','Message','RowResponse','AddedOn'],
		    colModel: [
			{name: "Id", index: "Id", width: 40, key: true, sortable: false},
			{name: "Provider", index: "Provider", width: 100, align: "left"},
			{name: "ApplicationId", index: "ApplicationId", width: 40, key: true, sortable: false},
			{name: "Status", index: "Status", width: 80, align: "left"},
			{name: "CampaignId", index: "CampaignId", width: 100, align: "left"},
			{name: "LeadId", index: "LeadId", width: 100, align: "left"},
			{name: "Tier", index: "Tier", width: 40, align: "right"},
			{name: "Price", index: "Price", width: 40, align: "right"},
			{name: "RedirectURL", index: "RedirectURL", width: 100, align: "left"},
			{name: "Message", index: "Message", width: 70, align: "left"},
			{name: "RowResponse", index: "RowResponse", width: 180, align: "left"},
			{name: "AddedOn", index: "AddedOn", width: 60, align: "center"}
		    ],
		    rowNum: 50,
		    pager: pager_id,
		    sortname: 'Id',
		    sortorder: "asc",
		    forceFit: true,
		    //shrinkToFit: true,
		    autowidth: true,
		    gridview: true,
		    height: '100%',
		    width: '100%'
		});
		$("#" + subgrid_table_id).jqGrid('navGrid', "#" + pager_id, {edit: false, add: false, del: false});
	    }
	});
	$("#Grid").jqGrid('navGrid', '#Pager', {edit: false, add: false, del: false}, {}, {}, {}, {multipleSearch: true});
	$("#Grid").jqGrid('filterToolbar', {stringResult: true, searchOperators: true});
	$("#Grid").jqGrid('navButtonAdd', '#Pager', {caption: "", title: "Download Excel", buttonicon: "fa fa-file-excel-o", onClickButton: function () {
		$("#DownloadForm").attr("action", $("#downloadForm").attr("action") + "?" + getFilterParams('ListTable'));
		$("#DownloadForm").submit();
	    }});
	$("#Grid").jqGrid('navButtonAdd', '#Pager', {caption: "", title: "Download Report", buttonicon: "glyphicon glyphicon-download-alt", onClickButton: function () {
		window.location.href = './leads/download';
	    }});
    });
    function getInfo($LeadId) {
	var $Modal = $("#InfoModal");
	var $DataBox = $("#Info");
	$DataBox.html($Loader);
	$Modal.modal('show');
	$.ajax({
	    type: 'POST',
	    url: "./leads/info",
	    data: {Id: $LeadId},
	    success: function (data, textStatus, jqXHR) {
		$DataBox.html(data);
		$Modal.modal('show');
	    },
	    error: function (jqXHR, textStatus, errorThrown) {
		alert("Error while processing.");
	    }
	});
    }
</script>