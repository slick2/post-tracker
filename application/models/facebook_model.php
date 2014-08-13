<?php

/**
 * @package Benchesters Social
 * @author Carey Dayrit <carey.dayrit@gmail.com>
 */
class Facebook_model extends CI_Model {

	protected $table_name = 'facebook';
	protected $primary_column = 'id';
	protected $access_token;

	/**
	 * Method: construct
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->config('social-access');
		$facebook_config = $this->config->item('facebook');
		$this->access_token = $facebook_config['app_access_token'];
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

	/**
	 * Method: get_page_id
	 * @param string $facebook_profile
	 * @return integer|boolean
	 */
	public function get_page_id($facebook_profile = NULL)
	{

		//change to graph
		$graph_profile = str_replace('www', 'graph', $facebook_profile);

		if ($response = @file_get_contents($graph_profile))
		{
			$response = json_decode($response);
			return $response->id;
		}

		return FALSE;
	}

	/**
	 * Method: get_page_feed
	 * @param string $facebook_profile
	 * @return boolean|object
	 */
	public function get_page_feed($facebook_profile = NULL)
	{
		//construct the url
		$url = 'https://graph.facebook.com/' . $this->get_page_id($facebook_profile) . '/feed/?access_token=' . $this->access_token;

		if ($response = @file_get_contents($url))
		{
			$response = json_decode($response);
			return $response;
		}

		return FALSE;
	}

	/**
	 * 
	 * @param type $campaign_id
	 * @param type $facebook_profile
	 * @return boolean
	 */
	public function process_facebook($campaign_id = NULL, $facebook_profile = NULL)
	{
		$response = $this->get_page_feed($facebook_profile);

		if ($response)
		{
			foreach ($response->data as $value)
			{
				# print_r($value);
				# exit();
				$single_post = NULL;
				$single_post = explode("_", $value->id);
				$data = array(
					'post_id' => $value->id,
					'facebook_page' => $facebook_profile,
					'poster_name' => $value->from->name,
					'post_time' => $this->facebook_time_convert($value->created_time),
					'post_content' => !empty($value->message) ? $value->message : '',
					'num_likes' => !empty($value->likes) ? count($value->likes->data) : 0,
					'post_image_url' => !empty($value->picture) ? $value->picture : '',
					'post_url' => "http://wwww.facebook.com/" . $single_post[0] . "/posts/" . $single_post[1]
				);
				$data['campaign_id'] = $campaign_id;

				if (!$this->check_post_id($data['post_id']))
				{
					$this->create($data);
					$output[] = $data;
				}
			}
		}
		if (!empty($output))
		{
			$this->Log_model->create(array('campaign_id' => $campaign_id, 'site' => 'facebook', 'last_fetch' => date('Y-m-d H:i:s')));
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Method: facebook_time_convert
	 * @param string $created_at
	 * @return datetime
	 */
	public function facebook_time_convert($created_at = NULL)
	{

		$time_string = $created_at;
		$time_unix = strtotime($time_string);

		return date('Y-m-d H:m:s', $time_unix);
	}

	/**
	 * Method: check_post_id
	 * @param integer $post_id
	 * @return boolean
	 */
	public function check_post_id($post_id = NULL)
	{
		$query = $this->db->get_where($this->table_name, array('post_id' => $post_id));
		if ($query->num_rows() > 0)
		{
			return TRUE;
		}

		return FALSE;
	}

	/**
	 * Method: get_all_facebook
	 * @param integer $cur_page
	 * @param integer $per_page
	 * @return array
	 */
	public function get_all_facebook($cur_page = 0, $per_page = 10)
	{
		$query = $this->db->select('*')
				->from('facebook')
				->limit($per_page, $cur_page)
				->get();

		return $query->result_array();
	}

	/**
	 * Method: num_rows_facebook
	 * @return integer
	 */
	public function num_rows_facebook()
	{
		$query = $this->db->select('*')
				->from('facebook')
				->get();

		return $query->num_rows();
	}

}
