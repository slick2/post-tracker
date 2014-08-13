<?php

/**
 * @package Benchesters Social
 * @author Carey Dayrit <carey.dayrit@gmail.com>
 * 
 */
class Rss_feed_model extends CI_Model {

	protected $table_name = 'rss';
	protected $primary_column = 'id';

	/**
	 * Method: __construct
	 * magic method
	 */
	public function ___construct()
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

	/**
	 * Method: process_rss_feed
	 * @param integer $campaign_id
	 * @param string $rss_feed
	 * @return boolean
	 */
	public function process_rss_feed($campaign_id = NULL, $rss_feed)
	{
		$response = file_get_contents($rss_feed);

		if ($response)
		{
			$rss_xml = simplexml_load_string($response);

			# var_dump($rss_xml);

			$publication_name = !empty($rss_xml->channel->title) ? $rss_xml->channel->title : '';
			foreach ($rss_xml->channel->item as $rss)
			{
				$data = array(
					'article_title' => (string) $rss->title,
					#'article_sub_title' => (string) $rss->description,
					'post_time' => (string) $rss->pubDate,
					'publication_name' => (string) $publication_name,
					'article_url' => (string) $rss->guid,
					'author' => !empty($rss->author) ? (string) $rss->author : '',
					'insertedon' => date('Y-m-d')
				);

				$data['campaign_id'] = $campaign_id;

				if (!$this->check_post($data['article_url']))
				{
					$this->create($data);
					$output[] = $data;
				}
			}
		}

		if (!empty($output))
		{
			$this->Log_model->create(array('campaign_id' => $campaign_id, 'site' => 'rss_feed', 'last_fetch' => date('Y-m-d H:i:s')));
			return TRUE;
		}

		return FALSE;
	}

	/**
	 * Method: check_post
	 * Description: this check if the post is in the database already
	 * @param type $url
	 * @return boolean
	 */
	public function check_post($url = NULL)
	{
		$query = $this->db->get_where($this->table_name, array('article_url' => (string) $url));
		if ($query->num_rows() > 0)
		{
			return TRUE;
		}

		return FALSE;
	}

}
