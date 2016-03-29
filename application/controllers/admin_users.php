<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_users extends CI_Controller 
{
	protected $page_data;
	protected $admin_id;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('users_model', 'users');
		$this->load->model('companies_model', 'companies');
		$this->load->model('groups_model', 'groups');
		$this->load->model('locations_model', 'locations');
		$this->load->model('codes_model', 'codes');
		$this->load->model('pages_data_model');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		
		$this->page_data = array();
		$this->page_data['title'] = 'Tell The Boss - Admin Panel - Manage Users';
		$this->page_data['current'] = 'admin_panel';
		$this->admin_id = $this->session->userdata('user_id');
	}
	
	public function index($msg = "")
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$this->page_data['sub_current'] = 'manage_users';
			$this->page_data['current_path'] = array("Manage Users"=>"admin_users");
			$this->page_data["clients"] = $this->users->list_records(array('type'=>'CLIENT'));
			$this->page_data["admins"] = $this->users->list_records(array('type'=>'ADMIN', 'ID !='=> $this->admin_id));
			$this->page_data["reply"] = $msg;
			
			$this->load->view('admin_panel/header', $this->page_data);
			$this->load->view('admin_panel/sub_menu');
			$this->load->view('admin_panel/admin_users/list');
			$this->load->view('general/footer');
		}
		else
		{
			redirect('error/must_sign_up_as_admin');
		}
	}
	
	public function add()
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$this->page_data['sub_current'] = 'manage_users';
			$this->page_data['current_path'] = array("Manage Users"=>"admin_users","Add a New User"=>"admin_users\add");
			
			$this->load->view('admin_panel/header', $this->page_data);
			$this->load->view('admin_panel/sub_menu');
			$this->load->view('admin_panel/admin_users/add');
			$this->load->view('general/footer');
		}
		else
		{
			redirect('error/must_sign_up_as_admin');
		}
	}
	
	public function submit_add()
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$this->form_validation->set_rules('first_name', 'First name', 'trim|required|max_length[20]|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('last_name', 'Last name', 'trim|required|max_length[20]|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('username', 'User name', 'trim|required|min_length[2]|max_length[20]|alpha_dash|is_unique[users.username]|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|max_length[50]|alpha_dash|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('confirm', 'Confirm password', 'trim|required|matches[password]|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('email', 'Email', 'trim|min_length[5]|max_length[50]|valid_email|is_unique[users.email]|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('phone', 'Phone number', 'trim|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('type', 'User type', 'trim|required|encode_php_tags|xss_clean');
		
			if($this->form_validation->run())
			{
				$user_data = array('first_name'=>$this->input->post('first_name'), 
													 'last_name'=>$this->input->post('last_name'),
													 'username'=>$this->input->post('username'),
													 'password'=>$this->input->post('password'),
													 'email'=>$this->input->post('email'),
													 'phone'=>$this->input->post('phone'),
													 'type'=> $this->input->post('type'),
													 'signup_date'=> 'now',
													 'is_active'=> 1);
				$this->users->add($user_data);
			
				$reply = "The <em>".strtolower($user_data['type'])."</em> <strong>".$user_data['first_name']." ".$user_data['last_name']." (".$user_data['username'].")</strong> was successfully added to the list of users.";
				
				$this->index($reply);
			}
			else
			{
				$this->add();
			}
		}
		else
		{
			redirect('error/must_sign_up_as_admin');
		}
	}
	
	public function edit($target_id)
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$target_data = $this->users->get_by_id($target_id);
			if(!empty($target_data))
			{
				$this->page_data['target_data'] = $target_data;
				
				$this->page_data['sub_current'] = 'manage_users';
				$this->page_data['current_path'] = array("Manage Users"=>"admin_users", "Edit ".$target_data['type']." : ".$target_data['username']=>"admin_users/edit/".$target_id);
				
				$this->load->view('admin_panel/header', $this->page_data);
				$this->load->view('admin_panel/sub_menu');
				$this->load->view('admin_panel/admin_users/edit');
				$this->load->view('general/footer');
			}
			else
			{
				redirect('error/something_went_wrong');
			}
		}
		else
		{
			redirect('error/must_sign_up_as_admin');
		}
	}
	
	public function submit_edit($target_id)
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$target_data = $this->users->get_by_id($target_id);
			if(!empty($target_data))
			{
				$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|max_length[20]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|max_length[20]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('username', 'User Name', 'trim|required|max_length[20]|alpha_dash|callback__is_unique_if_new[users.username.'.$target_data['username'].']|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|max_length[50]|alpha_dash|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('email', 'Email Address', 'trim|max_length[50]|valid_email|callback__is_unique_if_new[users.email.'.$target_data['email'].']|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('phone', 'Cell Phone Number', 'trim|callback_is_unique_if_new[users.phone.'.$target_data['phone'].']|encode_php_tags|xss_clean');
				
				if($this->form_validation->run())
				{
					$user_data = array('first_name'=>$this->input->post('first_name'), 
														 'last_name'=>$this->input->post('last_name'),
														 'username'=>$this->input->post('username'),
														 'email'=>$this->input->post('email'));
					
					$champ = $this->input->post('password');
					if(!empty($champ))
						$user_data['password'] = $champ;
						
					$champ = $this->input->post('phone');
					if(!empty($champ))
						$user_data['phone'] = $champ;
					
					$this->users->edit($target_id, $user_data);
					
					$reply = 'The changes you requested have been successfully submitted to '.$user_data['username'];
					$this->index($reply);
				}
				else
				{
					$this->edit($target_id);
				}
			}
			else
			{
				redirect('error/something_went_wrong');
			}
		}
		else
		{
			redirect('error/must_sign_up_as_admin');
		}
	}
	
	public function activate($user_id)
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$user_data = $this->users->get_by_id($user_id);
			if(!empty($user_data))
			{
				$new_data['is_active'] = 1;
				$this->users->edit($user_id, $new_data);
				$this->index($user_data['first_name'].' '.$user_data['last_name'].' Was Successfully activated. They can now use their login information to access the site.');
			}
			else
				redirect('error/something_went_wrong');
		}
		else
			redirect('error/must_sign_up_as_admin');
	}
	
	public function deactivate($user_id)
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$user_data = $this->users->get_by_id($user_id);
			if(!empty($user_data))
			{
				$new_data['is_active'] = 0;
				$this->users->edit($user_id, $new_data);
				$this->index($user_data['first_name'].' '.$user_data['last_name'].' is now Inactive and can NOT user their login information to access the site');
			}
			else
				redirect('error/something_went_wrong');
		}
		else
			redirect('error/must_sign_up_as_admin');
	}
	
	public function delete($target_id)
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$target_data = $this->users->get_by_id($target_id);
			if(!empty($target_data))
			{
				$this->page_data['target_data'] = $target_data;
				$this->page_data['sub_current'] = 'manage_users';
				$this->page_data['current_path'] = array("Manage Users"=>"admin_users", "delete ".$target_data['type']." : ".$target_data['username']=>"admin_users/delete/".$target_id);
				
				$this->load->view('admin_panel/header', $this->page_data);
				$this->load->view('admin_panel/sub_menu');
				$this->load->view('admin_panel/admin_users/delete');
				$this->load->view('general/footer');
			}
			else
			{
				redirect('error/something_went_wrong');
			}
		}
		else
		{
			redirect('error/must_sign_up_as_admin');
		}
	}
	
	public function submit_delete($target_id)
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$target_data = $this->users->get_by_id($target_id);
			if(!empty($target_data))
			{
				$this->users->delete($target_id);
				
				$reply = 'The '.$target_data['type'].' : '.$target_data['username'].' was successfully deleted.';
				$this->index($reply);
			}
			else
			{
				redirect('error/something_went_wrong');
			}
		}
		else
		{
			redirect('error/must_sign_up_as_admin');
		}
	}
	
	
	public function assign_rights($user_id, $submit = null)
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$user_data = $this->users->get_by_id($user_id);
			if(!empty($user_data))
			{
				$this->page_data['user_data'] = $user_data;
				$this->page_data['sub_current'] = 'manage_users';
				$this->page_data['current_path'] = array("Manage Users"=>"admin_users", "Assign Companies, Locations and Codes to  ".$user_data['username'] => "admin_users/assign_rights/".$user_id);
				
				//submitting data part
				if(!empty($submit))
				{
					$this->form_validation->set_rules('filtred_companies', 'Companies', 'encode_php_tags|xss_clean');
					$this->form_validation->set_rules('filtred_subgroups', 'Groups', 'encode_php_tags|xss_clean');
					$this->form_validation->set_rules('filtred_locations', 'Locations', 'encode_php_tags|xss_clean');
					$this->form_validation->set_rules('filtred_codes', 'Codes', 'encode_php_tags|xss_clean');
					
					if($this->form_validation->run())
					{
						//var_dump($this->input->post());
						//removing all previous user rights in the database
						$this->users->unassign_all($user_id);
						
						//collecting chosen rights
						$submitted_companies = explode(',', $this->input->post('filtred_companies'));
						$submitted_groups = explode(',', $this->input->post('filtred_subgroups'));
						$submitted_locations = explode(',', $this->input->post('filtred_locations'));
						$submitted_codes = explode(',', $this->input->post('filtred_codes'));
						
						if(!empty($submitted_companies[0]))
							foreach($submitted_companies as $sc)
								$this->users->assign_rights($user_id, $sc, 'company');
						
						if(!empty($submitted_groups[0]))
							foreach($submitted_groups as $sg)
								$this->users->assign_rights($user_id, $sg, 'group');
						
						if(!empty($submitted_locations[0]))					
							foreach($submitted_locations as $sl)
								$this->users->assign_rights($user_id, $sl, 'location');
						
						if(!empty($submitted_codes[0]))					
							foreach($submitted_codes as $sc)
								$this->users->assign_rights($user_id, $sc, 'code');
					}
				}
				
				//collecting data part
				$linked_comps = $this->users->get_rights_by_type($user_id, 'company');
				$linked_groups = $this->users->get_rights_by_type($user_id, 'group');
				$linked_locs = $this->users->get_rights_by_type($user_id, 'location');
				$linked_codes = $this->users->get_rights_by_type($user_id, 'code');
				
				$this->page_data['rights']['companies'] = $linked_comps;
				$this->page_data['rights']['groups'] = $linked_groups;
				$this->page_data['rights']['locations'] = $linked_locs;
				$this->page_data['rights']['codes'] = $linked_codes;
				
				
				$companies = $this->companies->list_records(array(), 0, 0, array('name', 'ASC'));
				$i = 0;
				foreach($companies as $company)
				{
					$groups = $this->groups->list_records(array('company_id'=>$company->ID), 0, 0, array('name', 'ASC'));
					$locations = $this->locations->list_records(array('company_id'=>$company->ID), 0, 0, array('name', 'ASC'));
					$codes = $this->codes->list_records(array('company_id' => $company->ID), 0, 0, array('code', 'ASC'));
					$groups_locations = $this->_get_groups_locations_arrays($groups, $locations, $codes);
					
					
					$company = (array) $company;
					$company['tree'] = $this->_get_company_hierarchy($groups_locations['groups'], $groups_locations['locations']);
					$companies[$i] = (array) $company;
					$i++;
				}
			
				$this->page_data['companies'] = $companies;
				
				$this->load->view('admin_panel/header', $this->page_data);
				$this->load->view('admin_panel/sub_menu');
				$this->load->view('admin_panel/admin_users/assign_rights');
				$this->load->view('general/footer');
			}
			else
			{
				redirect('error/something_went_wrong');
			}
		}
		else
		{
			redirect('error/must_sign_up_as_admin');
		}
	}
	
	public function manage_notifications($user_id, $reply = '')
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$user_data = $this->users->get_by_id($user_id);
			if(!empty($user_data))
			{
				$user_emails_phones = $this->users->get_phones_emails($user_id);
				$i = 0;
				foreach($user_emails_phones  as $uep)
				{
					if(strcmp($uep['contact'], $user_data['email']) == 0 || strcmp($uep['contact'], $user_data['phone']) == 0)
						$user_emails_phones[$i]['primary'] = 1;
					else
						$user_emails_phones[$i]['primary'] = 0;
					$list_emails_phones[$uep['contact']] = $uep;
					$i++;
				}
				
				$this->page_data['user_data'] = $user_data;
				$this->page_data['reply'] = $reply;
				$this->page_data['phones_emails'] = $user_emails_phones;
				$this->page_data['list_emails_phones'] = $list_emails_phones;
				$this->page_data['sub_current'] = 'manage_users';
				$this->page_data['current_path'] = array("Manage Users"=>"admin_users", "Manage ".$user_data['username']."'s notifications" => "admin_users/manage_notifications/".$user_id);
				
				$this->load->view('admin_panel/header', $this->page_data);
				$this->load->view('admin_panel/sub_menu');
				$this->load->view('admin_panel/admin_users/manage_notifications');
				$this->load->view('general/footer');
			}
			else
			{
				redirect('error/something_went_wrong');
			}
		}
		else
		{
			redirect('error/must_sign_up_as_admin');
		}
	}
	
	public function submit_manage_notifications($user_id)
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$user_data = $this->users->get_by_id($user_id);
			if(!empty($user_data))
			{
				$this->form_validation->set_rules('email', 'Primary Email', 'trim|max_length[50]|valid_email|callback__not_in_db[users.contact.'.$user_id.']|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('phone', 'Primary Phone', 'trim|max_length[20]|callback__valid_phone|callback__not_in_db[users.contact.'.$user_id.']|encode_php_tags|xss_clean');
				$sc_number = $this->input->post('sec_contacts_number');
				$contacts_array = array();
				for($i = 1; $i <= $sc_number; $i++)
				{
					$this->form_validation->set_rules('email_phone_'.$i, 'Email or Phone '.$i, 'trim|required|max_length[50]|callback__valid_email_or_phone|callback__not_in_db[users.contact.'.$user_id.']|encode_php_tags|xss_clean');
					$contact_info = $this->input->post('email_phone_'.$i);
					if(strpos($contact_info, '@') !== false)
						$contacts_array[] = $contact_info ;
					else
						$contacts_array[] = format_phone($contact_info);
				}
				$unique_contacts = array_unique($contacts_array);
				$contacts_are_distinct = true;
				if(count($unique_contacts) != count($contacts_array))
					$contacts_are_distinct = false;
				
				if($this->form_validation->run() && $contacts_are_distinct)
				{
					//updating user's email and phone: 
					$new_user_data = array('email'=>$this->input->post('email'),
												 'phone'=>$this->input->post('phone'));
					$new_user_data['phone'] = format_phone($new_user_data['phone']);
					$this->users->edit($user_id, $new_user_data);
					
					//removing all previous emails and phones
					$this->users->remove_all_phones_emails($user_id);
					
					//adding new phones and emails
					$this->users->add_phone($user_id, $new_user_data['phone'], $this->input->post('pf_noti_for'));
					$this->users->add_email($user_id, $new_user_data['email'], $this->input->post('pe_noti_for'));
					for($i = 1; $i <= $sc_number; $i++)
					{
						$contact_info = $this->input->post('email_phone_'.$i);
						if(strpos($contact_info, '@') !== false)
							$type = 'email';
						else
						{
							$contact_info = format_phone($contact_info);
							$type = 'phone';
						}
						$this->users->add_phone_email($user_id, $contact_info, $type, $this->input->post('ef_noti_for_'.$i));
					}
					$reply = '<span class="success">You have successfully submitted the notifications options changes for '.$user_data['username'].'</span>';
					$this->manage_notifications($user_id, $reply);
				}
				else
				{
					$reply = '<span class="error">There was some error</span>';
					if(!$contacts_are_distinct)
						$reply = '<span class="error">The emails and phones you submitted are not distinct</span>';
					$this->manage_notifications($user_id, $reply);
				}
			}
			else
			{
				redirect('error/something_went_wrong');
			}
		}
		else
		{
			redirect('error/must_sign_up_as_admin');
		}
	}
	
	
	
	public function _is_grandparent($child, $grandparent, $groups)
	{
		if(empty($groups) || empty($groups[$child]) || empty($groups[$grandparent]))
			return false;
		else
		{
			$cm = $groups[$child];
			while(!empty($cm))
			{
				if(empty($cm['parent']))
					return false;
				elseif($cm['parent'] == $grandparent)
					return true;
				else
					$cm = $groups[$cm['parent']];
			}
		}
	}
	
	public function _get_groups_locations_arrays($groups, $locations, $codes)
	{
		$locations_array = array();
		foreach($locations as $loc)
			$locations_array[$loc->ID] = (array) $loc;
		
		foreach($codes as $code)
		{
			$code = (array) $code;
			$locations_array[$code['location_id']]['codes'][] = $code;
		}
		
		$groups_array = array();
		foreach($groups as $g)
			$groups_array[$g->ID] = (array) $g;
					
		$result = array('groups'=> array(), 'locations'=> array());
		$i = 0;
		
		foreach($groups as $group)
		{
			$locations_ids = $this->groups->get_binded_locations($group->ID);
			$group_locations = array();
			foreach($locations_ids as $l_id)
			{
				$group_locations[] = $locations_array[$l_id['location_id']];
				$locations_array[$l_id['location_id']]['parent'] = $group->ID;
			}
				
			//$groups[$i]->locations = $group_locations;
			
			$subgroups_ids = $this->groups->get_binded_subgroups($group->ID);
			$group_subgroups = array();
			foreach($subgroups_ids as $sg_id)
			{
				$group_subgroups[] = $groups_array[$sg_id['subgroup_id']];
				$groups_array[$sg_id['subgroup_id']]['parent'] = $group->ID;
			}
				
			//$groups[$i]->subgroups = $group_subgroups;
			$i++;
		}
		
		$result['groups'] = $groups_array;
		$result['locations'] = $locations_array;
		
		return $result;
	}
	
	public function _get_company_hierarchy($groups, $locations, $parent = null) //recursive function, returns array of arrays
	{
		$result = array();
		if(empty($parent)) //we put elements that has no parent
		{
			//groups that has no parent
			foreach($groups as $group)
				if(empty($group['parent']))
				{
					$group['children'] = $this->_get_company_hierarchy($groups, $locations, $group['ID']);
					$result[] = $group;
				}
			//locations that has no parent
			foreach($locations as $loc)
				if(empty($loc['parent']))
					$result[] = $loc; 
		} // we put elements that has a specific parent
		else
		{
			//groups that has parent
			foreach($groups as $group)
				if(!empty($group['parent']) && $group['parent'] == $parent)
				{
					$group['children'] = $this->_get_company_hierarchy($groups, $locations, $group['ID']);
					$result[] = $group;
				}
			//locations that has  parent
			foreach($locations as $loc)
				if(!empty($loc['parent']) && $loc['parent'] == $parent)
					$result[] = $loc; 
		}
		
		return $result;
	}

	
	
	public function _sort_by_name(&$array)
	{
		/*$size = count($array);
		for($i = 0; $i < $size; $i++)
		{
			for($j = 0; $j < $size-1; $j++)
			{
				if(!empty($array[$j]->code))
				{
					if(strcmp(strtolower($array[$j]->code), strtolower($array[$j+1]->code)) > 0)
					{
						$temp = $array[$j];
						$array[$j] = $array[$j+1];
						$array[$j+1] = $temp;
					}
				}
				else
				{
					if(strcmp(strtolower($array[$j]->name), strtolower($array[$j+1]->name)) > 0)
					{
						$temp = $array[$j];
						$array[$j] = $array[$j+1];
						$array[$j+1] = $temp;
					}
				}
			}
		}*/
	}
	
	public function _valid_phone($str)
	{
		if(!empty($str))
		{
			$str = format_phone($str);
			if(strlen($str) == 11 && $str[0] == '1')
				return true;
			else
			{
				$this->form_validation->set_message('_valid_phone', 'Not a valid USA phone number');
				return false;
			}
		}
		else
		{
			$this->form_validation->set_message('_valid_phone', 'Not a valid USA phone number');
			return false;
		}
	}
	
	public function _valid_email_or_phone($str)
	{
		if(!empty($str))
		{
			if(strpos($str, '@') !== false)
			{
				if(!$this->form_validation->valid_email($str))
				{
					$this->form_validation->set_message('_is_unique_if_new', 'Not a valid Email');				
					return false;
				}
				else
					return true;
			}
			else
			{
				$str = format_phone($str);
				if(strlen($str) == 11 && $str[0] == '1')
					return true;
				else
				{
					$this->form_validation->set_message('_valid_email_or_phone', 'Not a valid USA phone number');
					return false;
				}
			}
		}
		else
		{
			$this->form_validation->set_message('_valid_email_or_phone', 'Not a valid Email or USA phone number');
			return false;
		}
	}
	
	public function _is_unique_if_new($str, $field)
	{
		if(!empty($str))
		{
			list($table, $item, $old_data) = explode('.', $field, 3);
			if(strcmp($old_data, $str) == 0)
					return true;
			$field = $table.'.'.$item;
			if(!$this->form_validation->is_unique($str, $field))
			{
				$this->form_validation->set_message('_is_unique_if_new', 'that '.$item.' is taken');				
				return false;
			}
			else
				return true;
		}
		else
			return true;
	}
	
	public function _not_in_db($str, $field)
	{
		if(!empty($str))
		{
			list($table, $item, $id) = explode('.', $field, 3);
			if(strcmp($item, 'contact') == 0) //if the field is contact, we check the users table and the user_phones_emails table
			{
				//we get the user's data from the database
				
				//we check if the data is new
				$user_emails_phones = $this->users->get_phones_emails($id);
				$user_data = $this->users->get_by_id($id);
				if(strcmp($str, $user_data['email']) == 0)
					return true;
				if(strcmp($str, $user_data['phone']) == 0)
					return true;
				foreach($user_emails_phones as $uep)
				{
					if(strcmp($str, $uep['contact']) == 0)
						return true;
				}
				
				//if not we check if data is unique
				if(!$this->form_validation->is_unique($str, 'users.phone'))
				{
					$this->form_validation->set_message('_not_in_db', 'that phone number is taken');				
					return false;
				}
				elseif(!$this->form_validation->is_unique($str, 'users.email'))
				{
					$this->form_validation->set_message('_not_in_db', 'that email is taken');				
					return false;
				}
				elseif(!$this->form_validation->is_unique($str, 'user_phones_emails.contact'))
				{
					$this->form_validation->set_message('_not_in_db', 'that email/phone is taken');				
					return false;
				}
				else 
					return true;
			}
		}
		else
			return true;
	}
	
}