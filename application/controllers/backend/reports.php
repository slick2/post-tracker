<?php

/**
 * @package Benchesters Social
 * @author Carey Dayrit <carey.dayrit@gmail.com>
 */
class Reports extends CI_Controller {

	/**
	 * Method: construct
	 */
	public function __construct()
	{
		parent::__construct();
		if (!$this->basic_auth->is_logged())
		{
			redirect('/admin/auth/login');
		}
		
		$this->load->model('twitter_model', 'Twitter_model');
	}

	public function facebook($cur_page = 0)
	{
		$this->load->library('pagination');
		$this->load->model('facebook_model', 'Facebook_model');

		$config['base_url'] = site_url() . '/admin/' . strtolower(__CLASS__) . '/' . __FUNCTION__;
		$config['total_rows'] = $this->Facebook_model->num_rows_facebook();
		$config['per_page'] = 10;
		$config['cur_page'] = $cur_page;

		$this->pagination->initialize($config);

		$this->view_data['facebook_rows'] = $this->Facebook_model->get_all_facebook($this->pagination->cur_page, $config['per_page']);

		$this->load->view('backend/reports/facebook', $this->view_data);
	}

	public function twitter($cur_page = 0)
	{
		$this->load->library('pagination');
		

		$config['base_url'] = site_url() . '/admin/' . strtolower(__CLASS__) . '/' . __FUNCTION__;
		$config['total_rows'] = $this->Twitter_model->num_rows_twitter();
		$config['per_page'] = 10;
		$config['cur_page'] = $cur_page;

		$this->pagination->initialize($config);

		$this->view_data['twitter_rows'] = $this->Twitter_model->get_all_twitter($this->pagination->cur_page, $config['per_page']);

		$this->load->view('backend/reports/twitter', $this->view_data);
	}

	public function instagram($cur_page = 0)
	{
		$this->load->library('pagination');
		$this->load->model('instagram_model', 'Instagram_model');

		$config['base_url'] = site_url() . '/admin/' . strtolower(__CLASS__) . '/' . __FUNCTION__;
		$config['total_rows'] = $this->Instagram_model->num_rows_instagram();
		$config['per_page'] = 10;
		$config['cur_page'] = $cur_page;

		$this->pagination->initialize($config);

		$this->view_data['instagram_rows'] = $this->Instagram_model->get_all_instagram($this->pagination->cur_page, $config['per_page']);

		$this->load->view('backend/reports/instagram', $this->view_data);
	}

	public function twitter_read($id = NULL)
	{
		if (empty($id))
		{
			show_404();
			exit();
		}
		
		if(!($this->view_data['tweet'] = $this->Twitter_model->read($id)))
		{
			show_404();
			exit();
		}
		
		$this->load->view('backend/reports/twitter_read', $this->view_data);
	}

}
