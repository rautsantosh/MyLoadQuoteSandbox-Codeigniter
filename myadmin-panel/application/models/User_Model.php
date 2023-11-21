<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_Model extends CI_Model {

    public function __construct() {
	parent::__construct();
    }

    public function get_dasboard($type) {
	$SQLString = "SELECT COUNT(*) AS TOTAL FROM Lead_Details";
	if (in_array($type, array('Today', 'Monthly', 'Weekly'))):
	    $SQLString .= " WHERE LeadTime >= ? AND LeadTime <= ?";
	endif;
	$con_array = array();
	switch ($type):
	    case 'Today':
		$from_date = date("Y-m-d") . " 00:00:00";
		$to_date = date("Y-m-d") . " 23:59:59";
		array_push($con_array, $from_date);
		array_push($con_array, $to_date);
		break;
	    case 'Weekly':
		$date = date("Y-m-d");
		$from_date = date("Y-m-d", strtotime("-8 day")) . " 00:00:00";
		$to_date = date("Y-m-d", strtotime("-1 day")) . " 23:59:59";
		array_push($con_array, $from_date);
		array_push($con_array, $to_date);
		break;
	    case 'Monthly':
		$date = date("Y-m-d");
		$from_date = date("Y-m-d", strtotime("-31 day")) . " 00:00:00";
		$to_date = date("Y-m-d", strtotime("-1 day")) . " 23:59:59";
		array_push($con_array, $from_date);
		array_push($con_array, $to_date);
		break;
	    default :
		break;
	endswitch;
	
	$Query = $this->db->query($SQLString,$con_array);
	$Result = $Query->result();
	return $Result;
    }

    public function lead_info() {
	$LeadId = $this->input->post("Id");
	$SQLString = "SELECT * FROM `Applicant_Info` WHERE `Id` = ?";
	$Query = $this->db->query($SQLString, array($LeadId));
	$Result = $Query->result();
	return $Result;
    }

    public function lead_grid() {
	$Page = $this->input->get("page");
	$SIDX = $this->input->get("sidx");
	$SORD = $this->input->get("sord");
	$Limit = $this->input->get("rows");

	if (!$SIDX):
	    $SIDX = 1;
	endif;

	//$Columns = array('Id', 'CampaignId', 'FirstName', 'LastName', 'Email', 'PhoneCell', 'Zipcdoe', 'City', 'State', 'RequestedAmount', 'PostResult', 'LeadId', 'LeadTime');
	$Columns = array('Id','LoanAmount','Title','FirstName','LastName','Birthday','Email','PhoneWork','PhoneCell','BestTimeToCall','StreetAddress','HouseNo','HouseName','City','State','Zipcode','EmpStreet','EmpCity','EmpState','EmpZipcode','Housing','AddressMoveIn','IncomeSource','EmployerName','JobTitle','EmploymentStarted','MonthlyIncome','PayFrequency','NextPayDate1','NextPayDate2','DirectDeposit','BankAccountType','BankName','BankABA','BankAccountNumber','AccountOpenDate','DriverLicenseNumber','DriversLicenseState','BankCardType','CreditRating','SSN','MilitaryService','AcceptTerms','OptinIP','OptinUserAgent','LeadTime','ParamS1','ParamS2','ParamS3','ParamS4','IsPost');

	$Filters = $this->input->get("filters");
	$Filters = json_decode($Filters, TRUE);

	$SQLCondition = "";

	if (count($Filters) > 0):
	    foreach ($Filters['rules'] as $Rules):
		$SQLCondition .= getWhereClause($Rules['field'], $Rules['op'], $Rules['data']);
	    endforeach;
	endif;


	$SQLString = "SELECT COUNT(*) AS Total FROM `Applicant_Info` WHERE `Id` > 0 $SQLCondition";
	$Query = $this->db->query($SQLString);
	$Result = $Query->result();
	$TotalRecords = $Result[0]->Total;

	$TotalPages = 0;
	if ($TotalRecords > 0) {
	    $TotalPages = ceil($TotalRecords / $Limit);
	} else {
	    $TotalPages = 0;
	}
	if ($Page > $TotalPages) {
	    $Page = $TotalPages;
	}
	$StartRow = ($Limit * $Page) - $Limit;

	if ($StartRow < 0) {
	    $StartRow = 0;
	}

	$ColumnSelectString = implode("`,`", $Columns);

	$SQLString = "SELECT `$ColumnSelectString` FROM `Applicant_Info` WHERE `Id` > 0 $SQLCondition ORDER BY $SIDX $SORD LIMIT $StartRow, $Limit";
	$Query = $this->db->query($SQLString);
	$Result = $Query->result();

	$Response = new stdClass();

	$Response->page = $Page;
	$Response->total = $TotalPages;
	$Response->records = $TotalRecords;
	$i = 0;
	foreach ($Result as $Row):
	    $Response->rows[$i]['id'] = $Row->Id;
	    $Link = '<a href="javascript:void(0)" onclick="getInfo(\'' . $Row->Id . '\')" data-id="' . $Row->Id . '" data-action="getInfo">View Detail</a>';
	    $Row->Action = $Link;
	    $Row->Birthday = date("M d,Y",  strtotime($Row->Birthday));
	    $Response->rows[$i]['cell'] = $Row;
	    $i++;
	endforeach;

	return $Response;
    }

    public function lead_response($LeadId){
	$Page = $this->input->get("page");
	$SIDX = $this->input->get("sidx");
	$SORD = $this->input->get("sord");
	$Limit = $this->input->get("rows");

	if (!$SIDX):
	    $SIDX = 1;
	endif;

	$Columns = array('Id','Provider','ApplicationId','Status','CampaignId','LeadId','Tier','Price','RedirectURL','Message','RowResponse','AddedOn');

	$Filters = $this->input->get("filters");
	$Filters = json_decode($Filters, TRUE);

	$SQLCondition = "";

	if (count($Filters) > 0):
	    foreach ($Filters['rules'] as $Rules):
		$SQLCondition .= getWhereClause($Rules['field'], $Rules['op'], $Rules['data']);
	    endforeach;
	endif;


	$SQLString = "SELECT COUNT(*) AS Total FROM `API_Response` WHERE `ApplicationId` =  ? $SQLCondition";
	$Query = $this->db->query($SQLString,array($LeadId));
	$Result = $Query->result();
	$TotalRecords = $Result[0]->Total;

	$TotalPages = 0;
	if ($TotalRecords > 0) {
	    $TotalPages = ceil($TotalRecords / $Limit);
	} else {
	    $TotalPages = 0;
	}
	if ($Page > $TotalPages) {
	    $Page = $TotalPages;
	}
	$StartRow = ($Limit * $Page) - $Limit;

	if ($StartRow < 0) {
	    $StartRow = 0;
	}

	$ColumnSelectString = implode("`,`", $Columns);

	$SQLString = "SELECT `$ColumnSelectString` FROM `API_Response` WHERE `ApplicationId` = ? $SQLCondition ORDER BY $SIDX $SORD LIMIT $StartRow, $Limit";
	$Query = $this->db->query($SQLString,array($LeadId));
	$Result = $Query->result();

	$Response = new stdClass();

	$Response->page = $Page;
	$Response->total = $TotalPages;
	$Response->records = $TotalRecords;

	$i = 0;
	foreach ($Result as $Row):
	    $Response->rows[$i]['id'] = $Row->Id;	    
	    $Response->rows[$i]['cell'] = $Row;
	    $i++;
	endforeach;

	return $Response;
    }
}
