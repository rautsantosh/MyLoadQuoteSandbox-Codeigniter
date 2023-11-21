<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MyPayDayLoan_Model extends CI_Model {

    private $post_url = "https://lead.mypaydayloan.com/leadpost.ashx";
    private $username = "SphereDigital";
    private $password = "6f8dc632-3050-4433-b99d-419263a026ef";
    private $vendor_id = "Sphere25";
    private $sub_id = "myloanquote";

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
	# My Pay day loan only accept income frequency "weekly bi-weekly or twice-monthly"

	$now = date("Y-m-d");
	$MonthsAtBank = $this->get_monthdiff($vals['AccountOpenDate'], $now);
	$MonthEmployed = $this->get_monthdiff($vals['EmploymentStarted'], $now);
	$MonthsAtAddress = $this->get_monthdiff($vals['AddressMoveIn'], $now);

	$PayFrequency = $vals['PayFrequency'];
	if ($PayFrequency == "SEMIMONTHLY") {
	    $PayFrequency = "TWICEMONTHLY";
	}

	$Housing = $vals['Housing'];
	$ownHome = "OWN";
	if (in_array($Housing, array('HomeOwner', 'LivingWithParents'))):
	    $ownHome = "OWN";
	else:
	    $ownHome = "RENT";
	endif;
	$SSN = $vals['SSN'];
	$SSN1 = substr($SSN, 0, 3);
	$SSN2 = substr($SSN, 3, 2);
	$SSN3 = substr($SSN, 5, 4);

	$IncomeSource = $vals['IncomeSource'];
	if ($IncomeSource == "Employed" || $IncomeSource == "Self Employed"):
	    $IncomeSource = "EMPLOYMENT";
	else:
	    $IncomeSource = "BENEFITS";
	endif;

	$postData = array(
	    'username' => $this->username,
	    'password' => $this->password,
	    'vendor_id' => $this->vendor_id,
	    'sub_id' => $this->sub_id,
	    'bank_aba' => $vals['BankABA'],
	    'bank_account' => $vals['BankAccountNumber'],
	    'bank_account_type' => $vals['BankAccountType'],
	    'bank_length_months' => $MonthsAtBank,
	    'bank_name' => $vals['BankName'],
	    'client_ip_address' => $vals['OptinIP'],
	    'client_url_root' => "https://myloanquote.net/",
	    'customer_id' => $vals['Id'],
	    'date_dob_d' => date("d", strtotime($vals['Birthday'])),
	    'date_dob_m' => date("m", strtotime($vals['Birthday'])),
	    'date_dob_y' => date("Y", strtotime($vals['Birthday'])),
	    'email_primary' => $vals['Email'],
	    'employer_length_months' => $MonthEmployed,
	    'employer_name' => $vals['EmployerName'],
	    'employer_zip' => $vals['EmpZipcode'],
	    'home_city' => $vals['City'],
	    'home_state' => $vals['State'],
	    'home_street' => $vals['StreetAddress'],
	    'home_zip' => $vals['Zipcode'],
	    'income_date1_d' => date("d", strtotime($vals['NextPayDate1'])),
	    'income_date1_m' => date("m", strtotime($vals['NextPayDate1'])),
	    'income_date1_y' => date("Y", strtotime($vals['NextPayDate1'])),
	    'income_date2_d' => date("d", strtotime($vals['NextPayDate2'])),
	    'income_date2_m' => date("m", strtotime($vals['NextPayDate2'])),
	    'income_date2_y' => date("Y", strtotime($vals['NextPayDate2'])),
	    'income_direct_deposit' => ($vals['DirectDeposit'] == 1) ? "true" : "false",
	    'income_frequency' => $PayFrequency,
	    'income_monthly' => $vals['MonthlyIncome'],
	    'income_type' => $IncomeSource,
	    'loan_amount_desired' => $vals['LoanAmount'],
	    'military' => ($vals['MilitaryService'] == 1) ? "true" : "false",
	    'name_first' => $vals['FirstName'],
	    'name_last' => $vals['LastName'],
	    'name_title' => $vals['Title'],
	    'phone_home' => $vals['PhoneCell'],
	    'phone_work' => $vals['PhoneWork'],
	    'residence_length_months' => $MonthsAtAddress,
	    'residence_type' => $ownHome,
	    'ssn_part_1' => $SSN1,
	    'ssn_part_2' => $SSN2,
	    'ssn_part_3' => $SSN3,
	    'state_id_number' => $vals['DriverLicenseNumber'],
	    'state_issued_id' => $vals['DriversLicenseState'],
	);

	$XMLRequest = '<?xml version="1.0" encoding="utf-8"?>';
	$XMLRequest .= "<tss_loan_request>";
	foreach ($postData as $key => $val):
	    $XMLRequest .= '<data name="' . $key . '">' . $val . '</data>';
	endforeach;
	$XMLRequest .= "</tss_loan_request>";

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $this->post_url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $XMLRequest);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
	curl_setopt($ch, CURLOPT_FAILONERROR, 1);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_TIMEOUT, 120);

	$Response = curl_exec($ch);
	$error = curl_error($ch);
	curl_close($ch);

	$parser = xml_parser_create();
	xml_parse_into_struct($parser, $Response, $values);
	xml_parser_free($parser);

	$outputArray = array();
	
	foreach ($values as $val) {
	    if ($val['tag'] == "DATA") {
		$outputArray[$val['attributes']['NAME']] = $val['value'];
	    }
	}
	$outputArray['RawText'] = $Response;
	$outputArray['CampaignID'] = $this->vendor_id;
	return $outputArray;
    }

}
