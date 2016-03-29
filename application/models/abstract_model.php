<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

abstract class Abstract_model extends CI_Model
{
	protected $table;
	abstract protected function set_object($data = array());
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function add($data = array())
	{
		$this->set_object($data);
		$this->db->insert($this->table);
		return $this->db->insert_id();
	}
	
	public function edit($id, $data = array())
	{
		$this->set_object($data);
		$this->db->where('id', (int)$id);
		return $this->db->update($this->table);
	}
	
	public function delete($id)
	{
		return $this->db->where('id', (int) $id)
										->delete($this->table);
	}
	
	public function count($where = array())
	{
		return (int) $this->db->where($where)->count_all_results($this->table);
	}
	
	public function list_records($where = array(), $nb = 0, $start = 0, $order_by = '')
	{
		$this->db->select('*')
						 ->from($this->table)
						 ->where($where);
		if($nb != 0)
			$this->db->limit($nb, $start);
		if(!empty($order_by[0]) && !empty($order_by[1]))
			$this->db->order_by($order_by[0], $order_by[1]);
		else
			$this->db->order_by('ID', 'desc');
		return $this->db->get()
						->result();
	}
	
	public function list_by_id($where = array(), $nb = 0, $start = 0, $order_by = 'ID', $order_dir = 'desc')
	{
		$this->db->select('*')
						 ->from($this->table)
						 ->where($where);
		if($nb != 0)
			$this->db->limit($nb, $start);
		$t = $this->db->order_by($order_by, $order_dir)
						 ->get()
						 ->result_array();
		$r = array();
		foreach($t as $v)
			$r[$v['ID']] = $v;
		return $r;
	}
	
	public function get_by_id($id)
	{
		$query = $this->db->get_where($this->table, array('ID' => $id));
		if($result = $query->result_array())
			return $result[0];
		else 
			return 0;
	}
	
	public function get_data($id, $data)
	{
		$query = $this->db->get_where($this->table, array('ID' => $id));
		foreach($query->result_array() as $row)
			return $row[$data];
	}
	
	public function count_distinct($what, $where = array())
	{
		$this->db->select($what)->distinct()->from($this->table)->where($where);
		return $this->db->get()->num_rows();
	}
	
	
}
