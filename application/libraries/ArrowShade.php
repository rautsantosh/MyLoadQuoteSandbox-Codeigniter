<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ArrowShade {

    private $campaign_id = "";
    private $key = "";
    private $source = "zMYwYwW2wnSDrJTG"; // This filed provided by Arrow Shades
    private $minprice = 2;
    private $service_url = "https://arshd.com/d.ashx";
    private $mode = "1"; // Check chk_test before production

   
        public function my_test() {
	echo 'testing';
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
	$this->minprice = $tier;
	switch ($tier):
	    case 60:
		$this->campaign_id = 2548;
		$this->key = "ApOZBAkYBg";
		break;
	    case 40:
		$this->campaign_id = 2547;
		$this->key = "gYM4Mm1qUiY";
		break;
	    case 20:
		$this->campaign_id = 2546;
		$this->key = "P3MtGadMuDU";
		break;
	    default:
		$this->campaign_id = 2545;
		$this->key = "YuVBDWwAZKg";
		break;
	endswitch;

	$now = date("Y-m-d");

	$MonthsAtBank = $this->get_monthdiff($vals['AccountOpenDate'], $now);
	$MonthEmployed = $this->get_monthdiff($vals['EmploymentStarted'], $now);
	$MonthsAtAddress = $this->get_monthdiff($vals['AddressMoveIn'], $now);

	$BestTimeToCall = $vals['BestTimeToCall'];
	if ($BestTimeToCall == "ANYTIME" || $BestTimeToCall == "MORNING"):
	    $BestTimeToCall = "M";
	endif;
	if ($BestTimeToCall == "AFTERNOON"):
	    $BestTimeToCall = "A";
	endif;
	if ($BestTimeToCall == "EVENING"):
	    $BestTimeToCall = "E";
	endif;

	$Housing = $vals['Housing'];
	$ownHome = "Rent";
	if (in_array($Housing, array('HomeOwner', 'LivingWithParents'))):
	    $ownHome = "Own";
	endif;

	$PayFrequency = $vals['PayFrequency'];
	if ($PayFrequency == "WEEKLY"):
	    $PayFrequency = "Weekly";
	endif;
	if ($PayFrequency == "BIWEEKLY"):
	    $PayFrequency = "Bi Weekly";
	endif;
	if ($PayFrequency == "MONTHLY"):
	    $PayFrequency = "Monthly";
	endif;

	$IncomeType = $vals['IncomeSource'];
	if ($IncomeType == "Employed"):
	    $IncomeType = "Employed";
	elseif ($IncomeType == "Self Employed"):
	    $IncomeType = "Self";
	else:
	    $IncomeType = "Benefits";
	endif;

	$postData = array(
	    'ckm_campaign_id' => $this->campaign_id,
	    'ckm_key' => $this->key,
	    'firstname' => $vals['FirstName'],
	    'lastname' => $vals['LastName'],
	    'address1' => $vals['StreetAddress'],
	    'city' => $vals['City'],
	    'state' => $vals['State'],
	    'zip' => $vals['Zipcode'],
	    'emailaddress' => $vals['Email'],
	    'workphone' => $vals['PhoneWork'],
	    'homephone' => $vals['PhoneCell'],
	    'besttimetocontact' => $BestTimeToCall,
	    'ipaddress' => $vals['OptinIP'],
	    'country' => 'us',
	    'loanamount' => $vals['LoanAmount'],
	    'source' => $this->source,
	    'ss' => $vals['SSN'],
	    'rentown' => $ownHome,
	    'monthsatresidence' => $MonthsAtAddress,
	    'employer' => $vals['EmployerName'],
	    'lengthatjob' => $MonthEmployed,
	    'monthlyincome' => $vals['MonthlyIncome'],
	    'directdeposit' => ($vals['DirectDeposit'] == "1") ? "Yes" : "No",
	    'birthdate' => date("m/d/Y", strtotime($vals['Birthday'])),
	    'bank' => $vals['BankName'],
	    'routingnumber' => $vals['BankABA'],
	    'accountnumber' => $vals['BankAccountNumber'],
	    'nextpaydate' => date("m/d/Y", strtotime($vals['NextPayDate1'])),
	    'secondpaydate' => date("m/d/Y", strtotime($vals['NextPayDate2'])),
	    'language' => 'English',
	    'activemilitary' => ($vals['MilitaryService'] == "1") ? "Yes" : "No",
	    'accounttype' => $vals['BankAccountType'],
	    'payfrequency' => $PayFrequency,
	    'driverslicensestate' => $vals['DriversLicenseState'],
	    'stateidnumber' => $vals['DriverLicenseNumber'],
	    'emptype' => $IncomeType,
	    'minprice' => $this->minprice,
	    'subid' => '126',
	    'ckm_subid' => '126'
		//'ckm_test' => $this->mode  // Remove this parameter in production.
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
	//$error = curl_error($ch);
	curl_close($ch);
	$outputXml = simplexml_load_string($Response);
	$outputJson = json_encode($outputXml);
	$outputArray = json_decode($outputJson, true);

	$outputArray['CampaignID'] = $this->campaign_id;

	return $outputArray;
    }

}
