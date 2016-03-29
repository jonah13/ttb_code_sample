<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Services extends CI_Controller
{
	
	public function index()
	{
		$page_data = array();
		$page_data['title'] = ' Discover Tell The Boss\'s Revolutionary Customer Feedback Services';
		$page_data['description'] = 'Tell The Boss Provides an Awesome Customer Feedback Service and Survey Options via Texts and QR Codes Right to Your Phone and to Your Account on Our Website!';
		$page_data['current'] = 'services';
		
		$this->load->view('general/header', $page_data);
		$this->load->view('general/slideshow');
		$this->load->view('general/services');
		$this->load->view('general/footer');
	}

	
}