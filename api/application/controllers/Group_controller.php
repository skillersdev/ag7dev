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
        
        
        $length=10;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        // echo $randomString; die;channelgroup
        if($model->showinwebsite==1 || $model->showinwebsite==true){
          $showinwebsite=1;
        }else{
          $showinwebsite=0;
        }
        $group_id=$this->db->query("insert into ".$this->db->dbprefix('group_master')." (group_name,channelgroup,group_code,imagename,private_public,showinwebsite,created_by) values ('".$model->groupname."','".$model->channelgroup."','".$randomString."','".$model->groupimagename."','".$model->privatepublic."','".$showinwebsite."','".$model->currentUserID."')");
        $g_id = $this->db->insert_id();
        // (`id`, `group_name`, `private_public`, `created_by`, `created_date`, `is_deleted`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6])
       
        foreach ($model->userselectedItems as $key => $value) {
         // $mem_group_sql=$this->db->query("select * from ".$this->db->dbprefix('group_members')." where group_id='". $model->g_id."' and user_id='".$value->Id."'");
         // $mem_group_array=$mem_group_sql->result_array();

         // if(count($mem_group_array) > 0){

         // }else {
           if($value->Id==$model->currentUserID){
            $this->db->query("insert into ".$this->db->dbprefix('group_members')." ( group_id,group_name,user_id,user_name,admin_normal,created_by) values ('".$g_id."','".$model->groupname."','".$value->Id."','".$value->username."',1,'".$model->currentUserID."')");
           }else {
            $this->db->query("insert into ".$this->db->dbprefix('group_members')." ( group_id,group_name,user_id,user_name,admin_normal,created_by) values ('".$g_id."','".$model->groupname."','".$value->Id."','".$value->username."',0,'".$model->currentUserID."')");
           }
            
         // }
        
      }
      $this->db->query("insert into ".$this->db->dbprefix('group_profile_images_log')." (group_id,image_name) values ('".$g_id."','".$model->groupimagename."')");
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
   }

   public function updategroup()
   {
     $this->output->set_content_type('application/json');
      
        $response=array('status'=>"success",'message'=>"Group added successfully");

        $model = json_decode($this->input->post('model',FALSE));
        $websitelists1 = '';
        // print_r($model); die;
        if(isset($model->showinwebsite) && ($model->showinwebsite==1 || $model->showinwebsite==true)){
          $showinwebsite=1;
         $websitelists1 = isset($model->websitelists1)?$model->websitelists1[0]->website:'';
        }else{
          $showinwebsite=0;
         
        }
        // echo "update ".$this->db->dbprefix('group_master')." set group_name='".$model->groupname."',channelgroup='".$model->channelgroup."',imagename='".$model->groupimagename."',private_public='".$model->privatepublic."',showinwebsite='".$showinwebsite."' where id='".$model->g_id."'"; die;
         $result=$this->db->query("update ".$this->db->dbprefix('group_master')." set group_name='".$model->groupname."',channelgroup='".$model->channelgroup."',imagename='".$model->groupimagename."',private_public='".$model->privatepublic."',showinwebsite='".$showinwebsite."',websitename='".$websitelists1."' where id='".$model->g_id."'");

        $group_id=$this->db->query("DELETE FROM ".$this->db->dbprefix('group_members')."  WHERE group_id='".$model->g_id."'");

        // $group_members_sql=$this->db->query("select * from ".$this->db->dbprefix('group_master')." where id='".$model->g_id."'");

        $group_members_sql = $this->db->select('group_master.id,group_master.group_name,affiliateuser.username,group_master.created_by')
        ->join('affiliateuser', 'group_master.created_by=affiliateuser.Id', 'left')
        ->where('group_master.id',$model->g_id)
        ->get('group_master');

        $group_members_array=$group_members_sql->result_array();
        // print_r($group_members_array);
        if(count($group_members_array) > 0){ 
          $this->db->query("insert into ".$this->db->dbprefix('group_members')." ( group_id,group_name,user_id,user_name,admin_normal,created_by) values ('".$group_members_array[0]['id']."','".$group_members_array[0]['group_name']."','".$group_members_array[0]['created_by']."','".$group_members_array[0]['username']."',1,'".$group_members_array[0]['created_by']."')");
         
          foreach ($model->userselectedItems as $key => $value) {
            $mem_group_sql=$this->db->query("select * from ".$this->db->dbprefix('group_members')." where group_id='". $model->g_id."' and user_id='".$value->Id."'");
            $mem_group_array=$mem_group_sql->result_array();
   
            if(count($mem_group_array) > 0){
   
            }else {
             if($value->Id==$model->currentUserID){
               $this->db->query("insert into ".$this->db->dbprefix('group_members')." ( group_id,group_name,user_id,user_name,admin_normal,created_by) values ('".$model->g_id."','".$model->groupname."','".$value->Id."','".$value->username."',1,'".$group_members_array[0]['created_by']."')");
              }else {
               $this->db->query("insert into ".$this->db->dbprefix('group_members')." ( group_id,group_name,user_id,user_name,admin_normal,created_by) values ('".$model->g_id."','".$model->groupname."','".$value->Id."','".$value->username."',0,'".$group_members_array[0]['created_by']."')");
              }
               // $this->db->query("insert into ".$this->db->dbprefix('group_members')." ( group_id,group_name,user_id,user_name,created_by) values ('".$model->g_id."','".$model->groupname."','".$value->Id."','".$value->username."','".$model->currentUserID."')");
            }
           
         }
        $this->db->query("insert into ".$this->db->dbprefix('group_profile_images_log')." (group_id,image_name) values ('".$model->g_id."','".$model->groupimagename."')");

        }

       
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
   }

   public function deletegroup()
   {
     $this->output->set_content_type('application/json');
      
        $response=array('status'=>"success",'message'=>"Group delete successfully");

        $model = json_decode($this->input->post('model',FALSE));
        
        $result=$this->db->query("update ".$this->db->dbprefix('group_master')." set is_deleted=1 where id='".$model->g_id."'");
        
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
   }

   public function exitgroup()
   {
     $this->output->set_content_type('application/json');
      
        $response=array('status'=>"success",'message'=>"Group exit successfully");

        $model = json_decode($this->input->post('model',FALSE));
        // print_r($model); die; 
        $result=$this->db->query("update ".$this->db->dbprefix('group_members')." set is_deleted=1 where group_id='".$model->g_id."' and user_id='".$model->currentUserID."'");
        
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
   }

   
   public function msggroupimage()
    {
        $path = 'groupchat_images/';
        $Response=[];
       
        if (isset($_FILES['file'])) 
          {
            $originalName = $_FILES['file']['name'];
            $ext = '.'.pathinfo($originalName, PATHINFO_EXTENSION);
            
            $upper_Case_ext=strtoupper($ext);

            //3GPP, AVI, FLV, MOV, MPEG4, MPEGPS, WebM and WMV. MPEG4
            // if($upper_Case_ext==".DOC"||$upper_Case_ext==".PDF"||$upper_Case_ext==".IMG"||$upper_Case_ext==".DOCX"||$upper_Case_ext==".PPT"||$upper_Case_ext==".MP3"||$upper_Case_ext==".JPG"||$upper_Case_ext==".JPEG"||$upper_Case_ext==".PNG" ||$upper_Case_ext==".MP4" ||$upper_Case_ext==".AVI" ||$upper_Case_ext==".3GPP" ||$upper_Case_ext==".FLV" ||$upper_Case_ext==".MOV" ||$upper_Case_ext==".MPEG4" ||$upper_Case_ext==".MPEGPS" ||$upper_Case_ext==".WebM" ||$upper_Case_ext==".WMV" ||$upper_Case_ext==".MPEG4")
            // {
              $chatimage = time().$_FILES['file']['name'];
              $filePath = $path.$chatimage;
           
              if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) 
              {

                $Response['status']="success"; 
                $Response['data']=$chatimage;
              }
            // }
            // else 
            // {
            //     $Response['status']="fail"; 
            //     $Response['data']="Not a valid format";
            // }
          }
        else {
            $Response['status']="fail"; 
            $Response['data']="Error While upload on image";
         }
          echo json_encode($Response,JSON_UNESCAPED_SLASHES);
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
            if($upper_Case_ext==".IMG"||$upper_Case_ext==".JPG"||$upper_Case_ext==".JPEG"||$upper_Case_ext==".PNG" ||$upper_Case_ext==".MP4" ||$upper_Case_ext==".AVI" ||$upper_Case_ext==".3GPP" ||$upper_Case_ext==".FLV" ||$upper_Case_ext==".MOV" ||$upper_Case_ext==".MPEG4" ||$upper_Case_ext==".MPEGPS" ||$upper_Case_ext==".WebM" ||$upper_Case_ext==".WMV" ||$upper_Case_ext==".MPEG4" || upper_Case_ext=="DOC" || upper_Case_ext=="DOCX" || upper_Case_ext=="PPT" || upper_Case_ext=="XLS" || upper_Case_ext=="XLSX")
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

    public function pimage()
    {
        $path = 'user_profile/';
        $Response=[];
       
        if (isset($_FILES['file'])) 
          {
            $originalName = $_FILES['file']['name'];
            $ext = '.'.pathinfo($originalName, PATHINFO_EXTENSION);
            //print_r($ext);die;
            $upper_Case_ext=strtoupper($ext);

            if($upper_Case_ext==".IMG"||$upper_Case_ext==".JPG"||$upper_Case_ext==".JPEG"||$upper_Case_ext==".PNG")
            {

            //   $generatedName = md5($_FILES['file']['tmp_name']).$ext;
            $pp = time().$ext;
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
        // print_r($model->groupmsgtxt); die;
        if($model){
          if($model->groupmsgtxt!=''){
            $model->groupimagename='';
          } 

         $this->db->query("insert into ".$this->db->dbprefix('all_message')." (group_id,message,chatimage,created_by,user_name) values ('".$model->g_id."','".$model->groupmsgtxt."','".$model->groupimagename."','".$model->currentUserID."','".$model->currentUser."')");
        $insert_id = $this->db->insert_id();

        $group_members=$this->db->query("select user_id from ".$this->db->dbprefix('group_members')." where group_id='". $model->g_id."'  and  is_deleted='0'");
        $group_members_array=$group_members->result_array(); 
          foreach ($group_members_array as $key => $value) {
            if($model->currentUserID!=$value['user_id']){
              $this->db->query("insert into ".$this->db->dbprefix('msg_readorunread')." (msg_id,group_id,user_id,status) values ('".$insert_id."','".$model->g_id."','".$value['user_id']."',1)");
            }
            
          }
        }
      
        
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
   }

   public function imagesendmsg(){
    $this->output->set_content_type('application/json');
    
      $response=array('status'=>"success",'message'=>"Msg sent successfully");

      $model = json_decode($this->input->post('model',FALSE));
    //   print_r($model); die;
      if($model){
       $this->db->query("insert into ".$this->db->dbprefix('all_message')." (group_id,chatimage,created_by,user_name) values ('".$model->g_id."','".$model->chatimage."','".$model->currentUserID."','".$model->currentUser."')");
       $insert_id = $this->db->insert_id();

       $group_members=$this->db->query("select user_id from ".$this->db->dbprefix('group_members')." where group_id='". $model->g_id."'  and  is_deleted='0'");
       $group_members_array=$group_members->result_array(); 
         foreach ($group_members_array as $key => $value) {
           if($model->currentUserID!=$value['user_id']){
             $this->db->query("insert into ".$this->db->dbprefix('msg_readorunread')." (msg_id,group_id,user_id,status) values ('".$insert_id."','".$model->g_id."','".$value['user_id']."',1)");
           }
           
         }
      }
    
      
      echo json_encode($response,JSON_UNESCAPED_SLASHES);
      die();
 }

   public function mychatgroup(){
    
      $this->output->set_content_type('application/json');
         $response=array();
         $response['status']="success";
         $result=array();

         $model = json_decode($this->input->post('model',FALSE));
   // print_r($model); die;

    $group_sql=$this->db->query("select * from ".$this->db->dbprefix('group_master')." where id='". $model->g_id."'  and  is_deleted='0' and private_public=3");
             $group_array=$group_sql->result_array(); 
             $response['group_details']=$group_array;
// print_r($group_array); die;
             
         $check_user = $this->db->query("select * from ".$this->db->dbprefix('group_members')." where group_id='". $model->g_id."'");
         $check_user_array=$check_user->result_array();
// print_r($check_user_array); die;
        // if(count($check_user_array)==0){
        //   $response['check_user']=0;
        // } else {
        //   $response['check_user']=1;
         
         $response['check_user']=1;
             $mem_group_sql=$this->db->query("select *,user_id as Id,user_name as username from ".$this->db->dbprefix('group_members')." where group_id='". $model->g_id."'  GROUP BY user_name");
             $mem_group_array=$mem_group_sql->result_array(); 
             $mem_group_array1=$mem_group_sql->result_object(); 
            //  print_r($mem_group_array1); die;
             $response['group_members']=$mem_group_array;
             $response['select_group_members']=$mem_group_array1;

             $msg_group_array1 = array();
             $datearray =array();


             $group_sql1=$this->db->query("select * from ".$this->db->dbprefix('group_master')." where created_by='".  $model->currentUserID."'  and  is_deleted='0' and private_public=3");
             $login_group_array1=$group_sql1->result_array(); 

// print_r($login_group_array1); die;
            //  $msg_group_sql=$this->db->query("select * from ".$this->db->dbprefix('all_message')." where group_id='". $model->g_id."' and is_deleted=0 and  (created_by='". $model->currentUserID."' or created_by='". $group_array[0]['created_by']."' )");
            //  $msg_group_array1=$msg_group_sql->result_array(); 
          // if(count($login_group_array1)>0){
            $other_msg_group_sql=$this->db->query("select * from ".$this->db->dbprefix('all_message')." where (group_id='". $model->g_id."' and is_deleted=0 and  (created_by='". $model->currentUserID."' or created_by='". $group_array[0]['created_by']."' ) ) or (group_id='". $login_group_array1[0]['id']."' and is_deleted=0 and  (created_by='". $model->currentUserID."' or created_by='". $group_array[0]['created_by']."' )) ORDER BY id");
            $other_msg_group_array=$other_msg_group_sql->result_array(); 

            // $msg_group_array = array_merge($msg_group_array1,$other_msg_group_array);
            $msg_group_array = $other_msg_group_array;
            foreach ($msg_group_array as $msg_key => $msg_value) {

              $res1=$this->db->query("select * from ".$this->db->dbprefix('affiliateuser')." where Id='".$msg_value['created_by']."'")->result_array();
              if($res1[0]['aliasname']!=''){
                $msg_value['user_name']=$res1[0]['aliasname'];
              }else{
                $msg_value['user_name']=$res1[0]['username'];
              }
              htmlspecialchars_decode(stripslashes($msg_value['message']));
              $msg_value['message_link']=0;
              if(preg_match("/https:/", $msg_value['message']) || preg_match("/http:/",$msg_value['message'])){
                $msg_value['message_link'] = 1;
              }elseif(preg_match("/www./", $msg_value['message'])){
                $msg_value['message_link'] = 1;
                $msg_value['message'] = "https://".$msg_value['message'];
              }
             $newDate = date("m-d-Y", strtotime($msg_value['created_date']));
             if(in_array($newDate,$datearray)){
              
             } else{
                $datearray[] = $newDate;  
             }
              $msg_value['video_type'] = 0;
             if($msg_value['chatimage']!=''){
               $ext = explode(".", $msg_value['chatimage']);
               $upper_Case_ext=strtoupper($ext[1]);
               if($upper_Case_ext=="MP4"){
                 $msg_value['video_type'] = 1;
               }
               if($upper_Case_ext=="MP3"){
                 $msg_value['video_type'] = 2;
               }
               if($upper_Case_ext=="PDF" || $upper_Case_ext=="DOC" || $upper_Case_ext=="DOCX" || $upper_Case_ext=="PPT" || $upper_Case_ext=="XLS" || $upper_Case_ext=="XLSX"){
                 $msg_value['video_type'] = 3;
               }
             }

              $msg_group_array1[$newDate][] = $msg_value;
              // print_r($msg_value['created_date']);
            }
          // }
            
             
             $group_image_sql=$this->db->query("select * from ".$this->db->dbprefix('group_profile_images_log')." where group_id='". $model->g_id."'");
             $group_image_array=$group_image_sql->result_array(); 
             $response['group_profile_details']=$group_image_array;
             // $datearray = array_unique($datearray);
              // print_r($msg_group_array1);
              // die;
             $response['group_msg']=$msg_group_array1;
             $response['date_array']=$datearray;

        // }
             
            //  print_r($response); die;
          echo json_encode($response,JSON_UNESCAPED_SLASHES);
          die();
       
  }

  public function getgroupsdetailspublic(){
    
      $this->output->set_content_type('application/json');
         $response=array();
         $response['status']="success";
         $result=array();

         $model = json_decode($this->input->post('model',FALSE));
   // print_r($model); die;and private_public=4

    $group_sql=$this->db->query("select * from ".$this->db->dbprefix('group_master')." where id='". $model->g_id."'  and  is_deleted='0' ");
             $group_array=$group_sql->result_array(); 
             $response['group_details']=$group_array;

             
         $check_user = $this->db->query("select * from ".$this->db->dbprefix('group_members')." where group_id='". $model->g_id."' and user_id='". $model->currentUserID."'");
         $check_user_array=$check_user->result_array();
// print_r($check_user_array); die;
        if(count($check_user_array)==0){
          $response['check_user']=0;
        } else {
          $response['check_user']=1;
         
          $mem_group_sql = $this->db->select('group_members.user_id as Id,affiliateuser.username as username,affiliateuser.username as user_name,group_members.is_deleted,group_members.group_id,group_members.admin_normal,group_members.created_by,group_members.group_name')
          ->join('affiliateuser', 'group_members.user_id=affiliateuser.Id', 'left')
          ->where('group_members.group_id',$model->g_id)
          ->group_by('affiliateuser.username')
          ->get('group_members');
            //  $mem_group_sql=$this->db->query("select *,user_id as Id,user_name as username from ".$this->db->dbprefix('group_members')." where group_id='". $model->g_id."'  GROUP BY user_name");
             $mem_group_array=$mem_group_sql->result_array(); 
             $mem_group_array1=$mem_group_sql->result_object(); 
            //  print_r($mem_group_array1); die;
             $response['group_members']=$mem_group_array;
             $response['select_group_members']=$mem_group_array1;

             $msg_group_sql=$this->db->query("select * from ".$this->db->dbprefix('all_message')." where group_id='". $model->g_id."' and is_deleted=0");
             $msg_group_array1 = array();
             $datearray =array();
             $msg_group_array=$msg_group_sql->result_array(); 
             foreach ($msg_group_array as $msg_key => $msg_value) {

              $res1=$this->db->query("select * from ".$this->db->dbprefix('affiliateuser')." where Id='".$msg_value['created_by']."'")->result_array();
              if($res1[0]['aliasname']!=''){
                $msg_value['user_name']=$res1[0]['aliasname'];
              }else{
                $msg_value['user_name']=$res1[0]['username'];
              }
              htmlspecialchars_decode(stripslashes($msg_value['message']));
              $msg_value['message_link']=0;
              if(preg_match("/https:/", $msg_value['message']) || preg_match("/http:/",$msg_value['message'])){
                $msg_value['message_link'] = 1;
              }elseif(preg_match("/www./", $msg_value['message'])){
                $msg_value['message_link'] = 1;
                $msg_value['message'] = "https://".$msg_value['message'];
              }
              $newDate = date("m-d-Y", strtotime($msg_value['created_date']));
              if(in_array($newDate,$datearray)){
               
              } else{
                 $datearray[] = $newDate;  
              }
               $msg_value['video_type'] = 0;
              if($msg_value['chatimage']!=''){
                $ext = explode(".", $msg_value['chatimage']);
                $upper_Case_ext=strtoupper($ext[1]);
                if($upper_Case_ext=="MP4"){
                  $msg_value['video_type'] = 1;
                }
                if($upper_Case_ext=="MP3"){
                  $msg_value['video_type'] = 2;
                }
                if($upper_Case_ext=="PDF" || $upper_Case_ext=="DOC" || $upper_Case_ext=="DOCX" || $upper_Case_ext=="PPT" || $upper_Case_ext=="XLS" || $upper_Case_ext=="XLSX"){
                  $msg_value['video_type'] = 3;
                }
              }

               $msg_group_array1[$newDate][] = $msg_value;
               // print_r($msg_value['created_date']);
             }
             
             $group_image_sql=$this->db->query("select * from ".$this->db->dbprefix('group_profile_images_log')." where group_id='". $model->g_id."'");
             $group_image_array=$group_image_sql->result_array(); 
             $response['group_profile_details']=$group_image_array;
             // $datearray = array_unique($datearray);
              // print_r($msg_group_array1);
              // die;
             $response['group_msg']=$msg_group_array1;
             $response['date_array']=$datearray;
             $response['admin_normal']=$check_user_array[0]['admin_normal'];

        }
             
            //  print_r($response); die;
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

    $group_sql=$this->db->query("select * from ".$this->db->dbprefix('group_master')." where id='". $model->g_id."'  and  is_deleted='0'");
             $group_array=$group_sql->result_array(); 
             $response['group_details']=$group_array;

             
         $check_user = $this->db->query("select * from ".$this->db->dbprefix('group_members')." where group_id='". $model->g_id."' and user_id='". $model->currentUserID."'");
         $check_user_array=$check_user->result_array();
// print_r($check_user_array); die; 
        if(count($check_user_array)==0){
          $response['check_user']=0;
        } else {
          $response['check_user']=1;
         
          $mem_group_sql = $this->db->select('group_members.user_id as Id,affiliateuser.username as username,affiliateuser.username as user_name,group_members.is_deleted,group_members.group_id,group_members.admin_normal,group_members.created_by,group_members.group_name')
          ->join('affiliateuser', 'group_members.user_id=affiliateuser.Id', 'left')
          ->where('group_members.group_id',$model->g_id)
          ->group_by('affiliateuser.username')
          ->get('group_members');
// echo  $mem_group_sql; die;
            //  $mem_group_sql=$this->db->query("select *,user_id as Id,user_name as username from ".$this->db->dbprefix('group_members')." where group_id='". $model->g_id."' GROUP BY user_name");
             $mem_group_array=$mem_group_sql->result_array(); 
             $mem_group_array1=$mem_group_sql->result_object(); 
            //  print_r($mem_group_array1); die;
             $response['group_members']=$mem_group_array;

             $response['select_group_members']=$mem_group_array1;
            //  id>'". $model->msgstartid."' and
             $msg_group_sql=$this->db->query("select * from ".$this->db->dbprefix('all_message')." where  group_id='". $model->g_id."' and is_deleted=0");
             $msg_group_array1 = array();
             $datearray =array();
             $last_msg_group_sql=$this->db->query("select id from ".$this->db->dbprefix('all_message')." ORDER BY id  DESC LIMIT 1")->result_array();
             
             $msg_group_array=$msg_group_sql->result_array(); 
            //  print_r($msg_group_array); die;
             foreach ($msg_group_array as $msg_key => $msg_value) {
              $res1=$this->db->query("select * from ".$this->db->dbprefix('affiliateuser')." where Id='".$msg_value['created_by']."'")->result_array();
              if($res1[0]['aliasname']!=''){
                $msg_value['user_name']=$res1[0]['aliasname'];
              }else{
                $msg_value['user_name']=$res1[0]['username'];
              }
              htmlspecialchars_decode(stripslashes($msg_value['message']));
               
              $msg_value['message_link']=0;
              if(preg_match("/https:/", $msg_value['message']) || preg_match("/http:/",$msg_value['message'])){
                $msg_value['message_link'] = 1;
              }elseif(preg_match("/www./", $msg_value['message'])){
                $msg_value['message_link'] = 1;
                $msg_value['message'] = "https://".$msg_value['message'];
              }

              $newDate = date("m-d-Y", strtotime($msg_value['created_date']));
              if(in_array($newDate,$datearray)){
               
              } else{
                 $datearray[] = $newDate;  
              }
               $msg_value['video_type'] = 0;
              if($msg_value['chatimage']!=''){
                $ext = explode(".", $msg_value['chatimage']);
                $upper_Case_ext=strtoupper($ext[1]);
                // echo $upper_Case_ext; die;
                if($upper_Case_ext=="MP4"){
                  $msg_value['video_type'] = 1;
                }
                if($upper_Case_ext=="MP3"){
                  $msg_value['video_type'] = 2;
                }
                if($upper_Case_ext=="PDF" || $upper_Case_ext=="DOC" || $upper_Case_ext=="DOCX" || $upper_Case_ext=="PPT" || $upper_Case_ext=="XLS" || $upper_Case_ext=="XLSX"){
                  $msg_value['video_type'] = 3;
                }
              }

               $msg_group_array1[$newDate][] = $msg_value;
               // print_r($msg_value['created_date']);
             }
             
             $group_image_sql=$this->db->query("select * from ".$this->db->dbprefix('group_profile_images_log')." where group_id='". $model->g_id."'");
             $group_image_array=$group_image_sql->result_array(); 
             $response['group_profile_details']=$group_image_array;
             // $datearray = array_unique($datearray);
              // print_r($msg_group_array1);
              // die;
              $response['msgstartid']=(int)$last_msg_group_sql[0]['id'];
             $response['group_msg']=$msg_group_array1;
             $response['date_array']=$datearray;
             $response['admin_normal']=$check_user_array[0]['admin_normal'];
             

        }
             
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
        if($model->search_group_name!=''){
          $group_sql = $this->db->select('group_master.id as id,group_master.group_name as group_name,group_master.imagename,group_master.channelgroup,group_master.private_public,group_master.group_code')
            ->join('group_members', 'group_members.group_id=group_master.id', 'left')
            // ->like('group_master.group_name',$model->search_group_name) told sridhar
            ->where('group_master.group_name',$model->search_group_name)
            // ->where('group_members.user_id', $model->currentUserID)
            ->where('group_master.private_public', '1')
            ->where('group_master.is_deleted', '0')
            ->where('group_members.is_deleted', '0')
            ->group_by('group_master.id')
            ->get('group_master');
        } else {
         $group_sql = $this->db->select('group_master.id as id,group_master.group_name as group_name,group_master.imagename,group_master.channelgroup,group_master.private_public,group_master.group_code')
            ->join('group_members', 'group_members.group_id=group_master.id', 'left')
            ->where('group_members.user_id', $model->currentUserID)
            // ->where('group_master.private_public', '2')
            ->where('group_master.is_deleted', '0')
            ->where('group_members.is_deleted', '0')
            ->get('group_master');
          }
            $group_array=$group_sql->result_array(); 
            $data=array();
           $ss=  array_map("unserialize", array_unique(array_map("serialize", $group_array)));
           foreach ($ss as $key => $value) {
            //  print_r($value); die;
            $group_members_count=$this->db->query("select id from ".$this->db->dbprefix('msg_readorunread')." where group_id='". $value['id']."'  and  user_id='".$model->currentUserID."'");
            $group_members_count1=$group_members_count->result_array();
            $count = count($group_members_count1);
            //  $data[] =$value;
            $data[] = array('id'=>$value['id'],'group_name'=>$value['group_name'],'imagename'=>$value['imagename'],'channelgroup'=>$value['channelgroup'],'private_public'=>$value['private_public'],'group_code'=>$value['group_code'],'count_msg'=>$count);
           }
          //  print_r($ss); die;
            //   $group_sql=$this->db->query("select * from ".$this->db->dbprefix('group_master')." where created_by='". $model->currentUserID."' and private_public='2' and  is_deleted='0'");
            //   $group_array=$group_sql->result_array(); 
              $response['result']=$data;
           echo json_encode($response,JSON_UNESCAPED_SLASHES);
           die();
        
        
   }
   
   public function getmygroups(){
    
    $this->output->set_content_type('application/json');
       $response=array();
       $response['status']="success";
       $result=array();

       $model = json_decode($this->input->post('model',FALSE));
     if($model->search_group_name!=''){
       $group_sql = $this->db->select('group_master.id as id,group_master.group_name as group_name,group_master.imagename,group_master.private_public,group_master.group_code')
        //  ->join('group_members', 'group_members.group_id=group_master.id', 'left')
         ->like('group_master.group_name',$model->search_group_name) 
        //  ->where('group_master.group_name',$model->search_group_name)
         // ->where('group_members.user_id', $model->currentUserID)
         ->where('group_master.private_public', '3')
         ->where('group_master.is_deleted', '0')
        //  ->where('group_members.is_deleted', '0')
         ->group_by('group_master.id')
         ->get('group_master');
         
         $group_array=$group_sql->result_array();
     } else {
      $login_group_array1=array();
      $login_group_sql=$this->db->query("select id from ".$this->db->dbprefix('group_master')." where created_by='". $model->currentUserID."' and private_public='3' and  is_deleted='0'");
      $login_group_array=$login_group_sql->result_array(); 
      if(count($login_group_array)>0){
        $login_group_sql = $this->db->select('group_master.id as id,group_master.group_name as group_name,group_master.imagename,group_master.private_public,group_master.group_code')
         ->join('all_message', 'all_message.created_by=group_master.created_by', 'left')
         ->where('all_message.group_id', $login_group_array[0]['id'])
          ->where('group_master.private_public', '3')
         ->where('group_master.is_deleted', '0')
         ->where('all_message.is_deleted', '0')
         ->group_by('group_master.id')
         ->get('group_master');
         $login_group_array1=$login_group_sql->result_array();
        //  print_r($login_group_array1); die;
      }
      $group_sql = $this->db->select('group_master.id as id,group_master.group_name as group_name,group_master.imagename,group_master.private_public,group_master.group_code')
         ->join('all_message', 'all_message.group_id=group_master.id', 'left')
         ->where('all_message.created_by', $model->currentUserID)
          ->where('group_master.private_public', '3')
         ->where('group_master.is_deleted', '0')
         ->where('all_message.is_deleted', '0')
         ->group_by('group_master.id')
         ->get('group_master');
         $group_array1=$group_sql->result_array();

         $ss = array_merge($group_array1,$login_group_array1);
        $group_array =  array_map("unserialize", array_unique(array_map("serialize", $ss)));;
       
       }
       $data=array();
       foreach ($group_array as $key => $value) {
        $data[] =$value;
      }
        //  $group_array=$group_sql->result_array(); 
         // print_r($group_array); die;
         //   $group_sql=$this->db->query("select * from ".$this->db->dbprefix('group_master')." where created_by='". $model->currentUserID."' and private_public='2' and  is_deleted='0'");
         //   $group_array=$group_sql->result_array(); 
           $response['result']=$data;
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
     
     
}

   public function checkuserhavinggroup()
   {

       $this->output->set_content_type('application/json');
          $response=array();          
          $result=array();

          $model = json_decode($this->input->post('model',FALSE));
          
          $group_sql=$this->db->query("select * from ".$this->db->dbprefix('group_master')." where group_code='". $model->groupcode."'  and  is_deleted='0'");
          $group_array=$group_sql->result_array(); 

          if(count($group_array)>0)
          {
            $mem_group_sql=$this->db->query("select * from ".$this->db->dbprefix('group_members')." where group_id='". $group_array[0]['id']."' AND user_id='".$model->user_id."'");
             $mem_group_array=$mem_group_sql->result_array(); 
             if(count($mem_group_array)>0)
             {
                $response['exist']="1";
                $response['group_id'] = $group_array[0]['id'];
                $response['group_name'] = $group_array[0]['group_name'];
                $response['message']="User already in chat group";
             }
             else
             {
                $response['exist']="0";
                $response['group_id'] = $group_array[0]['id'];
                $response['group_name'] = $group_array[0]['group_name'];
                $response['message']="User Not in chat group";
             }
          }
          else
          {
            $response['exist']="2";
          }
           echo json_encode($response,JSON_UNESCAPED_SLASHES);
           die();
          //print_r($group_array);die;
   }

   public function getcodetogroup(){
    
      $this->output->set_content_type('application/json');
         $response=array();
         $response['status']="success";
         $result=array();

         $model = json_decode($this->input->post('model',FALSE));
    
//and private_public=4
    $group_sql=$this->db->query("select * from ".$this->db->dbprefix('group_master')." where group_code='". $model->groupcode."' and  is_deleted='0'");
             $group_array=$group_sql->result_array(); 
             $response['group_details']=$group_array;

             
            // print_r($response); die;
          echo json_encode($response,JSON_UNESCAPED_SLASHES);
          die();
       
  }

   public function getmychatcodetogroup(){
    
      $this->output->set_content_type('application/json');
         $response=array();
         $response['status']="success";
         $result=array();

         $model = json_decode($this->input->post('model',FALSE));
    

    $group_sql=$this->db->query("select * from ".$this->db->dbprefix('group_master')." where group_code='". $model->groupcode."'  and private_public=3 and  is_deleted='0'");
             $group_array=$group_sql->result_array(); 
             $response['group_details']=$group_array;

             
            // print_r($response); die;
          echo json_encode($response,JSON_UNESCAPED_SLASHES);
          die();
       
  }


   public function addusertogroup()
   {
        $response=array('status'=>"success",'message'=>"Successfully added into group");

        $model = json_decode($this->input->post('model',FALSE));

        //print_r($model1->user_id);die;

        $payme_by=$this->db->select("username")->where(['id'=>$model->user_id])->get('affiliateuser');
        $user_det=$payme_by->result_array();

        // $model1->user_name = $user_det[0]['username'];
        // $model1->user_id = $model->user_id;
        // $model1->group_id = $model->group_id; 
        // $model1->group_name = $model->group_name; 
        // $model1->created_by = $model->user_id;
        
        $this->db->query("insert into ".$this->db->dbprefix('group_members')." ( group_id,group_name,user_id,user_name,created_by) values ('".$model->group_id."','".$model->group_name."','".$model->user_id."','".$user_det[0]['username']."','".$model->user_id."')");



       // $this->db->insert('group_members', $model1);

        

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
   }
   public function getchatgroupslist()
   {
     $res=$this->db->select("*,DATE_FORMAT(created_date,'%d/%m/%Y')as created_date")->where(['is_deleted'=>'0'])->get('group_master'); 
       $result=[];
       $response=[];
        if(count($res->result_array())>0)
        {
            
            foreach($res->result_array() as $key=>$value)
              { 
                
                $channelgroup = ($value['channelgroup']==1)?'Channel':'Group';

                $res11=$this->db->query("select * from ".$this->db->dbprefix('affiliateuser')." where id='".$value['created_by']."' ");
                $in_array11=$res11->result_array();

                $result[]=array('id'=>$value['id'],'group_name'=>$value['group_name'],'channelgroup'=>$channelgroup,'created_date'=>$value['created_date'],'created_by'=>$in_array11[0]['username'],'group_code'=>$value['group_code']);
              }
        }
        echo json_encode($result,JSON_UNESCAPED_SLASHES);
        die();
   }

   public function getchatslistbygroup($id)
   {
     $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();

            $res=$this->db->query("select * from ".$this->db->dbprefix('all_message')." where group_id='".$id."'");

            if($res->num_rows()>0){
                $in_array=$res->result_array();
                 if(count($res->result_array())>0)
                  {
                      
                      foreach($res->result_array() as $key=>$value)
                        { 
                          
                          //$channelgroup = ($value['channelgroup']==1)?'Channel':'Group';

                          $res11=$this->db->query("select * from ".$this->db->dbprefix('group_master')." where id='".$value['group_id']."' ");
                          $in_array11=$res11->result_array();

                          $result[]=array('id'=>$value['id'],'group_name'=>$in_array11[0]['group_name'],'created_date'=>$value['created_date'],'message'=>$value['message'],'created_by'=>$value['user_name'],'group_code'=>$in_array11[0]['group_code']);
                        }
                  }

                //$result=$in_array;
            }else{
                $response['status']="failure";
                $response['message']=" No Chat record found!!";
            }
            $response['result']=$result;

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
   }
   public function getsubscribersbygrouplist($id)
   {

        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();

        $res = $this->db->query("select * from ".$this->db->dbprefix('group_members')." where group_id='". $id."' and is_deleted=0 ");
         if($res->num_rows()>0){
          //  $res=$res->result_array();
            if(count($res->result_array())>0)
            {                      
              foreach($res->result_array() as $key=>$value)
                { 
                  $result[]=array('id'=>$value['id'],'group_name'=>$value['group_name'],'created_date'=>$value['created_date'],'created_by'=>$value['user_name']);
                }
            }
          }
          else{
              $response['status']="failure";
              $response['message']=" No Chat record found!!";
          }
        $response['result']=$result;

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
   }
   
   public function deletesubscriber($id)
   {
      $subscriber_delete=$this->db->query("DELETE FROM group_members where id='".$id."' "); 

      $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $response['message']="Subscribers deleted successfully";
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
   }

   public function chatmsgdelete(){

    $this->output->set_content_type('application/json');
      
        $response=array('status'=>"success",'message'=>"message deleted successfully");

        $model = json_decode($this->input->post('model',FALSE));
        // print_r($model); die; 
        $result=$this->db->query("update ".$this->db->dbprefix('all_message')." set is_deleted=1 where id='".$model->id."'");
        
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
   }

   public function chatmsgedit(){

    $this->output->set_content_type('application/json');
      
        $response=array('status'=>"success",'message'=>"message");

        $model = json_decode($this->input->post('model',FALSE));
        // print_r($model); die; 
        $res11=$this->db->query("select * from ".$this->db->dbprefix('all_message')." where id='".$model->id."' ");
        $response['msg']=$res11->result_array();
        
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
   }
   public function chatmsgupdate(){

    $this->output->set_content_type('application/json');
      
        $response=array('status'=>"success",'message'=>"message update successfully");

        $model = json_decode($this->input->post('model',FALSE));
        // print_r($model); die; 
        $result=$this->db->query("update ".$this->db->dbprefix('all_message')." set message='".$model->msgupdate."' where id='".$model->id."'");
        
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
   }

   public function chatmsgreply(){

    $this->output->set_content_type('application/json');
      
        $response=array('status'=>"success",'message'=>"reply message added successfully");

        $model = json_decode($this->input->post('model',FALSE));
        // print_r($model); die; replyid to database
        // $result=$this->db->query("update ".$this->db->dbprefix('all_message')." set message='".$model->msgupdate."' where id='".$model->id."'"); replymsgid
        
        $this->db->query("insert into ".$this->db->dbprefix('all_message')." (group_id,message,replyid,chatimage,created_by,user_name) values ('".$model->g_id."','".$model->replymsgupdate."','".$model->replymsgid."','','".$model->currentUserID."','".$model->currentUser."')");
        $group_members=$this->db->query("select user_id from ".$this->db->dbprefix('group_members')." where group_id='". $model->g_id."'  and  is_deleted='0'");
        $group_members_array=$group_members->result_array(); 
          foreach ($group_members_array as $key => $value) {
            if($model->currentUserID!=$value['user_id']){
              $this->db->query("insert into ".$this->db->dbprefix('msg_readorunread')." (msg_id,group_id,user_id,status) values ('".$insert_id."','".$model->g_id."','".$value['user_id']."',1)");
            }
            
          }
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
   }
   
   public function makegroupadmin(){

    $this->output->set_content_type('application/json');
      
        $response=array('status'=>"success",'message'=>"Group admin rights changed successfully");

        $model = json_decode($this->input->post('model',FALSE));
        
        $result=$this->db->query("update ".$this->db->dbprefix('group_members')." set admin_normal=".$model->val." where user_id='".$model->id."' and group_id='". $model->group_id."'");
       
        $check_user = $this->db->query("select *,user_id as Id,user_name as username from ".$this->db->dbprefix('group_members')." where group_id='". $model->group_id."' and is_deleted=0 GROUP BY user_id");
        $response['groupmemlists']=$check_user->result_array();
        
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();

   
   }

   public function groupuseraddreove(){

    $this->output->set_content_type('application/json');
      
        $response=array('status'=>"success",'message'=>"changed successfully");

        $model = json_decode($this->input->post('model',FALSE));
        
        $result=$this->db->query("update ".$this->db->dbprefix('group_members')." set is_deleted=".$model->val." where user_id='".$model->id."' and group_id='". $model->group_id."'");

        $check_user = $this->db->query("select *,user_id as Id,user_name as username from ".$this->db->dbprefix('group_members')." where group_id='". $model->group_id."' and is_deleted=0 GROUP BY user_id");
        $response['groupmemlists']=$check_user->result_array();
        
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
   
   }

   

    public function sendrequestforgroup()
   {
     $this->output->set_content_type('application/json');
      
        $response=array('status'=>"success",'message'=>"Request sent successfully");

        $model = json_decode($this->input->post('model',FALSE));
        //print_r($model->selectedmarketeritems);die;
        foreach ($model->selectedmarketeritems as $key => $value) {
          $this->db->query("insert into ".$this->db->dbprefix('send_group_request_log')." ( marketer_id,group_id,request_status) values ('".$value->Id."','".$model->groupId."','".$model->requeststatus."')");
        }

         echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
   }
    
  public function getgrouprequestlist()
  {
    $this->output->set_content_type('application/json');
      
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        //print_r($model);die;

        if($model->usergroup==2)
        {
           $res=$this->db->select("*,DATE_FORMAT(requested_date,'%d/%m/%Y')as created_date")->where(['request_status'=>'1','marketer_id'=>$model->currentuserid])->get('send_group_request_log'); 
        }else{
           $res=$this->db->select("*,DATE_FORMAT(requested_date,'%d/%m/%Y')as created_date")->where(['request_status'=>'1'])->get('send_group_request_log'); 
        }

      
       $result=[];
       $response=[];
        if(count($res->result_array())>0)
        {   
            foreach($res->result_array() as $key=>$value)
              { 

                $res11=$this->db->query("select * from ".$this->db->dbprefix('group_master')." where id='".$value['group_id']."' ");
                $in_array11=$res11->result_array();
                $status= ($value['request_status']==1)?'Pending':'Rejected';
                $result[]=array('id'=>$value['id'],'group_id'=>$in_array11[0]['id'],'group_name'=>$in_array11[0]['group_name'],'created_date'=>$value['created_date'],'status'=>$status);
              }
        }
        echo json_encode($result,JSON_UNESCAPED_SLASHES);
        die();


  }
 public function updategrouprequest()
  {
     $this->output->set_content_type('application/json');
      
       

        $model = json_decode($this->input->post('model',FALSE));


        $mem_group_sql=$this->db->query("select * from ".$this->db->dbprefix('group_members')." where group_id='".$model->group_id."' AND user_id='".$model->created_by."'");
             $mem_group_array=$mem_group_sql->result_array(); 

             if(count($mem_group_array)>0)
             {
              $result=$this->db->query("update ".$this->db->dbprefix('send_group_request_log')." set request_status='".$model->request_status."' where id='".$model->id."'");        
              
              $this->db->query("update ".$this->db->dbprefix('group_members')." set is_deleted=0 where group_id='".$model->group_id."' AND user_id='".$model->created_by."'");

               $response=array('status'=>"success");
             }else{
               $result=$this->db->query("update ".$this->db->dbprefix('send_group_request_log')." set request_status='".$model->request_status."' where id='".$model->id."'");        
        
                $this->db->query("insert into ".$this->db->dbprefix('group_members')." ( group_id,user_id,created_by) values ('".$model->group_id."','".$model->created_by."','".$model->created_by."')");

                 $response=array('status'=>"success");

             }

       
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
  }
  public function rejectgrouprequest($id)
  {
     $subscriber_delete=$this->db->query("DELETE FROM send_group_request_log where id='".$id."' "); 

      $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        //$response['message']="Subscribers deleted successfully";
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
  }

  
  public function chatprofilesave()
  {
    $this->output->set_content_type('application/json');

    $model = json_decode($this->input->post('model',FALSE));
    if($model->currentUserID){
      $this->db->query("update ".$this->db->dbprefix('affiliateuser')." set aliasname='".$model->aliasname."' , pimage='".$model->pimage."' where Id='".$model->currentUserID."'");
      // print_r($model->profilewebsitelists);
      foreach ($model->profilewebsitelists as $key => $value) {
        
        $this->db->query("update ".$this->db->dbprefix('user_vs_packages')." set chat_active_flag=1 where user_id='".$model->currentUserID."' AND website='".$value."'");
        
      }
      
    }
    $response=array('status'=>"success");
    echo json_encode($response,JSON_UNESCAPED_SLASHES);
    die();

  }

  public function chatwebsiteflag()
  {
    $this->output->set_content_type('application/json');
    $response=array();
    $response['status']="success";
    $model = json_decode($this->input->post('model',FALSE));
    if($model->userid){
      $res=$this->db->query("select * from ".$this->db->dbprefix('user_vs_packages')." where website!='' AND user_id='".$model->userid."' AND chat_active_flag=1 ");
      if($res->num_rows()>0){
        $response['result']=$res->result_array();
      }else{
        $response['result']=[];
      }

      $res1=$this->db->query("select * from ".$this->db->dbprefix('affiliateuser')." where Id='".$model->userid."'")->result_array();
      $response['websitelock']=$res1[0]['username'];
      $response['pimage']=$res1[0]['pimage'];
      if($res1[0]['aliasname']!=''){
        $response['username']=$res1[0]['aliasname'];
      }else{
        $response['username']=$res1[0]['username'];
      }

    }
    
    echo json_encode($response,JSON_UNESCAPED_SLASHES);
    die();

  }
  
}
