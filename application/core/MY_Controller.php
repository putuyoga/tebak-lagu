<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class BASE_Controller extends CI_Controller
{
	protected $judul;
	
	public function __construct()
	{
		parent::__construct();
	}
	
	protected function set_judul($judul)
	{
		$this->judul = $judul;
	}

	
	public function get_judul()
	{
		return $this->judul;
	}

    public function tampil($konten = '')
	{
		$this->load->library('user');
		$data_view['konten'] = $konten;
		$data_view['judul'] = $this->get_judul();
		$data_view['user'] = $this->user->get_current_user();
		$this->load->view('template', $data_view);
	}

}

class ADM_Controller extends BASE_Controller
{
	
	public function __construct($halaman = '')
	{
		parent::__construct($halaman);
		//hanya admin yang bisa akses controller ADM
		$member = $this->get_current_member();
		if($member['level'] < 255)
		{
			redirect('member/login');
		}
	}
	
	public function get_judul()
	{
		$out = 'Administrator &raquo; ' . ucwords($this->halaman);
		if($this->judul != NULL)
		{
			$out .= ' &raquo; ' . ucwords($this->judul);
		}
		
		return $out;
	}
	
	private function get_menu_view()
	{
		return $this->load->view('backend/menu_admin', array('active' => $this->halaman), TRUE);
	}
	
    public function tampil($konten = '')
	{
		$data_view['konten'] = $konten;
		$data_view['judul'] = $this->get_judul();
		$data_view['sidebar_member'] = $this->get_sidebar_member_view();
		$data_view['sidebar_halaman'] = $this->get_sidebar_halaman_view();
		$data_view['sidebar_kategori'] = $this->get_sidebar_kategori_view();
		$data_view['menu'] = $this->get_menu_view();
		
		if($this->feedback !== '' || $this->exist_flash_feedback() === TRUE)
		{
			$data_view['feedback'] = $this->get_feedback_view();
		}
		$this->load->view('template', $data_view);
	}
}