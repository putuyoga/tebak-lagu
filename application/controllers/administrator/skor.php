<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Skor extends BASE_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('skor_model');
		$this->load->library('user');
		
		//kalau bukan admin alihkan
		if($this->user->is_admin() !== TRUE)
		{
			redirect('user/login');
		}
	}
	
	public function index()
	{
		redirect('administrator/main');
	}
	
	/**---------------------------------------
		Menampilkan table listing
	-----------------------------------------**/
	public function lists($page = 1, $banyak = 10)
	{
		//sleep(1); //simulasi pas internet lemot
		if(( ! is_numeric($page)) && ( ! is_numeric($banyak)))
		{
			echo "Halaman invalid (Sk_ts_0x)";
		}
		else
		{
			$data_list['page_num'] = $page;
			$data_list['rows'] = $this->skor_model->get_all_at($page, $banyak);
			$data_list['total_hal'] = ceil($this->skor_model->total_row() / $banyak);
			$this->load->view('backend/skor/list', $data_list);
		}
	}
	
	/**---------------------------------------
		Digunakan untuk handle hapus user
	-----------------------------------------**/
	public function hapus($id = '')
	{
		
		if( ! is_numeric($id))
		{
			echo json_encode(array('error' => 'id tidah sah'));
		}
		else
		{
			$this->skor_model->del_by_iduser($id);
			$this->load->helper('file');
			echo json_encode(array('sukses' => true));
		}
	}
	
	/**---------------------------------------
		Digunakan untuk handle hapus semua
	-----------------------------------------**/
	public function hapus_semua()
	{
		$this->skor_model->del_all();
		echo json_encode(array('sukses' => true));
	}
}


