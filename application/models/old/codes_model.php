<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Codes_model extends CI_Model
{
	protected $table = 'codes';
	
	public function add_code($data = array())
	{
		foreach($data as $index => $value)
		{
			if($index == 'code')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'store_id')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'description')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'user_id')
			{
				$this->db->set($index, $value);
			}
			elseif($index == 'company_id')
			{
				$this->db->set($index, $value);
			}
			elseif($index == 'is_survey')
			{
				$this->db->set($index, $value);
			}
			elseif($index == 'is_global')
			{
				$this->db->set($index, $value);
			}
		}
		return $this->db->insert($this->table);
	}
	
	public function edit_code($id, $data = array())
	{
		foreach($data as $index => $value)
		{
			if($index == 'code')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'store_id')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'description')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'user_id')
			{
				$this->db->set($index, $value);
			}
			elseif($index == 'company_id')
			{
				$this->db->set($index, $value);
			}
			elseif($index == 'is_survey')
			{
				$this->db->set($index, $value);
			}
			elseif($index == 'is_global')
			{
				$this->db->set($index, $value);
			}
		}
		
		$this->db->where('ID', (int)$id);
		return $this->db->update($this->table);
	}
	
	public function delete_code($code)
	{
		return $this->db->where('code', $code)
										->delete($this->table);
	}
	
	public function count($where = array())
	{
		return (int) $this->db->where($where)
			                    ->count_all_results($this->table);
	}
	
	public function list_codes($where = array(), $nb = 0, $start = 0)
	{
		$this->db->select('*')
						 ->from($this->table)
						 ->where($where)
						 ->order_by('ID', 'desc');
		if(is_integer($nb) && is_integer($start) && $nb > 0 && $start >= 0)
			$this->db->limit($nb, $start);
		return $this->db->get()->result();
	}
	
	public function get_code_by_id($id)
	{
		$query = $this->db->get_where($this->table, array('ID' => $id));
		if($result = $query->result_array())
			return $result[0];
		else 
			return 0;
	}
	
	public function get_code_by_code($code)
	{
		$query = $this->db->get_where($this->table, array('code' => $code));
		if($result = $query->result_array())
			return $result[0];
		else 
			return 0;
	}
	
	public function get_code_id($code)
	{
		$query = $this->db->get_where($this->table, array('code' => $code));
		foreach($query->result_array() as $row)
			return $row['ID'];
	}
	
	public function get_code_data($id, $data)
	{
		$query = $this->db->get_where($this->table, array('ID' => $id));
		foreach($query->result_array() as $row)
			return $row[$data];
	}

	public function get_store_codes_ids($store_id)
	{
		$query = $this->db->get_where($this->table, array('store_id' => $store_id));
		$codes_ids = array();
		foreach($query->result_array() as $row)
			 $codes_ids[] = $row['ID'];
		return $codes_ids;
	}
	
	public function get_store_codes($store_id)
	{
		$query = $this->db->get_where($this->table, array('store_id' => $store_id));
		$codes = array();
		foreach($query->result_array() as $row)
			 $codes[$row['ID']] = $row['code'];
		return $codes;
	}
	
	public function get_target_codes($target_id)
	{
		$query = $this->db->get_where($this->table, array('user_id' => $target_id));
		$codes = array();
		foreach($query->result_array() as $row)
			 $codes[] = $row['code'];
		return $codes;
	}
	
	public function get_store_codes_number($store_id)
	{
		return $this->count(array('store_id' => $store_id));
	}
}
