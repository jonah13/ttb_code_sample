<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'abstract_model.php';

class Locations_model  extends Abstract_model
{
	protected $table;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->table = 'locations';
	}
	
	protected function set_object($data = array())
	{
		foreach($data as $index => $value)
		{
			if($index == 'company_id')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'name')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'business_type')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'address')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'city')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'state')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'zipcode')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'website')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'is_active')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'timezone')
			{
				$this->db->set($index,  $value);
			}
		}
	}
	
	public function get_id_from_name($name)
	{
		$query = $this->db->get_where($this->table, array('name' => $name));
		foreach($query->result_array() as $row)
			return $row['ID'];
	}
	
	public function get_by_company_id($id)
	{
		$query = $this->db->get_where($this->table, array('company_id' => $id));
		return $query->result_array();
	}

	public function get_unbound_by_company_id($id)
	{
		$query = $this->db->select('ID')
							->from($this->table.' t1 ')
							->join("group_locations t2","t1.ID = t2.location_id","left")
							->where(array('t1.company_id' => $id, "t2.location_id IS NULL" => null))
							->order_by('name','acs')
							->get()
							->result_array();
		$locations = array();
		foreach ($query as $q) {
			$locations[] = $q['ID'];
		}
		return $locations;
	}

	public function get_by_id($id)
	{
		$query = $this->db->get_where($this->table, array('ID' => $id));
		return $query->result_array();
	}
	
	public function put_by_id($data)
	{
		$this->db->where('ID',$data['ID']);
		$this->db->update($this->table,$data);
	}
	
	public function add($data)
	{
		unset($data['ID']);
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();
	}
	
	public function delete_by_id($lid)
	{
		return $this->db->where('ID', $lid)
										->delete($this->table);
	}
}
