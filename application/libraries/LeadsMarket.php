<?php

class LeadsMarket {
 
    private $service_url = "https://www.leadsmarket.com/api2/post/data.aspx";
    private $campaign_id = 228064;
    private $campaign_key = '166a2300-a471-4d00-aab3-de0a8ea227c1';
    private $api_environment = ""; // For Production this should be blank
    private $sub_source_id = "11001";
    private $client_url = 'http://www.myloanquote.net/apply.php';
    private $minimum_price = 2;
    private $max_reponse_time = 60;

   
    public function test(){
	echo 'ok';
    }

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

    public function post_leads($vals, $tier) {

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

	$postData = array(
	    'CampaignID' => $this->campaign_id,
	    'CampaignKey' => $this->campaign_key,
	    'TestResult' => $this->api_environment,
	    'SubSourceID' => $this->sub_source_id,
	    'ClientIP' => $vals['OptinIP'],
	    'ClientUserAgent' => $vals['OptinUserAgent'],
	    'ClientURL' => $this->client_url,
	    'MinimumPrice' => $tier,
	    'MaxResponseTime' => $this->max_reponse_time,
	    'RequestedAmount' => $vals['LoanAmount'],
	    'FirstName' => $vals['FirstName'],
	    'LastName' => $vals['LastName'],
	    'Email' => $vals['Email'],
	    'PhoneHome' => $vals['PhoneCell'],
	    'PhoneCell' => $vals['PhoneCell'],
	    'PhoneWork' => $vals['PhoneWork'],
	    'BestTimeToCall' => $vals['BestTimeToCall'],
	    'StreetAddress1' => $vals['StreetAddress'],
	    'City' => $vals['City'],
	    'State' => $vals['State'],
	    'ZipCode' => $vals['Zipcode'],
	    'DOB' => date("m/d/Y", strtotime($vals['Birthday'])),
	    'SSN' => $vals['SSN'],
	    'DriversLicense' => $vals['DriverLicenseNumber'],
	    'DriversLicenseState' => $vals['DriversLicenseState'],
	    'MonthlyIncome' => $vals['MonthlyIncome'],
	    'IncomeType' => $IncomeType,
	    'PayFrequency' => $vals['PayFrequency'],
	    'EmployerName' => $vals['EmployerName'],
	    'JOBTitle' => $vals['JobTitle'],
	    'MonthsEmployed' => $MonthEmployed,
	    'DirectDeposit' => $vals['DirectDeposit'],
	    'PayDate1' => date("m/d/Y", strtotime($vals['NextPayDate1'])),
	    'BankName' => $vals['BankName'],
	    'BankABA' => $vals['BankABA'],
	    'BankAccountNumber' => $vals['BankAccountNumber'],
	    'BankAccountType' => $vals['BankAccountType'],
	    'DebitCard' => $IsDebitCard,
	    'MonthsAtBank' => $MonthsAtBank,
	    'ActiveMilitary' => $vals['MilitaryService'],
	    'OwnHome' => $ownHome,
	    'MonthsAtAddress' => $MonthsAtAddress,
	    'Credit' => $vals['CreditRating'],
	    'AcceptedTerms' => 1,
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
	return $outputArray;
    }

}
