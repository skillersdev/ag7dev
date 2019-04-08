<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Website extends CI_Controller {

	
	public function index()
	{
		$template=1;
		
		$this->load->helper('url');
		if($template==1){
			$this->load->view('template1');	
		}
		
	}
}
