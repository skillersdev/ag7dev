<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shop_controller extends CI_Controller {

	public function index() {
		$this->output->set_content_type('application/json');
		die(json_encode(array('status'=>"failure", 'error'=>'UN-Authorized access'), JSON_UNESCAPED_SLASHES));
	}

   public function add_shop(){
       $this->output->set_content_type('application/json');
      
        $response=array('status'=>"success",'message'=>"shop Inserted successfully");
        $tableIsexist = 0;
        $model = json_decode($this->input->post('model',FALSE));

        $res1=$this->db->select("*")->where(['is_deleted'=>'0','shop_name'=>$model->shop_name])->get('shop_master');

        if(count($res1->result_array())>0){
           $response['exist']=1;
           $response['status']="Error";
           $response['message']="Shop already existed";
           echo json_encode($response,JSON_UNESCAPED_SLASHES);
            die();
        }

        $res2=$this->db->select("*")->where(['is_deleted'=>'0','username'=>$model->username])->get('shop_master');
        if(count($res2->result_array())>0){
           $response['exist']=1;
           $response['status']="Error";
           $response['message']="Shop user already existed";
           echo json_encode($response,JSON_UNESCAPED_SLASHES);
            die();
        }

        /*Check user is existed or not*/
        if($model->Trasnferusername){


          /*Check Pay via type
            --Enterprenur value as 1
            --Shop user as 2
            --no pay through selected by default set as affilate user
          */
            if(isset($model->paythrough)){
              if($model->paythrough==1){
                $res=$this->db->select("username,shop_amount,id")->where(['is_deleted'=>'0','username'=>$model->Trasnferusername,'password'=>$model->Trasnferpassword])->get('affiliateuser');
              }else{
                  $res=$this->db->select("username,shop_amount,id")->where(['is_deleted'=>'0','username'=>$model->Trasnferusername,'password'=>$model->Trasnferpassword])->get('shop_master');
                  $tableIsexist = 1;
              }
            }
        }


         if(count($res->result_array())>0){
         
            $userDetails = $res->result_array();

             /*Updation on Shop master table*/ 
            if($tableIsexist==1){ 
              if($model->package>$userDetails[0]['shop_amount']) {
                 $response['exist']=1;
                 $response['status']="Error";
                  $response['message']="User have Insufficient Shop ME";
                   echo json_encode($response,JSON_UNESCAPED_SLASHES);
                    die();
              } else{
                
                 $balanceamt = $userDetails[0]['shop_amount'] - $model->package; 
                  $data=array('shop_amount'=>$balanceamt);
                  $this->db->where('id',$userDetails[0]['id']);
                  $this->db->update($this->db->dbprefix('shop_master'),$data);
                 
              } 
            }
             /*Updation on affilate master table*/ 
            else{
              
               if($model->package>$userDetails[0]['shop_amount']) {
                 $response['exist']=1;
                 $response['status']="Error";
                 $response['message']="User have Insufficient shop ME";
                  echo json_encode($response,JSON_UNESCAPED_SLASHES);
                  die();
              } else{
                 $balanceamt = $userDetails[0]['shop_amount'] - $model->package; 
                  $data=array('shop_amount'=>$balanceamt);
                  $this->db->where('id',$userDetails[0]['id']);
                  $this->db->update($this->db->dbprefix('affiliateuser'),$data);
                 
              } 
            }
         $pckIdD = $model->package_id;

          unset($model->package);
          unset($model->package_id);
          unset($model->paythrough);
          unset($model->Trasnferusername);
          unset($model->Trasnferpassword);
          $this->db->insert('shop_master', $model);


          $shop_id = $this->db->insert_id();
          $current_date=date("Y-m-d H:i:s");
              
          /*Check validaity of package*/
            $val_res=$this->db->select("validity,DATE_FORMAT(cdate,'%Y-%m-%d')as cdate")->where('is_deleted','0')->where('id',$pckIdD)->get('packages');

             if(count($val_res->result_array())>0){
                $detls = $val_res->result_array() ; 
                $renew_date = date('Y-m-d', strtotime($detls[0]['validity']."days", strtotime($current_date)));  
             }else{
              $renew_date = date('Y-m-d', strtotime("10 days", strtotime($current_date))); 
             }
           /*End*/

              $this->db->query("insert into ".$this->db->dbprefix('user_vs_packages')." (user_id,package_id,package_status,website_type,shop_id,activated_date,renew_date) values ('".$model->created_by."','".$pckIdD."','0','S','".$shop_id."','". $current_date."','".$renew_date."')");

               $response['exist']=2;
                $response['status']="Success";
               $response['message']="Shop has been created";
            /**End**/

         }else{
           $response['exist']=1;
           $response['status']="Error";
           $response['message']="Enter valid user credentials";
        }

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
  

  public function getshopbyfloorid()
  {
    $model = json_decode($this->input->post('model',FALSE));

     $res=$this->db->select("id,shop_name")->where(['is_deleted'=>'0','floor_id'=>$model->floor_id])->get('shop_master'); 
     $result=array();
      if($res->num_rows()>0)
        {
          $result= $res->result_array();
        }else{
            $response['status']="failure";
            $response['message']="No shop records found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
  }

  public function getshopbymallidfloorid()
  {
    $model = json_decode($this->input->post('model',FALSE));

     $mall_now_det=$this->db->select("*")->where(['mall_name'=>$model->mallid])->get('mall_master')->result_array();

    
     $floor_now_det=$this->db->select("*")->where(['floor_code'=>$model->floorid,'mall_id'=>$mall_now_det[0]['id']])->get('floor_master')->result_array();
      
     $res=$this->db->select("id,shop_name,shop_code,logo,banner,mall_id,floor_id")->where(['is_deleted'=>'0','mall_id'=>$mall_now_det[0]['id'],'floor_id'=>$floor_now_det[0]['id']])->get('shop_master'); 
     
     $floorres=$this->db->select("id,floor_name,floor_code,image_name,mall_id")->where(['is_deleted'=>'0','mall_id'=>$mall_now_det[0]['id'],'id'=>$floor_now_det[0]['id']])->get('floor_master')->result_array(); 
     $result=array();
     
      if($res->num_rows()>0)
        {
          $result= $res->result_array();

        }else{
            $response['status']="failure";
            $response['message']="No shop records found..";
        }
        $response['result']=$result;
        $response["floorDetail"]=$floorres;
        $response["mall_name"] = $mall_now_det[0]['mall_name'];
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
  }

  public function get_shop_list()
  {
     $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $html="";
        global $api_path;        

        $model = json_decode($this->input->post('model',FALSE));
       
        if($model->usergroup==1){
          $res=$this->db->select("*,DATE_FORMAT(created_date,'%d/%m/%Y')as created_date")->where('is_deleted','0')->get('shop_master');
        }else{
          // $res=$this->db->select("*,DATE_FORMAT(created_date,'%d/%m/%Y')as created_date")->where(['is_deleted'=>'0','owner_id'=>$model->created_by])->or_where(['is_deleted'=>'0','mall_id'=>$model->mall_id])->get('shop_master');
          $this->db->select("*,DATE_FORMAT(created_date,'%d/%m/%Y')as created_date");
          if(isset($model->mall_id)){
            $this->db->where(['mall_id'=>$model->mall_id]);
          }
          else{
            $this->db->where(['is_deleted'=>'0','created_by'=>$model->created_by]);  
          }
           $res=$this->db->get('shop_master');

        }
        $pack_price=$pack_id=$renewal_date='';
        if($res->num_rows()>0)
        {


          foreach($res->result_array() as $key=>$value)
          {               
            $user_det=$this->db->select("username")->where(['is_deleted'=>'0','id'=>$value['created_by']])->get('affiliateuser'); 
            $data =$user_det->result_array();  

           $value['created_by']=(count($data)>0)?$data[0]['username']:''; 

            $user_vs_pck_det=$this->db->select("package_status,renew_date,package_id")->where(['shop_id'=>$value['id']])->get('user_vs_packages'); 
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
                      $this->db->where('shop_id',$value['id']);
                      $this->db->update($this->db->dbprefix('user_vs_packages'),$data);

                  }

                
                }
                $renewal_date = $user_vs_pck_data[0]['renew_date'];
            }




            
            $mall_det=$this->db->select("id,mall_name")->where(['is_deleted'=>'0','id'=>$value['mall_id']])->get('mall_master'); 
            $mall_data =$mall_det->result_array();  

            $value['mall_name']=$mall_data[0]['mall_name'];

            $floor_det=$this->db->select("id,floor_name,floor_code")->where(['is_deleted'=>'0','id'=>$value['floor_id']])->get('floor_master'); 
            $floor_data =$floor_det->result_array();  

            $result[]=array('id'=>$value['id'],'shop_name'=>$value['shop_name'],'shop_code'=>$value['shop_code'],'mall_name'=>$value['mall_name'],'mall_id'=>$mall_data[0]['id'],'floor_id'=>$floor_data[0]['id'],'floor_code'=>$floor_data[0]['floor_code'],
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
  
   public function editshop($id)
    {
        //var_dump($id); die();
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();

            $res=$this->db->query("select * from ".$this->db->dbprefix('shop_master')." where id='".$id."'");

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
  public function updateshop() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        if (isset($model)) {
          
          /*Check shop has been changed or not*/
         
          if(strcmp($model->shop_name,$model->beforeEditshopname)!=0){

            $res1=$this->db->select("*")->where(['is_deleted'=>'0','shop_name'=>$model->shop_name])->get('shop_master');
              if(count($res1->result_array())!=0){
                 $response['exist']=1;
                 $response['status']="Error";
                 $response['message']="Shop already existed";
                 echo json_encode($response,JSON_UNESCAPED_SLASHES);
                  die();
              }
          }
 
           $result=$this->db->query("update ".$this->db->dbprefix('shop_master')." set  shop_name='".$model->shop_name."',mall_id='".$model->mall_id."',floor_id='".$model->floor_id."',username='".$model->username."',password='".$model->password."',country='".$model->country."',city='".$model->city."',state='".$model->state."',address='".$model->address."',logo='".$model->logo."',banner='".$model->banner."' where id='".$model->id."'");
           
          $response['message']="shop has been updated successfully";          

        } else {
            $response['status']="failure";
            $response['message']="Error while on update shop";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }
    public function deleteshop($id)
    {
      $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        

        $res_chk=$this->db->query("select id from ".$this->db->dbprefix('shop_master')." where id='".$id."' ");
        //print_r($res_chk);die;
        if($res_chk->num_rows()>0){

            $data=array('is_deleted'=>'1');
            $this->db->where('id',$id);
            $this->db->update($this->db->dbprefix('shop_master'),$data);

            $response['status']="success";
            $response['message']="shop record has been deleted successfully";
            
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";    
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    }

 
  public function fetchshopbyid($id)
  {
      $res=$this->db->select("*")->where(['is_deleted'=>'0','created_by'=>$id])->get('shop_master'); 
      $result=array();
      if($res->num_rows()>0)
        {
          foreach($res->result_array() as $key=>$value)
          {               
            
            $user_det=$this->db->select("username")->where(['is_deleted'=>'0','id'=>$value['created_by']])->get('affiliateuser'); 
            $data =$user_det->result_array();

            $value['created_by']=$data[0]['username'];
            
            $result[]=array('id'=>$value['id'],'shop_name'=>$value['shop_name'],
              'created_date'=>$value['created_date'],'created_by'=>$value['created_by']);
          }
        }else{
            $response['status']="failure";
            $response['message']="No shop records found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
  }


  public function add_order(){
    $this->output->set_content_type('application/json');
   
     $response=array('status'=>"success",'message'=>"Order Placed successfully");

     $model = json_decode($this->input->post('model',FALSE));
     
     $this->db->insert('order_items', $model);

     echo json_encode($response,JSON_UNESCAPED_SLASHES);
     die();
 }



 public function getOrdersbyShopid()
  {
      $model = json_decode($this->input->post('model',FALSE));

      // print_r($model);
      // die();

      $res=$this->db->select("*")->order_by("id", "desc")->where(['order_delete_status'=>'0','shopname'=>$model->shopname])->get('order_items'); 
      $result=array();
      if($res->num_rows()>0)
        {
          $result=$res->result_array(); 
          
        }else{
            $response['status']="failure";
            $response['message']="No Orders Found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
  }
  


public function add_product_category(){
  $this->output->set_content_type('application/json');
 
   $response=array('status'=>"success",'message'=>"Category Added successfully");

   $model = json_decode($this->input->post('model',FALSE));

  //  print_r($this->input->post()); die();
   
   $this->db->insert('shop_product_category', $model);

   echo json_encode($response,JSON_UNESCAPED_SLASHES);
   die();
}

public function getCategorybyShopid()
  {
      $model = json_decode($this->input->post('model',FALSE));

      $res=$this->db->select("*")->where(['delete_status'=>'0','shop_id'=>$model->shop_id])->get('shop_product_category'); 
      $result=array();
      if($res->num_rows()>0)
        {
          $result=$res->result_array(); 
          
        }else{
            $response['status']="failure";
            $response['message']="No category Found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
  }

  
  public function deleteshopcategory($id)
  {
    $this->output->set_content_type('application/json');
      $response=array();
      $response['status']="success";
      

      $res_chk=$this->db->query("select id from ".$this->db->dbprefix('shop_product_category')." where id='".$id."' ");
      //print_r($res_chk);die;
      if($res_chk->num_rows()>0){

          $data=array('delete_status'=>'1');
          $this->db->where('id',$id);
          $this->db->update($this->db->dbprefix('shop_product_category'),$data);

          $response['status']="success";
          $response['message']="Category record has been deleted successfully";
          
      }else{
          $response['status']="failure";
          $response['message']="Invalid Attempt!!.. Access denied..";    
      }
       echo json_encode($response,JSON_UNESCAPED_SLASHES);
       die();
  }
  public function getShopcode(){
     $this->output->set_content_type('application/json');
     $model = json_decode($this->input->post('model',FALSE));


    $res=$this->db->select("*,DATE_FORMAT(created_date,'%d/%m/%Y')as created_date")->where(['is_deleted'=>'0','mall_id'=>$model->mall_id,'floor_id'=>$model->floor_id])->get('shop_master');

     $result=array();
     $floorname='';
     if(count($res->result_array())>0){
      $tot_cnt = (count($res->result_array()))+1;
      
      $Label = "s";
      $shopcode = $Label . $tot_cnt;
      
      $result['shopcode']=$shopcode;
      
     }else{
      $result['shopcode']='s1';
     }

      $response['result']=$result;
       echo json_encode($response,JSON_UNESCAPED_SLASHES);
       die();

   }
}
