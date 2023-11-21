<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class LBMC {

    private $service_url = "https://www.cashnow9.com/rt/post/";
    private $api_key = "";
    private $mode = "accept"; // accept|reject will generate a response; live activates the campaign
    private $source = "myloanquote.net";
    //private $sub_c1 = ""; // Should not be blank. Confirm in production 

    public function test() {
	echo 'testing';
    }

	    
    public function __construct() {
	parent::__construct();
    }

    private function phone_format($Phone) {
	$Phone = substr($Phone, 0, 3) . "-" . substr($Phone, 3, 3) . "-" . substr($Phone, 6);
	return $Phone;
    }

    private function get_monthdiff($date1, $date2) {
	$date1 = strtotime($date1);
	$date2 = strtotime($date2);

	$year1 = date('Y', $date1);
	$year2 = date('Y', $date2);

	$month1 = date('m', $date1);
	$month2 = date('m', $date2);

	$diff = (($year2 - $year1) * 12) + ($month2 - $month1);
	return $diff;
    }

    public function post_lead($vals, $tier) {

	switch ($tier):
	    case 60:
		$this->api_key = "b698f77cb6edc4e9";
		break;
	    case 40:
		$this->api_key = "8591bbcc1fa4ac9f";
		break;
	    case 20:
		$this->api_key = "dce9d5e712f5a2c0";
		break;
	    case 1:
		$this->api_key = "4cd0756e457a5b82";
		break;
	endswitch;

	$now = date("Y-m-d");
	$MonthsAtBank = $this->get_monthdiff($vals['AccountOpenDate'], $now);
	$MonthEmployed = $this->get_monthdiff($vals['EmploymentStarted'], $now);
	$MonthsAtAddress = $this->get_monthdiff($vals['AddressMoveIn'], $now);
	$BestContact = $vals['BestTimeToCall'];

	if ($BestContact == "MORNING"):
	    $BestContact = 1;
	elseif ($BestContact == "AFTERNOON"):
	    $BestContact = 4;
	elseif ($BestContact == "EVENING"):
	    $BestContact = 16;
	else:
	    $BestContact = 1;
	endif;

	$Housing = $vals['Housing'];
	$OwnHome = "R";
	if (in_array($Housing, array('HomeOwner', 'LivingWithParents'))):
	    $OwnHome = "O";
	endif;

	$IncomeType = $vals['IncomeSource'];
	$EmpStatus = 1;
	if ($IncomeType == "Employed"):
	    $EmpStatus = 32;
	endif;
	if ($IncomeType == "Self Employed"):
	    $EmpStatus = 16;
	endif;
	if ($IncomeType == "Social Security"):
	    $EmpStatus = 2;
	endif;
	if ($IncomeType == "Pension"):
	    $EmpStatus = 8;
	endif;
	if ($IncomeType == "Disability"):
	    $EmpStatus = 4;
	endif;

	$PayFrequency = $vals['PayFrequency'];
	$PayFrequencyVal = 8;
	if ($PayFrequency == "WEEKLY"):
	    $PayFrequencyVal = 2;
	endif;
	if ($PayFrequency == "BIWEEKLY"):
	    $PayFrequencyVal = 4;
	endif;

	$BankAccountType = "C";
	if ($vals['BankAccountType'] == "SAVINGS"):
	    $BankAccountType = "S";
	endif;


	$postData = array(
	    'pkey' => $this->api_key,
	    'mode' => $this->mode,
	    'email' => $vals['Email'],
	    'fname' => $vals['FirstName'],
	    'lname' => $vals['LastName'],
	    'address1' => $vals['StreetAddress'],
	    'city' => $vals['City'],
	    'state' => $vals['State'],
	    'zip' => $vals['Zipcode'],
	    'home_phone' => $this->phone_format($vals['PhoneCell']),
	    'cell_phone' => $this->phone_format($vals['PhoneCell']),
	    'military' => ($vals['MilitaryService'] == 1) ? "Y" : "N",
	    'ssn' => $vals['SSN'],
	    'dob' => date("Y-m-d", strtotime($vals['Birthday'])),
	    'license' => $vals['DriverLicenseNumber'],
	    'license_state' => $vals['DriversLicenseState'],
	    'best_contact' => $BestContact,
	    'own_home' => $OwnHome,
	    'home_length' => $MonthsAtAddress,
	    'emp_status' => $EmpStatus,
	    'employer' => $vals['EmployerName'],
	    'emp_city' => $vals['EmpCity'],
	    'emp_state' => $vals['EmpState'],
	    'emp_zip' => $vals['EmpZipcode'],
	    'emp_phone' => $this->phone_format($vals['PhoneWork']),
	    'position' => $vals['JobTitle'],
	    'income' => $vals['MonthlyIncome'],
	    'pay_period' => $PayFrequencyVal,
	    'next_pay_1' => $vals['NextPayDate1'],
	    'next_pay_2' => $vals['NextPayDate2'],
	    'emp_length' => $MonthEmployed,
	    'bank' => $vals['BankName'],
	    'acct_type' => $BankAccountType,
	    'dir_dep' => ($vals['DirectDeposit'] == "1") ? "Y" : "N",
	    'acct' => $vals['BankAccountNumber'],
	    'routing' => $vals['BankABA'],
	    'bank_length' => $MonthsAtBank,
	    'ip' => $vals['OptinIP'],
	    'source' => $this->source,
	    'amt' => $vals['LoanAmount'],
	    'subc1' => $vals["Id"]
	);

	$postvals = http_build_query($postData);

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $this->service_url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postvals);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Expect:"));
	curl_setopt($ch, CURLOPT_FAILONERROR, 1);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_TIMEOUT, 120);

	$Response = curl_exec($ch);
	curl_close($ch);
	$outputXml = simplexml_load_string($Response);
	$outputJson = json_encode($outputXml);
	$outputArray = json_decode($outputJson, true);
	//$outputArray['Q_STRING'] = $postvals;
	return $outputArray;
    }

}
