<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Site_Model extends CI_Model {

	protected $table_name = 'sites';

	public function __construct()
	{
		parent::__construct();
	}

	public function list_sites()
	{
		$query = $this->db->select('*')
				->from($this->table_name)
				->get();
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		return array();
	}

}
