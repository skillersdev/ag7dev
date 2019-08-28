<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Malllogin_controller extends CI_Controller {

	public function index() {
		$this->output->set_content_type('application/json');
		die(json_encode(array('status'=>"failure", 'error'=>'UN-Authorized access'), JSON_UNESCAPED_SLASHES));
	}

  
  public function checklogin(){
    $model = json_decode($this->input->post('model',FALSE));
   
    $response['exist']=0;
    $type = trim($model->type);
    $username = trim($model->user_name);
    $password = trim($model->user_password);
    
   if($type==1){
    $res=$this->db->select("*")->where(['is_deleted'=>'0','username'=>$username,'password'=>$password])->get('mall_master');  
   }
   if($type==2){
    $res=$this->db->select("*")->where(['is_deleted'=>'0','username'=>$username,'password'=>$password])->get('floor_master');  
   }
   if($type==3){
    $res=$this->db->select("*")->where(['is_deleted'=>'0','username'=>$username,'password'=>$password])->get('shop_master');  
  }

  if($type==4){
    $res=$this->db->select("*")->where(['is_deleted'=>'0','username'=>$username,'password'=>$password])->get('mallproduct_master');  
  }
        

    if(count($res->result_array())>0)
    {
     
        $result=$res->result_array();
        $response['result']=$result;
        $response['exist']=1;
        $response['message']="login successfully";
    }
    else{
         $response['result']=array();
        $response['exist']=0;
        $response['message']="Enter valid user credentials";
    }
    echo json_encode($response,JSON_UNESCAPED_SLASHES);
    die(); 
  }
  
  
}
