<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Codes_model extends Abstract_model
{
	protected $table;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->table = 'codes';
	}
	
	protected function set_object($data = array())
	{
		foreach($data as $index => $value)
		{
			if($index == 'location_id')
			{
				$this->db->set($index,  $value);
			}
			if($index == 'company_id')
			{
				$this->db->set($index,  $value);
			}
			if($index == 'code')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'description')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'is_global')
			{
				$this->db->set($index, $value);
			}
			elseif($index == 'negative_type')
			{
				$this->db->set($index, $value);
			}
		}
		
	}
	
	
	public function delete_by_code($code)
	{
		return $this->db->where('code', $code)
										->delete($this->table);
	}
	
	public function delete_by_id($cid)
	{
		return $this->db->where('ID', $cid)
										->delete($this->table);
	}
	
	public function delete_by_location_id($lid)
	{
		return $this->db->where('location_id', $lid)
										->delete($this->table);
	}
	
	public function get_by_company_id($id)
	{
		$query = $this->db->get_where($this->table, array('company_id' => $id));
		return $query->result_array();
	}
	
	public function get_by_code($code)
	{
		$query = $this->db->get_where($this->table, array('code' => $code));
		if($result = $query->result_array())
			return $result[0];
		else 
			return 0;
	}
	
	public function get_id_from_code($code)
	{
		$query = $this->db->get_where($this->table, array('code' => $code));
		foreach($query->result_array() as $row)
			return $row['ID'];
	}

	public function get_by_location_id($id)
	{
		$query = $this->db->get_where($this->table, array('location_id' => $id));
		return $query->result_array();
	}
	
	public function put_by_id($data)
	{
		$this->db->where('ID',$data['ID']);
		$this->db->update($this->table,$data);
	}

	
}
