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

        unset($model->type);
        
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

                $ext = '.'.pathinfo($result['service_image'], PATHINFO_EXTENSION);
                $upper_Case_ext=strtoupper($ext);

                $result['type'] = ($upper_Case_ext==".IMG"||$upper_Case_ext==".JPG"||$upper_Case_ext==".JPEG"||$upper_Case_ext==".PNG")?'1':'2';
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
            

              $result=$this->db->query("update ".$this->db->dbprefix('services')." set  title='".$model->title."',description='".$model->description."',service_image='".$model->service_image."',website='".$model->website."' where id='".$model->id."'");

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

     public function uploadserviceimage()
    {
       $path = 'product_image/';
        $Response=[];
     
        if (isset($_FILES['file'])) 
          {
            $originalName = $_FILES['file']['name'];
            $ext = '.'.pathinfo($originalName, PATHINFO_EXTENSION);
             
           
              $generatedName = md5($_FILES['file']['tmp_name']).$ext;

              $filePath = $path.$generatedName;
              $product_image=$filePath;
           
              if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) 
              {
                $Response['status']="success"; 
                $Response['data']=$product_image;
              }
           
          }
        else {
            $Response['status']="fail"; 
            $Response['data']="Error While upload on image";
         }
          echo json_encode($Response,JSON_UNESCAPED_SLASHES);
         die();
    }

    public function getservicebyuser()
    {
      $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $package=array();
         $model = json_decode($this->input->post('model',FALSE));

       $res=$this->db->query("select * from ".$this->db->dbprefix('user_vs_packages')." where website!='' AND user_id='".$model->userId."' ");
            if($res->num_rows()>0){
                $in_array=$res->result_array();

                foreach ($in_array as $key => $value) 
                {
                    $package[] =  $value['website'];  
                }
            }
        $query_parts = array();
        foreach ($package as $val) {
            $query_parts[] = "'".$val."'";
        }

        $string = implode(' OR website LIKE ', $query_parts);

        //echo "select *,DATE_FORMAT(created_date,'%d/%m/%Y')as created_date from ".$this->db->dbprefix('services')." WHERE is_deleted=0 AND website LIKE {$string}";die;

        $tank = $this->db->query("select *,DATE_FORMAT(created_date,'%d/%m/%Y')as created_date from ".$this->db->dbprefix('services')." WHERE is_deleted=0 AND website LIKE {$string} ");
        $result1=$tank->result_array();
          $response['result']=$result1;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    }

   
}
