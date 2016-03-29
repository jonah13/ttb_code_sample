<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Regions_model extends CI_Model
{
	protected $table = 'regions';
	
	public function add_region($data = array())
	{
		
		foreach($data as $index => $value)
		{
			if($index == 'name')
			{
				$this->db->set($index,  $value);
			}
			if($index == 'parent_region_id')
			{
				$this->db->set($index,  $value);
			}
		}
		
		$this->db->insert($this->table);
		return $this->db->insert_id();
	}
	
	public function edit_region($id, $data = array())
	{
		foreach($data as $index => $value)
		{
			if($index == 'name')
			{
				$this->db->set($index,  $value);
			}
			if($index == 'parent_region_id')
			{
				$this->db->set($index,  $value);
			}
		}
		
		$this->db->where('ID', (int)$id);
		return $this->db->update($this->table);
	}
	
	public function delete_region($id)
	{
		return $this->db->where('ID', (int) $id)
										->delete($this->table);
	}
	
	public function count($where = array())
	{
		return (int) $this->db->where($where)->count_all_results($this->table);
	}
	
	public function list_regions($where = array(), $nb = 0, $start = 0)
	{
		$this->db->select('*')
						 ->from($this->table)
						 ->where($where);
		if($nb != 0)
			$this->db->limit($nb, $start);
		return $this->db->order_by('ID', 'desc')
						 ->get()
						 ->result();
	}
	
	public function get_region_by_id($id)
	{
		$query = $this->db->get_where($this->table, array('ID' => $id));
		if($result = $query->result_array())
			return $result[0];
		else 
			return 0;
	}
	
}
