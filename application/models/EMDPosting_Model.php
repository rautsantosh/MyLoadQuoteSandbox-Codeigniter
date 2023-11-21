<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EMDPosting_Model extends CI_Model {

    private $service_url = "https://api.xclusivedigital.com/post.ashx";
    private $tier_code = "9585E42B-F4FD-4783-A677-EE13AE8CA142";
    private $test_mode = 0;
    private $referringURL = "https://myloanquote.net/apply";

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

    public function post_lead($Vals, $TierPrice) {

	$now = date("Y-m-d");
	$MonthsAtBank = $this->get_monthdiff($Vals['AccountOpenDate'], $now);
	$MonthEmployed = $this->get_monthdiff($Vals['EmploymentStarted'], $now);
	$MonthsAtAddress = $this->get_monthdiff($Vals['AddressMoveIn'], $now);

	$YearAtAddress = intval($MonthsAtAddress / 12);
	$YearAtEmployed = intval($MonthEmployed / 12);
	$YearAtBank = intval($MonthsAtBank / 12);


	$Housing = $Vals['Housing'];
	$ownHome = 1;
	if (in_array($Housing, array('HomeOwner', 'LivingWithParents'))):
	    $ownHome = 0;
	else:
	    $ownHome = 1;
	endif;

	$ContactTime = 1;
	if ($Vals['BestTimeToCall'] == 'MORNING'):
	    $ContactTime = 2;
	endif;
	if ($Vals['BestTimeToCall'] == 'AFTERNOON'):
	    $ContactTime = 3;
	endif;
	if ($Vals['BestTimeToCall'] == 'EVENING'):
	    $ContactTime = 4;
	endif;

	$PayFrequency = 4;
	
	if($Vals['PayFrequency'] == "WEEKLY"):
	    $PayFrequency = 1;
	endif;
	
	if($Vals['PayFrequency'] == "BIWEEKLY"):
	    $PayFrequency = 2;
	endif;
	
	if($Vals['PayFrequency'] == "SEMIMONTHLY"):
	    $PayFrequency = 3;
	endif;
	
	$AccountType = 1;

	if ($Vals['BankAccountType'] == "CHECKING"):
	    $AccountType = 2;	
	endif;
	
	
	$IncomeSource = 4;
	if($Vals['IncomeSource'] == "Employed"):
	    $IncomeSource = 2;
	endif;
	if($Vals['IncomeSource'] == "Self Employed"):
	    $IncomeSource = 2;
	endif;
	if($Vals['IncomeSource'] == "Social Security" || $Vals['IncomeSource'] == 'Pension' || $Vals['IncomeSource'] == 'Disability'):
	    $IncomeSource = 3;
	endif;
	$originationTimezone = "-04";
	$postData = array(
	    'tierCode' => $this->tier_code,
	    'isTest' => $this->test_mode,
	    'isPing' => 0,
	    'subID1' => uniqid(),
	    'universal_leadID' => $Vals['Id'],
	    'minPrice' => $TierPrice,
	    'referringURL' => $this->referringURL,
	    'userAgent' => $Vals['OptinUserAgent'],
	    'remoteAddr' => $Vals['OptinIP'],
	    'tcpaOptin' => '1',
	    'tcpaText' => 'tcpaText',
	    'originationDate' => $Vals['LeadTime'],
	    'originationTimezone' => $originationTimezone, // Confirm in production
	    'countryCode' => 'us',
	    'sessionID' => uniqid(), 
	    'firstName' => $Vals['FirstName'],
	    'lastName' => $Vals['LastName'],
	    'email' => $Vals['Email'],
	    'phonePrimary' => $Vals['PhoneCell'],
	    'phoneSecondary' => $Vals['PhoneWork'],
	    'address' => $Vals['StreetAddress'],
	    'city' => $Vals['City'],
	    'state' => $Vals['State'],
	    'zip' => $Vals['Zipcode'],
	    'dob' => $Vals['Birthday'],
	    'residenceType' => $ownHome,
	    'yearsAtResidence' => ($YearAtAddress < 10) ? $YearAtAddress : 10,
	    'incomeMonthly' => $Vals['MonthlyIncome'],
	    'contactTime' => $ContactTime,
	    'isMilitary' => $Vals['MilitaryService'],
	    'requestedAmount' => $Vals['LoanAmount'],
	    'licenseNumber' => $Vals['DriverLicenseNumber'],
	    'licenseState' => $Vals['DriversLicenseState'],
	    'ssn' => $Vals['SSN'],
	    'incomeSource' => $IncomeSource,
	    'employerName' => $Vals['EmployerName'],
	    'employerPhone' => $Vals['PhoneWork'], // ?? 
	    'yearsAtJob' => $YearAtEmployed,
	    'jobTitle' => $Vals['JobTitle'],
	    'payFrequency' => $PayFrequency,
	    'nextPayday' => $Vals['NextPayDate1'],
	    'secondPayday' => $Vals['NextPayDate2'],
	    'abaNumber' => $Vals['BankABA'],
	    'accountNumber' => $Vals['BankAccountNumber'],
	    'accountType' => $AccountType,
	    'bankName' => $Vals['BankName'],
	    'bankPhone' => "3157244022", //Hardcode any value According to Pankaj Sir.
	    'monthsAtBank' => $MonthsAtBank,
	    'directDeposit' => $Vals['DirectDeposit'],
	    'ownCar' => 0
	);
	
	
	
	$postvals = "";
	
	#$postvals = http_build_query($postData);
	
	foreach ($postData as $key => $val):	    
	    $postvals .= ($postvals == "") ? "" : "&"; 
	    $postvals .= "$key=".  rawurlencode($val);
	endforeach;
	/* 
	echo "<br> ----------------------------------------- <br>";
	echo "<pre>".$postvals."</pre>";
	echo "<br> ----------------------------------------- <br>";
	*/
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $this->service_url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postvals);	
	curl_setopt($ch, CURLOPT_FAILONERROR, 1);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_TIMEOUT, 300);

	$Response = curl_exec($ch);
	$error = curl_error($ch);
	#print_r($error);
	#print_r($Response);
	curl_close($ch);
	$outputArray = json_decode($Response, true);

	$outputArray['CampaignID'] = $this->tier_code;
	/*
	echo "<br> ----------------------------------------- <br>";
	echo "<pre>";
	print_r($outputArray);
	echo "</pre>";
	echo "<br> ----------------------------------------- <br>";
	*/
	return $outputArray;
    }

}
