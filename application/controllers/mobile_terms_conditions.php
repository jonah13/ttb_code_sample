<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mobile_terms_conditions extends CI_Controller
{
	public function index()
	{
		$page_data = array();
		$page_data['title'] = 'Tell The Boss - Mobile Terms &amp; Conditions';
		$page_data['description'] = 'Review Tell The Boss\'s Mobile Terms, Conditions and Guidelines';
		$page_data['current'] = 'terms_privacy';
		
		$this->load->view('general/header', $page_data);
		$this->load->view('general/slideshow');
		$this->load->view('general/mobile_terms_conditions');
		$this->load->view('general/footer');
	}
}