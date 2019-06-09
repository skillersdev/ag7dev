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
      
        $group_id=$this->db->query("insert into ".$this->db->dbprefix('group_master')." (group_name,imagename,private_public,created_by) values ('".$model->groupname."','".$model->groupimagename."','".$model->privatepublic."','".$model->currentUserID."')");
        $g_id = $this->db->insert_id();
        // (`id`, `group_name`, `private_public`, `created_by`, `created_date`, `is_deleted`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6])
       
        foreach ($model->userselectedItems as $key => $value) {
         // $mem_group_sql=$this->db->query("select * from ".$this->db->dbprefix('group_members')." where group_id='". $model->g_id."' and user_id='".$value->Id."'");
         // $mem_group_array=$mem_group_sql->result_array();

         // if(count($mem_group_array) > 0){

         // }else {
            $this->db->query("insert into ".$this->db->dbprefix('group_members')." ( group_id,group_name,user_id,user_name,created_by) values ('".$g_id."','".$model->groupname."','".$value->Id."','".$value->username."','".$model->currentUserID."')");
         // }
        
      }
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
   }

   public function groupimage()
    {
        $path = 'group_images/';
        $Response=[];
       
        if (isset($_FILES['file'])) 
          {
            $originalName = $_FILES['file']['name'];
            $ext = '.'.pathinfo($originalName, PATHINFO_EXTENSION);
            //print_r($ext);die;
            $upper_Case_ext=strtoupper($ext);

            //3GPP, AVI, FLV, MOV, MPEG4, MPEGPS, WebM and WMV. MPEG4
            if($upper_Case_ext==".IMG"||$upper_Case_ext==".JPG"||$upper_Case_ext==".JPEG"||$upper_Case_ext==".PNG" ||$upper_Case_ext==".MP4" ||$upper_Case_ext==".AVI" ||$upper_Case_ext==".3GPP" ||$upper_Case_ext==".FLV" ||$upper_Case_ext==".MOV" ||$upper_Case_ext==".MPEG4" ||$upper_Case_ext==".MPEGPS" ||$upper_Case_ext==".WebM" ||$upper_Case_ext==".WMV" ||$upper_Case_ext==".MPEG4")
            {

            //   $generatedName = md5($_FILES['file']['tmp_name']).$ext;

              $filePath = $path.$originalName;
            //   $product_image=$filePath;
           
              if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) 
              {
                $Response['status']="success"; 
                $Response['data']=$originalName;
              }
            }
            else 
            {
                $Response['status']="fail"; 
                $Response['data']="Not a valid format";
            }
          }
        else {
            $Response['status']="fail"; 
            $Response['data']="Error While upload on image";
         }
          echo json_encode($Response,JSON_UNESCAPED_SLASHES);
         die();
    }

   public function sendmsg(){
      $this->output->set_content_type('application/json');
      
        $response=array('status'=>"success",'message'=>"Msg sent successfully");

        $model = json_decode($this->input->post('model',FALSE));
      //   print_r($model); die;
        if($model){
         $this->db->query("insert into ".$this->db->dbprefix('all_message')." (group_id,message,created_by,user_name) values ('".$model->g_id."','".$model->groupmsgtxt."','".$model->currentUserID."','".$model->currentUser."')");
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
      
         $group_sql = $this->db->select('group_master.id as id,group_master.group_name as group_name,group_master.imagename')
            ->join('group_members', 'group_members.group_id=group_master.id', 'left')
            ->where('group_members.user_id', $model->currentUserID)
            ->where('group_master.private_public', '2')
            ->where('group_master.is_deleted', '0')
            ->get('group_master');
            $group_array=$group_sql->result_array(); 
            // print_r($group_array); die;
            //   $group_sql=$this->db->query("select * from ".$this->db->dbprefix('group_master')." where created_by='". $model->currentUserID."' and private_public='2' and  is_deleted='0'");
            //   $group_array=$group_sql->result_array(); 
              $response['result']=$group_array;
           echo json_encode($response,JSON_UNESCAPED_SLASHES);
           die();
        
   }
   
   
}
