<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company extends CI_Controller 
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
	
	public function index($error = "")
	{
		if($this->pages_data_model->is_logged_in() && (strcmp($this->session->userdata('type'), 'ADMIN') == 0 || strcmp($this->session->userdata('type'), 'SUPER') == 0))
		{
			$values = $this->input->post(NULL, TRUE);
			
			$this->page_data['adminpage'] = "Company";
			$this->page_data["error"] = $error;
			$cid = $this->input->get('cid');
			
			if ($cid !== false) {
				$this->company_id = $cid;
				$this->session->set_userdata('cid',$cid);
			}
			
			if ($this->company_id == 0) {
				redirect('admin');
			}
			
			if (!$this->companies->verify_company_for_user($this->admin_id,$this->company_id)) {
				redirect('admin');
			}

			$company = $this->companies->get_by_id($this->company_id);

			$this->load->view('admin/header', $this->page_data);
			$this->load->view('admin/company/company_edit',array('company'=>$company[0]));
			$this->load->view('admin/footer');
		}
		else
		{
			redirect('error/must_sign_up_as_admin');
		}
	}
	
	public function add($error = "")
	{
		if($this->pages_data_model->is_logged_in() && (strcmp($this->session->userdata('type'), 'ADMIN') == 0 || strcmp($this->session->userdata('type'), 'SUPER') == 0))
		{
			$this->page_data['adminpage'] = "Company";
			$this->page_data["error"] = $error;

			$this->load->view('admin/header', $this->page_data);
			$this->load->view('admin/company/company_edit');
			$this->load->view('admin/footer');
		}
		else
		{
			redirect('error/must_sign_up_as_admin');
		}
	}
	
	public function save_company()
	{
		$formValues = $this->input->post(NULL, TRUE);
		if ($formValues['ID'] == 0) {
			$uid = $this->companies->add($formValues);
			redirect('admin');
		} else {
			$this->companies->put_by_id($formValues);		
			redirect('admin/company');
		}
	}
	
	public function save_picture()
	{
		$this->load->library('upload');
		
		$config['upload_path'] = UPLOAD_DIR;
		$config['allowed_types'] = 'jpg';
		$config['max_size']	= '300';
		$config['max_width']  = '2000';
		$config['max_height']  = '2000';
		$config['overwrite'] = true;
		$config['file_name'] = 'logo_'.$this->company_id.'.jpg';

		$this->upload->initialize($config);
 
		$uploaded = $this->upload->up(TRUE); //Pass true if you want to create the index.php files

		if (!empty($uploaded['error'])) {
			$this->index(empty($uploaded['error']) ? '' : trim($uploaded['error'][0]['error_msg']));
		} else {
			$config['image_library'] = 'gd2';
			$config['source_image'] = $this->upload->upload_path.$this->upload->file_name;
			$config['maintain_ratio'] = TRUE;
			$config['width'] = 250;
			$config['height'] = 125;
			$this->load->library('image_lib',$config); 
		
			if ( !$this->image_lib->resize()){
				$this->index($this->image_lib->display_errors('', ''));
			} else {
				redirect('admin/company');
			}
		}
	}
	
	public function script($error = "")
	{
		if($this->pages_data_model->is_logged_in() && (strcmp($this->session->userdata('type'), 'ADMIN') == 0 || strcmp($this->session->userdata('type'), 'SUPER') == 0))
		{
			$values = $this->input->post(NULL, TRUE);
			
			$this->page_data['adminpage'] = "Company";
			$this->page_data["error"] = $error;
			$cid = $this->input->get('cid');
			
			if ($cid !== false) {
				$this->company_id = $cid;
				$this->session->set_userdata('cid',$cid);
			}
			
			if ($this->company_id == 0) {
				redirect('admin');
			}
			
			if (!$this->companies->verify_company_for_user($this->admin_id,$this->company_id)) {
				redirect('admin');
			}

			$company = $this->companies->get_by_id($this->company_id);

			$this->load->view('admin/header', $this->page_data);
			$this->load->view('admin/company/script_edit',array('company'=>$company[0]));
			$this->load->view('admin/footer');
		}
		else
		{
			redirect('error/must_sign_up_as_admin');
		}
	}
	
	public function set_script()
	{
		$formValues = $this->input->post(NULL, TRUE);
		$data = array('ID'=>$formValues['pk'],$formValues['name']=>$formValues['value']);
		$this->companies->put_by_id($data);
	}
	
}