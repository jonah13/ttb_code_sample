<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'abstract_model.php';

class Sms_record_model extends Abstract_model
{
	protected $table;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->table = 'sms_record';
	}
	
	protected function set_object($data = array())
	{
		foreach($data as $index => $value)
        {
            if(strcmp('from', $index) == 0)
            {
                $this->db->set($index,  $value);
            }
            if(strcmp('to', $index) == 0)
            {
                $this->db->set($index,  $value);
            }
            if(strcmp('message', $index) == 0)
            {
                $this->db->set($index,  $value);
            }
            if(strcmp('ticket_id', $index) == 0)
            {
                $this->db->set($index,  $value);
            }
			if(strcmp('type', $index) == 0)
            {
                $this->db->set($index,  $value);
            }
			if(strcmp('expect', $index) == 0)
            {
                $this->db->set($index,  $value);
            }
            if(strcmp('time', $index) == 0)
            {
                if(strcmp($value, 'now') == 0)
                    $this->db->set($index, 'NOW()', false);
                else
                    $this->db->set($index,  $value);
            }
    	}
	}

    public function add_sms_record($data = array())
    {
        foreach($data as $index => $value)
        {
            if(strcmp('from', $index) == 0)
            {
                $this->db->set($index,  $value);
            }
            if(strcmp('to', $index) == 0)
            {
                $this->db->set($index,  $value);
            }
            if(strcmp('message', $index) == 0)
            {
                $this->db->set($index,  $value);
            }
            if(strcmp('ticket_id', $index) == 0)
            {
                $this->db->set($index,  $value);
            }
			if(strcmp('type', $index) == 0)
            {
                $this->db->set($index,  $value);
            }
			if(strcmp('expect', $index) == 0)
            {
                $this->db->set($index,  $value);
            }
            if(strcmp('time', $index) == 0)
            {
                if(strcmp($value, 'now') == 0)
                    $this->db->set($index, 'NOW()', false);
                else
                    $this->db->set($index,  $value);
            }
        }
         $this->db->insert($this->table);
						return $this->db->insert_id();
    }

	
}