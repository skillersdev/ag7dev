<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Floor_controller extends CI_Controller {

	public function index() {
		$this->output->set_content_type('application/json');
		die(json_encode(array('status'=>"failure", 'error'=>'UN-Authorized access'), JSON_UNESCAPED_SLASHES));
	}

   public function add_floor(){
       $this->output->set_content_type('application/json');
      
       

        $model = json_decode($this->input->post('model',FALSE));
        $tableIsexist = 0;
        $res2=$this->db->select("username")->where(['is_deleted'=>'0','username'=>$model->username])->get('floor_master');

        if(count($res2->result_array())>0){
           $response['exist']=1;
           $response['status']="Error";
           $response['message']="Floor user already existed";
           echo json_encode($response,JSON_UNESCAPED_SLASHES);
            die();
        }

        /*Check user is existed or not*/
        if($model->Trasnferusername){


          /*Check Pay via type
            --Enterprenur value as 1
            --Floor user as 2
          */
            if(isset($model->paythrough)){
              if($model->paythrough==1){
                $res=$this->db->select("username,floor_amount,id")->where(['is_deleted'=>'0','username'=>$model->Trasnferusername,'password'=>$model->Trasnferpassword])->get('affiliateuser');
              }else{
                  $res=$this->db->select("username,floor_amount,id")->where(['is_deleted'=>'0','username'=>$model->Trasnferusername,'password'=>$model->Trasnferpassword])->get('floor_master');
                  $tableIsexist = 1;
              }
            }
        }

         /*User exist*/
        if(count($res->result_array())>0){

          $userDetails = $res->result_array();
          /*Updation on Floor master table*/ 
            if($tableIsexist==1){ 
              if($model->package>$userDetails[0]['floor_amount']) {
                 $response['exist']=1;
                 $response['status']="Error";
                  $response['message']="User have Insufficient floor ME";
                   echo json_encode($response,JSON_UNESCAPED_SLASHES);
                    die();
              } else{
                
                 $balanceamt = $userDetails[0]['floor_amount'] - $model->package; 
                  $data=array('floor_amount'=>$balanceamt);
                  $this->db->where('id',$userDetails[0]['id']);
                  $this->db->update($this->db->dbprefix('mall_master'),$data);
                 
              } 
            }
              /*Updation on affilate master table*/ 
            else{
              
               if($model->package>$userDetails[0]['floor_amount']) {
                 $response['exist']=1;
                 $response['status']="Error";
                 $response['message']="User have Insufficient Floor ME";
                  echo json_encode($response,JSON_UNESCAPED_SLASHES);
                  die();
              } else{
                 $balanceamt = $userDetails[0]['floor_amount'] - $model->package; 
                  $data=array('floor_amount'=>$balanceamt);
                  $this->db->where('id',$userDetails[0]['id']);
                  $this->db->update($this->db->dbprefix('affiliateuser'),$data);
                 
              } 
            }
        }
        else{
           $response['exist']=1;
           $response['status']="Error";
           $response['message']="User name doesnot exists";
            echo json_encode($response,JSON_UNESCAPED_SLASHES);
          die();
        }
        /*Check validaity of package*/
         $val_res=$this->db->select("validity,DATE_FORMAT(cdate,'%Y-%m-%d')as cdate")->where('is_deleted','0')->where('id',$model->package_id)->get('packages');
         /***/
         $pckId = $model->package_id;
         
        unset($model->package);unset($model->package_id);unset($model->paythrough);
        unset($model->Trasnferusername);unset($model->Trasnferpassword);unset($model->paythrough);

        $this->db->insert('floor_master', $model);     

        $floor_id = $this->db->insert_id();

        $current_date=date("Y-m-d H:i:s");
              
          /*Check validaity of package*/              

           if(count($val_res->result_array())>0){
              $detls = $val_res->result_array() ; 
              $renew_date = date('Y-m-d', strtotime($detls[0]['validity']."days", strtotime($current_date)));  
           }else{
            /*by default*/
             $renew_date = date('Y-m-d', strtotime("10 days", strtotime($current_date))); 
           }

         /*End*/
               
        $this->db->query("insert into ".$this->db->dbprefix('user_vs_packages')." (user_id,package_id,package_status,website_type,floor_id,activated_date,renew_date) values ('".$model->created_by."','".$pckId."','0','M','".$floor_id."','". $current_date."','".$renew_date."')");   

        $response=array('status'=>"success",'message'=>"floor Inserted successfully");
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
  
  public function getfloorbyweb()
  {
    $model = json_decode($this->input->post('model',FALSE));

     $res=$this->db->select("*")->where(['is_deleted'=>'0','url'=>$model->url])->get('floor_master'); 
     $result=array();
      if($res->num_rows()>0)
        {
          foreach($res->result_array() as $key=>$value)
          {               
             $user_det=$this->db->select("username")->where(['is_deleted'=>'0','id'=>$value['created_by']])->get('affiliateuser'); 
            $data =$user_det->result_array();

            $value['created_by']=$data[0]['username'];

           // print_r($data[0]['username']);die;
            $result[]=array('id'=>$value['id'],'floor_name'=>$value['floor_name'],
              'created_date'=>$value['created_date'],'created_by'=>$value['created_by']);
          }
        }else{
            $response['status']="failure";
            $response['message']="No floor records found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
  }

  public function getfloorbymallid()
  {
    $model = json_decode($this->input->post('model',FALSE));

   
      $res=$this->db->select("id,floor_name")->where(['is_deleted'=>'0','mall_id'=>$model->mall_id])->get('floor_master');
 
      

     $result=array();
      if($res->num_rows()>0)
        {
          $result= $res->result_array();
        }else{
            $response['status']="failure";
            $response['message']="No floor records found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
  }

  public function getfloorbyid()
  {
    $model = json_decode($this->input->post('model',FALSE));
    $res=$this->db->select("id,floor_name")->where(['is_deleted'=>'0','id'=>$model->floor_id])->get('floor_master');
   
      

     $result=array();
      if($res->num_rows()>0)
        {
          $result= $res->result_array();
        }else{
            $response['status']="failure";
            $response['message']="No floor records found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
  }

public function get_floor_list()
  {
     $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $html="";
        global $api_path;       
        
        $model = json_decode($this->input->post('model',FALSE));
       
        if($model->usergroup==1){
          $res=$this->db->select("*,DATE_FORMAT(created_date,'%d/%m/%Y')as created_date")->where('is_deleted','0')->get('floor_master');
        }else{
         
          if($model->mall_id!=null){

            $mall_det=$this->db->select("id,mall_name")->where(['is_deleted'=>'0','mall_name'=>$model->mall_id])->get('mall_master'); 
            $mall_data =$mall_det->result_array(); 


            $res=$this->db->select("*,DATE_FORMAT(created_date,'%d/%m/%Y')as created_date")->where(['is_deleted'=>'0','mall_id'=>$mall_data[0]['id']])->get('floor_master');
          }
          else{
            $res=$this->db->select("*,DATE_FORMAT(created_date,'%d/%m/%Y')as created_date")->where(['is_deleted'=>'0','owner_id'=>$model->created_by])->get('floor_master');
          }


        }


        if($res->num_rows()>0)
        {
          foreach($res->result_array() as $key=>$value)
          {               
            // $user_det=$this->db->select("username")->where(['is_deleted'=>'0','id'=>$value['created_by']])->get('affiliateuser'); 
            // $data =$user_det->result_array();  

            // $value['created_by']=$data[0]['username'];
            
            $mall_det=$this->db->select("mall_name")->where(['is_deleted'=>'0','id'=>$value['mall_id']])->get('mall_master'); 
            $mall_data =$mall_det->result_array();  

            $value['mall_name']=$mall_data[0]['mall_name'];

            $result[]=array('id'=>$value['id'],'floor_name'=>$value['floor_name'],'image_name'=>$value['image_name'],'mall_name'=>$value['mall_name'],'floor_code'=>$value['floor_code'],
              'created_date'=>$value['created_date'],'created_by'=>$value['created_by']);
          }
        }else{
            $response['status']="failure";
            $response['message']="No User records found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    

  }

  public function get_admin_floor_list()
  {
     $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $html="";
        global $api_path;       
        
        $model = json_decode($this->input->post('model',FALSE));
       
        if($model->usergroup==1){
          $res=$this->db->select("*,DATE_FORMAT(created_date,'%d/%m/%Y')as created_date")->where('is_deleted','0')->get('floor_master');
        }else{
         
          if(isset($model->mall_id)){
            $res=$this->db->select("*,DATE_FORMAT(created_date,'%d/%m/%Y')as created_date")->where(['is_deleted'=>'0','mall_id'=>$model->mall_id])->get('floor_master');
          }
          else{
            $res=$this->db->select("*,DATE_FORMAT(created_date,'%d/%m/%Y')as created_date")->where(['is_deleted'=>'0','owner_id'=>$model->created_by])->get('floor_master');
          }


        }
        
        $pack_price=$pack_id=$renewal_date='';
        if($res->num_rows()>0)
        {
          foreach($res->result_array() as $key=>$value)
          {               
            $user_det=$this->db->select("username")->where(['is_deleted'=>'0','id'=>$value['created_by']])->get('affiliateuser'); 
            $data =$user_det->result_array();  

            // $value['created_by']=$data[0]['username'];
            $value['created_by']=(count($data)>0)?$data[0]['username']:''; 
            $user_vs_pck_det=$this->db->select("package_status,renew_date,package_id")->where(['floor_id'=>$value['id']])->get('user_vs_packages'); 
            $user_vs_pck_data =$user_vs_pck_det->result_array();
            
             $package_status=''; 
            if(count($user_vs_pck_data)>0){
               $package_status=$user_vs_pck_data[0]['package_status']=='1'?'Inactivate':($user_vs_pck_data[0]['package_status']=='0'?'Active':'Expired');

               $pck_res=$this->db->select("price,id")->where('is_deleted','0')->where('id',$user_vs_pck_data[0]['package_id'])->get('packages');
               $pck_res_data =$pck_res->result_array();
               
               $pack_price = $pck_res_data[0]['price'];
               $pack_id = $pck_res_data[0]['id'];

                 if($user_vs_pck_data[0]['package_status']=='0' || $user_vs_pck_data[0]['package_status']=='2')
                {
                      
                  $today=date("Y-m-d h:i:s");
                  $pck_end_date_time = strtotime($user_vs_pck_data[0]['renew_date']);
                  $current_time = strtotime($today);

                  if($current_time>$pck_end_date_time)
                  {
                    $package_status='Renewal';
                    /*Update status as inactive*/
                     $data=array('package_status'=>2);
                      $this->db->where('mall_id',$value['id']);
                      $this->db->update($this->db->dbprefix('user_vs_packages'),$data);

                  }

                
                }
                $renewal_date = $user_vs_pck_data[0]['renew_date'];
            }





            
            $mall_det=$this->db->select("mall_name")->where(['is_deleted'=>'0','id'=>$value['mall_id']])->get('mall_master'); 
            $mall_data =$mall_det->result_array();  

            $value['mall_name']=$mall_data[0]['mall_name'];

            $result[]=array('id'=>$value['id'],'floor_name'=>$value['floor_name'],'image_name'=>$value['image_name'],'mall_name'=>$value['mall_name'],
              'created_date'=>$value['created_date'],'created_by'=>$value['created_by'],'pck_status'=>$package_status,'pack_price'=> $pack_price,'pack_id'=>$pack_id,'expiry_date'=>$renewal_date);
          }
        }else{
            $response['status']="failure";
            $response['message']="No User records found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    

  }
  
   public function editfloor($id)
    {
        //var_dump($id); die();
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();

            $res=$this->db->query("select * from ".$this->db->dbprefix('floor_master')." where id='".$id."'");

            if($res->num_rows()>0){
                //$in_array=$res->result_array();
                foreach($res->result_array() as $key=>$value)
                {              
                  
                  $mall_det=$this->db->select("id,mall_name")->where(['is_deleted'=>'0','id'=>$value['mall_id']])->get('mall_master'); 
                  $mall_data =$mall_det->result_array(); 
                
                  
                  $result[]=array('id'=>$value['id'],'floor_name'=>$value['floor_name'],'floor_amount'=>$value['floor_amount'],'floor_amount_renewal'=>$value['floor_amount_renewal'],'floor_code'=>$value['floor_code'],'floor_code'=>$value['floor_code'],'image_name'=>$value['image_name'],'is_deleted'=>$value['is_deleted'],'mall_id'=>$value['mall_id'],'owner_id'=>$value['owner_id'],
                    'password'=>$value['password'],'usergroup'=>$value['usergroup'],'username'=>$value['username'],
                    'created_date'=>$value['created_date'],'created_by'=>$value['created_by'],'mall_name'=>$mall_data[0]['mall_name']);
                }

               // echo $in_array[0]['mall_id'];die;
               // $result=$in_array[0];
            }else{
                $response['status']="failure";
                $response['message']=" No Package record found!!";
            }
            $response['result']=$result;

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
  public function updatefloor() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        if (isset($model)) {
              
           $result=$this->db->query("update ".$this->db->dbprefix('floor_master')." set  floor_name='".$model->floor_name."',image_name='".$model->image_name."',mall_id='".$model->mall_id."',username='".$model->username."',password='".$model->password."',created_date='".$model->created_date."' where id='".$model->id."'");
           
          $response['message']="floor has been updated successfully";          

        } else {
            $response['status']="failure";
            $response['message']="Error while on update floor";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }
    public function deletefloor($id)
    {
      $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        

        $res_chk=$this->db->query("select id from ".$this->db->dbprefix('floor_master')." where id='".$id."' ");
        //print_r($res_chk);die;
        if($res_chk->num_rows()>0){

            $data=array('is_deleted'=>'1');
            $this->db->where('id',$id);
            $this->db->update($this->db->dbprefix('floor_master'),$data);

            $response['status']="success";
            $response['message']="floor record has been deleted successfully";
            
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";    
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    }

 
  public function fetchfloorbyid($id)
  {
      $res=$this->db->select("*")->where(['is_deleted'=>'0','created_by'=>$id])->get('floor_master'); 
      $result=array();
      if($res->num_rows()>0)
        {
          foreach($res->result_array() as $key=>$value)
          {               
            
            $user_det=$this->db->select("username")->where(['is_deleted'=>'0','id'=>$value['created_by']])->get('affiliateuser'); 
            $data =$user_det->result_array();

            $value['created_by']=$data[0]['username'];
            
            $result[]=array('id'=>$value['id'],'floor_name'=>$value['floor_name'],
              'created_date'=>$value['created_date'],'created_by'=>$value['created_by']);
          }
        }else{
            $response['status']="failure";
            $response['message']="No floor records found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
  }
  
   public function getFloordetails($mallId){


      $res=$this->db->select("*,DATE_FORMAT(created_date,'%d/%m/%Y')as created_date")->where(['is_deleted'=>'0','mall_id'=>$mallId])->get('floor_master');
     $result=array();
     $floorname='';
     if(count($res->result_array())>0){
      $tot_cnt = (count($res->result_array()) - 1)+1;
      $a = "Floor ";
      $floorLabel = "F";
      $floorcode = $floorLabel . $tot_cnt;
      $b = $a . $tot_cnt;
      $result['floorname']=$b;
      $result['floorcode']=$floorcode;
      
     }else{
      $result['floorname']='Ground Floor';
      $result['floorcode']='gf';
     }

      $response['result']=$result;
       echo json_encode($response,JSON_UNESCAPED_SLASHES);
       die();

   }

}
