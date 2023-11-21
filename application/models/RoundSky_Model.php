<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class RoundSky_Model extends CI_Model {

    private $environment = 1; // 0 = test, 1 = production.
    private $service_url = "";
    private $partner = "digitechrev";
    private $partner_password = "8fdfc9e0d8b810517dd1";
    private $tier = 17;
    private $domain = "myloanquote.net";
    private $time_allowed = 30;
    private $response_type = "json";
    private $subid = "myloanPPC"; // Confirm befor production

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
	$this->service_url = ($this->environment) ? "https://www.leadhorizon.com/leads/payday/live.php" : "https://www.leadhorizon.com/leads/payday/test.php";
	if ($tier == 60):
	    $this->tier = 5;
	endif;
	if ($tier == 40):
	    $this->tier = 6;
	endif;
	if ($tier == 20):
	    $this->tier = 9;
	endif;
	if ($tier == 2):
	    $this->tier = 13;
	endif;

	$now = date("Y-m-d");
	$MonthsAtBank = $this->get_monthdiff($vals['AccountOpenDate'], $now);
	$MonthEmployed = $this->get_monthdiff($vals['EmploymentStarted'], $now);
	$MonthsAtAddress = $this->get_monthdiff($vals['AddressMoveIn'], $now);

	
	if (intval($MonthEmployed) > 240):
	    $MonthEmployed = 240;
	endif;
	if (intval($MonthsAtBank) > 240):
	    $MonthsAtBank = 240;
	endif;
	
	if(intval($MonthsAtAddress) > 240):
	    $MonthsAtAddress = 240;
	endif;

	$Housing = $vals['Housing'];
	$ownHome = '';
	if (in_array($Housing, array('HomeOwner', 'LivingWithParents'))):
	    $ownHome = 'own';
	else:
	    $ownHome = 'rent';
	endif;

	$NextPayDate1 = $vals['NextPayDate1'];


	$IncomeType = $vals['IncomeSource'];
	if ($IncomeType == "Employed"):
	    $IncomeType = "employment";
	endif;
	if ($IncomeType == "Self Employed"):
	    $IncomeType = "self_employed";
	endif;
	if ($IncomeType == "Social Security" || $IncomeType == "Pension" || $IncomeType == "Disability"):
	    $IncomeType = "benefits";
	endif;
	$PayFrequency = $vals['PayFrequency'];
	if ($PayFrequency == "SEMIMONTHLY") {
	    $PayFrequency = "semi-monthly";
	}
	$PayFrequency = strtolower($PayFrequency);

	$postData = array(
	    'partner' => $this->partner,
	    'partner_password' => $this->partner_password,
	    'customer_ip' => $vals['OptinIP'],
	    'tier' => $this->tier,
	    'sub_id' => $this->subid,
	    'domain' => $this->domain,
	    'time_allowed' => $this->time_allowed,
	    'browser_info' => $vals['OptinUserAgent'],
	    'state' => $vals['State'],
	    'first_name' => $vals['FirstName'],
	    'last_name' => $vals['LastName'],
	    'email' => $vals['Email'],
	    'home_phone' => $vals['PhoneCell'],
	    'zip' => $vals['Zipcode'],
	    'address' => $vals['StreetAddress'],
	    'city' => $vals['City'],
	    'housing' => $ownHome,
	    'monthly_income' => $vals['MonthlyIncome'],
	    'account_type' => $vals['BankAccountType'],
	    'direct_deposit' => $vals['DirectDeposit'],
	    'pay_period' => $PayFrequency,
	    'next_pay_date' => $NextPayDate1,
	    'requested_loan_amount' => $vals['LoanAmount'],
	    'months_at_residence' => $MonthsAtAddress,
	    'income_type' => $IncomeType,
	    'active_military' => $vals['MilitaryService'],
	    'occupation' => $vals['JobTitle'],
	    'employer' => $vals['EmployerName'],
	    'work_phone' => $vals['PhoneWork'],
	    'months_employed' => $MonthEmployed,
	    'bank_name' => $vals['BankName'],
	    'account_number' => $vals['BankAccountNumber'],
	    'routing_number' => $vals['BankABA'],
	    'months_with_bank' => $MonthsAtBank,
	    'driving_license_state' => $vals['DriversLicenseState'],
	    'driving_license_number' => $vals['DriverLicenseNumber'],
	    'birth_date' => $vals['Birthday'],
	    'social_security_number' => $vals['SSN'],
	    'response_type' => $this->response_type
	);
	//print_r($postData);
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
	$outputJson = curl_exec($ch);
	$outputArray = json_decode($outputJson, true);
	$outputArray['CampaignID'] = $this->partner;
	return $outputArray;
    }

}
