<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sponsor_controller extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
			 $this->output->set_content_type('application/json')
        ->set_output(json_encode(array('error' => 'UN-Authorized access'),JSON_UNESCAPED_SLASHES)); 
        die();
	}
    
    
    public function create_gems_sponsor(){
        
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        
        
        
        
        
        
        
        
        
        
        
        
        
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
        
        
        
        
    }
    
    
    
    
}
