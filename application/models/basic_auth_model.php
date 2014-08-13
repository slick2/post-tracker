<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/**
 * Model Class basic_auth_model
 * @package Basic Auth
 * @author Carey Dayrit <carey.dayrit@gmail.com>
 */
class basic_auth_model extends CI_Model {

	public $tables = array();
	public $identity_column;

	public function __construct()
	{
		parent::__construct();
		$this->load->config('basic_auth');
		$this->tables = $this->config->item('tables');
		$this->identity_column = $this->config->item('identity');
	}

	/**
	 * Method login
	 * @param mixed $identity
	 * @param string $password
	 * @return boolean
	 */
	public function login($identity, $password)
	{

		$query = $this->db->select('id as user_id, ' . $this->identity_column . ', password, activation_code ')
				->from($this->tables['users'])
				->where($this->identity_column, $identity)
				->where('password', $password)
				->get();

		if ($query->num_rows() == 1)
		{
			return $query->row_array();
		}
		else
		{
			return array();
		}
	}

	/**
	 * Method register
	 * @param array $data
	 * @return boolean
	 */
	public function register($data)
	{
		$query = $this->db->insert($this->tables['users'], $data);

		return $query;
	}

	/**
	 * Method change_password
	 * @param mixed $identity
	 * @param string $new
	 * @return boolean
	 */
	public function change_password($identity = NULL, $new = NULL)
	{
		if (empty($new) OR empty($identity))
		{
			return FALSE;
		}
		$data = array
			(
			'password' => $new
		);
		return $this->db->where($this->identity_column, $identity)
						->update($this->tables['users'], $data);
	}

	/**
	 * Method deactivate
	 * @param mixed $identity
	 * @return boolean
	 */
	public function deactivate($identity)
	{
		$users_table = $this->tables['users'];
		if ($identity === false)
		{
			return false;
		}

		$activation_code = sha1(md5(microtime()));
		$this->activation_code = $activation_code;

		$data = array('activation_code' => $activation_code, 'active' => 0);

		$this->db->update($users_table, $data, array($this->identity_column => $identity));

		return ($this->db->affected_rows() == 1) ? true : false;
	}

	/**
	 * Method exist_email
	 * @param string $email
	 * @return boolean
	 */
	public function exist_email($email)
	{
		$query = $this->db->get_where('users', array('email' => $email));
		if ($query->num_rows())
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Method get_info
	 * @param string $identity
	 * @return boolean
	 */
	public function get_info($identity)
	{
		$result = array();
		$query = $this->db->get_where('users', array($this->identity_column => $identity));
		$result = $query->result_array();
		return $result;
	}

}
