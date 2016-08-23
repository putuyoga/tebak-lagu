<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends BASE_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->helper('email');
	}
	
	public function index()
	{
		$this->set_judul('Register');
		$form = $this->load->view('frontend/user/register', '', TRUE);
		
		$this->tampil($form);
	}
	
	private function cek_input($data)
	{
		$array_error = array();
		
		//cek username
		if(trim($data['username']) === '')
		{
			$array_error[] = 'Username harus diisi';
		}
		elseif($this->user_model->exists($data['username']) === TRUE)
		{
			$array_error[] = 'Username sudah ada';
		}
		
		//cek email
		if(trim($data['email']) === '')
		{
			$array_error[] = 'Email harus diisi';
		}
		elseif(valid_email($data['email']) === FALSE)
		{
			$array_error[] = 'Email tidak valid';
		}
		elseif($this->user_model->exists($data['email'], 'email') === TRUE)
		{
			$array_error[] = 'Email sudah ada';
		}
		
		//cek password
		if(trim($data['password']) === '')
		{
			$array_error[] = 'Password harus diisi';
		}
		elseif($data['password'] !== $data['re_password'])
		{
			$array_error[] = 'Password yang diketikkan tidak sama';
		}
		
		if( ! empty($array_error))
		{
			return $array_error;
		}
		else
		{
			return TRUE;
		}
	}
	
	public function ajax()
	{
		$data_cek = $this->cek_input($this->input->post());
		
		//kalau udah bener
		if($data_cek === TRUE)
		{
			$data_baru = $this->input->post();
			$data_baru['auth'] = 1;
			//buat user baru
			$this->user_model->baru($data_baru);
			echo json_encode(array('sukses' => true));
		}
		else
		{
			//error
			echo json_encode(array('error' => $data_cek));
		}
	}
	
}


