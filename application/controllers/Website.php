<?php

ob_start();
session_start();

defined('BASEPATH') OR exit('No direct script access allowed');

class Website extends CI_Controller {

    private $defaultRedirectURL = "http://topfinancepicks.com/v13/3478.php";

    private function set_session($key, $val) {
        $_SESSION[SESSION_PREFIX . $key] = $val;
    }

    private function get_session($key) {
        return isset($_SESSION[SESSION_PREFIX . $key]) ? $_SESSION[SESSION_PREFIX . $key] : NULL;
    }

    public function __construct() {
        parent::__construct();
    }

    public function pages($page = 'home') {
        if ($page == "validatezip") {
            $zipcode = $this->input->post("zipcode");
            $info = $this->Website_Model->zipcode_info($zipcode);
            header('Content-Type:application/json');
            $response = new stdClass();
            if (count($info) > 0) {
                $response->type = "success";
            } else {
                $response->title = "Invalid Zipcde";
                $response->text = "Zipcode you entered is not valid.";
                $response->type = "error";
            }
            echo json_encode($response);
            exit(1);
        }
        if ($page == "verify") {
            $this->verify_data();
            return;
        }
        if ($page == "processApplication" && $this->input->method() == "post") {
            $this->process_application();
            return;
        }
        $page_file = $page . "_view";
        if (!file_exists(APPPATH . "views/Pages/$page_file.php")) {
            $this->load->view("Pages/common/error_page");
            return;
        }
        $IsApplyForm = FALSE;
        if ($page_file == "apply_view"):
            $IsApplyForm = TRUE;
        endif;
        $view_data = array(
            "s1" => $this->input->get("s1"),
            "s2" => $this->input->get("s2"),
            "s3" => $this->input->get("s3"),
            "s4" => $this->input->get("s4"),
            "zipcode" => "",
            "city" => "",
            "state" => "",
            "IsApplyForm" => $IsApplyForm,
            "defaultRedirectURL" => $this->defaultRedirectURL
        );
        if ($page == "apply") {
            if ($this->input->method() != "post"):
                redirect(base_url());
            endif;
            $action = $this->input->post("PostAction");
            if (strlen($action) > 2) {
                $this->load->view("Pages/sub/apply_wait");
                return;
            }
            $zipcode = $this->input->post("zipcode");
            
            $info = $this->Website_Model->zipcode_info($zipcode);
            
            $IsReview = $this->input->post("ReviewApp");
            
            if ($IsReview == "1") {
                $app_data = $this->Website_Model->application_review_data();
                if ($app_data == NULL) {
                    $this->set_session("AppData", NULL);
                    redirect(base_url());
                } else {

                    $view_data['App'] = $app_data;
                    $view_data['s1'] = $this->input->post("s1");
                    $view_data['s2'] = $this->input->post("s2");
                    $view_data['s3'] = $this->input->post("s3");
                    $view_data['s4'] = $this->input->post("s4");
                    if ($info == NULL) {
                        $info = new stdClass();
                    }
                    $info->postalCode = $app_data->Zipcode;
                    $info->region = $app_data->State;
                    $info->city = $app_data->City;
                    $page_file = "application_review";
                }
            } elseif ($info == NULL) {
                redirect(base_url("service-unavailable"));
                return;
            }
            // Checing for Unavailable area
            if ($info->region == "NY") {
                redirect(base_url("service-unavailable"));
                return;
            }

            // Setting cookie for zipcode 
            $info->postalCode = (string) $info->postalCode;
            $cookie_val = json_encode($info);
            $cookie_val = base64_encode($cookie_val);
            $cookie_val = strrev($cookie_val);

            set_cookie("_webdata", $cookie_val, time() + (86400 * 30), "", "");
            $view_data['s1'] = $this->input->post("s1");
            $view_data['s2'] = $this->input->post("s2");
            $view_data['s3'] = $this->input->post("s3");
            $view_data['s4'] = $this->input->post("s4");
            $view_data['zipcode'] = (string) sprintf("%05d", $info->postalCode);
            $view_data['city'] = $info->city;
            $view_data['state'] = $info->region;
        } else {

            // get cookie
            $data = get_cookie("_webdata");
            $cookie_data = strrev($data);
            $cookie_data = base64_decode($cookie_data);
            $cookie_data = json_decode($cookie_data, TRUE);
            $POSTALCODE = (string) $cookie_data['postalCode'];
            $POSTALCODE = sprintf("%05d", $POSTALCODE);
            if ($POSTALCODE == "00000"):
                $POSTALCODE = "";
            endif;
            $view_data["POSTALCODE"] = $POSTALCODE;

            if ($page == "application-error") {
                $errors = $this->get_session("ERROR");
                $AppData = $this->get_session("AppData");
                if (is_null($errors)) {
                    redirect(base_url());
                    return;
                }
                $view_data['errors'] = $errors;
                $view_data['AppData'] = $AppData;
            }
        }

        $this->load->view("Pages/common/header", $view_data);
        $this->load->view("Pages/$page_file", $view_data);
        $this->load->view("Pages/common/footer", $view_data);
    }

