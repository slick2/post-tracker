<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Hash_Tag_Model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function insert($data = null)
	{
		$query = $this->db->insert('hash_tags', $data);
		return $query;
	}

}
