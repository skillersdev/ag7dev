<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Floor_controller extends CI_Controller {

	public function index() {
		$this->output->set_content_type('application/json');
		die(json_encode(array('status'=>"failure", 'error'=>'UN-Authorized access'), JSON_UNESCAPED_SLASHES));
	}

   public function add_floor(){
       $this->output->set_content_type('application/json');
      
        $response=array('status'=>"success",'message'=>"floor Inserted successfully");

        $model = json_decode($this->input->post('model',FALSE));
        
        $this->db->insert('floor_master', $model);

        

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
            $res=$this->db->select("*,DATE_FORMAT(created_date,'%d/%m/%Y')as created_date")->where(['is_deleted'=>'0','mall_id'=>$model->mall_id])->get('floor_master');
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

            $result[]=array('id'=>$value['id'],'floor_name'=>$value['floor_name'],'image_name'=>$value['image_name'],'mall_name'=>$value['mall_name'],
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
  
   public function editfloor($id)
    {
        //var_dump($id); die();
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();

            $res=$this->db->query("select * from ".$this->db->dbprefix('floor_master')." where id='".$id."'");

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
  public function updatefloor() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        if (isset($model)) {
              
           $result=$this->db->query("update ".$this->db->dbprefix('floor_master')." set  floor_name='".$model->floor_name."',image_name='".$model->image_name."',mall_id='".$model->mall_id."',username='".$model->username."',password='".$model->password."' where id='".$model->id."'");
           
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
  

}
