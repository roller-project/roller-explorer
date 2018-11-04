<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends HomeController {

	
	public function index()
	{
		$this->view('welcome_message');
	}
}
