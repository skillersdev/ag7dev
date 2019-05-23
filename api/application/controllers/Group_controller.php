<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group_controller extends CI_Controller {

	public function index() {
		$this->output->set_content_type('application/json');
		die(json_encode(array('status'=>"failure", 'error'=>'UN-Authorized access'), JSON_UNESCAPED_SLASHES));
	}

   
   public function addgroup()
   {
     $this->output->set_content_type('application/json');
      
        $response=array('status'=>"success",'message'=>"Group added successfully");

        $model = json_decode($this->input->post('model',FALSE));
      //   print_r($model); die;
        
        $group_id=$this->db->query("insert into ".$this->db->dbprefix('group_master')." (group_name,private_public,created_by) values ('".$model->groupname."','".$model->privatepublic."','".$model->currentUserID."')");
        $g_id = $this->db->insert_id();
        // (`id`, `group_name`, `private_public`, `created_by`, `created_date`, `is_deleted`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6])
       
        foreach ($model->userselectedItems as $key => $value) {
         
         $this->db->query("insert into ".$this->db->dbprefix('group_members')." ( group_id,user_id,user_name,created_by) values ('".$g_id."','".$value->Id."','".$value->username."','".$model->currentUserID."')");
      }
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
   }
   public function sendmsg(){
      $this->output->set_content_type('application/json');
      
        $response=array('status'=>"success",'message'=>"Msg sent successfully");

        $model = json_decode($this->input->post('model',FALSE));
      //   print_r($model); die;
        if($model){
         $this->db->query("insert into ".$this->db->dbprefix('all_message')." (group_id,message,created_by) values ('".$model->g_id."','".$model->groupmsgtxt."','".$model->currentUserID."')");
        }
      
        
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
   }
   public function getgroupsdetails(){
    
      $this->output->set_content_type('application/json');
         $response=array();
         $response['status']="success";
         $result=array();

         $model = json_decode($this->input->post('model',FALSE));
   // print_r($model); die;
             $group_sql=$this->db->query("select * from ".$this->db->dbprefix('group_master')." where id='". $model->g_id."' and private_public='2' and  is_deleted='0'");
             $group_array=$group_sql->result_array(); 
             $response['group_details']=$group_array;

             $mem_group_sql=$this->db->query("select * from ".$this->db->dbprefix('group_members')." where group_id='". $model->g_id."'");
             $mem_group_array=$mem_group_sql->result_array(); 
             $response['group_members']=$mem_group_array;

             $msg_group_sql=$this->db->query("select * from ".$this->db->dbprefix('all_message')." where group_id='". $model->g_id."'");
             $msg_group_array=$msg_group_sql->result_array(); 
             $response['group_msg']=$msg_group_array;
            //  print_r($response); die;
          echo json_encode($response,JSON_UNESCAPED_SLASHES);
          die();
       
  }

   public function getgroups(){
    
       $this->output->set_content_type('application/json');
          $response=array();
          $response['status']="success";
          $result=array();

          $model = json_decode($this->input->post('model',FALSE));
    
              $group_sql=$this->db->query("select * from ".$this->db->dbprefix('group_master')." where created_by='". $model->currentUserID."' and private_public='2' and  is_deleted='0'");
              $group_array=$group_sql->result_array(); 
              $response['result']=$group_array;
           echo json_encode($response,JSON_UNESCAPED_SLASHES);
           die();
        
   }
   
   
}
