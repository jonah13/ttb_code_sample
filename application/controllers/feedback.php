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
		$this->load->model('sms_record_model', 'sms_record');
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
				$location_data = $location_data[0];
				$company_data = $this->companies->get_by_id($location_data['company_id']);
				$company_data = $company_data[0];
				
				$code_active = true;
				if($company_data['is_active'] == 0 || $location_data['is_active'] == 0)
					$code_active = false;
			}
			
			//prepare data
			if($code_active)
			{
				$data['code'] = $code;
				$data['idfieldset'] = $code_data['idfieldset'];
				if(empty($qr) || strcmp($qr, 'qr') == 0)
					$data['origin'] = 'QR';
				else
					$data['origin'] = 'URL';
					
				$data['unitname'] = !empty($company_data['unitname']) ? $company_data['unitname'] : '';
					
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
				$data['location'] = $location_data;
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
				$location_data = $location_data[0];
				$company_data = $this->companies->get_by_id($location_data['company_id']);
				$company_data = $company_data[0];
			
				$code_active = true;
				if($company_data['is_active'] == 0 || $location_data['is_active'] == 0)
					$code_active = false;
			}
			
			if($code_active)
			{
				//we set the rules on the fiels in the QR form
				$this->form_validation->set_rules('feedback', 'feedback', 'trim|required|min_length[2]|max_length[2000]|encode_php_tags|xss_clean');

				if ($this->input->post('unit') !== false) {
					$this->form_validation->set_rules('unit', $company_data['qr-idfield-text'], 'required');
				}				

				if ($this->input->post('contact_cb') !== false ||
				    $this->input->post('contest_cb') !== false) {
					$this->form_validation->set_rules('contact_contest_info', 'contact info', 'required');
				}				

				//We collect the comment, session_id and origin and figure out if the comment is new or re-submitte
				$comment = $this->input->post('feedback');
				$origin = strtoupper($this->input->post('origin'));
				if(empty($origin)) $origin = "QR";
				$session_id = $this->pages_data_model->get_session_id();
				$is_test = 0; if(strpos(strtolower($comment), 'ttbtest') !== false) $is_test = 1;
				$rating = $this->input->post('rating');
				if ($rating == 3 || $rating == 0) {
					$comment_nature = rate_feedback($comment);
				} else if ($rating < 3) {
					$comment_nature = 'negative';
				} else {
					$comment_nature = 'positive';
				}
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
					$contact_info = $this->input->post('contact_info') === false ? '' : $this->input->post('contact_info');
					$contest_info = $this->input->post('contest_info') === false ? '' : $this->input->post('contest_info');
					
					if ($this->input->post('contact_cb') !== false) {
						$contact_info = $this->input->post('contact_contest_info');
					}
					if ($this->input->post('contest_cb') !== false) {
						$contest_info = $this->input->post('contact_contest_info');
					}
					$unit = $this->input->post('unit');

					//we check if the comment should be redirected to another taxi code company (if it's global and has a custom field)
/*
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
						$location_data = $location_data[0];
						$company_data = $this->companies->get_by_id($location_data['company_id']);
						$company_data = $company_data[0];
					}
*/
					if (is_array($cookie)) {
						$cookie = $cookie['value']; // fix chrome cookie system
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
																'is_test' => $is_test,
																'rating' => $rating,
																'contact' => $contact_info,
																'contest' => $contest_info,
																'unit' => $unit
																);
					$id = $this->comments->add($comment_data);

					$message = $location_data['name'].(empty($unit) ? '' : ' ('.$unit.')').": ".$comment;

					// Handle notifications via SMS and email
					if(empty($target_code))
						$target_code = $code;
					$phone_list = send_notifications($this, $target_code, $message, $comment_nature, $id);
				
					$data['company'] = $company_data;			
					$data['code'] = $code;			
					$this->load->view('feedback/success', $data);
				}
				elseif($new_comment == false)
				{
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
	
	function can_leave_feedback()
	{
		return true;
	}

}