    public function verify_data() {
        $flag = $this->Website_Model->store_lead();
        echo $flag;
    }

    private function set_errors_redirect($Application, $errors) {
        $APPDATA = array(
            "appid" => $Response->Application['Id'],
            "leadtime" => $Response->Application['LeadTime'],
            "userip" => $Response->Application['OptinIP'],
            "zipcode" => $Response->Application['Zipcode'],
            "s1" => $Response->Application['ParamS1'],
            "s2" => $Response->Application['ParamS2'],
            "s3" => $Response->Application['ParamS3'],
            "s4" => $Response->Application['ParamS4']
        );
        $this->set_session("ERROR", $errors);
        $this->set_session("AppData", $APPDATA);
        redirect(base_url("application-error"));
        exit(1);
    }

    private function process_application() {
        $Response = $this->Website_Model->store_application();
        if ($Response->IsError == TRUE) {
            $SessData = $Response->ErrorData;
            $this->set_errors_redirect($Response->Application, $SessData);
        }
        $this->ping_tree($Response->Application);
    }

    private function ping_tree($Application) {
        $TierLevel = array(60, 40, 20, 2);
        $IsLeadSold = FALSE;
        $this->lbmc_api_new($Application, 2);
        return; // Remove comment after testing
        
        /*
          $APIRedirectURL = "";
          $ApplicationFlag = intval($Application['Id']) % 3;
          if ($ApplicationFlag == 0) { // Ping Tree Posting Order A	// Click Allocation 33 %

          # TRYING TO SALE LEAD TO DEV WIRE FOR $230
          $APIResponse = $this->devwire_consulting($Application, 230);

          # TRYING TO SALE LEAD TO VIVUS LEND GREEN
          $this->leadhandler_post($Application, 35, "LendGreen");

          #TRYING TO SALE LEAD TO OTHER LENDERS
          $this->mypayday_loan($Application, 25);

          # TRYING TO SALE LEAD TO ARROW SHADE FOR ALL TIER
          $this->arrow_shade($Application, 60);
          $this->arrow_shade($Application, 40);
          $this->arrow_shade($Application, 20);
          $this->arrow_shade($Application, 2);

          ############## 60 #######################
          $this->lbmc_api($Application, 60);
          $this->zero_parallel($Application, 60);
          $this->leads_market($Application, 60);
          $this->round_sky($Application, 60);

          ############## 40 #######################
          $this->lbmc_api($Application, 40);
          $this->zero_parallel($Application, 40);
          $this->leads_market($Application, 40);
          $this->round_sky($Application, 40);

          ############## 20 #######################
          $this->lbmc_api($Application, 20);
          $this->zero_parallel($Application, 20);
          $this->leads_market($Application, 20);
          $this->round_sky($Application, 20);

          ############## 2 #######################
          $this->zero_parallel($Application, 2);
          $this->leads_market($Application, 2);
          $this->round_sky($Application, 2);
          $this->lbmc_api($Application, 2);
          ############## 1 #######################
          $this->epcvip_post($Application,1);
          }
          if ($ApplicationFlag == 1) { // Ping Tree Posting Order B Click Allocation 33 %
          # TRYING TO SALE LEAD TO DEV WIRE FOR $230
          $APIResponse = $this->devwire_consulting($Application, 230);

          # TRYING TO SALE LEAD TO VIVUS NORTH CASH
          $this->leadhandler_post($Application, 35, "NorthCash");

          #TRYING TO SALE LEAD TO OTHER LENDERS
          $this->mypayday_loan($Application, 25);

          # TRYING TO SALE LEAD TO LBMC FOR ALL TIER
          $this->lbmc_api($Application, 60);
          $this->lbmc_api($Application, 40);
          $this->lbmc_api($Application, 20);
          $this->lbmc_api($Application, 2);

          ############## 60 #######################
          $this->arrow_shade($Application, 60);
          $this->zero_parallel($Application, 60);
          $this->leads_market($Application, 60);
          $this->round_sky($Application, 60);

          ############## 40 #######################
          $this->arrow_shade($Application, 40);
          $this->zero_parallel($Application, 40);
          $this->leads_market($Application, 40);
          $this->round_sky($Application, 40);

          ############## 20 #######################
          $this->arrow_shade($Application, 20);
          $this->zero_parallel($Application, 20);
          $this->leads_market($Application, 20);
          $this->round_sky($Application, 20);

          ############## 2 #######################
          $this->arrow_shade($Application, 2);
          $this->zero_parallel($Application, 2);
          $this->leads_market($Application, 2);
          $this->round_sky($Application, 2);

          ############## 1 #######################
          $this->epcvip_post($Application,1);
          }
          if ($ApplicationFlag == 2) { // Ping Tree Posting Order C Click Allocation 33 %
          $this->edm_posting($Application, 0.01); //
          }

          redirect($this->defaultRedirectURL);
         */
    }

