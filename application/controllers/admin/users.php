<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller 
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

		$this->load->model('pages_data_model');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		
		$this->page_data = array();
		$this->page_data['title'] = 'Tell The Boss - Admin Panel - Manage Company';

		$this->admin_id = $this->session->userdata('user_id');
		
		$this->company_id = $this->session->userdata('cid');
	}
	
	public function index()
	{
		if($this->pages_data_model->is_logged_in() && (strcmp($this->session->userdata('type'), 'ADMIN') == 0 || strcmp($this->session->userdata('type'), 'SUPER') == 0))
		{
			$values = $this->input->post(NULL, TRUE);
			
			$this->page_data['adminpage'] = "Users";

			if ($this->company_id == 0) {
				redirect('admin');
			}
			if (!$this->companies->verify_company_for_user($this->admin_id,$this->company_id)) {
				redirect('admin');
			}

			$company = $this->companies->get_by_id($this->company_id);
			$this->page_data['company'] = $company[0];
			
			$users = $this->users->get_users_for_company($this->company_id);
			$this->page_data["users"] = $users;

			$this->load->view('admin/header', $this->page_data);
			$this->load->view('admin/users/user_index',$this->page_data);
			$this->load->view('admin/footer');
		}
		else
		{
			redirect('dash');
		}
	}
	
	public function edit($error = "")
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
		
		if ($this->session->userdata('user_id') == $this->input->get('uid') || ($this->pages_data_model->is_logged_in() && (strcmp($this->session->userdata('type'), 'ADMIN') == 0 || strcmp($this->session->userdata('type'), 'SUPER') == 0)))
		{
			$values = $this->input->post(NULL, TRUE);
			
			$this->page_data['adminpage'] = "Users";
			$this->page_data["error"] = $error;

			$uid = $this->input->get('uid');
			
			if ($this->company_id == 0) {
				$c = $this->companies->get_companies_for_user($this->admin_id);
				if (!empty($c)) {
					$this->company_id = $c[0]['ID'];
				} else {
					redirect('admin');
				}
			}
			if (!$this->companies->verify_company_for_user($this->admin_id,$this->company_id)) {
				$c = $this->companies->get_companies_for_user($this->admin_id);
				if (!empty($c)) {
					$this->company_id = $c[0]['ID'];
				} else {
					redirect('admin');
				}
			}

			$company = $this->companies->get_by_id($this->company_id);
			$this->page_data["company"] = $company[0];
			
			if ($uid > 0) {
				$user = $this->users->get_by_id($uid);
				$this->page_data["user"] = $user;
				
				$sms = $this->users->get_phones($uid);
				$this->page_data["sms"] = $sms;
				
				$email = $this->users->get_emails($uid);
				$this->page_data["email"] = $email;
			} else {
				$user = array();
			}
			
			$perm = $this->users->get_rights($uid);
			$permissions = array();
			foreach ($perm as $p) {
				$permissions[$p['target_type']][] = $p[$p['target_type'].'_id'];
			}
			$this->page_data['permissions'] = $permissions;

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
			$this->page_data['map'] = $map;
			$this->page_data['loc_names'] = $loc_names;
			$this->page_data['group_names'] = $group_names;
			$this->page_data['group_types'] = $group_types;

			$this->load->view('admin/header', $this->page_data);
			$this->load->view('admin/users/user_edit', $this->page_data);
			$this->load->view('admin/footer');
		}
		else
		{
			redirect('error/must_sign_up_as_admin');
		}
	}
	
	public function save()
	{
		$formValues = $this->input->post(NULL, TRUE);
		
		if (isset($formValues['checks'])) {
			$checks = $formValues['checks'];
			unset($formValues['checks']);
		}
		
		$smsonoff = !empty($formValues['smsonoff']) ? true : false;
		$smstype = isset($formValues['smstype']) ? $formValues['smstype'] : 0;
		unset($formValues['smsonoff']);
		unset($formValues['smstype']);
		
		$emailonoff = !empty($formValues['emailonoff']) ? true : false;
		$emailtype = isset($formValues['emailtype']) ? $formValues['emailtype'] : 0;
		unset($formValues['emailonoff']);
		unset($formValues['emailtype']);
		
		if ($formValues['ID'] == 0) {
			$uid = $this->users->add($formValues);
			$formValues['ID'] = $uid;
			$this->users->assign_rights($formValues['ID'],$this->company_id,'company');
		} else {
			$this->users->put_by_id($formValues);
			$this->users->remove_all_phones_emails($formValues['ID']);
		}
		
		$type = array('','negative','positive','all');
		
		if ($smsonoff && $smstype > 0) {
			$this->users->add_phone($formValues['ID'],$formValues['phone'],$type[$smstype]);
		}
		if ($emailonoff && $emailtype > 0) {
			$this->users->add_email($formValues['ID'],$formValues['email'],$type[$emailtype]);
		}
		
		if (isset($checks)) {
			$locations = $this->locations->get_by_company_id($this->company_id);
			foreach ($locations as $l) {
				$this->users->remove_right($formValues['ID'],$l['ID'],'location');
			}
			if (!empty($checks)) {
				$locations = explode(',', $checks);
				foreach ($locations as $l) {
					$this->users->assign_rights($formValues['ID'],$l,'location');
				}
			}
			redirect('admin/users');
		} else {
			redirect('admin/users/edit?uid='.$this->session->userdata('user_id'));
		}
	}

	public function delete_user()
	{
		$uid = $this->input->get('uid');
		$this->users->delete_permissions_by_id($uid);
		$this->users->delete_by_id($uid);
		redirect(site_url('/admin/users'));
	}
	
}