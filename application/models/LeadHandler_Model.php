<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class LeadHandler_Model extends CI_Model {

    private $post_url = "";
    private $store_key = "";
    private $tier_key = "";
    private $affid = "MyLoanQuote";
    private $ref_url = "https://myloanquote.net/apply";
    private $test_mode = false;

    public function __construct() {
	parent::__construct();
    }

    private function format_phone($Phone) {
	$Phone = "(" . substr($Phone, 0, 3) . ")" . substr($Phone, 3, 3) . "-" . substr($Phone, 6);
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

    public function post_lead($vals, $Type) {

	if ($Type == "LendGreen") {
	    #$this->post_url = "https://leads-zaplo-us.stage.4finance.com/lead/vivus";
	    $this->post_url = "https://leads.zaplo.ca/lead/vivus";
	    $this->tier_key = "RDMEW0Q6WH2G5LL1R26QO1Q54BBEDVTRLPHVIITW5EAHQK59BN6NPXUPKH9KMCQ1";
	    $this->store_key = "LDGN";
	}
	if($Type == "NorthCash"){
	    $this->post_url = "https://nstf.epicloansystems.com/service/leadinbox.ashx";
	    $this->tier_key = "3D7249C1WQQ4G57TO0A03S2GTDWNN2ETJNMERCFN1CVWHVEC9OL6XEP9BO6OAMCU";
	    $this->store_key = "NCIL07";
	}


	$now = date("Y-m-d");
	$MonthsAtBank = $this->get_monthdiff($vals['AccountOpenDate'], $now);
	$MonthEmployed = $this->get_monthdiff($vals['EmploymentStarted'], $now);
	$MonthsAtAddress = $this->get_monthdiff($vals['AddressMoveIn'], $now);

	$YearAtAddress = intval($MonthsAtAddress / 12);
	$YearAtEmployed = intval($MonthEmployed / 12);
	$YearAtBank = intval($MonthsAtBank / 12);

	$Housing = $vals['Housing'];
	$ownHome = 1;
	if (in_array($Housing, array('HomeOwner', 'LivingWithParents'))):
	    $ownHome = "O";
	else:
	    $ownHome = "R";
	endif;

	$ContactTime = $vals['BestTimeToCall'];
	if ($ContactTime == 'ANYTIME' || $ContactTime = 'MORNING') {
	    $ContactTime = "M";
	}

	if ($ContactTime == "AFTERNOON") {
	    $ContactTime = "A";
	}
	if ($ContactTime == "EVENING") {
	    $ContactTime = "E";
	}

	$IncomeType = $vals['IncomeSource'];
	$IncomeTypeVal = "O";
	if ($IncomeType == "Employed"):
	    $IncomeTypeVal = "E";
	endif;
	if ($IncomeType == "Self Employed"):
	    $IncomeTypeVal = "E";
	endif;
	if ($IncomeType == "Social Security"):
	    $IncomeTypeVal = "S";
	endif;
	if ($IncomeType == "Pension"):
	    $IncomeTypeVal = "P";
	endif;
	if ($IncomeType == "Disability"):
	    $IncomeTypeVal = "D";
	endif;

	$PayFrequency = $vals['PayFrequency'];
	$PayFrequencyVal = "M";
	if ($PayFrequency == "SEMIMONTHLY") {
	    $PayFrequency = "S";
	}
	if ($PayFrequency == "BIWEEKLY") {
	    $PayFrequency = "B";
	}
	if ($PayFrequency == "WEEKLY") {
	    $PayFrequency = "W";
	}


	$Referral = array(
	    'STOREKEY' => $this->store_key,
	    'REFURL' => $this->ref_url,
	    'IPADDRESS' => $vals['OptinIP'],
	    'TIERKEY' => $this->tier_key,
	    'AFFID' => $this->affid,
	    'TEST' => $this->test_mode
	);
	$Customer = array(
	    'REQUESTEDAMOUNT' => $vals['LoanAmount'],
	    'SSN' => $vals['SSN'],
	    'DOB' => $vals['Birthday'],
	    'FIRSTNAME' => $vals['FirstName'],
	    'LASTNAME' => $vals['LastName'],
	    'ADDRESS' => $vals['StreetAddress'],
	    'CITY' => $vals['City'],
	    'STATE' => $vals['State'],
	    'ZIP' => $vals['Zipcode'],
	    'HOMEPHONE' => $this->format_phone($vals['PhoneCell']),
	    'OTHERPHONE' => $this->format_phone($vals['PhoneWork']),
	    'DLSTATE' => $vals['DriversLicenseState'],
	    'DLNUMBER' => $vals['DriverLicenseNumber'],
	    'CONTACTTIME' => $ContactTime,
	    'ADDRESSMONTHS' => $MonthsAtAddress,
	    'ADDRESSYEARS' => $YearAtAddress,
	    'RENTOROWN' => $ownHome,
	    'ISMILITARY' => ($vals['MilitaryService'] == "1") ? true : false,
	    'ISCITIZEN' => true,
	    'OTHEROFFERS' => true,
	    'EMAIL' => $vals['Email'],
	    'LANGUAGE' => 'en'
	);

	$LastPayDate = "";

	$Employment = array(
	    'INCOMETYPE' => $IncomeTypeVal,
	    'PAYTYPE' => ($vals['DirectDeposit'] == "1") ? "D" : "P",
	    'EMPMONTHS' => $MonthEmployed,
	    'EMPYEARS' => $YearAtEmployed,
	    'EMPNAME' => $vals['EmployerName'],
	    'EMPADDRESS' => $vals['EmpStreet'],
	    'EMPCITY' => $vals['EmpCity'],
	    'EMPSTATE' => $vals['EmpState'],
	    'EMPZIP' => $vals['EmpZipcode'],
	    'EMPPHONE' => $this->format_phone($vals['PhoneWork']),
	    'HIREDATE' => $vals['EmploymentStarted'],
	    'EMPTYPE' => "F",
	    'JOBTITLE' => $vals['JobTitle'],
	    'PAYFREQUENCY' => $PayFrequencyVal,
	    'NETMONTHLY' => $vals['MonthlyIncome'],
	    'LASTPAYDATE' => $LastPayDate,
	    'NEXTPAYDATE' => $vals['NextPayDate1'],
	    'SECONDPAYDATE' => $vals['NextPayDate2'],
	);

	$BankAccountType = $vals['BankAccountType'];
	$BankAccountTypeVal = "S";
	if ($BankAccountType == "CHECKING"):
	    $BankAccountTypeVal = "C";
	endif;

	$Bank = array(
	    'BANKNAME' => $vals['BankName'],
	    'ACCOUNTTYPE' => $BankAccountTypeVal,
	    'ROUTINGNUMBER' => $vals['BankABA'],
	    'ACCOUNTNUMBER' => $vals['BankAccountNumber'],
	    'BANKMONTHS' => $MonthsAtBank,
	    'BANKYEARS' => $YearAtBank
	);

	$References = array(
	    'FIRSTNAME' => "Jhon",
	    'LASTNAME' => "Doe",
	    'PHONE' => $vals['PhoneCell'],
	    'RELATIONSHIP' => "O"
	);

	$XMLRequestString = '<?xml version="1.0" ?>';
	$XMLRequestString .= "<REQUEST>";

	$XMLRequestString .= "<REFERRAL>";
	foreach ($Referral as $Key => $Val):
	    $XMLRequestString .= "<$Key>$Val</$Key>";
	endforeach;
	$XMLRequestString .= "</REFERRAL>";
	$XMLRequestString .= "<CUSTOMER>>";

	$XMLRequestString .= "<PERSONAL>";
	foreach ($Customer as $Key => $Val):
	    $XMLRequestString .= "<$Key>$Val</$Key>";
	endforeach;
	$XMLRequestString .= "</PERSONAL>";

	$XMLRequestString .= "<EMPLOYMENT>";
	foreach ($Employment as $Key => $Val):
	    $XMLRequestString .= "<$Key>$Val</$Key>";
	endforeach;
	$XMLRequestString .= "</EMPLOYMENT>";

	$XMLRequestString .= "<BANK>";
	foreach ($Bank as $Key => $Val):
	    $XMLRequestString .= "<$Key>$Val</$Key>";
	endforeach;
	$XMLRequestString .= "</BANK>";

	$XMLRequestString .= "<REFERENCES>";
	foreach ($References as $Key => $Val):
	    $XMLRequestString .= "<$Key>$Val</$Key>";
	endforeach;
	$XMLRequestString .= "</REFERENCES>";

	$XMLRequestString .= "</CUSTOMER>>";
	$XMLRequestString .= "</REQUEST>";

	#echo $XMLRequestString; exit;
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $this->post_url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $XMLRequestString);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
	curl_setopt($ch, CURLOPT_FAILONERROR, 1);
	curl_setopt($ch, CURLOPT_HEADER, false); 
	//curl_setopt($ch, CURLOPT_PROXY, "104.223.128.69"); //"104.144.190.252"
	//curl_setopt($ch, CURLOPT_PROXYPORT, "3129"); // 3129
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_TIMEOUT, 120);

	$Response = curl_exec($ch);
	$error = curl_error($ch);		
	curl_close($ch);

	$outputXml = simplexml_load_string($Response);
	$outputJson = json_encode($outputXml);
	$outputArray = json_decode($outputJson, true);
	$outputArray['CampaignID'] = $this->store_key;
	
	return $outputArray;
    }

}
