<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller 
{
	
	public function index()
	{
		//redirect('http://www.rapparport.com/ttb');
		$page_data = array();
		$page_data['title'] = 'Welcome to Tell The Boss';
		$page_data['description'] = 'Tell The Boss is a Service Customer Feedback Company - We\'ll Help You Improve Your Business By Bringing What Your Customers Think From Their Cell Phones Right To Yours!';
		$page_data['current'] = 'home';
		
		$this->load->view('general/header', $page_data);
		$this->load->view('general/slideshow');
		$this->load->view('general/intro');
		$this->load->view('general/footer');
	}
}

