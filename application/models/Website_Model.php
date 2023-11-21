<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Website_Model extends CI_Model {

    public function zipcode_info($zipcode) {
	$this->db->limit(1);
	$this->db->where("postalCode", $zipcode);
	$query = $this->db->get("city_location");
	$result = $query->result();        
	$info = (count($result) == 0) ? NULL : $result[0];
	return $info;
    }

    public function store_lead() {
	$data = array(
	    'Id' => NULL,
	    'FirstName' => $this->input->post("FirstName"),
	    'LastName' => $this->input->post("LastName"),
	    'Email' => $this->input->post("Email"),
	    'Zip' => $this->input->post("Zipcdoe"),
	    "State" => $this->input->post("State"),
	    "City" => $this->input->post("City"),
	    "AddedOn" => date("Y-m-d H:i:s")
	);
	$this->db->insert("LeadInfo", $data);
	return TRUE;
	//print_r($data); 
    }

    public function store_application() {

	$Birthdate = $this->input->post('BirthdayYear') . '-' . $this->input->post('BirthdayMonth') . '-' . $this->input->post('BirthdayDate');
	$PhoneCell = $this->input->post("PhoneCell");
	$PhoneWork = $this->input->post("PhoneWork");

	$PhoneCell = preg_replace('/[- )(]/', "", $PhoneCell);
	$PhoneWork = preg_replace('/[- )(]/', "", $PhoneWork);


	$AddresMoveIn = $this->input->post('MoveInAddressYear') . "-" . $this->input->post('MoveInAddressMonth') . "-" . $this->input->post('MoveInAddressDate');
	$EmploymentStarted = $this->input->post('EmploymentStartedYear') . "-" . $this->input->post('EmploymentStartedMonth') . "-" . $this->input->post('EmploymentStartedDate');
	$BankAccountOpened = $this->input->post('BankAccountOpenYear') . "-" . $this->input->post('BankAccountOpenMonth') . "-" . $this->input->post('BankAccountOpenDate');

	$PayFrequency = trim(strtoupper($this->input->post('PayFrequency')));

	$NextPayDate1 = $this->input->post('NextPayDate');
	$NextPayDate1 = explode("/", $NextPayDate1);
	$NextPayDate1 = $NextPayDate1[2] . '-' . $NextPayDate1[0] . '-' . $NextPayDate1[1];


	$NextPayDate2 = $NextPayDate1;

	if ($PayFrequency == "WEEKLY"):
	    $NextPayDate2 = date("Y-m-d", strtotime("$NextPayDate1 +7 days"));
	endif;
	if ($PayFrequency == "BIWEEKLY"):
	    $NextPayDate2 = date("Y-m-d", strtotime("$NextPayDate1 +14 days"));
	endif;
	if ($PayFrequency == "SEMIMONTHLY"):
	    $NextPayDate2 = date("Y-m-d", strtotime("$NextPayDate1 +15 days"));
	endif;
	if ($PayFrequency == "MONTHLY"):
	    $NextPayDate2 = date("Y-m-d", strtotime("$NextPayDate1 +1 month"));
	endif;
	

	#$NextPayDate2 = $this->input->post("FollowPayDate");
	#$NextPayDate2 = explode("/", $NextPayDate2); 
	#$NextPayDate2 = $NextPayDate2[2] . '-' . $NextPayDate2[0] . '-' . $NextPayDate2[1];
	
	if (date("D", strtotime($NextPayDate2)) == "Sat") {
	    $NextPayDate2 = date("Y-m-d",  strtotime("$NextPayDate2 +2 days"));
	}
	if (date("D", strtotime($NextPayDate2)) == "Sun") {
	    $NextPayDate2 = date("Y-m-d",  strtotime("$NextPayDate2 +1 days"));
	}
	
	
	$SSN = $this->input->post('SSN');
	$SSN = str_replace("-", "", $SSN);        
	$Application = array(
	    "Id" => NULL,
	    'LoanAmount' => $this->input->post('RequestedAmount'),
	    'Title' => $this->input->post('Title'),
	    'FirstName' => $this->input->post('FirstName'),
	    'LastName' => $this->input->post('LastName'),
	    'Birthday' => $Birthdate,
	    'Email' => $this->input->post('Email'),
	    'PhoneWork' => $PhoneWork,
	    'PhoneCell' => $PhoneCell,
	    'BestTimeToCall' => $this->input->post('BestTimeToCall'),
	    'StreetAddress' => $this->input->post('StreetAddress'),
	    'HouseNo' => "",
	    'HouseName' => "",
	    'City' => $this->input->post('City'),
	    'State' => $this->input->post('State'),
	    'Zipcode' => $this->input->post('Zipcdoe'),
	    'EmpStreet' => $this->input->post('EmpStreetAddress'),
	    'EmpCity' => $this->input->post('EmpCity'),
	    'EmpState' => $this->input->post('EmpState'),
	    'EmpZipcode' => $this->input->post('EmpZipcdoe'), //EmpZipcode
	    'Housing' => $this->input->post('OwnHome'),
	    'AddressMoveIn' => $AddresMoveIn,
	    'IncomeSource' => $this->input->post('IncomeType'),
	    'EmployerName' => $this->input->post('EmployerName'),
	    'JobTitle' => $this->input->post('JOBTitle'),
	    'EmploymentStarted' => $EmploymentStarted,
	    'MonthlyIncome' => $this->input->post('MonthlyIncome'),
	    'PayFrequency' => $PayFrequency,
	    'NextPayDate1' => $NextPayDate1,
	    'NextPayDate2' => $NextPayDate2,
	    'DirectDeposit' => $this->input->post('PaymentType'),
	    'BankAccountType' => $this->input->post('BankAccountType'),
	    'BankName' => $this->input->post('BankName'),
	    'BankABA' => $this->input->post('BankABA'),
	    'BankAccountNumber' => $this->input->post('AccountNumber'),
	    'AccountOpenDate' => $BankAccountOpened,
	    'DriverLicenseNumber' => $this->input->post('DrivingLicenseNumber'),
	    'DriversLicenseState' => $this->input->post('DrivingLicenseState'),
	    'BankCardType' => 0, // Removed Filed "Do you have Debit Card ?"
	    'CreditRating' => $this->input->post('CreditRating'),
	    'SSN' => $SSN,
	    'MilitaryService' => $this->input->post('ActiveMilitary'),
	    'AcceptTerms' => $this->input->post('AcceptedTerms'),
	    'OptinIP' => $this->input->ip_address(),
	    'OptinUserAgent' => $this->agent->agent_string(),
	    'LeadTime' => date("Y-m-d H:i:s"),
	    'ParamS1' => $this->input->post('s1'),
	    'ParamS2' => $this->input->post('s2'),
	    'ParamS3' => $this->input->post('s3'),
	    'ParamS4' => $this->input->post('s4')
	);


	$AddressInfo = $this->zipcode_info($Application['Zipcode']);        
	$response = new stdClass();

	$response->IsError = FALSE;	
	$ErrorData = array();

	if ($this->validate_address($AddressInfo, $Application['City'], $Application['State'])) {
	    $response->IsError = TRUE;
	    $ErrorData['Address'] = "Zipcode, State and City name combination not matched.";
	}
	/* 
	$AddressInfo = $this->zipcode_info($Application['EmpZipcode']);
	if ($this->validate_address($AddressInfo, $Application['EmpCity'], $Application['EmpState'])) {
	    $response->IsError = TRUE;
	    $ErrorData['EmployerAddress'] = "Zipcode, State and City name combination not matched.";
	}*/
	
	if (date("D", strtotime($NextPayDate1)) == "Sat") {
	    $response->IsError = TRUE;
	    $ErrorData['NextPayDate'] = "Next pay date should not be weekend.";
	}

	if (date("D", strtotime($NextPayDate1)) == "Sun") {
	    $response->IsError = TRUE;
	    $ErrorData['NextPayDate'] = "Next pay date should not be weekend.";
	}
	
	if (date("D", strtotime($NextPayDate2)) == "Sat") {
	    $response->IsError = TRUE;
	    $ErrorData['FollowPayDate'] = "Follow pay date should not be weekend.";
	}

	if (date("D", strtotime($NextPayDate2)) == "Sun") {
	    $response->IsError = TRUE;
	    $ErrorData['FollowPayDate'] = "Follow pay date should not be weekend.";
	}
	
	$daydDiff = strtotime($NextPayDate2) - strtotime($NextPayDate1);
	$daydDiff = floor($daydDiff / (60 * 60 * 24));
	
	
	if ($PayFrequency == "WEEKLY"){
	    if(intval($daydDiff) < 6){
		$response->IsError = TRUE;
		$ErrorData['FollowPayDate'] = "Follow Pay Date should not be less than 6 days from next pay date.";
	    }
	}
	if ($PayFrequency == "BIWEEKLY"){
	    if(intval($daydDiff) < 14){
		$response->IsError = TRUE;
		$ErrorData['FollowPayDate'] = "Follow Pay Date should not be less than 14 days from next pay date.";
	    }
	}
	if ($PayFrequency == "SEMIMONTHLY"){
	    if(intval($daydDiff) < 15){
		$response->IsError = TRUE;
		$ErrorData['FollowPayDate'] = "Follow Pay Date should not be less than 15 days from next pay date.";
	    }
	}
	if ($PayFrequency == "MONTHLY"){
	    if(intval($daydDiff) < 28){
		$response->IsError = TRUE;
		$ErrorData['FollowPayDate'] = "Follow Pay Date should not be less than 28 days from next pay date.";
	    }
	}
	
	if ($response->IsError == TRUE) {
	    $Application['IsPost'] = 0;
	} else {
	    $Application['IsPost'] = 1;
	}
	$this->db->insert("Applicant_Info", $Application); // Insert data into database;
	$ApplicationId = $this->db->insert_id();
	$Application['Id'] = $ApplicationId;
	
	$response->ErrorData  = $ErrorData;
	
	$response->Application = $Application;

	return $response;
    }

    private function validate_address($Info, $city, $state) {
	if (trim($Info->region) !== trim($state)) {
	    return TRUE;
	}
	/*if (strtolower(trim($Info->city)) !== strtolower(trim($city))) {
	    return TRUE;
	}*/
	return FALSE;
    }

    public function application_review_data() {
	$app_id = $this->input->post("appid");
	$leadtime = $this->input->post("leadtime");
	$userip = $this->input->post("userip");

	$this->db->where("Id", $app_id);
	$this->db->where("OptinIP", $userip);
	$this->db->where("LeadTime", $leadtime);
	$query = $this->db->get("Applicant_Info");
	$result = $query->result();
	return (count($result) > 0) ? $result[0] : NULL;
    }

    public function api_response($Response) {
	$data = array(
	    'Id' => NULL,
	    'Provider' => $Response->Provider,
	    'ApplicationId' => $Response->ApplicationId,
	    'Status' => $Response->Status,
	    'CampaignId' => $Response->CampaignId,
	    'LeadId' => $Response->LeadId,
	    'Tier' => $Response->Tier,
	    'Price' => $Response->Price,
	    'RedirectURL' => $Response->RedirectURL,
	    'Message' => $Response->Message,
	    'RowResponse' => $Response->Response,
	    'AddedOn' => date("Y-m-d H:i:s")
	);
	$this->db->insert("API_Response", $data);
	return $this->db->insert_id();
    }

}
