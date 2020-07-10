<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class User_model extends MY_Model {

  // ------------------------------------------------------------------------

  public function __construct()
	{
		parent::__construct();
		$this->table = "m_user";
    $this->pri_index = "id_user";
    $this->format_pk = "";
	}

  // ------------------------------------------------------------------------


  // ------------------------------------------------------------------------
  function Authentication($username,$password){

    $query = $this->db->get_where($this->table, array('username' => $username, 'password' => $password), null, null);
    // $query = $this->db->get();

    return $query;
  }

  public function get_detail_user($id)
  {
    $query = $this->db->get_where($this->table, array('id' => $id), null, null);

    return $query;
  }

  public function get_existing_email($email)
  {
    $query = $this->db->get_where($this->table, array('email' => $email), null, null);
    return $query->num_rows();
  }

  public function get_existing_username($username)
  {
    $query = $this->db->get_where($this->table, array('username' => $username), null, null);
    return $query->num_rows() ;
  }

  // ------------------------------------------------------------------------

}

/* End of file User_model.php */
/* Location: ./application/models/User_model.php */