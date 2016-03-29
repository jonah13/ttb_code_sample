<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sms_record_model extends CI_Model
{
        protected $table = 'all_sms_record';
        
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

        public function edit_sms_record($id, $data = array())
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
                $this->db->where('ID', (int)$id);
                return $this->db->update($this->table);
        }

        public function delete_sms_record($id)
        {
                return $this->db->where('ID', (int) $id)->delete($this->table);
        }

        public function count($where = array())
        {
                return (int) $this->db->where($where,NULL, FALSE)->count_all_results($this->table);
        }
				
				public function count_all($where = array())
        {
                return (int) $this->db->where($where)->count_all_results($this->table);
        }

        public function list_sms_records($where = array(), $nb = 0, $start = 0)
        {
                $this->db->select('`ID`, `message`, `type`, `expect`')
                    ->from($this->table)
                    ->where($where)
                    ->order_by('ID', 'desc');
                if(is_integer($nb) && is_integer($start) && $nb > 0 && $start >= 0)
                        $this->db->limit($nb, $start);
                return $this->db->get()->result();
        }
}