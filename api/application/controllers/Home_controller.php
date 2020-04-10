<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_controller extends CI_Controller {

  public function index() {
    $this->output->set_content_type('application/json');
    die(json_encode(array('status'=>"failure", 'error'=>'UN-Authorized access'), JSON_UNESCAPED_SLASHES));
  }

    
  public function getrvideolist()
  {
     $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $html="";
        global $api_path;       

        $model = json_decode($this->input->post('model',FALSE));
       
        
          $res=$this->db->select("*,DATE_FORMAT(created_date,'%d/%m/%Y')as cdate")->where(['is_deleted'=>'0','videocategory'=>'1'])->get('video_sections');
       

        if($res->num_rows()>0)
        {
          foreach($res->result_array() as $key=>$value)
          { 
            $userData=$this->db->select("*")->where(['is_deleted'=>'0','id'=>$value['created_by']])->get('affiliateuser'); 
            $user_array=$userData->result_array();
        
            //$result[$key]['username'] = $user_array[0]['username'];      
            
            $result[]=array('id'=>$value['id'],'title'=>$value['title'],'description'=>$value['description'],'video_file'=>$value['video_file'],'preview_image'=>$value['preview_image'],'website_name'=>$value['website_name'],'created_date'=>$value['cdate'],'username'=>$user_array[0]['username']);
          }
        }else{
            $response['status']="failure";
            $response['message']="No User records found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    

  }
 public function editvideodetail($id)
    {
        //var_dump($id); die();
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();

        // $res=$this->db->query("select * from ".$this->db->dbprefix('video_sections')." where id='".$id."'");
        
        $today =date("Y-m-d");
    $ip_address = $_SERVER['REMOTE_ADDR'];
    
        $check_view=$this->db->query("select * from ".$this->db->dbprefix('video_sections')." where date(view_updated_date)='".$today."' AND ip_address='".$ip_address."' AND id='".$id."'");
        
        if($check_view->num_rows()==0)
    {
        $update_channel_data=$this->db->query("select * from ".$this->db->dbprefix('video_sections')." where id='".$id."'");
        
         $channel_data=$update_channel_data->result_array();
       
         
        $data=array('total_views'=>$channel_data[0]['total_views']+1,'ip_address'=>$ip_address,'view_updated_date'=>$today);
            $this->db->where('id',$id);
            $this->db->update($this->db->dbprefix('video_sections'),$data);
    }else{
        $update_channel_data=$this->db->query("select * from ".$this->db->dbprefix('tbl_channel')." where website='".$model->currentwebsite."' AND channel_name='".$model->currentchannel."' ");
        
         //$channel_data=$update_channel_data->result_array();
    }
    
    $res=$this->db->query("select * from ".$this->db->dbprefix('video_sections')." where  id='".$id."'");
        
        if($res->num_rows()>0){
            $in_array=$res->result_array();
            $result['video_det']=$in_array[0];
        }else{
            $response['status']="failure";
            $response['message']=" No Package record found!!";
        }
        $response['result']=$result;

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }

}
