<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages_data_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('users_model',  'users');
		$type = $this->session->userdata('type');
		if(empty($type))
			$this->session->set_userdata('type', 'VISITOR');
	}
	
	public function update_user_type($type = 'VISITOR')
	{
		$this->session->set_userdata('type', $type);
		if(strcmp($type, 'VISITOR') == 0)
			$this->session->unset_userdata('user_id');
	}
	
	public function get_session_id()
	{
		return $this->session->userdata('session_id');
	}
	
	public function is_logged_in()
	{
		$user_id = $this->session->userdata('user_id');
		$type = $this->session->userdata('type');
		if(!empty($user_id) && strcmp($type, 'VISITOR') != 0)
			return true;
		else
			return false;
	}
	
	public function get_user_data($user_id = '')
	{
		$user_id = $this->session->userdata('user_id');
		$data = array();
		//$data['link1'] = 'Sign Up';
		//$data['link1address'] = 'sign_up';
		$data['link2'] = 'Log In';
		$data['link2address'] = 'login';
		$data['type'] = 'VISITOR';
		if($this->is_logged_in())
		{
			$user = $this->users->get_by_id($user_id);
			if(strcmp($this->session->userdata('type'), 'CLIENT') == 0)
			{
				$data['is_active'] = $user['is_active'];
				$data['link1'] = 'Dashboard';
				$data['link1address'] = 'dashboard';
			}
			elseif(strcmp($this->session->userdata('type'), 'ADMIN') == 0 || strcmp($this->session->userdata('type'), 'SUPER') == 0)
			{
				$data['link1'] = 'Admin Panel';
				$data['link1address'] = 'admin_panel';
			}
			$data['first_name'] = $user['first_name'];
			$data['last_name'] = $user['last_name'];
			$data['username'] = $user['username'];
			$data['email'] = $user['email'];
			$data['phone'] = $user['phone'];
			$data['signup_date'] = $user['signup_date'];
			$data['type'] = $user['type'];
			$data['id'] = $user_id;
			
			
			$data['link2'] = 'Log Out';
			$data['link2address'] = 'login/log_out';
		}
		return $data;
	}
	
}
	/********
		$handle = fopen('log.txt', 'ab');
		fwrite($handle, 'user type: '.$user_data['type']);
		/********/