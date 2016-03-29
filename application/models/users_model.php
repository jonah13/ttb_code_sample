<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'abstract_model.php';

class Users_model extends Abstract_model
{
	public function __construct()
	{
		parent::__construct();
		$this->table = 'users';
		$this->link_table = 'user_rights';
		$this->contacts_table = 'user_phones_emails';
	}
	protected function set_object($data = array())
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
			elseif(strcmp($index, 'phone') == 0)
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
			elseif(strcmp($index, 'type') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'signup_date') == 0)
			{
				if(strcmp($value, 'now') == 0)
					$this->db->set($index, 'NOW()', false);
				else
					$this->db->set($index, $value);
			}
			elseif(strcmp($index, 'last_login') == 0)
			{
				if(strcmp($value, 'now') == 0)
					$this->db->set($index, 'NOW()', false);
				else
					$this->db->set($index, $value);
			}
			elseif(strcmp($index, 'is_active') == 0)
			{
				$this->db->set($index,  $value);
			}
			
		}
		
	}
	
	public function get_by_id($user_id)
	{
		$query = $this->db->get_where($this->table, array('ID' => $user_id));
		$result = $query->result_array();
		return $result[0];
	}
	
	public function get_by_username($username)
	{
		$query = $this->db->get_where($this->table, array('username' => $username));
		$result = $query->result_array();
		return $result[0];
	}
	
	public function get_by_email($email)
	{
		$query = $this->db->get_where($this->table, array('email' => $email));
		return $query->result_array();
	}
	
	public function get_id_from_username($username)
	{
		$query = $this->db->get_where($this->table, array('username' => $username));
		foreach($query->result_array() as $row)
			return $row['ID'];
	}
	
	public function get_id_from_email($email)
	{
		$query = $this->db->get_where($this->table, array('email' => $email));
		foreach($query->result_array() as $row)
			return $row['ID'];
	}
	
	public function get_rights($user_id)
	{
		return $this->db->select('*')
						 ->from($this->link_table)
						 ->where(array('user_id' => $user_id))
						 ->get()
						 ->result_array();
	}
	
	public function get_rights_by_type($user_id, $type)
	{
		$result =  $this->db->select($type.'_id')
						 ->from($this->link_table)
						 ->where(array('user_id' => $user_id, 'target_type' => $type))
						 ->get()
						 ->result_array();
		if(!empty($result))
		{
			$i = 0;
			foreach($result as $r)
			{
				$result[$i] = (int) $r[$type.'_id'];
				$i++;
			}
		}
		
		return $result;
	}
	
	public function assign_rights($user_id, $target_id, $target_type)
	{
		if($this->is_assigned($user_id, $target_id, $target_type))
			return null;
		$this->db->set('user_id',  $user_id);
		$this->db->set($target_type.'_id',  $target_id);
		$this->db->set('target_type',  $target_type);
		$this->db->insert($this->link_table);
		return $this->db->insert_id();
	}
	
	public function remove_right($user_id, $target_id, $target_type)
	{
		return $this->db->where(array('user_id' => (int) $user_id, $target_type.'_id' => (int) $target_id, 'target_type' => $target_type))
										->delete($this->link_table);
	}
	
	public function is_assigned($user_id, $target_id, $target_type)
	{
		$result = (int) $this->db->where(array('user_id' => (int) $user_id, $target_type.'_id' =>  (int) $target_id, 'target_type' => $target_type))
			                    ->count_all_results($this->link_table);
		if($result == 0)
			return false;
		else
			return true;
	}
	
	public function unassign_all($user_id)
	{
		return $this->db->where('user_id', (int) $user_id)
										->delete($this->link_table);
	}
	
	public function unassign_all_by_type($user_id, $target_type)
	{
		return $this->db->where(array('user_id' => (int) $user_id, 'target_type' => $target_type))
										->delete($this->link_table);
	}
	
	public function add_phone_email($user_id, $phone_email, $type, $notify_for)
	{
		if(!empty($phone_email)/*  && !$this->phone_email_exist($phone_email) */)
		{
			$this->db->set('user_id',  $user_id);
			$this->db->set('contact_type',  $type);
			$this->db->set('contact',  $phone_email);
			$this->db->set('notify_for',  $notify_for);
			$this->db->insert($this->contacts_table);
			return $this->db->insert_id();
		}
		else
			return false;
	}
	
	public function add_phone($user_id, $phone, $notify_for)
	{
		return $this->add_phone_email($user_id, $phone, 'phone', $notify_for);
	}
	
	public function add_email($user_id, $email, $notify_for)
	{
		return $this->add_phone_email($user_id, $email, 'email', $notify_for);
	}
	
	public function get_phones($user_id)
	{
		return $this->db->select('contact, notify_for')
						 ->from($this->contacts_table)
						 ->where(array('user_id' => $user_id, 'contact_type' => 'phone'))
						 ->get()
						 ->result_array();
	}
	
	public function get_emails($user_id)
	{
		return $this->db->select('contact, notify_for')
						 ->from($this->contacts_table)
						 ->where(array('user_id' => $user_id, 'contact_type' => 'email'))
						 ->get()
						 ->result_array();
	}
	
	public function get_phones_emails($user_id)
	{
		return $this->db->select('contact, notify_for, contact_type')
						 ->from($this->contacts_table)
						 ->where(array('user_id' => $user_id))
						 ->get()
						 ->result_array();
	}
	
	public function phone_email_exist($phone_email)
	{
		$result = (int) $this->db->where(array('contact' => $phone_email))
			                    ->count_all_results($this->contacts_table);
		if($result == 0)
			return false;
		else
			return true;
	}
	
	public function remove_all_phones_emails($user_id)
	{
		return $this->db->where('user_id', (int) $user_id)
										->delete($this->contacts_table);
	}
	
	public function get_users_for_company($company_id)
	{
		return $this->db->select('u.*')
						 ->from($this->table.' u')
						 ->join($this->link_table.' r','r.user_id = u.ID','left')
						 ->where(array('r.target_type' => 'company','r.company_id' => $company_id))
						 ->get()
						 ->result_array();
	}
	
	public function get_users_for_location($location_id)
	{
		return $this->db->select('u.*')
						 ->from($this->table.' u')
						 ->join($this->link_table.' r','r.user_id = u.ID','left')
						 ->where(array('r.target_type' => 'location','r.location_id' => $location_id))
						 ->get()
						 ->result_array();
	}
	
	public function put_by_id($data)
	{
		$this->db->where('ID',$data['ID']);
		$this->db->update($this->table,$data);
	}
	
	public function delete_permissions_by_location_id($lid)
	{
		return $this->db->where(array('target_type'=>'location','location_id'=>$lid))
										->delete($this->link_table);
	}
	
	public function delete_by_id($uid)
	{
		return $this->db->where('ID', $uid)
										->delete($this->table);
	}

	public function delete_permissions_by_id($uid)
	{
		return $this->db->where('user_id', $uid)
										->delete($this->link_table);
	}

	public function add($data)
	{
		unset($data['ID']);
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();
	}
	
}
