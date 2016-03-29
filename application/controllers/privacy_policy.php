<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Privacy_policy extends CI_Controller
{
	
	public function index()
	{
		$page_data = array();
		$page_data['title'] = 'Tell The Boss - Privacy Policy';
		$page_data['description'] = 'We Value Your Customers and Your Privacy, Review Our Privacy Policy Here';
		$page_data['current'] = 'terms_privacy';
		
		$this->load->view('general/header', $page_data);
		$this->load->view('general/slideshow');
		$this->load->view('general/privacy_policy');
		$this->load->view('general/footer');
	}

	
}