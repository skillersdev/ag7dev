<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sectionitem_controller extends CI_Controller {

	public function index() {
		$this->output->set_content_type('application/json');
		die(json_encode(array('status'=>"failure", 'error'=>'UN-Authorized access'), JSON_UNESCAPED_SLASHES));
	}

   public function addsectionitem(){
       $this->output->set_content_type('application/json');
      
        $response=array('status'=>"success",'message'=>"Section Inserted successfully");

        $model = json_decode($this->input->post('model',FALSE));

        unset($model->usergroup);  
        unset($model->user_id); 
        unset($model->websiteSelected);
        unset($model->IspreviewImage);
        
        $this->db->insert('manage_section_item', $model);

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();       
    }
  
  public function getsectionitemlist()
  {
     $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $html="";
        global $api_path;  
        $model = json_decode($this->input->post('model',FALSE));
        /**Get list by user**/
        if($model->usergroup==2)
        {
           $res=$this->db->query("select *,DATE_FORMAT(created_date,'%d/%m/%Y')as cdate from ".$this->db->dbprefix('manage_section_item')." where created_by='".$model->user_id."' AND is_deleted=0");
        }
        /*BY all list*/ 
        else{
           $res=$this->db->select("*,DATE_FORMAT(created_date,'%d/%m/%Y')as cdate")->where('is_deleted','0')->get('manage_section_item');
        }

        if($res->num_rows()>0)
        {
          foreach($res->result_array() as $key=>$value)
          {               
            if($value['media_type']=='1'){
              $type ="Image";
            }
            else if($value['media_type']=='2')
            {
              $type ="Video";
            }else if($value['media_type']=='3')
            {
              $type ="Pdf";
            }
            else if($value['media_type']=='4')
            {
              $type ="Doc";
            }else if($value['media_type']=='5')
            {
              $type ="Audio";
            }

            $result[]=array('id'=>$value['id'],'website'=>$value['website'],'section_item'=>$value['title'],'description'=>$value['description'],'created_date'=>$value['cdate'],'type'=>$type);
          }
        }else{
            $response['status']="failure";
            $response['message']="No Service records found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    

  }
  
   public function editsectionitem($id)
    {
        //var_dump($id); die();
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();

        $res=$this->db->query("select * from ".$this->db->dbprefix('manage_section_item')." where id='".$id."'");

        if($res->num_rows()>0){
            $in_array=$res->result_array();
            $result=$in_array[0];
        }else{
            $response['status']="failure";
            $response['message']=" No Service record found!!";
        }
        $response['result']=$result;

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
  public function updatesectionItem() 
    {
      $this->output->set_content_type('application/json');
      $response=array('status'=>"success");
       $model = json_decode($this->input->post('model',FALSE));

        if (isset($model)) 
          {
            $result=$this->db->query("update ".$this->db->dbprefix('manage_section_item')." set  website='".$model->website."',media_type='".$model->media_type."',title='".$model->title."',description='".$model->description."',file_name='".$model->file_name."',attachment_desc='".$model->description."',created_by='".$model->created_by."',section='".$model->section."',preview_file ='".$model->preview_file."' where id='".$model->id."'");

            if ($result) {
                $response['message']="Section has been updated successfully";
            }
            else
            {
              $response['status']="failure";
              $response['message']="Section has not been updated fully";
            }
        } 
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }
    public function deletesectionitem($id)
    {
      $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        

        $res_chk=$this->db->query("select id from ".$this->db->dbprefix('manage_section_item')." where id='".$id."' ");
        //print_r($res_chk);die;
        if($res_chk->num_rows()>0){

            $data=array('is_deleted'=>'1');
            $this->db->where('id',$id);
            $this->db->update($this->db->dbprefix('manage_section_item'),$data);

            $response['status']="success";
            $response['message']="section record has been deleted successfully";
            
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

   public function updatesectionbytoggle()
   {
    $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $model = json_decode($this->input->post('model',FALSE));
  

        $res_chk=$this->db->query("select id from ".$this->db->dbprefix('manage_section')." where id='".$model->sectionId."' ");
        //print_r($res_chk);die;
        if($res_chk->num_rows()>0){
          if($model->Isshow==1)
          {
            $data=array('Issection_show'=>'0');
          }
            else{
            $data=array('Issection_show'=>'1');   
            }
            $this->db->where('id',$model->sectionId );
            $this->db->update($this->db->dbprefix('manage_section'),$data);

            $response['status']="success";
            $response['message']="section record has been updated successfully";
            
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";    
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
   }
   public function uploadsectionitemvideo()
   {
    $path = 'sectionitemvideos/';
    $Response=[];
   //print_r($_FILES);die;
    if (isset($_FILES['file']) && $_FILES['file']) 
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
   
}
