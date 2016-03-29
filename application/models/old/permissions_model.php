<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Permissions_model extends CI_Model
{
	protected $table = 'permissions';
	
	public function add_permission($data = array())
	{
		
		foreach($data as $index => $value)
		{
			if($index == 'userid')
			{
				$this->db->set($index,  $value);
			}
			if($index == 'objectid')
			{
				$this->db->set($index,  $value);
			}
			if($index == 'objtype')
			{
				$this->db->set($index,  $value);
			}
		}
		
		$this->db->insert($this->table);
		return $this->db->insert_id();
	}
	
	public function edit_permission($id, $data = array())
	{
		foreach($data as $index => $value)
		{
			if($index == 'userid')
			{
				$this->db->set($index,  $value);
			}
			if($index == 'objectid')
			{
				$this->db->set($index,  $value);
			}
			if($index == 'objtype')
			{
				$this->db->set($index,  $value);
			}
		}
		
		$this->db->where('ID', (int)$id);
		return $this->db->update($this->table);
	}
	
	public function delete_permission($id)
	{
		return $this->db->where('ID', (int) $id)
										->delete($this->table);
	}
	
	public function count($where = array())
	{
		return (int) $this->db->where($where)->count_all_results($this->table);
	}
	
	public function list_permissions($where = array(), $nb = 0, $start = 0)
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
	
	public function get_permission_by_id($id)
	{
		$query = $this->db->get_where($this->table, array('ID' => $id));
		if($result = $query->result_array())
			return $result[0];
		else 
			return 0;
	}
	
	public function get_user_permissions($user_id)
	{
		$query = $this->db->get_where($this->table, array('user_id' => $user_id));
		$user_permissions = array();
		foreach($query->result_array() as $row)
			 $user_permissions[] = $row;
		return $user_permissions;
	}
}
