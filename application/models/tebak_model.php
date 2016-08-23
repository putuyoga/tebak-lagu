<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tebak_model extends CI_Model {
	private $table;
	
	public function __construct()
	{
		parent::__construct();
		$this->set_table('tebak');
	}
	
	public function set_table($tab)
	{
		$this->table = $tab;
	}
	
	public function get_table()
	{
		return $this->table;
	}
	
	public function exists($compare, $field = 'id_user')
	{
		$field_array = array('id_user');
		if( ! in_array($field, $field_array))
		{
			die('Field tidak diketahui');
			return;
		}
		
		$this->db->where($field, $compare);
		$query = $this->db->get($this->get_table(), 1);
		
		if($query->num_rows() === 1)
		{
			return $query->row_array();
		}
		else
		{
			return FALSE;
		}
	}
	
	public function get_by_id($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get($this->get_table(), 1);
		if($query->num_rows() === 1)
		{
			return $query->row_array();
		}
		else
		{
			return FALSE;
		}
	}
	
	public function get_all_at($page, $banyak)
	{
		$awal = ($page - 1) * $banyak;
		$this->db->select('lagu.id, lagu.judul, id_artist, artist.nama');
		$this->db->join('artist', 'lagu.id_artist = artist.id', 'left');
		$this->db->order_by('id DESC');
		$query = $this->db->get($this->get_table(), $banyak, $awal);
		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		else
		{
			return NULL;
		}
	}
	
	public function total_row()
	{
		$query = $this->db->get($this->get_table());
		return $query->num_rows();
	}
	
	public function baru($data_main)
	{
		$data = array(
			'mulai_tebak' => $data_main['mulai_tebak'],
			'terakhir_benar' => $data_main['terakhir_benar'],
			'urutan_lagu' => $data_main['urutan_lagu'],
			'id_user' => $data_main['id_user'],
			'skor' => $data_main['skor']
		);
		$this->db->insert($this->get_table(), $data);
	}
	
	public function update($data_main)
	{
		
		$data = array(
			'mulai_tebak' => $data_main['mulai_tebak'],
			'terakhir_benar' => $data_main['terakhir_benar'],
			'urutan_lagu' => $data_main['urutan_lagu'],
			'skor' => $data_main['skor']
		);
		$this->db->where('id_user', $data_main['id_user']);
		$this->db->update($this->get_table(), $data);
	}
	
	public function update_urutan($id_user, $urutan_lagu, $skor = '', $update_terakhir = FALSE)
	{
		$data = array(
			'urutan_lagu' => $urutan_lagu
		);
		if($update_terakhir === TRUE)
		{
			$data['terakhir_benar'] = date('Y-m-d H:i:s');
		}
		if(trim($skor) !== '')
		{
			$data['skor'] = $skor;
		}
		$this->db->where('id_user', $id_user);
		$this->db->update($this->get_table(), $data);
	}
	
	public function del_by_iduser($iduser)
	{
		$this->db->where('id_user', $iduser);
		$this->db->delete($this->get_table());
	}
	
	public function del_all()
	{
		$this->db->empty_table($this->get_table());
	}
}
