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

        $res=$this->db->select("*,DATE_FORMAT(created_date,'%d/%m/%Y')as created_date")->where('is_deleted','0')->get('mall_master');


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
  public function updatemall() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        if (isset($model)) {
              
           $result=$this->db->query("update ".$this->db->dbprefix('mall_master')." set  mall_name='".$model->mall_name."',username='".$model->username."',password='".$model->password."' where id='".$model->id."'");
           
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
