<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class LBMCNew_Model extends CI_Model {

    private $service_url = "https://leads.mystatportal.com/lead/";
    private $api_key = "";
    private $api_pwd = "dbbc9807";
    private $mode = "live"; // accept|reject will generate a response; live activates the campaign
    private $source = "myloanquote.net";

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
            case 1:
                $this->api_key = "E34404C83F4011E7A62142010A8005D6";
                break;
        endswitch;
        $now = date("Y-m-d");
        $MonthsAtBank = $this->get_monthdiff($vals['AccountOpenDate'], $now);
        $MonthEmployed = $this->get_monthdiff($vals['EmploymentStarted'], $now);
        $MonthsAtAddress = $this->get_monthdiff($vals['AddressMoveIn'], $now);

        $IncomeType = "";
        $PayFrequency = "";
        if ($vals['PayFrequency'] == "SEMIMONTHLY") {
            $PayFrequency = "TWICEMONTHLY";
        } else {
            $PayFrequency = $vals['PayFrequency'];
        }

        if ($vals['IncomeSource'] == "Employed" || $vals['IncomeSource'] == "Self Employed") {
            $IncomeType = "EMPLOYMENT";
        } else {
            $IncomeType = "BENEFITS";
        }

        $ownHome = "";

        if ($vals["Housing"] == "HomeOwner") {
            $ownHome = "YES";
        } else {
            $ownHome = "NO";
        }
        $BankAccountType = $vals['BankAccountType'];
        if($BankAccountType =="SAVINGS"){
            $BankAccountType = "SAVING";
        }

        $postData = array(
            'apiId' => $this->api_key,
            'apiPassword' => $this->api_pwd,
            'testMode' => 1, // test Reject mode
            'testSold' => 1, //test Sold mode
            'productId' => 1, 
            'price' => 0, // lead price sold for; 0 for any  need to ask
            'loanAmount' => $vals['LoanAmount'],
            'workCompanyName' => $vals['EmployerName'],
            'jobTitle' => $vals['JobTitle'],
            'activeMilitary' => ($vals['MilitaryService'] == "1" ? "YES" : "NO"),
            'workTimeAtEmployer' => $MonthEmployed,
            'ssn' => $vals['SSN'],
            'driversLicenseNumber' => $vals['DriverLicenseNumber'],
            'driversLicenseState' => $vals['DriversLicenseState'],
            'incomeType' => $IncomeType,
            'incomePaymentFrequency' => $PayFrequency,
            'incomeNetMonthly' => $vals['MonthlyIncome'],
            'incomeNextDate1' => $vals['NextPayDate1'],
            'incomeNextDate2' => $vals['NextPayDate2'],
            'bankDirectDeposit' => ($vals['DirectDeposit'] == "1" ? "YES" : "NO"),
            'bankAba' => $vals['BankABA'],
            'bankName' => $vals['BankName'],
            'bankPhone' => "", //not required
            'bankAccountNumber' => $vals['BankAccountNumber'],
            'bankAccountType' => $BankAccountType,
            'bankAccountLengthMonths' => $MonthsAtBank,
            'firstName' => $vals['FirstName'],
            'lastName' => $vals['LastName'],
            'dob' => $vals['Birthday'],
            'address' => $vals['StreetAddress'],
            'city' => $vals['EmpCity'],
            'state' => $vals['EmpState'],
            'zip' => $vals['Zipcode'],
            'ownHome' => $ownHome, // need to ask required
            'addressLengthMonths' => $MonthsAtAddress,
            'email' => $vals['Email'],
            'homePhone' => $vals['PhoneCell'],
            'workPhone' => $vals['PhoneWork'],
            'cellPhone' => $vals['PhoneCell'],
            'userIp' => $vals['OptinIP'],
            'webSiteUrl' => $this->source,
            'webmasterSourceId' => $vals['ParamS3']
        );
        $postvals = http_build_query($postData);
        $Response = "NA";
        $ch = curl_init($this->service_url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Expect:"));
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        /*curl_setopt($ch, CURLOPT_PROXYPORT, '3129');
        curl_setopt($ch, CURLOPT_PROXYTYPE, 'HTTP');
        curl_setopt($ch, CURLOPT_PROXY, '192.210.227.248');
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, "indiausr:9bd69fb7-556e-4d61-b404-c9e533170709");*/
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

        if (curl_errno($ch)) {
            echo curl_error($ch);
        } else {
            try {
                $Response = curl_exec($ch);
            } catch (Exception $e) {
                echo $e->getMessage();
            }
            curl_close($ch);
        }
        $outputArray=json_decode($Response, true);
        $outputArray['CampaignID'] = $this->api_key;
        return $outputArray;
        
    }

}
