<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller 
{
	protected $page_data;
	protected $admin_id;
	protected $company_id;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('companies_model', 'companies');

		$this->load->model('pages_data_model');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		
		$this->page_data = array();
		$this->page_data['title'] = 'Tell The Boss - Admin Panel - Manage Company';

		$this->admin_id = $this->session->userdata('user_id');
		
		$this->company_id = $this->session->userdata('cid');
	}
	
	public function index()
	{
		$gets = $this->input->get(NULL,TRUE);
		if (!empty($gets['admin'])) {
			$this->session->set_userdata('type',$gets['admin']);	
		}
		
		if($this->pages_data_model->is_logged_in() && (strcmp($this->session->userdata('type'), 'ADMIN') == 0 || strcmp($this->session->userdata('type'), 'SUPER') == 0))
		{
			$this->page_data['adminpage'] = "None";

			$companies = $this->companies->get_companies_for_user($this->session->userdata('user_id'),strcmp($this->session->userdata('type'), 'SUPER') == 0);
			if (count($companies) == 1) {
				$this->company_id = $companies[0]['ID'];
				$this->session->set_userdata('cid',$companies[0]['ID']);
				redirect('admin/company');
			}
			$this->page_data["companies"] = $companies;

			$this->load->view('admin/header', $this->page_data);
			$this->load->view('admin/company/company_index',$this->page_data);
			$this->load->view('admin/footer');
		}
		else
		{
			redirect('dash');
		}
	}
	
	public function change_active() {
		$formValues = $this->input->post(NULL, TRUE);
		$company_id = $formValues['id'];
		$active = $this->companies->is_active($company_id);
		$this->companies->set_active($company_id,!$active);
		echo !$active ? '1' : '0';
	}
}