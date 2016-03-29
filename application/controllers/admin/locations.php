<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__).'/../../libraries/qrlib.php');

class Locations extends CI_Controller 
{
	protected $page_data;
	protected $admin_id;
	protected $company_id;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('companies_model', 'companies');
		$this->load->model('locations_model', 'locations');
		$this->load->model('groups_model', 'groups');
		$this->load->model('codes_model', 'codes');
		$this->load->model('users_model', 'users');
		$this->load->model('comments_model', 'comments');

		$this->load->model('pages_data_model');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		
		$this->page_data = array();
		$this->page_data['title'] = 'Tell The Boss - Admin Panel - Manage Company';

		$this->admin_id = $this->session->userdata('user_id');
		
		$this->company_id = $this->session->userdata('cid');
	}
	
	public function index($error = "")
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
		
		if($this->pages_data_model->is_logged_in() && (strcmp($this->session->userdata('type'), 'ADMIN') == 0 || strcmp($this->session->userdata('type'), 'SUPER') == 0))
		{
			$values = $this->input->post(NULL, TRUE);
			
			$this->page_data['adminpage'] = "Locations";
			$this->page_data["error"] = $error;
			if ($this->company_id == 0) {
				redirect('admin');
			}
			if (!$this->companies->verify_company_for_user($this->admin_id,$this->company_id)) {
				redirect('admin');
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
	
	
	public function edit($error = "")
	{
		if($this->pages_data_model->is_logged_in() && (strcmp($this->session->userdata('type'), 'ADMIN') == 0 || strcmp($this->session->userdata('type'), 'SUPER') == 0))
		{
			$values = $this->input->post(NULL, TRUE);
			
			$this->page_data['adminpage'] = "Locations";
			$this->page_data["error"] = $error;
			$lid = $this->input->get('lid');
			
			if ($this->company_id == 0) {
				redirect('admin');
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
				if (empty($group)) {
					$group_id = 0;
				} else {
					$group_id = $group[0]['group_id'];
				}
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
	
	public function add_qr_code()
	{
		$lid = $this->input->get('lid');
		$this->codes->add(array('code'=>'','description'=>'','is_global'=>0,'negative_type'=>'negative_type','location_id'=>$lid,'company_id'=>$this->company_id));
		redirect(site_url('/admin/locations/edit').'?lid='.$lid);
	}
	
	public function delete_qr_code()
	{
		$cid = $this->input->get('cid');
		$lid = $this->input->get('lid');
		$this->comments->delete_by_code_id($cid);
		$this->codes->delete_by_id($cid);
		redirect(site_url('/admin/locations/edit').'?lid='.$lid);
	}
	
	public function save()
	{
		$formValues = $this->input->post(NULL, TRUE);
		$lid = $formValues['ID'];
		$orgposition = 0;
		if (isset($formValues['orgposition'])) {
			$orgposition = $formValues['orgposition'];
			unset($formValues['orgposition']); 
		}
		
		if ($lid == 0) {
			$formValues['company_id'] = $this->company_id;
			$lid = $this->locations->add($formValues);
		} else {
			$this->locations->put_by_id($formValues);
			$this->groups->unbind_location_from_parent($lid);
		}
		if ($orgposition != 0) {
			$this->groups->bind_location($orgposition,$lid);	
		}

		redirect('admin/locations');
	}
	
	public function delete_location()
	{
		$lid = $this->input->get('lid');
		$this->comments->delete_by_location_id($lid);
		$this->codes->delete_by_location_id($lid);
		$this->groups->unbind_location_from_parent($lid);
		$this->users->delete_permissions_by_location_id($lid);
		$this->locations->delete_by_id($lid);
		redirect(site_url('/admin/locations'));
	}
	
	public function delete_group()
	{
		$gid = $this->input->get('gid');
		$this->groups->unbind_subgroup_from_parent($gid);
		$this->groups->delete_by_id($gid);
		redirect(site_url('/admin/locations'));
	}
	
	public function set_code()
	{
		$formValues = $this->input->post(NULL, TRUE);
		$data = array('ID'=>$formValues['pk'],$formValues['name']=>$formValues['value']);
		$this->codes->put_by_id($data);
	}
}