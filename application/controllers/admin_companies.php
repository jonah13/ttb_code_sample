 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_companies extends CI_Controller 
{
	protected $page_data;
	protected $admin_id;
	//protected $locations_array;
	//protected $groups_array;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('companies_model', 'companies');
		$this->load->model('locations_model', 'locations');
		$this->load->model('codes_model', 'codes');
		$this->load->model('groups_model', 'groups');
		$this->load->model('pages_data_model');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		
		$this->page_data = array();
		$this->page_data['title'] = 'Tell The Boss - Admin Panel - Manage Companies';
		$this->page_data['current'] = 'admin_panel';
		$this->admin_id = $this->session->userdata('user_id');
		
		$this->load->library('upload');
		
		$config['upload_path'] = UPLOAD_DIR;
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		$config['overwrite'] = 'TRUE';
		$config['max_size']	= '1000';
		$this->upload->initialize($config);
	}
	
	public function index($reply = "")
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$this->page_data['sub_current'] = 'manage_companies';
			$this->page_data['current_path'] = array("Manage Companies"=>"admin_companies");
			$this->page_data["reply"] = $reply;
			
			$companies = $this->companies->list_records();
			$i = 0;
			foreach($companies as $comp)
			{
				$companies[$i]->locations = $this->locations->list_records(array('company_id'=>$comp->ID));
				$companies[$i]->groups = $this->groups->list_records(array('company_id'=>$comp->ID));
				$i++;
			}
			$this->page_data["objects"] = $companies;
		
			
			$this->load->view('admin_panel/header', $this->page_data);
			$this->load->view('admin_panel/sub_menu');
			$this->load->view('admin_panel/admin_companies/list');
			$this->load->view('general/footer');
		}
		else
		{
			redirect('error/must_sign_up_as_admin');
		}
	}
	
	public function add($error = '')
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$this->page_data['sub_current'] = 'manage_companies';
			$this->page_data['current_path'] = array("Manage Companies"=>"admin_companies","Add a New Company"=>"admin_companies/add");
			$this->page_data['other_errors'] = $error;
			
			$this->load->view('admin_panel/header', $this->page_data);
			$this->load->view('admin_panel/sub_menu');
			$this->load->view('admin_panel/admin_companies/add');
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
			//company information
			$this->form_validation->set_rules('name', 'name', 'trim|required|is_unique[companies.name]|max_length[50]|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('address', 'address', 'trim|max_length[100]|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('city', 'city', 'trim|max_length[20]|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('state', 'state', 'trim|max_length[20]|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('zipcode', 'zipcode', 'trim|max_length[20]|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('company_contact', 'company contact', 'trim|max_length[50]|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('contact_phone', 'contact phone', 'trim|max_length[20]|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('contact_email', 'contact email', 'trim|max_length[50]|valid_email|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('website', 'website', 'trim|max_length[50]|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('business_type', 'business type', 'trim|max_length[50]|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('is_test', 'Company for testing', 'trim|encode_php_tags|xss_clean');
			
			$this->form_validation->set_rules('locations_number', 'Locations Number', 'trim|encode_php_tags|xss_clean');
			
			//locations
			$n_locations = $this->input->post('locations_number');
			$codes = array();
			//echo $n_locations.' : locations number<br/>';
			for($i = 1; $i <= $n_locations; $i++)
			{
				$this->form_validation->set_rules('name_'.$i, 'Location '.$i.' name', 'trim|required|is_unique[locations.name]|max_length[50]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('timezone_'.$i, 'Location '.$i.' timezone', 'trim|required|max_length[20]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('address_'.$i, 'Location '.$i.' address', 'trim|max_length[100]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('state_'.$i, 'Location '.$i.' state', 'trim|max_length[20]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('city_'.$i, 'Location '.$i.' city', 'trim|max_length[20]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('zipcode_'.$i, 'Location '.$i.' zipcode', 'trim|max_length[20]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('website_'.$i, 'Location '.$i.' website', 'trim|max_length[50]|encode_php_tags|xss_clean');
				
				$this->form_validation->set_rules('codes_'.$i.'_number', 'Location '.$i.' number of codes', 'trim|required|encode_php_tags|xss_clean');
				
				//codes
				$n_codes = $this->input->post('codes_'.$i.'_number');
				//echo $n_codes.' : codes_'.$i.'_number<br/>';
				for($j = 1; $j <= $n_codes; $j++)
				{
					$this->form_validation->set_rules('code_'.$i.'_'.$j, 'Location '.$i.' code '.$j, 'trim|required|is_unique[codes.code]|max_length[20]|encode_php_tags|xss_clean');
					$this->form_validation->set_rules('code_'.$i.'_'.$j.'_desc', 'Location '.$i.' code '.$j.' description', 'trim|max_length[100]|encode_php_tags|xss_clean');
					
					$codes[] = $this->input->post('code_'.$i.'_'.$j);
				}
			}
			
			$unique_codes = array_unique($codes);
			$codes_are_distinct = true;
			if(count($unique_codes) != count($codes))
				$codes_are_distinct = false;
		
			if($this->form_validation->run() && $codes_are_distinct)
			{
				$company_data = array('name'=>$this->input->post('name'), 
														 'address'=>$this->input->post('address'),
														 'city'=>$this->input->post('city'),
														 'state'=>$this->input->post('state'),
														 'zipcode'=>$this->input->post('zipcode'),
														 'company_contact'=>$this->input->post('company_contact'),
														 'contact_phone'=>$this->input->post('contact_phone'),
														 'contact_email'=>$this->input->post('contact_email'),
														 'website'=>$this->input->post('website'),
														 'business_type'=>$this->input->post('business_type'),
														 'is_test'=>$this->input->post('is_test'),
														 'date_added'=>'now',
														 'is_active'=> 1);

				$company_id = $this->companies->add($company_data);
				for($i = 1; $i <= $n_locations; $i++)
				{
					$location_data = array('name'=>$this->input->post('name_'.$i), 
																 'timezone'=>$this->input->post('timezone_'.$i),
																 'address'=>$this->input->post('address_'.$i),
																 'state'=>$this->input->post('state_'.$i),
																 'city'=>$this->input->post('city_'.$i),
																 'zipcode'=>$this->input->post('zipcode_'.$i),
																 'website'=>$this->input->post('website_'.$i),
																 'business_type'=> $company_data['business_type'],
																 'is_active'=> 1,
																 'company_id'=> $company_id);
																 
					$location_id = $this->locations->add($location_data);
					
					$n_codes = $this->input->post('codes_'.$i.'_number');
					for($j = 1; $j <= $n_codes; $j++)
					{
						$code_data = array('code'=>$this->input->post('code_'.$i.'_'.$j), 
															 'description'=>$this->input->post('code_'.$i.'_'.$j.'_desc'),
															 'location_id'=> $location_id,
															 'company_id'=> $company_id);
															 
						$code_id = $this->codes->add($code_data);
					}
				}
				
				
				$this->index("You have successfully registred the Company ".$company_data['name']." with ".$n_locations." locations");
			}
			else
			{
				if($codes_are_distinct)
					$this->add();
				else
					$this->add('The codes you entered are not distinct!');
			}
		}
		else
		{
			redirect('error/must_sign_up_as_admin');
		}
	}
	
	public function edit($target_id = NULL)
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$target_data = $this->companies->get_by_id($target_id);
			if(!empty($target_data))
			{
				$this->page_data['target_data'] = $target_data;
				
				$this->page_data['sub_current'] = 'manage_companies';
				$this->page_data['current_path'] = array("Manage Companies"=>"admin_companies", "Edit company : ".$target_data['name']=>"admin_companies/edit/".$target_id);
				
				$this->load->view('admin_panel/header', $this->page_data);
				$this->load->view('admin_panel/sub_menu');
				$this->load->view('admin_panel/admin_companies/edit');
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
	
	public function submit_edit($target_id = NULL)
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$target_data = $this->companies->get_by_id($target_id);
			if(!empty($target_data))
			{
				$this->form_validation->set_rules('name', 'Company Name', 'trim|required|max_length[50]|callback__is_unique_if_new[companies.name.'.$target_data['name'].']|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('address', 'Address', 'trim|max_length[100]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('city', 'city', 'trim|max_length[20]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('state', 'state', 'trim|max_length[20]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('zipcode', 'zipcode', 'trim|max_length[20]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('company_contact', 'company contact', 'trim|max_length[50]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('contact_phone', 'contact phone', 'trim|max_length[20]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('contact_email', 'contact email', 'trim|max_length[50]|valid_email|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('website', 'website', 'trim|max_length[50]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('business_type', 'business type', 'trim|max_length[50]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('is_test', 'Company for testing', 'trim|encode_php_tags|xss_clean');
				
				if($this->form_validation->run())
				{
					$new_data = array('name'=>$this->input->post('name'), 
														 'address'=>$this->input->post('address'),
														 'city'=>$this->input->post('city'),
														 'state'=>$this->input->post('state'),
														 'zipcode'=>$this->input->post('zipcode'),
														 'company_contact'=>$this->input->post('company_contact'),
														 'contact_phone'=>$this->input->post('contact_phone'),
														 'contact_email'=>$this->input->post('contact_email'),
														 'website'=>$this->input->post('website'),
														 'business_type'=>$this->input->post('business_type'),
														 'is_test'=>$this->input->post('is_test'));
					
					$this->companies->edit($target_id, $new_data);
					
					$reply = 'The changes you requested have been successfully submitted to '.$new_data['name'];
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
	
	public function activate($target_id)
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$target_data = $this->companies->get_by_id($target_id);
			if(!empty($target_data))
			{
				$new_data['is_active'] = 1;
				$this->companies->edit($target_id, $new_data);
				$this->index('The company '.$target_data['name'].' Was Successfully activated. All the codes that belong to it can now receive feedback!');
			}
			else
				redirect('error/something_went_wrong');
		}
		else
			redirect('error/must_sign_up_as_admin');
	}
	
	public function deactivate($target_id)
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$target_data = $this->companies->get_by_id($target_id);
			if(!empty($target_data))
			{
				$new_data['is_active'] = 0;
				$this->companies->edit($target_id, $new_data);
				$this->index('The company '.$target_data['name'].' is now Inactive and all the codes that belong to it won\'t be able to receive feedback!');
			}
			else
				redirect('error/something_went_wrong');
		}
		else
			redirect('error/must_sign_up_as_admin');
	}
	
	public function delete($target_id = NULL) //NOT DONE YET
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$target_data = $this->companies->get_by_id($target_id);
			if(!empty($target_data))
			{
				$this->page_data['target_data'] = $target_data;
				$this->page_data['sub_current'] = 'manage_companies';
				$this->page_data['current_path'] = array("Manage Companies"=>"admin_companies", "delete company : ".$target_data['name']=>"admin_companies/delete/".$target_id);
				
				$this->load->view('admin_panel/header', $this->page_data);
				$this->load->view('admin_panel/sub_menu');
				$this->load->view('admin_panel/admin_companies/delete');
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
	
	public function submit_delete($target_id = NULL)
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$target_data = $this->companies->get_by_id($target_id);
			if(!empty($target_data))
			{
				$this->companies->delete($target_id);
				
				$reply = 'The Company : '.$target_data['name'].' was successfully deleted as well as all the locations and codes under it.';
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
	
	
	public function edit_sms_qr_scripts($target_id, $reply = '', $img_error = null)
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$company_data = $this->companies->get_by_id($target_id);
			if(!empty($company_data))
			{
				$this->page_data['company'] = $company_data;	
				$this->page_data['reply'] = $reply;	
				$this->page_data['img_error'] = $img_error;	
				$this->page_data['sub_current'] = 'manage_companies';
				$this->page_data['current_path'] = array("Manage Companies"=>"admin_companies", "Edit SMS and QR scripts for: ".$company_data['name']=>"admin_companies/edit_sms_qr_scripts/".$target_id);
				$this->load->view('admin_panel/header', $this->page_data);
				$this->load->view('admin_panel/sub_menu');
				$this->load->view('admin_panel/admin_companies/edit_sms_qr_scripts');
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
	
	public function submit_edit_sms_qr_scripts($target_id)
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$company_data = $this->companies->get_by_id($target_id);
			if(!empty($company_data))
			{
				$this->form_validation->set_rules('s_header_logo', 'Header Logo', 'trim|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('s_body_bg_type', 'Body Background Type', 'trim|required|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('s_body_bg1', 'Body Background Color 1', 'trim|min_length[1]|max_length[20]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('s_body_bg2', 'Body Background Color 2', 'trim|min_length[1]|max_length[20]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('s_body_bg_pic', 'Body Background Picture', 'trim|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('s_header_bg_type', 'Header Background Type', 'trim|required|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('s_header_bg1', 'Header Background Color 1', 'trim|min_length[1]|max_length[20]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('s_header_bg2', 'Header Background Color 2', 'trim|min_length[1]|max_length[20]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('s_header_bg_pic', 'Header Background Picture', 'trim|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('s_header_fcolor', 'Header Font Color', 'trim|min_length[1]|max_length[20]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('s_header_ffamily', 'Header Font Family', 'trim|min_length[1]|max_length[20]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('s_header_fsize', 'Header Font Size', 'trim|min_length[1]|max_length[20]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('s_labels_fcolor', 'Labels Text Font Color', 'trim|min_length[1]|max_length[20]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('s_labels_ffamily', 'Labels Text Font family', 'trim|min_length[1]|max_length[20]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('s_labels_fsize', 'Labels Text Size', 'trim|min_length[1]|max_length[20]|encode_php_tags|xss_clean');
				
				$this->form_validation->set_rules('sms_first_reply', 'SMS First Response', 'trim|min_length[5]|max_length[200]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('sms_last_reply', 'SMS Last Response', 'trim|min_length[5]|max_length[200]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('qr_header', 'Header Text', 'trim|min_length[1]|max_length[50]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('qr_comment_label', 'Comment Label', 'trim|min_length[5]|max_length[200]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('qr_success_text', 'Success Message', 'trim|min_length[5]|max_length[500]|encode_php_tags|xss_clean');
				
				$this->form_validation->set_rules('cf_exists', 'Custom Field', 'trim|encode_php_tags|xss_clean');
				
				$this->form_validation->set_rules('cf_asked_for', 'Custom field Asked for', 'trim|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('cf_type', 'Custom Field Type', 'trim|min_length[1]|max_length[20]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('cf_qr_label', 'QR form Label Text', 'trim|min_length[5]|max_length[500]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('cf_required', 'Is Required?', 'trim|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('cf_pos', 'Custom Field Position', 'trim|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('cf_sms_text', 'SMS Inviting Message', 'trim|min_length[5]|max_length[500]|encode_php_tags|xss_clean');
				
				$this->form_validation->set_rules('cf2_exists', 'Custom Field 2', 'trim|encode_php_tags|xss_clean');
				
				$this->form_validation->set_rules('cf2_type', 'Custom Field 2 Type', 'trim|min_length[1]|max_length[20]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('cf2_qr_label', 'QR form Label Text', 'trim|min_length[5]|max_length[500]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('cf2_required', 'Is Required?', 'trim|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('cf2_pos', 'Custom Field 2 Position', 'trim|encode_php_tags|xss_clean');
				
				$header_bg_type = $this->input->post('s_header_bg_type');
				$body_bg_type = $this->input->post('s_body_bg_type');
				$this->page_data['img_error'] = array(); 
				$header_bg = '';
				$body_bg = '';
				$logo = '';
				$no_upload_error = true;
				if((strcasecmp($header_bg_type, 'picture') == 0 && empty($company_data['s_header_bg_type'])) || (strcasecmp($body_bg_type, 'picture') == 0 && empty($company_data['s_body_bg_type'])) || !empty($_FILES['s_header_logo']['name'])) // WE have files to upload
				{
					$uploaded = $this->upload->up(TRUE);
					if((empty($uploaded) || $uploaded == false)) //no file was uploaded
					{
						$no_upload_error = false;
						if(strcasecmp($header_bg_type, 'picture') == 0)
							$this->page_data['img_error']['header'] = '<span class="error">You did not select an image to upload.</span>';
						if(strcasecmp($body_bg_type, 'picture') == 0)
							$this->page_data['img_error']['body'] = '<span class="error">You did not select an image to upload.</span>';
						if(!empty($_FILES['s_header_logo']['name']))
							$this->page_data['img_error']['logo'] = '<span class="error">You did not select an image to upload.</span>';
					}
					else //at least one file was uploaded
					{
						if(!empty($uploaded['error'])) //in case of errors during uploads
						{
							$up_errors = $uploaded['error'];
							foreach($up_errors as $up_err)
							{
								if($up_err['file_input'] == 's_header_bg_pic' && strcasecmp($header_bg_type, 'picture') == 0) //if we choose to upload a header bg picture and the error was on it
								{
									$up_err['error_msg'] = str_replace('<p>', '<span class="error">', $up_err['error_msg']);
									$up_err['error_msg'] = str_replace('</p>', '</span>', $up_err['error_msg']);
									$this->page_data['img_error']['header'] = $up_err['error_msg'];
									$no_upload_error = false;
								}
								elseif($up_err['file_input'] == 's_body_bg_pic' && strcasecmp($body_bg_type, 'picture') == 0) //if we choose to upload a body bg picture and the error was on it
								{
									$up_err['error_msg'] = str_replace('<p>', '<span class="error">', $up_err['error_msg']);
									$up_err['error_msg'] = str_replace('</p>', '</span>', $up_err['error_msg']);
									$this->page_data['img_error']['body'] = $up_err['error_msg'];
									$no_upload_error = false;
								}
								elseif($up_err['file_input'] == 's_header_logo' && !empty($_FILES['s_header_logo']['name']))
								{
									$up_err['error_msg'] = str_replace('<p>', '<span class="error">', $up_err['error_msg']);
									$up_err['error_msg'] = str_replace('</p>', '</span>', $up_err['error_msg']);
									$this->page_data['img_error']['logo'] = $up_err['error_msg'];
									$no_upload_error = false;
								}
							}
						}
						if(empty($uploaded['success']))
						{
							$no_upload_error = false;
						}
						else
						{
							$images = $uploaded['success'];
							foreach($images as $img)
							{
								if(strcmp($img['file_input'], 's_header_bg_pic') == 0 && strcasecmp($header_bg_type, 'picture') == 0)
								{
									$img_name = $img['file_name'];
									$ext = substr($img_name, strrpos($img_name, '.'));
									$new_name = 'header_bg_'.$target_id.$ext;
									$filenew = rename(UPLOAD_DIR.$img_name, UPLOAD_DIR.$new_name);
									$header_bg = $new_name;
								}
								elseif(strcmp($img['file_input'], 's_body_bg_pic') == 0 && strcasecmp($body_bg_type, 'picture') == 0)
								{
									$img_name = $img['file_name'];
									$ext = substr($img_name, strrpos($img_name, '.'));
									$new_name = 'body_bg_'.$target_id.$ext;
									$filenew = rename(UPLOAD_DIR.$img_name, UPLOAD_DIR.$new_name);
									$body_bg = $new_name;
								}
								elseif(strcmp($img['file_input'], 's_header_logo') == 0)
								{
									$img_name = $img['file_name'];
									$ext = substr($img_name, strrpos($img_name, '.'));
									$new_name = 'logo_'.$target_id.$ext;
									$filenew = rename(UPLOAD_DIR.$img_name, UPLOAD_DIR.$new_name);
									$logo = $new_name;
								}
							}
							if(strcasecmp($header_bg_type, 'picture') == 0 && empty($header_bg) && empty($company_data['s_header_bg_type']))
							{
								$no_upload_error = false;
								$this->page_data['img_error']['header'] = '<span class="error">There was an error uploading this picture.</span>';
							}
							elseif(strcasecmp($body_bg_type, 'picture') == 0 && empty($body_bg) && empty($company_data['s_body_bg_type']))
							{
								$no_upload_error = false;
								$this->page_data['img_error']['body'] = '<span class="error">There was an error uploading this picture.</span>';
							}elseif(!empty($_FILES['s_header_logo']['name']) && empty($logo))
							{
								$no_upload_error = false;
								$this->page_data['img_error']['logo'] = '<span class="error">There was an error uploading this picture.</span>';
							}
						}
					}
				}
					
				if($this->form_validation->run() && $no_upload_error)
				{
					$company_new_data = array();
					//style
						
					$field = $this->input->post('s_header_fcolor');
					if(!empty($field) && strcmp(strtolower($field), strtolower(S_HEADER_FCOLOR)) != 0)
						$company_new_data['s_header_fcolor'] = $field;
					else
						$company_new_data['s_header_fcolor'] = '';
						
					$field = $this->input->post('s_header_ffamily');
					if(!empty($field) && strcmp(strtolower($field), strtolower(S_HEADER_FFAMILY)) != 0)
						$company_new_data['s_header_ffamily'] = $field;
					else
						$company_new_data['s_header_ffamily'] = '';
						
					$field = $this->input->post('s_header_fsize');
					if(!empty($field) && strcmp(strtolower($field), strtolower(S_HEADER_FSIZE)) != 0)
						$company_new_data['s_header_fsize'] = $field;
					else
						$company_new_data['s_header_fsize'] = '';
						
					$field = $this->input->post('s_labels_fcolor');
					if(!empty($field) && strcmp(strtolower($field), strtolower(S_LABELS_FCOLOR)) != 0)
						$company_new_data['s_labels_fcolor'] = $field;
					else
						$company_new_data['s_labels_fcolor'] = '';
						
					$field = $this->input->post('s_labels_ffamily');
					if(!empty($field) && strcmp(strtolower($field), strtolower(S_LABELS_FFAMILY)) != 0)
						$company_new_data['s_labels_ffamily'] = $field;
					else
						$company_new_data['s_labels_ffamily'] = '';
					$field = $this->input->post('s_labels_fsize');
					if(!empty($field) && strcmp(strtolower($field), strtolower(S_LABELS_FSIZE)) != 0)
						$company_new_data['s_labels_fsize'] = $field;
					else
						$company_new_data['s_labels_fsize'] = '';
					
					//backgrounds
					if(strcasecmp($header_bg_type, 'picture') == 0)
					{
						if(!empty($header_bg))
						{
							$company_new_data['s_header_bg_pic'] = $header_bg;
							$company_new_data['s_header_bg_type'] = 'picture';
						}
					}
					else
					{
						$company_new_data['s_header_bg_type'] = 'gradient';
						$field = $this->input->post('s_header_bg1');
						if(!empty($field) && strcmp(strtolower($field), strtolower(S_HEADER_BG1)) != 0)
							$company_new_data['s_header_bg1'] = $field;
						else
							$company_new_data['s_header_bg1'] = '';
							
						$field = $this->input->post('s_header_bg2');
						if(!empty($field) && strcmp(strtolower($field), strtolower(S_HEADER_BG2)) != 0)
							$company_new_data['s_header_bg2'] = $field;
						else
							$company_new_data['s_header_bg2'] = '';
					}
					if(strcasecmp($body_bg_type, 'picture') == 0)
					{
						if(!empty($body_bg))
						{
							$company_new_data['s_body_bg_pic'] = $body_bg;
							$company_new_data['s_body_bg_type'] = 'picture';
						}
					}
					else
					{
						$company_new_data['s_body_bg_type'] = 'gradient';
						$field = $this->input->post('s_body_bg1');
						if(!empty($field) && strcmp(strtolower($field), strtolower(S_BODY_BG1)) != 0)
							$company_new_data['s_body_bg1'] = $field;
						else
							$company_new_data['s_body_bg1'] = '';
							
						$field = $this->input->post('s_body_bg2');
						if(!empty($field) && strcmp(strtolower($field), strtolower(S_BODY_BG2)) != 0)
							$company_new_data['s_body_bg2'] = $field;
						else
							$company_new_data['s_body_bg2'] = '';
					}
					if(!empty($logo))
						$company_new_data['s_header_logo'] = $logo;
					else
					{
						$field = $this->input->post('s_delete_logo');
						if(!empty($field) && strcasecmp($field, 'true') == 0)
						{
							$company_new_data['s_header_logo'] = '';
						}
					}
						
					//text
					$field = $this->input->post('sms_first_reply');
					if(!empty($field))
					{
						$field = preg_replace("#&amp;#", "&", $field);
						$field = preg_replace("#;#", "", $field);
						if(strcmp($field, SMS_FIRST_REPLY) != 0)
							$company_new_data['sms_first_reply'] = $field;
						else
							$company_new_data['sms_first_reply'] = '';
					}
					$field = $this->input->post('sms_last_reply');
					if(!empty($field))
					{
						$field = preg_replace("#&amp;#", "&", $field);
						$field = preg_replace("#;#", "", $field);
						if(strcmp($field, SMS_LAST_REPLY) != 0)
							$company_new_data['sms_last_reply'] = $field;
						else
							$company_new_data['sms_last_reply'] = '';
					}
					$field = $this->input->post('qr_header');
					if(!empty($field))
					{
						$field = preg_replace("#&amp;#", "&", $field);
						$field = preg_replace("#;#", "", $field);
						if(strcmp($field, QR_HEADER) != 0)
							$company_new_data['qr_header'] = $field;
						else
							$company_new_data['qr_header'] = '';
					}
					$field = $this->input->post('qr_comment_label');
					if(!empty($field))
					{
						$field = preg_replace("#&amp;#", "&", $field);
						$field = preg_replace("#;#", "", $field);
						if(strcmp($field, QR_COMMENT_LABEL) != 0)
							$company_new_data['qr_comment_label'] = $field;
						else
							$company_new_data['qr_comment_label'] = '';
					}
					$field = $this->input->post('qr_success_text');
					if(!empty($field))
					{
						$field = preg_replace("#&amp;#", "&", $field);
						$field = preg_replace("#;#", "", $field);
						if(strcmp($field, QR_SUCCESS_TEXT) != 0)
							$company_new_data['qr_success_text'] = $field;
						else
							$company_new_data['qr_success_text'] = '';
					}
					
					//custom fields
					$m_field = $this->input->post('cf_exists');
					if(strcmp($m_field, 'false') == 0)
					{
						$company_new_data['cf_asked_for'] = 'none';
					}
					else
					{
						$company_new_data['cf_asked_for'] = $this->input->post('cf_asked_for');
						$company_new_data['cf_type'] = $this->input->post('cf_type');
						$company_new_data['cf_qr_label'] = $this->input->post('cf_qr_label');
						$company_new_data['cf_required'] = ($this->input->post('cf_required') == 'true')?1:0;
						$company_new_data['cf_pos'] = $this->input->post('cf_pos');
						$company_new_data['cf_sms_text'] = $this->input->post('cf_sms_text');
						
						$sec_field = $this->input->post('cf2_exists');
						if(strcmp($sec_field, 'false') == 0)
						{
							$custom_field['cf_asked_for'] = 'none';
						}
						else
						{
							$company_new_data['cf2_asked_for'] = 'qr';
							$company_new_data['cf2_type'] = $this->input->post('cf2_type');
							$company_new_data['cf2_qr_label'] = $this->input->post('cf2_qr_label');
							$company_new_data['cf2_required'] = ($this->input->post('cf2_required') == 'true')?1:0;
							$company_new_data['cf2_pos'] = $this->input->post('cf2_pos');
						}
					}
						
					$this->companies->edit($target_id, $company_new_data);
					$this->edit_sms_qr_scripts($target_id, 'The changes you requested were successfully submitted for '.$company_data['name']);
					
				}
				else
				{
					$this->edit_sms_qr_scripts($target_id, '', $this->page_data['img_error']);
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
	
	
	public function manage_locations($target_id = NULL, $reply = "")
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$target_data = $this->companies->get_by_id($target_id);
			if(!empty($target_data))
			{
				$this->page_data['sub_current'] = 'manage_companies';
				$this->page_data['current_path'] = array("Manage Companies"=>"admin_companies", "Manage ".$target_data['name']." Locations"=>"admin_companies/manage_locations/".$target_id);
				$this->page_data["reply"] = $reply;
				$this->page_data["company_data"] = $target_data;
				
				$locations = $this->locations->list_records(array('company_id'=>$target_id));
				$i = 0;
				foreach($locations as $loc)
				{
					$locations[$i]->codes = $this->codes->list_records(array('location_id'=>$loc->ID));
					$i++;
				}
				$this->page_data["locations"] = $locations;
				
				$this->load->view('admin_panel/header', $this->page_data);
				$this->load->view('admin_panel/sub_menu');
				$this->load->view('admin_panel/admin_companies/list_locations');
				$this->load->view('general/footer');
			}
			else
				redirect('error/something_went_wrong');
		}
		else
		{
			redirect('error/must_sign_up_as_admin');
		}
	}
	
	public function add_location($company_id, $error = '')
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$company_data = $this->companies->get_by_id($company_id);
			if(!empty($company_data))
			{
				$this->page_data['sub_current'] = 'manage_companies';
				$this->page_data['current_path'] = array("Manage Companies"=>"admin_companies", "Manage ".$company_data['name']." Locations"=>"admin_companies/manage_locations/".$company_id, "Add a New Company"=>"admin_companies/add_location/".$company_id);
				$this->page_data['other_errors'] = $error;
				$this->page_data['company_data'] = $company_data;
				
				$this->load->view('admin_panel/header', $this->page_data);
				$this->load->view('admin_panel/sub_menu');
				$this->load->view('admin_panel/admin_companies/add_location');
				$this->load->view('general/footer');
			}
			else
				redirect('error/something_went_wrong');
		}
		else
		{
			redirect('error/must_sign_up_as_admin');
		}
	}
	
	public function submit_add_location($company_id)
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$company_data = $this->companies->get_by_id($company_id);
			if(!empty($company_data))
			{
				$this->form_validation->set_rules('locations_number', 'Locations Number', 'trim|encode_php_tags|xss_clean');
				
				//locations
				$n_locations = $this->input->post('locations_number');
				$codes = array();
				//echo $n_locations.' : locations number<br/>';
				for($i = 1; $i <= $n_locations; $i++)
				{
					$this->form_validation->set_rules('name_'.$i, 'Location '.$i.' name', 'trim|required|is_unique[locations.name]|max_length[50]|encode_php_tags|xss_clean');
					$this->form_validation->set_rules('timezone_'.$i, 'Location '.$i.' timezone', 'trim|required|max_length[20]|encode_php_tags|xss_clean');
					$this->form_validation->set_rules('address_'.$i, 'Location '.$i.' address', 'trim|max_length[100]|encode_php_tags|xss_clean');
					$this->form_validation->set_rules('state_'.$i, 'Location '.$i.' state', 'trim|max_length[20]|encode_php_tags|xss_clean');
					$this->form_validation->set_rules('city_'.$i, 'Location '.$i.' city', 'trim|max_length[20]|encode_php_tags|xss_clean');
					$this->form_validation->set_rules('zipcode_'.$i, 'Location '.$i.' zipcode', 'trim|max_length[20]|encode_php_tags|xss_clean');
					$this->form_validation->set_rules('website_'.$i, 'Location '.$i.' website', 'trim|max_length[50]|encode_php_tags|xss_clean');
					
					$this->form_validation->set_rules('codes_'.$i.'_number', 'Location '.$i.' number of codes', 'trim|required|encode_php_tags|xss_clean');
					
					//codes
					$n_codes = $this->input->post('codes_'.$i.'_number');
					//echo $n_codes.' : codes_'.$i.'_number<br/>';
					for($j = 1; $j <= $n_codes; $j++)
					{
						$this->form_validation->set_rules('code_'.$i.'_'.$j, 'Location '.$i.' code '.$j, 'trim|required|is_unique[codes.code]|max_length[20]|encode_php_tags|xss_clean');
						$this->form_validation->set_rules('code_'.$i.'_'.$j.'_desc', 'Location '.$i.' code '.$j.' description', 'trim|max_length[100]|encode_php_tags|xss_clean');
						
						$codes[] = $this->input->post('code_'.$i.'_'.$j);
					}
				}
				
				$unique_codes = array_unique($codes);
				$codes_are_distinct = true;
				if(count($unique_codes) != count($codes))
					$codes_are_distinct = false;
			
				if($this->form_validation->run() && $codes_are_distinct)
				{
					for($i = 1; $i <= $n_locations; $i++)
					{
						$location_data = array('name'=>$this->input->post('name_'.$i), 
																	 'timezone'=>$this->input->post('timezone_'.$i),
																	 'address'=>$this->input->post('address_'.$i),
																	 'state'=>$this->input->post('state_'.$i),
																	 'city'=>$this->input->post('city_'.$i),
																	 'zipcode'=>$this->input->post('zipcode_'.$i),
																	 'website'=>$this->input->post('website_'.$i),
																	 'business_type'=> $company_data['business_type'],
																	 'is_active'=> 1,
																	 'company_id'=> $company_id);
																	 
						$location_id = $this->locations->add($location_data);
						
						$n_codes = $this->input->post('codes_'.$i.'_number');
						for($j = 1; $j <= $n_codes; $j++)
						{
							$code_data = array('code'=>$this->input->post('code_'.$i.'_'.$j), 
																 'description'=>$this->input->post('code_'.$i.'_'.$j.'_desc'),
																 'location_id'=> $location_id,
																 'company_id'=> $company_id);
																 
							$code_id = $this->codes->add($code_data);
						}
					}
					
					
					$this->index("You have successfully registred ".$n_locations." locations for <strong>".$company_data['name']."</strong>.");
				}
				else
				{
					if($codes_are_distinct)
						$this->add_location($company_id);
					else
						$this->add_location($company_id, 'The codes you entered are not distinct!');
				}
			}
			else
				redirect('error/something_went_wrong');
		}
		else
		{
			redirect('error/must_sign_up_as_admin');
		}
	}
	
	public function edit_location($location_id, $error = '')
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$location_data = $this->locations->get_by_id($location_id);
			if(!empty($location_data))
			{
				$company_data = $this->companies->get_by_id($location_data['company_id']);
				$this->page_data['sub_current'] = 'manage_companies';
				$this->page_data['current_path'] = array("Manage Companies"=>"admin_companies", "Manage ".$company_data['name']." Locations"=>"admin_companies/manage_locations/".$location_data['company_id'], "Edit location: ".$location_data['name']=>"admin_companies/edit_location/".$location_id);
				$this->page_data['company_data'] = $company_data;
				$this->page_data['other_errors'] = $error;
				
				$location_data['codes'] = $this->codes->list_records(array('location_id'=>$location_id));
				
				$this->page_data['location_data'] = $location_data;
				
				$this->load->view('admin_panel/header', $this->page_data);
				$this->load->view('admin_panel/sub_menu');
				$this->load->view('admin_panel/admin_companies/edit_location');
				$this->load->view('general/footer');
			}
			else
				redirect('error/something_went_wrong');
		}
		else
		{
			redirect('error/must_sign_up_as_admin');
		}
	}
	
	public function submit_edit_location($location_id) //deleting codes comments not done yet
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$location_data = $this->locations->get_by_id($location_id);
			$location_data['codes'] = $this->codes->list_records(array('location_id'=>$location_id));
			if(!empty($location_data))
			{
				$codes = array();
				$this->form_validation->set_rules('name', 'Location name', 'trim|required|callback__is_unique_if_new[locations.name.'.$location_data['name'].']|max_length[50]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('timezone', 'Location timezone', 'trim|required|max_length[20]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('address', 'Location address', 'trim|max_length[100]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('state', 'Location state', 'trim|max_length[20]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('city', 'Location city', 'trim|max_length[20]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('zipcode', 'Location zipcode', 'trim|max_length[20]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('website', 'Location website', 'trim|max_length[50]|encode_php_tags|xss_clean');
					
				$this->form_validation->set_rules('codes_number', 'number of codes', 'trim|required|encode_php_tags|xss_clean');
					
				//codes
				$n_codes = $this->input->post('codes_number');
				for($j = 1; $j <= $n_codes; $j++)
				{
					$this->form_validation->set_rules('code_'.$j, 'code '.$j, 'trim|required|max_length[20]|encode_php_tags|xss_clean');
					$this->form_validation->set_rules('code_'.$j.'_desc', 'code '.$j.' description', 'trim|max_length[100]|encode_php_tags|xss_clean');
					
					$codes[] = strtoupper($this->input->post('code_'.$j));
				}
				
				//we check if the codes submitted doesn't have any repeated code
				$unique_codes = array_unique($codes);
				$codes_are_distinct = true;
				if(count($unique_codes) != count($codes))
					$codes_are_distinct = false;
					
				$codes_are_unique = false;
				if($codes_are_distinct)//we check if the codes submitted are unique in the database if they're new
				{
					foreach($location_data['codes'] as $old_code)
					{
						$new_codes[$old_code->code] = true;
						if(($key = array_search($old_code->code, $codes)) !== false)
						{
							unset($codes[$key]);
							$new_codes[$old_code->code] = false;
						}
						
						$list_of_codes[$old_code->code] = (array) $old_code;
					}
					if(empty($codes))
						$codes_are_unique = true;
					else
					{
						foreach($codes as $code)
						{
							$codes_are_unique = $this->form_validation->is_unique($code, 'codes.code');
							//echo $code;
						}
					}
				}
				
			
				if($this->form_validation->run() && $codes_are_unique)
				{
					$location_new_data = array('name'=>$this->input->post('name'), 
																 'timezone'=>$this->input->post('timezone'),
																 'address'=>$this->input->post('address'),
																 'state'=>$this->input->post('state'),
																 'city'=>$this->input->post('city'),
																 'zipcode'=>$this->input->post('zipcode'),
																 'website'=>$this->input->post('website'));
																 
					$this->locations->edit($location_id, $location_new_data);
					
					//codes to delete
					foreach($new_codes as $nc => $delete)
					{
						if($delete)
						{
							echo 'this code is deleted : '.$nc.'<br/>';
							$this->codes->delete_by_code($nc);
						}
					}
	
					//codes to edit or add
					$n_codes = $this->input->post('codes_number');
					for($j = 1; $j <= $n_codes; $j++)
					{
						$code_data = array('code'=>$this->input->post('code_'.$j), 
															 'description'=>$this->input->post('code_'.$j.'_desc'),
															 'location_id'=> $location_id,
															 'company_id'=> $location_data['company_id']);
						
						if(empty($list_of_codes[strtoupper($code_data['code'])]))								 
							$this->codes->add($code_data);
						else
						{
							if($list_of_codes[strtoupper($code_data['code'])]['description'] != $code_data['description'])
								$this->codes->edit($list_of_codes[strtoupper($code_data['code'])]['ID'], $code_data);
						}
					}
					
					
					$this->manage_locations($location_data['company_id'], "The changes you requested have been successfully submitted for ".$location_data['name']);
				}
				else
				{
					if($codes_are_unique)
						$this->edit_location($location_id);
					elseif($codes_are_distinct)
						$this->edit_location($location_id, 'The codes you entered are not unique!');
					else
						$this->edit_location($location_id, 'The codes you entered are not distinct!');
				}
			}
			else
				redirect('error/something_went_wrong');
		}
		else
		{
			redirect('error/must_sign_up_as_admin');
		}
	}
	
	public function activate_location($target_id)
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$target_data = $this->locations->get_by_id($target_id);
			if(!empty($target_data))
			{
				$new_data['is_active'] = 1;
				$this->locations->edit($target_id, $new_data);
				$this->manage_locations($target_data['company_id'], 'The location '.$target_data['name'].' Was Successfully activated. All the codes that belong to it can now receive feedback!');
			}
			else
				redirect('error/something_went_wrong');
		}
		else
			redirect('error/must_sign_up_as_admin');
	}
	
	public function deactivate_location($target_id)
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$target_data = $this->locations->get_by_id($target_id);
			if(!empty($target_data))
			{
				$new_data['is_active'] = 0;
				$this->locations->edit($target_id, $new_data);
				$this->manage_locations($target_data['company_id'], 'The location '.$target_data['name'].' is now Inactive and all the codes that belong to it won\'t be able to receive feedback!');
			}
			else
				redirect('error/something_went_wrong');
		}
		else
			redirect('error/must_sign_up_as_admin');
	}
	
	public function delete_location($target_id = NULL)
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$target_data = $this->locations->get_by_id($target_id);
			if(!empty($target_data))
			{
				$company_name = $this->companies->get_data($target_data['company_id'], 'name');
				$this->page_data['target_data'] = $target_data;
				$this->page_data['company_name'] = $company_name;
				$this->page_data['sub_current'] = 'manage_companies';
				$this->page_data['current_path'] = array("Manage Companies"=>"admin_companies", "Manage ".$company_name." Locations"=>"admin_companies/manage_locations/".$target_data['company_id'], "delete location : ".$target_data['name']=>"admin_companies/delete_location/".$target_id);
				
				$this->load->view('admin_panel/header', $this->page_data);
				$this->load->view('admin_panel/sub_menu');
				$this->load->view('admin_panel/admin_companies/delete_location');
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
	
	public function submit_delete_location($target_id = NULL) //NOT DONE YET
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$target_data = $this->locations->get_by_id($target_id);
			if(!empty($target_data))
			{
				$this->locations->delete($target_id);
				
				$reply = 'The Location : '.$target_data['name'].' was successfully deleted as well as all the codes and comments under it.';
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
	
	
	public function manage_groups($target_id = NULL, $reply = "")
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$target_data = $this->companies->get_by_id($target_id);
			if(!empty($target_data))
			{
				$this->page_data['sub_current'] = 'manage_companies';
				$this->page_data['current_path'] = array("Manage Companies"=>"admin_companies", "Manage ".$target_data['name']." Groups"=>"admin_companies/manage_groups/".$target_id);
				$this->page_data["reply"] = $reply;
				$this->page_data["company_data"] = $target_data;
				
				$locations = $this->locations->list_records(array('company_id'=>$target_id));
				$groups = $this->groups->list_records(array('company_id'=>$target_id));
				
				$groups_locations = $this->_get_groups_locations_arrays($groups, $locations);
				$hierarchy = $this->_get_company_hierarchy($groups_locations['groups'], $groups_locations['locations']);
				//$table_content = $this->_get_hierarchy_table_content($hierarchy); //get info ready for table
				//$list_content = $this->_get_hierarchy_list_content($hierarchy); //get info ready for table
				//echo '<pre>'.print_r($hierarchy, true).'</pre>';
					
				$this->page_data["groups"] = $groups;
				$this->page_data["hierarchy"] = $hierarchy;
				
				$this->load->view('admin_panel/header', $this->page_data);
				$this->load->view('admin_panel/sub_menu');
				$this->load->view('admin_panel/admin_companies/list_groups');
				$this->load->view('general/footer');
			}
			else
				redirect('error/something_went_wrong');
		}
		else
		{
			redirect('error/must_sign_up_as_admin');
		}
	}
	
	public function add_group($company_id, $error = '')
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$company_data = $this->companies->get_by_id($company_id);
			if(!empty($company_data))
			{
				$this->page_data['sub_current'] = 'manage_companies';
				$this->page_data['current_path'] = array("Manage Companies"=>"admin_companies", "Manage ".$company_data['name']." Groups"=>"admin_companies/manage_groups/".$company_id, "Add a New Group"=>"admin_companies/add_group/".$company_id);
				$this->page_data['other_errors'] = $error;
				
				$locations = $this->locations->list_records(array('company_id'=>$company_id));
				$groups = $this->groups->list_records(array('company_id'=>$company_id));
				$group_types = array();
				foreach($groups as $g)
					$group_types[] = $g->type;
				$group_types = array_unique($group_types);
				
				$this->page_data["locations"] = $locations;
				$this->page_data["groups"] = $groups;
				$this->page_data["group_types"] = $group_types;
				$this->page_data['company_data'] = $company_data;
				
				$groups_locations = $this->_get_groups_locations_arrays($groups, $locations);
				$hierarchy = $this->_get_company_hierarchy($groups_locations['groups'], $groups_locations['locations']);
				$this->page_data['hierarchy'] = $hierarchy;
				
				$this->load->view('admin_panel/header', $this->page_data);
				$this->load->view('admin_panel/sub_menu');
				$this->load->view('admin_panel/admin_companies/add_group');
				$this->load->view('general/footer');
			}
			else
				redirect('error/something_went_wrong');
		}
		else
		{
			redirect('error/must_sign_up_as_admin');
		}
	}
	
	public function submit_add_group($company_id)
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$company_data = $this->companies->get_by_id($company_id);
			if(!empty($company_data))
			{
				$this->form_validation->set_rules('name', 'Group Name', 'trim|required|is_unique[groups.name]|max_length[50]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('type', 'Group Type', 'trim|required|max_length[20]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('locations[]', 'Group Locations', 'encode_php_tags|xss_clean');
				$this->form_validation->set_rules('subgroups[]', 'Group subgroups', 'encode_php_tags|xss_clean');
				$this->form_validation->set_rules('filtred_locations', 'Group Locations', 'encode_php_tags|xss_clean');
				$this->form_validation->set_rules('filtred_subgroups', 'Group subgroups', 'encode_php_tags|xss_clean');
				$this->form_validation->set_rules('has_parent', 'has parent', 'encode_php_tags|xss_clean');
			
				//var_dump($this->input->post());
			
				if($this->form_validation->run())
				{
					$subgroups = explode(',', $this->input->post('filtred_subgroups'));
					$sublocations = explode(',', $this->input->post('filtred_locations'));
					if(empty($subgroups[0]))
						$subgroups = array();
					if(empty($sublocations[0]))
						$sublocations = array();
					$groups = $this->groups->list_records(array('company_id'=>$company_id));
					$locations = $this->locations->list_records(array('company_id'=>$company_id));
					$groups_locations = $this->_get_groups_locations_arrays($groups, $locations);
					
					$group_data = array('name'=>$this->input->post('name'), 
															'type'=>$this->input->post('type'),
															'has_parent'=>(int)$this->input->post('has_parent'),
															'company_id'=> $company_id);
					 
					//var_dump($group_data);
					$group_id = $this->groups->add($group_data);
					
					foreach($sublocations as $loc)
					{
						$this->groups->unbind_location_from_parent($loc);
						$this->groups->bind_location($group_id, $loc);
						if(!empty($groups_locations['locations'][$loc]['parent']))
							$parent_id = $groups_locations['locations'][$loc]['parent'];
					}
					foreach($subgroups as $sg)
					{
						$this->groups->unbind_subgroup_from_parent($sg);
						$this->groups->bind_subgroup($group_id, $sg);
						$this->groups->edit($sg, array('has_parent' => 1));
						if(!empty($groups_locations['groups'][$sg]['parent']))
							$parent_id = $groups_locations['groups'][$sg]['parent'];
					}
					if($group_data['has_parent'])
					{
						$this->groups->bind_subgroup($parent_id, $group_id);
					}
					
					$this->manage_groups($company_id, "You have successfully added ".count($sublocations)." location(s) and ".count($subgroups)." sub group(s) to the new Group <strong>".$group_data['name']."</strong>.");
				}
				else
				{
					$this->add_group($company_id);
				}
			}
			else
				redirect('error/something_went_wrong');
		}
		else
		{
			redirect('error/must_sign_up_as_admin');
		}
	}
	
	public function edit_group($group_id, $error = '')
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$group_data = $this->groups->get_by_id($group_id);
			if(!empty($group_data))
			{
				$company_data = $this->companies->get_by_id($group_data['company_id']);
				$this->page_data['sub_current'] = 'manage_companies';
				$this->page_data['current_path'] = array("Manage Companies"=>"admin_companies", "Manage ".$company_data['name']." Groups"=>"admin_companies/manage_groups/".$group_data['company_id'], "Edit Group: ".$group_data['name']=>"admin_companies/edit_group/".$group_id);
				$this->page_data['other_errors'] = $error;
				
				$this->page_data['group_data'] = $group_data;
				
				$locations = $this->locations->list_records(array('company_id'=>$group_data['company_id']));
				$groups = $this->groups->list_records(array('company_id'=>$group_data['company_id']));
				$group_types = array();
				foreach($groups as $g)
					$group_types[] = $g->type;
				$group_types = array_unique($group_types);
				
				$this->page_data["locations"] = $locations;
				$this->page_data["groups"] = $groups;
				$this->page_data["group_types"] = $group_types;
				$this->page_data['company_data'] = $company_data;
				
				$groups_locations = $this->_get_groups_locations_arrays($groups, $locations);
				$hierarchy = $this->_get_company_hierarchy($groups_locations['groups'], $groups_locations['locations'], $group_id);
				$this->page_data['hierarchy'] = $hierarchy;
				
				$locations_to_add = array();
				$groups_to_add = array();
				//locations and subgroups we can add to target group: - groups or locatiosn that have the same parent, groups and locations that have no parents, (locations that belong directly to a grand parent)
				foreach($groups_locations['locations'] as $l)
				{
					if(empty($l['parent']) || (!empty($l['parent']) && !empty($groups_locations['groups'][$group_id]['parent']) && $l['parent'] == $groups_locations['groups'][$group_id]['parent']))
						$locations_to_add[] = $l;
				}
				foreach($groups_locations['groups'] as $g)
				{
					if(($g['ID'] != $group_id)&&(!$this->_is_grandparent($group_id, $g['ID'], $groups_locations['groups']))&&(empty($g['parent']) || (!empty($g['parent']) && !empty($groups_locations['groups'][$group_id]['parent']) && $g['parent'] == $groups_locations['groups'][$group_id]['parent'])))
							$groups_to_add[] = $g;
				}
				
				$this->page_data['other_locations'] = $locations_to_add;
				$this->page_data['other_groups'] = $groups_to_add;
				
				$this->load->view('admin_panel/header', $this->page_data);
				$this->load->view('admin_panel/sub_menu');
				$this->load->view('admin_panel/admin_companies/edit_group');
				$this->load->view('general/footer');
			}
			else
				redirect('error/something_went_wrong');
		}
		else
		{
			redirect('error/must_sign_up_as_admin');
		}
	}
	
	public function submit_edit_group($target_id)
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$target_data = $this->groups->get_by_id($target_id);
			if(!empty($target_data))
			{
				$this->form_validation->set_rules('name', 'Group Name', 'trim|required|callback__is_unique_if_new[groups.name.'.$target_data['name'].']|max_length[50]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('type', 'Group Type', 'trim|required|max_length[20]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('locations[]', 'Group Locations', 'encode_php_tags|xss_clean');
				$this->form_validation->set_rules('subgroups[]', 'Group subgroups', 'encode_php_tags|xss_clean');
				$this->form_validation->set_rules('filtred_locations', 'Group Locations', 'encode_php_tags|xss_clean');
				$this->form_validation->set_rules('filtred_subgroups', 'Group subgroups', 'encode_php_tags|xss_clean');
				$this->form_validation->set_rules('has_parent', 'has parent', 'encode_php_tags|xss_clean');
			
				if($this->form_validation->run())
				{
					$subgroups = explode(',', $this->input->post('filtred_subgroups'));
					$sublocations = explode(',', $this->input->post('filtred_locations'));
					if(empty($subgroups[0]))
						$subgroups = array();
					if(empty($sublocations[0]))
						$sublocations = array();
					$groups = $this->groups->list_records(array('company_id'=>$target_data['company_id']));
					$locations = $this->locations->list_records(array('company_id'=>$target_data['company_id']));
					$groups_locations = $this->_get_groups_locations_arrays($groups, $locations);
					
					$new_group_data = array('name'=>$this->input->post('name'), 
															'type'=>$this->input->post('type'),
															'company_id'=> $target_data['company_id']);
					 
					//removing old group connections
					if(!$target_data['has_parent'])
					{
						//children subgroups should have has_parent = 0 since we are deleting the parent's connections
						foreach($groups_locations['groups'] as $g)
							if(!empty($g['parent']) && $g['parent'] == $target_id)
								$this->groups->edit($g['ID'], array('has_parent' => 0));
						$this->groups->unbind_all($target_id);
					}
					else
					{
						//children subgroups should be binded to the group's parent since we are deleting the group's connections
						foreach($groups_locations['groups'] as $g)
							if(!empty($g['parent']) && $g['parent'] == $target_id)
								$this->groups->bind_subgroup($groups_locations['groups'][$target_id]['parent'], $g['ID']);
						foreach($groups_locations['locations'] as $l)
							if(!empty($l['parent']) && $l['parent'] == $target_id)
								$this->groups->bind_location($groups_locations['groups'][$target_id]['parent'], $l['ID']);
						$this->groups->unbind_all($target_id);
						$this->groups->unbind_subgroup_from_parent($target_id);
					}
					
					//adding new group connections
					$this->groups->edit($target_id, $new_group_data);
					$groups = $this->groups->list_records(array('company_id'=>$target_data['company_id']));
					$locations = $this->locations->list_records(array('company_id'=>$target_data['company_id']));
					$groups_locations = $this->_get_groups_locations_arrays($groups, $locations);
					
					
					foreach($sublocations as $loc)
					{
						$this->groups->unbind_location_from_parent($loc);
						$this->groups->bind_location($target_id, $loc);
						if(!empty($groups_locations['locations'][$loc]['parent']))
							$parent_id = $groups_locations['locations'][$loc]['parent'];
					}
					foreach($subgroups as $sg)
					{
						$this->groups->unbind_subgroup_from_parent($sg);
						$this->groups->bind_subgroup($target_id, $sg);
						$this->groups->edit($sg, array('has_parent' => 1));
						if(!empty($groups_locations['groups'][$sg]['parent']))
							$parent_id = $groups_locations['groups'][$sg]['parent'];
					}
					if($target_data['has_parent'])
					{
						$this->groups->bind_subgroup($parent_id, $target_id);
					}
					
					$this->manage_groups($target_data['company_id'], "The changes you requested have been successfully submitted to the group ".$target_data['name']);
				}
				else
				{
					$this->add_location($company_id);
				}
			}
			else
				redirect('error/something_went_wrong');
		}
		else
		{
			redirect('error/must_sign_up_as_admin');
		}
	}
	
	public function delete_group($target_id = NULL)
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$target_data = $this->groups->get_by_id($target_id);
			if(!empty($target_data))
			{
				$company_name = $this->companies->get_data($target_data['company_id'], 'name');
				$this->page_data['target_data'] = $target_data;
				$this->page_data['company_name'] = $company_name;
				$this->page_data['sub_current'] = 'manage_companies';
				$this->page_data['current_path'] = array("Manage Companies"=>"admin_companies", "Manage ".$company_name." Groups"=>"admin_companies/manage_groups/".$target_data['company_id'], "delete Group : ".$target_data['name']=>"admin_companies/delete_group/".$target_id);
				
				$groups = $this->groups->list_records(array('company_id'=>$target_data['company_id']));
				$locations = $this->locations->list_records(array('company_id'=>$target_data['company_id']));
				$groups_locations = $this->_get_groups_locations_arrays($groups, $locations);
				var_dump($groups_locations);
				
				$this->load->view('admin_panel/header', $this->page_data);
				$this->load->view('admin_panel/sub_menu');
				$this->load->view('admin_panel/admin_companies/delete_group');
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
		
	public function submit_delete_group($target_id = NULL)
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$target_data = $this->groups->get_by_id($target_id);
			if(!empty($target_data))
			{
				$groups = $this->groups->list_records(array('company_id'=>$target_data['company_id']));
				$locations = $this->locations->list_records(array('company_id'=>$target_data['company_id']));
				$groups_locations = $this->_get_groups_locations_arrays($groups, $locations);
				
				if(!$target_data['has_parent'])
				{
					//children subgroups should have has_parent = 0 since we are deleting the parent
					foreach($groups_locations['groups'] as $g)
						if(!empty($g['parent']) && $g['parent'] == $target_id)
							$this->groups->edit($g['ID'], array('has_parent' => 0));
					$this->groups->unbind_all($target_id);
					$this->groups->delete($target_id);
				}
				else
				{
					//children subgroups should be binded to the group's parent since we are deleting the group
					foreach($groups_locations['groups'] as $g)
						if(!empty($g['parent']) && $g['parent'] == $target_id)
							$this->groups->bind_subgroup($groups_locations['groups'][$target_id]['parent'], $g['ID']);
					foreach($groups_locations['locations'] as $l)
						if(!empty($l['parent']) && $l['parent'] == $target_id)
							$this->groups->bind_location($groups_locations['groups'][$target_id]['parent'], $l['ID']);
					$this->groups->unbind_all($target_id);
					$this->groups->unbind_subgroup_from_parent($target_id);
					$this->groups->delete($target_id);
				}
				
				$reply = 'The Group : '.$target_data['name'].' was successfully deleted.';
				$this->manage_groups($target_data['company_id'], $reply);
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
	
	public function _get_groups_locations_arrays($groups, $locations)
	{
		$locations_array = array();
		foreach($locations as $loc)
			$locations_array[$loc->ID] = (array) $loc;
		
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
	
	public function _is_unique_if_new($str, $field)
	{
		if(!empty($str))
		{
			list($table, $item, $old_data) = explode('.', $field, 3);
			if($table == 'codes')
			{
			}
			else
			{
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
		}
		else
			return true;
	}
	
}