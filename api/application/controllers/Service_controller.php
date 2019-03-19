<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service_controller extends CI_Controller {

	public function index() {
		$this->output->set_content_type('application/json');
		die(json_encode(array('status'=>"failure", 'error'=>'UN-Authorized access'), JSON_UNESCAPED_SLASHES));
	}

   public function addservice(){
       $this->output->set_content_type('application/json');
      
        $response=array('status'=>"success",'message'=>"Service Inserted successfully");

        $model = json_decode($this->input->post('model',FALSE));
        
        $this->db->insert('services', $model);

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();       
    }
  
  public function get_all_service_details()
  {
     $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $html="";
        global $api_path;        

        $res=$this->db->select("*,DATE_FORMAT(created_date,'%d/%m/%Y')as cdate")->where('is_deleted','0')->get('services');


        if($res->num_rows()>0)
        {
          foreach($res->result_array() as $key=>$value)
          {               

            $result[]=array('id'=>$value['id'],'title'=>$value['title'],'description'=>$value['description'],'website'=>$value['website'],'created_date'=>$value['cdate']);
          }
        }else{
            $response['status']="failure";
            $response['message']="No Service records found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    

  }
  
   public function editservice($id)
    {
        //var_dump($id); die();
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();

            $res=$this->db->query("select * from ".$this->db->dbprefix('services')." where id='".$id."'");

            if($res->num_rows()>0){
                $in_array=$res->result_array();
                $result=$in_array[0];
               // print_r($level_value);die;
            }else{
                $response['status']="failure";
                $response['message']=" No Service record found!!";
            }
            $response['result']=$result;

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
  public function updateservice() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));
//       print_r($level_field);die();

        if (isset($model)) {
        
          //   $this->db->where('id',$model->id);
          //   $result=$this->db->update('package_info', $model);
          // //  pr($this->db->last_query());die();
            

              $result=$this->db->query("update ".$this->db->dbprefix('services')." set  title='".$model->title."',description='".$model->description."',website='".$model->website."' where id='".$model->id."'");

            if ($result) {
                $response['message']="Service has been updated successfully";
            }
            else
            {
                 $response['status']="failure";
            $response['message']="Service has not been updated fully";
            }
            

        } else {
            $response['status']="failure";
            $response['message']="Choose Service and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }
    public function deleteservice($id)
    {
      $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        

        $res_chk=$this->db->query("select id from ".$this->db->dbprefix('services')." where id='".$id."' ");
        //print_r($res_chk);die;
        if($res_chk->num_rows()>0){

            $data=array('is_deleted'=>'1');
            $this->db->where('id',$id);
            $this->db->update($this->db->dbprefix('services'),$data);

            $response['status']="success";
            $response['message']="service record has been deleted successfully";
            
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";    
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    }

   
}