    //added by santosh
    private function lbmc_api_new($Application, $Tier) {
        $APIResponse = NULL;
        if ($Tier == 2) {
            $Tier = 1;
        }
        $APIResponse = $this->LBMCNew_Model->post_lead($Application, $Tier);
        $Response = new stdClass();
        $trans_id = (isset($APIResponse['lead_id'])) ? $APIResponse['lead_id'] : "";
        $trans_id = (is_array($trans_id)) ? implode(",", $trans_id) : $trans_id;
        $Response->Provider = "LBMCNew";
        $Response->ApplicationId = $Application['Id'];
        $Response->Status = $APIResponse['status'];
        $Response->CampaignId = $APIResponse['CampaignID'];
        $Response->LeadId = $trans_id;
        $Response->Tier = $Tier;
        $Response->Price = (isset($APIResponse['price'])) ? $APIResponse['price'] : "";
        $Response->RedirectURL = (isset($APIResponse['redirect_url'])) ? $APIResponse['redirect_url'] : "";
        $Response->Message = (isset($APIResponse['status_text'])) ? $APIResponse['status_text'] : "";
        $Response->Response = json_encode($APIResponse);
        $this->Website_Model->api_response($Response); #need to chk for redirect url
        /*var_dump($Response);
        echo "+++++++++++++++++++++++++++++++++++++++++++++++";
        print_r($Application);exit;*/
        if($Response->Message=="sold") {
            redirect($Response->RedirectURL);
        }
       
    }

    private function lbmc_api_sandbox($Application, $Tier) {
        $APIResponse = NULL;
        if ($Tier == 2) {
            $Tier = 1;
        }
        $APIResponse = $this->LBMC_Model->post_lead($Application, $Tier);

        $Response = new stdClass();

        $trans_id = (isset($APIResponse['trans_id'])) ? $APIResponse['trans_id'] : "";
        $trans_id = (is_array($trans_id)) ? implode(",", $trans_id) : $trans_id;

        $Response->Provider = "LBMC";
        $Response->ApplicationId = $Application['Id'];
        $Response->Status = $APIResponse['status'];
        $Response->CampaignId = $APIResponse['CampaignID'];
        $Response->LeadId = $trans_id;
        $Response->Tier = $Tier;
        $Response->Price = (isset($APIResponse['price'])) ? $APIResponse['price'] : "";
        $Response->RedirectURL = (isset($APIResponse['redirect'])) ? $APIResponse['redirect'] : "";
        $Response->Message = (isset($APIResponse['msg'])) ? $APIResponse['msg'] : "";
        $Response->Response = json_encode($APIResponse);

        $this->Website_Model->api_response($Response);
        if ($APIResponse['status'] == "ACCEPT" && intval($APIResponse['price']) > 0):
            $APIRedirectURL = $APIRedirectURL['redirect'];
            #$this->post_track_pixel(); // Remove commnet in production
            redirect($APIRedirectURL);
        endif;
    }

