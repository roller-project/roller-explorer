<?php
/**
 * 
 */
class MY_Model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}
}

class DB_Model extends CI_Model
{
	public $is_public = false;
	public $is_private = true;
	public $business = false;
	public $limit_connect = false;
	
	function __construct()
	{
		parent::__construct();
	}

	public function get_login_id(){
		$login = $this->session->userdata("login");
		if(is_array($login) && isset($login["is_login"]) && intval($login["is_login"]) > 0){
			return intval($login["is_login"]);
		}else{
			return 0;
		}
	}

	public function report($arv){
		return json_encode($arv);
	}


	
	
}