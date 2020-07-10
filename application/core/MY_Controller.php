<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	var $method; 

	public function __construct()
	{
		parent::__construct();
        $key    = "f0d4c3356f99d32dec2fa6bf46270dd9"; 
        $auth   = $this->post("token");
        
        if ($key !== $auth) {
            $this->_api(JSON_ERROR, "Invalid Token.");
            exit;
        }
	}

	public function _check_func($o)
    {
        if (is_object($o)) {
            $m = $this->post("method");
            if (method_exists($o, $m)) {
                $this->method = $m;
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function post($param = "")
    {
        if ($param != "") {
            return $this->input->post($param); //return string
        }else{
            return $this->input->post(); //return array
        }
    }

    public function get($param = "")
    {
        if ($param != "") {
            return $this->input->get($param); //return string
        }else{
            return $this->input->get(); //return array
        }
    }

    public function _api($code, $message, $data = null)
    {
        $result = array(
            'code' => $code,
            'message' => $message,
            'data' => $data
        );

        header('Content-Type: application/json');
        echo json_encode($result);
    }

    public function convert_date($date)
    {
        $time = strtotime($date);
        $newformat = date('Y-m-d',$time);

        return $newformat;
    }
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */