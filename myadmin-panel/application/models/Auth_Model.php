<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_Model extends CI_Model {

    public function __construct() {
	parent::__construct();
    }

    public function validate() {
	$Email = $this->input->post("Email");
	$Password = $this->input->post("Password");

	$Password = md5($Password);

	$sql = "SELECT * FROM `user_master` WHERE `Email` = ? AND `Password` = ?";
	$query = $this->db->query($sql, array($Email, $Password));
	$result = $query->result();

	$response = new stdClass();

	if (count($result) == 0):
	    $response->Type = 0;
	else:
	    $response->Type = 1;
	    $response->Profile = $result[0];
	endif;
	
	return $response;
    }

}
