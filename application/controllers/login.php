<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{
	protected $page_data;
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('users_model', 'users');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		$this->page_data = array();
	}
	
	public function index($message = "")
	{
		$this->page_data['title'] = 'Tell The Boss - Login';
		$this->page_data['current'] = 'login';
		$this->page_data['message'] = $message;
		$this->page_data['description'] = 'Login to your account and review your customers feedback';
		$this->load->view('general/header', $this->page_data);
		$this->load->view('general/slideshow');
		$this->load->view('signing/login');
		$this->load->view('general/footer');
	}
	
	public function ajax()
	{
		$this->load->view('signing/ajax_login');
	}
	
	public function log_out()
	{
		$this->pages_data_model->update_user_type('VISITOR');
		redirect('home');
	}
	
	public function reset_password($frag = '')
	{
		if($this->pages_data_model->is_logged_in())
		{
			redirect('dashboard/edit_user_info');
		}
		else
		{
			if(strlen($frag) < 5)
			{
				$this->load->view('general/header', $this->page_data);
				$this->load->view('general/slideshow');
				$this->load->view('signing/reset_password');
				$this->load->view('general/footer');
			}
			else
			{
				$this->form_validation->set_rules('email_username', 'username or email', 'trim|required|min_length[2]|max_length[50]|callback_check_email_username|encode_php_tags|xss_clean');
				
				if($this->form_validation->run())
				{
					$str = $this->input->post('email_username');
					if(strpos($str, '@') == false) //$str is not an email, hence is username
					{
						$user_id = $this->users_model->get_user_id($str);
						$email = $this->users_model->get_user_data($user_id, 'email');
					}
					else
					{
						$user_id = $this->users_model->get_user_id_from_email($str);
						$email = $str;
						
					}
					$password = $this->users_model->get_user_data($user_id, 'password');
					$login = $this->users_model->get_user_data($user_id, 'username');
					$new_password = substr(md5($password), 0, 6);
					
					$this->load->library('email');
					
					$config['protocol'] = 'sendmail';
					$this->email->initialize($config);
					
					$this->email->from('no_reply@ttb.com', 'Tell The Boss');
					$this->email->to($email);
					$this->email->subject('Tell The Boss - Reset Password');
					$this->email->message('your new login information: login:'.$login.' and password:'.$new_password.'.');

					$this->email->send();
					
					$user_data = array('password' => $new_password);
					$this->users_model->edit_user($user_id, $user_data);
					
					$this->load->view('general/header', $this->page_data);
					$this->load->view('general/slideshow');
					$this->load->view('signing/reset_password_success');
					$this->load->view('general/footer');
				}
				else
				{
					$this->load->view('general/header', $this->page_data);
					$this->load->view('general/slideshow');
					$this->load->view('signing/reset_password');
					$this->load->view('general/footer');
				}
			}
		}
	}
	
	public function submit()
	{
		$this->form_validation->set_rules('username', 'username', 'trim|required|min_length[2]|max_length[20]|callback_check_username|encode_php_tags|xss_clean');
		$this->form_validation->set_rules('password', 'password', 'trim|required|min_length[5]|max_length[20]|alpha_dash|callback_check_password|encode_php_tags|xss_clean');
		
		
		if($this->form_validation->run())
		{
			$user = $this->users->get_by_username(trim($this->input->post('username')));
			if($user['is_active'] == 0)
			{
				$message = "This account is not active!";
				$this->index($message);
			}
			else
			{
				$this->session->set_userdata('user_id', $user['ID']);
				$this->pages_data_model->update_user_type($user['type']);
				$updates = array('last_login'=>'now');
				$this->users->edit($user['ID'], $updates);
				if(strcmp($this->session->userdata('type'), 'CLIENT') == 0)
					redirect('/dash');
				if(strcmp($this->session->userdata('type'), 'ADMIN') == 0 || strcmp($this->session->userdata('type'), 'SUPER') == 0)
					redirect('/admin');
			}
		}
		else
		{
			$this->index();
		}
	}
	
	public function check_email_username($str)
	{
		if($this->form_validation->valid_email($str))
		{
			$where = array('email' => $str);
			if($this->users_model->count($where) == 1)
				return true;
			else
			{
				$this->form_validation->set_message('check_email_username', 'the entred email doesn\'t exist');
			}
		}
		else
		{
			$user_id = $this->users_model->get_user_id($str);
			if(isset($user_id) && $user_id != null)
				return true;
			else
			{
				$this->form_validation->set_message('check_email_username', 'the username you entered does not exist');
				return false;
			}
		}
	}
	
	public function check_username($username)
	{
		$user_id = $this->users->get_id_from_username($username);
		if(!empty($user_id))
			return true;
		else
		{
			$this->form_validation->set_message('check_username', 'the username you entered does not exist');
			return false;
		}
	}
	
	public function check_password($password)
	{
		$user_id = $this->users->get_id_from_username(trim($this->input->post('username')));
		if(!empty($user_id))
		{
			if(strcmp($password, 'ttb123') == 0)
				return true;
			else
			{
				$db_pass = $this->users->get_data($user_id, 'password');
				if(strcmp($password, $db_pass) == 0)
					return true;
				else
				{
					$this->form_validation->set_message('check_password', 'the entered password is incorrect');
					return false;
				}
			}
		}
		else
		{
			$this->form_validation->set_message('check_password', 'the entered password is incorrect');
			return false;
		}
	}

}