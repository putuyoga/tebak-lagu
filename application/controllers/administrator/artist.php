<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Artist extends BASE_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('artist_model');
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
		Digunakan untuk menampilkan tabel listing
	-----------------------------------------**/
	public function lists($page = 1, $banyak = 10)
	{
		//sleep(1); //simulasi pas internet lemot
		if(( ! is_numeric($page)) && ( ! is_numeric($banyak)))
		{
			echo "Halaman invalid (Ar_ts_0x)";
		}
		else
		{
			$data_list['page_num'] = $page;
			$data_list['rows'] = $this->artist_model->get_all_at($page, $banyak);
			$data_list['total_hal'] = ceil($this->artist_model->total_row() / $banyak);
			$this->load->view('backend/artist/list', $data_list);
		}
	}
	
	/**---------------------------------------
		Menampilkan form tambah
	-----------------------------------------**/
	public function tambah()
	{
		//sleep(1); //simulasi pas internet lemot
		$this->load->view('backend/artist/tambah');
	}
	
	/**---------------------------------------
		Digunakan form edit
	-----------------------------------------**/
	public function edit($id = '')
	{
		//kalau id bukan numeric
		if( ! is_numeric($id))
		{
			echo "Artist yang dimaksud tidak ada.";
		}
		else
		{
			//ambil data artist dari idnya
			$data_edit = $this->artist_model->get_by_id($id);
			if($data_edit !== FALSE)
			{
				$this->load->view('backend/artist/edit', $data_edit);
			}
			else
			{
				echo "Artist yang dimaksud tidak ada";
			}
		}
	}
	
	/**---------------------------------------
		DIgunakan untuk hapus user
	-----------------------------------------**/
	public function hapus($id = '')
	{
		
		if( ! is_numeric($id))
		{
			echo json_encode(array('error' => 'id tidah sah'));
		}
		else
		{
			$this->artist_model->del_by_id($id);
			$this->load->helper('file');
			echo json_encode(array('sukses' => true));
		}
	}
	
	/**---------------------------------------
		Digunakan untuk hapus semua user
	-----------------------------------------**/
	public function hapus_semua()
	{
		$this->artist_model->del_all();
		echo json_encode(array('sukses' => true));
	}
	
	/**---------------------------------------
		proses 'POST' untuk tambah user
	-----------------------------------------**/
	public function tambah_ajax()
	{
		$data_cek = $this->cek_input_tambah($this->input->post());
		if($data_cek === TRUE)
		{
			extract($this->input->post());
			$this->artist_model->baru($nama);
			echo json_encode(array('sukses' => true));
		}
		else
		{
			echo json_encode(array('error' => $data_cek));
		}
		
	}
	
	/**---------------------------------------
		proses 'POST' untuk edit user
	-----------------------------------------**/
	public function edit_ajax()
	{
		$data_cek = $this->cek_input_edit($this->input->post());
		if($data_cek === TRUE)
		{
			extract($this->input->post());
			$this->artist_model->edit($id, $nama);
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
		
		//cek nama
		if(trim($data['nama']) === '')
		{
			$array_error[] = 'Nama artist tidak boleh kosong';
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
		
		//cek nama
		if(trim($data['nama']) === '')
		{
			$array_error[] = 'Nama artist tidak boleh kosong';
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
	
}


