<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends BASE_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->library('user');
	}
	
	public function index()
	{
		$this->set_judul('Login');
		$form = $this->load->view('frontend/user/login', '', TRUE);
		
		$this->tampil($form);
	}
	
	public function ajax()
	{
		$data = $this->input->post();
		$cek_login = $this->user_model->is_user($data['username'], $data['password']);
		
		//kalau udah bener
		if($cek_login !== FALSE)
		{
			$this->user->set_current_user($cek_login);
			echo json_encode(array('sukses' => true));
		}
		else
		{
			echo json_encode(array('error' => 'Username/password salah.'));
		}
	}
	
}


