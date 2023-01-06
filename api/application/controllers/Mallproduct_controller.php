<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mallproduct_controller extends CI_Controller {

	public function index() {
		$this->output->set_content_type('application/json');
		die(json_encode(array('status'=>"failure", 'error'=>'UN-Authorized access'), JSON_UNESCAPED_SLASHES));
	}

   public function add_mallproduct(){
       $this->output->set_content_type('application/json');
      
        $response=array('status'=>"success",'message'=>"mallproduct Inserted successfully");

        $model = json_decode($this->input->post('model',FALSE));
        
        $this->db->insert('mallproduct_master', $model);

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
  

  public function getmallproductbyfloorid()
  {
    $model = json_decode($this->input->post('model',FALSE));

     $res=$this->db->select("id,product_name")->where(['is_deleted'=>'0','floor_id'=>$model->floor_id])->get('mallproduct_master'); 
     $result=array();
      if($res->num_rows()>0)
        {
          $result= $res->result_array();
        }else{
            $response['status']="failure";
            $response['message']="No mallproduct records found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
  }

  public function get_mallproduct_list()
  {
     $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $html="";
        global $api_path;        

        $model = json_decode($this->input->post('model',FALSE));
        if(isset($model->usergroup)){
          $model->usergroup=$model->usergroup;
        }else{
          $model->usergroup='';
        }
        // print_r($model);
        if($model->usergroup==1){
          $res=$this->db->select("*,DATE_FORMAT(created_date,'%d/%m/%Y')as created_date")->where('is_deleted','0')->get('mallproduct_master');
        }else{
          $res=$this->db->select("*,DATE_FORMAT(created_date,'%d/%m/%Y')as created_date")->where(['is_deleted'=>'0','owner_id'=>$model->created_by])->get('mallproduct_master');
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

            $result[]=array('id'=>$value['id'],'product_name'=>$value['product_name'],'mall_name'=>$value['mall_name'],
              'created_date'=>$value['created_date'],'created_by'=>$value['created_by'],'mall_id'=>$value['mall_id'],'floor_id'=>$value['floor_id'],'shop_id'=>$value['shop_id'],'category_id'=>$value['category_id']);
          }
        }else{
            $response['status']="failure";
            $response['message']="No User records found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    

  }
  
   public function editmallproduct($id)
    {
        //var_dump($id); die();
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();

            $res=$this->db->query("select * from ".$this->db->dbprefix('mallproduct_master')." where id='".$id."'");

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
  public function updatemallproduct() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        if (isset($model)) {
              
           $result=$this->db->query("update ".$this->db->dbprefix('mallproduct_master')." set  product_name='".$model->product_name."',mall_id='".$model->mall_id."',category_id='".$model->category_id."',floor_id='".$model->floor_id."',shop_id='".$model->shop_id."'  where id='".$model->id."'");
           
          $response['message']="mallproduct has been updated successfully";          

        } else {
            $response['status']="failure";
            $response['message']="Error while on update mallproduct";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }
    public function deletemallproduct($id)
    {
      $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        

        $res_chk=$this->db->query("select id from ".$this->db->dbprefix('mallproduct_master')." where id='".$id."' ");
        //print_r($res_chk);die;
        if($res_chk->num_rows()>0){

            $data=array('is_deleted'=>'1');
            $this->db->where('id',$id);
            $this->db->update($this->db->dbprefix('mallproduct_master'),$data);

            $response['status']="success";
            $response['message']="mallproduct record has been deleted successfully";
            
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";    
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    }

 
  public function fetchmallproductbyid($id)
  {
      $res=$this->db->select("*")->where(['is_deleted'=>'0','created_by'=>$id])->get('mallproduct_master'); 
      $result=array();
      if($res->num_rows()>0)
        {
          foreach($res->result_array() as $key=>$value)
          {               
            
            $user_det=$this->db->select("username")->where(['is_deleted'=>'0','id'=>$value['created_by']])->get('affiliateuser'); 
            $data =$user_det->result_array();

            $value['created_by']=$data[0]['username'];
            
            $result[]=array('id'=>$value['id'],'product_name'=>$value['product_name'],
              'created_date'=>$value['created_date'],'created_by'=>$value['created_by']);
          }
        }else{
            $response['status']="failure";
            $response['message']="No mallproduct records found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
  }
  public function  imageupload(){
    $path = 'mallproduct_image/';
    $Response=[];
    // print_r($_FILES['file']); die;
    if (isset($_FILES['file'])) 
      {
        $originalName = $_FILES['file']['name'];
        $ext = '.'.pathinfo($originalName, PATHINFO_EXTENSION);
        
        $upper_Case_ext=strtoupper($ext);

        //3GPP, AVI, FLV, MOV, MPEG4, MPEGPS, WebM and WMV. MPEG4
        // if($upper_Case_ext==".IMG"||$upper_Case_ext==".JPG"||$upper_Case_ext==".JPEG"||$upper_Case_ext==".PNG" ||$upper_Case_ext==".MP4" ||$upper_Case_ext==".AVI" ||$upper_Case_ext==".3GPP" ||$upper_Case_ext==".FLV" ||$upper_Case_ext==".MOV" ||$upper_Case_ext==".MPEG4" ||$upper_Case_ext==".MPEGPS" ||$upper_Case_ext==".WebM" ||$upper_Case_ext==".WMV" ||$upper_Case_ext==".MPEG4")
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

  public function getshopmallproduct()
    {
        //var_dump($id); die();
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $model = json_decode($this->input->post('model',FALSE));

        if (isset($model)) {
          $shop=array();
          $result=array();

          $res=$this->db->query("select * from ".$this->db->dbprefix('shop_master')." where shop_name='".$model->shopname."'");


          if($res->num_rows()>0){
              $in_array=$res->result_array();
                $shop = $in_array[0];
               $country_det=$this->db->select("name")->where(['id'=>$in_array[0]['country']])->get('countries')->result_array();

              $shop['country'] = $country_det[0]['name'];

              $state_det=$this->db->select("name")->where(['id'=>$in_array[0]['state']])->get('states')->result_array();
              $shop['state'] = $state_det[0]['name'];

              $city_det=$this->db->select("name")->where(['id'=>$in_array[0]['city']])->get('cities')->result_array();
              $shop['city'] = $city_det[0]['name'];


              $response['shop']=$shop;
              $res=$this->db->query("select * from ".$this->db->dbprefix('mallproduct_master')." where shop_id='".$in_array[0]['id']."'");

              $cat_res=$this->db->query("select * from ".$this->db->dbprefix('shop_product_category')." where shop_id='".$in_array[0]['id']."'");
              if($cat_res->num_rows()>0){
                $cat_array=$cat_res->result_array();
                $response['categorylist']=$cat_array;
              }


              if($res->num_rows()>0){
                  $in_array=$res->result_array();
                  $result=$in_array;
              }else{
                  $response['status']="failure";
                  $response['message']=" No Package record found!!";
              }
              $response['result']=$result;
          }
        }
           

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }

}
