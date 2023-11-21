<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

    public function __construct() {
	parent::__construct();
	$this->load->model("User_Model");
    }

    public function index($type = '') {
	if (in_array($type, array('Today', 'Weekly', 'Monthly', 'LifeTime'))):
	    $info = $this->User_Model->get_dasboard($type);
	    $data = array('data' => $info);
	    $content = $this->load->view("app/dashboard", $data, TRUE);
	    exit($content);	    
	endif;
	$this->content_view = "home_view";
    }

    public function leads($action = '',$params='') {
	if ($action == "info"):
	    $info = $this->User_Model->lead_info();
	    $data = array('Lead' => $info);
	    $content = $this->load->view("app/lead_info", $data, TRUE);
	    exit($content);
	endif;
	if ($action == "download"):
	    $this->load->dbutil();
	    $this->load->helper('file');
	    $this->load->helper('download');
	    $delimiter = ",";
	    $newline = "\r\n";
	    $filename = "Lead Details.csv";
	    $query = "SELECT A.LoanAmount,A.Title,A.FirstName,A.LastName,A.Birthday,A.Email,A.PhoneWork,A.PhoneCell,A.BestTimeToCall,A.StreetAddress,A.HouseNo,A.HouseName,A.City,A.State,A.Zipcode,A.EmpStreet,A.EmpCity,A.EmpState,A.EmpZipcode,A.Housing,A.AddressMoveIn,A.IncomeSource,A.EmployerName,A.JobTitle,A.EmploymentStarted,A.MonthlyIncome,A.PayFrequency,A.NextPayDate1,A.NextPayDate2,A.DirectDeposit,A.BankAccountType,A.BankName,A.BankABA,A.BankAccountNumber,A.AccountOpenDate,A.DriverLicenseNumber,A.DriversLicenseState,A.BankCardType,A.CreditRating,A.SSN,A.MilitaryService,A.AcceptTerms,A.OptinIP,A.OptinUserAgent,A.LeadTime,A.ParamS1,A.ParamS2,A.ParamS3,A.ParamS4,B.Provider,B.ApplicationId,B.Status,B.CampaignId,B.LeadId,B.Price,B.RedirectURL,B.Message,B.RowResponse,B.AddedOn FROM  Applicant_Info AS A RIGHT JOIN API_Response AS B ON A.Id = B.ApplicationId ORDER BY A.Id DESC";
	    $result = $this->db->query($query);
	    $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
	    force_download($filename, $data);
	    exit;
	endif;
	if ($action == 'list' && $this->input->is_ajax_request()):
	    header('Content-Type:application/json');
	    $list = $this->User_Model->lead_grid();
	    exit(json_encode($list));
	endif;
	if($action == "response"){
	    header('Content-Type:application/json');
	    $list = $this->User_Model->lead_response($params);
	    exit(json_encode($list));
	    exit(1);
	}
	$this->active_menu = 2;
	$this->content_view = "lead_view";
    }

}
