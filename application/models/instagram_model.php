<?php

/**
 * @package Benchesters Social
 * @author Carey Dayrit <carey.dayrit@gmail.com>
 */
class Instagram_model extends CI_Model {

	protected $table_name = 'instagram';
	protected $primary_column = 'id';

	/**
	 * Method: construct
	 */
	public function __construct()
	{
		parent::__construct();

		$this->load->config('social-access');
		$this->load->library('Instagram/Instagram_api', $this->config->item('instagram'));
		$this->load->model('log_model', 'Log_model');
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
	 * Method: process_hashtags
	 * @param integer $campaign_id
	 * @param string $hashtag
	 * @return boolean
	 */
	public function process_hashtags($campaign_id = NULL, $hashtag = NULL)
	{
		$ig = new Instagram_api($this->config->item('instagram'));

		$response = $ig->hashRecent($hashtag, NULL, NULL, '190553834.f59def8.ed18edd84d5145afb08b5cc1d1740201');

		$data = array();
		$output = array();

		if ($response)
		{

			foreach ($response->data as $value)
			{
				$data = array(
					'post_id' => $value->id,
					'poster_name' => $value->user->username,
					'followed' => '',
					'following' => '',
					'post_time' => $this->instagram_time_convert($value->created_time),
					'post_image_url' => $value->images->standard_resolution->url,
					'num_likes' => $value->likes->count,
					'content' => !empty($value->caption->text) ? $value->caption->text : '',
					'post_url' => $value->link
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
			$this->Log_model->create(array('campaign_id' => $campaign_id, 'site' => 'instagram', 'last_fetch' => date('Y-m-d H:i:s')));
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Method: instagram_time_convert
	 * @param integer $created_at
	 * @return datetime
	 */
	public function instagram_time_convert($created_at = NULL)
	{
		return date('Y-m-d H:m:s', $created_at);
	}

	/**
	 * Method: check_post_id
	 * @param integer $instagram_id
	 * @return boolean
	 */
	public function check_post_id($instagram_id = NULL)
	{
		$query = $this->db->get_where($this->table_name, array('post_id' => $instagram_id));
		if ($query->num_rows() > 0)
		{
			return TRUE;
		}

		return FALSE;
	}

	/**
	 * Method: get_all_instagram
	 * @param integer $cur_page
	 * @param integer $per_apge
	 * @return array
	 */
	public function get_all_instagram($cur_page = 0, $per_page = 10)
	{
		$query = $this->db->select('*')
				->from('instagram')
				->limit($per_page, $cur_page)
				->get();

		return $query->result_array();
	}

	/**
	 * Method: num_rows_instagram
	 * @return integer
	 */
	public function num_rows_instagram()
	{
		$query = $this->db->select('*')
				->from('instagram')
				->get();

		return $query->num_rows();
	}

}
