<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Layanan_model extends MY_Model {

  // ------------------------------------------------------------------------

  public function __construct()
	{
		parent::__construct();
		$this->table = "m_layanan";
	}

  // ------------------------------------------------------------------------


  // ------------------------------------------------------------------------
  public function getAll()
  {
    $query = $this->db->get($this->table);
    return $query;
  }

  public function getById($id)
  {
    $query = $this->db->get_where($this->table, array("id" => $id), null, null);
    return $query;
  }

  public function getSyaratById($id)
  {
    $query = $this->db->get_where('m_syarat_layanan', array("id_layanan" => $id), null, null);
    return $query;
  }

  // ------------------------------------------------------------------------

}

/* End of file Layanan_model.php */
/* Location: ./application/models/Layanan_model.php */