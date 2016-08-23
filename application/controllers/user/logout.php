<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends BASE_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->library('user');
	}
	
	public function index()
	{
		$this->user->clear_current_user();
		redirect('/');
	}
	
}


