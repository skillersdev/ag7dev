<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_controller extends CI_Controller {

    public function index() {
        $this->output->set_content_type('application/json');
        die(json_encode(array('status'=>"failure", 'error'=>'UN-Authorized access'), JSON_UNESCAPED_SLASHES));
    }

   public function add_user_master(){
      $this->output->set_content_type('application/json');
        
        $model = json_decode($this->input->post('model',FALSE));

       // print_r($model);die;

        date_default_timezone_set('Asia/Kolkata');
        
        $model->doj = date("Y-m-d H:i:s");

        unset($model->cpassword);
        $check_exists=$this->db->select("*")->where(['is_deleted'=>'0','username'=>$model->referedby])->get('affiliateuser');  
        if($check_exists->num_rows()==0)
        {
            $response=array('status'=>"fail");
            $response['message']="Enter a valid creator name";

        }else{
            $response=array('status'=>"success");
            $response['message']="User inserted successfully";
            $this->db->insert('affiliateuser', $model);

             $last_insert_id = $this->db->insert_id();

        /*Create a chat group for the corressponding user*/
            $group_image = 'default-profile.png';

            for ($i=1; $i<=2; $i++) 
            { 

                $length=10;
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($j = 0; $j < $length; $j++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }

                $this->db->query("insert into ".$this->db->dbprefix('group_master')." 
                (group_name,channelgroup,imagename,private_public,group_code,created_by,created_date,is_deleted) values('".$model->username."','".$i."','".$group_image."',4,'".$randomString."','".$last_insert_id."','". $model->doj."',0)");
                $group_id = $this->db->insert_id();

                if($i==2)
                {
                    $this->db->query("insert into ".$this->db->dbprefix('group_master')." 
                    (group_name,channelgroup,imagename,private_public,group_code,created_by,created_date,is_deleted) values('".$model->username."',2,'".$group_image."',3,'".$randomString."','".$last_insert_id."','". $model->doj."',0)");
                    $group_id_1 = $this->db->insert_id();
                }

                $this->db->query("insert into ".$this->db->dbprefix('group_members')." 
                (group_id,group_name,user_id,user_name,created_by,created_date,is_deleted) values('".$group_id."','".$model->username."','".$last_insert_id."','".$model->username."','".$last_insert_id."','". $model->doj."',0)");
             }

        /*End*/


            if(isset($model->user_type)&&($model->user_type==2))
            {
              $last_inserted_user_id = $this->db->insert_id();
              $package_id =isset($model->pcktaken)?$model->pcktaken:0;
              $this->db->query("insert into ".$this->db->dbprefix('user_vs_packages')." (user_id,package_id,website) values('".$last_insert_id."','".$package_id."','".$model->website."')");
            }

        }
        
       


        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
    public function updategroupandchatforolduser()
    {
        /***Get Group Members Id by distinct***/
        $get_group_members=$this->db->query("select DISTINCT(user_id) as userId from ".$this->db->dbprefix('group_members')." where user_id !=0 AND is_deleted=0");
          
         $group_user_ids = $get_group_members->result_array();

         foreach ($group_user_ids as $key => $value) {
             $ids[] = $value['userId'];
         }
         
       // echo "<pre>";print_r(implode(',',$ids));die;
          $ids =implode(',',$ids);
          
          $get_users_not_in_group = $this->db->query("SELECT * FROM affiliateuser WHERE id NOT IN (".$ids.") AND id!=1");
         
          $user_ids = $get_users_not_in_group->result_array();

         
         //echo "<pre>"; print_r($user_ids);die;
         //echo "SELECT * FROM affiliateuser WHERE id NOT IN (".$ids.")";die;
        
         if(count($user_ids)>0)
         {

            foreach ($user_ids as $key => $value) 
            {
                /*Create a chat group for the corressponding user*/
                $group_image = 'default-profile.png';
                $current_date = date("Y-m-d h:i:sa");

                for ($i=1; $i<=2; $i++) 
                { 

                    $length=10;
                    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $charactersLength = strlen($characters);
                    $randomString = '';
                    for ($j = 0; $j < $length; $j++) {
                        $randomString .= $characters[rand(0, $charactersLength - 1)];
                    }

                    $this->db->query("insert into ".$this->db->dbprefix('group_master')." 
                    (group_name,channelgroup,imagename,private_public,group_code,created_by,created_date,is_deleted) values('".$value['username']."','".$i."','".$group_image."',4,'".$randomString."','".$value['Id']."','".$current_date."',0)");
                    $group_id = $this->db->insert_id();

                    if($i==2)
                    {
                        $this->db->query("insert into ".$this->db->dbprefix('group_master')." 
                        (group_name,channelgroup,imagename,private_public,group_code,created_by,created_date,is_deleted) values('".$value['username']."',2,'".$group_image."',3,'".$randomString."','".$value['Id']."','".$current_date."',0)");
                        $group_id_1 = $this->db->insert_id();
                    }

                    $this->db->query("insert into ".$this->db->dbprefix('group_members')." 
                    (group_id,group_name,user_id,user_name,created_by,created_date,is_deleted) values('".$group_id."','".$value['username']."','".$value['Id']."','".$value['username']."','".$value['Id']."','".$current_date."',0)");
                }

                 /*End*/
            }
            $response['message'] = "User has been successfully updated to group";
         }else{
            $response['message'] = "User doesn't exist for updating to group";
         }

           echo json_encode($response,JSON_UNESCAPED_SLASHES);
            die();
    }


    public function add_template_master()
    {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $response['message']="Template inserted successfully";

        $model = json_decode($this->input->post('model',FALSE));
        
        $this->db->insert('template_settings', $model);        


        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }

    public function add_user_ad(){
       $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
         
        $response['message']="Ad inserted successfully";

        $model = json_decode($this->input->post('model',FALSE));

        
        $this->db->insert('user_advertisements', $model);
       

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
    
  
  public function get_users_detail()
  {
     $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $html="";
        global $api_path;        

        $res=$this->db->select("Id,username,password,fname,address,email,referedby,mobile,active,DATE_FORMAT(doj,'%d/%m/%Y')as doj,country,tamount,payment,signupcode,level,pcktaken,launch,getpayment,renew,iba_status,user_type,DATE_FORMAT(expiry,'%d/%m/%Y')as expiry")->where('is_deleted','0')->get('affiliateuser');
        $website_query=$this->db->select("count(*) as total_website")->get('user_vs_packages'); 
        $web_tot_count=$website_query->result_array();
       
        $active_website_query=$this->db->select("count(*) as total_act_website")->where('package_status','0')->get('user_vs_packages'); 
        $active_web_tot_count=$active_website_query->result_array();

        $active_yet_to_query=$this->db->select("count(*) as total_yet_to_act_website")->where('package_status','1')->get('user_vs_packages'); 
        $yet_to_active_web_tot_count=$active_yet_to_query->result_array();

        if($res->num_rows()>0)
        {
          foreach($res->result_array() as $key=>$value)
          {               
            $status=($value['active']=='1')?'Active':'Inactive';
            $result[]=array('Id'=>$value['Id'],'username'=>$value['username'],'password'=>$value['password'],'fname'=>$value['fname'],'address'=>$value['address'],'email'=>$value['email'],'referedby'=>$value['referedby'],'mobile'=>$value['mobile'],'active'=>$status,'doj'=>$value['doj'],'country'=>$value['country'],'tamount'=>$value['tamount'],'payment'=>$value['payment'],'signupcode'=>$value['signupcode'],'level'=>$value['level'],'pcktaken'=>$value['pcktaken'],'launch'=>$value['launch'],'getpayment'=>$value['getpayment'],'renew'=>$value['renew'],'iba_status'=>$value['iba_status'],'user_type'=>$value['user_type'],'created_date'=>$value['expiry'],'status'=>$value['active']);
          }
        }else{
            $response['status']="failure";
            $response['message']="No User records found..";
        }
        $result['total_web_count'] = $web_tot_count[0]['total_website'];
        $result['total_active_web_count'] =$active_web_tot_count[0]['total_act_website'];
        $result['total_yet_to_active'] =$yet_to_active_web_tot_count[0]['total_yet_to_act_website'];
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    

  }
  public function get_chatusers_detail()
  {
     $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $html="";
        global $api_path;        

        // $res=$this->db->select("Id,username")->where('is_deleted','0')->get('affiliateuser');

        $model = json_decode($this->input->post('model',FALSE));    
        $username = trim($model->currentUsername);
        if(isset($model->currentUsername)){
            $res=$this->db->select("*")->where(['is_deleted'=>'0','referedby'=>$username])->get('affiliateuser');    
        }
        
        if($res->num_rows()>0)
        {
          foreach($res->result_array() as $key=>$value)
          {               
            $result[]=array('Id'=>$value['Id'],'username'=>$value['username']);
          }
        }else{
            $response['status']="failure";
            $response['message']="No User records found..";
        }
   
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    

  }
  public function getmarketerslist()
  {
     $model = json_decode($this->input->post('model',FALSE));    
        $username = trim($model->currentUsername);
        if(isset($model->currentUsername)){
            $res=$this->db->select("*")->where(['is_deleted'=>'0','referedby'=>$username])->get('affiliateuser');    
        }
       
       $response=[];

        if(count($res->result_array())>0)
        {
          // $data = $res->result_array();
            $result=[];

             foreach($res->result_array() as $key=>$value)
              { 
                //$value['username']=$data[0]['username']; 

                $result[]=array('username'=>$value['username'],'website'=>$value['website'],
                  'doj'=>$value['doj'],'expiry'=>$value['expiry']);
              }
            //$response['message']="User name already exists";
        }
        echo json_encode($result,JSON_UNESCAPED_SLASHES);
        die();
  }
  public function getallmarketers(){
        $model = json_decode($this->input->post('model',FALSE));    
        $username = trim($model->currentUsername);
        if(isset($model->currentUsername)){
            $res=$this->db->select("*")->where(['is_deleted'=>'0','user_type'=>'2'])->get('affiliateuser');    
        }
       
       $response=[];

        if(count($res->result_array())>0)
        {
          // $data = $res->result_array();
            $result=[];

             foreach($res->result_array() as $key=>$value)
              { 
                //$value['username']=$data[0]['username']; 

                $result[]=array('Id'=>$value['Id'],'username'=>$value['username']);
              }
            //$response['message']="User name already exists";
        }
        echo json_encode($result,JSON_UNESCAPED_SLASHES);
        die(); 
  }
   public function findmarketers()
  {
     $model = json_decode($this->input->post('model',FALSE));    
        // $username = trim($model->currentUsername);
        //if(isset($model->currentUsername)){
            $res=$this->db->select("*")->where(['is_deleted'=>'0','username'=>$model->marketer,'user_type'=>'2'])->get('affiliateuser');    
        //}
       
       $response=[];
        if(count($res->result_array())>0)
        {
            $result=[];
            // $result['status']='success';
            foreach($res->result_array() as $key=>$value)
              { 
                $result[]=array('Id'=>$value['Id'],'username'=>$value['username']);
              }
        }else{
            $result['status']='error';
        }
        echo json_encode($result,JSON_UNESCAPED_SLASHES);
        die(); 
  }
  public function get_template_list()
  {
     
       $res=$this->db->select("*,DATE_FORMAT(created_date,'%d/%m/%Y')as created_date")->where(['is_deleted'=>'0'])->get('template_settings'); 
       $result=[];
       $response=[];
        if(count($res->result_array())>0)
        {
            
            foreach($res->result_array() as $key=>$value)
              { 
                $res11=$this->db->query("select * from ".$this->db->dbprefix('affiliateuser')." where id='".$value['created_by']."' ");
                $in_array11=$res11->result_array();
               // print_r($in_array11);die;
                //$result=$in_array11[0];
                $result[]=array('id'=>$value['id'],'template_name'=>$value['website'],'created_date'=>$value['created_date'],'created_by'=>$in_array11[0]['username']);
              }
        }
        echo json_encode($result,JSON_UNESCAPED_SLASHES);
        die();
  }
  public function deletetemplateslider($id)
    {
      $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        

        $res_chk=$this->db->query("select id from ".$this->db->dbprefix('template_settings')." where id='".$id."' ");
        
        if($res_chk->num_rows()>0){

            $data=array('is_deleted'=>'1');
            $this->db->where('id',$id);
            $this->db->update($this->db->dbprefix('template_settings'),$data);

            $response['status']="success";
            $response['message']="Template has been deleted successfully";
            
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";    
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    }
  public function get_templatelistby_user($id)
  {
    $model = json_decode($this->input->post('model',FALSE));
    $res=$this->db->select("*,DATE_FORMAT(created_date,'%d/%m/%Y')as created_date")->where(['is_deleted'=>'0','created_by'=>$id])->get('template_settings'); 
       $result=[];
       $response=[];
        if(count($res->result_array())>0)
        {
            
            foreach($res->result_array() as $key=>$value)
              { 
                $res11=$this->db->query("select * from ".$this->db->dbprefix('affiliateuser')." where id='".$value['created_by']."'");
                $in_array11=$res11->result_array();

                 $result[]=array('id'=>$value['id'],'template_name'=>$value['website'],'created_date'=>$value['created_date'],'created_by'=>$in_array11[0]['username']);
              }
        }
        echo json_encode($result,JSON_UNESCAPED_SLASHES);
        die();
  }
  public function check_user_exist(){
    $model = json_decode($this->input->post('model',FALSE));
    //print_r($model->username);die;   
    $response['exist']=0;
    $username = trim($model->username);
    if(isset($model->Id)){
        $res=$this->db->select("username")->where(['is_deleted'=>'0','id!='=>$model->Id,'username'=>$username])->get('affiliateuser');    
    }
    else{
        $res=$this->db->select("username")->where(['is_deleted'=>'0','username'=>$username])->get('affiliateuser');
    }
  // print_r($res->result_array());die;
    if(count($res->result_array())>0)
    {
       
        $response['exist']=1;
        $response['message']="User name already exists";
    }
    echo json_encode($response,JSON_UNESCAPED_SLASHES);
    die();
  }

  public function check_user_credit(){
    $model = json_decode($this->input->post('model',FALSE));
    $user_id = trim($model->user_id);
    $share_amount_from_user = $model->share_amt;
    $res=$this->db->select("username,tamount,pcktaken")->where(['is_deleted'=>'0','id'=>$user_id])->get('affiliateuser');    
    

    if(count($res->result_array())>0)
    {
        $data =$res->result_array();  
        $response['total_amount']=$data[0]['tamount'];
        $curret_user_name=$data[0]['username'];

        /*Check Maximum trasnfer*/
        $package_id=$data[0]['pcktaken'];  
        $pack_det=$this->db->select("maximum_transfer")->where(['is_deleted'=>'0','id'=>$package_id])->get('packages');
        if(count($pack_det->result_array())>0)
        { 
            $pck_data =$pack_det->result_array(); 

            $response['maximum_transfer']=$pck_data[0]['maximum_transfer']; 

            $current_user_transfer_det=$this->db->select_sum("amt")->where('transfer_from',$curret_user_name)->get('transfer_history'); 
            $trasnfer_data = $current_user_transfer_det->result_array();

            $total_transfer_amount = ($trasnfer_data[0]['amt']!='')?$trasnfer_data[0]['amt']:0;

            if($total_transfer_amount>=$response['maximum_transfer'])
            {
                $response['status']=1;
                $response['message']="Already Exceeded your maximum transfer";
                echo json_encode($response,JSON_UNESCAPED_SLASHES);
                die();
            }
            else if($share_amount_from_user>$response['maximum_transfer'])
            {
                $response['status']=1;
                $response['message']="Share amount should not greater than maximum transfer amount";
                echo json_encode($response,JSON_UNESCAPED_SLASHES);
                die();
            }
        }

        /**/
    }
    echo json_encode($response,JSON_UNESCAPED_SLASHES);
    die();
  }
  
   public function edituser($id)
    {
        //var_dump($id); die();
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();

            $res=$this->db->query("select * from ".$this->db->dbprefix('affiliateuser')." where id='".$id."'");

            if($res->num_rows()>0){
                $in_array=$res->result_array();
                $result=$in_array[0];
            }else{
                $response['status']="failure";
                $response['message']=" No Package record found!!";
            }
            $response['result']=$result;

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
    public function edittemplate($id)
    {
        //var_dump($id); die();
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();

            $res=$this->db->query("select * from ".$this->db->dbprefix('template_settings')." where id='".$id."'");

            if($res->num_rows()>0){
                $in_array=$res->result_array();
                $result=$in_array[0];
            }else{
                $response['status']="failure";
                $response['message']=" No Package record found!!";
            }
            $response['result']=$result;

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
  public function updateuser() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

       // print_r($model);die();

        if (isset($model)) {
        
            $this->db->where('id',$model->Id);
            $result=$this->db->update('affiliateuser', $model);
          //  pr($this->db->last_query());die();

            if ($result) {
                $response['message']="User has been updated successfully";
            }
            else
            {
                 $response['status']="failure";
            $response['message']="User has not been updated fully";
            }
            

        } else {
            $response['status']="failure";
            $response['message']="Choose User and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }
    public function updatetemp() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $model = json_decode($this->input->post('model',FALSE));
        if (isset($model)) {
            $this->db->where('id',$model->id);
            $result=$this->db->update('template_settings', $model);
            if ($result) {
                $response['message']="Template has been updated successfully";
            }
            else
            {
                 $response['status']="failure";
            $response['message']="Template has not been updated fully";
            }
            

        } else {
            $response['status']="failure";
            $response['message']="Choose Template and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }
      
    public function updateuserprofile()
    {
       $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

       // print_r($model);die();

        if (isset($model)) {
        
            $this->db->where('id',$model->Id);
            $result=$this->db->update('affiliateuser', $model);
          //  pr($this->db->last_query());die();

            if ($result) {
                $response['message']="Profile has been updated successfully";
            }
            else
            {
                $response['status']="failure";
                $response['message']="Profile has not been updated fully";
            }
            

        } else {
            $response['status']="failure";
            $response['message']="Enter valid details and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES)); 
    }
    public function updatepassword()
    {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $model = json_decode($this->input->post('model',FALSE));
        if (isset($model)) {
        
            $this->db->where('id',$model->id);
            $result=$this->db->update('affiliateuser', $model);
            if ($result) {
                $response['message']="Password has been updated successfully";
            }
            else
            {
                $response['status']="failure";
                $response['message']="Password has not been updated fully";
            }
            

        } else {
            $response['status']="failure";
            $response['message']="Enter valid Password and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES)); 
    }
    public function deleteuser($id)
    {
      $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        

        $res_chk=$this->db->query("select id from ".$this->db->dbprefix('affiliateuser')." where id='".$id."' ");
        
        if($res_chk->num_rows()>0){

            $data=array('is_deleted'=>'1');
            $this->db->where('id',$id);
            $this->db->update($this->db->dbprefix('affiliateuser'),$data);

            $response['status']="success";
            $response['message']="User record has been deleted successfully";
            
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";    
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    }
    public function uploadAdvfile()
    {
        $path = 'user_adv_uploads/';
        $Response=[];
       
        if (isset($_FILES['file'])) 
          {
            $originalName = $_FILES['file']['name'];
            
            $image_info = getimagesize($_FILES["file"]["tmp_name"]);
            $image_width = $image_info[0];
            $image_height = $image_info[1];

            // if($image_width<1900 && $image_height<900)
            // {
            //   $Response['status']="fail"; 
            //   $Response['data']="Upload image size should be accurate size";
            //    echo json_encode($Response,JSON_UNESCAPED_SLASHES);
            //   die();
            // }

            //echo $image_width."-------".$image_height;die;
            $ext = '.'.pathinfo($originalName, PATHINFO_EXTENSION);
            //print_r($ext);die;
            $upper_Case_ext=strtoupper($ext);

            //3GPP, AVI, FLV, MOV, MPEG4, MPEGPS, WebM and WMV. MPEG4
            if($upper_Case_ext==".IMG"||$upper_Case_ext==".JPG"||$upper_Case_ext==".JPEG"||$upper_Case_ext==".PNG" ||$upper_Case_ext==".MP4" ||$upper_Case_ext==".AVI" ||$upper_Case_ext==".3GPP" ||$upper_Case_ext==".FLV" ||$upper_Case_ext==".MOV" ||$upper_Case_ext==".MPEG4" ||$upper_Case_ext==".MPEGPS" ||$upper_Case_ext==".WebM" ||$upper_Case_ext==".WMV" ||$upper_Case_ext==".MPEG4")
            {

              $generatedName = md5($_FILES['file']['tmp_name']).$ext;

              $filePath = $path.$generatedName;
              $product_image=$filePath;
           
              if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) 
              {
                $Response['status']="success"; 
                $Response['data']=$product_image;
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
    public function uploadtempfile()
    {
       $path = 'user_adv_uploads/';
        $Response=[];
       
        if (isset($_FILES['file'])) 
          {
            $originalName = $_FILES['file']['name'];
            
            $image_info = getimagesize($_FILES["file"]["tmp_name"]);
            $image_width = $image_info[0];
            $image_height = $image_info[1];
            //echo $image_width."-------".$image_height;die;
            if($image_width<1500 && $image_height<700)
            {
              $Response['status']="fail"; 
              $Response['data']="Upload image size should be above 1500*700 size";
               echo json_encode($Response,JSON_UNESCAPED_SLASHES);
              die();
            }

            //echo $image_width."-------".$image_height;die;
            $ext = '.'.pathinfo($originalName, PATHINFO_EXTENSION);
            //print_r($ext);die;
            $upper_Case_ext=strtoupper($ext);

            //3GPP, AVI, FLV, MOV, MPEG4, MPEGPS, WebM and WMV. MPEG4
            if($upper_Case_ext==".IMG"||$upper_Case_ext==".JPG"||$upper_Case_ext==".JPEG"||$upper_Case_ext==".PNG" ||$upper_Case_ext==".MP4" ||$upper_Case_ext==".AVI" ||$upper_Case_ext==".3GPP" ||$upper_Case_ext==".FLV" ||$upper_Case_ext==".MOV" ||$upper_Case_ext==".MPEG4" ||$upper_Case_ext==".MPEGPS" ||$upper_Case_ext==".WebM" ||$upper_Case_ext==".WMV" ||$upper_Case_ext==".MPEG4")
            {

              $generatedName = md5($_FILES['file']['tmp_name']).$ext;

              $filePath = $path.$generatedName;
              $product_image=$filePath;
           
              if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) 
              {
                $Response['status']="success"; 
                $Response['data']=$product_image;
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
    public function uploadimage()
    {
       $path = 'user_profile/';
        $Response=[];
       
        if (isset($_FILES['file'])) 
          {
            $originalName = $_FILES['file']['name'];
            $ext = '.'.pathinfo($originalName, PATHINFO_EXTENSION);
             
            // if($ext==".img"||$ext==".jpg"||$ext==".jpeg"||$ext==".png")
            // {

              $generatedName = md5($_FILES['file']['tmp_name']).$ext;

              $filePath = $path.$generatedName;
              $product_image=$filePath;
           
              if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) 
              {
                $Response['status']="success"; 
                $Response['data']=$product_image;
              }
            // }
            // else 
            // {
            //     $Response['status']="fail"; 
            //     $Response['data']="Upload only valid format images";
            // }
          }
        else {
            $Response['status']="fail"; 
            $Response['data']="Error While upload on image";
         }
          echo json_encode($Response,JSON_UNESCAPED_SLASHES);
         die();
    }

    public function resetpassword()
    {
        $model = json_decode($this->input->post('model',FALSE));
   
        $response['exist']=0;
        $email = trim($model->email);
   
        $res=$this->db->select("*")->where(['is_deleted'=>'0','email'=>$email])->get('affiliateuser');  
        if(count($res->result_array())>0)
        {
           
            $user_det = $res->result_array();
            $password = $user_det[0]['password'];

            // $config = Array(
            //     'protocol' => 'mail',
            //     'smtp_host' => 'ssl://smtp.googlemail.com',
            //     'smtp_port' => 587,
            //     'smtp_user' => 'my mail',
            //     'smtp_pass' => 'my password',
            //     'smtp_crypto'=>'tls'
            //     'mailtype'  => 'html', 
            //     'wordwrap'  => TRUE;
            //     'charset'   => 'iso-8859-1'
            // );

            // $this->load->library('email',$config);
            // $this->email->from('admin@gmail.com', 'admin');
            // $this->email->to('mr.mani99@gmail.com');
             
            // $this->email->subject('Your Password is:'.$password);
            // $this->email->message('Testing the email class.');
            // if($this->email->send()) 
            // {
            //     $response['exist']=1;
            //     $response['message']="Password sent to your mail id"; 
            // }
            
        
            
            
        }
        else{
             $response['result']=array();
            $response['exist']=0;
            $response['message']="Email id is not an registered";
        }

    echo json_encode($response,JSON_UNESCAPED_SLASHES);
    die();
    }
     public function get_user_ad()
    {
     $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $html="";
        global $api_path;        

        $res=$this->db->select("*,DATE_FORMAT(created_at,'%d/%m/%Y')as created_at")->where('is_deleted','0')->get('user_advertisements');


        if($res->num_rows()>0)
        {
          foreach($res->result_array() as $key=>$value)
          {               
            $user_det=$this->db->select("username")->where(['is_deleted'=>'0','id'=>$value['user_id']])->get('affiliateuser'); 
            $data =$user_det->result_array();  

            $value['user_id']=$data[0]['username']; 

            $result[]=array('id'=>$value['id'],'website'=>$value['url'],
              'created_at'=>$value['created_at'],'created_by'=>$value['user_id'],'ad_image'=>$value['uploads']);
          }
        }else{
            $response['status']="failure";
            $response['message']="No User records found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    

    }
    public function get_ad_by_user($id)
    {
     $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $html="";
        global $api_path;        

        $res=$this->db->select("*,DATE_FORMAT(created_at,'%d/%m/%Y')as created_at")->where(['is_deleted'=>'0','user_id'=>$id])->get('user_advertisements'); 

        


        if($res->num_rows()>0)
        {
          foreach($res->result_array() as $key=>$value)
          {               
            $user_det=$this->db->select("username")->where(['is_deleted'=>'0','id'=>$value['user_id']])->get('affiliateuser'); 
            $data =$user_det->result_array();  

            $value['user_id']=$data[0]['username']; 

            $result[]=array('id'=>$value['id'],'website'=>$value['url'],
              'created_at'=>$value['created_at'],'created_by'=>$value['user_id'],'ad_image'=>$value['uploads']);
          }
        }else{
            $response['status']="failure";
            $response['message']="No User records found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    

    }
    public function editad($id)
    {
        //var_dump($id); die();
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();

            $res=$this->db->query("select * from ".$this->db->dbprefix('user_advertisements')." where id='".$id."'");

            if($res->num_rows()>0){
                $in_array=$res->result_array();
                $result=$in_array[0];
            }else{
                $response['status']="failure";
                $response['message']=" No Package record found!!";
            }
            $response['result']=$result;

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
    public function updatead() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

       // print_r($model);die();

        if (isset($model)) {
        
            $this->db->where('id',$model->id);
            $result=$this->db->update('user_advertisements', $model);
          //  pr($this->db->last_query());die();

            if ($result) {
                $response['message']="Advertisements has been updated successfully";
            }
            else
            {
                 $response['status']="failure";
            $response['message']="Advertisements has not been updated fully";
            }
            

        } else {
            $response['status']="failure";
            $response['message']="Choose Advertisements and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }
     public function deletead($id)
    {
      $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        

        $res_chk=$this->db->query("select id from ".$this->db->dbprefix('user_advertisements')." where id='".$id."' ");
        
        if($res_chk->num_rows()>0){

            $data=array('is_deleted'=>'1');
            $this->db->where('id',$id);
            $this->db->update($this->db->dbprefix('user_advertisements'),$data);

            $response['status']="success";
            $response['message']="Advertisement record has been deleted successfully";
            
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";    
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    }
    public function updateibadetails()
    {
         $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $model = json_decode($this->input->post('model',FALSE));
        

        $res_chk=$this->db->query("select id from ".$this->db->dbprefix('user_advertisements')." where id='".$model->ad_id."' AND is_deleted=0");
        
        if($res_chk->num_rows()>0){

            $data=array('iba_ad'=>'1');
            $this->db->where('id',$model->ad_id);
            $this->db->update($this->db->dbprefix('user_advertisements'),$data);

            $response['status']="success";
            $response['message']="IBA has enabled for this Advertisements";
            
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";    
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    }
    public function reactivatepackage()
    {
      $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $model = json_decode($this->input->post('model',FALSE));    


        $user_res=$this->db->query("select * from ".$this->db->dbprefix('affiliateuser')." where id='".$model->user_id."' ");

        $user_array=$user_res->result_array();

         //$current_date=date("Y-m-d");
            $renew_date = date('Y-m-d', strtotime('+ 93 day',strtotime($user_array[0]['doj'])));

            //print_r($renew_date);die;

        $this->db->query("insert into ".$this->db->dbprefix('user_vs_packages')." (user_id,package_id,package_status,website,template,activated_date,renew_date) values ('".$model->user_id."',1,0,'".$model->website."',1,'".$user_array[0]['doj']."','".$renew_date."')");

         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();


    }
   public function uploadcropimage()
   {
      $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $model = json_decode($this->input->post('model',FALSE));
//print_r($model);die;
        /*Converting base 64 image to image file and upload*/
        if(isset($model->Imagefile))
        {


        $image_parts = explode(";base64,", $model->Imagefile);
        define('UPLOAD_DIR', 'resizeuploads/');
        $img = $model->Imagefile;
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $file = UPLOAD_DIR . uniqid() . '.png';
        $success = file_put_contents($file, $data);
        $result = $success ? $file : 'fail';
        
        if($result!='fail')
        {
            $response['status']="success";
            $response['message']="Image upload successfully";
            $response['data']=$file;
        }
        else{
            $response['status']="failure";
            $response['message']="Error while upload on photos";    
        }}else{
          $response['status']="fail";
          $response['message']="Error while upload on photos";    
      }
       
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
   }
}
