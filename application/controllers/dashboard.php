<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller 
{
	protected $page_data;
	protected $client_id;
	protected $client;
	protected $client_rights;
	//arrays of IDs
	protected $c_companies; //client companies full access
	protected $c_groups; //client groups full access not belong to companies
	protected $c_locations; //client locations full access not belong to companies or groups
	protected $cg_locations; //client locations full access not belong to companies but can to groups
	protected $c_codes; //client codes full access not belong to companies, groups and locations
	protected $all_groups; //all client's groups full access (also the one included in companies)
	protected $all_locations; //all client's locations full access (also the ones included in companies and groups)
	protected $all_codes; //all client's codes  full access (also the ones included in companies, groups and locations)
	protected $where; //client's where clause to select feedback that belongs to him/her
	//arrays of IDS => items
	protected $pa_companies; //All companies full or partial access
	protected $pa_locations; //all locations full or partial access
	protected $pa_codess; //all codes as an array of codes and their info
	
	protected $site_groups; //site groups
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('users_model', 'users');
		$this->load->model('locations_model', 'locations');
		$this->load->model('comments_model', 'comments');
		$this->load->model('codes_model', 'codes');
		$this->load->model('companies_model', 'companies');
		$this->load->model('groups_model', 'groups');
		$this->load->model('pages_data_model');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		
		$this->page_data = array();
		$this->page_data['title'] = 'Tell The Boss - Dashboard';
		$this->page_data['current'] = 'dashboard';
		$this->client_id = $this->session->userdata('user_id');
		$this->client = $this->users->get_by_id($this->client_id);
		$this->page_data['username'] = $this->client['username'];
		$this->client_rights = $this->users->get_rights($this->client_id);
		$this->c_companies = array();
		$this->c_groups = array();
		$this->c_locations = array();
		$this->cg_locations = array();
		$this->c_codes = array();
		
		foreach($this->client_rights as $cr)
		{
			if(strcasecmp($cr['target_type'], 'company') == 0)
				$this->c_companies[] = $cr[$cr['target_type'].'_id'];
			if(strcasecmp($cr['target_type'], 'group') == 0)
				$this->c_groups[] = $cr[$cr['target_type'].'_id'];
			if(strcasecmp($cr['target_type'], 'location') == 0)
				$this->c_locations[] = $cr[$cr['target_type'].'_id'];
			if(strcasecmp($cr['target_type'], 'code') == 0)
				$this->c_codes[] = $cr[$cr['target_type'].'_id'];
		}
		$this->all_groups = $this->c_groups;
		$this->all_locations = $this->c_locations;
		$this->all_g_locations = $this->c_locations;
		$this->all_codes = $this->c_codes;
		foreach($this->c_companies as $c)
		{
			$gs = $this->groups->list_records(array('company_id'=>$c));
			$ls = $this->locations->list_records(array('company_id'=>$c));
			foreach($gs as $g)
				if(!in_array($g->ID, $this->all_groups))
					$this->all_groups[] = $g->ID;
			foreach($gs as $g)
			{
				$gls = $this->groups->get_binded_locations($g->ID);
				foreach($gls as $gl)
					if(!in_array($gl['location_id'], $this->all_locations))
						$this->all_locations[] = $gl['location_id'];
			}
			foreach($ls as $l)
				if(!in_array($l->ID, $this->all_locations))
					$this->all_locations[] = $l->ID;
		}
		foreach($this->c_groups as $g)
		{
			$gls = $this->groups->get_binded_locations($g);
			foreach($gls as $gl)
				if(!in_array($gl['location_id'], $this->all_locations))
				{
					$this->cg_locations[] = $gl['location_id'];
					$this->all_locations[] = $gl['location_id'];
				}
		}
		foreach($this->all_locations as $l)
		{
			$cs = $this->codes->list_records(array('location_id'=>$l));
			foreach($cs as $c)
				if(!in_array($c->ID, $this->all_codes))
				{
					$this->all_codes[] = $c->ID;
				}
		}
		$this->where = '';
		foreach($this->c_companies as $c)
			$this->where .= "`comments`.`company_id` = '".$c."' OR ";
		foreach($this->cg_locations as $l)
			$this->where .= "`comments`.`location_id` = '".$l."' OR ";
		foreach($this->c_codes as $c)
			$this->where .= "`comments`.`code_id` = '".$c."' OR ";
		
		if(!empty($this->where))
			$this->where = substr($this->where, 0, -4);
		else
			$this->where = "(`comments`.`company_id` < '0') ";
			
		$all_companies = $this->companies->list_by_id(array(), 0, 0, 'name', 'asc');
		$all_groups = $this->groups->list_by_id(array(), 0, 0, 'name', 'asc');
		$all_locations = $this->locations->list_by_id(array(), 0, 0, 'name', 'asc');
		$all_codes = $this->codes->list_by_id(array(), 0, 0, 'code', 'asc');
		
		$this->site_groups = $all_groups;
		
		$this->pa_locations = array();
		foreach($this->all_locations as $id)
			$this->pa_locations[$id] = $all_locations[$id];
		foreach($this->c_codes as $id)
		{
			$l_id = $all_codes[$id]['location_id'];
			if(empty($this->pa_locations[$l_id]))
				$this->pa_locations[$l_id] = $all_locations[$l_id];
		}
		
		$this->pa_companies = array();
		foreach($this->c_companies as $id)
			$this->pa_companies[$id] = $all_companies[$id];
		foreach($this->pa_locations as $id => $loc)
		{
			$c_id = $loc['company_id'];
			if(empty($this->pa_companies[$c_id]))
				$this->pa_companies[$c_id] = $all_companies[$c_id];
		}
		foreach($this->c_groups as $id)
		{
			$c_id = $all_groups[$id]['company_id'];
			if(empty($this->pa_companies[$c_id]))
				$this->pa_companies[$c_id] = $all_companies[$c_id];
		}
		foreach($this->c_companies as $c)
		{
			$gs = $this->groups->list_records(array('company_id'=>$c));
			foreach($gs as $g)
			{
				$gls = $this->groups->get_binded_locations($g->ID);
				foreach($gls as $gl)
					$this->pa_locations[$gl['location_id']]['group_id'] = $g->ID;
			}
		}
		foreach($this->all_codes as $c)
		{
			$this->pa_codes[$c] = (array) $all_codes[$c];
		}
	}
	
	public function index($message = "", $is_error = false)
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'SUPER') == 0)
		{
			$this->page_data['sub_current'] = 'home';
			$this->page_data['current_path'] = array('home'=>'dashboard');
			if($is_error)
				$this->page_data['error'] = $message;
			else
				$this->page_data['reply'] = $message;
			
			//$stats = $this->pages_data_model->get_site_stats();
			$this->page_data['user_data'] = $this->client;
			
			$stats['companies_number'] = count($this->c_companies);
			$stats['groups_number'] = count($this->all_groups);
			$stats['locations_number'] = count($this->all_locations);
			$stats['codes_number'] = count($this->all_codes);
				
			$stats['comments_number'] = $this->comments->count($this->where);
			$stats['pos_comments_number'] = $this->comments->count("(".$this->where.") AND `nature`= 'positive'");
			$stats['neg_comments_number'] = $this->comments->count("(".$this->where.") AND `nature`= 'negative'");
			$stats['neut_comments_number'] = $this->comments->count("(".$this->where.") AND `nature`= 'neutral'");
			$stats['url_comments_number'] = $this->comments->count("(".$this->where.") AND `origin`= 'URL'"); 
			$stats['qr_comments_number'] = $this->comments->count("(".$this->where.") AND `origin`= 'QR'");
			$stats['mail_comments_number'] = $this->comments->count("(".$this->where.") AND `origin`= 'MAIL'");
			$stats['sms_comments_number'] = $this->comments->count("(".$this->where.") AND `origin`= 'SMS'");
			
			$this->page_data['stats'] = $stats;
			
			$this->load->view('dashboard/header', $this->page_data);
			$this->load->view('dashboard/sub_menu');
			$this->load->view('dashboard/overview');
			$this->load->view('general/footer');
		}
		else
		{
			redirect('error/must_sign_up');
		}
	}
	
	public function submit_edit_my_info()
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'CLIENT') == 0)
		{
			$this->form_validation->set_rules('first_name', 'first name', 'trim|min_length[2]|max_length[20]|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('last_name', 'last name', 'trim|min_length[2]|max_length[20]|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('username', 'user name', 'trim|min_length[2]|max_length[20]|alpha_dash|callback_is_unique_if_new[users.username]|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('email', 'email', 'trim|min_length[5]|max_length[50]|valid_email|callback_is_unique_if_new[users.email]|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('phone', 'phone', 'trim|min_length[5]|max_length[20]|callback_is_unique_if_new[users.phone]|encode_php_tags|xss_clean');
			
			if($this->form_validation->run())
			{
				$user_data = array();
				$champ = $this->input->post('first_name');
				if(!empty($champ))
					$user_data['first_name'] = $champ;
					
				$champ = $this->input->post('last_name');
				if(!empty($champ))
					$user_data['last_name'] = $champ;
					
				$champ = $this->input->post('username');
				if(!empty($champ))
					$user_data['username'] = $champ;
				
				$champ = $this->input->post('email');
				if(!empty($champ))
					$user_data['email'] = $champ;
					
				$champ = $this->input->post('phone');
				if(!empty($champ))
					$user_data['phone'] = $champ;
							
				$this->users->edit($this->client_id, $user_data);
				
				$this->index('Your Changes have been Successfully Submitted');
			}
			else
			{
				$this->index();
			}
		}
		else
		{
			redirect('error/must_sign_up');
		}
	}
	
	public function submit_edit_password()
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'CLIENT') == 0)
		{
			$this->form_validation->set_rules('password', 'password', 'trim|required|min_length[5]|max_length[20]|alpha_dash|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('confirm', 'confirm password', 'trim|required|matches[password]|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('old_password', 'old password', 'trim|required|min_length[5]|max_length[20]|alpha_dash|callback_check_password|encode_php_tags|xss_clean');
				
			if($this->form_validation->run())
			{
				$champ = $this->input->post('password');
				if(!empty($champ))
					$user_data['password'] = $champ;
					
				$this->users->edit($this->client_id, $user_data);
				
				$this->index('Your Password has been Successfully Changed');
			}
			else
			{
				$this->index('We couldn\'t change your password, go to "Change My Password" to find out why', true);
			}
		}
		else
		{
			redirect('error/must_sign_up');
		}
	}
	
	public function feedback_stats($page_number = 1, $comments_per_page = 50, $reply = "")
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'CLIENT') == 0)
		{
			$this->page_data['sub_current'] = 'feedback_stats';
			$this->page_data['current_path'] = array("Feedback Stats"=>"dashboard/feedback_stats");
			$this->page_data["reply"] = $reply;
			
			$stats['comments_number'] = $this->comments->count($this->where);
			$stats['pos_comments_number'] = $this->comments->count("(".$this->where.") AND `nature`= 'positive'");
			$stats['neg_comments_number'] = $this->comments->count("(".$this->where.") AND `nature`= 'negative'");
			$stats['neut_comments_number'] = $this->comments->count("(".$this->where.") AND `nature`= 'neutral'");
			$stats['url_comments_number'] = $this->comments->count("(".$this->where.") AND `origin`= 'URL'"); 
			$stats['qr_comments_number'] = $this->comments->count("(".$this->where.") AND `origin`= 'QR'");
			$stats['mail_comments_number'] = $this->comments->count("(".$this->where.") AND `origin`= 'MAIL'");
			$stats['sms_comments_number'] = $this->comments->count("(".$this->where.") AND `origin`= 'SMS'");
			
			$this->page_data["stats"] = $stats;
			
			
			$comp_where = '';
			$this->page_data["companies"] = array();
			foreach($this->c_companies as $c)
				$comp_where .= "`ID` = '".$c."' OR ";
			if(!empty($comp_where))
			{
				$comp_where = substr($comp_where, 0, -4);
				$this->page_data["companies"] = $this->companies->list_by_id($comp_where, 0, 0, 'name', 'asc');
			}
			
			$groups_where = '';
			$this->page_data["groups"] = array();
			foreach($this->all_groups as $c)
				$groups_where .= "`ID` = '".$c."' OR ";
			if(!empty($groups_where))
			{
				$groups_where = substr($groups_where, 0, -4);
				$this->page_data["groups"] = $this->groups->list_by_id($groups_where, 0, 0, 'name', 'asc');
			}
			
			$locs_where = '';
			$this->page_data["locations"] = array();
			foreach($this->all_locations as $c)
				$locs_where .= "`ID` = '".$c."' OR ";
			if(!empty($locs_where))
			{
				$locs_where = substr($locs_where, 0, -4);
				$this->page_data["locations"] = $this->locations->list_by_id($locs_where, 0, 0, 'name', 'asc');
			}
			
			$codes_where = '';
			$this->page_data["codes"] = array();
			foreach($this->all_codes as $c)
				$codes_where .= "`ID` = '".$c."' OR ";
			if(!empty($codes_where))
			{
				$codes_where = substr($codes_where, 0, -4);
				$this->page_data["codes"] = $this->codes->list_by_id($codes_where, 0, 0, 'code', 'asc');
			}
			//var_dump($this->page_data["codes"]);
			$this->page_data["all_companies"] = $this->pa_companies;
			
			$this->page_data["all_locations"] = $this->pa_locations;
			
			$this->page_data["cur_filter"] = $this->input->get('filter_by');
			
			$this->page_data["cur_company"] = $this->input->get('company');
			$this->page_data["cur_group"] = $this->input->get('group');
			$this->page_data["cur_location"] = $this->input->get('location');
			$this->page_data["cur_code"] = $this->input->get('code');
			
			$this->page_data["cur_period"] = $this->input->get('period');
			$this->page_data["cur_from"] = $this->input->get('from');
			$this->page_data["cur_to"] = $this->input->get('to');
			
			$this->page_data["cur_nature"] = $this->input->get('nature');
			$this->page_data["cur_source"] = $this->input->get('source');
			
			$report_type = $this->input->get('report_type');
			
			if(empty($report_type))
				$report_type = "WEB";
			
			if(strcasecmp($report_type, 'WEB') == 0)
			{
				$get_array = $this->input->get();
				if(empty($get_array))
					$get_array = array();
				
				$this->page_data["cur_link"] = site_url('dashboard/get_datatable_comments?'.http_build_query($get_array));
				
				$total_comments_number = $this->comments->count($this->where);
				$this->page_data['total_comments_number'] = $total_comments_number;
				$this->page_data['comments_per_page'] = $comments_per_page;
				$this->load->view('dashboard/feedback_summary', $this->page_data);
			}
			elseif(strcasecmp($report_type, 'CSV') == 0)
			{
				$comments = $this->_get_comments_array(false);
				$displayed_data = $comments['comments'];
				$nb_filtred_results = $comments['nb_filtred_results'];
				$nb_total_results = $comments['nb_total_results'];
				
				$custom_fields = '';
				$sec_custom_fields = '';
				foreach($this->pa_companies as $c)
				{
					if(!empty($c['cf_type']) && strpos($custom_fields, $c['cf_type']) === false)
					{
						if(!empty($custom_fields))
							$custom_fields .= '/';
						$custom_fields .= $c['cf_type'];
					}
					if(!empty($c['cf2_type']) && strpos($sec_custom_fields, $c['cf2_type']) === false)
					{
						if(!empty($sec_custom_fields))
							$sec_custom_fields .= '/';
						$sec_custom_fields .= $c['cf2_type'];
					}
				}
				$this->page_data['headers'] = array();
				$this->page_data['headers'][] = 'Time';
				if(count($this->pa_companies) > 1)
					$this->page_data['headers'][] = 'Company';
				$this->page_data['headers'][] = 'Location';
				$this->page_data['headers'][] = 'Code';
				$this->page_data['headers'][] = 'Code Description';
				$this->page_data['headers'][] = 'Comment';
				
				if(!empty($custom_fields))
					$this->page_data['headers'][] = 'Custom Field';
				if(!empty($sec_custom_fields))
					$this->page_data['headers'][] = '2nd Custom Field';
				$this->page_data['headers'][] = 'Nature';
				$this->page_data['headers'][] = 'Source';
					
				$this->page_data['filename'] = "feedback-stats-".date("Ymdhis");
				
				$this->page_data['data'] = array();
				foreach($displayed_data as $row_key => $row_val)
				{
					foreach($this->page_data['headers'] as $i => $index)
					{
						if(strcasecmp($index, 'time') == 0)
						{
							$time = new DateTime($row_val['comment_time'], new DateTimeZone('America/Los_Angeles')); //PDT is the timezone in the server.
							if(strcasecmp($row_val['timezone'], "America/Los_Angeles") != 0)
								$time->setTimezone(new DateTimeZone($row_val['timezone']));
							if(strcasecmp($row_val['time_type'], "NO_TIME") == 0)
								$this->page_data['data'][$row_key][$i] = $time->format('m/d/y');
							elseif(strcasecmp($row_val['time_type'], "AM") == 0 )
								$this->page_data['data'][$row_key][$i] = $time->format('m/d/y \A\M');		
							elseif(strcasecmp($row_val['time_type'], "PM") == 0)
								$this->page_data['data'][$row_key][$i] = $time->format('m/d/y \P\M');		
							else
								$this->page_data['data'][$row_key][$i] = $time->format('m/d/y g:iA T');
						}
						elseif(strcasecmp($index, 'company') == 0)
							$this->page_data['data'][$row_key][$i] = $row_val['company']; 
						elseif(strcasecmp($index, 'location') == 0)
							$this->page_data['data'][$row_key][$i] = $row_val['location']; 
						elseif(strcasecmp($index, 'code') == 0)
							$this->page_data['data'][$row_key][$i] = $row_val['code'];
						elseif(strcasecmp($index, 'code description') == 0)
							$this->page_data['data'][$row_key][$i] = $row_val['code_desc'];  
						elseif(strcasecmp($index, 'comment') == 0)
							$this->page_data['data'][$row_key][$i] = $row_val['comment'];   
						elseif(strcasecmp($index, 'nature') == 0)
							$this->page_data['data'][$row_key][$i] = $row_val['nature'];   
						elseif(strcasecmp($index, 'source') == 0)
						{
							$this->page_data['data'][$row_key][$i] = $row_val['origin'];
							if(!empty($row_val['indirect_origin']))
							$this->page_data['data'][$row_key][$i] .= ' ('.strtolower($row_val['indirect_origin']).')';
						}
						elseif(strcasecmp($index, 'comment') == 0)
							$this->page_data['data'][$row_key][$i] = $row_val['comment'];  
						elseif(strcasecmp($index, 'custom field') == 0 && !empty($row_val['extra_data']))
							$this->page_data['data'][$row_key][$i] = $row_val['extra_data'];  
						elseif(strcasecmp($index, '2nd custom field') == 0 && !empty($row_val['sec_extra_data']))
							$this->page_data['data'][$row_key][$i] = $row_val['sec_extra_data'];  
					}
					$n = count($this->page_data['headers']);
					for($i = 0; $i < $n; $i++)
						if(empty($this->page_data['data'][$row_key][$i]))
							$this->page_data['data'][$row_key][$i] = 'No Data Available';
					ksort($this->page_data['data'][$row_key]);
					
					if(!empty($custom_fields))
					{
						$cf_i = (int) array_search('Custom Field', $this->page_data['headers']);
						if(!empty($cf_i))
							$this->page_data['headers'][$cf_i] = $custom_fields;
					}
					if(!empty($sec_custom_fields))
					{
						$cf2_i = (int) array_search('2nd Custom Field', $this->page_data['headers']);
						if(!empty($cf2_i))
							$this->page_data['headers'][$cf2_i] = $sec_custom_fields;
					}
					/*if(!empty($custom_fields))
						$this->page_data['headers'][array_search('Custom Field', $this->page_data['headers'])] = $custom_fields;
					if(!empty($sec_custom_fields))
						$this->page_data['headers'][array_search('2nd Custom Field', $this->page_data['headers'])] = $sec_custom_fields;*/
				}
					
				$this->load->view('dashboard/csv_output', $this->page_data);
			}
			elseif(strcasecmp($report_type, 'PDF') == 0)
			{
				$comments = $this->_get_comments_array(false);
				$displayed_data = $comments['comments'];
				$nb_filtred_results = $comments['nb_filtred_results'];
				$nb_total_results = $comments['nb_total_results'];
				
				$comments_number = count($displayed_data);
				if($comments_number == 0) $comments_number = 1;
				$posi = 0; $nega = 0; $neut = 0;
				$br = ' 
';
				$this->load->library('cezpdf');
				foreach($displayed_data as $row_key => $row_val)
				{
					//time
					$time = new DateTime($row_val['comment_time'], new DateTimeZone('America/Los_Angeles')); //PDT is the timezone in the server.
					if(strcasecmp($row_val['timezone'], "America/Los_Angeles") != 0)
						$time->setTimezone(new DateTimeZone($row_val['timezone']));
					if(strcasecmp($row_val['time_type'], "NO_TIME") == 0)
						$time_str = $time->format('m/d/y');
					elseif(strcasecmp($row_val['time_type'], "AM") == 0 )
						$time_str = $time->format('m/d/y \A\M');		
					elseif(strcasecmp($row_val['time_type'], "PM") == 0)
						$time_str = $time->format('m/d/y \P\M');		
					else
						$time_str = $time->format('m/d/y g:iA T');	
						
					$time_str = preg_replace('/ /', $br, $time_str);
						
					//comment	
					$comment_text = strip_tags($row_val['comment']); 
					$extra_data = "";
					if(!empty($row_val['extra_data']) || !empty($row_val['sec_extra_data']))
					{
						if(!empty($row_val['cf_name']) && !empty($row_val['extra_data']))
							$extra_data = '<c:bold><c:uline>'.$row_val['cf_name'].':</c:uline></c:bold> '.$row_val['extra_data'];
						
						if(!empty($row_val['sec_extra_data']))
						{
							if(!empty($row_val['cf2_name']))
							{
								if(empty($extra_data))
									$extra_data = '<c:bold><c:uline>'.$row_val['cf2_name'].':</c:uline></c:bold> '.$row_val['sec_extra_data'];
								else
									$extra_data = $extra_data.$br.'<c:bold><c:uline>'.$row_val['cf2_name'].':</c:uline></c:bold> '.$row_val['sec_extra_data'];
							}
							elseif($row_val['cf_name'])
							{
								if(empty($extra_data))
									$extra_data = '<c:bold><c:uline>'.$row_val['cf_name'].':</c:uline></c:bold> '.$row_val['sec_extra_data'];
								else
									$extra_data = $extra_data.$br.'<c:bold><c:uline>'.$row_val['cf_name'].':</c:uline></c:bold> '.$row_val['sec_extra_data'];
							}
						}
						if(!empty($extra_data))
							$comment_text = $comment_text.$br.$extra_data;
					}
					
					//origin
					$source = $row_val['origin'];
					if(!empty($row_val['indirect_origin']))
								$source = $source.$br.'('.strtolower($row_val['indirect_origin']).')';
						
					//code
					$code = $row_val['code']; 
					if(!empty($row_val['code_desc']))
						$code .= $br.'('.$row_val['code_desc'].')';
						
					if(count($this->pa_companies) > 1)
						$data[] = array('Time'=>$time_str,'Company'=>$row_val['company'], 'Location'=>$row_val['location'],'Code'=>$code,'Comment'=>$comment_text,'Nature'=>$row_val['nature'],'Source'=>$source);
					else
						$data[] = array('Time'=>$time_str, 'Location'=>$row_val['location'],'Code'=>$code,'Comment'=>$comment_text,'Nature'=>$row_val['nature'],'Source'=>$source);
						
					//nature
					if(strcasecmp($row_val['nature'], 'positive') == 0)
						$posi++;
					elseif(strcasecmp($row_val['nature'], 'negative') == 0)
						$nega++;
					elseif(strcasecmp($row_val['nature'], 'neutral') == 0)
						$neut++;
					
				}
				//var_dump($data);
				
				// Set Report Title
				$report_title = "Feedback report for: ".$this->client['username']." (".$this->client['first_name']." ".$this->client['last_name'].")".$br;
				$h_filter = "";
				$p_filter = "";
				$o_filter = "";
				
				$cur_filter = $this->input->get('filter_by');
			
				$cur_company = $this->input->get('company');
				$cur_group = $this->input->get('group');
				$cur_location = $this->input->get('location');
				$cur_code = $this->input->get('code');
				
				$cur_period = $this->input->get('period');
				$cur_from = $this->input->get('from');
				$cur_to = $this->input->get('to');
				
				$cur_nature = $this->input->get('nature');
				$cur_source = $this->input->get('source');
				
				if(!empty($cur_filter))
				{
					if(strcasecmp($cur_filter, 'code') == 0 && !empty($cur_code))
						$h_filter = $this->pa_companies[$this->pa_codes[$cur_code]['company_id']]['name']." - ".$this->pa_locations[$this->pa_codes[$cur_code]['location_id']]['name']." - ".$this->pa_codes[$cur_code]['code'];
					elseif(strcasecmp($cur_filter, 'location') == 0 && !empty($cur_location))
						$h_filter = $this->pa_companies[$this->pa_locations[$cur_location]['company_id']]['name']." - ".$this->pa_locations[$cur_location]['name']." - All Codes";
					elseif(strcasecmp($cur_filter, 'group') == 0 && !empty($cur_group))
						$h_filter = $this->pa_companies[$this->site_groups[$cur_group]['company_id']]['name']." - ".$this->site_groups[$cur_group]['name']." - All Locations - All Codes";
					elseif(strcasecmp($cur_filter, 'company') == 0 && !empty($cur_company))
						$h_filter = $this->pa_companies[$cur_company]['name']." - All Locations - All Codes";
				}
				else
				{
					if(count($this->pa_companies) > 1)
						$h_filter = "All Companies - All Locations - All Codes";
					else
					{
						foreach($this->pa_companies as $c)
							$h_filter = $c['name']." - All Locations - All Codes";
					}
				}
				
				if(!empty($cur_period))
				{
					if(strcasecmp($cur_period, 'today') == 0)
						$p_filter = "Period: Today";
					elseif(strcasecmp($cur_period, 'weekly') == 0)
						$p_filter = "Period: Last 7 Days";
					elseif(strcasecmp($cur_period, 'monthly') == 0)
						$p_filter = "Period: Last 30 Days";
					elseif(strcasecmp($cur_period, 'yearly') == 0)
						$p_filter = "Period: Last 12 Months";
					elseif(strcasecmp($cur_period, 'custom') == 0 && !empty($cur_from) && !empty($cur_to))
						$p_filter = "Period: Between ".$cur_from." and ".$cur_to;
				}
				else
					$p_filter = "Period: All Time";
				
				if(!empty($cur_nature))
					$o_filter = "Nature: ".str_replace('_', ' ', $cur_nature).". ";
				
				if(!empty($cur_source))
					$o_filter .= 'Source: '.$cur_source;
		
				/*foreach($this->pa_companies as $c)
						$report_title = $report_title . $c['name'].' - ';*/
				
				$this->cezpdf->ezSetMargins(115,80,20,20);
				
				$header = $this->cezpdf->openObject();
				$this->cezpdf->addJpegFromFile(UPLOAD_DIR.'../logo.jpg',25,750,120);
				$this->cezpdf->closeObject();
				$this->cezpdf->addObject($header, "all");
				
				
				$footer = $this->cezpdf->openObject();
			  $this->cezpdf->addText(25,45,8,"TELL THE BOSS, INC. 27762 Antonio Pkwy., Suite L-1504, Ladera Ranch, CA 92694 (800) 372-7960. www.TellTheBoss.com");
				$this->cezpdf->closeObject();
				$this->cezpdf->addObject($footer, "all");
				
				
				//letter = 612 x 792
				$this->cezpdf->addInfo('Title',$report_title);
				$this->cezpdf->addInfo('Author','TellTheBoss.com');
				$this->cezpdf->addInfo('Subject','Feedback Report');
				
				$this->cezpdf->ezStartPageNumbers(552,45,12,'','',1);
				$this->cezpdf->setLineStyle(1);
				
			  $this->cezpdf->addText(25,735,12,$report_title);
			  $this->cezpdf->addText(25,720,10,$h_filter);
			  $this->cezpdf->addText(25,705,10,$p_filter);
				if(!empty($o_filter))
				{
					$this->cezpdf->addText(25,690,10,$o_filter);
					$this->cezpdf->addText(25,675,10,"Comments Number: ".$comments_number);
				}
				else
					$this->cezpdf->addText(25,690,10,"Comments Number: ".$comments_number);
				
				//$this->cezpdf->addText(25,735,8,$report_title);
			
				$dataNature[] = array('Nature'=>'Positive', 'Count'=>round(($posi*100)/$comments_number)."%");
				$dataNature[] = array('Nature'=>'Negative', 'Count'=>round(($nega*100)/$comments_number)."%");
				$dataNature[] = array('Nature'=>'Neutral', 'Count'=>round(($neut*100)/$comments_number)."%");
				
				$this->cezpdf->ezTable($dataNature,'','eAnalyzer Results',array('showHeadings'=>0,'shadeCol'=>array(0.9,0.9,0.9),'shaded'=>1,'fontSize'=>7, 'width'=>120,'xPos'=>'right','xOrientation'=>'left','cols' => array('Nature'=>array('justification'=>'left','width'=>80),'Count'=>array('justification'=>'right','width'=>30) )));
				$this->cezpdf->ezSetDy(-20);
				if(count($this->pa_companies) > 1)
					$this->cezpdf->ezTable($data,'','',array('showHeadings'=>1,'shaded'=>1,'fontSize'=>7, 'width'=>545, 'xPos'=>'right','xOrientation'=>'left',  'shadeCol'=>array(0.9,0.9,0.9),  'shadeCol2'=>array(0.9,0.9,0.9),'cols' => array('time'=>array('justification'=>'left','width'=>50),'Company'=>array('justification'=>'center','width'=>60),'Location'=>array('justification'=>'center','width'=>50),'Code'=>array('justification'=>'center','width'=>50),'Comment'=>array('justification'=>'left'),'Nature'=>array('justification'=>'center','width'=>40),'Source'=>array('justification'=>'center','width'=>50) )  ));
				else
					$this->cezpdf->ezTable($data,'','',array('showHeadings'=>1,'shaded'=>1,'fontSize'=>7, 'width'=>545, 'xPos'=>'right','xOrientation'=>'left',  'shadeCol'=>array(0.9,0.9,0.9),  'shadeCol2'=>array(0.9,0.9,0.9),'cols' => array('time'=>array('justification'=>'left','width'=>50),'Location'=>array('justification'=>'center','width'=>50),'Code'=>array('justification'=>'center','width'=>50),'Comment'=>array('justification'=>'left'),'Nature'=>array('justification'=>'center','width'=>40),'Source'=>array('justification'=>'center','width'=>50) )  ));

				$this->cezpdf->ezStream();
			}
		}
		else
		{
			redirect('error/must_sign_up');
		}
	}
	
	public function notifications_options($reply = '')
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'CLIENT') == 0 ||strcmp($this->session->userdata('type'), 'SUPER') == 0)
		{
			$user_emails_phones = $this->users->get_phones_emails($this->client_id);
			foreach($user_emails_phones  as $i => $uep)
			{
				if(strcmp($uep['contact'], $this->client['email']) == 0 || strcmp($uep['contact'], $this->client['phone']) == 0)
					$user_emails_phones[$i]['primary'] = 1;
				else
					$user_emails_phones[$i]['primary'] = 0;
				$list_emails_phones[$uep['contact']] = $uep;
				$i++;
			}
			
			$this->page_data['user_data'] = $this->client;
			$this->page_data['reply'] = $reply;
			$this->page_data['phones_emails'] = $user_emails_phones;
			$this->page_data['list_emails_phones'] = $list_emails_phones;
			$this->page_data['sub_current'] = 'notifications_options';
			$this->page_data['current_path'] = array("Notifications Options"=>"dashboard/notifications_options");
			
			$this->load->view('dashboard/header', $this->page_data);
			$this->load->view('dashboard/sub_menu');
			$this->load->view('dashboard/notifications_options');
			$this->load->view('general/footer');
		}
		else
		{
			redirect('error/must_sign_up');
		}
	}
	
	public function submit_notifications_options()
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'CLIENT') == 0)
		{
			$this->form_validation->set_rules('email', 'Primary Email', 'trim|max_length[50]|valid_email|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('phone', 'Primary Phone', 'trim|max_length[20]|callback__valid_phone|encode_php_tags|xss_clean');
			
			if($this->form_validation->run())
			{
				//updating user's email and phone: 
				$new_user_data = array('email'=>$this->input->post('email'),
											 'phone'=>$this->input->post('phone'));
				$new_user_data['phone'] = format_phone($new_user_data['phone']);
				$this->users->edit($this->client_id, $new_user_data);
				
				//removing all previous emails and phones
				$this->users->remove_all_phones_emails($this->client_id);
				
				//adding new phones and emails
				$this->users->add_phone($this->client_id, $new_user_data['phone'], $this->input->post('pf_noti_for'));
				$this->users->add_email($this->client_id, $new_user_data['email'], $this->input->post('pe_noti_for'));
				
				$reply = '<span class="success">The changes you requested have been successfully submitted</span>';
				$this->notifications_options($reply);
			}
			else
			{
				$reply = '<span class="error">Data entry error</span>';
				$this->notifications_options($reply);
			}
		}
		else
		{
			redirect('error/must_sign_up');
		}
	}
	
	public function locations_codes()
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'CLIENT') == 0)
		{
			
			$this->page_data['sub_current'] = 'locations_codes';
			$this->page_data['current_path'] = array("My Locations"=>"dashboard/locations_codes");
			
			$companies = $this->pa_companies;
			foreach($companies as $i => $company)
			{
				$companies[$i]['access_type'] = (in_array($i, $this->c_companies))?'Full Access':'Partial Access';
				
				$locations = array();
				foreach($this->pa_locations as $loc)
				{
					if($loc['company_id'] == $company['ID'])
					{
						$loc['access_type'] = (in_array($loc['ID'], $this->all_locations))?'Full Access':'Partial Access';
						$locations[] = $loc;
					}
				}
				$groups = array();
				foreach($this->all_groups as $g)
				{
					if($this->site_groups[$g]['company_id'] == $company['ID'])
						$groups[] = $this->site_groups[$g];
				}
				
				foreach($groups as $j => $group)
				{
					$groups[$j] = (array) $group;
					$locations_ids = $this->groups->get_binded_locations($group['ID']);
					$group_locations = array();
					foreach($locations_ids as $l_id)
					{
						foreach($locations as  $k => $loc)
						{
						
							if(!empty($loc) && ((int)$loc['ID'] == (int)$l_id['location_id']))
							{
								$group_locations[] = $loc;
								$locations[$k] = 0;
							}
						}
						foreach($group_locations as $k => $l)
						{
							$loc_codes = array();
							foreach($this->pa_codes as $code)
							{
								if($code['location_id'] == $l['ID'])
									$loc_codes[] = $code;
							}
							$group_locations[$k]['codes'] = $loc_codes;
						}
					}
					$groups[$j]['locations'] = $group_locations;
				}
				$locations = array_filter($locations);
				foreach($locations as $k => $l)
				{
					$loc_codes = array();
					foreach($this->pa_codes as $code)
					{
						if($code['location_id'] == $l['ID'])
							$loc_codes[] = $code;
					}
					$locations[$k]['codes'] = $loc_codes;
				}
				//$this->_sort_by_name($groups);
				$companies[$i]['groups'] = $groups;
				$companies[$i]['locations'] = $locations;
			}
			//echo '<pre>'.print_r($companies, true).'</pre>';
			$this->page_data['companies'] = $companies;
			$this->load->view('dashboard/header', $this->page_data);
			$this->load->view('dashboard/sub_menu');
			$this->load->view('dashboard/my_locations');
			$this->load->view('general/footer');
		}
		else
		{
			redirect('error/must_sign_up');
		}
	}
	
	public function codes($loc_id)
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'CLIENT') == 0)
		{
			if(!empty($this->pa_locations[$loc_id]))
			{
				$loc_data = $this->pa_locations[$loc_id];
				$loc_codes = array();
				foreach($this->pa_codes as $code)
				{
					if($code['location_id'] == $loc_id)
						$loc_codes[] = $code;
				}
				
				$this->page_data['sub_current'] = 'locations_codes';
				$this->page_data['current_path'] = array("My Locations"=>"dashboard/locations_codes", $loc_data['name']."'s codes"=>"dashboard/codes/".$loc_id);
				
				$this->page_data['location'] = $loc_data;
				$this->page_data['total_codes_number'] = count($loc_codes);
				$this->page_data['cur_link'] = site_url('dashboard/get_datatable_codes/'.$loc_id);
				$this->load->view('dashboard/header', $this->page_data);
				$this->load->view('dashboard/sub_menu');
				$this->load->view('dashboard/codes');
				$this->load->view('general/footer');
			}
			else
			{
				redirect('error/something_went_wrong');
			}
		}
		else
		{
			redirect('error/must_sign_up');
		}
	}
	
	public function get_datatable_codes($loc_id)
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'CLIENT') == 0)
		{
			//datatables conditions
			$columns = array('code', 'code', 'code', 'description');
			$valid_columns = array('code', 'description');
			
			$loc_codes = array();
			foreach($this->pa_codes as $code)
			{
				if($code['location_id'] == $loc_id)
					$loc_codes[] = $code;
			}
			
			$displayed_data = $loc_codes;
			
			$sLimit[0] = $this->input->post("iDisplayLength");
			$sLimit[1] = $this->input->post("iDisplayStart");
			if($sLimit[0] === "-1")
			{
				$sLimit[0] = '';
				$sLimit[1] = 0;
			}
			else
			{
				if(empty($sLimit[0]))
					$sLimit[0] = 5;
				if(empty($sLimit[1]))
					$sLimit[1] = 0;
			}
			
			$sOrder = "";

			if($this->input->post("iSortingCols"))
			{
				for($i = 0; $i < intval($this->input->post("iSortingCols")); $i++)
					$this->_sort_by($displayed_data, $columns[intval($this->input->post("iSortCol_".$i))],  $this->input->post("sSortDir_".$i));
			}
			
			if($this->input->post("sSearch") != '')
			{
				for($i = 0; $i < count($columns); $i++)
				{
					foreach($displayed_data as $k => $c)
					{
						if(stripos($c['code'], $this->input->post("sSearch")) === false && stripos($c['description'], $this->input->post("sSearch")) === false)
							$displayed_data[$k] = null;
					}
					$displayed_data = array_filter($displayed_data);
				}
			}
			$nb_filtred_results = count($displayed_data);
			$nb_total_results = count($loc_codes);
			if(!empty($sLimit[0]))
				$displayed_data = array_slice($displayed_data, $sLimit[1], $sLimit[0]);
			else
				$displayed_data = array_slice($displayed_data, $sLimit[1]);
			$aaData = array();

			foreach($displayed_data as $row_key => $row_val)
			{
				//code
				$aaData[$row_key][0] = '<strong style="font-size:18px;">'.strtoupper($row_val['code']).'</strong>';		
				
				//QR code
				$code = strtolower($row_val['code']);
				$url = site_url('feedback/receive/'.$code);
				$pc_url = site_url('f/'.$code);
				$filename = $code.".png";
				if(!empty($_GET['dev']) && $_GET['dev'] == 1) $filename = 'dev_'.$filename;
				$filepath = UPLOAD_DIR."../qr_codes/".$filename; 
				$width = $height = 300;
				if(!file_exists($filepath)) 
				{ 
					$encoded_url = urlencode($url); 
					$qr = file_get_contents("http://chart.googleapis.com/chart?chs={$width}x{$height}&cht=qr&chl={$encoded_url}&choe=UTF-8&chld=L|1"); 
					file_put_contents($filepath, $qr); 
				}
				$aaData[$row_key][1] = '<div class="qr_code"><a class="colorbox" href="'.img_url('qr_codes/'.$filename).'" rel="'.strtoupper($code).'"><img alt="QR code: Right click to download full size image" title="QR code: Right click to download full size image" style="height:100px;width:100px;" src="'.img_url('qr_codes/'.$filename).'"/></a></div>'; 
				
				//link
				$aaData[$row_key][2] = '<a href="'.$pc_url.'">'.$pc_url.'</a>'; 
				
				//code desc
				$desc = (!empty($row_val['description']))?$row_val['description']:'No description is given for this code';
				$aaData[$row_key][3] = $desc; 
				if(!empty($row_val['code_desc']))
					$aaData[$row_key][3] .= '<br/>('.$row_val['code_desc'].')';
			}
			
			//we generate json

			$sOutput = array
			(
				"sEcho"                => intval($this->input->post("sEcho")),
				"iTotalRecords"        => (string)$nb_total_results,
				"iTotalDisplayRecords" => (string)$nb_filtred_results,
				"aaData"               => $aaData
			);
			
			$this->output->set_header('Content-type: application/json'); 
			/*$postt=$this->input->post();
			log_message('error', '<pre>'.print_r($postt, true).'</pre>');
			log_message('error', '<pre>'.print_r($sOutput, true).'</pre>');*/
			echo json_encode($sOutput);
		}
		else
		{
			redirect('error/must_sign_up');
		}
	}
	
	public function get_datatable_comments()
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'CLIENT') == 0)
		{
			$comments = $this->_get_comments_array();
			$displayed_data = $comments['comments'];
			$nb_filtred_results = $comments['nb_filtred_results'];
			$nb_total_results = $comments['nb_total_results'];
			
			$aaData = array();

			foreach($displayed_data as $row_key => $row_val)
			{
				//time
				$time = new DateTime($row_val['comment_time'], new DateTimeZone('America/Los_Angeles')); //PDT is the timezone in the server.
				if(strcasecmp($row_val['timezone'], "America/Los_Angeles") != 0)
					$time->setTimezone(new DateTimeZone($row_val['timezone']));
				if(strcasecmp($row_val['time_type'], "NO_TIME") == 0)
					$aaData[$row_key][0] = $time->format('m/d/y');
				elseif(strcasecmp($row_val['time_type'], "AM") == 0 )
					$aaData[$row_key][0] = $time->format('m/d/y \A\M');		
				elseif(strcasecmp($row_val['time_type'], "PM") == 0)
					$aaData[$row_key][0] = $time->format('m/d/y \P\M');		
				else
					$aaData[$row_key][0] = $time->format('m/d/y g:iA');		
				
				//company
				//$aaData[$row_key][1] = $row_val['company']; 
				
				//location
				$aaData[$row_key][1] = $row_val['location']; 
				
				//code+desc
				if(!empty($row_val['code_desc']))
					$aaData[$row_key][2] = $row_val['code_desc'];
				else
					$aaData[$row_key][2] = $row_val['code']; 
					
				//comment
				$aaData[$row_key][3] = htmlentities($row_val['comment']); 
				$extra_data = "";
				$buttons = "";
								
				if(!empty($row_val['extra_data']) || !empty($row_val['sec_extra_data']))
				{
					if(!empty($row_val['cf_name']) && !empty($row_val['extra_data']))
					{
						if(strpos($row_val['extra_data'], '@') !== false)
							$buttons = '<a class="reply_btn" href="#" data-toggle="popover" title data-content=​"And here\'s some amazing content. It\'s very engaging. right?" data-original-title=​"A Title"><span class="label label-primary" alt="'.$row_val['extra_data'].'"  onclick="my_popover(this); return false;">Reply</span></a>';
						else
							$extra_data = '<strong>'.$row_val['cf_name'].':</strong> '.$row_val['extra_data'];
					}
					
					if(!empty($row_val['sec_extra_data']))
					{
						if(!empty($row_val['cf2_name']))
						{
							if(strpos($row_val['sec_extra_data'], '@') !== false)
								$buttons = '<a class="reply_btn" href="#"><span class="label label-primary" alt="'.$row_val['sec_extra_data'].'">Reply</span></a>';
							else
							{
								if(empty($extra_data))
									$extra_data = '<strong>'.$row_val['cf2_name'].':</strong> '.$row_val['sec_extra_data'];
								else
									$extra_data = $extra_data.'<br/><strong>'.$row_val['cf2_name'].':</strong> '.$row_val['sec_extra_data'];
							}
						}
						elseif($row_val['cf_name'])
						{
							if(empty($extra_data))
								$extra_data = '<strong>'.$row_val['cf_name'].':</strong> '.$row_val['sec_extra_data'];
							else
								$extra_data = $extra_data.'<br/><strong>'.$row_val['cf_name'].':</strong> '.$row_val['sec_extra_data'];
						}
					}
					if(!empty($buttons))
						$aaData[$row_key][3] = $aaData[$row_key][3].' '.$buttons;
					if(!empty($extra_data))
						$aaData[$row_key][3] = $aaData[$row_key][3].'<div class="custom_field">'.$extra_data.'</div>';
				}
				
				//nature
				$aaData[$row_key][4] = '<img src="'.img_url('n_'.$row_val['nature'].'.png').'" alt="'.$row_val['nature'].' title="'.$row_val['nature'].'" width="24">'; 
				
				//origin+indirect_origin
				$aaData[$row_key][5] = strtoupper($row_val['origin']);
				if(strcasecmp($aaData[$row_key][5], 'sms') == 0)
					$aaData[$row_key][5] = '<span class="glyphicon glyphicon-phone" style="color:#999;"></span>';
				if(strcasecmp($aaData[$row_key][5], 'qr') == 0)
					$aaData[$row_key][5] = '<span class="glyphicon glyphicon-qrcode" style="color:#999;"></span>';
				if(strcasecmp($aaData[$row_key][5], 'url') == 0)
					$aaData[$row_key][5] = '<span class="glyphicon glyphicon-globe" style="color:#999;"></span>';
				if(strcasecmp($aaData[$row_key][5], 'mail') == 0)
					$aaData[$row_key][5] = '<span class="glyphicon glyphicon-envelope" style="color:#999;"></span>';
				if(!empty($row_val['indirect_origin']))
					$aaData[$row_key][5] = $aaData[$row_key][5].'<br/>('.strtolower($row_val['indirect_origin']).')';
				
				/*if(count($this->pa_companies) < 2)
				{
					unset($aaData[$row_key][1]);
					$aaData[$row_key] = array_values($aaData[$row_key]);
				}*/
			}
			
			//we generate json

			$sOutput = array
			(
				"sEcho"                => intval($this->input->post("sEcho")),
				"iTotalRecords"        => (string)$nb_total_results,
				"iTotalDisplayRecords" => (string)$nb_filtred_results,
				"aaData"               => $aaData
			);
			$postt=$this->input->post();
			//log_message('error', '<pre>'.print_r($postt, true).'</pre>');
			//log_message('error', '<pre>'.print_r($sOutput, true).'</pre>');
			$this->output->set_header('Content-type: application/json'); 
			echo json_encode($sOutput);
		}
		else
		{
			redirect('error/must_sign_up');
		}
	}
	
	public function _get_comments_array($limit = true)
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'CLIENT') == 0)
		{
			//we query the database to get comments that fit both the GET creteria and the datatables creteria
			//GET conditions
			$where = '';
			$cur_filter = $this->input->get('filter_by');
			
			$cur_company = $this->input->get('company');
			$cur_group = $this->input->get('group');
			$cur_location = $this->input->get('location');
			$cur_code = $this->input->get('code');
			
			$cur_period = $this->input->get('period');
			$cur_from = $this->input->get('from');
			$cur_to = $this->input->get('to');
			
			$cur_nature = $this->input->get('nature');
			$cur_source = $this->input->get('source');
			
			
			
			if(!empty($cur_code))
				$where = "(comments.code_id = '".$cur_code."') ";
			elseif(!empty($cur_location))
				$where = "(comments.location_id = '".$cur_location."') ";
			
			/*if(!empty($cur_filter))
			{
				if(strcasecmp($cur_filter, 'code') == 0 && !empty($cur_code))
					$where = "(comments.code_id = '".$cur_code."') ";
				elseif(strcasecmp($cur_filter, 'location') == 0 && !empty($cur_location))
					$where = "(comments.location_id = '".$cur_location."') ";
				elseif(strcasecmp($cur_filter, 'group') == 0 && !empty($cur_group))
				{
					$group_locs = $this->groups->get_binded_locations($cur_group);
					foreach($group_locs as $gl)
					{
						if(!empty($where))
							$where .= " OR ";
						$where .= "(comments.location_id = '".$gl['location_id']."') ";
					}
				}
				elseif(strcasecmp($cur_filter, 'company') == 0 && !empty($cur_company))
					$where = "(comments.company_id = '".$cur_company."') ";
			}*/
			
			if(!empty($where))
				$where = '(('.$this->where.') AND ('.$where.')) ';
			else
				$where = '('.$this->where.') ';
			
			if(!empty($cur_from) && !empty($cur_to))
					$time_where = "comments.comment_time BETWEEN '".$cur_from." 00:00:00' AND '".$cur_to." 23:59:59'";
			
			if(!empty($cur_period))
			{
				if(strcasecmp($cur_period, 'today') == 0)
					$time_where = "comments.comment_time > DATE_ADD(NOW(), INTERVAL -1 DAY)";
				elseif(strcasecmp($cur_period, 'weekly') == 0)
					$time_where = "comments.comment_time > DATE_ADD(NOW(), INTERVAL -1 WEEK)";
				elseif(strcasecmp($cur_period, 'monthly') == 0)
					$time_where = "comments.comment_time > DATE_ADD(NOW(), INTERVAL -1 MONTH)";
				elseif(strcasecmp($cur_period, 'yearly') == 0)
					$time_where = "comments.comment_time > DATE_ADD(NOW(), INTERVAL -1 YEAR)";
				elseif(strcasecmp($cur_period, 'custom') == 0 && !empty($cur_from) && !empty($cur_to))
					$time_where = "comments.comment_time BETWEEN '".$cur_from." 00:00:00' AND '".$cur_to." 23:59:59'";
			}
			if(!empty($time_where))
			{
				if(!empty($where))
					$where = $where.' AND ('.$time_where.')';
				else
					$where = '('.$time_where.')';
			}
			
			if(!empty($cur_nature))
			{
				if(!empty($where))
					$where = '('.$where.') AND ';
				if(strpos($cur_nature, 'not_') === false)
					$where .= "(comments.nature = '".$cur_nature."')";
				else
				{
					$cur_nature = str_replace('not_', '', $cur_nature);
					$where .= "(comments.nature != '".$cur_nature."')";
				}
			}
			if(!empty($cur_source))
			{
				if(!empty($where))
					$where = '('.$where.') AND ';
				$where .= "(comments.origin = '".$cur_source."')";
			}
		
			//datatables conditions
			$columns = array('comment_time', 'company', 'location', 'code', 'comment', 'nature', 'origin');
			$valid_columns = array('comments.comment_time', 'companies.name', 'locations.name', 'comments.code', 'comments.comment', 'comments.nature', 'comments.origin');
			if(count($this->pa_companies) < 2)
			{
				$columns = array('comment_time', 'location', 'code', 'comment', 'nature', 'origin');
				$valid_columns = array('comments.comment_time', 'locations.name', 'comments.code', 'comments.comment', 'comments.nature', 'comments.origin');
			}
			if($limit)
				$sLimit = $this->get_datatable_paging();
			else
				$sLimit = array(0, 0);
			$sOrder = $this->get_datatable_ordering($columns);
			$sWhere = $this->get_datatable_filtering($valid_columns, $where);
			//log_message('error', print_r($sWhere, true));
			//getting data from database
			$displayed_data['comments'] = $this->comments->list_comments($sWhere, $sOrder, $sLimit);
			$displayed_data['nb_filtred_results'] = $this->comments->count_total_filtred_results($sWhere);
			$displayed_data['nb_total_results'] = $this->comments->count_total_filtred_results($where);
			
			return $displayed_data;
		}
		else
			return 'you don\'t have the right to see this!';
	}

	protected function get_datatable_paging()
	{
		$sLimit[0] = $this->input->post("iDisplayLength");
		$sLimit[1] = $this->input->post("iDisplayStart");
		if($sLimit[0] === "-1")
		{
			$sLimit[0] = '';
			$sLimit[1] = '';
		}
		else
		{
			if(empty($sLimit[0]))
				$sLimit[0] = 50;
			if(empty($sLimit[1]))
				$sLimit[1] = 0;
		}
		return $sLimit;
	}

	protected function get_datatable_ordering($columns)
	{
		$sOrder = "";

		if($this->input->post("iSortingCols"))
		{
			$sOrder = "";

			for($i = 0; $i < intval($this->input->post("iSortingCols")); $i++)
				$sOrder .= $columns[intval($this->input->post("iSortCol_" . $i))] . " " . $this->input->post("sSortDir_" . $i) . ", ";

			$sOrder = substr_replace($sOrder, "", -2);
		}

		return $sOrder;
	}

	protected function get_datatable_filtering($columns, $where)
	{
		$sWhere = "";

		if($this->input->post("sSearch") != '')
		{
			for($i = 0; $i < count($columns); $i++)
				$sWhere .= $columns[$i] . " LIKE '%" . $this->input->post("sSearch") . "%' OR ";

			$sWhere = substr_replace($sWhere, "", -3);
		}
		//log_message('error', '<pre>'.print_r($sWhere, true).'</pre>');
		
		if(!empty($where) && !empty($sWhere))
			return '('.$sWhere.') AND ('.$where.')';
		elseif(!empty($where))
			return $where;
		elseif(!empty($sWhere))
			return $sWhere;
		else
			return '';
	}
	
	public function is_unique_if_new($str, $field)
	{
		if(!empty($str))
		{
			list($table, $item) = explode('.', $field, 2);
			if(strcmp($table, 'users') == 0)
			{
				if(strcmp($this->client[$item], $str) == 0)
					return true;
			}
			if(!$this->form_validation->is_unique($str, $field))
			{
				$this->form_validation->set_message('is_unique_if_new', 'that '.$item.' is taken');				
				return false;
			}
			else
				return true;
		}
		else
			return true;
	}
	
	public function is_unique_if_new_user($str, $field)
	{
		if(!empty($str))
		{
			list($table, $item, $target_id) = explode('.', $field, 3);
			$target_id = (int)$target_id;
			if(strcmp($table, 'users') == 0)
			{
				$db_data = $this->users->get_data($target_id, $item);
				if(strcmp($db_data, $str) == 0)
				{
					return true;
				}
			}
			$field = $table.'.'.$item;
			if(!$this->form_validation->is_unique($str, $field))
			{
				$this->form_validation->set_message('is_unique_if_new_user', 'that '.$item.' is taken');				
				return false;
			}
			else
				return true;
		}
		else
			return true;
	}
	
	public function check_password($pass)
	{
		if(!empty($pass))
		{
			if(strcmp($this->client['password'], $pass) == 0)
				return true;
			else
			{
				$this->form_validation->set_message('check_password', 'password doesn\'t match');
				return false;
			}
		}
		else
			return true;
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

	public function _sort_by_name(&$array)
	{
		$size = count($array);
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
		}
	}
	
	public function _sort_by(&$array, $column, $dir = 'asc')
	{
		$size = count($array);
		for($i = 0; $i < $size; $i++)
		{
			for($j = 0; $j < $size-1; $j++)
			{
				if(!empty($array[$j][$column]))
				{
					if(strcmp(strtolower($array[$j][$column]), strtolower($array[$j+1][$column])) > 0)
					{
						$temp = $array[$j];
						$array[$j] = $array[$j+1];
						$array[$j+1] = $temp;
					}
				}
				else
				{
					if(strcmp(strtolower($array[$j][$column]), strtolower($array[$j+1][$column])) > 0)
					{
						$temp = $array[$j];
						$array[$j] = $array[$j+1];
						$array[$j+1] = $temp;
					}
				}
			}
		}
		if(strcasecmp($dir, 'desc') == 0)
			$array = array_reverse($array);
	}
	
}