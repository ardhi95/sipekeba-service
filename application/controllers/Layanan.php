<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Layanan extends MY_Controller {
	
	function __construct() {
        parent::__construct();
        $this->load->model("Layanan_model", "layanan");
    }

	public function index()
	{
		if($this->_check_func($this)){
			$m = $this->method;
			$this->$m();
		}else{
			$this->_api(JSON_ERROR, "tidak ada method ".$this->method." di class record");
		}
	}

    public function getList()
    {
        $data = $this->layanan->getAll();
        
        if ($data->num_rows() == 0) {
            $data = false;
        }

        if ($data) {
            $this->_api(JSON_SUCCESS, "Success get all data", $data->result());
        }else{
            $this->_api(JSON_ERROR, "Data tidak ditemukan.");
        }
    }

    public function getDetail()
    {
        $id     =   $this->post("id");
        if (!empty($id)) {
            $data = $this->layanan->getById($id);
            $dataSyarat = $this->layanan->getSyaratById($id);

            if ($data->num_rows() == 0) {
                $data = false;
            }
        }

        if ($data) {
            $this->_api(JSON_SUCCESS, "Success get data by id", ["Layanan" => (object)$data->result(), "Syarat" => $dataSyarat->result()]);
        }else{
            $this->_api(JSON_ERROR, "Data tidak ditemukan");
        }
    }


}

/* End of file olahraga.php */
/* Location: ./application/controllers/olahraga.php */