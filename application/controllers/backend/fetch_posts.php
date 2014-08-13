<?php
/*
 * Cron to run
 */

//just include the TwitterOauthClass
include_once(APPPATH . 'libraries/facebook/Facebook.php');

class Fetch_posts extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->config('social-access');
		/**
		 * Load the Twitter Library
		 */
		$this->load->library('TwitterOAuth/TwitterOAuth', $this->config->item('twitter'));
		/**
		 * Load the Instagram Library
		 */
		$this->load->library('Instagram/Instagram_api', $this->config->item('instagram'));
	}

	public function run()
	{
		//try to initialize the class

		/* $data['twitter_hash'] = $this->_twitter_hash('singaporeair'); */

		/* $data['twitter_profile'] = $this->_twitter_profile('AirAsiaSG'); */

		/* $data['instagram_hash'] = $this->_instagram_hash('singaporeair');  */

		$data['facebook_profile'] = $this->_facebook_profile();

		$this->load->view('output', $data);
	}

	/**
	 * Facebook methods
	 */
	public function _facebook_profile($profile = NULL)
	{
		/* 		
		  $request = new FacebookRequest(
		  $session,
		  'GET',
		  '/{page-id}/feed'
		  );
		 * 
		 */
		$this->session->set_userdata('fb_token', 'CAALZCVvlX1hYBAHLm99tnJN6QkZBNrgzYKSD077b0drv8ADA6ZAWZCkZC58yFAZAooT9nOI7zvjj4rFjSftRZCAFphrFyGWORZAQvTJZCj6CCmTgx0RERonhhhs5pCXyW5uGyq7C8s40cAoAW2WrRMPMh6375gkgSbXdZBwURflMQl82XJC2TKzrg63MYJpunQVBdVZCH0wW7xqQqP79ZByVYk14tXQZAU6XgJDoZD');

		$test = new Facebook();



		$result = $test->get_page_post(6708787004);

		return $result;
	}

	/** Instagram methods * */
	public function _instagram_hash($hashtag = NULL)
	{
		$ig = new Instagram_api($this->config->item('instagram'));

		$result = $ig->hashRecent($hashtag, NULL, NULL, '190553834.f59def8.ed18edd84d5145afb08b5cc1d1740201');

		/*
		  print '<pre>';
		  print_r($result);
		  print '</pre>';
		 * 
		 */

		return $result;
	}

	/** Twitter methods * */

	/**
	 * This accepts the twitter profile as the parameter
	 * @param string $handler
	 * @return array;
	 */
	public function _twitter_profile($handler = NULL)
	{

		/**
		 * @todo the last fetch, we should check the last id inserted
		 * @todo we should check first if it is a valid handler
		 * @todo add cases on test
		 */
		$tw = new TwitterOAuth($this->config->item('twitter'));

		$params = array(
			'screen_name' => $handler,
			'count' => 5, // maximum upto the recent
			'exclude_replies' => true
		);

		/**
		 * Send a GET call with set parameters
		 */
		$response = $tw->get('statuses/user_timeline', $params);
		/**
		 * print '<pre>';
		 * print_r($response);
		 * print '</pre>';
		 * 
		 */
		return $response;
	}

	/**
	 * Would return tweets having the hashtag on the parameter
	 * @param string $hashtag the search query string
	 * @param date $until  date format based on Twitter docs
	 */
	public function _twitter_hash($hashtag = NULL, $until = NULL)
	{
		/**
		 * @todo the last fetch, we should check the last id inserted
		 * @todo add cases on test
		 */
		$tw = new TwitterOAuth($this->config->item('twitter'));

		$params = array(
			'q' => $hashtag,
			'count' => 5, // maximum upto the recent
				#until => given date
		);

		$response = $tw->get('search/tweets', $params);

		/**
		 * print '<pre>';
		 * print_r($response);
		 * print '</pre>';
		 */
		return $response;
	}

	public function _youtube_profile($profile = NULL)
	{
		
	}
	
	public function _vine_hash($hashtag = NULL)
	{
		
		
	}

}
