 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_feedback extends CI_Controller 
{
	protected $page_data;
	protected $admin_id;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('companies_model', 'companies');
		$this->load->model('locations_model', 'locations');
		$this->load->model('codes_model', 'codes');
		$this->load->model('comments_model', 'comments');
		$this->load->model('groups_model', 'groups');
		$this->load->model('pages_data_model');
		$this->load->helper('feedback');
		$this->load->helper('sms');
		$this->load->helper('form');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		
		$this->page_data = array();
		$this->page_data['title'] = 'Tell The Boss - Admin Panel - Feedback Stats';
		$this->page_data['current'] = 'admin_panel';
		$this->admin_id = $this->session->userdata('user_id');
	}
	
	public function index($page_number = 1, $comments_per_page = 50, $reply = "")
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$this->page_data['sub_current'] = 'feedback_stats';
			$this->page_data['current_path'] = array("Feedback Stats"=>"admin_feedback");
			$this->page_data["reply"] = $reply;
			
			$this->page_data["clients"] = $this->users->list_by_id(array('type' => 'CLIENT'), 0, 0, 'username', 'asc');
			$this->page_data["companies"] = $this->companies->list_by_id(array(), 0, 0, 'name', 'asc');
			$this->page_data["groups"] = $this->groups->list_by_id(array(), 0, 0, 'name', 'asc');
			$this->page_data["locations"] = $this->locations->list_by_id(array(), 0, 0, 'name', 'asc');
			$this->page_data["codes"] = $this->codes->list_by_id(array(), 0, 0, 'code', 'asc');
			
			
			$this->page_data["cur_filter"] = $this->input->get('filter_by');
			
			$this->page_data["cur_client"] = $this->input->get('client');
			$this->page_data["cur_company"] = $this->input->get('company');
			$this->page_data["cur_group"] = $this->input->get('group');
			$this->page_data["cur_location"] = $this->input->get('location');
			$this->page_data["cur_code"] = $this->input->get('code');
			
			$this->page_data["cur_period"] = $this->input->get('period');
			$this->page_data["cur_from"] = $this->input->get('from');
			$this->page_data["cur_to"] = $this->input->get('to');
			
			$this->page_data["cur_nature"] = $this->input->get('nature');
			$this->page_data["cur_source"] = $this->input->get('source');
			$this->page_data["cur_is_test"] = $this->input->get('is_test');
			
			$get_array = $this->input->get();
			if(empty($get_array))
				$get_array = array();
			
			$this->page_data["cur_link"] = site_url('admin_feedback/get_datatable_comments?'.http_build_query($get_array));
			
			$total_comments_number = $this->comments->count();
			$this->page_data['total_comments_number'] = $total_comments_number;
			$this->page_data['comments_per_page'] = $comments_per_page;
			$this->load->view('admin_panel/header', $this->page_data);
			$this->load->view('admin_panel/sub_menu');
			$this->load->view('admin_panel/admin_feedback/list');
			$this->load->view('general/footer');
		}
		else
		{
			redirect('error/must_sign_up_as_admin');
		}
	}
	
	public function add($reply = "")
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$this->page_data['sub_current'] = 'feedback_stats';
			$this->page_data['current_path'] = array("Feedback Stats"=>"admin_feedback", "Add a New Comment" => "admin_feedback/add");
			$this->page_data["reply"] = $reply;
			
			$codes_objs = $this->codes->list_records();
			$codes = array();
			foreach($codes_objs as $co)
				$codes[] = strtoupper($co->code);
			sort($codes);
			$this->page_data['codes'] = $codes;
			
			$this->load->view('admin_panel/header', $this->page_data);
			$this->load->view('admin_panel/sub_menu');
			$this->load->view('admin_panel/admin_feedback/add');
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
			$this->form_validation->set_rules('comment', 'Comment', 'trim|min_length[2]|max_length[2000]|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('overall_exp', 'Overall Experience', 'trim|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('code', 'Code', 'trim|required|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('date', 'Date', 'trim|required|min_length[6]|max_length[10]|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('time', 'Time', 'trim|required|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('s_time', 'Specific Time', 'trim|min_length[4]|max_length[8]|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('nature', 'Nature', 'trim|required|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('source', 'Source', 'trim|required|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('extra_data', 'Extra Data', 'trim|min_length[2]|max_length[50]|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('sec_extra_data', 'Second Extra Data', 'trim|min_length[2]|max_length[50]|encode_php_tags|xss_clean');
				
			if($this->form_validation->run())
			{
				$code = $this->codes->get_by_code($this->input->post('code'));
				if($this->input->post('time') == 'SPECIFIC')
					$timedate = $this->input->post('date').' '.$this->input->post('s_time');
				elseif($this->input->post('time') == 'AM')
					$timedate = $this->input->post('date').' 08:00 AM';
				elseif($this->input->post('time') == 'PM')
					$timedate = $this->input->post('date').' 02:00 PM';
				else
					$timedate = $this->input->post('date').' 00:00';
				$time_string = $timedate;
				$timedate = new datetime($timedate);
				$timedate = $timedate->format('Y-m-d H:i:s');
				
				$indirect_source = "";
				if($this->input->post('is_postcard') == 'yes')
					$indirect_source = "postcards";
				
				$comment = $this->input->post('comment');
				if(!empty($comment))
					$comment .= ' ';
				$overall_exp = $this->input->post('overall_exp');
				if(!empty($overall_exp)) 
					$comment = $comment.'Overall experience: '.$overall_exp;
				
				$is_test = 0; if(strpos(strtolower($comment), 'ttbtest') !== false) $is_test = 1;
				
				$comment_data = array('comment'=>$comment,
															'code'=>$this->input->post('code'),
															'time'=>'now',
															'comment_time'=>$timedate,
															'time_type'=>$this->input->post('time'),
															'nature'=>$this->input->post('nature'),
															'analyzer_nature'=>rate_feedback($comment),
															'code_id'=>$code['ID'],
															'location_id'=>$code['location_id'],
															'company_id'=>$code['company_id'],
															'origin'=>$this->input->post('source'),
															'extra_data'=>$this->input->post('extra_data'),
															'sec_extra_data'=>$this->input->post('sec_extra_data'),
															'admin_id'=>$this->admin_id,
															'is_test'=>$is_test,
															'indirect_origin'=>$indirect_source);
				
				$comment_id = $this->comments->add($comment_data);
				
				//send notifications
				//coming soon
				$reply = "Your comment was successfully Added to comments!";
				if(strcasecmp($this->input->post('btn_submit'), 'Submit and Go back to Feedback Stats') == 0)
					$this->index(1, 50, $reply);
				else
					$this->add($reply);
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
	
	public function edit($comment_id, $reply = '')
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$comment_data = $this->comments->get_by_id($comment_id);
			if(!empty($comment_data))
			{
				$codes_objs = $this->codes->list_records();
				$codes = array();
				foreach($codes_objs as $co)
					$codes[] = strtoupper($co->code);
				sort($codes);
				$this->page_data['codes'] = $codes;
				
				if(strcasecmp($comment_data['origin'], 'MAIL') == 0 || !empty($comment_data['admin_id']))
				{
					if(!empty($comment_data['admin_id']))
					{
						$comment_data['admin'] = $this->users->get_data($comment_data['admin_id'], 'username');
						$comment_data['admin_comments_number'] = $this->comments->count(array('admin_id' => $comment_data['admin_id']));
					}
				}
				elseif(strcasecmp($comment_data['origin'], 'SMS') == 0 || strcasecmp($comment_data['origin'], 'QR') == 0 || strcasecmp($comment_data['origin'], 'URL') == 0)
				{
					if(strcasecmp($comment_data['origin'], 'SMS') == 0)
						$indic = 'phone_number';
					else
					{
						$indic = 'cookie_id';
						if(empty($comment_data[$indic]))
							$indic = 'session_id';
						if(!empty($comment_data['ip_address']))
						{
							$xml = (array)simplexml_load_file("http://api.ipinfodb.com/v3/ip-city/?key=9eae2e9ff589df730aabb38205433a9429d29a01d4b17b6dedc9a768692770c5&format=xml&ip=".$comment_data['ip_address']);
							if(!empty($xml))
							{
								if(!empty($xml['cityName'])) $city = str_replace('-', '', $xml['cityName']);
								if(!empty($xml['regionName'])) $region = str_replace('-', '', $xml['regionName']);
								if(!empty($xml['countryName'])) $country = str_replace('-', '', $xml['countryName']);
							}
							$comment_data['geo_location'] = '';
							if(!empty($city))
								$comment_data['geo_location'] = $xml['cityName'].', ';
							if(!empty($region))
								$comment_data['geo_location'] .= $xml['regionName'].' ';
							if(!empty($country))
								$comment_data['geo_location'] .= $xml['countryName'];
						}
					}
					if(!empty($comment_data[$indic]))
					{
						$comment_data['indic'] = $indic;
						$comment_data['total_comments_number'] = $this->comments->count(array($indic => $comment_data[$indic]));
						$n = $comment_data['total_comments_number'];
						$comment_data['last_week_comments_number'] = 0;
						$comment_data['last_month_comments_number'] = 0;
						if($n > 1)
						{
							$comment_data['total_codes_number'] = $this->comments->count_distinct('code', array($indic => $comment_data[$indic]));
							$comment_data['total_locations_number'] = $this->comments->count_distinct('location_id', array($indic => $comment_data[$indic]));
							$comment_data['total_companies_number'] = $this->comments->count_distinct('company_id', array($indic => $comment_data[$indic]));
							
							//Last 24 Hours
							$comment_data['last_day_comments_number'] = $this->comments->count("`".$indic."` = '".$comment_data[$indic]."' AND `comment_time` >= DATE_ADD(NOW(), INTERVAL -1 DAY)");
							if($comment_data['last_day_comments_number'] != 0)
							{
								$comment_data['last_day_codes_number'] = $this->comments->count_distinct('code', "`".$indic."` = '".$comment_data[$indic]."' AND `comment_time` >= DATE_ADD(NOW(), INTERVAL -1 DAY)" );
								$comment_data['last_day_locations_number'] = $this->comments->count_distinct('location_id', "`".$indic."` = '".$comment_data[$indic]."' AND `comment_time` >= DATE_ADD(NOW(), INTERVAL -1 DAY)");
								$comment_data['last_day_companies_number'] = $this->comments->count_distinct('company_id', "`".$indic."` = '".$comment_data[$indic]."' AND `comment_time` >= DATE_ADD(NOW(), INTERVAL -1 DAY)");
							}

							//Last week
							if($comment_data['last_day_comments_number'] != $n)
							{
								$comment_data['last_week_comments_number'] = $this->comments->count("`".$indic."` = '".$comment_data[$indic]."' AND `comment_time` >= DATE_ADD(NOW(), INTERVAL -1 WEEK)");
								if($comment_data['last_week_comments_number'] != 0)
								{
									$comment_data['last_week_codes_number'] = $this->comments->count_distinct('code', "`".$indic."` = '".$comment_data[$indic]."' AND `comment_time` >= DATE_ADD(NOW(), INTERVAL -1 WEEK)");
									$comment_data['last_week_locations_number'] = $this->comments->count_distinct('location_id', "`".$indic."` = '".$comment_data[$indic]."' AND `comment_time` >= DATE_ADD(NOW(), INTERVAL -1 WEEK)");
									$comment_data['last_week_companies_number'] = $this->comments->count_distinct('company_id', "`".$indic."` = '".$comment_data[$indic]."' AND `comment_time` >= DATE_ADD(NOW(), INTERVAL -1 WEEK)");
								}
							}
							
							//Last month
							if($comment_data['last_day_comments_number'] != $n && $comment_data['last_week_comments_number'] != $n)
							{
								$comment_data['last_month_comments_number'] = $this->comments->count("`".$indic."` = '".$comment_data[$indic]."' AND `comment_time` >= DATE_ADD(NOW(), INTERVAL -1 MONTH)");
								if($comment_data['last_month_comments_number'] != 0)
								{
									$comment_data['last_month_codes_number'] = $this->comments->count_distinct('code', "`".$indic."` = '".$comment_data[$indic]."' AND `comment_time` >= DATE_ADD(NOW(), INTERVAL -1 MONTH)");
									$comment_data['last_month_locations_number'] = $this->comments->count_distinct('location_id', "`".$indic."` = '".$comment_data[$indic]."' AND `comment_time` >= DATE_ADD(NOW(), INTERVAL -1 MONTH)");
									$comment_data['last_month_companies_number'] = $this->comments->count_distinct('company_id', "`".$indic."` = '".$comment_data[$indic]."' AND `comment_time` >= DATE_ADD(NOW(), INTERVAL -1 MONTH)");
								}
							}

							//Last Year
							if($comment_data['last_day_comments_number'] != $n && $comment_data['last_week_comments_number'] != $n && $comment_data['last_month_comments_number'] != $n)
							{
								$comment_data['last_year_comments_number'] = $this->comments->count("`".$indic."` = '".$comment_data[$indic]."' AND `comment_time` >= DATE_ADD(NOW(), INTERVAL -1 YEAR)");
								if($comment_data['last_month_comments_number'] != 0)
								{
									$comment_data['last_year_codes_number'] = $this->comments->count_distinct('code', "`".$indic."` = '".$comment_data[$indic]."' AND `comment_time` >= DATE_ADD(NOW(), INTERVAL -1 YEAR)");
									$comment_data['last_year_locations_number'] = $this->comments->count_distinct('location_id', "`".$indic."` = '".$comment_data[$indic]."' AND `comment_time` >= DATE_ADD(NOW(), INTERVAL -1 YEAR)");
									$comment_data['last_year_companies_number'] = $this->comments->count_distinct('company_id', "`".$indic."` = '".$comment_data[$indic]."' AND `comment_time` >= DATE_ADD(NOW(), INTERVAL -1 YEAR)");
								}
							}
						}
					}
					else
						$comment_data['total_comments_number'] = 0;
				}
				
				$this->page_data['comment_data'] = $comment_data;
				$this->page_data['reply'] = $reply;
				
				$this->page_data['sub_current'] = 'feedback_stats';
				$this->page_data['current_path'] =  array("Feedback Stats"=>"admin_feedback", "Edit Comment" => "admin_feedback/edit/".$comment_id);
				
				$this->load->view('admin_panel/header', $this->page_data);
				$this->load->view('admin_panel/sub_menu');
				$this->load->view('admin_panel/admin_feedback/edit');
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
			$target_data = $this->comments->get_by_id($target_id);
			if(!empty($target_data))
			{
				$this->form_validation->set_rules('comment', 'Comment', 'trim|required|min_length[2]|max_length[2000]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('time', 'Date and Time', 'trim|required|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('time_type', 'Time Type', 'trim|min_length[4]|max_length[8]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('nature', 'Nature', 'trim|required|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('source', 'Source', 'trim|required|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('extra_data', 'Extra Data', 'trim|min_length[2]|max_length[50]|encode_php_tags|xss_clean');
				$this->form_validation->set_rules('sec_extra_data', 'Second Extra Data', 'trim|min_length[2]|max_length[50]|encode_php_tags|xss_clean');
					
				if($this->form_validation->run())
				{
					$code = $this->codes->get_by_code($this->input->post('code'));
					$indirect_source = "";
					if($this->input->post('is_postcard') == 'yes')
						$indirect_source = "postcards";
				
					$comment = $this->input->post('comment');
					$is_test = 0; if(strpos(strtolower($comment), 'ttbtest') !== false) $is_test = 1;
				
					$comment_data = array('comment'=>$comment,
															'code'=>$this->input->post('code'),
															'comment_time'=>$this->input->post('time'),
															'time_type'=>$this->input->post('time_type'),
															'nature'=>$this->input->post('nature'),
															'analyzer_nature'=>rate_feedback($comment),
															'code_id'=>$code['ID'],
															'location_id'=>$code['location_id'],
															'company_id'=>$code['company_id'],
															'origin'=>$this->input->post('source'),
															'extra_data'=>$this->input->post('extra_data'),
															'sec_extra_data'=>$this->input->post('sec_extra_data'),
															'is_test'=>$is_test,
															'indirect_origin'=>$indirect_source);
					
					$this->comments->edit($target_id, $comment_data);
					
					$reply = 'The changes you requested have been successfully submitted to this comment';
					$this->edit($target_id, $reply);
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
	
	public function submit_delete($target_id)
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$target_data = $this->comments->get_by_id($target_id);
			if(!empty($target_data))
			{
				$this->comments->delete($target_id);
				
				$reply = 'The requested comment was successfully deleted.';
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
	
	public function toggle_verified($target_id)
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$target_data = $this->comments->get_by_id($target_id);
			if(!empty($target_data))
			{
				if($target_data['seen'] == 0)
				{
					$new_data['seen'] = 1;
					$new_data['seen_by'] = $this->admin_id;
					$this->comments->edit($target_id, $new_data);
					$admin_name = $this->users->get_data($this->admin_id, 'username');
					echo 'Verified by <strong>'.$admin_name.'</strong><br/><a class="toggle_verified" href="'.site_url('admin_feedback/toggle_verified/'.$target_id).'">Undo</a>';
				}
				else
				{
					$new_data['seen'] = 0;
					$this->comments->edit($target_id, $new_data);
					echo '<span class="new_comment">New</span><br/><a class="toggle_verified" href="'.site_url('admin_feedback/toggle_verified/'.$target_id).'"> Mark as seen</a>';
				}
			}
			else
			{
				echo "The Site encountred an error, report to developer.";
			}
		}
		else
		{
			echo "You don't have the right to do this";
		}
	}
	
	
	public function get_datatable_comments()
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			//we query the database to get comments that fit both the GET creteria and the datatables creteria
			//GET conditions
			$where = '';
			$cur_filter = $this->input->get('filter_by');
			
			$cur_client = $this->input->get('client');
			$cur_company = $this->input->get('company');
			$cur_group = $this->input->get('group');
			$cur_location = $this->input->get('location');
			$cur_code = $this->input->get('code');
			
			$cur_period = $this->input->get('period');
			$cur_from = $this->input->get('from');
			$cur_to = $this->input->get('to');
			
			$cur_nature = $this->input->get('nature');
			$cur_source = $this->input->get('source');
			$cur_is_test = $this->input->get('is_test');
			
			if(!empty($cur_filter))
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
				elseif(strcasecmp($cur_filter, 'client') == 0 && !empty($cur_client))
				{
					$user_rights = $this->users->get_rights($cur_client);
					if(empty($user_rights))
						$where = '(comments.ID < 0) ';
					foreach($user_rights as $ur)
					{
						if(strcasecmp($ur['target_type'], 'company') == 0)
						{
							if(!empty($where))
								$where .= " OR ";
							$where .= "(comments.company_id = '".$ur[$ur['target_type'].'_id']."') ";
						}
						elseif(strcasecmp($ur['target_type'], 'location') == 0)
						{
							if(strpos($where, "(comments.location_id = '".$ur[$ur['target_type'].'_id']."')") === false)
							{
								if(!empty($where))
									$where .= " OR ";
								$where .= "(comments.location_id = '".$ur[$ur['target_type'].'_id']."') ";
							}
						}
						elseif(strcasecmp($ur['target_type'], 'code') == 0)
						{
							if(strpos($where, "(comments.code_id = '".$ur[$ur['target_type'].'_id']."')") === false)
							{
								if(!empty($where))
									$where .= " OR ";
								$where .= "(comments.code_id = '".$ur[$ur['target_type'].'_id']."') ";
							}
						}
						elseif(strcasecmp($ur['target_type'], 'group') == 0)
						{
							$group_id = $ur[$ur['target_type'].'_id'];
							$group_locs = $this->groups->get_binded_locations($group_id);
							foreach($group_locs as $gl)
							{
								if(strpos($where, "(comments.location_id = '".$gl['location_id']."')") === false)
								{
									if(!empty($where))
										$where .= " OR ";
									$where .= "(comments.location_id = '".$gl['location_id']."') ";
								}
							}
						}
					}
				}
			}
			
			if(!empty($where))
				$where = '('.$where.') ';
			
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
			if(!empty($cur_is_test))
			{
				if(!empty($where))
					$where = '('.$where.') AND ';
				if(strcasecmp($cur_is_test, 'test') == 0)
					$where .= "(comments.is_test = '1')";
				else
					$where .= "(comments.is_test = '0')";
			}
		
			//datatables conditions
			$columns = array('comment_time', 'company', 'location', 'code', 'comment', 'nature', 'origin', 'action', 'seen');
			$valid_columns = array('comments.comment_time', 'companies.name', 'locations.name', 'comments.code', 'comments.comment', 'comments.nature', 'comments.origin', 'comments.seen');
			$sLimit = $this->get_datatable_paging();
			$sOrder = $this->get_datatable_ordering($columns);
			$sWhere = $this->get_datatable_filtering($valid_columns, $where);
			//log_message('error', print_r($sWhere, true));
			//getting data from database
			$displayed_data = $this->comments->list_comments($sWhere, $sOrder, $sLimit);
			$nb_filtred_results = $this->comments->count_total_filtred_results($sWhere);
			$nb_total_results = $this->comments->count_total_filtred_results($where);
			
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
					$aaData[$row_key][0] = $time->format('m/d/y <b\\r/>g:iA <b\\r/>T');		
				
				//company
				$aaData[$row_key][1] = $row_val['company']; 
				
				//location
				$aaData[$row_key][2] = $row_val['location']; 
				
				//code+desc
				$aaData[$row_key][3] = $row_val['code']; 
				if(!empty($row_val['code_desc']))
					$aaData[$row_key][3] .= '<br/>('.$row_val['code_desc'].')';
					
				//comment
				$aaData[$row_key][4] = htmlentities($row_val['comment']); 
				$extra_data = "";
				if(!empty($row_val['extra_data']) || !empty($row_val['sec_extra_data']))
				{
					if(!empty($row_val['cf_name']) && !empty($row_val['extra_data']))
						$extra_data = '<strong>'.$row_val['cf_name'].':</strong> '.$row_val['extra_data'];
					
					if(!empty($row_val['sec_extra_data']))
					{
						if(!empty($row_val['cf2_name']))
						{
							if(empty($extra_data))
								$extra_data = '<strong>'.$row_val['cf2_name'].':</strong> '.$row_val['sec_extra_data'];
							else
								$extra_data = $extra_data.'<br/><strong>'.$row_val['cf2_name'].':</strong> '.$row_val['sec_extra_data'];
						}
						elseif($row_val['cf_name'])
						{
							if(empty($extra_data))
								$extra_data = '<strong>'.$row_val['cf_name'].':</strong> '.$row_val['sec_extra_data'];
							else
								$extra_data = $extra_data.'<br/><strong>'.$row_val['cf_name'].':</strong> '.$row_val['sec_extra_data'];
						}
					}
					if(!empty($extra_data))
						$aaData[$row_key][4] = $aaData[$row_key][4].'<div class="custom_field">'.$extra_data.'</div>';
				}
				
				//nature
				$aaData[$row_key][5] = '<img src="'.img_url($row_val['nature'].'.png').'" alt="'.$row_val['nature'].' title="'.$row_val['nature'].'" width="32">'; 
				
				//origin+indirect_origin
				$aaData[$row_key][6] = strtoupper($row_val['origin']);
				if(!empty($row_val['indirect_origin']))
					$aaData[$row_key][6] = $aaData[$row_key][6].'<br/>('.strtolower($row_val['indirect_origin']).')';
				
				//action
				$aaData[$row_key][7] = '<a href="'.site_url('admin_feedback/edit/'.$row_val['ID']).'"><img src="'.img_url('edit_comment.png').'" alt="Edit" title="Edit"></a>'; 
				
				//new/seen
				
				if($row_val['seen'])
				{
					$aaData[$row_key][8] = 'Verified ';
					if(!empty($row_val['seen_by']))
						$aaData[$row_key][8] = $aaData[$row_key][8].'by <strong>'.$row_val['seen_by'].'</strong>';
					$aaData[$row_key][8] = $aaData[$row_key][8].'<br/><a class="toggle_verified" href="'.site_url('admin_feedback/toggle_verified/'.$row_val['ID']).'">Undo</a>';
				}
				else
					$aaData[$row_key][8] = '<span class="new_comment">New</span><br/><a class="toggle_verified" href="'.site_url('admin_feedback/toggle_verified/'.$row_val['ID']).'"> Mark as seen</a>';
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
			redirect('error/must_sign_up_as_admin');
		}
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