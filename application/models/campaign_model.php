<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/**
 * @author Carey Dayrit <carey.dayrit@gmail.com>
 * @package Social Report
 * Fields:
 * id
 * user_id
 * name
 * hashtags
 * facebook_pages
 * twitter_pages
 * instagram_pages
 * youtube_pages
 * createdon
 * updatedon
 */
class Campaign_Model extends CI_Model {

	protected $table_name = 'campaigns';

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Method: list_campaigns
	 * @return array
	 */
	public function list_campaigns()
	{
		$query = $this->db->select('*')
				->from('campaigns')
				->get();
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		return array();
	}

	/**
	 * Method: get_all
	 * @return array
	 */
	public function get_all()
	{
		$query = $this->db->select('*')
				->from('campaigns')
				->get();

		return $query->result_array();
	}

	/**
	 * Method: insert
	 * @param array $data
	 * @return integer|boolean
	 */
	public function insert($data = null)
	{
		$result = $this->db->insert('campaigns', $data);
		if ($result)
		{
			return $this->db->insert_id();
		}
		else
		{
			return $result;
		}
	}

	/**
	 * Method: update
	 * @param array $data
	 * @param integer $id
	 * @return array|boolean
	 */
	public function update($data = null, $id = null)
	{
		$query = $this->db->where('id', $id)
				->update('campaigns', $data);
		return $query;
	}

	/**
	 * Method: remove
	 * @param integer $id
	 * @return boolean
	 */
	public function remove($id = null)
	{
		$query = $this->db->where('id', $id)
				->delete('campaigns');
		return $query;
	}

	/**
	 * Method: read
	 * @param integer $primary_id
	 * @return array|boolean
	 */
	public function read($primary_id = NULL)
	{
		$query = $this->db->select('*')
				->from('campaigns')
				->where('id', $primary_id)
				->get();

		return $query->row_array();
	}

	/**
	 * Method: get_campaign
	 * @param integer $id
	 * @return array|boolean
	 */
	public function get_campaign($id = null)
	{
		$query = $this->db->select('*')
				->from('campaigns')
				->where('id', $id)
				->get();

		if ($query->num_rows() > 0)
		{
			return $query->row_array();
		}

		return array();
	}

}
