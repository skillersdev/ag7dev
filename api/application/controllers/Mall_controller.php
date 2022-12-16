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

        $model = json_decode($this->input->post('model',FALSE));
        
        $this->db->insert('mall_master', $model);

        

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
            $res=$this->db->select("*,DATE_FORMAT(created_date,'%d/%m/%Y')as created_date")->where(['is_deleted'=>'0','created_by'=>$model->created_by])->or_where("username",$model->created_by)->or_where("id",$model->mall_id)->get('mall_master');
          }
          else{
            $res=$this->db->select("*,DATE_FORMAT(created_date,'%d/%m/%Y')as created_date")->where(['is_deleted'=>'0','username'=>$model->username])->get('mall_master');
          }
          
          
        }        

         

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
    $mall_det=$this->db->select("id,mall_name,image_name,usergroup,created_by")->where(['is_deleted'=>'0','id'=>$model->mallid])->get('mall_master')->result_array();
    $result["mall_det"]=$mall_det;
    $floor_det=$this->db->select("id,floor_name,mall_id")->where(['is_deleted'=>'0','mall_id'=>$model->mallid])->get('floor_master');
    if($floor_det->num_rows()>0){

      foreach($floor_det->result_array() as $key=>$value)
      {
        //$result[$key]=array("floorData"=>$value);
        $shop_det=$this->db->select("shop_name,mall_id,floor_id,logo,banner,usergroup")->where(['is_deleted'=>'0','mall_id'=>$model->mallid,'floor_id'=>$value['id'] ])->get('shop_master');
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
            
         $result=$this->db->query("update ".$this->db->dbprefix('mall_master')." set  mall_name='".$model->mall_name."',username='".$model->username."',image_name='".$model->image_name."',password='".$model->password."' where id='".$model->id."'");
         
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
