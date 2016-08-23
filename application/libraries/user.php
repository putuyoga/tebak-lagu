<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User
{
	private $CI;
	private $current_user;
	
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->model('user_model');
		$this->load_current_user();
	}
	
	/**---------------------------------------
		Mengembalikan user yg berkunjung
	-----------------------------------------**/
	public function get_current_user()
	{
		return $this->current_user;
	}
	
	/**---------------------------------------
		Cek apakah si user sudah login ?
		kalau sudah set user sekarang
	-----------------------------------------**/
	public function load_current_user()
	{
		$userid = $this->CI->session->userdata('userid');
		if($userid)
		{
			$userdata = $this->CI->user_model->get_by_id($userid);
			if($userdata !== NULL)
			{
				$this->set_current_user($userdata);
			}
		}
	}
	
	/**---------------------------------------
		Apakah user yg berkunjung admin ?
	-----------------------------------------**/
	public function is_admin()
	{
		$user = $this->get_current_user();
		if($user !== NULL)
		{
			if($user['auth'] == 255)
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
			
		}
		else
		{
			return FALSE;
		}
	}
	
	/**---------------------------------------
		Set user yang sedang berkunjung,
		guest/member/admin?
	-----------------------------------------**/
	public function set_current_user($userdata)
	{
		$this->CI->session->set_userdata('userid', $userdata['id']);
		$this->current_user = $userdata;
	}
	
	public function clear_current_user()
	{
		$this->CI->session->unset_userdata('userid');
		$this->current_user = NULL;
	}
	
}