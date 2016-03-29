<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rate_feedback extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->library('form_validation');
		$this->load->helper('feedback');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
	}
	
	public function index()
	{
		$this->load->view('general/header');
		$this->load->view('feedback/enter_comment');
		$this->load->view('general/footer');		
	}
	
	public function submit()
	{
		$this->form_validation->set_rules('feedback', 'feedback', 'trim|min_length[2]|max_length[1000]|encode_php_tags|xss_clean');
		if($this->form_validation->run())
		{
			$data['comment'] = $this->input->post('feedback');
			$this->load->view('general/header', $data);
			$this->load->view('feedback/display_result');
			$this->load->view('general/footer');		
		}
		else
		{
			$this->load->view('feedback/enter_comment');
		}
	}
	
}
	
	