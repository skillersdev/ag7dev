<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_controller extends CI_Controller {

	public function index() {
		$this->output->set_content_type('application/json');
		die(json_encode(array('status'=>"failure", 'error'=>'UN-Authorized access'), JSON_UNESCAPED_SLASHES));
	}

   public function add_category(){
       $this->output->set_content_type('application/json');
      
        $response=array('status'=>"success",'message'=>"Category Inserted successfully");

        $model = json_decode($this->input->post('model',FALSE));
        
        $this->db->insert('category_master', $model);

        

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
  public function getsubcategorylistbyuser($id)
  {
    $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $html="";
        global $api_path;        

        $res=$this->db->select("*,DATE_FORMAT(created_date,'%d/%m/%Y')as created_date")->
        where(['is_deleted'=>'0','created_by'=>$id])->get('sub_category_master');


        if($res->num_rows()>0)
        {
          foreach($res->result_array() as $key=>$value)
          { 

            $cat_det=$this->db->select("category_name")->where(['id'=>$value['category_id'],'is_deleted'=>'0'])->get('category_master'); 
            $cat_data =$cat_det->result_array();  

            $value['category_name']=$cat_data[0]['category_name']; 

            $user_det=$this->db->select("username")->where(['is_deleted'=>'0','id'=>$value['created_by']])->get('affiliateuser'); 
            $data =$user_det->result_array();  

            $value['created_by']=$data[0]['username'];

            $result[]=array('id'=>$value['id'],'sub_category_name'=>$value['sub_category_name'],'created_date'=>$value['created_date'],'category_name'=>$value['category_name'],'created_by'=>$value['created_by']);
          }
        }else{
            $response['status']="failure";
            $response['message']="No User records found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
  }  
  public function getsubcategorybyid($id)
  {
    $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $html="";
        global $api_path;        

        $res=$this->db->select("*,DATE_FORMAT(created_date,'%d/%m/%Y')as created_date")->
        where(['is_deleted'=>'0','category_id'=>$id])->get('sub_category_master');


        if($res->num_rows()>0)
        {
          foreach($res->result_array() as $key=>$value)
          { 

            $cat_det=$this->db->select("category_name")->where(['id'=>$value['category_id'],'is_deleted'=>'0'])->get('category_master'); 
            $cat_data =$cat_det->result_array();  

            $value['category_name']=$cat_data[0]['category_name']; 

            $user_det=$this->db->select("username")->where(['is_deleted'=>'0','id'=>$value['created_by']])->get('affiliateuser'); 
            $data =$user_det->result_array();  

            $value['created_by']=$data[0]['username'];

            $result[]=array('id'=>$value['id'],'sub_category_name'=>$value['sub_category_name'],'created_date'=>$value['created_date'],'category_name'=>$value['category_name'],'created_by'=>$value['created_by']);
          }
        }else{
            $response['status']="failure";
            $response['message']="No User records found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
  }
  public function getcategorybyweb()
  {
    $model = json_decode($this->input->post('model',FALSE));

     $res=$this->db->select("*")->like('url',$model->url)->where(['is_deleted'=>'0'])->get('category_master'); 
     $result=array();
      if($res->num_rows()>0)
        {
          foreach($res->result_array() as $key=>$value)
          {               
             $user_det=$this->db->select("username")->where(['is_deleted'=>'0','id'=>$value['created_by']])->get('affiliateuser'); 
            $data =$user_det->result_array();

            $value['created_by']=$data[0]['username'];

           // print_r($data[0]['username']);die;
            $result[]=array('id'=>$value['id'],'category_name'=>$value['category_name'],
              'created_date'=>$value['created_date'],'created_by'=>$value['created_by']);
          }
        }else{
            $response['status']="failure";
            $response['message']="No Category records found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
  }
  public function get_category_list()
  {
     $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $html="";
        global $api_path;        

        $res=$this->db->select("*,DATE_FORMAT(created_date,'%d/%m/%Y')as created_date")->where('is_deleted','0')->get('category_master');


        if($res->num_rows()>0)
        {
          foreach($res->result_array() as $key=>$value)
          {               
            $user_det=$this->db->select("username")->where(['is_deleted'=>'0','id'=>$value['created_by']])->get('affiliateuser'); 
            $data =$user_det->result_array();  

            $value['created_by']=$data[0]['username']; 

            $result[]=array('id'=>$value['id'],'category_name'=>$value['category_name'],
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
  
   public function editcategory($id)
    {
        //var_dump($id); die();
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();

            $res=$this->db->query("select * from ".$this->db->dbprefix('category_master')." where id='".$id."'");

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
  public function updatecategory() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        if (isset($model)) {
              
           $result=$this->db->query("update ".$this->db->dbprefix('category_master')." set  category_name='".$model->category_name."' where id='".$model->id."'");
           
          $response['message']="category has been updated successfully";          

        } else {
            $response['status']="failure";
            $response['message']="Error while on update category";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }
    public function deletecategory($id)
    {
      $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        

        $res_chk=$this->db->query("select id from ".$this->db->dbprefix('category_master')." where id='".$id."' ");
        //print_r($res_chk);die;
        if($res_chk->num_rows()>0){

            $data=array('is_deleted'=>'1');
            $this->db->where('id',$id);
            $this->db->update($this->db->dbprefix('category_master'),$data);

            $response['status']="success";
            $response['message']="Category record has been deleted successfully";
            
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";    
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    }

  public function add_subcategory()
  {
    $this->output->set_content_type('application/json');
      
        $response=array('status'=>"success",'message'=>"Sub Category Inserted successfully");

        $model = json_decode($this->input->post('model',FALSE));
        
        $this->db->insert('sub_category_master', $model);

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
  }
  public function fetchcategorybyid($id)
  {
      $res=$this->db->select("*")->where(['is_deleted'=>'0','created_by'=>$id])->get('category_master'); 
      $result=array();
      if($res->num_rows()>0)
        {
          foreach($res->result_array() as $key=>$value)
          {               
            
            $user_det=$this->db->select("username")->where(['is_deleted'=>'0','id'=>$value['created_by']])->get('affiliateuser'); 
            $data =$user_det->result_array();

            $value['created_by']=$data[0]['username'];
            
            $result[]=array('id'=>$value['id'],'category_name'=>$value['category_name'],
              'created_date'=>$value['created_date'],'created_by'=>$value['created_by']);
          }
        }else{
            $response['status']="failure";
            $response['message']="No Category records found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
  }
   public function get_sub_category_list()
  
  {
     $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $html="";
        global $api_path;        

        $res=$this->db->select("*,DATE_FORMAT(created_date,'%d/%m/%Y')as created_date")->where('is_deleted','0')->get('sub_category_master');


        if($res->num_rows()>0)
        {
          foreach($res->result_array() as $key=>$value)
          {               
            $user_det=$this->db->select("username")->where(['is_deleted'=>'0','id'=>$value['created_by']])->get('affiliateuser'); 
            $data =$user_det->result_array();  

            $value['created_by']=$data[0]['username']; 

            $cat_det=$this->db->select("category_name")->where(['id'=>$value['category_id'],'is_deleted'=>'0'])->get('category_master'); 
            $cat_data =$cat_det->result_array();  

            $value['category_name']=$cat_data[0]['category_name']; 

            $result[]=array('id'=>$value['id'],'sub_category_name'=>$value['sub_category_name'],'category_name'=>$value['category_name'],'created_date'=>$value['created_date'],'created_by'=>$value['created_by']);
          }
        }else{
            $response['status']="failure";
            $response['message']="No User records found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    

  }
   public function editsubcategory($id)
    {
        //var_dump($id); die();
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();

            $res=$this->db->query("select * from ".$this->db->dbprefix('sub_category_master')." where id='".$id."'");

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
   public function updatesubcategory() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        if (isset($model)) {
              
           $result=$this->db->query("update ".$this->db->dbprefix('sub_category_master')." 
            set sub_category_name='".$model->sub_category_name."',category_id='".$model->category_id."' where id='".$model->id."'");
           
          $response['message']="Sub category has been updated successfully";          

        } else {
            $response['status']="failure";
            $response['message']="Error while on update Subcategory";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

     public function deletesubcategory($id)
    {
      $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        

        $res_chk=$this->db->query("select id from ".$this->db->dbprefix('sub_category_master')." where id='".$id."' ");
        //print_r($res_chk);die;
        if($res_chk->num_rows()>0){

            $data=array('is_deleted'=>'1');
            $this->db->where('id',$id);
            $this->db->update($this->db->dbprefix('sub_category_master'),$data);

            $response['status']="success";
            $response['message']="Sub category record has been deleted successfully";
            
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";    
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    }

}