    private function zero_parallel($Application, $Tier) {
        $APIResponse = NULL;
        $APIResponse = $this->ZeroParallel_Model->post_lead($Application, $Tier);

        $Response = new stdClass();

        $Response->Provider = "ZEROPARALLEL";
        $Response->ApplicationId = $Application['Id'];
        $Response->Status = $APIResponse['status'];
        $Response->CampaignId = "";
        $Response->LeadId = (isset($APIResponse['id'])) ? $APIResponse['id'] : "";
        $Response->Tier = $Tier;
        $Response->Price = (isset($APIResponse['price'])) ? $APIResponse['price'] : "";
        $Response->RedirectURL = (isset($APIResponse['redirect'])) ? $APIResponse['redirect'] : "";
        $Response->Message = "";
        $Response->Response = json_encode($APIResponse);

        $this->Website_Model->api_response($Response);

        if ($APIResponse['status'] == "sold" && intval($APIResponse['price']) > 0) {
            $APIRedirectURL = $APIResponse['URL'];
            $this->post_track_pixel();
            redirect($APIRedirectURL);
        }
    }

    private function round_sky($Application, $Tier) {
        $APIResponse = NULL;
        $APIResponse = $this->RoundSky_Model->post_lead($Application, $Tier);

        $Response = new stdClass();

        $Response->Provider = "ROUNDSKY";
        $Response->ApplicationId = $Application['Id'];
        $Response->Status = $APIResponse['DECISION'];
        $Response->CampaignId = $APIResponse['CampaignID'];
        $Response->LeadId = (isset($APIResponse['LEADID'])) ? $APIResponse['LEADID'] : "";
        $Response->Tier = $Tier;
        $Response->Price = (isset($APIResponse['PRICE'])) ? $APIResponse['PRICE'] : "";
        $Response->RedirectURL = (isset($APIResponse['URL'])) ? $APIResponse['URL'] : "";
        $Response->Message = (isset($APIResponse['MESSAGE'])) ? $APIResponse['MESSAGE'] : "";
        $Response->Response = json_encode($APIResponse);

        $this->Website_Model->api_response($Response);

        if ($APIResponse['DECISION'] == "APPROVED" && intval($APIResponse['PRICE']) > 0) {
            $APIRedirectURL = $APIResponse['URL'];
            $this->post_track_pixel();
            redirect($APIRedirectURL);
        }
    }

    private function leads_market($Application, $Tier) {
        $APIResponse = NULL;
        $APIResponse = $this->Leadsmarket_Model->post_lead($Application, $Tier);

        $Response = new stdClass();

        $Response->Provider = "LEADSMARKET";
        $Response->ApplicationId = $Application['Id'];
        $Response->Status = $APIResponse['Result'];
        $Response->CampaignId = $APIResponse['CampaignID'];
        $Response->LeadId = (isset($APIResponse['LeadID'])) ? $APIResponse['LeadID'] : "";
        $Response->Tier = $Tier;
        $Response->Price = (isset($APIResponse['Price'])) ? $APIResponse['Price'] : "";
        $Response->RedirectURL = (isset($APIResponse['RedirectURL'])) ? $APIResponse['RedirectURL'] : "";
        $Response->Message = (isset($APIResponse['Messages']['Message'])) ? $APIResponse['Messages']['Message'] : "";
        $Response->Response = json_encode($APIResponse);

        $this->Website_Model->api_response($Response);
        /* Redirect to show error when error occured by leads market.
          if ($APIResponse['Result'] == "Errors") {
          $errors_data = array();
          foreach ($APIResponse['Errors']['Error'] as $error) {
          if (isset($errors_data[$error['Field']])) {
          $errors_data[$error['Field']] .= $error['Field'] . " has " . $error['Description'] . ".";
          } else {
          $errors_data[$error['Field']] = $error['Field'] . " has " . $error['Description'] . ".";
          }
          }
          $this->set_errors_redirect($Application, $errors_data);
          }
         */
        if ($APIResponse['Result'] == "Accepted" && intval($APIResponse['Price']) > 0) {
            $APIRedirectURL = $APIResponse['RedirectURL'];
            $this->post_track_pixel();
            redirect($APIRedirectURL);
        }
    }

