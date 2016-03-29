<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customers_model extends CI_Model
{
	protected $table = 'customers';
	
	public function add_customer($data = array())
	{
		
		foreach($data as $index => $value)
		{
			if(strcmp($index, 'email') == 0)
			{
				$this->db->set($index,  $value);
			}
			if(strcmp($index, 'phone') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'code') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'store_id') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'company_id') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'user_id') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'session_id') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'cookie_id') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'stopped') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'blacklisted') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'blacklisted_from') == 0)
			{
				if($value == 'now')
					$this->db->set($index, 'NOW()', false);
				else
					$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'blacklisted_to') == 0)
			{
				if($value == 'now')
					$this->db->set($index, 'NOW()', false);
				else
					$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'blacklist_period') == 0)
			{
				$this->db->set('blacklisted_from', 'NOW()', false);
				$this->db->set('blacklisted_to', 'DATE_ADD(NOW(),INTERVAL '.$value.' DAY)', false);
			}
		}
		$this->db->insert($this->table);
		return $this->db->insert_id();
	}
	
	public function edit_customer($id, $data = array())
	{
		foreach($data as $index => $value)
		{
			if(strcmp($index, 'email') == 0)
			{
				$this->db->set($index,  $value);
			}
			if(strcmp($index, 'phone') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'code') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'store_id') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'company_id') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'user_id') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'session_id') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'cookie_id') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'stopped') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'blacklisted') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'blacklisted_from') == 0)
			{
				if($value == 'now')
					$this->db->set($index, 'NOW()', false);
				else
					$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'blacklisted_to') == 0)
			{
				if($value == 'now')
					$this->db->set($index, 'NOW()', false);
				else
					$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'blacklist_period') == 0)
			{
				$this->db->set('blacklisted_from', 'NOW()', false);
				$this->db->set('blacklisted_to', 'DATE_ADD(NOW(),INTERVAL '.$value.' DAY)', false);
			}
		}
		
		$this->db->where('ID', (int)$id);
		return $this->db->update($this->table);
	}
	
	public function delete_customer($id)
	{
		return $this->db->where('ID', (int) $id)
										->delete($this->table);
	}
	
	public function count($where = array())
	{
		return (int) $this->db->where($where)
			                    ->count_all_results($this->table);
	}
	
	public function get_id_from_phone($phone)
	{
		$query = $this->db->get_where($this->table, array('phone' => $phone));
		foreach($query->result_array() as $row)
			return $row['ID'];
	}
	
	public function get_customer_data($id, $data)
	{
		$query = $this->db->get_where($this->table, array('ID' => $id));
		foreach($query->result_array() as $row)
			return $row[$data];
	}
	
	public function list_customers($where = array(), $nb = 0, $start = 0)
	{
		$this->db->select('*')
						 ->from($this->table)
						 ->where($where)
						 ->order_by('ID', 'desc');
		if(is_integer($nb) && is_integer($start) && $nb > 0 && $start >= 0)
			$this->db->limit($nb, $start);
		return $this->db->get()->result();
	}

	
}
