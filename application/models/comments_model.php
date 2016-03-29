<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'abstract_model.php';

class Comments_model extends Abstract_model
{
	protected $table;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->table = 'comments';
	}
		
	protected function set_object($data = array())
	{
		foreach($data as $index => $value)
		{
			if($index == 'code_id')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'comment')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'code')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'location_id')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'company_id')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'time')
			{
				if($value == 'now')
					$this->db->set($index, 'NOW()', false);
				else
					$this->db->set($index,  $value);
			}
			elseif($index == 'comment_time')
			{
				if($value == 'now')
					$this->db->set($index, 'NOW()', false);
				else
					$this->db->set($index,  $value);
			}
			elseif($index == 'time_type')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'analyzer_nature')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'nature')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'origin')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'extra_data')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'sec_extra_data')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'indirect_origin')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'phone_number')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'ip_address')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'cookie_id')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'user_agent')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'session_id')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'admin_id')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'is_test')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'seen')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'seen_by')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'rating')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'contact')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'unit')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'contest')
			{
				$this->db->set($index,  $value);
			}
		}
	}
	
	public function edit_where($where, $data = array())
	{
		$this->set_object($data);
		$this->db->where($where);
		return $this->db->update($this->table);
	}
	
	public function list_comments($sWhere, $sOrder, $sLimit)
	{
		//log_message('error', '<pre>'.print_r($sLimit, true).'</pre>');
		$this->db->select('comments.ID, comments.comment, comments.comment_time, comments.time_type, comments.nature, comments.origin, comments.indirect_origin, comments.extra_data, comments.sec_extra_data, companies.cf_type as cf_name, companies.cf2_type as cf2_name, comments.code, codes.description as code_desc, locations.name as location, locations.timezone as timezone, companies.name as company, comments.is_test, comments.seen, users.username as seen_by')
						 ->from($this->table)
						 ->join('locations', 'locations.ID = comments.location_id')
						 ->join('companies', 'companies.ID = comments.company_id')
						 ->join('codes', 'codes.ID = comments.code_id')
						 ->join('users', 'users.ID = comments.seen_by');
		if(!empty($sWhere))
			$this->db->where($sWhere);
		if(!empty($sLimit[0]))
			$this->db->limit($sLimit[0], $sLimit[1]);
		if(empty($sOrder))
			$sOrder = 'ID desc';
		$this->db->order_by($sOrder);
		$r = $this->db->get()->result_array();
		//log_message('error', '<pre>'.print_r($this->db->last_query(), true).'</pre>');
		return $r;
	}
	
	public function count_total_filtred_results($sWhere)
	{
		$this->db->select('*')
						 ->from($this->table)
						 ->join('locations', 'locations.ID = comments.location_id')
						 ->join('companies', 'companies.ID = comments.company_id')
						 ->join('codes', 'codes.ID = comments.code_id')
						 ->join('users', 'users.ID = comments.seen_by');
		if(!empty($sWhere))
			$this->db->where($sWhere);
		return $this->db->count_all_results();
	}

	public function delete_by_id($id)
	{
		return $this->db->where(array('ID'=>$id))
										->delete($this->table);
	}

	public function delete_by_location_id($lid)
	{
		return $this->db->where(array('location_id'=>$lid))
										->delete($this->table);
	}

	public function delete_by_code_id($cid)
	{
		return $this->db->where(array('code_id'=>$cid))
										->delete($this->table);
	}
	
	public function get_by_id($id)
	{
		$this->db->select('*')->from($this->table);
		$this->db->where('ID = ',$id);
		$r = $this->db->get()->result_array();
		return $r;
	}
	
	public function get_by_company_id($id,$locations = array(),$codes = array(),$units = array(),$exp = array(),$source = array(),$date_filter = array())
	{
		$this->db->select('comments.*,UNIX_TIMESTAMP(comments.time) utime,locations.name locname, locations.timezone, codes.description code_desc')
			->from($this->table)
			->join('locations','locations.ID = comments.location_id')
			->join('codes', 'codes.ID = comments.code_id');
		$this->db->where('comments.company_id = ',$id);
		if (!empty($locations)) {
			$this->db->where_in('locations.name',$locations);
		}
		if (!empty($codes)) {
			$this->db->where_in('comments.code',$codes);
		}
		if (!empty($units)) {
			$this->db->where_in('comments.unit',$units);
		}
		if (!empty($exp)) {
			$this->db->where_in('comments.nature',$exp);
		}
		if (!empty($source)) {
			$this->db->where_in('comments.origin',$source);
		}
		if (!empty($date_filter)) {
			$start = strtotime($date_filter['start']);
			$end = strtotime($date_filter['end']) + 3600*24;
			$this->db->where('(UNIX_TIMESTAMP(comments.time) >= '.$start.' AND UNIX_TIMESTAMP(comments.time) <= '.$end.')');
		}
		$r = $this->db->get()->result_array();
		return $r;
	}
	
	public function get_locations_for_company_id($id) {
		$this->db->select('locations.name locname')
			->from($this->table)
			->join('locations','locations.ID = comments.location_id')
			->group_by('locations.name');
		$this->db->where('comments.company_id = ',$id);
		$r = $this->db->get()->result_array();
		return $r;
	}
	
	public function get_codes_for_company_id($id) {
		$this->db->select('code')
			->from($this->table)
			->group_by('code');
		$this->db->where('comments.company_id = ',$id);
		$r = $this->db->get()->result_array();
		return $r;
	}
	
	public function get_units_for_company_id($id) {
		$this->db->select('unit')
			->from($this->table)
			->group_by('unit');
		$this->db->where('comments.company_id = ',$id);
		$this->db->where('comments.unit != ','');
		$r = $this->db->get()->result_array();
		return $r;
	}
	
	public function put_by_id($data)
	{
		$this->db->where('ID',$data['ID']);
		$this->db->update($this->table,$data);
	}
	
}
