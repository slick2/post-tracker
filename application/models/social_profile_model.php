<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Social_Profile_Model extends CI_Model {

	protected $table_name = 'social_profiles';

	public function __construct()
	{
		parent::__construct();
	}

	public function list_sites()
	{
		$query = $this->db->select('*')
				->from('sites')
				->get();
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		return array();
	}

	public function insert($data = null)
	{
		$query = $this->db->insert($this->table_name, $data);
		return $query;
	}

}
