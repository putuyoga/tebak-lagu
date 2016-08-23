<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lagu_model extends CI_Model {
	private $table;
	
	public function __construct()
	{
		parent::__construct();
		$this->set_table('lagu');
	}
	
	public function set_table($tab)
	{
		$this->table = $tab;
	}
	
	public function get_table()
	{
		return $this->table;
	}
	
	public function exists($compare, $field = 'judul')
	{
		$field_array = array('id', 'judul');
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
	
	public function baru($judul, $artist)
	{
		$data = array(
			'judul' => $judul,
			'id_artist' => $artist
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
	
	public function del_by_id($id)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->get_table());
	}
	
	public function del_all()
	{
		$this->db->empty_table($this->get_table());
	}
	
	public function random_seq()
	{
		$this->db->select('id');
		$query = $this->db->get($this->get_table());
		if($query->num_rows() > 0)
		{
			$array_baru = array();
			foreach($query->result_array() as $row)
			{
				$array_baru[] = $row['id'];
			}
			shuffle($array_baru);
			return implode($array_baru, '-');
		}
		else
		{
			return FALSE;
		}
	}
}