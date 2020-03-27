<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Channel_controller extends CI_Controller {

    public function index() {
        $this->output->set_content_type('application/json');
        die(json_encode(array('status'=>"failure", 'error'=>'UN-Authorized access'), JSON_UNESCAPED_SLASHES));
    }

   

    public function addchanneldata()
    {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $response['message']="Channel inserted successfully";

        $model = json_decode($this->input->post('model',FALSE));
        
        //print_r($model);die;
        
        $this->db->insert('tbl_channel', $model);        


        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
    public function getchannellist()
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
           $res=$this->db->query("select *,DATE_FORMAT(created_date,'%d/%m/%Y')as cdate from ".$this->db->dbprefix('tbl_channel')." where created_by='".$model->user_id."' AND is_delete=0");
        }
        /*BY all list*/ 
        else{
           $res=$this->db->select("*,DATE_FORMAT(created_date,'%d/%m/%Y')as cdate")->where('is_delete','0')->get('tbl_channel');
        }

        $result= $res->result_array();
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    }
  
  public function get_chatusers_detail()
  {
     $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $html="";
        global $api_path;        

        // $res=$this->db->select("Id,username")->where('is_deleted','0')->get('affiliateuser');

        $model = json_decode($this->input->post('model',FALSE));    
        $username = trim($model->currentUsername);
        if(isset($model->currentUsername)){
            $res=$this->db->select("*")->where(['is_deleted'=>'0','referedby'=>$username])->get('affiliateuser');    
        }
        
        if($res->num_rows()>0)
        {
          foreach($res->result_array() as $key=>$value)
          {               
            $result[]=array('Id'=>$value['Id'],'username'=>$value['username']);
          }
        }else{
            $response['status']="failure";
            $response['message']="No User records found..";
        }
   
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    

  }
 
   public function uploadchannelimage()
   {
      $this->output->set_content_type('application/json');
        $response=array();
        //$response['status']="success";
        $model = json_decode($this->input->post('model',FALSE));
        //print_r($model);die;
        /*Converting base 64 image to image file and upload*/
        if(isset($model->profileImage))
        {
          $image_parts = explode(";base64,", $model->profileImage);
          define('UPLOAD_DIR', 'channeluploads/');
          $img1 = $model->profileImage;
          $img1 = str_replace('data:image/png;base64,', '', $img1);
          $img1 = str_replace(' ', '+', $img1);
          $data1 = base64_decode($img1);
          $file1 = UPLOAD_DIR . uniqid() . '.png';
          $success = file_put_contents($file1, $data1);
          $result = $success ? $file : 'fail';
          
        if($result!='fail')
        {
           // $response['profile']=['status'=>"success",'file'=>$file1];
            $response[]=array('profile_image'=>1,'file'=>$file1);
        }
        else{
            $response['status']="failure";
            $response['message']="Profile Image Error";    
        }
      }

       if(isset($model->bannerImage))
        {
          $image_parts = explode(";base64,", $model->bannerImage);
          define('UPLOAD_DIR', 'channelbanneruploads/');
          $img = $model->bannerImage;
          $img = str_replace('data:image/png;base64,', '', $img);
          $img = str_replace(' ', '+', $img);
          $data = base64_decode($img);
          $file = UPLOAD_DIR . uniqid() . '.png';
          $success = file_put_contents($file, $data);
          $result = $success ? $file : 'fail';
          
        if($result!='fail')
        {
            $response[]=array('banner_image'=>1,'file'=>$file);
        }
        else{
            $response['status']="failure";
            $response['message']="Error upload on photos";    
        }
      }
     
       
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
   }
   public function editchannel($id)
    {
        //var_dump($id); die();
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();

        $res=$this->db->query("select * from ".$this->db->dbprefix('tbl_channel')." where id='".$id."'");

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
    public function updatechanneldata() 
    {
      $this->output->set_content_type('application/json');
      $response=array('status'=>"success");
       $model = json_decode($this->input->post('model',FALSE));
        if (isset($model)) 
          {
            $result=$this->db->query("update ".$this->db->dbprefix('tbl_channel')." set  website='".$model->website."',channel_name='".$model->channel_name."',channel_profile_img='".$model->channel_profile_img."',channel_banner_img='".$model->channel_banner_img."',about_channel='".$model->about_channel."',channel_url='".$model->channel_url."',videos_count='".$model->videos_count."',total_followers='".$model->total_followers."',comments ='".$model->comments."',created_by='".$model->created_by."' where id='".$model->id."'");

            if ($result) {
                $response['message']="Channel has been updated successfully";
            }
            else
            {
              $response['status']="failure";
              $response['message']="Channel has not been updated";
            }
        } 
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }
     public function deletechanneldata($id)
    {
      $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $res_chk=$this->db->query("select id from ".$this->db->dbprefix('tbl_channel')." where id='".$id."' ");
        //print_r($res_chk->num_rows());die;
        if($res_chk->num_rows()>0){

            $data=array('is_delete'=>'1');
            $this->db->where('id',$id);
            $this->db->update($this->db->dbprefix('tbl_channel'),$data);

            $response['status']="success";
            $response['message']="Channel record has been deleted successfully";
            
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";    
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    }
}
