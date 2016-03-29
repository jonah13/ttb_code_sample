<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Feedback extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->library('form_validation');
		$this->load->library('email');
		$config['protocol'] = 'sendmail';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$this->email->initialize($config);
		$this->load->model('users_model', 'users');
		$this->load->model('companies_model', 'companies');
		$this->load->model('groups_model', 'groups');
		$this->load->model('locations_model', 'locations');
		$this->load->model('codes_model', 'codes');
		$this->load->model('comments_model', 'comments');
		$this->load->model('pages_data_model');
		$this->load->helper('feedback');
		$this->load->helper('sms');
		$this->load->helper('form');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
	}
	
	public function index($code = null, $qr = null)
	{
		$this->receive($code, $qr);
	}
	
	public function receive($code = null, $qr = null)
	{
		if($this->can_leave_feedback())
		{
			//collect data
			$code_data = $this->codes->get_by_code($code);
			$code_active = false;
			if(!empty($code_data))
			{
				$location_data = $this->locations->get_by_id($code_data['location_id']);
				$company_data = $this->companies->get_by_id($location_data['company_id']);
			
				$code_active = true;
				if($company_data['is_active'] == 0 || $location_data['is_active'] == 0)
					$code_active = false;
			}
			
			//prepare data
			if($code_active)
			{
				$data['code'] = $code;
				if(empty($qr) || strcmp($qr, 'qr') == 0)
					$data['origin'] = 'QR';
				else
					$data['origin'] = 'URL';
					
			
				$description = $code_data['description'];
				if(empty($description)) $description = '';
				
				$text = array('qr_header' => empty($company_data['qr_header'])?QR_HEADER:$company_data['qr_header'],
											'qr_comment_label' => empty($company_data['qr_comment_label'])?QR_COMMENT_LABEL:$company_data['qr_comment_label'],
											'qr_success_text' => empty($company_data['qr_success_text'])?QR_SUCCESS_TEXT:$company_data['qr_success_text'],
											'sms_first_reply' => empty($company_data['sms_first_reply'])?SMS_FIRST_REPLY:$company_data['sms_first_reply'],
											'sms_last_reply' => empty($company_data['sms_last_reply'])?SMS_LAST_REPLY:$company_data['sms_last_reply']);
				if(!empty($company_data['cf_asked_for']) && (strcmp($company_data['cf_asked_for'], 'both') == 0 || strcmp($company_data['cf_asked_for'], 'qr') == 0))
				{
					$text['cf_qr_label'] = $company_data['cf_qr_label'];
					$text['cf_type'] = $company_data['cf_type'];
					if(!empty($company_data['cf2_asked_for']) && (strcmp($company_data['cf2_asked_for'], 'both') == 0 || strcmp($company_data['cf2_asked_for'], 'qr') == 0))
					{
						$text['cf2_qr_label'] = $company_data['cf2_qr_label'];
						$text['cf2_type'] = $company_data['cf2_type'];
					}
				}
				
				foreach($text as $index => $value)
					$company_data[$index] = $this->_replace_variables($value, $company_data['name'], $code, $location_data['name'], $description);	
				
				//if there's no cookie, we set it.
				$cookie = $this->input->cookie('ttb_ta3li9');
				if(empty($cookie))
				{
					$cookie = array(
						'name'   => 'ta3li9',
						'value'  => uniqid('ttb_', true),
						'expire' => 315567000,
						'domain' => DOMAIN,
						'prefix' => 'ttb_',
						'secure' => false);

					$this->input->set_cookie($cookie);
				}
				
				
				$data['company'] = $company_data;
				$this->load->view('feedback/receive', $data);
			}
			else
			{
					$this->load->view('feedback/error404');
			}
		}
		else
		{
			$this->load->view('feedback/not_allowed');
		}
	}
	
	public function submit($code)
	{
		$cookie = $this->input->cookie('ttb_ta3li9', true);
		if(empty($cookie))
		{
			$cookie = array(
				'name'   => 'ta3li9',
				'value'  => uniqid('ttb_', true),
				'expire' => 315567000,
				'domain' => '.telltheboss.com',
				'prefix' => 'ttb_',
				'secure' => false);

			$this->input->set_cookie($cookie);
		}
		
		if($this->can_leave_feedback())
		{
			//collect data
			$code_data = $this->codes->get_by_code($code);
			$code_active = false;
			if(!empty($code_data))
			{
				$location_data = $this->locations->get_by_id($code_data['location_id']);
				$company_data = $this->companies->get_by_id($location_data['company_id']);
			
				$code_active = true;
				if($company_data['is_active'] == 0 || $location_data['is_active'] == 0)
					$code_active = false;
			}
			
			if($code_active)
			{
				//we set the rules on the fiels in the QR form
				$this->form_validation->set_rules('feedback', 'feedback', 'trim|required|min_length[2]|max_length[2000]|encode_php_tags|xss_clean');
				if(!empty($company_data['cf_asked_for']) && (strcmp($company_data['cf_asked_for'], 'both') == 0 || strcmp($company_data['cf_asked_for'], 'qr') == 0) )
				{
					$required = '';
					if($company_data['cf_required'])
						$required = 'required|';
					$this->form_validation->set_rules('custom_field', $company_data['cf_type'], $required.'trim|max_length[50]|encode_php_tags|xss_clean');
					if(!empty($company_data['cf2_asked_for']) && (strcmp($company_data['cf2_asked_for'], 'both') == 0 || strcmp($company_data['cf2_asked_for'], 'qr') == 0) )
					{
						$required = '';
						if($company_data['cf2_required'])
							$required = 'required|';
						$this->form_validation->set_rules('sec_custom_field', $company_data['cf2_type'], $required.'trim|max_length[50]|encode_php_tags|xss_clean');
					}
				}
				
				//We collect the comment, session_id and origin and figure out if the comment is new or re-submitte
				$comment = $this->input->post('feedback');
				$origin = strtoupper($this->input->post('origin'));
				if(empty($origin)) $origin = "QR";
				$session_id = $this->pages_data_model->get_session_id();
				$is_test = 0; if(strpos(strtolower($comment), 'ttbtest') !== false) $is_test = 1;
				$comment_nature = rate_feedback($comment);
				$session_data = $this->session->all_userdata();
		
				$new_comment = true;
				$where = '';
				if($origin == 'URL' || $origin == 'QR')
				{
					$where = "`origin` = '".$origin."' AND `time` > DATE_ADD(NOW(), INTERVAL -1 HOUR) AND `comment` = '".addslashes($comment)."' AND `session_id` = '".$session_id."'";
					$n = $this->comments->count($where);
					if($n != 0)
						$new_comment = false;
				}
			
				if($this->form_validation->run() && $new_comment)
				{
					//we check if the comment should be redirected to another taxi code company (if it's lobal and has a custom field)
					$field = $this->input->post('custom_field');
					$field2 = $this->input->post('sec_custom_field');
				
					if(!empty($code_data['is_global']) && !empty($field)) //if code is global (for taxis) and we have the taxi number as custom field
					{
						preg_match("/\d{3}/u", $field, $code_str);
						$target_code = $code_str[0]; 
						
						$target_code_data = $this->codes->get_by_code('A'.$target_code);
						if(empty($target_code_data))
						{
							$target_code_data = $this->codes->get_by_code('Y'.$target_code);
							if(empty($target_code_data))
								$target_code = 0;
							else
								$target_code = 'Y'.$target_code;
						}
						else
							$target_code = 'A'.$target_code;
					}
					if(!empty($target_code_data))
					{
						$code = $target_code;
						$indirect_origin = $code_data['description']; //the global code description is the indirect source for the comment
						$code_data = $target_code_data;
						$location_data = $this->locations->get_by_id($code_data['location_id']);
						$company_data = $this->companies->get_by_id($location_data['company_id']);
					}
					$comment_data = array('comment'=>$comment, 
																'code'=>$code,
																'time'=>'now',
																'comment_time'=>'now',
																'analyzer_nature'=>$comment_nature,
																'nature'=>$comment_nature,
																'origin' => $origin,
																'ip_address' => $session_data['ip_address'],
																'user_agent' => $session_data['user_agent'],
																'session_id'=> $session_data['session_id'],
																'cookie_id'=> $cookie,
																'code_id'=>$code_data['ID'],
																'location_id'=>$code_data['location_id'],
																'company_id'=>$code_data['company_id'],
																'is_test' => $is_test);
					if(!empty($indirect_origin))
					{
						if(!empty($field2))
							$comment_data['extra_data'] = $field2;
						$comment_data['indirect_origin'] = $indirect_origin;
					}
					else
					{
						if(!empty($field))
							$comment_data['extra_data'] = $field;
						if(!empty($field2))
							$comment_data['sec_extra_data'] = $field2;
					}
					
					$id = $this->comments->add($comment_data);
										
					//$this->send_notifications();
					// Handle notifications via SMS and email
					/*if(empty($target_code))
						$target_code = $code;
					$phone_list = send_notifications($this, $target_code, $message, $comment_nature, $id);
					*/
					if(empty($company_data['qr_success_text'])) $company_data['qr_success_text'] = QR_SUCCESS_TEXT;
					if(empty($company_data['qr_header'])) $company_data['qr_header'] = QR_HEADER;
					
					$company_data['qr_success_text'] = $this->_replace_variables($company_data['qr_success_text'], $company_data['name'], $code, $location_data['name'], $code_data['description']);
					$company_data['qr_header'] = $this->_replace_variables($company_data['qr_header'], $company_data['name'], $code, $location_data['name'], $code_data['description']);
				
					$data['company'] = $company_data;			
					$data['code'] = $code;			
					$this->load->view('feedback/success', $data);
				}
				elseif($new_comment == false)
				{
					$qr_header = empty($company_data['qr_header'])?QR_HEADER:$company_data['qr_header'];
					$qr_header = $this->_replace_variables($qr_header, $company_data['name'], $code, $location_data['name'], $code_data['description']);
					$company_data['qr_header'] = $qr_header;
					$data['code'] = $code;			
					$data['company'] = $company_data;
					$data['location_name'] = $location_data['name'];
					$this->load->view('feedback/already_submitted', $data);
				}
				else
				{
					$this->receive($code, $origin);
				}
			}
			else
			{
					$this->load->view('feedback/error404');
			}
		}
		else
		{
			$this->load->view('feedback/not_allowed');
		}
	}
	
	function _replace_variables($str, $company_name, $code, $location_name, $desc)
	{
		$str = str_replace("#company_name" , $company_name, $str); 
		$str = str_replace("#code" , strtoupper($code), $str);
		$str = str_replace("#location_name" , $location_name, $str);
		$str = str_replace("#store_name" , $location_name, $str);
		$str = str_replace("#description" , $desc, $str);
					
		$callback_date = create_function('$match', '
			if(empty($match[0]) || empty($match[1])) 
				return date("m/d/y"); 
			else 
				return date("m/d/y", time()+$match[1]*86400);
		');
		$str = preg_replace_callback("#\#date\+([0-9]+)#", $callback_date, $str);
		
		//replacing links
		$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
		preg_replace($reg_exUrl, '<a href="$0">$0</a> ', $str);
		
		return $str;
	}
	
	function can_leave_feedback()
	{
		return true;
	}

}

/********
		$handle = fopen('log.txt', 'ab');
		fwrite($handle, 'store_code: '.$where[0]);
		/********/