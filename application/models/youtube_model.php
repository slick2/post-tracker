<?php

/**
 * @package Benchesters Social
 * @author Carey Dayrit <carey.dayrit@gmail.com>
 */
class Youtube_model extends CI_Model {

	protected $table_name = 'youtube';
	protected $primary_column = 'id';
	private $api_key;

	/**
	 *
	 * @var array having endpoint values
	 */
	private $request_url = array(
		'channels' => 'https://www.googleapis.com/youtube/v3/channels?',
		'search' => 'https://www.googleapis.com/youtube/v3/search?',
		'videos' => 'https://www.googleapis.com/youtube/v3/videos?'
	);

	/**
	 * Method: __construct
	 */
	public function __construct()
	{
		parent::__construct();

		$this->load->config('social-access');
		$youtube_config = $this->config->item('youtube');
		$this->api_key = $youtube_config['api_key'];
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
	 * Method: process_youtube_channel
	 * Description: this process have been divided in smaller task methods on which needed calls
	 * since youtube API would not provide complete details on response data.
	 * @param integer $campaign_id
	 * @param string $page
	 */
	public function process_youtube_channel($campaign_id, $page = NULL)
	{
		if ($channel_id = $this->get_channel_id($page))
		{
			if ($video_ids = $this->get_all_channel_videos($channel_id))
			{
				if ($youtube_data = $this->get_video_details($video_ids))
				{
					foreach ($youtube_data as $data)
					{
						//prevent dupes
						if (!$this->check_exists($data['url']))
						{
							$this->create($data);
						}
					}
				}
			}
		}
	}

	/**
	 * Method: check_exists
	 * Description: The method to check whether the video has been inserted on the database.
	 * @param string $youtube_url
	 * @return boolean
	 */
	public function check_exists($youtube_url)
	{
		$query = $this->db->get_where($this->table_name, array('url' => $youtube_url));

		if ($query->num_rows() > 0)
		{
			return TRUE;
		}

		return FALSE;
	}

	/**
	 * Method: get_channel_id
	 * Description: Based on the youtube channel url, we extract the channel username
	 * and converted it to the channel_id for fetching properly
	 * @param type $page
	 * @return boolean
	 */
	public function get_channel_id($page = NULL)
	{
		$author = str_replace('https://www.youtube.com/', '', $page);

		$params = array(
			'key' => $this->api_key,
			'part' => 'id',
			'forUsername' => $author
		);
		$response = $this->get_request('channels', $params);
		if ($response)
		{
			$channel = json_decode($response);

			if (!empty($channel->items[0]->id))
			{
				return $channel->items[0]->id;
			}
		}


		return FALSE;
	}

	/**
	 * Method: get_video_details
	 * Description: Would fetch the video details
	 * @param string $ids comma separated string on which has the list of the channel ids
	 * @return boolean
	 */
	public function get_video_details($ids = NULL)
	{
		$params = array(
			'key' => $this->api_key,
			'id' => implode(',', $ids),
			'part' => 'snippet, statistics',
			'maxResults' => 50
		);

		$output = array();
		$response = $this->get_request('videos', $params);

		if ($response)
		{
			$videos = json_decode($response);
			//construct the data that we need
			
			# print_r($videos);
			# exit();
			foreach ($videos->items as $video)
			{
				$data = array(
					'poster_name' => $video->snippet->channelTitle,
					'poster_channel' => $video->snippet->channelTitle,
					'post_time' => $video->snippet->publishedAt,
					'comments' => $video->statistics->commentCount,
					'views' => $video->statistics->viewCount,
					'likes' => $video->statistics->likeCount,
					'dislikes' => $video->statistics->dislikeCount,
					'embed_code' => '<iframe width="560" height="315" src="//www.youtube.com/embed/' . $video->id . '" frameborder="0" allowfullscreen></iframe>',
					'content' => $video->snippet->title,
					'url' => 'https://www.youtube.com/watch?v=' . $video->id,
					'insertedon' => date('Y-m-d')
				);
				$output[] = $data;
			}

			if ($output)
			{
				return $output;
			}
		}
		return FALSE;
	}

	/**
	 * Method: get_all_channel_videos
	 * Description: this would just list all the video ids of a channel, the details
	 * are not in the response so we need the videos endpoint to get these details
	 * @param string $channel_id
	 * @return boolean|array
	 */
	public function get_all_channel_videos($channel_id = NULL)
	{
		$params = array(
			'key' => $this->api_key,
			'part' => 'snippet',
			'channelId' => $channel_id,
			'type' => 'video',
			'maxResults' => 50
		);
		$output = array();
		$response = $this->get_request('search', $params);

		if ($response)
		{
			$video_ids = json_decode($response);

			foreach ($video_ids->items as $video_id)
			{
				$output[] = $video_id->id->videoId;
			}

			if (!empty($output))
			{
				return $output;
			}
		}

		return FALSE;
	}

	/**
	 * method: get_request
	 * @param array $params
	 */
	public function get_request($method = NULL, $params = NULL)
	{


		$url = $this->request_url[$method] . http_build_query($params);

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
