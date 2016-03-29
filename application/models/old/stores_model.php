<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stores_model extends CI_Model
{
	protected $table = 'stores';
	
	public function add_store($data = array())
	{
		foreach($data as $index => $value)
		{
			if($index == 'user_id')
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
			elseif($index == 'phone')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'fax')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'website')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'email')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'logo')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'description')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'placard')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'company_id')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'timezone')
			{
				$this->db->set($index,  $value);
			}
		}
		
		return $this->db->insert($this->table);
	}
	
	public function edit_store($id, $data = array())
	{
		foreach($data as $index => $value)
		{
			if($index == 'user_id')
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
			elseif($index == 'phone')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'fax')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'website')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'email')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'logo')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'description')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'placard')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'company_id')
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'timezone')
			{
				$this->db->set($index,  $value);
			}
		}
		
		$this->db->where('ID', (int)$id);
		return $this->db->update($this->table);
	}
	
	public function delete_store($id)
	{
		return $this->db->where('ID', (int) $id)
										->delete($this->table);
	}
	
	public function count($where = array())
	{
		return (int) $this->db->where($where)->count_all_results($this->table);
	}
	
	public function list_stores($where = array(), $nb = 0, $start = 0)
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
	
	public function get_store_by_id($id)
	{
		//$query = $this->db->get_where($this->table, array('ID' => $id));
		$this->db->select('stores.*, companies.name as company_name, users.first_name, users.last_name');
    $this->db->from('stores');
		$this->db->join('companies', 'companies.id = stores.company_id', 'left outer');
    $this->db->join('users', 'users.ID = stores.user_id', 'left outer');
		$this->db->where('stores.ID', $id);
		$query = $this->db->get();
		if($result = $query->result_array()){
			return $result[0];
		}else{ 
			return 0;
		}	
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
	
	public function get_store_id($name)
	{
		$query = $this->db->get_where($this->table, array('name' => $name));
		foreach($query->result_array() as $row)
			return $row['ID'];
	}
	
	public function get_stores_by_client($user_id = 0)
	{
	  if($user_id > 0){
		  $query = $this->db->get_where($this->table, array('user_id' => $user_id));
		 } else {
			$query = $this->db->get($this->table);
		}
		$stores = array();
		foreach($query->result_array() as $row)
			 $stores[] = $row;
		return $stores;
	}
	
	public function get_user_stores_ids($user_id)
	{
	    $stores_ids = array();
		
		  $this->db->select('stores.ID');
      $this->db->from('stores');
  		$this->db->where('stores.user_id', $user_id);
			$query = $this->db->get();
			foreach($query->result_array() as $row)
			{
				$stores_ids[] = $row['ID'];
			}
	
	  	$this->db->select('stores.ID');
      $this->db->from('user_stores');
      $this->db->join('stores', 'stores.ID = user_stores.store_id');
			$this->db->where('user_stores.user_id', $user_id); 
			$this->db->where('user_stores.active', '1');
 			$this->db->order_by("stores.ID", "asc"); 
		  $query = $this->db->get();
			foreach($query->result_array() as $row)
			{
				$stores_ids[] = $row['ID'];
			}

		foreach($query->result_array() as $row)
			 $stores_ids[] = $row['ID'];
		return $stores_ids;
	}
	
	
	public function get_user_stores_data($user_id)
	{
	 		$stores = array();
  	  $this->db->select('stores.*, companies.name as company_name');
      $this->db->from('stores');
			$this->db->join('companies', 'companies.id = stores.company_id');
  		$this->db->where('stores.user_id', $user_id);
			$query = $this->db->get();
			foreach($query->result_array() as $row)
			{
				$stores[$row['ID']] = $row;
			}
	
	  	$this->db->select('stores.*, companies.name as company_name');
      $this->db->from('user_stores');
      $this->db->join('stores', 'stores.ID = user_stores.store_id');
			$this->db->join('companies', 'companies.id = stores.company_id');
  		$this->db->where('user_stores.user_id', $user_id); 
			$this->db->where('user_stores.active', '1');
 			$this->db->order_by("stores.ID", "asc"); 
		  $query = $this->db->get();
			foreach($query->result_array() as $row)
			{
				$stores[$row['ID']] = $row;
			}
			
			if(count($stores) < 1){
			  return false;
			} else {
					   $current_store_id = 0;
  					 foreach ($stores as $key=>$value)
  					 {
						   $stores[$key]['codes'] = $this->codes_model->get_store_codes($key);
						 }
				return $stores;		 
			}		
	}
	
	
	public function get_user_stores_number($user_id)
	{
	  $this->db->select('stores.ID');
    $this->db->from('user_stores');
    $this->db->join('stores', 'stores.ID = user_stores.store_id');
		$this->db->where('user_stores.user_id', $user_id); 
		$this->db->where('user_stores.active', '1');
		$set_stores = $this->db->count_all_results();
		
		$this->db->select('stores.ID');
    $this->db->from('stores');
    $this->db->where('stores.user_id', $user_id); 
		$set_stores = $set_stores + $this->db->count_all_results();
		
		return (int) $set_stores;
		
		//return (int) $this->db->where(array('user_id' => $user_id))->count_all_results($this->table);
	}
	
	public function get_store_data($id, $data)
	{
		$query = $this->db->get_where($this->table, array('ID' => $id));
		foreach($query->result_array() as $row)
			return $row[$data];
	}
	
	public function belongs_to_user($id, $user_id)
	{
	  $user_stores = $this->get_user_stores_ids($user_id);
		if (is_array($user_stores)){
			 foreach ($user_stores as $key=>$value){
			  			if($id==$value){
							  return true;
							}
			 }
		}
		return false; 
		//$where = array('ID'=>$id, 'user_id'=>$user_id);
		//$n = $this->count($where);
		//if($n == 1) 
		//	return true;
		//else
		//	return false;
	}
	
	public function get_users_by_store($store_id = NULL){
		$this->db->select('users.*, companies.name as company_name');
    $this->db->from('user_stores');
    $this->db->join('users', 'users.ID = user_stores.user_id');
		$this->db->join('companies', 'companies.user_id = users.ID', 'LEFT OUTER');
		$this->db->where('user_stores.store_id', $store_id);
		$this->db->where('user_stores.active', '1');  
		$this->db->order_by("companies.name", "asc"); 
		$query = $this->db->get();
		
		$user_ids = array();
		foreach($query->result_array() as $row)
			 $user_ids[$row['ID']] = $row;
		return $user_ids;
	
	}
	
	
	public function non_client_list($store_id=NULL){
		$this->db->select('users.*, companies.name as company_name');
    $this->db->from('users');
		$this->db->join('companies', 'companies.user_id = users.ID', 'LEFT OUTER');
		$where = "users.type='CLIENT' and users.ID not in (select user_id from user_stores where store_id = '".$store_id."' and active='1')";
    $this->db->where($where,NULL,false);
		$this->db->order_by("companies.name", "asc"); 
		$query = $this->db->get();
		
		$clients = array();
		foreach($query->result_array() as $row)
			 $clients[$row['ID']] = $row;
		return $clients;
	
	}
	
	public function get_client_stores($user_id = NULL)
	{
		$this->db->select('stores.*,companies.name as company_name, user_stores.user_id as store_user_id');
    $this->db->from('stores');
		$this->db->join('user_stores', 'user_stores.store_id = stores.ID', 'left outer');
		$this->db->join('companies', 'companies.id = stores.company_id');
		$this->db->where("stores.user_id = '".$user_id."'");
		$this->db->order_by('companies.name', "asc"); 
		$query = $this->db->get();
		
		$client_stores = array();
		foreach($query->result_array() as $row)
		{
			if(!isset($client_stores[$row['ID']] ))
			{
			 $client_stores[$row['ID']] = $row;
			 unset($client_stores[$row['ID']]['store_user_id']);
			} 
			if($row['store_user_id'] > 0)
			{
			 $client_stores[$row['ID']]['clients'][$row['store_user_id']] = $row['store_user_id'];
			}
		}
		return $client_stores;
	
	}
	
	public function client_stores($user_id=NULL){
		$this->db->select('stores.*,companies.name as company_name, user_stores.user_id as store_user_id');
    $this->db->from('stores');
		$this->db->join('user_stores', 'user_stores.store_id = stores.ID', 'left outer');
		$this->db->join('companies', 'companies.id = stores.company_id');
		$this->db->order_by('companies.name', "asc"); 
		$query = $this->db->get();
		
		$client_stores = array();
		foreach($query->result_array() as $row){
				if(!isset($client_stores[$row['ID']] )){
			   $client_stores[$row['ID']] = $row;
				 unset($client_stores[$row['ID']]['store_user_id']);
				} 
				if($row['store_user_id'] > 0){
				 $client_stores[$row['ID']]['clients'][$row['store_user_id']] = $row['store_user_id'];
				}
			 }
		return $client_stores;
	
	}
	
	
	public function add_store_user($store_id=NULL, $user_id=NULL){
  	if(($store_id == NULL) or ($user_id == NULL)){
  	  return false; 
  	}
	 	$this->db->select('id');
    $this->db->from('user_stores');
		$this->db->where('user_id', $user_id);
		$this->db->where('store_id', $store_id);
		$query = $this->db->get();

		if($result = $query->result_array()){
			$data = array(
               'active' => '1',
               'date_modified' => date('Y-m-d h:i:s') 
            );
      $this->db->where('id', $result[0]['id']);
      $this->db->update('user_stores', $data);
		}else{ 
			$data = array(
         'store_id' => $store_id ,
         'user_id' => $user_id ,
         'active' => 1 ,
				 'date_created' => date('Y-m-d h:i:s')  ,
				 'date_modified' => date('Y-m-d h:i:s')  
      );
      $this->db->insert('user_stores', $data); 
		}	
		return true; 
	}
	
	public function remove_store_user($store_id=NULL, $user_id=NULL){
	 if(($store_id == NULL) or ($user_id == NULL)){
  	  return false; 
  	}
		$data = array(
               'active' => '0',
               'date_modified' => date('Y-m-d h:i:s') 
            );
    $this->db->where('store_id', $store_id);
		$this->db->where('user_id', $user_id);
    $this->db->update('user_stores', $data);
	  return true; 
	}
	
}
