<?php

/**
 * @package Benchesters Social
 * @author Carey Dayrit <carey.dayrit@gmail.com>
 */
class Log_model extends CI_Model {

	protected $table_name = 'logs';
	protected $primary_column = 'id';

	/**
	 * Method: construct
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Method: create
	 * @param array $data
	 * @return integer|boolean Returns the table insert id upon success, FALSE upon failure.
	 */
	public function create($data = NULL)
	{
		$query = $this->db->insert($this->table_name, $data);

		if ($query)
		{
			return $this->db->insert_id();
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Method: read
	 * @param integer $primary_id
	 * @return array
	 */
	public function read($primary_id = NULL)
	{
		$query = $this->db->select('*')
				->from($this->table_name)
				->where($this->primary_key, $primary_id)
				->get();

		return $query->row_array();
	}
	
	public function get_last_fetch($campaign_id)
	{
		$query = $this->db->select('*')
				->from($this->table_name)
				->where('campaign_id', $campaign_id)
				->order_by('last_fetch', 'desc')
				->get();
		if($last_fetch = $query->row_array())
		{
			return $last_fetch['last_fetch'];
		}
		
		return FALSE;
	}

}
