<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BaseController extends CI_Controller{
	public $layout = "home-layout";
	public $title = "B2B Blockchian Exchange";
	public $description = "";
	public $image = "";
	function __construct()
	{
		parent::__construct();
		$this->load->library(['session','email','user_agent']);
		$this->load->helper(['url','form']);
		$this->load->model(['account_model']);
		
	}



	public function set_meta($title, $des="", $img=""){
		if($title) $this->title = $title;
		if($des) $this->description = $des;
		if($img) $this->image = $img;
	}


	/*
	Get Layout 
	*/
	public function getLayout(){
		$file = VIEWPATH.$this->layout.".php";
		if(file_exists($file)){
			return true;
		}
		return false;
	}

	/*
	Return View
	*/
	public function view($layout, $data=[]){
		
		$is_login = 1;
		$data = array_merge($data,["is_login" => $is_login]);
		
		if($this->getLayout()){

			$data = $this->load->view($layout, $data, true);
			return $this->load->view($this->layout,[
				"title" => $this->title, 
				"description" => $this->description, 
				"image" => $this->image,
				"content" => $data, 
				"flash" => $this->get_flash(), 
				"header" => "",
				"is_login" => $is_login
			]);

		}else{
			return $this->load->view($layout, $data);
		}
	}

	public function viewAjax($layout, $data=[]){
		return $this->load->view($layout, $data);
	}

	public function isPost(){
		if($this->input->method() == "post"){
			return true;
		}
		return false;
	}

	public function isPut(){
		if($this->input->method() == "put"){
			return true;
		}
		return false;
	}

	public function isGet(){
		if($this->input->method() == "get"){
			return true;
		}
		return false;
	}

	/*
	Note Flash Member
	*/
	public function flash($key, $content=""){
		$this->session->set_flashdata($key, $content);
	}
	public function get_flash(){
		$html = "";
		if($this->session->flashdata("error")){
			$html = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
			  <strong>Error !</strong> '.$this->session->flashdata("error").'.
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			  </button>
			</div>';
		}

		if($this->session->flashdata("success")){
			$html = '<div class="alert alert-success alert-dismissible fade show" role="alert">
			  <strong>Success !</strong> '.$this->session->flashdata("success").'.
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			  </button>
			</div>';
		}


		if($this->session->flashdata("warning")){
			$html = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
			  <strong>Warning!</strong> '.$this->session->flashdata("warning").'.
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			  </button>
			</div>';
		}


		return $html;
	}

	public function exportJson($arv=[]){
		header('Content-Type: application/json;charset=utf-8');
   		echo (json_encode($arv, JSON_PRETTY_PRINT));
	}

}
class HomeController extends BaseController{
	function __construct()
	{
		parent::__construct();
		//$this->load->database();
	}
}

class AdminController extends BaseController{
	function __construct()
	{
		parent::__construct();
		//$this->load->database();
	}
}




class ApiController extends BaseController{
	function __construct()
	{
		parent::__construct();
	}
}



class APIAdminController extends BaseController{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
}