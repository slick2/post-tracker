<?php
/*
 * Model: Vine_model
 * Description:
 * 
 * Note: Vine Api would returns json format
 * @package Benchesters Social
 * @author Carey Dayrit <carey.dayrit@gmail.com>
 * poster_name
 * num_loops
 * num_likes
 * post_time
 * post_content
 * url
 */

class Vine_model extends CI_Model {

	protected $table_name = 'vine';
	protected $primary_column = 'id';

	/**
	 * No need for an access token or API key
	 * @var string 
	 */
	private $request_url = 'https://api.vineapp.com/timelines/tags/';

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
				->where($this->primary_column, $primary_id)
				->get();

		return $query->row_array();
	}

	/**
	 * Method: update
	 * @param array $data
	 * @param integer $primary_id
	 * @return boolean
	 */
	public function update($data = NULL, $primary_id = NULL)
	{
		$query = $this->where($this->primary_colum, $primary_id)
				->update($this->table_name, $data);

		return $query;
	}

	/**
	 * Method: delete
	 * @param integer $primary_id
	 * @return boolean
	 */
	public function delete($primary_id = NULL)
	{
		$query = $this->db->where($this->primary_column, $primary_id)
				->delete($this->table_name);

		return $query;
	}

	public function process_hashtags($campaign_id = NULL, $hashtag = NULL)
	{

		// response is json
		$response = $this->get_request($hashtag);

		if ($response)
		{
			$output = json_decode($response);
			
			foreach ($output->data->records as $records)
			{

				$data = array(
					'vine_id' => $records->postId,
					'campaign_id' => $campaign_id,
					'poster_name' => $records->username,
					'num_loops' => $records->loops->count,
					'num_likes' => $records->likes->count,
					'post_time' => $records->created,
					'post_content' => $records->description,
					'url' => $records->shareUrl
				);

				if (!($this->check_exists($data['vine_id'])))
				{
					$this->create($data);
				}
			}
		}
	}

	public function check_exists($vine_id)
	{
		$query = $this->db->get_where($this->table_name, array('vine_id' => $vine_id));

		if ($query->num_rows() > 0)
		{
			return TRUE;
		}

		return FALSE;
	}

	/**
	 * method: get_request
	 * @param array $params
	 */
	public function get_request($hashtag = NULL)
	{


		$url = $this->request_url . $hashtag;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array());
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$response = curl_exec($ch);

		curl_close($ch);

		return $response;
	}

}
