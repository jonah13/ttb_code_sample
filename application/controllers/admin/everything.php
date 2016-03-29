<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// to do:
// 1) need to do security check to make sure saves are permissioned
// 2) update org groups by nestable output

require_once(dirname(__FILE__).'/../libraries/qrlib.php');

class Admin extends CI_Controller 
{
	protected $page_data;
	protected $admin_id;
	protected $company_id;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('users_model', 'users');
		$this->load->model('companies_model', 'companies');
		$this->load->model('locations_model', 'locations');
		$this->load->model('groups_model', 'groups');
		$this->load->model('codes_model', 'codes');

		$this->load->model('pages_data_model');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		
		$this->page_data = array();
		$this->page_data['title'] = 'Tell The Boss - Admin Panel - Manage Company';

		$this->admin_id = $this->session->userdata('user_id');
		
		$this->company_id = $this->session->userdata('cid');
	}
	
	public function index()
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$this->page_data['adminpage'] = "None";

/* 			$companies = $this->companies->list_records(); */
			$companies = $this->companies->get_companies_for_user($this->session->userdata('user_id'));
			if (count($companies) == 1) {
				$this->company_id = $companies[0]['ID'];
				$this->session->set_userdata('cid',$companies[0]['ID']);
				redirect('admin/edit');
			}
			$this->page_data["companies"] = $companies;

			$this->load->view('admin/header', $this->page_data);
			$this->load->view('admin/company/company_index',$this->page_data);
			$this->load->view('admin/footer');
		}
		else
		{
			redirect('error/must_sign_up_as_admin');
		}
	}
	
	
	public function edit($error = "")
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
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
				redirect('admin/index');
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
	
	public function save_company()
	{
		$formValues = $this->input->post(NULL, TRUE);
		$this->companies->put_by_id($formValues);
		redirect('admin/edit');
	}
	
	public function save_picture()
	{
		$this->load->library('upload');
		
		$config['upload_path'] = UPLOAD_DIR;
		$config['allowed_types'] = 'jpg';
		$config['max_size']	= '250';
		$config['max_width']  = '2000';
		$config['max_height']  = '2000';
		$config['overwrite'] = true;
		$config['file_name'] = 'logo_'.$this->company_id.'.jpg';

		$this->upload->initialize($config);
 
		$uploaded = $this->upload->up(TRUE); //Pass true if you want to create the index.php files

		if (!empty($uploaded['error'])) {
			$this->edit(empty($uploaded['error']) ? '' : trim($uploaded['error'][0]['error_msg']));
		} else {
			$config['image_library'] = 'gd2';
			$config['source_image'] = $this->upload->upload_path.$this->upload->file_name;
			$config['maintain_ratio'] = TRUE;
			$config['width'] = 250;
			$config['height'] = 125;
			$this->load->library('image_lib',$config); 
		
			if ( !$this->image_lib->resize()){
				$this->edit($this->image_lib->display_errors('', ''));
			} else {
				redirect('admin/edit');
			}
		}
	}


	public function locations($error = "")
	{
		function domap($groups,$g) {
			$map = array();
			$map['locations'] = $groups->get_locations_ids($g);
			$sgs = $groups->get_subgroups_ids($g);
			foreach ($sgs as $sg) {
				$map['groups'][$sg] = domap($groups,$sg);				
			}
			return $map;
		}
		
		if ($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$values = $this->input->post(NULL, TRUE);
			
			$this->page_data['adminpage'] = "Locations";
			$this->page_data["error"] = $error;
			$cid = $this->input->get('cid');
			
			if ($cid !== false) {
				$this->company_id = $cid;
				$this->session->set_userdata('cid',$cid);
			}
			
			if ($this->company_id == 0) {
				redirect('admin/index');
			}

			$company = $this->companies->get_by_id($this->company_id);
			$locations = $this->locations->get_by_company_id($this->company_id);
			$groups = $this->groups->get_by_company_id($this->company_id);
			$level0groups = $this->groups->get_unbound_by_company_id($this->company_id);
			
			$map = array();
			foreach ($level0groups as $g) {
				$id = $g['ID'];
				$map['groups'][$id] = domap($this->groups,$id);
			}
			$map['locations'] = $this->locations->get_unbound_by_company_id($this->company_id);
			
			$group_names = array();
			$group_types = array();
			foreach ($groups as $g) {
				$group_types[$g['ID']] = $g['type'];
				$group_names[$g['ID']] = $g['name'];
			}

			$loc_names = array();
			foreach ($locations as $l) {
				$loc_names[$l['ID']] = $l['name'];
			}

			$this->load->view('admin/header', $this->page_data);
			$this->load->view('admin/locations/location_index',array('company'=>$company[0],'map'=>$map,'group_types'=>$group_types,'group_names'=>$group_names,'loc_names'=>$loc_names));
			$this->load->view('admin/footer');
		}
		else
		{
			redirect('error/must_sign_up_as_admin');
		}
	}
	
	public function add_group() {
		$this->form_validation->set_rules('grouptype', 'Group Level Type', 'required');
		$this->form_validation->set_rules('groupname', 'Group Level Description', 'required');
		if ($this->form_validation->run() == false) {
			$this->locations(validation_errors());
		} else {
			$group_data = array(
				'name'=>$this->input->post('groupname'),
				'type'=>$this->input->post('grouptype'),
				'has_parent'=>0,
				'company_id'=> $this->company_id);
					 
/* 			var_dump($group_data); */
			$group_id = $this->groups->add($group_data);
			redirect('admin/locations');
		}
	}
	
	public function set_group()
	{
		$formValues = $this->input->post(NULL, TRUE);
		$data = array('ID'=>$formValues['pk'],$formValues['name']=>$formValues['value']);
		$this->groups->put_by_id($data);
	}
	
	public function change_group()
	{
		$formValues = $this->input->post(NULL, TRUE);
		$location = $formValues['id'];
		$newparent = $formValues['group'];
		
		if ($location < 0) { // this means we are a group
			$this->groups->unbind_subgroup_from_parent(-$location);
		} else {
			$this->groups->unbind_location_from_parent($location);
		}
		if ($newparent < 0) { // we have a new group for a parent
			if ($location < 0) { // this means we are a group
				$this->groups->bind_subgroup(-$newparent,-$location);	
			} else {
				$this->groups->bind_location(-$newparent,$location);	
			}
		}
	}
	
	
	public function location_edit($error = "")
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$values = $this->input->post(NULL, TRUE);
			
			$this->page_data['adminpage'] = "Locations";
			$this->page_data["error"] = $error;
			$lid = $this->input->get('lid');
			
			if ($this->company_id == 0) {
				redirect('admin/index');
			}
			
			$groups = $this->groups->get_by_company_id($this->company_id);
			$group_names = array();
			foreach ($groups as $g) {
				$group_names[$g['ID']] = $g['type'].' | '.$g['name'];
			}

			if ($lid === false) {
				$location = false;
				$codes = false;
				$group_id = $this->input->get('gid');
			} else {
				$location = $this->locations->get_by_id($lid);
				$location = $location[0];
				$group = $this->groups->get_group_id($lid);
				$group_id = $group[0]['group_id'];
				$codes = $this->codes->get_by_location_id($lid);
			}
			$company = $this->companies->get_by_id($this->company_id);

			$this->load->view('admin/header', $this->page_data);
			$this->load->view('admin/locations/location_edit',array('company'=>$company[0],'location'=>$location,'groups'=>$group_names,'group_id'=>$group_id,'codes'=>$codes));
			$this->load->view('admin/footer');
		}
		else
		{
			redirect('error/must_sign_up_as_admin');
		}
	}
	
	public function get_qr_code()
	{
		$code = $this->input->get('code');
		QRcode::png($code,false,'L',4);
	}
	
	public function save_location()
	{
/*
		$formValues = $this->input->post(NULL, TRUE);
		$this->companies->put_by_id($formValues);
*/
		redirect('admin/location_edit');
	}
	
	public function set_code()
	{
		$formValues = $this->input->post(NULL, TRUE);
		$data = array('ID'=>$formValues['pk'],$formValues['name']=>$formValues['value']);
		$this->codes->put_by_id($data);
	}


	public function users()
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$values = $this->input->post(NULL, TRUE);
			
			$this->page_data['adminpage'] = "Users";

			$cid = $this->input->get('cid');
			
			if ($cid !== false) {
				$this->company_id = $cid;
				$this->session->set_userdata('cid',$cid);
			}

			
			if ($this->company_id == 0) {
				redirect('admin/index');
			}

			$company = $this->companies->get_by_id($this->company_id);
			$this->page_data['company'] = $company[0];
			
			$users = $this->users->get_users_for_company($this->company_id);
			$this->page_data["users"] = $users;

			$this->load->view('admin/header', $this->page_data);
			$this->load->view('admin/user/user_index',$this->page_data);
			$this->load->view('admin/footer');
		}
		else
		{
			redirect('error/must_sign_up_as_admin');
		}
	}
	
	public function user_edit($error = "")
	{
		if ($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$values = $this->input->post(NULL, TRUE);
			
			$this->page_data['adminpage'] = "Users";
			$this->page_data["error"] = $error;

			$cid = $this->input->get('cid');
			
			if ($cid !== false) {
				$this->company_id = $cid;
				$this->session->set_userdata('cid',$cid);
			}

			
			if ($this->company_id == 0) {
				redirect('admin/index');
			}

			$company = $this->companies->get_by_id($this->company_id);
/*
			$locations = $this->locations->get_by_company_id($this->company_id);
			$groups = $this->groups->get_by_company_id($this->company_id);
			$level0groups = $this->groups->get_unbound_by_company_id($this->company_id);
			
			$map = array();
			foreach ($level0groups as $g) {
				$id = $g['ID'];
				$map['groups'][$id] = domap($this->groups,$id);
			}
			$map['locations'] = $this->locations->get_unbound_by_company_id($this->company_id);
			
			$group_names = array();
			$group_types = array();
			foreach ($groups as $g) {
				$group_types[$g['ID']] = $g['type'];
				$group_names[$g['ID']] = $g['name'];
			}

			$loc_names = array();
			foreach ($locations as $l) {
				$loc_names[$l['ID']] = $l['name'];
			}
*/

			$this->load->view('admin/header', $this->page_data);
			$this->load->view('admin/user/user_edit', array('company'=>$company[0]));
			$this->load->view('admin/footer');
		}
		else
		{
			redirect('error/must_sign_up_as_admin');
		}
	}
	

	
	public function feedback($error = "")
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$this->page_data['adminpage'] = "Feedback";
			$this->page_data["error"] = $error;

			$this->load->view('admin/header', $this->page_data);
			$this->load->view('admin/feedback/feedback');
			$this->load->view('admin/footer');
		}
		else
		{
			redirect('error/must_sign_up_as_admin');
		}
	}
	
	

}