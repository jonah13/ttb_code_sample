<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error extends CI_Controller
{
	protected $page_data;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->page_data = array();
		$this->page_data['title'] = 'Tell The Boss - Error Page';
		$this->page_data['description'] = 'Tell The Boss Provides an Awesome Customer Feedback Service and Survey Options via Texts and QR Codes Right to Your Phone and to Your Account on Our Website!';
		$this->page_data['current'] = 'home';
	}
	
	public function index()
	{
		$this->load->view('general/header', $this->page_data);
		$this->load->view('general/slideshow');
		$this->load->view('general/page_not_found');
		$this->load->view('general/footer');
	}
	
	public function page_not_found()
	{
		$this->load->view('general/header', $this->page_data);
		$this->load->view('general/slideshow');
		$this->load->view('general/page_not_found');
		$this->load->view('general/footer');
	}
	
	public function something_went_wrong()
	{
		$this->load->view('general/header', $this->page_data);
		$this->load->view('general/slideshow');
		$this->load->view('general/page_not_found');
		$this->load->view('general/footer');
	}
	
	public function must_sign_up_as_admin()
	{
		$this->load->view('general/header', $this->page_data);
		$this->load->view('general/slideshow');
		$this->load->view('general/must_sign_up_as_admin_error');
		$this->load->view('general/footer');
	}
	
	public function must_sign_up()
	{
		$this->load->view('general/header', $this->page_data);
		$this->load->view('general/slideshow');
		$this->load->view('general/must_sign_up_error');
		$this->load->view('general/footer');
	}
}