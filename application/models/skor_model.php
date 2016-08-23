<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Skor_model extends CI_Model {
	private $table;
	
	public function __construct()
	{
		parent::__construct();
		$this->set_table('skor');
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
	
	public function get_all_at($page, $banyak)
	{
		$awal = ($page - 1) * $banyak;
		$this->db->join('user', 'skor.id_user = user.id');
		$this->db->order_by('nilai DESC');
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
	
	public function get_top_5()
	{
		$this->db->join('user', 'user.id = skor.id_user');
		$this->db->order_by('nilai DESC');
		$query = $this->db->get($this->get_table(), 5);
		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		else
		{
			return FALSE;
		}
	}
	
	public function get_by_iduser($id_user)
	{
		$this->db->join('user', 'user.id = skor.id_user');
		$this->db->where('id_user', $id_user);
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
	
	public function baru($id_user, $skor)
	{
		$data = array(
			'id_user' => $id_user,
			'tanggal' => date('Y-m-d H:i:s'),
			'nilai' => $skor
		);
		$this->db->insert($this->get_table(), $data);
	}
	
	public function edit($id, $judul, $artist)
	{
		$data = array(
			'judul' => $judul,
			'id_artist' => $artist
		);
		$this->db->where('id', $id);
		$this->db->update($this->get_table(), $data);
	}
	
	public function total_row()
	{
		$query = $this->db->get($this->get_table());
		return $query->num_rows();
	}
	
	public function update($id_user, $skor)
	{
		$data = array(
			'tanggal' => date('Y-m-d H:i:s'),
			'nilai' => $skor
		);
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
