<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sweepstakes_rules extends CI_Controller
{
	public function index()
	{
		$page_data = array();
		$page_data['title'] = 'Tell The Boss - Sweepstakes Rules, Terms &amp; Conditions';
		$page_data['description'] = 'Review Tell The Boss\'s Sweepstakes Rules, Terms, Conditions and Guidelines';
		$page_data['current'] = 'terms_privacy';
		
		$this->load->view('general/header', $page_data);
		$this->load->view('general/slideshow');
		$this->load->view('general/sweepstakes_rules');
		$this->load->view('general/footer');
	}
}