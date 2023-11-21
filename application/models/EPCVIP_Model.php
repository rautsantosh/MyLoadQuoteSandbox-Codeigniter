<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EPCVIP_Model extends CI_Model {

    private $post_url = "https://epcvip.com/api/dois/prospect.json";
    private $affiliate_id = "500365";
    private $campaign_id = "1";
    private $api_key = "58ab5442cf74a";
    private $test_mode = 1;
    private $category = 2;
    private $site_url = "https://www.myloanquore.net";
    private $sub_id = "";

    public function __construct() {
	parent::__construct();
	$this->post_url = $this->post_url . "?aid=" . $this->affiliate_id . "&acid=" . $this->campaign_id . "&category=" . $this->category . "&apiKey=" . $this->api_key . "&subid=" . $this->sub_id;
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

	$PayFrequency = $vals['PayFrequency'];
	if ($PayFrequency == "WEEKLY") {
	    $PayFrequency = 1;
	}
	if ($PayFrequency == "BIWEEKLY") {
	    $PayFrequency = 2;
	}
	if ($PayFrequency == "SEMIMONTHLY") {
	    $PayFrequency = 3;
	}
	if ($PayFrequency == "MONTHLY") {
	    $PayFrequency = 4;
	}

	$IncomeType = $vals['IncomeSource'];
	if (in_array($IncomeType, array('Employed', 'Self Employed'))):
	    $IncomeType = "EMPLOYMENT";
	else:
	    $IncomeType = "BENEFITS";
	endif;

	$BankAccountType = 7;
	if ($vals['BankAccountType'] == "SAVINGS") {
	    $BankAccountType = 8;
	}

	$BestTimeTocall = 7;
	if ($vals['BestTimeToCall'] == "MORNING"):
	    $BestTimeTocall = 4;
	endif;
	if ($vals['BestTimeToCall'] == "AFTERNOON"):
	    $BestTimeTocall = 5;
	endif;
	if ($vals['BestTimeToCall'] == "EVENING"):
	    $BestTimeTocall = 6;
	endif;

	$postData = array(
	    'aid' => $this->affiliate_id,
	    'acid' => $this->campaign_id,
	    'apiKey' => $this->api_key,
	    //'testMode' => $this->test_mode, // Remove test mode in production
	    'category' => $this->category,
	    'ip' => $vals['OptinIP'],
	    'userAgent' => $vals['OptinUserAgent'],
	    'siteUrl' => $this->site_url,
	    'applicantId' => $vals['Id'],
	    'applicationId' => $vals['Id'],
	    'requestedLoanAmount' => $vals['LoanAmount'],
	    'firstName' => $vals['FirstName'],
	    'lastName' => $vals['LastName'],
	    'email' => $vals['Email'],
	    'dob' => date("m/d/Y", strtotime($vals['Birthday'])),
	    'ssn' => $vals['SSN'],
	    'licenseNumber' => $vals['DriverLicenseNumber'],
	    'licenseState' => $vals['DriversLicenseState'],
	    'activeMilitary' => $vals['MilitaryService'],
	    'phone' => $vals['PhoneCell'],
	    'preferredContactTOD' => $BestTimeTocall,
	    'phoneMobile' => $vals['PhoneCell'],
	    'address1' => $vals['StreetAddress'],
	    'city' => $vals['City'],
	    'state' => $vals['State'],
	    'postcode' => $vals['Zipcode'],
	    'homeOwner' => $ownHome,
	    'monthsAtAddress' => $MonthsAtAddress,
	    'employerName' => $vals['EmployerName'],
	    'jobTitle' => $vals['JobTitle'],
	    'phoneWork' => $vals['PhoneWork'],
	    'netMonthlyIncome' => $vals['MonthlyIncome'],
	    'payFrequency' => $PayFrequency,
	    'payNextDate' => date("m/d/Y", strtotime($vals['NextPayDate1'])),
	    'payAfterNextDate' => date("m/d/Y", strtotime($vals['NextPayDate2'])),
	    'incomeType' => $IncomeType,
	    'bankAccountType' => $BankAccountType,
	    'bankName' => $vals['BankName'],
	    'bankAccountNumber' => $vals['BankAccountNumber'],
	    'bankABA' => $vals['BankABA'],
	    'directDeposit' => $vals['DirectDeposit'],
	    'monthsAtBank' => $MonthsAtBank
	);

	$ch = curl_init();

	$data = json_encode($postData);

	curl_setopt($ch, CURLOPT_URL, $this->post_url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 300); //timeout in seconds
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	    'Content-Type: application/json',
	    'Content-Length: ' . strlen($data))
	);
	$outputJson = curl_exec($ch);
	$error = curl_error($ch);		
	curl_close($ch);
	#print_r($error); 
	$outputArray = json_decode($outputJson, true);
	$outputArray['CampaignID'] = $this->campaign_id;
	return $outputArray;
    }

}
