<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'abstract_model.php';

class Customers_model extends Abstract_model
{
	protected $table;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->table = 'customers';
	}
	
	protected function set_object($data = array())
	{
		foreach($data as $index => $value)
        {
            if(strcmp('phone', $index) == 0)
            {
                $this->db->set($index,  $value);
            }
            if(strcmp('stopped', $index) == 0)
            {
                $this->db->set($index,  $value);
            }
    	}
	}

	public function get_id_from_phone($phone)
	{
		$query = $this->db->get_where($this->table, array('phone' => $phone));
		foreach($query->result_array() as $row)
			return $row['ID'];
	}
}