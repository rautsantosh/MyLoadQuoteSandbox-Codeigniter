<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
	parent::__construct();
	$this->load->model("Auth_Model");
    }

    public function login() {
	$data = array();
	$data['has_error'] = FALSE;
	$data['message'] = "";
	$data['redirect'] = "login";
	if ($this->input->method() == 'post'):
	    $info = $this->Auth_Model->validate();
	    if ($info->Type == 1):
		$_SESSION[SESSION_PREFIX . "PROFILE"] = $info->Profile;
		redirect(base_url());
	    else:
		$data['has_error'] = TRUE;
		$data['message'] = "Invalid Username or Password.";
	    endif;
	endif;	
	$this->load->view("public/login_view", $data);
    }
    
    public function logout(){
	$_SESSION[SESSION_PREFIX."PROFILE"] = NULL;
	redirect(base_url());
    }

}
