<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {

	function __construct() {
        parent::__construct();
        $this->load->model("User_model", "usr");
    }

	public function index()
	{
		if($this->_check_func($this)){
			$m = $this->method;
			$this->$m();
		}else{
			$this->_api(JSON_ERROR, "No Method ".$this->method." in Class Users");
		}
    }
    
	public function login()
	{
        $username = $this->post("username");
        $password = $this->post("password");

        if (empty($username) || empty($password)) {
            $this->_api("1001", "Please input username and password.", $users);
            exit;
        } else {

            $data = $this->usr->Authentication($username, md5($password));
            if ($data->num_rows() == 0) {
                $data = false;
            }
        }

        if ($data) {
            $result = (object)$data->result_object();
            $this->_api(JSON_SUCCESS, "Success Login", array("Users" => $result));
        }else{
            $this->_api(JSON_ERROR, "Data username dan password tidak ditemukan.");
        }
    }

    public function get_detail_user()
    {
        $id_user    = $this->post("id");

        if (empty($id_user)) {
            $this->_api("1002", "User id is empty", null);
            exit;
        } else {
            $data = $this->usr->get_detail_user($id_user);
            if ($data->num_rows() == 0) {
                $data = false;
            }
        }

        if ($data) {
            $this->_api(JSON_SUCCESS, "Success get data user", (object)$data->result());
        } else {
            $this->_api(JSON_ERROR, "Data tidak ditemukan");
        }
        
    }

	public function register()
	{
		$data = array(
            "email"              => $this->post("email"),
            "username"           => $this->post("username"),
            "password"           => md5($this->post("password")),
            "nama"               => $this->post("nama"),
            "jenis_kelamin"      => $this->post("jenis_kelamin"),
            "alamat"             => $this->post("alamat"),
            "tempat_lahir"       => $this->post("tempat_lahir"),
            "tanggal_lahir"      => $this->convert_date($this->post("tanggal_lahir")),
            "agama"              => $this->post("agama"),
            "pekerjaan"          => $this->post("pekerjaan"),
            "kewarganegaraan"    => $this->post("kewarganegaraan"),
            "created"            => date("Y-m-d H:i:s"),
            "status"             => "1"
        );

        $where1 = $this->usr->get_existing_email($data['email']);
        $where2 = $this->usr->get_existing_email($data['username']);

        if ($where1 > 0 || $where2 > 0) {
            $this->_api(JSON_ERROR, "Email / Username sudah di pakai");
        }else{
            $insert = $this->usr->insert($data);
            if ($insert) {
                $this->_api(JSON_SUCCESS, "Success Registration", $data);
            } else {
                $this->_api(JSON_ERROR, "Failed Registration");
            }
        }
	}

	public function update_akun()
	{
		$users_code =   $this->post('id_user');
        if ($users_code) {

        $data = array(
            'username'  => $this->post('username'),
            'password'  => $this->post('password'),       
            'email'     => $this->post('email'),
            'nama_user' => $this->post('nama_user'),
            'jk'        => $this->post('jk'),
            'ttl'       => $this->post('ttl'),
            'tinggi'    => $this->post('tinggi'),
            'berat'     => $this->post('berat'),
            'umur'      => $this->post('umur'),
            'kalori'    => $this->post('kalori')
        );

            if ($data != NULL) {
                $update = $this->usr->update($data, $users_code);
                if ($update) {
        			$this->_api(JSON_SUCCESS, "Success Update");
                } else {
            		$this->_api(JSON_ERROR, "Failed Update 1, check your input data");
                }
            } else {
        		$this->_api(JSON_ERROR, "Failed Update 2, because data null");
                }
	       } else {
        $this->_api(JSON_ERROR, "Failed Update 3, in where clause");
       }
    }

public function update_profile()
    {
        $users_code =   $this->post('ucode');
        if ($users_code) {
            $data = NULL;
            if ($this->post('username') != "") {
                $data["users_login_username"] = $this->post('username');
            }
            if ($this->post('password') != "") {
                $data["users_login_password"] = $this->post('password');
            }
            if ($this->post('email') != "") {
                $data["users_email"] = $this->post('email');
            }
            if ($this->post('first_name') != "") {
                $data["users_first_name"] = $this->post('first_name');
            }
            if ($this->post('mid_name') != "") {
                $data["users_mid_name"] = $this->post('mid_name');
            }
            if ($this->post('last_name') != "") {
                $data["users_last_name"] = $this->post('last_name');
            }
            if ($this->post('gender') != "") {
                $data["users_gender"] = $this->post('gender');
            }
            if ($this->post('date_of_birth') != "") {
                $data["users_date_of_birth"] = $this->post('birth');
            }
            if ($this->post('website') != "") {
                $data["users_website"] = $this->post('website');
            }
            if ($this->post('bio') != "") {
                $data["users_bio"] = $this->post('bio');
            }
            if ($this->post('phone') != "") {
                $data["users_phone"] = $this->post('phone');
            }
            if ($data != NULL) {
                $update = $this->users->update($data, $users_code);
                if ($update) {
                    $this->_api(JSON_SUCCESS, "Success Update");
                } else {
                    $this->_api(JSON_ERROR, "Failed Update");
                }
            } else {
                $this->_api(JSON_ERROR, "Failed Update");
            }
        }else{
            $this->_api(JSON_ERROR, "Failed Update");
        }
    }

	public function delete()
	{
		$users_code = $this->post('ucode');
        if ($users_code != "") {
            $delete = $this->users->post($users_code);
            if ($delete) {
        			$this->_api(JSON_SUCCESS, "Success Delete");
            } else {
        		$this->_api(JSON_ERROR, "Failed Delete");
            }
        } else {
    		$this->_api(JSON_ERROR, "Failed Delete");
        }
	}
}
