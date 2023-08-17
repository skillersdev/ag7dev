<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Section_controller extends CI_Controller {

  public function index() {
    $this->output->set_content_type('application/json');
    die(json_encode(array('status'=>"failure", 'error'=>'UN-Authorized access'), JSON_UNESCAPED_SLASHES));
  }

   public function addsection(){
       $this->output->set_content_type('application/json');
      
        $response=array('status'=>"success",'message'=>"Service Inserted successfully");

        $model = json_decode($this->input->post('model',FALSE));
        
        $model->Issection_show = 1;
        $this->db->insert('manage_section', $model);

        $section_id = $this->db->insert_id();
        $data = array('section_order'=>$section_id);
        $this->db->set($data);
        $this->db->where('id',$section_id);
        $this->db->update('manage_section');

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();       
    }
  public function getdefaultsectionlist()
  {
    $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $html="";
        global $api_path;  
        $model = json_decode($this->input->post('model',FALSE));
        
          $res=$this->db->query("select *,DATE_FORMAT(created_at,'%d/%m/%Y')as cdate from ".$this->db->dbprefix('manage_section')." where  is_deleted=0 AND isdefault=1");
         

        if($res->num_rows()>0)
        {
          foreach($res->result_array() as $key=>$value)
          {               

            $result[]=array('id'=>$value['id'],'website'=>$value['website'],'section'=>$value['section_name'],'description'=>$value['long_desc'],'created_date'=>$value['cdate'],'Issection_show'=>$value['Issection_show']);
          }
        }else{
            $response['status']="failure";
            $response['message']="No Service records found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
  }
  public function getsectionlist()
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
           if($model->websiteSelected){
          $res=$this->db->query("select *,DATE_FORMAT(created_at,'%d/%m/%Y')as cdate from ".$this->db->dbprefix('manage_section')." where created_by='".$model->user_id."' AND website='".$model->websiteSelected."' AND is_deleted=0 AND isdefault=0");
      }else{
        $res=$this->db->query("select *,DATE_FORMAT(created_at,'%d/%m/%Y')as cdate from ".$this->db->dbprefix('manage_section')." where created_by='".$model->user_id."' AND is_deleted=0 AND isdefault=0");
      }
        }
        /*BY all list*/ 
        else{
          $res=$this->db->query("select *,DATE_FORMAT(created_at,'%d/%m/%Y')as cdate from ".$this->db->dbprefix('manage_section')." where  is_deleted=0 AND website='".$model->websiteSelected."' AND isdefault=0");
          // $res=$this->db->select("*,DATE_FORMAT(created_at,'%d/%m/%Y')as cdate")->where('is_deleted','0')->get('manage_section');
        }

        if($res->num_rows()>0)
        {
          foreach($res->result_array() as $key=>$value)
          {               
            $Ischecked = ($value['Issection_show']==1)?true:false;
            $isSectionMenuShow = ($value['isSectionMenuShow']==1)?true:false;
            $result[]=array('id'=>$value['id'],'website'=>$value['website'],'section'=>$value['section_name'],'description'=>$value['long_desc'],'created_date'=>$value['cdate'],'Issection_show'=>$value['Issection_show']);
            $checkdresult[]=array('IsEnable'=>$Ischecked);
            $menucheckedresult[]=array('IsEnable'=>$isSectionMenuShow);
          }
        }else{
            $response['status']="failure";
            $response['message']="No Service records found..";
        }
        $response['result']=$result;
        $response['checkedresult']= $checkdresult;
        $response['menucheckedresult']= $menucheckedresult;
        
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
  }
  public function getsectionlistbyshow()
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
           $res=$this->db->query("select *,DATE_FORMAT(created_at,'%d/%m/%Y')as cdate from ".$this->db->dbprefix('manage_section')." where created_by='".$model->user_id."' AND is_deleted=0 AND Issection_show=1 ORDER BY section_order ASC");
        }
        /*BY all list*/ 
        else{
           $res=$this->db->query("select *,DATE_FORMAT(created_at,'%d/%m/%Y')as cdate from ".$this->db->dbprefix('manage_section')." where Issection_show=1 AND is_deleted=0");
           // $res=$this->db->select("*,DATE_FORMAT(created_at,'%d/%m/%Y')as cdate")->where('is_deleted','0')->get('manage_section');
        }

        if($res->num_rows()>0)
        {
          foreach($res->result_array() as $key=>$value)
          {               

            $result[]=array('id'=>$value['id'],'section'=>$value['section_name'],'isSectionMenuShow'=>$value['isSectionMenuShow'],'section_order'=>$value['section_order']);
          }
        }else{
            $response['status']="failure";
            $response['message']="No Service records found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
  }
  
   public function editsection($id)
    {
        //var_dump($id); die();
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();

        $res=$this->db->query("select * from ".$this->db->dbprefix('manage_section')." where id='".$id."'");

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
  public function updatesection() 
    {
      $this->output->set_content_type('application/json');
      $response=array('status'=>"success");
       $model = json_decode($this->input->post('model',FALSE));
       
        if (isset($model)) 
          {
            $result=$this->db->query("update ".$this->db->dbprefix('manage_section')." set  website='".$model->website."',section_name='".$model->section_name."',long_desc='".$model->long_desc."',Issection_show ='".$model->Issection_show."',section_view='".$model->section_view."' where id='".$model->id."'");

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
    public function deletesection($id)
    {
      $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        

        $res_chk=$this->db->query("select id from ".$this->db->dbprefix('manage_section')." where id='".$id."' ");
        //print_r($res_chk);die;
        if($res_chk->num_rows()>0){

            $data=array('is_deleted'=>'1');
            $this->db->where('id',$id);
            $this->db->update($this->db->dbprefix('manage_section'),$data);

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

   public function uploadcropserviceimage()
   {
    $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $model = json_decode($this->input->post('model',FALSE));
       //print_r($model->IspreviewImage);die;
        /*Converting base 64 image to image file and upload*/
        if($model->IspreviewImage==1)
        {
            if(isset($model->file_name))
        {


        $image_parts = explode(";base64,", $model->file_name);
        define('UPLOAD_DIR', 'section_uploads/');
        $img = $model->file_name;
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $file = UPLOAD_DIR . uniqid() . '.png';
        $success = file_put_contents($file, $data);
        $result = $success ? $file : 'fail';
        
        if($result!='fail')
        {
            $response['status']="success";
            $response['message']="Image upload successfully";
            $response['data']=$file;
        }
        else{
            $response['status']="failure";
            $response['message']="Error while upload on photos";    
        }
      } 
        }
       else{
          $response['status']="fail";
          $response['message']="Error while upload on photos";    
      }
       
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
   }
   public function sectionreordersave()
   {
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $model = json_decode($this->input->post('model',FALSE));

        $id=1;
         foreach($model->orderlist as $key=>$value)
          {               
              $data=array('section_order'=>$id);
              $this->db->where('id', $value->id);
              $this->db->update($this->db->dbprefix('manage_section'),$data);
               // print_r($value->id);
              $id++;
          }
          //die;
      //$this->db->update_batch('manage_section', $model->orderlist, 'id');
       echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
   }
   public function updatesectionbytoggle()
   {
    $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $model = json_decode($this->input->post('model',FALSE));
        // print_r($model);die;
        if($model->default==1)
        {
          $res_chk=$this->db->query("select id from ".$this->db->dbprefix('manage_section')." where id='".$model->secId."' ");
        //print_r($res_chk);die;
        if($res_chk->num_rows()>0){
          
          if(isset($model->Isshow))
          {
            $data['Issection_show']=$model->Isshow;
          }
          
          if(isset($model->Isshowmenu))
          {
            $data['isSectionMenuShow']=$model->Isshowmenu;
          }

        
          $this->db->where('id',$model->secId );
          $this->db->update($this->db->dbprefix('manage_section'),$data);

          $response['status']="success";
          $response['message']="section record has been updated successfully";
            
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";    
        }

        }else{
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
            if($model->Isshowmenu==1)
            {
              $data=array('isSectionMenuShow'=>'1');
            }
            else{
              $data=array('isSectionMenuShow'=>'0');   
            }  
            
            $this->db->where('id',$model->sectionId );
            $this->db->update($this->db->dbprefix('manage_section'),$data);

            $response['status']="success";
            $response['message']="section record has been updated successfully";
            
          }else{
              $response['status']="failure";
              $response['message']="Invalid Attempt!!.. Access denied..";    
          }
        }
        
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
   }

   
}
