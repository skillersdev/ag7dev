<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contacts_controller extends CI_Controller {

  public function index() {
    $this->output->set_content_type('application/json');
    die(json_encode(array('status'=>"failure", 'error'=>'UN-Authorized access'), JSON_UNESCAPED_SLASHES));
  }

   public function addcontacts(){
       $this->output->set_content_type('application/json');
      
        $response=array('status'=>"success",'message'=>"Contact Inserted successfully");

        $model = json_decode($this->input->post('model',FALSE));

         $website = trim($model->website);
          if(isset($website))
            {
              $res=$this->db->select("*")->where(['is_deleted'=>'0','website'=>$website])->get('contacts_master') ;
          }
          //print_r($res->result_array());die;
           if(count($res->result_array())>0)
            {
               
                $response['exist']=1;
                $response['statuc']="error";
                $response['message']="Selected Website has already contact exists";
            }                                                                                                                                                                 
            else{              
              $this->db->insert('contacts_master', $model);

              $last_insert_contact_id = $this->db->insert_id();

               $this->db->query("insert into ".$this->db->dbprefix('contact_image_log')." 
            (contact_id,image_name) values('".$last_insert_contact_id."','".$model->website_image."')");
            }
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

            $result[]=array('id'=>$value['id'],'sub_category_name'=>$value['sub_category_name'],'created_date'=>$value['created_date'],'created_by'=>$value['created_by']);
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

     $res=$this->db->select("*")->where(['is_deleted'=>'0','url'=>$model->url])->get('category_master'); 
     $result=array();
      if($res->num_rows()>0)
        {
          foreach($res->result_array() as $key=>$value)
          {               
            
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
  public function get_contact_list()
  {
     $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $html="";
        global $api_path;        

        $res=$this->db->select("*,DATE_FORMAT(created_date,'%d/%m/%Y')as created_date")->where('is_deleted','0')->get('contacts_master');


        if($res->num_rows()>0)
        {
          foreach($res->result_array() as $key=>$value)
          {  

            $result[]=array('id'=>$value['id'],'website'=>$value['website'],
              'created_date'=>$value['created_date'],'contact'=>$value['contact']);
          }
        }else{
            $response['status']="failure";
            $response['message']="No records found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    

  }
   public function getcontactbyid($id)
   {
     $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();

            $res=$this->db->query("select * from ".$this->db->dbprefix('contacts_master')." where created_by='".$id."' AND is_deleted=0 ");

            if($res->num_rows()>0)
            {
              foreach($res->result_array() as $key=>$value)
              {  

                $result[]=array('id'=>$value['id'],'website'=>$value['website'],
                  'created_date'=>$value['created_date'],'contact'=>$value['contact']);
              }
            }else{
                $response['status']="failure";
                $response['message']="No records found..";
            }
            $response['result']=$result;

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
   }
  
  
   public function editcontact($id)
    {
        //var_dump($id); die();
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();

            $res=$this->db->query("select * from ".$this->db->dbprefix('contacts_master')." where id='".$id."'");

            if($res->num_rows()>0){
                $in_array=$res->result_array();
                $result=$in_array[0];

               $log_res=$this->db->select("*,DATE_FORMAT(created_date,'%d/%m/%Y')as created_date")->where(['contact_id'=>$id])->get('contact_image_log');


              if($log_res->num_rows()>0)
              {
                foreach($log_res->result_array() as $key=>$value)
                { 
                  $result['log_result'][]=array('id'=>$value['id'],'contact_id'=>$value['contact_id'],'image_name'=>$value['image_name']);
                }
              }
            }else{
                $response['status']="failure";
                $response['message']=" No  record found!!";
            }
            $response['result']=$result;

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
  public function updatecontact() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        if (isset($model)) {
              
           $website = trim($model->website);
          if(isset($website))
            {
              $res=$this->db->select("website")->where(['is_deleted'=>'0','id!='=>$model->id,'website'=>$website])->get('contacts_master') ;
            }
           // if(count($res->result_array())>0)
           //  {
               
           //      $response['exist']=1;
           //      $response['statuc']="error";
           //      $response['message']="Selected Website hs already contact exists";
           //  } 
            // else
            // {
               $this->db->where('id',$model->id);
                  $result=$this->db->update('contacts_master', $model);

                 // $last_insert_contact_id = $this->db->insert_id();

               $this->db->query("insert into ".$this->db->dbprefix('contact_image_log')." 
            (contact_id,image_name) values('".$model->id."','".$model->website_image."')");
           
                $response['message']="contacts has been updated successfully"; 
            // }


                   

        } else {
            $response['status']="failure";
            $response['message']="Error while on update contacts";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }
     public function deletecontact($id)
    {
      $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        

        $res_chk=$this->db->query("select id from ".$this->db->dbprefix('contacts_master')." where id='".$id."' ");
       // print_r($res_chk->num_rows());die;
        if($res_chk->num_rows()>0){

            $data=array('is_deleted'=>'1');
            $this->db->where('id',$id);
            $this->db->update($this->db->dbprefix('contacts_master'),$data);

            $response['status']="success";
            $response['message']="Record has been deleted successfully";
            
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

    public function deletecontactlogimages($id)
    {
       $subscriber_delete=$this->db->query("DELETE FROM contact_image_log where id='".$id."' "); 

      $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $response['message']="Contact Image deleted successfully";
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }

}
