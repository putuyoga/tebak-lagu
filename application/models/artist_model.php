<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Artist_model extends CI_Model {
	private $table;
	
	public function __construct()
	{
		parent::__construct();
		$this->set_table('artist');
	}
	
	public function set_table($tab)
	{
		$this->table = $tab;
	}
	
	public function get_table()
	{
		return $this->table;
	}
	
	public function exists($compare, $field = 'nama')
	{
		$field_array = array('id', 'nama');
		if( ! in_array($field, $field_array))
		{
			die('Field tidak diketahui');
			return;
		}
		
		$this->db->where($field, $compare);
		$query = $this->db->get($this->get_table(), 1);
		
		if($query->num_rows() === 1)
		{
			return TRUE;
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
		//$this->db->select('lagu.id, lagu.judul, id_artist, artist.nama');
		//$this->db->join('artist', 'lagu.id_artist = artist.id', 'left');
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
	
	public function get_all()
	{
		$this->db->order_by('id DESC');
		$query = $this->db->get($this->get_table());
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
	
	public function baru($nama)
	{
		$data = array(
			'nama' => $nama
		);
		
		$this->db->insert($this->get_table(), $data);
	}
	
	public function edit($id, $nama)
	{
		$data = array(
			'nama' => $nama
		);
		$this->db->where('id', $id);
		$this->db->update($this->get_table(), $data);
	}
	
	public function del_by_id($id)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->get_table());
		
		//untuk lagu
		$data = array(
			'id_artist' => 0
		);
		$this->db->where('id_artist', $id);
		$this->db->update('lagu', $data);
	}
	
	public function del_all()
	{
		$this->db->empty_table($this->get_table());
		//untuk lagu
		$data = array(
			'id_artist' => 0
		);
		$this->db->update('lagu', $data);
	}
}