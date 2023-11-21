<?php

class DevwireConsulting_Model extends CI_Model {

    private $mode = 1; # 0 => Test mode 1 => Production Mode
    private $url = "https://leads.dwcdata.com/apply.json";
    private $provider_name = "sphere";
    private $provider_password = "G9iDse2U9Gys7W9kNp";
    private $campaign = "450100";
    private $affiliate_id = "myloanquote"; // Confirm in production

    public function __construct() {
	parent::__construct();
	$this->url = ($this->mode == 1) ? "https://leads.dwcdata.com/apply.json" : "https://leads-test.dwcdata.com/apply.json";
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

    public function repost_lead($app_id) {
	$repost_string = '<request>';
	$repost_string .= '<lead_provider_name>'.$this->provider_name.'</lead_provider_name>';
	$repost_string .= '<lead_provider_password>'.$this->provider_password.'</lead_provider_password>';
	$repost_string .= '<app_id>'.$app_id.'</app_id>';	
	$repost_string .= '</request>';
	
	$postVals = array(
	    'lead_provider_name' => $this->provider_name,
	    'lead_provider_password' => $this->provider_password,
	    'app_id' => $app_id 
	);
	
	$postVal = http_build_query($postVals);
	
	$repost_url = "https://leads-test.dwcdata.com/price_reject/yes.xml";
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $repost_url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postVal);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Expect:"));
	curl_setopt($ch, CURLOPT_FAILONERROR, 1);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_TIMEOUT, 120);

	$Response = curl_exec($ch);
	
	$outputXml  =  simplexml_load_string($Response);
	$outputJson = json_encode($outputXml);
	$outputArray = json_decode($outputJson, true);
	
	$outputArray['CampaignID'] = $this->campaign;
	
	return $outputArray;
    }

    public function post_lead($vals, $tier) {

	$now = date("Y-m-d");
	$MonthsAtAddress = $this->get_monthdiff($vals['AddressMoveIn'], $now);
	$MonthEmployed = $this->get_monthdiff($vals['EmploymentStarted'], $now);
	$PayFrequency = $vals['PayFrequency'];

	if ($PayFrequency == "SEMIMONTHLY") {
	    $PayFrequency = "semi-monthly";
	}
	if ($PayFrequency == "BIWEEKLY") {
	    $PayFrequency = "bi-weekly";
	}
	$IncomeSource = $vals['IncomeSource'];
	if ($IncomeSource == "Employed"):
	    $IncomeSource = "Employed";
	elseif ($IncomeSource == "Self Employed"):
	    $IncomeSource = "Self";
	else:
	    $IncomeSource = "Benefits";
	endif;

	$Housing = $vals['Housing'];
	$ownHome = "rent";
	if (in_array($Housing, array('HomeOwner', 'LivingWithParents'))):
	    $ownHome = "own";
	endif;

	$post_data = array(
	    'lead_provider_name' => $this->provider_name,
	    'lead_provider_password' => $this->provider_password,
	    'campaign' => $this->campaign,
	    'affiliate_id' => $this->affiliate_id,
	    'ip_address' => $vals['OptinIP'],
	    'requested_loan_amount' => $vals['LoanAmount'],
	    'ssn' => $vals['SSN'],
	    'email' => $vals['Email'],
	    'birthday' => $vals['Birthday'],
	    'first_name' => $vals['FirstName'],
	    'last_name' => $vals['LastName'],
	    'dl_state' => $vals['DriversLicenseState'],
	    'dl_number' => $vals['DriverLicenseNumber'],
	    'active_military' => $vals['MilitaryService'],
	    'home_phone' => $vals['PhoneCell'],
	    'best_time_to_contact' => $vals['BestTimeToCall'],
	    'street' => $vals['StreetAddress'],
	    'city' => $vals['City'],
	    'state' => $vals['State'],
	    'postal' => $vals['Zipcode'],
	    'rent_or_own' => $ownHome,
	    'months_at_residence' => $MonthsAtAddress,
	    'monthly_income' => $vals['MonthlyIncome'],
	    'pay_schedule' => $PayFrequency,
	    'pay_date_1' => $vals['NextPayDate1'],
	    'pay_date_2' => $vals['NextPayDate2'],
	    'direct_deposit' => $vals['DirectDeposit'],
	    'income_source' => $IncomeSource,
	    'occupation' => $vals['JobTitle'],
	    'months_at_job' => $MonthEmployed,
	    'employer_name' => $vals['EmployerName'],
	    'employer_phone' => $vals['PhoneWork'],
	    'employer_street' => $vals['EmpStreet'],
	    'employer_city' => $vals['EmpCity'],
	    'employer_postal' => $vals['EmpZipcode'],
	    'employer_state' => $vals['EmpState'],
	    'bank_routing_number' => $vals['BankABA'],
	    'bank_account_number' => $vals['BankAccountNumber'],
	    'bank_account_type' => $vals['BankAccountType'],
	    'price_reject' => "yes",
	);

	$postvals = http_build_query($post_data);

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $this->url);
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
	$outputArray = json_decode($Response, true);

	$outputArray['CampaignID'] = $this->campaign;
	//$outputArray['Q_STRING'] = $postvals;
	return $outputArray;
    }

}
