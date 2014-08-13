<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Campaigns extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//check the authentication    
		if (!$this->basic_auth->is_logged())
		{
			redirect('/admin/auth/login');
		}
		$this->profile = $this->session->userdata($this->config->item('identity'));
		$this->load->model('campaign_model', 'Campaign_model');


		$this->load->helper('form');
	}

	/** This would list all available campaigns * */
	public function index($cur_page = 0)
	{
		$data = array();

		$data['campaigns'] = $this->Campaign_model->list_campaigns();
		$this->load->view('backend/campaigns/index', $data);
	}

	public function add()
	{
		//validation here
		$this->form_validation->set_rules('name', 'Name', 'required');

		if ($this->form_validation->run() === true)
		{
			$params = array(
				'user_id' => $this->profile['user_id'],
				'name' => $this->input->post('name'),
				'hashtags' => $this->input->post('hashtags'),
				'facebook_pages' => $this->input->post('facebook_pages'),
				'twitter_pages' => $this->input->post('twitter_pages'),
				'instagram_pages' => $this->input->post('instagram_pages'),
				'youtube_channels' => $this->input->post('youtube_channels'),
				'rss_feeds' => $this->input->post('rss_feeds'),
				'createdon' => date('Y-m-d', time())
			);

			$campaign_id = $this->Campaign_model->insert($params);

			$this->session->set_flashdata('message', 'The record has been added');

			redirect('/admin/campaigns');
		}

		$this->load->view('backend/campaigns/add');
	}

	public function edit($id = null)
	{
		if (empty($id))
		{
			show_404();
			exit();
		}

		if (!($data['campaign'] = $this->Campaign_model->get_campaign($id)))
		{
			show_404();
			exit();
		}

		$this->form_validation->set_rules('name', 'Name', 'required');

		if ($this->form_validation->run() === true)
		{
			$params = array(
				'name' => $this->input->post('name'),
				'hashtags' => $this->input->post('hashtags'),
				'facebook_pages' => $this->input->post('facebook_pages'),
				'twitter_pages' => $this->input->post('twitter_pages'),
				'instagram_pages' => $this->input->post('instagram_pages'),
				'youtube_channels' => $this->input->post('youtube_channels'),
				'rss_feeds' => $this->input->post('rss_feeds'),
				'updatedon' => date('Y-m-d', time())
			);
			$this->Campaign_model->update($params, $id);
			$this->session->set_flashdata('message', 'The record has been updated');

			redirect('/admin/campaigns/index');
		}

		$this->load->view('backend/campaigns/edit', $data);
	}

	public function remove($id = null)
	{
		if (empty($id))
		{
			show_404();
		}

		$this->Campaign_model->remove($id);

		$this->session->set_flashdata('message', 'The record has been removed');
		redirect('/admin/campaigns/index');
		//redirect with flash message
	}

	public function view($id = null)
	{
		if (empty($id))
		{
			show_404();
			exit();
		}

		if (!($data['campaign'] = $this->Campaign_model->get_campaign($id)))
		{
			show_404();
			exit();
		}

		$this->load->view('backend/campaigns/view', $data);
	}

	

}
