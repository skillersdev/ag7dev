<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Videosection_controller extends CI_Controller {

	public function index() {
		$this->output->set_content_type('application/json');
		die(json_encode(array('status'=>"failure", 'error'=>'UN-Authorized access'), JSON_UNESCAPED_SLASHES));
	}

   public function addvideosection(){
        $this->output->set_content_type('application/json');
      
        $response=array('status'=>"success",'message'=>"Data Inserted successfully");

        $model = json_decode($this->input->post('model',FALSE));
        // print_r($model);die;
        unset($model->channelWebsite);
        unset($model->Iswebsite);

        //unset($model->tags);
        $model->tags = implode (", ", $model->tags);
       //print_r($model->tags);die;
        //unset($model->taglist);
        $this->db->insert('video_sections', $model);

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
    
    public function uploadvideoswebsite()
    {
       $path = 'videosection/';
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
     public function addvideopreview()   
    {
       $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $model = json_decode($this->input->post('model',FALSE));
//print_r($model);die;
        /*Converting base 64 image to image file and upload*/
        if(isset($model->Imagefile))
        {


        $image_parts = explode(";base64,", $model->Imagefile);
        define('UPLOAD_DIR', 'videosection/');
        $img = $model->Imagefile;
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
       
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
         }
    }
  
  public function getvideolistbyuser()
  {
     $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $html="";
        global $api_path;       

        $model = json_decode($this->input->post('model',FALSE));
        if($model->usergroup==2)
        {
           $res=$this->db->select("*,DATE_FORMAT(created_date,'%d/%m/%Y')as cdate")->where(['is_deleted'=>'0','created_by'=>$model->userid])->get('video_sections');

        }
        else{
          $res=$this->db->select("*,DATE_FORMAT(created_date,'%d/%m/%Y')as cdate")->where(['is_deleted'=>'0'])->get('video_sections');
        }

       

        if($res->num_rows()>0)
        {
          foreach($res->result_array() as $key=>$value)
          { 

            $result[]=array('id'=>$value['id'],'title'=>$value['title'],'description'=>$value['description'],'video_file'=>$value['video_file'],'preview_image'=>$value['preview_image'],'website_name'=>$value['website_name'],'created_date'=>$value['cdate']);
          }
        }else{
            $response['status']="failure";
            $response['message']="No User records found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    

  }
  
   public function editvideodata($id)
    {
        //var_dump($id); die();
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();

        $res=$this->db->query("select * from ".$this->db->dbprefix('video_sections')." where id='".$id."'");
       
       
        
        if($res->num_rows()>0){
            $in_array=$res->result_array();
            $in_array[0]['tags_list'] = explode(',', $in_array[0]['tags']);
            $result['video_det']=$in_array[0];
        }else{
            $response['status']="failure";
            $response['message']=" No Package record found!!";
        }
        $response['result']=$result;

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
  public function updatevideodata() {
         $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));
        if (isset($model)) {
            $this->db->where('id',$model->id);
             //unset($model->tags);
             
            $model->tags = implode (",", $model->tags_list);
            //print_r($model->tags);die;
            // $model->tags = array_map($model->tags);
            
            //unset($model->tags_list);
            $result=$this->db->update('video_sections', $model);
            if ($result) {
                $response['message']="Video has been updated successfully";
            }
            else
            {
                 $response['status']="failure";
            $response['message']="video has not been updated fully";
            }
        } else {
            $response['status']="failure";
            $response['message']="Choose User and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }
    public function deletevideosection($id)
    {
      $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        

        $res_chk=$this->db->query("select id from ".$this->db->dbprefix('video_sections')." where id='".$id."' ");
        //print_r($res_chk);die;
        if($res_chk->num_rows()>0){

            $data=array('is_deleted'=>'1');
            $this->db->where('id',$id);
            $this->db->update($this->db->dbprefix('video_sections'),$data);

            $response['status']="success";
            $response['message']="Data has been deleted successfully";
            
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";    
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    }
    
    public function searchvideoresult()
    {
      $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $html="";
        global $api_path;       

        $model = json_decode($this->input->post('model',FALSE));
       
        // $res=$this->db->select("*,DATE_FORMAT(created_date,'%d/%m/%Y')as cdate")->where(['is_deleted'=>'0'])->like('title',$model->searchword)->get('video_sections');

          $res=$this->db->query("select *,DATE_FORMAT(created_date,'%d/%m/%Y')as cdate from ".$this->db->dbprefix('video_sections')." WHERE  is_deleted='0' AND title='".$model->searchword."' OR FIND_IN_SET('".$model->searchword."',tags)");
    //   echo "select *,DATE_FORMAT(created_date,'%d/%m/%Y')as cdate from ".$this->db->dbprefix('video_sections')." WHERE  is_deleted='0' AND title='".$model->searchword."' OR tags REGEXP CONCAT('(^|,)(', REPLACE('".$model->searchword."', ',', '|'), ')(,|$)')";die;

        if($res->num_rows()>0)
        {
          foreach($res->result_array() as $key=>$value)
          { 

            $result[]=array('id'=>$value['id'],'title'=>$value['title'],'description'=>$value['description'],'video_file'=>$value['video_file'],'preview_image'=>$value['preview_image'],'website_name'=>$value['website_name'],'created_date'=>$value['created_date'],'total_views'=>$value['total_views'],'tags'=>$value['tags']);
          }
        }else{
            $response['status']="failure";
            $response['message']="No User records found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    }

}
