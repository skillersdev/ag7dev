<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mall_controller extends CI_Controller {

  public function index() {
    $this->output->set_content_type('application/json');
    die(json_encode(array('status'=>"failure", 'error'=>'UN-Authorized access'), JSON_UNESCAPED_SLASHES));
  }

   public function add_mall(){
       $this->output->set_content_type('application/json');
      
        $response=array('status'=>"success",'message'=>"mall Inserted successfully");
        $tableIsexist = 0;
        $model = json_decode($this->input->post('model',FALSE));

        $res1=$this->db->select("mall_name")->where(['is_deleted'=>'0','mall_name'=>$model->mall_name])->get('mall_master');

        if(count($res1->result_array())>0){
           $response['exist']=1;
           $response['status']="Error";
           $response['message']="Mall already existed";
           echo json_encode($response,JSON_UNESCAPED_SLASHES);
            die();
        }

         $res2=$this->db->select("username")->where(['is_deleted'=>'0','username'=>$model->username])->get('mall_master');

        if(count($res2->result_array())>0){
           $response['exist']=1;
           $response['status']="Error";
           $response['message']="Mall user already existed";
           echo json_encode($response,JSON_UNESCAPED_SLASHES);
            die();
        }
        /*Check user is existed or not*/
        if($model->Trasnferusername){


          /*Check Pay via type
            --Enterprenur value as 1
            --Mall user as 2
            --no pay through selected by default set as affilate user
          */
            if(isset($model->paythrough)){
              if($model->paythrough==1){
                $res=$this->db->select("username,mall_amount,id")->where(['is_deleted'=>'0','username'=>$model->Trasnferusername,'password'=>$model->Trasnferpassword])->get('affiliateuser');
              }else{
                  $res=$this->db->select("username,mall_amount,id")->where(['is_deleted'=>'0','username'=>$model->Trasnferusername,'password'=>$model->Trasnferpassword])->get('mall_master');
                  $tableIsexist = 1;
              }
            }
        }

        /*User exist*/
        if(count($res->result_array())>0){
         
            $userDetails = $res->result_array();
             
           /*Updation on mall master table*/ 
            if($tableIsexist==1){ 
              if($model->package>$userDetails[0]['mall_amount']) {
                 $response['exist']=1;
                 $response['status']="Error";
                  $response['message']="User have Insufficient mall ME";
                   echo json_encode($response,JSON_UNESCAPED_SLASHES);
                    die();
              } else{
                
                 $balanceamt = $userDetails[0]['mall_amount'] - $model->package; 
                  $data=array('mall_amount'=>$balanceamt);
                  $this->db->where('id',$userDetails[0]['id']);
                  $this->db->update($this->db->dbprefix('mall_master'),$data);
                 
              } 
            }
            /*Updation on affilate master table*/ 
            else{
              
               if($model->package>$userDetails[0]['mall_amount']) {
                 $response['exist']=1;
                 $response['status']="Error";
                 $response['message']="User have Insufficient mall ME";
                  echo json_encode($response,JSON_UNESCAPED_SLASHES);
                  die();
              } else{
                 $balanceamt = $userDetails[0]['mall_amount'] - $model->package; 
                  $data=array('mall_amount'=>$balanceamt);
                  $this->db->where('id',$userDetails[0]['id']);
                  $this->db->update($this->db->dbprefix('affiliateuser'),$data);
                 
              } 
            }
            /*Mall has been created*/
              $mallData=new stdClass;

              $mallData->mall_name = $model->mall_name;
              $mallData->created_by = $model->created_by;
              $mallData->image_name = $model->image_name;
              $mallData->username = $model->username;
              $mallData->password = $model->password;
              $mallData->usergroup = $model->usergroup;
              $mallData->country = $model->country;
              $mallData->state = $model->state;
              $mallData->city = $model->city;   
              $mallData->address = $model->address;         
              
              $this->db->insert('mall_master', $mallData);

              $mall_id = $this->db->insert_id();
              $current_date=date("Y-m-d H:i:s");
              
              /*Check validaity of package*/
                $val_res=$this->db->select("validity,DATE_FORMAT(cdate,'%Y-%m-%d')as cdate")->where('is_deleted','0')->where('id',$model->package_id)->get('packages');

                 if(count($val_res->result_array())>0){
                    $detls = $val_res->result_array() ; 
                    $renew_date = date('Y-m-d', strtotime($detls[0]['validity']."days", strtotime($current_date)));  
                 }else{
                  $renew_date = date('Y-m-d', strtotime("10 days", strtotime($current_date))); 
                 }
               /*End*/

              $this->db->query("insert into ".$this->db->dbprefix('user_vs_packages')." (user_id,package_id,package_status,website_type,mall_id,activated_date,renew_date) values ('".$model->created_by."','".$model->package_id."','0','M','".$mall_id."','". $current_date."','".$renew_date."')");

               $response['exist']=2;
                $response['status']="Success";
               $response['message']="Mall has been created";
            /**End**/

        }else{
           $response['exist']=1;
           $response['status']="Error";
           $response['message']="Enter valid user credentials";
        }

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
  
  public function getmallbyweb()
  {
    $model = json_decode($this->input->post('model',FALSE));

     $res=$this->db->select("*")->where(['is_deleted'=>'0','url'=>$model->url])->get('mall_master'); 
     $result=array();
      if($res->num_rows()>0)
        {
          foreach($res->result_array() as $key=>$value)
          {               
          //    $user_det=$this->db->select("username")->where(['is_deleted'=>'0','id'=>$value['created_by']])->get('affiliateuser'); 
          //   $data =$user_det->result_array();

          //   $value['created_by']=$data[0]['username'];

          //  print_r($data[0]['username']);die;
            $result[]=array('id'=>$value['id'],'mall_name'=>$value['mall_name'],
              'created_date'=>$value['created_date'],'created_by'=>$value['created_by']);
          }
        }else{
            $response['status']="failure";
            $response['message']="No mall records found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
  }
  public function get_mall_list()
  {
     $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $html="";
        global $api_path;        

        
        $model = json_decode($this->input->post('model',FALSE));
        
        if($model->usergroup==1){
          $res=$this->db->select("*,DATE_FORMAT(created_date,'%d/%m/%Y')as created_date")->where('is_deleted','0')->get('mall_master');
        }else{

          if($model->created_by!=null){
            $this->db->select("*,DATE_FORMAT(created_date,'%d/%m/%Y')as created_date")->where(['is_deleted'=>'0','created_by'=>$model->created_by]);
            if(isset($model->username)){
              $this->db->or_where("username",$model->username);
            }
             if(isset($model->mall_id)){
              $this->db->or_where("id",$model->mall_id);
            }         

            $res=$this->db->get('mall_master');
            
          }
          else{
            $res=$this->db->select("*,DATE_FORMAT(created_date,'%d/%m/%Y')as created_date")->where(['is_deleted'=>'0','username'=>$model->username])->get('mall_master');
          }
          
         // print_r($this->db->last_query());die;
        }        

         
         $pack_price=$pack_id=$renewal_date='';
        if($res->num_rows()>0)
        {
          foreach($res->result_array() as $key=>$value)
          {               
            $user_det=$this->db->select("username")->where(['is_deleted'=>'0','id'=>$value['created_by']])->get('affiliateuser'); 
            $data =$user_det->result_array();  

            $value['created_by']=(count($data)>0)?$data[0]['username']:''; 

            $user_vs_pck_det=$this->db->select("package_status,renew_date,package_id,renew_date")->where(['mall_id'=>$value['id']])->get('user_vs_packages'); 
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

            $result[]=array('id'=>$value['id'],'mall_name'=>$value['mall_name'],
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
  public function getmalllist()
  {
     $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $html="";
        global $api_path;        

        // $model = json_decode($this->input->post('model',FALSE));
        // print_r($model);
        $res=$this->db->select("*,DATE_FORMAT(created_date,'%d/%m/%Y')as created_date")->where('is_deleted','0')->order_by('rand()')->get('mall_master');     
        $shop=array();


        if($res->num_rows()>0)
        {
          foreach($res->result_array() as $key=>$value)
          {               
            $user_det=$this->db->select("username")->where(['is_deleted'=>'0','id'=>$value['created_by']])->get('affiliateuser'); 
            $data =$user_det->result_array();  
            if(count($data)>0)
            $value['created_by']=$data[0]['username']; 

            $shop_det=$this->db->select("shop_name")->where(['is_deleted'=>'0','mall_id'=>$value['id']])->get('shop_master'); 
            $shop[$value['id']] =$shop_det->result_array();  

            $result[]=array('id'=>$value['id'],'mall_name'=>$value['mall_name'],
              'created_date'=>$value['created_date'],'image_name'=>$value['image_name']);
          }
        }else{
            $response['status']="failure";
            $response['message']="No User records found..";
        }
        $response['result']=$result;
        $response['shop']=$shop;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    

  }

  public function getmallshoplist()
  {
    $this->output->set_content_type('application/json');
    $response=array();
    $response['status']="success";
    $result=array();

    $model = json_decode($this->input->post('model',FALSE));
    $mallDetails = array();
    $mall_det=$this->db->select("id,mall_name,image_name,usergroup,created_by,country,state,city,address")->where(['is_deleted'=>'0','mall_name'=>$model->mallid])->get('mall_master');

      if(count($mall_det->result_array())>0){ 

        foreach($mall_det->result_array() as $key=>$value)
        {
          
          $country_det=$this->db->select("name")->where(['id'=>$value['country']])->get('countries')->result_array();


          $mallDetails['country'] = $country_det[0]['name'];

          $state_det=$this->db->select("name")->where(['id'=>$value['state']])->get('states')->result_array();
          $mallDetails['state'] = $state_det[0]['name'];

          $city_det=$this->db->select("name")->where(['id'=>$value['city']])->get('cities')->result_array();
          $mallDetails['city'] = $city_det[0]['name'];

          $mallDetails['id'] = $value['id'];
          $mallDetails['mall_name'] = $value['mall_name'];
          $mallDetails['usergroup'] = $value['usergroup'];
          $mallDetails['created_by'] = $value['created_by'];
          $mallDetails['address'] = $value['address'];
           $mallDetails['image_name'] = $value['image_name'];
          
        }
      }

    $result["mall_det"]=$mallDetails;

    // echo "<pre>";print_r($result["mall_det"]);die;


    $floor_det=$this->db->select("id,floor_name,mall_id")->where(['is_deleted'=>'0','mall_id'=>$result["mall_det"]['id']])->get('floor_master');
    if($floor_det->num_rows()>0){

      foreach($floor_det->result_array() as $key=>$value)
      {
        //$result[$key]=array("floorData"=>$value);
        $shop_det=$this->db->select("shop_name,mall_id,floor_id,logo,banner,usergroup")->where(['is_deleted'=>'0','mall_id'=>$result["mall_det"]['id'],'floor_id'=>$value['id'] ])->get('shop_master');
        if($shop_det->num_rows()>0){
          // print_r($shop_det->result_array());
          // print_r($value);
          $shopData=array();
          foreach($shop_det->result_array() as $key2=>$value2)
          {
            array_push($shopData,$value2);
          }
          $result[]=array("floorData"=>$value,"shopList"=>$shopData);
         

        }else{
          $result[]=array("floorData"=>$value,"shopList"=>[]);
          
        }
      }
      // echo "<pre>";
      // print_r($result);
      
      $response['result']=$result;
       echo json_encode($response,JSON_UNESCAPED_SLASHES);
       die();
      

    }
   

    
  }
  
   public function editmall($id)
    {
        //var_dump($id); die();
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();

            $res=$this->db->query("select * from ".$this->db->dbprefix('mall_master')." where id='".$id."'");

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
    
  public function useridbymallid() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        if (isset($model)) {
          $res=$this->db->query("select created_by from ".$this->db->dbprefix('mall_master')." where id='".$model->mall_id."'");

          if($res->num_rows()>0){
              $in_array=$res->result_array();
              $response['created_by']=$in_array[0];
          }       

        } 

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }
    public function updatemall() {
      $this->output->set_content_type('application/json');
      $response=array('status'=>"success");

      $model = json_decode($this->input->post('model',FALSE));

      if (isset($model)) {
            
         $result=$this->db->query("update ".$this->db->dbprefix('mall_master')." set  country='".$model->country."',state='".$model->state."',city='".$model->city."',address='".$model->address."',image_name='".$model->image_name."' where id='".$model->id."'");
         
        $response['message']="mall has been updated successfully";          

      } else {
          $response['status']="failure";
          $response['message']="Error while on update mall";
      }

      die(json_encode($response, JSON_UNESCAPED_SLASHES));
  }
    public function deletemall($id)
    {
      $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        

        $res_chk=$this->db->query("select id from ".$this->db->dbprefix('mall_master')." where id='".$id."' ");
        //print_r($res_chk);die;
        if($res_chk->num_rows()>0){

            $data=array('is_deleted'=>'1');
            $this->db->where('id',$id);
            $this->db->update($this->db->dbprefix('mall_master'),$data);

            $response['status']="success";
            $response['message']="mall record has been deleted successfully";
            
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";    
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    }

 
  public function fetchmallbyid($id)
  {
      $res=$this->db->select("*")->where(['is_deleted'=>'0','created_by'=>$id])->get('mall_master'); 
      $result=array();
      if($res->num_rows()>0)
        {
          foreach($res->result_array() as $key=>$value)
          {               
            
            $user_det=$this->db->select("username")->where(['is_deleted'=>'0','id'=>$value['created_by']])->get('affiliateuser'); 
            $data =$user_det->result_array();

            $value['created_by']=$data[0]['username'];
            
            $result[]=array('id'=>$value['id'],'mall_name'=>$value['mall_name'],
              'created_date'=>$value['created_date'],'created_by'=>$value['created_by']);
          }
        }else{
            $response['status']="failure";
            $response['message']="No mall records found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
  }
  

}
