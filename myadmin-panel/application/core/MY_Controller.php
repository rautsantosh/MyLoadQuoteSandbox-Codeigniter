<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    protected $loginUser;
    private $layout = "web_app";
    protected $view_data = array();
    protected $content_view = "";
    protected $active_menu = 1;

    public function __construct() {
	parent::__construct();
	$this->_is_login();
    }

    protected function set_session($key, $value) {
	$_SESSION[SESSION_PREFIX . $key] = $val;
    }

    protected function get_session($key) {
	return isset($_SESSION[SESSION_PREFIX . $key]) ? $_SESSION[SESSION_PREFIX . $key] : NULL;
    }

    private function _is_login() {
	if (!isset($_SESSION[SESSION_PREFIX . "PROFILE"]) || $_SESSION[SESSION_PREFIX . "PROFILE"] == NULL):
	    redirect(base_url("login"));
	endif;
	$this->loginUser = $_SESSION[SESSION_PREFIX . "PROFILE"];
    }

    public function _output() {
	$view_data = $this->view_data;
	$view_data['user'] = $this->loginUser;
	$view_data['active_menu'] = $this->active_menu;
	$view_data['default_machine'] = $this->get_session("DEFAULT_MACHINE");
	$yield = "";
	if (!file_exists(APPPATH . "/views/app/" . $this->content_view . ".php")) {
	    show_404();
	} else {
	    $yield = $this->load->view("app/" . $this->content_view, $view_data, true);
	}
	$view_data['yield'] = $yield;
	$render_output = $this->load->view("layout/" . $this->layout, $view_data, true);
	exit($render_output);
    }

}