    private function lbmc_api($Application, $Tier) {
        $APIResponse = NULL;
        if ($Tier == 2) {
            $Tier = 1;
        }
        $APIResponse = $this->LBMC_Model->post_lead($Application, $Tier);

        $Response = new stdClass();

        $trans_id = (isset($APIResponse['trans_id'])) ? $APIResponse['trans_id'] : "";
        $trans_id = (is_array($trans_id)) ? implode(",", $trans_id) : $trans_id;

        $Response->Provider = "LBMC";
        $Response->ApplicationId = $Application['Id'];
        $Response->Status = $APIResponse['status'];
        $Response->CampaignId = $APIResponse['CampaignID'];
        $Response->LeadId = $trans_id;
        $Response->Tier = $Tier;
        $Response->Price = (isset($APIResponse['price'])) ? $APIResponse['price'] : "";
        $Response->RedirectURL = (isset($APIResponse['redirect'])) ? $APIResponse['redirect'] : "";
        $Response->Message = (isset($APIResponse['msg'])) ? $APIResponse['msg'] : "";
        $Response->Response = json_encode($APIResponse);

        $this->Website_Model->api_response($Response);
        if ($APIResponse['status'] == "ACCEPT" && intval($APIResponse['price']) > 0):
            $APIRedirectURL = $APIRedirectURL['redirect'];
            $this->post_track_pixel();
            redirect($APIRedirectURL);
        endif;
    }

    private function arrow_shade($Application, $Tier) {
        $APIResponse = NULL;
        $APIResponse = $this->Arrowshade_Model->post_lead($Application, $Tier);

        $Response = new stdClass();

        $Response->Provider = "ARROWSHADE";
        $Response->ApplicationId = $Application['Id'];
        $Response->Status = $APIResponse['code'];
        $Response->CampaignId = $APIResponse['CampaignID'];
        $Response->LeadId = (isset($APIResponse['leadid'])) ? $APIResponse['leadid'] : "";
        $Response->Tier = $Tier;
        $Response->Price = (isset($APIResponse['price'])) ? $APIResponse['price'] : "";
        $Response->RedirectURL = (isset($APIResponse['redirect'])) ? $APIResponse['redirect'] : "";
        $Response->Message = (isset($APIResponse['msg'])) ? $APIResponse['msg'] : "";
        $Response->Response = json_encode($APIResponse);

        $this->Website_Model->api_response($Response);

        if ($APIResponse['code'] == "0" && intval($APIResponse['price']) > 0) {
            $APIRedirectURL = $APIResponse['redirect'];
            $this->post_track_pixel();
            redirect($APIRedirectURL);
        }
    }

    private function devwire_consulting($Application, $Tier) {
        $APIResponse = NULL;
        $APIResponse = $this->DevwireConsulting_Model->post_lead($Application, $Tier);

        $Response = new stdClass();

        $Response->Provider = "DEVWIRE";
        $Response->ApplicationId = $Application['Id'];
        $Response->Status = $APIResponse['status'];
        $Response->CampaignId = $APIResponse['CampaignID'];
        $Response->LeadId = (isset($APIResponse['leadid'])) ? $APIResponse['leadid'] : "";
        $Response->Tier = $Tier;
        $Response->Price = (isset($APIResponse['price'])) ? $APIResponse['price'] : "";
        $Response->RedirectURL = (isset($APIResponse['landing'])) ? $APIResponse['landing'] : "";
        $Response->Message = (isset($APIResponse['reasons'])) ? implode("|", $APIResponse['reasons']) : "";
        $Response->Response = json_encode($APIResponse);


        $this->Website_Model->api_response($Response);

        if ($APIResponse['status'] == "approved") {
            $APIRedirectURL = $APIResponse['landing'];
            $this->post_track_pixel();
            redirect($APIRedirectURL);
        }
        return $APIResponse;
    }

