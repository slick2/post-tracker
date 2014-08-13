<?php

/**
 * @package Benchesters Social
 * @author Carey Dayrit <carey.dayrit@gmail.com>
 * Fields:
 * poster_name
 * followed
 * following
 * post_time
 * retweets
 * post_tweet
 * post_url
 */
class Twitter_model extends CI_Model {

	protected $table_name = 'twitter';
	protected $primary_column = 'id';

	/**
	 * Method: construct
	 */
	public function __construct()
	{

		parent::__construct();

		$this->load->config('social-access');
		$this->load->library('TwitterOAuth/TwitterOAuth', $this->config->item('twitter'));
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
	 * This accepts the twitter profile as the parameter
	 * @param string $handler
	 * @return array;
	 */
	public function process_profile($handler = NULL, $until = NULL)
	{

		/**
		 * @todo the last fetch, we should check the last id inserted
		 * @todo we should check first if it is a valid handler
		 * @todo add cases on test
		 */
		$tw = new TwitterOAuth($this->config->item('twitter'));

		$params = array(
			'screen_name' => $handler,
			'count' => 10, // maximum upto the recent
			'exclude_replies' => TRUE
		);

		if ($until)
		{
			$params['until'] = $until;
		}

		/**
		 * Send a GET call with set parameters
		 */
		$response = $tw->get('statuses/user_timeline', $params);

		$data = array();
		$output = array();

		if ($response)
		{
			foreach ($response as $value)
			{
				$data = array(
					'tweet_id' => $value->id,
					'poster_name' => $value->user->name,
					'followed' => $value->user->followers_count,
					'following' => $value->friends_count,
					'post_time' => $value->created_at,
					'retweets' => $value->retweeted,
					'post_tweet' => $value->text,
					'post_url' => 'http://twitter.com/' . $value->user->name . '/status/' . $value->id
				);
				$data['campaign_id'] = $campaign_id;
				if (!$this->check_tweet_id($data['tweet_id']))
				{
					$this->create($data);

					$output[] = $data;
				}
			}
		}
		if (!empty($output))
		{
			$this->Log_model->create(array('campaign_id' => $campaign_id, 'site' => 'twitter', 'last_fetch' => date('Y-m-d H:i:s')));
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Would return tweets having the hashtag on the parameter
	 * @param string $hashtag the search query string
	 * @param date $until  date format based on Twitter docs
	 */
	public function process_hashtags($campaign_id, $hashtag = NULL, $until = NULL)
	{
		/**
		 * @todo the last fetch, we should check the last id inserted
		 * @todo add cases on test
		 */
		$tw = new TwitterOAuth($this->config->item('twitter'));

		$params = array(
			'q' => $hashtag,
			'count' => 10, // maximum upto the recent
		);

		if ($until)
		{
			$params['until'] = $until;
		}
		$response = $tw->get('search/tweets', $params);

		$data = array();
		$output = array();
		if ($response)
		{
			foreach ($response->statuses as $value)
			{
				$data = array(
					'tweet_id' => $value->id,
					'poster_name' => $value->user->name,
					'followed' => $value->user->followers_count,
					'following' => $value->user->friends_count,
					'post_time' => $this->twitter_time_convert($value->created_at),
					'retweets' => $value->retweeted,
					'post_tweet' => $value->text,
					'post_url' => 'http://twitter.com/' . $value->user->name . '/status/' . $value->id
				);

				$data['campaign_id'] = $campaign_id;
				//check for duplicates
				if (!$this->check_tweet_id($data['tweet_id']))
				{
					$this->create($data);

					$output[] = $data;
				}
			}
		}
		if (!empty($output))
		{
			$this->Log_model->create(array('campaign_id' => $campaign_id, 'site' => 'twitter', 'last_fetch' => date('Y-m-d H:i:s')));
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Method: twitter_time_convert
	 * @param string $created_at
	 * @return datetime
	 */
	public function twitter_time_convert($created_at = NULL)
	{

		$time_string = $created_at;
		$time_unix = strtotime($time_string);

		return date('Y-m-d H:m:s', $time_unix);
	}

	/**
	 * Method: check_tweet_id
	 * @param integer $tweet_id
	 * @return boolean
	 */
	public function check_tweet_id($tweet_id = NULL)
	{
		$query = $this->db->get_where($this->table_name, array('tweet_id' => $tweet_id));
		if ($query->num_rows() > 0)
		{
			return TRUE;
		}

		return FALSE;
	}

	/**
	 * Method: get_all_twitter
	 * @param integer $cur_page
	 * @param integer $per_page
	 * @return array
	 */
	public function get_all_twitter($cur_page = 0, $per_page = 10)
	{
		$query = $this->db->select('*')
				->from('twitter')
				->limit($per_page, $cur_page)
				->get();
		return $query->result_array();
	}

	/**
	 * Method: num_rows_twitter
	 * @return integer
	 */
	public function num_rows_twitter()
	{
		$query = $this->db->select('*')
				->from('twitter')
				->get();

		return $query->num_rows();
	}

}
