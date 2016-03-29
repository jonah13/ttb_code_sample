<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comments_model extends CI_Model
{
	protected $table = 'comments';
	
	public function add_comment($data = array())
	{
		
		foreach($data as $index => $value)
		{
			if($index == 'comment')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'code')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'customer_id')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'nature')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'negative_nature')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'analyzer_nature')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'store_id')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'user_id')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'time')
			{
				if($value == 'now')
					$this->db->set('time', 'NOW()', false);
				else
					$this->db->set($index,  $value);
			}
			elseif($index == 'time_type')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'is_sms')
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
			elseif($index == 'session_id')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'indirect_source')
			{
				$this->db->set($index,  $value);
			}
		}
		
	  $this->db->insert($this->table);
		return $this->db->insert_id();
	}
	
	public function edit_comment($id, $data = array())
	{
		foreach($data as $index => $value)
		{
			if($index == 'comment')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'code')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'customer_id')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'nature')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'negative_nature')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'analyzer_nature')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'store_id')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'user_id')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'time')
			{
				if($value == 'now')
					$this->db->set('time', 'NOW()', false);
				else
					$this->db->set($index,  $value);
			}
			elseif($index == 'time_type')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'is_sms')
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
			elseif($index == 'session_id')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'indirect_source')
			{
				$this->db->set($index,  $value);
			}
		}
		
		$this->db->where('ID', (int)$id);
		return $this->db->update($this->table);
	}
	
	public function edit_comment_where($where, $data = array())
	{
		foreach($data as $index => $value)
		{
			if($index == 'comment')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'code')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'customer_id')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'nature')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'negative_nature')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'analyzer_nature')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'store_id')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'user_id')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'time')
			{
				if($value == 'now')
					$this->db->set('time', 'NOW()', false);
				else
					$this->db->set($index,  $value);
			}
			elseif($index == 'time_type')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'is_sms')
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
			elseif($index == 'session_id')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'indirect_source')
			{
				$this->db->set($index,  $value);
			}
		}
		
		$this->db->where($where);
		return $this->db->update($this->table);
	}
	
	public function delete_comment($id)
	{
		return $this->db->where('ID', (int)$id)
										->delete($this->table);
	}
	
	public function count($where = array())
	{
		if($where != null)
			return (int) $this->db->where($where)->count_all_results($this->table);
		else return 0;
	}
	
	public function list_comments($where = array(), $nb = 0, $start = 0)
	{
		if($where != null)
		{
		$this->db->select('comments.ID,  stores.name as store_name, codes.description as comment_type, companies.name as company_name, comments.comment, comments.nature, comments.store_id, comments.user_id, comments.customer_id, comments.is_sms, comments.time_type, comments.origin, comments.code, comments.indirect_source, comments.extra_data, comments.sec_extra_data, DATE_FORMAT(comments.time,\'%c/%e/%y %l:%i %p\') AS \'time\'', false)
						 ->from('comments')
						 ->join('stores', 'stores.ID = comments.store_id')
						 ->join('companies', 'companies.id = stores.company_id')
						 ->join('codes', 'codes.code = comments.code')
						 ->where($where)
						 ->order_by('comments.ID', 'desc');
		//echo $where;
		//$this->db->select('comments.*, users.company_name, users2.company_name as company_name2, stores.name, DATE_FORMAT(comments.time,\'%c/%e/%y %l:%i %p\') AS \'time\'' , false)
		//				 ->from('comments')
		//				 ->join('stores', 'stores.ID = comments.store_id')
		//				 ->join('users', 'users.ID = stores.user_id')
		//				 ->join('user_stores', 'user_stores.store_id = comments.store_id', 'LEFT OUTER')
		//				 ->join('users as users2', 'users2.ID = user_stores.user_id', 'LEFT OUTER')
		//				 ->where($where)
		//				 ->order_by('ID', 'desc');
		if(is_integer($nb) && is_integer($start) && $nb > 0 && $start >= 0)
			$this->db->limit($nb, $start);
		return $this->db->get()->result();
		}
		else
		return false;
	}
	
	public function list_all_comments()
	{
		$this->db->select('*')
							 ->from($this->table)
							 ->order_by('ID', 'desc');
			return $this->db->get()->result();
	}
	
	public function find_comments($where = array())
	{
		if($where != null)
		{
			$this->db->select('`ID`, `comment`, `code`, `customer_id`, `nature`, `store_id`, `user_id`, `is_sms`, `origin`, `extra_data`, DATE_FORMAT(`time`,\'%c/%e/%y %l:%i %p\') AS \'time\'', false)
						 ->from($this->table)
						 ->where($where)
						 ->order_by('ID', 'desc');
			return $this->db->get()->result();
		}
		else
			return false;
	}
		
	public function get_by_id($id)
	{
		$query = $this->db->get_where($this->table, array('ID' => $id));
		if($result = $query->result_array()){
			return $result[0];
		}else{ 
			return 0;
		}	
	}
		
	public function get_comment_data($id, $data)
	{
		$query = $this->db->get_where($this->table, array('ID' => $id));
		foreach($query->result_array() as $row)
			return $row[$data];
	}

	public function get_code_comments_ids($code)
	{
		$query = $this->db->get_where($this->table, array('code' => $code));
		$comments_ids = array();
		foreach($query->result_array() as $row)
			 $comments_ids[] = $row['ID'];
		return $comments_ids;
	}
	
}
