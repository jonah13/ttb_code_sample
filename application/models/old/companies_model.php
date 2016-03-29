<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Companies_model extends CI_Model
{
	protected $table;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->table = 'companies';
	}
	
	public function add_company($data = array())
	{
		
		foreach($data as $index => $value)
		{
			if(strcmp($index, 'name') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'user_id') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'plan_start') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'plan_months') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'plan_amount') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'plan_last_billed') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'options') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'active') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'address') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'city') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'state') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'zipcode') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'company_contact') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'phone') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'email') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'authnet_id') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'qr_page_style') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'custom_qr_sms_text')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'custom_field')
			{
				$this->db->set($index,  $value);
			}
		}
		
		return $this->db->insert($this->table);
	}
	
	public function edit_company($id, $data = array())
	{
		foreach($data as $index => $value)
		{
			if(strcmp($index, 'name') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'user_id') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'plan_start') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'plan_months') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'plan_amount') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'plan_last_billed') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'options') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'active') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'address') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'city') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'state') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'zipcode') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'company_contact') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'phone') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'email') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'authnet_id') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'qr_page_style') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'custom_qr_sms_text')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'custom_field')
			{
				$this->db->set($index,  $value);
			}
		}
		$this->db->where('id', (int)$id);
		return $this->db->update($this->table);
	}
	
	public function delete_company($id)
	{
		return $this->db->where('id', (int) $id)
										->delete($this->table);
	}
	
	public function count($where = array())
	{
		return (int) $this->db->where($where)
			                    ->count_all_results($this->table);
	}
	
	public function list_companies($where = array(), $nb = 0, $start = 0)
	{
		$this->db->select('*')
						 ->from($this->table)
						 ->where($where);
		if($nb != 0)
			$this->db->limit($nb, $start);
		return $this->db->order_by('id', 'asc')
						 ->get()
						 ->result();
	}
	
	public function get_company_by_id($id)
	{
		$query = $this->db->get_where($this->table, array('id' => $id));
		if($result = $query->result_array())
			return $result[0];
		else 
			return 0;
	}
	
	public function get_company_by_name($name)
	{
		$query = $this->db->get_where($this->table, array('name' => $name));
		return $query->result_array();
	}
	
	public function get_company_id($name)
	{
		$query = $this->db->get_where($this->table, array('name' => $name));
		foreach($query->result_array() as $row)
			return $row['ID'];
	}
	
	public function get_user_id_for_company($id)
	{
		$query = $this->db->get_where($this->table, array('id' => $id));
		foreach($query->result_array() as $row)
			return $row['user_id'];
	}
	
	public function get_company_data($id, $data)
	{
		$query = $this->db->get_where($this->table, array('id' => $id));
		foreach($query->result_array() as $row)
			return $row[$data];
	}
	
	public function get_company_by_user_id($user_id)
	{
		$query = $this->db->get_where($this->table, array('user_id' => $user_id));
		if($result = $query->result_array())
			return $result[0];
		else 
			return 0;
	}
	
	public function get_company_data_by_user_id($user_id, $data)
	{
		$query = $this->db->get_where($this->table, array('user_id' => $user_id));
		foreach($query->result_array() as $row)
			return $row[$data];
		return 0;
	}
	
	public function get_stores_by_company($company_id){
	  $this->db->select('*');
    $this->db->from('stores');
    $this->db->where('company_id', $company_id);
		$query = $this->db->get();
		
		$stores = array();
		foreach($query->result_array() as $row)
			 $stores[$row['ID']] = $row;
		return $stores;
	}
	
}
