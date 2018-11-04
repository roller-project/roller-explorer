<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH."third_party/ethereum.php";
class Tokens extends HomeController {
	private $connect = false;
	public $bigum = 10000000000;
	function __construct()
	{
		parent::__construct();
		$this->connect =  new EthereumRPC('http://127.0.0.1', 8545);
		$this->bigum = 1000000000000000000;
		$this->connect->bigum = $this->bigum;
	}

	
	public function index()
	{
		$this->view('tokens');
	}
}