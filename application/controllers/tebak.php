<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tebak extends BASE_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->library('user');
		//kalau belum login, suruh login dulu
		if($this->user->get_current_user() === NULL)
		{
			redirect('user/login');
		}
		
		$this->load->model('lagu_model');
		$this->load->model('tebak_model');
		$this->load->model('skor_model');
	}
	
	public function index()
	{
		$tabel = $this->load->view('frontend/tebak', '', TRUE);
		$this->tampil($tabel);
	}
	
	/**---------------------------------------
		Mengembalikan form input tebakan
	-----------------------------------------**/
	public function input()
	{
		$this->load->view('frontend/form_tebak');
	}
	
	/**---------------------------------------
		Digunakan untuk handle resource ketika awal permainan
	-----------------------------------------**/
	public function mulai_ajax()
	{
		//ambil info si user
		$user = $this->user->get_current_user();
		
		//cek apakah si user lagi main dari DB
		$lagi_main = $this->tebak_model->exists($user['id'], 'id_user');
		
		//data2 yang akan dimasukkan ke db
		$data_main = array(
				'mulai_tebak' => date('Y-m-d H:i:s'),
				'terakhir_benar' => date('Y-m-d H:i:s'),
				'urutan_lagu' => $this->lagu_model->random_seq(),
				'id_user' => $user['id'],
				'skor' => 0
		);
		
		//kalau lagi ga main
		if($lagi_main === FALSE)
		{
			//insert ke database
			$this->tebak_model->baru($data_main);
			echo json_encode(array('lagi_main' => false));
		}
		else
		{
			//update database
			$this->tebak_model->update($data_main);
			echo json_encode(array('lagi_main' => true));
		}
	}
	
	/**---------------------------------------
		Digunakan untuk menghandle permainan yg selesai
	-----------------------------------------**/
	public function selesai_ajax()
	{
		//ambil info si user
		$user = $this->user->get_current_user();
		
		//ambil info permainan
		$data_main = $this->tebak_model->exists($user['id'], 'id_user');
		
		//kalau si user lagi main
		if($data_main !== FALSE)
		{
			//ambil skor si user
			$skor = $this->skor_model->get_by_iduser($user['id']);
			
			//kalau belum ada skor si user di DB
			if($skor == FALSE)
			{
				//insert new score
				$this->skor_model->baru($user['id'], $data_main['skor']);
				$data_skor = array('new_highscore' => true, 'skor_sebelum' => 0, 'skor_setelah' => $data_main['skor']);
			}
			else
			{
				//bandingkan score
				if($skor['nilai'] < $data_main['skor'])
				{
					//update
					$this->skor_model->update($user['id'], $data_main['skor']);
					$data_skor = array('new_highscore' => true, 'skor_sebelum' => $skor['nilai'], 'skor_setelah' => $data_main['skor']);
				}
				else
				{
					//biarkan saja :P
					$data_skor = array('new_highscore' => false, 'skor_sebelum' => $skor['nilai'], 'skor_setelah' => $data_main['skor']);
				}
			}
			
			//kalau urutan lagunya dah habis, berarti tamat :))
			if(trim($data_main['urutan_lagu']) === '')
			{
				$data_skor['tamat'] = TRUE;
			}
			else
			{
				$data_skor['tamat'] = FALSE;
			}
			
			//data buat dikirim ke view
			$data_skor['username'] = $user['username'];
			
			//hapus dah permainan si user dari db
			$this->tebak_model->del_by_iduser($user['id']);
			
			//tampilin view
			$this->load->view('frontend/hasil', $data_skor);
		}
		else
		{
			//tampilin pesan error
			echo $user['username'] . 'tidak lagi main.';
		}
	}
	
	/**---------------------------------------
		Digunakan untuk mengecek apakah waktu sudah habis
	-----------------------------------------**/
	private function is_waktu_habis($terakhir_nebak)
	{
		$datetime1 = date_create($terakhir_nebak);
		$datetime2 = date_create(date('Y-m-d H:i:s'));
		$interval = date_diff($datetime1, $datetime2);
		$sekon = $interval->format('%s');
		/*
			harusnya 30, 
			tapi ada delay ketika transfer data
			buat jaga2, sekitar 5 detik
		*/
		
		if($sekon < 35) 
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	/**---------------------------------------
		Digunakan untuk mencocokan input tebakan
	-----------------------------------------**/
	public function nebak_ajax()
	{
		//ambil data tebakan
		$tebakan = $this->input->post('tebakan');
		
		//kalau ada 'POST'
		if($tebakan)
		{
			//ambil info si user sama permainannya
			$user = $this->user->get_current_user();
			$tebak = $this->tebak_model->exists($user['id']);
			
			//kalau user lagi main
			if($tebak !== FALSE)
			{
				//cek apakah waktu habis ?
				if($this->is_waktu_habis($tebak['terakhir_benar']) === TRUE)
				{
					echo json_encode(array('waktu_habis' => true));
					exit;
				}
				
				//urutan lagunya dipecah jadi array
				$sekuens = explode('-', $tebak['urutan_lagu']);
				
				//ambil info lagu yang sedang ditebak
				$lagu = $this->lagu_model->get_by_id($sekuens[0]);
				
				//kalau tebakan bener
				if(strtolower($lagu['judul']) == strtolower($tebakan))
				{
					//hapus id lagu dari urutan lagu yg sedang ditebak
					unset($sekuens[0]);
					
					//kalau urutan lagu udah kosong
					if(count($sekuens) == 0)
					{
						//menang (alias tamat)
						$urutan_lagu = implode($sekuens, '-');
						$this->tebak_model->update_urutan($user['id'],  $urutan_lagu, ($tebak['skor'] + 10));
						echo json_encode(array('selesai' => true));
					}
					else
					{
						//bener & masih lanjut
						$urutan_lagu = implode($sekuens, '-');
						$this->tebak_model->update_urutan($user['id'], $urutan_lagu, ($tebak['skor'] + 10), TRUE);
						echo json_encode(array('benar' => true));
					}
				}
				else
				{
					//salah
					echo json_encode(array('benar' => false));
				}
			}
			else
			{
				//error
				echo json_encode(array('error' => 'tidak ada lagu yang lagi ditebak oleh ' . $user['username']));
			}
		}
		else
		{
			//error
			echo json_encode(array('error' => 'tidak ada input'));
		}
	}
	
	/**---------------------------------------
		Digunakan untuk mengambil konten lagu
	-----------------------------------------**/
	public function lagu()
	{
		$empty_file = FALSE;
		
		//ambil info si user & info permainan
		$user = $this->user->get_current_user();
		$tebak = $this->tebak_model->exists($user['id'], 'id_user');
		
		//kalau si user lagi ga main, jangan lanjutin.
		if($tebak == false)
		{
			exit;
		}		
		
		//pecah urutan lagu jadi array
		$urutan_lagu = explode('-', $tebak['urutan_lagu']);
		$index = 0;
		
		while(1)
		{
			//kalau lagunya ga kosong
			if(count($urutan_lagu) > 0)
			{
				//lokasi file lagu
				$filename = "lagu/". $urutan_lagu[$index] .".ogg";
				
				//Kalau filenya ada
				if(file_exists($filename))
				{	
					//pasang header
					header('Content-Length: '.filesize($filename));
					header('Content-Type: audio/ogg');
					header('Content-Disposition: inline; filename="'. md5(date('d-m-y-H-i-s')) .'.ogg";');
					header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
					header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
					header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
					header("Cache-Control: post-check=0, pre-check=0", false);
					header("Pragma: no-cache");
					readfile($filename);
					die();
					exit;
				}
				else
				{
					//skip file
					$empty_file = TRUE;
					unset($urutan_lagu[$index]);
					$index++;
				}
			}
			else
			{
				break;
			}
		}
		
		//kalau ditemukan yang belum ada lagunya, update urutan lagu
		//buang yang ga ada file lagunya
		if($empty_file == TRUE)
		{
			$this->tebak_model->update_urutan($user['id'], implode($urutan_lagu, '-'));
		}

	}
}