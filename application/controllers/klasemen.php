<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Klasemen extends BASE_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->library('user');
		
		$this->load->model('lagu_model');
		$this->load->model('tebak_model');
		$this->load->model('skor_model');
	}
	
	public function index()
	{
		$user = $this->user->get_current_user();
		//ambil data 5 paling besar nilainya
		$data_view['rows'] = $this->skor_model->get_top_5();
		//jika user sudah login
		if($user !== NULL)
		{
			$data_view['current_user'] = $this->skor_model->get_by_iduser($user['id']);
		}
		else
		{
			$data_view['current_user']['id'] = NULL;
		}
		$tabel = $this->load->view('frontend/klasemen', $data_view, TRUE);
		$this->tampil($tabel);
	}
}