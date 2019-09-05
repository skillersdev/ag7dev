<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Videosection_controller extends CI_Controller {

	public function index() {
		$this->output->set_content_type('application/json');
		die(json_encode(array('status'=>"failure", 'error'=>'UN-Authorized access'), JSON_UNESCAPED_SLASHES));
	}

   public function addvideosection(){
        $this->output->set_content_type('application/json');
      
        $response=array('status'=>"success",'message'=>"Gallery Inserted successfully");

        $model = json_decode($this->input->post('model',FALSE));
        
//print_r($model);die;
        
        $this->db->insert('video_sections', $model);

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
    
    public function uploadvideoswebsite()
    {
       $path = 'videosection/';
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
  
   public function editalbum($id)
    {
        //var_dump($id); die();
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();

        $res=$this->db->query("select * from ".$this->db->dbprefix('album_master')." where id='".$id."'");
        $photo_res=$this->db->query("select * from ".$this->db->dbprefix('album_photos')." where album_id='".$id."' AND is_deleted=0");
       // $gallery_array=
        $gallery_details = $photo_res->result_array();
        $gal_array=[];
        foreach ($gallery_details as $key => $value)
        {
          $filename_photo=substr($value['photos'], strpos($value['photos'], "/") + 1);
          $ext = '.'.pathinfo($filename_photo, PATHINFO_EXTENSION);

          $video_format =  array('.mp4','.3gp','.3gp2','.3g2','.3gpp','.3gpp2','.wmv','.wma','.asf','.AVI','flv');
          $audio_format =  array('.mp4','.mp3','.aac','.ogg','.wma');

          if(in_array($ext,$video_format)) {
             $type = "video";
          }
          else if(in_array($ext,$audio_format)){
            $type = "audio";
          }
          else{
            $type="image";
          }

          $gal_array[]=array('id'=>$value['id'],'album_id'=>$value['album_id'],'website'=>$value['website'],'photos'=>$value['photos'],'created_date'=>$value['created_date'],'fileName'=>$filename_photo,'ext'=>$ext,'type'=>$type);
        }
        $result['gallery_det'] = $gal_array;
        if($res->num_rows()>0){
            $in_array=$res->result_array();
            $result['album_det']=$in_array[0];
        }else{
            $response['status']="failure";
            $response['message']=" No Package record found!!";
        }
        $response['result']=$result;

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
  public function updatealbum() {
         $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));
        if (isset($model)) {
            $this->db->where('id',$model->id);
            $result=$this->db->update('album_master', $model);
            if ($result) {
                $response['message']="Album has been updated successfully";
            }
            else
            {
                 $response['status']="failure";
            $response['message']="Album has not been updated fully";
            }
        } else {
            $response['status']="failure";
            $response['message']="Choose User and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }
    public function deletealbum($id)
    {
      $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        

        $res_chk=$this->db->query("select id from ".$this->db->dbprefix('album_master')." where id='".$id."' ");
        //print_r($res_chk);die;
        if($res_chk->num_rows()>0){

            $data=array('is_deleted'=>'1');
            $this->db->where('id',$id);
            $this->db->update($this->db->dbprefix('album_master'),$data);

            $response['status']="success";
            $response['message']="Album record has been deleted successfully";
            
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";    
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    }
  

}
