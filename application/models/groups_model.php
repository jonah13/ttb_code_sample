<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'abstract_model.php';

class Groups_model extends Abstract_model
{
	protected $table;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->table = 'groups';
		$this->link_table = 'group_locations';
	}
	
	protected function set_object($data = array())
	{
		foreach($data as $index => $value)
		{
			if(strcmp($index, 'name') == 0)
			{
				$this->db->set($index,  $value);
			}
			if(strcmp($index, 'type') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'company_id') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'has_parent') == 0)
			{
				$this->db->set($index,  $value);
			}
		}
	}
	
	public function get_binded_locations($group_id) //Directly binded locations only
	{
		return $this->db->select('t1.location_id')
						 ->from($this->link_table.' t1')
 						 ->join("locations t2","t2.ID = t1.location_id","left")
						 ->where(array('t1.group_id' => $group_id, "t1.location_id IS NOT NULL" => null))
						 ->order_by('t2.name','asc')
						 ->get()
						 ->result_array();
	}
	
	public function get_locations_ids($group_id) //Directly binded locations only
	{
		$r = $this->get_binded_locations($group_id);
		$n = array();
		foreach($r as $i)
			$n[] = $i['location_id'];
		return $n;
	}
	
	public function get_binded_subgroups($group_id) //Directly binded sub groups only
	{
		return $this->db->select('subgroup_id')
						 ->from($this->link_table.' t1')
 						 ->join("groups t2","t2.ID = t1.subgroup_id","left")
						 ->where(array('t1.group_id' => $group_id, "t1.subgroup_id IS NOT NULL" => null))
						 ->order_by('t2.type,t2.name')
						 ->get()
						 ->result_array();
	}
	
	public function get_subgroups_ids($group_id) //Directly binded subgroups only
	{
		$r = $this->get_binded_subgroups($group_id);
		$n = array();
		foreach($r as $i)
			$n[] = $i['subgroup_id'];
		return $n;
	}
	
	public function bind_location($group_id, $location_id)
	{
		if($this->is_binded($group_id, $location_id))
			return null;
		$this->db->set('group_id',  $group_id);
		$this->db->set('location_id',  $location_id);
		$this->db->insert($this->link_table);
		return $this->db->insert_id();
	}
	
	public function unbind_location_from_parent($loc_id)
	{
		return $this->db->where(array('location_id' => (int) $loc_id))
										->delete($this->link_table);
	}
	
	public function unbind_subgroup_from_parent($sg_id)
	{
		return $this->db->where(array('subgroup_id' => (int) $sg_id))
										->delete($this->link_table);
	}
	
	public function bind_subgroup($group_id, $subgroup_id)
	{
		if($this->is_binded($group_id, $subgroup_id, 'group'))
			return null;
		$this->db->set('group_id',  $group_id);
		$this->db->set('subgroup_id',  $subgroup_id);
		$this->db->insert($this->link_table);
		return $this->db->insert_id();
	}
	
	public function unbind_location($group_id, $location_id)
	{
		return $this->db->where(array('group_id' => (int) $group_id, 'location_id' => (int) $location_id))
										->delete($this->link_table);
	}
	
	public function unbind_subgroup($group_id, $subgroup_id)
	{
		return $this->db->where(array('group_id' => (int) $group_id, 'subgroup_id' => (int) $subgroup_id))
										->delete($this->link_table);
	}
	
	public function is_binded($group_id, $target_id, $check_for  = "location")
	{
		if($check_for == "location")
			$result = (int) $this->db->where(array('group_id' => $group_id, 'location_id' => $target_id))
													 ->count_all_results($this->link_table);
		else
			$result = (int) $this->db->where(array('group_id' => $group_id, 'subgroup_id' => $target_id))
													 ->count_all_results($this->link_table);
		if($result == 0)
			return false;
		else
			return true;
	}
	
	public function unbind_all($group_id) //unbind the group from all locations and sub groups
	{
		return $this->db->where('group_id', (int) $group_id)
										->delete($this->link_table);
	}

	public function get_by_company_id($id)
	{
		$query = $this->db->get_where($this->table, array('company_id' => $id));
		return $query->result_array();
	}
	
	public function get_unbound_by_company_id($id)
	{
		$query = $this->db->select('*')
							->from($this->table.' t1 ')
							->join("group_locations t2","t1.ID = t2.subgroup_id","left")
							->where(array('t1.company_id' => $id, "t2.subgroup_id IS NULL" => null))
							->order_by('t1.type,t1.name')
							->get()
							->result_array();
/*
		$locations = array();
		foreach ($query as $q) {
			$locations[] = $q['ID'];
		}
*/
		return $query;
	}

	public function get_group_id($locationid)
	{
		$query = $this->db->get_where($this->link_table, array('location_id' => $locationid));
		return $query->result_array();
	}
	
	public function put_by_id($data)
	{
		$this->db->where('ID',$data['ID']);
		$this->db->update($this->table,$data);
	}

	public function delete_by_id($gid)
	{
		$this->db->where('group_id', $gid)
										->delete($this->link_table);
		return $this->db->where('ID', $gid)
										->delete($this->table);
	}
}
