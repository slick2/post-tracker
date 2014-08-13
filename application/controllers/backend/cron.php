<?php

/**
 * @package Benchesters Social
 * @author Carey Dayrit <carey.dayrit@gmail.com>
 */
class Cron extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('twitter_model', 'Twitter_model');
		$this->load->model('instagram_model', 'Instagram_model');
		$this->load->model('campaign_model', 'Campaign_model');
		$this->load->model('facebook_model', 'Facebook_model');
		$this->load->model('rss_feed_model', 'Rss_feed_model');
		$this->load->model('youtube_model', 'Youtube_model');
		$this->load->model('vine_model', 'Vine_model');
		$this->load->model('log_model', 'Log_model');
	}

	public function index()
	{
		$campaigns = $this->Campaign_model->get_all();

		foreach ($campaigns as $campaign)
		{
			# $this->_process_tweets($campaign['id']);

			# $this->_process_twitter_profile($campaign['id']);

			# $this->_process_ig_posts($campaign['id']);

			$this->_process_facebook_page($campaign['id']);

			# $this->_process_rss_feeds($campaign['id']);

			# $this->_process_youtube_channels($campaign['id']);

			# $this->_process_vine($campaign['id']);
		}
	}

	public function _process_tweets($campaign_id = NULL)
	{

		//get the campaign
		$campaign = $this->Campaign_model->read($campaign_id);

		//read hash tags first
		$hashtags = array();
		$hashtags = explode("\n", $campaign['hashtags']);

		// get the last fetch of the id
		# 
		$until = $this->Log_model->get_last_fetch($campaign_id);


		foreach ($hashtags as $hash_word)
		{
			if (!empty($hash_word))
			{
				echo '<pre>Processing...' . $hash_word;
				$data[] = $this->Twitter_model->process_hashtags($campaign_id, trim($hash_word));
				echo '...Done.</pre>';
			}
		}
	}

	public function _process_twitter_profile($campaign_id = NULL)
	{
		$campaign = $this->Campaign_model->read($campaign_id);

		$twitter_profiles = array();

		$twitter_profiles = explode("\n", $campaign['twitter_pages']);

		// get the last fetch of the id
		$until = $this->Log_model->get_last_fetch($campaign_id);

		foreach ($twitter_profiles as $twitter_profile)
		{
			echo '<pre>Processing...' . $twitter_profile;
			$data[] = $this->Twitter_model->process_profile($campaign_id, trim($twitter_profile));
			echo '....Done.</pre>';
		}
	}

	public function _process_ig_posts($campaign_id = NULL)
	{
		$campaign = $this->Campaign_model->read($campaign_id);

		//read hash tags first
		$hashtags = array();
		$hashtags = explode("\n", $campaign['hashtags']);

		// get the last fetch of the id
		# 
		$until = $this->Log_model->get_last_fetch($campaign_id);

		foreach ($hashtags as $hash_word)
		{
			if (!empty($hash_word))
			{
				echo '<pre>Processing...' . $hash_word;
				$data[] = $this->Instagram_model->process_hashtags($campaign_id, trim($hash_word), $until);
				echo '...Done.</pre>';
			}
		}
	}

	public function _process_facebook_page($campaign_id = NULL)
	{
		$campaign = $this->Campaign_model->read($campaign_id);

		$facebook_profiles = array();
		$facebook_profiles = explode("\n", $campaign['facebook_pages']);

		foreach ($facebook_profiles as $facebook_profile)
		{
			if (!empty($facebook_profile))
			{
				echo '<pre>Processing...' . $facebook_profile;
				$data[] = $this->Facebook_model->process_facebook($campaign_id, $facebook_profile);
				echo '...Done.</pre>';
			}
		}
	}

	public function _process_rss_feeds($campaign_id = NULL)
	{
		$campaign = $this->Campaign_model->read($campaign_id);

		$rss_feeds = array();

		$rss_feeds = explode("\n", $campaign['rss_feeds']);

		foreach ($rss_feeds as $rss_feed)
		{
			if (!empty($rss_feed))
			{
				echo '<pre>Processing...' . $rss_feed;
				$data[] = $this->Rss_feed_model->process_rss_feed($campaign_id, $rss_feed);
				echo '...Done.</pre>';
			}
		}
	}

	public function _process_youtube_channels($campaign_id = NULL)
	{
		$campaign = $this->Campaign_model->read($campaign_id);

		$youtube_channels = array();

		$youtube_channels = explode("\n", $campaign['youtube_channels']);



		foreach ($youtube_channels as $youtube_channel)
		{
			if (!empty($youtube_channel))
			{
				echo '<pre>Processing...' . $youtube_channel;
				$data[] = $this->Youtube_model->process_youtube_channel($campaign_id, $youtube_channel);
				echo '...Done.</pre>';
			}
		}
	}

	public function _process_vine($campaign_id)
	{
		$campaign = $this->Campaign_model->read($campaign_id);

		//read hash tags first
		$hashtags = array();
		$hashtags = explode("\n", $campaign['hashtags']);

		foreach ($hashtags as $hash_word)
		{
			if (!empty($hash_word))
			{
				echo '<pre>Processing...' . $hash_word;
				$data[] = $this->Vine_model->process_hashtags($campaign_id, trim($hash_word));
				echo '...Done.</pre>';
			}
		}
	}

}
