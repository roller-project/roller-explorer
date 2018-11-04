<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Account_model extends DB_Model{
	public $info_api = false;
	function __construct()
	{
		parent::__construct();
	}
	
	public function api_checklogin($username, $password){
		return ($username == "admin" && $password == "anhkhoa123" ? true : false);
	}

	//
	// api_account
	//

	public function api_account($keys, $secret, $obj){
		$this->db->where("api_keys",$keys);
		$this->db->where("api_secret",$secret);
		$data = $this->db->get("api_access")->row();
		if(isset($data->api_id)){
			$obj->_info_api = $data;
			return true;
		}else{
			return false;
		}
	}

	public function getInfo(){
		
		$this->db->where("id",$this->get_login_id());
		return $this->db->get("account")->row();
	}

	public function getUserByCode($code){
		$this->db->where("referrals",$code);
		return $this->db->get("account")->row();
	}
	/*
	Manager Profile
	*/
	public function getProfile(){
		
		$this->db->where("account_id",$this->get_login_id());
		return $this->db->get("profiles")->row();
	}

	public function setProfiles(){
		$arv = [
			"firstname" => ($this->input->post("firstname") ? $this->input->post("firstname") : ""),
			"minname" => ($this->input->post("minname") ? $this->input->post("minname") : ""),
			"lastname" => ($this->input->post("lastname") ? $this->input->post("lastname") : ""),
			"country" => ($this->input->post("country") ? $this->input->post("country") : ""),
			"city" => ($this->input->post("city") ? $this->input->post("city") : ""),
			"state" => ($this->input->post("state") ? $this->input->post("state") : ""),
			"zipcode" => ($this->input->post("zipcode") ? $this->input->post("zipcode") : ""),
			"address" => ($this->input->post("address") ? $this->input->post("address") : ""),
			"address2" => ($this->input->post("address2") ? $this->input->post("address2") : ""),
		];

		$data = $this->getProfile();
		if(isset($data->profile_id)){
			$this->db->update("profiles",$arv,["profile_id" => $data->profile_id]);
			return "update";
		}else{
			$arv["account_id"] = $this->get_login_id();
			$this->db->insert("profiles",$arv);
			return "insert";
		}
	}
	/*
	Security
	*/
	public function getSecurity($type=false){
		$this->db->where("account_id",$this->get_login_id());
		if(trim($type)){
			$this->db->where("sec_method",trim($type));
			return $this->db->get("security")->row();
		}else{
			
			return $this->db->get("security")->result();
		}
	}

	public function setSecurity($type, $content){
		$data= $this->getSecurity($type);
		if(isset($data->sec_id)){
			return $this->db->update("security",["sec_value" => $content, "updated" => date("Y-m-d h:i:s")],["sec_method" => $type, "account_id" => $this->get_login_id(), "sec_id" => $data->sec_id]);
			
		}else{

			$arv = [
				"sec_method" => $type,
				"sec_value" => $content,
				"account_id" => $this->get_login_id()
			];
			return $this->db->insert("security", $arv);
		}

	}


	public function removeSecurity($type){
		return $this->db->delete("security",["account_id" => $this->get_login_id(), "sec_method" => trim($type)]);
	}

	public function unlockf2a($code, $ciphertextin=false){

		$this->load->library('GoogleAuthenticator');
        $ga = new GoogleAuthenticator();
        if(!$ciphertextin){
        	$data = $this->getSecurity("authentication");
	        if(!isset($data->sec_id)) return false;
	        $ciphertext = $data->sec_value;
        }else{
        	$ciphertext = $ciphertextin;
        }
        

        $secret = encrypt_decrypt("decrypt", $ciphertext);

        if ($ga->verifyCode($secret, $code, 2)) {
        	return true;
        }
        return false;
	}

	public function openf2a(){
		$data = $this->getSecurity("authentication");
		if(isset($data->sec_id)){
			return true;
		}
		return false;
	}
	/*
	Render token login
	*/
	public function activeToken($token, $userid=0){
		$arv = [
			"token" => $token,
			"updated_at" => date("Y-m-d h:i:s")
		];
		$this->session->set_userdata("token",$token);
		$this->db->update("account",$arv,["id" => $userid]);
	}
}

?>