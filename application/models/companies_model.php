<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'abstract_model.php';

class Companies_model extends Abstract_model
{
	public function __construct()
	{
		parent::__construct();
		$this->table = 'companies';
		$this->link_table = 'user_rights';
	}
	
	protected function set_object($data = array())
	{
		foreach($data as $index => $value)
		{
			if(strcmp($index, 'name') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'address') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'city') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'state') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'zipcode') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'date_added') == 0)
			{
				if(strcmp($value, 'now') == 0)
					$this->db->set($index, 'NOW()', false);
				else
					$this->db->set($index, $value);
			}
			elseif(strcmp($index, 'company_contact') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'contact_phone') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'contact_email') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'website') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'business_type') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'is_active') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'is_test') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'qr_header') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'qr_comment_label') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'qr_success_text') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'sms_first_reply') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'sms_last_reply') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 's_header_logo') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 's_body_bg_type') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 's_body_bg1') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 's_body_bg2') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 's_body_bg_pic') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 's_header_bg_type') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 's_header_bg1') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 's_header_bg2') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 's_header_bg_pic') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 's_header_fcolor') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 's_header_ffamily') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 's_header_fsize') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 's_labels_fcolor') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 's_labels_ffamily') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 's_labels_fsize') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'cf_asked_for') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'cf_type') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'cf_qr_label') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'cf_required') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'cf_pos') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'cf_sms_text') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'cf_sms_pos') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'cf2_asked_for') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'cf2_type') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'cf2_required') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'cf2_qr_label') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'cf2_pos') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'cf2_sms_text') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif(strcmp($index, 'cf2_sms_pos') == 0)
			{
				$this->db->set($index,  $value);
			}
			elseif($index == 'unitname')
			{
				$this->db->set($index, $value);
			}
		}
		
	}

	public function get_by_name($name)
	{
		$query = $this->db->get_where($this->table, array('name' => $name));
		return $query->result_array();
	}
	
	public function get_by_id($id)
	{
		$query = $this->db->get_where($this->table, array('ID' => $id));
		return $query->result_array();
	}
	
	public function is_active($company_id) {
		$company = $this->get_by_id($company_id);
		$company = $company[0];
		return $company['is_active'] == 1;
	}
	
	public function set_active($company_id,$is_active) {
		$this->db->where('ID',$company_id);
		$this->db->update($this->table,array('is_active'=>($is_active ? 1 : 0)));
	}
	
	public function get_id_from_name($name)
	{
		$query = $this->db->get_where($this->table, array('name' => $name));
		foreach($query->result_array() as $row)
			return $row['ID'];
	}
	
	public function put_by_id($data)
	{
		$this->db->where('ID',$data['ID']);
		$this->db->update($this->table,$data);
	}
	
	public function get_companies_for_user($user_id,$all = false)
	{
		if ($all) {
			return $this->db->select('c.*')
							 ->from($this->table.' c')
							 ->get()
							 ->result_array();
		} else {
			return $this->db->select('c.*')
							 ->from($this->table.' c')
							 ->join($this->link_table.' r','r.company_id = c.ID','left')
							 ->where(array('r.target_type' => 'company','r.user_id' => $user_id))
							 ->get()
							 ->result_array();
		}
	}
	
	public function verify_company_for_user($user_id,$company_id)
	{
		if (strcmp($this->session->userdata('type'), 'SUPER') == 0) {
			return true;
		}

		$result = $this->db->select('c.*')
						 ->from($this->table.' c')
						 ->join($this->link_table.' r','r.company_id = c.ID','left')
						 ->where(array('r.target_type' => 'company','r.user_id' => $user_id,'r.company_id' => $company_id))
						 ->get()
						 ->result_array();
		return !empty($result);
	}
}
