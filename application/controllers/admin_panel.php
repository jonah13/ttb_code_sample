<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_panel extends CI_Controller 
{
	protected $page_data;
	protected $admin_id;
	protected $admin;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('users_model', 'users');
		$this->load->model('locations_model', 'locations');
		$this->load->model('comments_model', 'comments');
		$this->load->model('codes_model', 'codes');
		$this->load->model('companies_model', 'companies');
		$this->load->model('groups_model', 'groups');
		$this->load->model('sms_record_model', 'sms_record');
		$this->load->model('pages_data_model');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		
		$this->page_data = array();
		$this->page_data['title'] = 'Tell The Boss - Admin Panel';
		$this->page_data['current'] = 'admin_panel';
		$this->admin_id = $this->session->userdata('user_id');
		$this->admin = $this->users->get_by_id($this->admin_id);
	}
	
	public function index($message = "", $is_error = false)
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$this->page_data['sub_current'] = 'home';
			$this->page_data['current_path'] = array('home'=>'admin_panel');
			if($is_error)
				$this->page_data['error'] = $message;
			else
				$this->page_data['reply'] = $message;
			
			//$stats = $this->pages_data_model->get_site_stats();
			$this->admin = $this->users->get_by_id($this->admin_id);
			$this->page_data['user_data'] = $this->admin;
			
			$stats['clients_number'] = $this->users->count(array('type'=>'CLIENT'));
			$stats['admins_number'] = $this->users->count(array('type'=>'ADMIN'));
			$stats['companies_number'] = $this->companies->count();
			$stats['groups_number'] = $this->groups->count();
			$stats['locations_number'] = $this->locations->count();
			$stats['codes_number'] = $this->codes->count();
			$stats['comments_number'] = $this->comments->count();
			$stats['url_comments_number'] = $this->comments->count(array('origin'=>'URL'));
			$stats['qr_comments_number'] = $this->comments->count(array('origin'=>'QR'));
			$stats['mail_comments_number'] = $this->comments->count(array('origin'=>'MAIL'));
			$stats['sms_comments_number'] = $this->comments->count(array('origin'=>'SMS'));
			$stats['incoming_SMS_number'] = $this->sms_record->count(array('to' => '22121'));
			$stats['outgoing_SMS_number'] = $this->sms_record->count(array('from' => '22121'));
			
			$this->page_data['stats'] = $stats;
			
			$this->load->view('admin_panel/header', $this->page_data);
			$this->load->view('admin_panel/sub_menu');
			$this->load->view('admin_panel/overview');
			$this->load->view('general/footer');
		}
		else
		{
			redirect('error/must_sign_up_as_admin');
		}
	}
	
	public function submit_edit_my_info()
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
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
							
				$this->users->edit($this->admin_id, $user_data);
				
				$this->index('Your Changes have been Successfully Submitted');
			}
			else
			{
				$this->index();
			}
		}
		else
		{
			redirect('error/must_sign_up_as_admin');
		}
	}
	
	public function submit_edit_password()
	{
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'ADMIN') == 0)
		{
			$this->form_validation->set_rules('password', 'password', 'trim|required|min_length[5]|max_length[20]|alpha_dash|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('confirm', 'confirm password', 'trim|required|matches[password]|encode_php_tags|xss_clean');
			$this->form_validation->set_rules('old_password', 'old password', 'trim|required|min_length[5]|max_length[20]|alpha_dash|callback_check_password|encode_php_tags|xss_clean');
				
			if($this->form_validation->run())
			{
				$champ = $this->input->post('password');
				if(!empty($champ))
					$user_data['password'] = $champ;
					
				$this->users->edit($this->admin_id, $user_data);
				
				$this->index('Your Password has been Successfully Changed');
			}
			else
			{
				$this->index('We couldn\'t change your password, go to "Change My Password" to find out why', true);
			}
		}
		else
		{
			redirect('error/must_sign_up_as_admin');
		}
	}
	
	public function is_unique_if_new($str, $field)
	{
		if(!empty($str))
		{
			list($table, $item) = explode('.', $field, 2);
			if(strcmp($table, 'users') == 0)
			{
				if(strcmp($this->admin[$item], $str) == 0)
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
				$db_data = $this->users_model->get_user_data($target_id, $item);
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
			if(strcmp($this->admin['password'], $pass) == 0)
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
	
	public function must_sign_up_as_admin()
	{
		$this->load->view('general/header', $this->page_data);
		$this->load->view('general/slideshow');
		$this->load->view('general/must_sign_up_as_admin_error');
		$this->load->view('general/footer');
	}
	
	public function page_not_found()
	{
		$this->load->view('general/header', $this->page_data);
		$this->load->view('general/slideshow');
		$this->load->view('general/page_not_found');
		$this->load->view('general/footer');
	}
}