    private function mypayday_loan($Application, $Tier) {
        $APIResponse = NULL;
        $APIResponse = $this->MyPayDayLoan_Model->post_lead($Application, $Tier);

        $Response = new stdClass();

        $Response->Provider = "MYPAYDAYLOAN";
        $Response->ApplicationId = $Application['Id'];
        $Response->Status = $APIResponse['status'];
        $Response->CampaignId = $APIResponse['CampaignID'];
        $Response->LeadId = (isset($APIResponse['application_id'])) ? $APIResponse['application_id'] : "";
        $Response->Tier = $Tier;
        $Response->Price = (isset($APIResponse['amount'])) ? $APIResponse['amount'] : "";
        $Response->RedirectURL = (isset($APIResponse['message'])) ? $APIResponse['message'] : "";
        $Response->Message = (isset($APIResponse['msg'])) ? $APIResponse['msg'] : "";
        $Response->Response = json_encode($APIResponse);

        $this->Website_Model->api_response($Response);

        if ($APIResponse['status'] == "accepted" && intval($APIResponse['amount']) > 0) {
            $APIRedirectURL = $APIResponse['message'];
            $this->post_track_pixel();
            redirect($APIRedirectURL);
        }
        return $APIResponse;
    }

    public function edm_posting($Application, $Tier) {
        $APIResponse = NULL;
        $APIResponse = $this->EMDPosting_Model->post_lead($Application, $Tier);

        $Response = new stdClass();

        $Response->Provider = "EDM-POSTING";
        $Response->ApplicationId = $Application['Id'];
        $Response->Status = $APIResponse['Status'];
        $Response->CampaignId = $APIResponse['CampaignID'];
        $Response->LeadId = (isset($APIResponse['ConfirmationID'])) ? $APIResponse['ConfirmationID'] : "";
        $Response->Tier = $Tier;
        $Response->Price = (isset($APIResponse['Price'])) ? $APIResponse['Price'] : "";
        $Response->RedirectURL = (isset($APIResponse['RedirectUrl'])) ? $APIResponse['RedirectUrl'] : "";
        $Response->Message = (isset($APIResponse['Message'])) ? $APIResponse['Message'] : "";
        $Response->Response = json_encode($APIResponse);

        $this->Website_Model->api_response($Response);

        if ($APIResponse['Status'] == "Accepted" && intval($APIResponse['Price']) > 0) {
            $APIRedirectURL = $APIResponse['RedirectUrl'];
            $this->post_track_pixel();
            redirect($APIRedirectURL);
        }
        return $APIResponse;
    }

    private function leadhandler_post($Application, $Tier, $Type) {
        $APIResponse = NULL;

        #Type =  LendGreen OR NorthCash
        $APIResponse = $this->LeadHandler_Model->post_lead($Application, $Type);
        $Response = new stdClass();

        $Response->Provider = "LEADHANDLER-" . strtoupper($Type);
        $Response->ApplicationId = $Application['Id'];
        $Response->Status = isset($APIResponse['Result']) ? $APIResponse['Result'] : "";
        $Response->CampaignId = $APIResponse['CampaignID'];
        $Response->LeadId = (isset($APIResponse['ConfirmationID'])) ? $APIResponse['ConfirmationID'] : "";
        $Response->Tier = $Tier;
        $Response->Price = (isset($APIResponse['Price'])) ? $APIResponse['Price'] : "";
        $Response->RedirectURL = (isset($APIResponse['RedirectUrl'])) ? $APIResponse['RedirectUrl'] : "";
        $Response->Message = (isset($APIResponse['RejectionReason'])) ? $APIResponse['RejectionReason'] : "";
        $Response->Response = json_encode($APIResponse);

        $this->Website_Model->api_response($Response);

        if (isset($APIResponse['Result']) && $APIResponse['Result'] == "A") {
            $APIRedirectURL = $APIResponse['RedirectUrl'];
            $this->post_track_pixel();
            redirect($APIRedirectURL);
        }
        return $APIResponse;
    }

