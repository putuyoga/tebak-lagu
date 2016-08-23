<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends BASE_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->library('user');
		
		//kalau bukan admin, alihkan
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
			echo "Halaman invalid (La_ts_0x)";
		}
		else
		{
			$data_list['page_num'] = $page;
			$data_list['rows'] = $this->user_model->get_all_at($page, $banyak);
			$data_list['total_hal'] = ceil($this->user_model->total_row() / $banyak);
			$this->load->view('backend/user/list', $data_list);
		}
	}
	
	/**---------------------------------------
		Form untuk edit user
	-----------------------------------------**/
	public function edit($id = '')
	{
		$this->load->helper('form');
		$this->load->helper('auth');
		if( ! is_numeric($id))
		{
			echo "User yang dimaksud tidak ada.";
		}
		else
		{
			$data_edit = $this->user_model->get_by_id($id);
			if($data_edit !== FALSE)
			{
				$this->load->view('backend/user/edit', $data_edit);
			}
			else
			{
				echo "User yang dimaksud tidak ada";
			}
		}
	}
	
	/**---------------------------------------
		Form untuk hapus user
	-----------------------------------------**/
	public function hapus($id = '')
	{
		
		if( ! is_numeric($id))
		{
			echo json_encode(array('error' => 'id tidah sah'));
		}
		else
		{
			$this->user_model->del_by_id($id);
			$this->load->model('tebak_model');
			$this->load->model('skor_model');
			//hapus juga skornya + permainannya
			$this->tebak_model->del_by_iduser($id);
			$this->skor_model->del_by_iduser($id);
			echo json_encode(array('sukses' => true));
		}
	}
	
	/**---------------------------------------
		Form untuk hapus semua user
	-----------------------------------------**/
	public function hapus_semua()
	{
		$this->user_model->del_all();
		$this->load->model('tebak_model');
		$this->load->model('skor_model');
		//kosongkan juga skornya
		$this->skor_model->del_all();
		$this->tebak_model->del_all();
		echo json_encode(array('sukses' => true));
	}
	
	/**---------------------------------------
		Proses 'POST' edit user
	-----------------------------------------**/
	public function edit_ajax()
	{
		$data_cek = $this->cek_input_edit($this->input->post());
		if($data_cek === TRUE)
		{
			$data_user = $this->input->post();
			$this->user_model->edit($data_user);
			echo json_encode(array('sukses' => TRUE));
		}
		else
		{
			echo json_encode(array('error' => $data_cek));
		}
	}
	
	/**---------------------------------------
		Digunakan untuk cek input form tambah
	-----------------------------------------**/
	private function cek_input_tambah($data)
	{
		$array_error = array();
		
		//cek judul
		if(trim($data['judul']) === '')
		{
			$array_error[] = 'Judul tidak boleh kosong';
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
	
	/**---------------------------------------
		Digunakan untuk cek input form edit
	-----------------------------------------**/
	private function cek_input_edit($data)
	{
		$array_error = array();
		
		//cek judul
		if(trim($data['username']) === '')
		{
			$array_error[] = 'Username tidak boleh kosong';
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
	
	/**---------------------------------------
		Digunakan untuk handle request untuk
		reset password user
	-----------------------------------------**/
	public function reset_password($id = '')
	{
		if(is_numeric($id))
		{
			$user  = $this->user_model->get_by_id($id);
			if($user !== FALSE)
			{
				$random_password = substr(md5(microtime()),rand(0,26),5);
				$this->user_model->update_password($id, $random_password);
				echo json_encode(array('sukses' => true, 'password_baru' => $random_password));
			}
			else
			{
				echo json_encode(array('error' => 'Tidak ada user yang dimaksud'));
			}
		}
		else
		{
			echo json_encode(array('error' => 'Tidak ada input'));
		}
	}
}


