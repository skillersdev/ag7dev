<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Home_controller extends CI_Controller {

    public function index() {
        $this->output->set_content_type('application/json');
        die(json_encode(array('status'=>"failure", 'error'=>'UN-Authorized access'), JSON_UNESCAPED_SLASHES));
    }

  public function getpremiumpackagesettings()
    {
       $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $html="";
        global $api_path;       
    
        $model = json_decode($this->input->post('model',FALSE));
       
        
        $res=$this->db->select("*,DATE_FORMAT(created_date,'%d/%m/%Y')as cdate")->where(['is_deleted'=>'0'])->get('premium_package_settings');
        
        if($res->num_rows()>0)
        {
          foreach($res->result_array() as $key=>$value)
          { 
                $userData=$this->db->select("*")->where(['is_deleted'=>'0','id'=>$value['created_by']])->get('affiliateuser'); 
                $user_array=$userData->result_array();
           
                $result[]=array('id'=>$value['id'],'premium_days'=>$value['no_of_days'],'premium_amount'=>$value['total_amount'],'created_date'=>$value['cdate'],'created_by'=>$user_array[0]['username']);
          }
        }else{
            $response['status']="failure";
            $response['message']="No User records found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
   }
   public function getpremiumrequestvideos()
   {
       $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $html="";
        global $api_path;       

        $model = json_decode($this->input->post('model',FALSE));
       
        
      $res=$this->db->select("*,DATE_FORMAT(created_date,'%d %b %Y')as cdate")->where(['is_deleted'=>'0','is_premium_videos'=>'1'])->order_by('id')->get('video_sections');
      
       if($res->num_rows()>0)
        {
        $result[]=$res->result_array();
        }
        $response['data'] = $result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
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
       
        
          $res=$this->db->select("*,DATE_FORMAT(created_date,'%d %b %Y')as cdate")->where(['is_deleted'=>'0','videocategory'=>'1'])->order_by('id', 'RANDOM')->get('video_sections');
       

        if($res->num_rows()>0)
        {
          foreach($res->result_array() as $key=>$value)
          { 
            $userData=$this->db->select("*")->where(['is_deleted'=>'0','id'=>$value['created_by']])->get('affiliateuser'); 
            $user_array=$userData->result_array();
        
            //$result[$key]['username'] = $user_array[0]['username'];      
            if($value['Is_premium_videos']==0)
            {
                 $result['videos'][]=array('id'=>$value['id'],'title'=>$value['title'],'description'=>$value['description'],'video_file'=>$value['video_file'],'preview_image'=>$value['preview_image'],'website_name'=>$value['website_name'],'created_date'=>$value['cdate'],'username'=>$user_array[0]['username'],'total_views'=>$value['total_views'],'tags'=>$value['tags']);
            }else{
                 $result['premium_videos'][]=array('id'=>$value['id'],'title'=>$value['title'],'description'=>$value['description'],'video_file'=>$value['video_file'],'preview_image'=>$value['preview_image'],'website_name'=>$value['website_name'],'created_date'=>$value['cdate'],'username'=>$user_array[0]['username'],'total_views'=>$value['total_views'],'tags'=>$value['tags']);
            }
           
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
    public function likevideodetail($id)
    {
        //var_dump($id); die();
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();

       
        
        $today =date("Y-m-d");
        $ip_address = $_SERVER['REMOTE_ADDR'];
        
        $check_view=$this->db->query("select * from ".$this->db->dbprefix('video_sections')." where date(like_update_date)='".$today."' AND ip_address='".$ip_address."' AND id='".$id."'");
        
        if($check_view->num_rows()==0)
        {
          $update_channel_data=$this->db->query("select * from ".$this->db->dbprefix('video_sections')." where id='".$id."'");
          
           $channel_data=$update_channel_data->result_array();
         
           
            $data=array('total_likes'=>$channel_data[0]['total_likes']+1,'ip_address'=>$ip_address,'like_update_date'=>$today);
            $this->db->where('id',$id);
            $this->db->update($this->db->dbprefix('video_sections'),$data);
            $response['likes'] = $channel_data[0]['total_likes']+1;
        }
        else{
            $response['status']="failure";
            $response['message']="Like not updated!!";
        }
       

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
    public function addpremiumpackage()
    {
         $this->output->set_content_type('application/json');
      
        $response=array('status'=>"success",'message'=>"Package Inserted successfully");

        $model = json_decode($this->input->post('model',FALSE));
        
        $this->db->insert('premium_package_settings', $model);

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();    
    }
    public function deletepremiumpackage($id)
    {
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        

        $res_chk=$this->db->query("select id from ".$this->db->dbprefix('premium_package_settings')." where id='".$id."' ");
        //print_r($res_chk);die;
        if($res_chk->num_rows()>0){

            $data=array('is_deleted'=>'1');
            $this->db->where('id',$id);
            $this->db->update($this->db->dbprefix('premium_package_settings'),$data);

            $response['status']="success";
            $response['message']="Premium record has been deleted successfully";
            
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";    
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    }
     public function editpremium($id)
    {
        //var_dump($id); die();
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();


            $res=$this->db->query("select * from ".$this->db->dbprefix('premium_package_settings')." where id='".$id."'");

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
    public function updatepremium()
    {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
           
        $model = json_decode($this->input->post('model',FALSE));
        
        if (isset($model)) {
            
              $result=$this->db->query("update ".$this->db->dbprefix('premium_package_settings')." set no_of_days='".$model->no_of_days."',total_amount ='".$model->total_amount."' where id='".$model->id."'");

            if ($result) {
                $response['message']="Package setting has been updated successfully";
            }
            else
            {
                 $response['status']="failure";
            $response['message']="Package setting has not been updated fully";
            }
            

        } else {
            $response['status']="failure";
            $response['message']="Choose Service and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }
    public function checkpremiumuserandbalanceexist()
    {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
           
        $model = json_decode($this->input->post('model',FALSE));
        
       // print_r($model);die;
        
        $check_exists=$this->db->select("*")->where(['is_deleted'=>'0','username'=>$model->username])->get('affiliateuser');  
        if($check_exists->num_rows()==0)
        {
            $response=array('status'=>"fail");
            $response['message']="Enter a valid creator name";
        }else{
           
                foreach($check_exists->result_array() as $key=>$value)
                {
                    if($value['tamount']<$model->premiumamount)
                    {
                         $response=array('status'=>"fail",'message'=>"Premium Amount should not be more than user amount");
                    }
                }  
             
        }
         die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }
    public function savepremiumdata()
    {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
           
        $model = json_decode($this->input->post('model',FALSE));
        
         $check_exists=$this->db->select("*")->where(['is_deleted'=>'0','username'=>$model->username])->get('affiliateuser'); 
         foreach($check_exists->result_array() as $key=>$value)
            {
                $tot_amount = $value['tamount'] - $model->premiumamount;
                $data_user=array('tamount'=>$tot_amount);
                $this->db->where('Id',$value['Id']);
                $this->db->update($this->db->dbprefix('affiliateuser'),$data_user);
                
                $date = date("Y-m-d");
                $date = strtotime($date);
                $date = strtotime("".$model->selectedPremiumdays." day", $date);
                $expire_premium_days = date('Y-m-d', $date);
                
                 $transaction_data = array(
                        'premium_video'=>$model->videoId,
                        'premium_activated_to'=>$model->current_userid,
                        'premium_activated_from'=>$value['Id'],
                        'premium_amount'=>$model->premiumamount
                    );
                //print_r($transaction_data);die;        
                $this->db->insert($this->db->dbprefix('premium_transaction_details'),$transaction_data);
                
                $data=array('Is_premium_videos'=>'1','premium_expires_in'=>$expire_premium_days);
                $this->db->where('id',$model->videoId);
                $this->db->update($this->db->dbprefix('video_sections'),$data);
                
                $response['status']="success";
                $response['message']="Your video is upgraded to premium";
            }  
         
         die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    public function savepremiumrequest()
    {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
           
        $model = json_decode($this->input->post('model',FALSE));
        if($model->Isaccept==1)
        {
            $data=array('Is_premium_videos'=>'1'); 
             $response['message']="video is upgraded to premium";
        }
        else{
            $data=array('Is_premium_videos'=>'0');  
             $response['message']="Upgrade to premium is cancelled";
        }
        $this->db->where('id',$model->videoId);
        $this->db->update($this->db->dbprefix('video_sections'),$data);
        
        $response['status']="success";
       
         die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }
    
    public function getpremiumtransactiondetails()
    {
        $this->output->set_content_type('application/json');
        $response=array();
        $response=array('status'=>"success");
        $model = json_decode($this->input->post('model',FALSE));
        $result=[];
        $get_transaction_det=$this->db->select("*")->where(['id'=>$model->videoId])->get('premium_transaction_details'); 
        
       foreach($get_transaction_det->result_array() as $key=>$value)
        {
             $get_user_premiunm_video_activated = $this->db->select("username")->where(['is_deleted'=>'0','Id'=>$value['premium_activated_to']])->get('affiliateuser'); 
             $user_array_1=$get_user_premiunm_video_activated->result_array();
             
            
             
             $get_user_premiunm_video_activated_from = $this->db->select("username")->where(['is_deleted'=>'0','Id'=>$model->userid])->get('affiliateuser'); 
             $user_array_2=$get_user_premiunm_video_activated_from->result_array();
             
              
             $video_det = $this->db->select("title")->where(['is_deleted'=>'0','Id'=>$value['premium_video']])->get('video_sections'); 
             $video_details=$video_det->result_array();
             
             $result['data'][]=array('premium_video'=>$video_details[0]['title'],'premium_video_user'=>$user_array_1[0]['username'],'premium_activated_from'=>$user_array_2[0]['username'],'premium_amount'=>$value['premium_amount']);
        }
       // $response['result']=$result;
         echo json_encode($result,JSON_UNESCAPED_SLASHES);
         die();
         
    }

}
