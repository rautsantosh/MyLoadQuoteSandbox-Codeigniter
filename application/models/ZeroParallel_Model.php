<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ZeroParallel_Model extends CI_Model {

    private $service_url = "https://leads1.zeroparallel.com/new_lead.php";
    private $user_id = "d6da120558eca1d2aa5c322704c91270";
    private $password = "Z53LQPkEz7FuVtXq";
    private $tier = 2; // Confirm before goes to production.

    public function __construct() {
	parent::__construct();
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
	$now = date("Y-m-d");
	$MonthsAtBank = $this->get_monthdiff($vals['AccountOpenDate'], $now);
	$MonthEmployed = $this->get_monthdiff($vals['EmploymentStarted'], $now);
	$MonthsAtAddress = $this->get_monthdiff($vals['AddressMoveIn'], $now);
	$Housing = $vals['Housing'];
	$ownHome = 1;
	if (in_array($Housing, array('HomeOwner', 'LivingWithParents'))):
	    $ownHome = 1;
	else:
	    $ownHome = 0;
	endif;

	$BankCardType = $vals['BankCardType'];
	$IsDebitCard = 1;
	if ($BankCardType == 0):
	    $IsDebitCard = 0;
	endif;

	$IncomeType = $vals['IncomeSource'];
	if (in_array($IncomeType, array('Employed', 'Self Employed'))):
	    $IncomeType = "EMPLOYMENT";
	else:
	    $IncomeType = "BENEFITS";
	endif;
	
	$PayFrequency = $vals['PayFrequency'];
	if($PayFrequency == "SEMIMONTHLY"){
	    $PayFrequency = "TWICEMONTHLY";
	}

	$postData = array(
	    'userid' => $this->user_id,
	    'password' => $this->password,
	    'ip_address' => $vals['OptinIP'],
	    'tier' => $tier,
	   // 'test_status' => 'sold', 
	    'requested_amount' => $vals['LoanAmount'],
	    'employer' => $vals['EmployerName'],
	    'job_title' => $vals['JobTitle'],
	    'active_military' => $vals['MilitaryService'],
	    'employed_months' => $MonthEmployed,
	    'income_type' => $IncomeType,
	    'monthly_income' => $vals['MonthlyIncome'],
	    'pay_date1' => $vals['NextPayDate1'],
	    'pay_date2' => $vals['NextPayDate2'],
	    'pay_frequency' => $PayFrequency,
	    'drivers_license_number' => $vals['DriverLicenseNumber'],
	    'drivers_license_state' => $vals['DriversLicenseState'],
	    'bank_name' => $vals['BankName'],
	    'bank_aba' => $vals['BankABA'],
	    'bank_account_number' => $vals['BankAccountNumber'],
	    'bank_account_type' => $vals['BankAccountType'],
	    'direct_deposit' => $vals['DirectDeposit'],
	    'first_name' => $vals['FirstName'],
	    'last_name' => $vals['LastName'],
	    'ssn' => $vals['SSN'],
	    'birth_date' => date("Y-m-d", strtotime($vals['Birthday'])),
	    'address' => $vals['StreetAddress'],
	    'city' => $vals['City'],
	    'state' => $vals['State'],
	    'zip' => $vals['Zipcode'],
	    'email' => $vals['Email'],
	    'home_phone' => $vals['PhoneCell'],
	    'work_phone' => $vals['PhoneWork'],
	);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $this->service_url);
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
	//curl_setopt($ch, CURLOPT_PROXY, "104.144.190.252"); //"104.144.190.252"
	//curl_setopt($ch, CURLOPT_PROXYPORT, "3129"); // 3129
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Expect:"));
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 120);

	$Response = curl_exec($ch);
	
	curl_close($ch);

	$outputXml = simplexml_load_string($Response);
	$outputJson = json_encode($outputXml);
	$outputArray = json_decode($outputJson, true);
	
	return $outputArray;
    }

}
