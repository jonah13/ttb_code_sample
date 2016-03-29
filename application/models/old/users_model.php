<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends CI_Model
{
	protected $table;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('account_options_class');
		
		$this->table = 'users';
	}
	
	public function add_user($data = array())
	{
		
		foreach($data as $index => $value)
		{
			if(strcmp($index, 'username') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'password') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'email') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'first_name') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'last_name') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'company_name') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'phone') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'type') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'options') == 0)
			{
				if(strcmp(strtolower($value), 'default') == 0 || strcmp($value, '') == 0)
				{
					$options = new Account_options_class;
					$options->feedback_limit = 0;
					$options->notify_for = 'all';
					$phones = array('all_phones','all_codes');//all_phones, user_phone, stores_phones, store_phone_'store_id', a phone number
																										//all_codes, store_codes_'store_id', code
					$emails = array('all_emails','all_codes');
					$options->phones[0] = $phones;
					$options->emails[0] = $emails;
					
					$s = serialize($options);
					$this->db->set($index,  $s);
				}
				else
				{
					$this->db->set($index,  $value);
				}
			}
			elseif(strcmp($index, 'active') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'plan_period') == 0)
			{
				$this->db->set('plan_start', 'NOW()', false);
				$this->db->set('plan_end', 'DATE_ADD(NOW(),INTERVAL '.$value.' MONTH)', false);
			}
			elseif(strcmp($index, 'sign_up_date') == 0)
			{
				if(strcmp($value, 'now') == 0)
					$this->db->set('sign_up_date', 'NOW()', false);
				else
					$this->db->set('sign_up_date', $value);
			}
			elseif(strcmp($index, 'last_login') == 0)
			{
				if(strcmp($value, 'now') == 0)
					$this->db->set('last_login', 'NOW()', false);
				else
					$this->db->set('last_login', $value);
			}
			elseif(strcmp($index, 'phone_notifications') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'email_notifications') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'phone_noti_type') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'email_noti_type') == 0)
			{
				$this->db->set($index,  $value);
			}
		}
		
		$this->db->insert($this->table);
		return $this->db->insert_id();
	}
	
	public function edit_user($id, $data = array())
	{
		foreach($data as $index => $value)
		{
			if(strcmp($index, 'username') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'password') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'email') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'first_name') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'last_name') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'company_name') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'phone') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'type') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'options') == 0)
			{
				if(strcmp(strtolower($value), 'default') == 0 || strcmp($value, '') == 0)
				{
					$options = new Account_options_class;
					$options->feedback_limit = 0;
					$options->notify_for = 'all';
					$phones = array('all_phones','all_codes');
					$emails = array('all_emails','all_codes');
					$options->phones[0] = $phones;
					$options->emails[0] = $emails;
					
					$s = serialize($options);
					$this->db->set($index,  $s);
				}
				else
				{
					$this->db->set($index,  $value);
				}
			}
			elseif(strcmp($index, 'active') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'last_login') == 0)
			{
				if(strcmp($value, 'now') == 0)
					$this->db->set('last_login', 'NOW()', false);
				else
					$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'sign_up_date') == 0)
			{
				if(strcmp($value, 'now') == 0)
					$this->db->set('sign_up_date', 'NOW()', false);
				else
					$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'plan_start') == 0)
			{
				if(strcmp($value, 'now') == 0)
					$this->db->set('plan_start', 'NOW()', false);
				else
					$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'plan_end') == 0)
			{
				if(strcmp($value, 'now') == 0)
					$this->db->set('plan_end', 'NOW()', false);
				else
					$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'phone_notifications') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'email_notifications') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'phone_noti_type') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'email_noti_type') == 0)
			{
				$this->db->set($index,  $value);
			}
		}
		$this->db->where('ID', (int)$id);
		return $this->db->update($this->table);
	}
	
	public function delete_user($id)
	{
		return $this->db->where('ID', (int) $id)
										->delete($this->table);
	}
	
	public function count($where = array())
	{
		return (int) $this->db->where($where)
			                    ->count_all_results($this->table);
	}
	
	public function list_users($where = array(), $nb = 0, $start = 0)
	{
		$this->db->select('*')
						 ->from($this->table)
						 ->where($where);
		if($nb != 0)
			$this->db->limit($nb, $start);
		return $this->db->order_by('ID', 'asc')
						 ->get()
						 ->result();
	}
	
		
	public function list_users_company($where = array(), $nb = 0, $start = 0)
	{
		$this->db->select('users.*,companies.name as company_name')
						 ->from('users');
			$this->db->join('companies', 'companies.user_id = users.ID', 'LEFT OUTER');
			$this->db->where($where);
  	
		if($nb != 0)
			$this->db->limit($nb, $start);
		  return $this->db->order_by('companies.name', 'asc')
						 ->get()
						 ->result();
	}
	
	
	
	public function get_user_by_id($id)
	{
		$query = $this->db->get_where($this->table, array('ID' => $id));
		if($result = $query->result_array())
			return $result[0];
		else 
			return 0;
	}
	
	public function get_user_by_name($username)
	{
		$query = $this->db->get_where($this->table, array('username' => $username));
		return $query->result_array();
	}
	
	public function get_user_id($username)
	{
		$query = $this->db->get_where($this->table, array('username' => $username));
		foreach($query->result_array() as $row)
			return $row['ID'];
	}
	
	public function get_user_id_from_email($email)
	{
		$query = $this->db->get_where($this->table, array('email' => $email));
		foreach($query->result_array() as $row)
			return $row['ID'];
	}
	
	public function get_user_data($id, $data)
	{
		$query = $this->db->get_where($this->table, array('ID' => $id));
		foreach($query->result_array() as $row)
			return $row[$data];
	}
	
	public function get_user_option($id, $option)
	{
		$s = $this->get_user_data($id, 'options');
		$options = unserialize($s);
		if(strcmp($option, 'critical_words') == 0)
			return $options->critical_words;
		if(strcmp($option, 'feedback_limit') == 0)
			return $options->feedback_limit;
		if(strcmp($option, 'notify_for') == 0)
			return $options->notify_for;
		if(strcmp($option, 'phones') == 0)
			return $options->phones;
		if(strcmp($option, 'emails') == 0)
			return $options->emails;
	}
	
}
