<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lagu extends BASE_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('lagu_model');
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
		Digunakan untuk menampilkan tabel listing
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
			$data_list['rows'] = $this->lagu_model->get_all_at($page, $banyak);
			$data_list['total_hal'] = ceil($this->lagu_model->total_row() / $banyak);
			$this->load->view('backend/lagu/list', $data_list);
		}
	}
	
	/**---------------------------------------
		Mengembalikan form untuk tambah user
	-----------------------------------------**/
	public function tambah()
	{
		//sleep(1); //simulasi pas internet lemot
		$data_tambah['dropdown'] = $this->buat_dropdown_artist();
		$this->load->view('backend/lagu/tambah', $data_tambah);
	}
	
	/**---------------------------------------
		Mengembalikan form untuk edit user
	-----------------------------------------**/
	public function edit($id = '')
	{
		if( ! is_numeric($id))
		{
			echo "Lagu yang dimaksud tidak ada.";
		}
		else
		{
			$data_edit = $this->lagu_model->get_by_id($id);
			$data_edit['dropdown'] = $this->buat_dropdown_artist($data_edit['id_artist']);
			if($data_edit !== FALSE)
			{
				$this->load->view('backend/lagu/edit', $data_edit);
			}
			else
			{
				echo "Lagu yang dimaksud tidak ada";
			}
		}
	}
	
	/**---------------------------------------
		Digunakan untuk menghapus lagu dan filenya
	-----------------------------------------**/
	public function hapus($id = '')
	{
		if( ! is_numeric($id))
		{
			echo json_encode(array('error' => 'id tidah sah'));
		}
		else
		{
			$this->lagu_model->del_by_id($id);
			$this->load->helper('file');
			unlink('lagu/'. $id .'.ogg');
			echo json_encode(array('sukses' => true));
		}
	}
	
	/**---------------------------------------
		Digunakan untuk hapus semua lagu dan filenya
	-----------------------------------------**/
	public function hapus_semua()
	{
		$this->lagu_model->del_all();
		echo json_encode(array('sukses' => true));
		
		//hapus semua file lagu
		$dir = 'lagu/';
		if(!$dh = @opendir($dir)) return;
		while (false !== ($obj = readdir($dh)))
		{
			if($obj=='.' || $obj=='..') continue;
			@unlink($dir.'/'.$obj);
		}
		closedir($dh);
	}
	
	/**---------------------------------------
		Proses 'POST' tambah lagu
	-----------------------------------------**/
	public function tambah_ajax()
	{
		$data_cek = $this->cek_input_tambah($this->input->post());
		if($data_cek === TRUE)
		{
			extract($this->input->post());
			$this->lagu_model->baru($judul, $id_artist);
			echo json_encode(array('sukses' => true));
		}
		else
		{
			echo json_encode(array('error' => $data_cek));
		}
		
	}
	
	/**---------------------------------------
		Proses 'POST' edit lagu
	-----------------------------------------**/
	public function edit_ajax()
	{
		$data_cek = $this->cek_input_edit($this->input->post());
		if($data_cek === TRUE)
		{
			extract($this->input->post());
			$this->lagu_model->edit($id, $judul, $id_artist);
			echo json_encode(array('sukses' => TRUE));
		}
		else
		{
			echo json_encode(array('error' => $data_cek));
		}
	}
	
	/**---------------------------------------
		Mengembalikan HTML dari dropdown artist
	-----------------------------------------**/
	private function buat_dropdown_artist($selected = '')
	{
		$this->load->model('artist_model');
		$this->load->helper('form');
		$data_artist = $this->artist_model->get_all();
		$array_artist = array();
		if($data_artist !== NULL)
		{
			foreach($data_artist as $data)
			{
				$array_artist[$data['id']] = $data['nama'];
			}
		}
		$array_artist[0] = 'Unknown';
		$info = 'id="search"';
		return form_dropdown('id_artist', $array_artist, $selected, $info);
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
		Untuk handle upload file lagu
	-----------------------------------------**/
	public function upload($id = '')
	{
		$config['upload_path'] = './lagu/';
		$config['allowed_types'] = 'ogg|ogg';
		$config['file_name'] = $id . '.ogg';
		$config['overwrite'] = TRUE;
		
		$this->load->library('upload', $config);
		
		if (!$this->upload->do_upload('lagu'))
		{
			$status = 'error';
			$msg = $this->upload->display_errors('', '');
		}
		else
		{
			$status = 'sukses';
			$msg = TRUE;
		}
		echo json_encode(array($status => $msg));
	}
	
}


