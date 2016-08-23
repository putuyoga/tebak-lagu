<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Beranda extends BASE_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('lagu_model');
	}
	
	public function index()
	{
		$data_view['total_user'] = $this->user_model->total_row();
		$data_view['total_lagu'] = $this->lagu_model->total_row();
		$konten = $this->load->view('frontend/beranda', $data_view, TRUE);
		$this->tampil($konten);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