    public function epcvip_post($Application, $Tier) {
        $APIResponse = NULL;
        $APIResponse = $this->EPCVIP_Model->post_lead($Application, $Tier);

        $Response = new stdClass();

        $Response->Provider = "EPCVIP";
        $Response->ApplicationId = $Application['Id'];
        $Response->Status = isset($APIResponse['code']) ? $APIResponse['code'] : "";
        $Response->CampaignId = $APIResponse['CampaignID'];
        $Response->LeadId = (isset($APIResponse['prospectId'])) ? $APIResponse['prospectId'] : "";
        $Response->Tier = $Tier;
        $Response->Price = (isset($APIResponse['price'])) ? $APIResponse['price'] : "";
        $Response->RedirectURL = (isset($APIResponse['actionData'])) ? $APIResponse['actionData'] : "";
        $Response->Message = (isset($APIResponse['message'])) ? $APIResponse['message'] : "";
        $Response->Response = json_encode($APIResponse);

        $this->Website_Model->api_response($Response);

        if ($APIResponse['action'] == "redirect " && $APIResponse['code'] == "200" && intval($APIResponse['price']) > 0) {
            $APIRedirectURL = $APIResponse['actionData'];
            $this->post_track_pixel();
            redirect($APIRedirectURL);
        }
        return $APIResponse;
    }

    private function post_track_pixel($postback_data = array()) {
        $postback_url = "http://tidycraning.com/p.ashx";

        $postback_data['a'] = "556";
        $postback_data['e'] = "588";
        $postback_data['f'] = "pb";

        $postback_data = array_map('urlencode', $postback_data);

        $postback_url = $postback_url . "?" . http_build_query($postback_data);

        $ch1 = curl_init();
        curl_setopt($ch1, CURLOPT_URL, $postback_url);
        curl_setopt($ch1, CURLOPT_POST, 0);
        curl_setopt($ch1, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch1, CURLOPT_HEADER, FALSE);
        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch1, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch1, CURLOPT_TIMEOUT, 120);
        curl_setopt($ch1, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch1, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

        if (curl_errno($ch1)):
            return array("code" => "500", "msg" => "POST ERROR!!");
        else:
            $Response = curl_exec($ch1);
            $outputXml = simplexml_load_string($Response);
            $outputJson = json_encode($outputXml);
            $outputArray = json_decode($outputJson, true);
            return $outputArray;
        endif;
    }

    private function leadtest() { // This function is used for testing.	
        exit(1);
        $LeadId = 569;
        $sql = "SELECT * FROM Applicant_Info WHERE Id = ?";
        $query = $this->db->query($sql, array($LeadId));
        $result = $query->result_array();
        $Application = $result[0];
        $APIResponse = $this->EMDPosting_Model->post_lead($Application, 1);
        #$info = $this->leadhandler_post($Application,35,"LendGreen");
        #$info = $this->EMDPosting_Model->post_lead($Application,0.01);
        print_r($APIResponse);
        exit;

        #$APIResponse = $this->devwire_consulting($Application, 2);
        #$info = $this->devwire_consulting_repost($Application, $APIResponse);
        #$info = $this->DevwireConsulting_Model->repost_lead($APIResponse['app_id']);
        #$info = $this->edm_posting($Application, 0.01);
        #$info = $this->EMDPosting_Model->post_lead($Application,0.01);
        #$info = $this->LeadHandler_Model->post_lead($Application,"LendGreen");
        $info = $this->LeadHandler_Model->post_lead($Application, "NorthCash");
        echo '<pre>';
        print_r($info);
        echo '</pre>';

        #$this->mypayday_loan($Application, 2);
        #$Response = $this->LBMC_Model->post_lead($Application,);
        #$Response = $this->MyPayDayLoan_Model->post_lead($Application, 1);
        #$Response = $this->DevwireConsulting_Model->post_lead($Application,1);
        #echo '<pre>'; 
        #print_r($Response); 
        #echo '</pre>'; 
    }

}
