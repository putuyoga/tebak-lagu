<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {
	private $table;
	
	public function __construct()
	{
		parent::__construct();
		$this->set_table('user');
	}
	
	public function set_table($table)
	{
		$this->table = $table;
	}
	
	public function get_table()
	{
		return $this->table;
	}
	
	public function exists($compare, $field = 'username')
	{
		$field_array = array('id', 'username', 'email', 'auth');
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
	
	public function is_user($username, $password)
	{
		$this->db->where('username', $username);
		$this->db->where('password', md5($password));
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
	
	public function baru(array $data_user)
	{
		
		$data = array(
			'username' => $data_user['username'],
			'email' => $data_user['email'],
			'joinDate' => date('Y-m-d H:i:s'),
			'auth' => $data_user['auth'],
		);
		if(trim($data_user['password']) != '')
		{
			$data['password'] = md5($data_user['password']);
		}
		$this->db->insert($this->get_table(), $data);
	}
	
	public function edit($data_user)
	{
		$data = array(
			'username' => $data_user['username'],
			'email' => $data_user['email'],
			//'password' => $data_user['password'],
			'auth' => $data_user['auth'],
		);
		$this->db->where('id', $data_user['id']);
		$this->db->update($this->get_table(), $data);
	}
	
	public function edit_profil($id, $email, $password = '')
	{
		$data = array(
			'email'	=> $email
		);
		if(trim($password) !== '')
		{
			$data['password'] = md5($password);
		}
		$this->db->where('id', $id);
		$this->db->update($this->get_table(), $data);
	}
	
	public function update_password($id, $password)
	{
		$data = array(
			'password' => md5($password)
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
}