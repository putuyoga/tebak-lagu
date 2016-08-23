<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends BASE_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('lagu_model');
		$this->load->library('user');
		
		//kalau bukan admin, alihkan
		if($this->user->is_admin() !== TRUE)
		{
			redirect('user/login');
		}
	}
	
	public function index()
	{
		$tabel = $this->load->view('backend/main', '', TRUE);
		$this->tampil($tabel);
	}
}


