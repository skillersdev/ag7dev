<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_controller extends CI_Controller {

	public function index() {
		$this->output->set_content_type('application/json');
		die(json_encode(array('status'=>"failure", 'error'=>'UN-Authorized access'), JSON_UNESCAPED_SLASHES));
	}

   public function add_user_master(){
       $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $response['message']="User inserted successfully";

        $model = json_decode($this->input->post('model',FALSE));

        date_default_timezone_set('Asia/Kolkata');
        
        $model->doj = date("Y-m-d H:i:s");
        
        $this->db->insert('affiliateuser', $model);

        if(isset($model->user_type)&&($model->user_type==2))
        {
          $last_inserted_user_id = $this->db->insert_id();
          $package_id =isset($model->pcktaken)?$model->pcktaken:0;
          $this->db->query("insert into ".$this->db->dbprefix('user_vs_packages')." (user_id,package_id) values('".$last_inserted_user_id."','".$package_id."')");
        }


        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
    public function add_user_ad(){
       $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $response['message']="Ad inserted successfully";

        $model = json_decode($this->input->post('model',FALSE));

        
        $this->db->insert('user_advertisements', $model);
       

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
    
  
  public function get_users_detail()
  {
     $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $html="";
        global $api_path;        

        $res=$this->db->select("id,username,password,fname,address,email,referedby,mobile,active,DATE_FORMAT(doj,'%d/%m/%Y')as doj,country,tamount,payment,signupcode,level,pcktaken,launch,getpayment,renew,iba_status,user_type,DATE_FORMAT(expiry,'%d/%m/%Y')as expiry")->where('is_deleted','0')->get('affiliateuser');


        if($res->num_rows()>0)
        {
          foreach($res->result_array() as $key=>$value)
          {               
            $status=($value['active']=='0')?'Active':'Inactive';
            $result[]=array('id'=>$value['id'],'username'=>$value['username'],'password'=>$value['password'],'fname'=>$value['fname'],'address'=>$value['address'],'email'=>$value['email'],'referedby'=>$value['referedby'],'mobile'=>$value['mobile'],'active'=>$status,'doj'=>$value['doj'],'country'=>$value['country'],'tamount'=>$value['tamount'],'payment'=>$value['payment'],'signupcode'=>$value['signupcode'],'level'=>$value['level'],'pcktaken'=>$value['pcktaken'],'launch'=>$value['launch'],'getpayment'=>$value['getpayment'],'renew'=>$value['renew'],'iba_status'=>$value['iba_status'],'user_type'=>$value['user_type'],'created_date'=>$value['expiry'],'status'=>$value['active']);
          }
        }else{
            $response['status']="failure";
            $response['message']="No User records found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    

  }
  public function check_user_exist(){
    $model = json_decode($this->input->post('model',FALSE));
    //print_r($model->username);die;   
    $response['exist']=0;
    $username = trim($model->username);
    if(isset($model->Id)){
        $res=$this->db->select("username")->like('username',$username)->where(['is_deleted'=>'0','id!='=>$model->Id])->get('affiliateuser');    
    }
    else{
        $res=$this->db->select("username")->like('username',$username)->where('is_deleted','0')->get('affiliateuser');
    }

    if(count($res->result_array())>0)
    {
       
        $response['exist']=1;
        $response['message']="User name already exists";
    }
    echo json_encode($response,JSON_UNESCAPED_SLASHES);
    die();
  }

  public function check_user_credit(){
    $model = json_decode($this->input->post('model',FALSE));
    $user_id = trim($model->user_id);
    $share_amount_from_user = $model->share_amt;
    $res=$this->db->select("username,tamount,pcktaken")->like('id',$user_id)->where(['is_deleted'=>'0'])->get('affiliateuser');    
    

    if(count($res->result_array())>0)
    {
        $data =$res->result_array();  
        $response['total_amount']=$data[0]['tamount'];
        $curret_user_name=$data[0]['username'];

        /*Check Maximum trasnfer*/
        $package_id=$data[0]['pcktaken'];  
        $pack_det=$this->db->select("maximum_transfer")->like('id',$package_id)->where(['is_deleted'=>'0'])->get('package_info');
        if(count($pack_det->result_array())>0)
        { 
            $pck_data =$pack_det->result_array(); 

            $response['maximum_transfer']=$pck_data[0]['maximum_transfer']; 

            $current_user_transfer_det=$this->db->select_sum("amt")->like('transfer_from',$curret_user_name)->get('transfer_history'); 
            $trasnfer_data = $current_user_transfer_det->result_array();

            $total_transfer_amount = ($trasnfer_data[0]['amt']!='')?$trasnfer_data[0]['amt']:0;

            if($total_transfer_amount>=$response['maximum_transfer'])
            {
                $response['status']=1;
                $response['message']="Already Exceeded your maximum transfer";
                echo json_encode($response,JSON_UNESCAPED_SLASHES);
                die();
            }
            else if($share_amount_from_user>$response['maximum_transfer'])
            {
                $response['status']=1;
                $response['message']="Share amount should not greater than maximum transfer amount";
                echo json_encode($response,JSON_UNESCAPED_SLASHES);
                die();
            }
        }

        /**/
    }
    echo json_encode($response,JSON_UNESCAPED_SLASHES);
    die();
  }
  
   public function edituser($id)
    {
        //var_dump($id); die();
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();

            $res=$this->db->query("select * from ".$this->db->dbprefix('affiliateuser')." where id='".$id."'");

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
  public function updateuser() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

       // print_r($model);die();

        if (isset($model)) {
        
            $this->db->where('id',$model->Id);
            $result=$this->db->update('affiliateuser', $model);
          //  pr($this->db->last_query());die();

            if ($result) {
                $response['message']="User has been updated successfully";
            }
            else
            {
                 $response['status']="failure";
            $response['message']="User has not been updated fully";
            }
            

        } else {
            $response['status']="failure";
            $response['message']="Choose User and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }
    public function updateuserprofile()
    {
       $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

       // print_r($model);die();

        if (isset($model)) {
        
            $this->db->where('id',$model->Id);
            $result=$this->db->update('affiliateuser', $model);
          //  pr($this->db->last_query());die();

            if ($result) {
                $response['message']="Profile has been updated successfully";
            }
            else
            {
                $response['status']="failure";
                $response['message']="Profile has not been updated fully";
            }
            

        } else {
            $response['status']="failure";
            $response['message']="Enter valid details and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES)); 
    }
    public function updatepassword()
    {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $model = json_decode($this->input->post('model',FALSE));
        if (isset($model)) {
        
            $this->db->where('id',$model->id);
            $result=$this->db->update('affiliateuser', $model);
            if ($result) {
                $response['message']="Password has been updated successfully";
            }
            else
            {
                $response['status']="failure";
                $response['message']="Password has not been updated fully";
            }
            

        } else {
            $response['status']="failure";
            $response['message']="Enter valid Password and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES)); 
    }
    public function deleteuser($id)
    {
      $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        

        $res_chk=$this->db->query("select id from ".$this->db->dbprefix('affiliateuser')." where id='".$id."' ");
        
        if($res_chk->num_rows()>0){

            $data=array('is_deleted'=>'1');
            $this->db->where('id',$id);
            $this->db->update($this->db->dbprefix('affiliateuser'),$data);

            $response['status']="success";
            $response['message']="User record has been deleted successfully";
            
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";    
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    }
    public function uploadAdvfile()
    {
        $path = 'user_adv_uploads/';
        $Response=[];
       
        if (isset($_FILES['file'])) 
          {
            $originalName = $_FILES['file']['name'];
            $ext = '.'.pathinfo($originalName, PATHINFO_EXTENSION);
            // print_r($ext);die;
            if($ext==".img"||$ext==".jpg"||$ext==".jpeg"||$ext==".png" ||$ext==".mp4" )
            {

              $generatedName = md5($_FILES['file']['tmp_name']).$ext;

              $filePath = $path.$generatedName;
              $product_image=$filePath;
           
              if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) 
              {
                $Response['status']="success"; 
                $Response['data']=$product_image;
              }
            }
            else 
            {
                $Response['status']="fail"; 
                $Response['data']="Not a valid format";
            }
          }
        else {
            $Response['status']="fail"; 
            $Response['data']="Error While upload on image";
         }
          echo json_encode($Response,JSON_UNESCAPED_SLASHES);
         die();
    }
    public function uploadimage()
    {
       $path = 'user_profile/';
        $Response=[];
     
        if (isset($_FILES['file'])) 
          {
            $originalName = $_FILES['file']['name'];
            $ext = '.'.pathinfo($originalName, PATHINFO_EXTENSION);
             
            if($ext==".img"||$ext==".jpg"||$ext==".jpeg"||$ext==".png")
            {

              $generatedName = md5($_FILES['file']['tmp_name']).$ext;

              $filePath = $path.$generatedName;
              $product_image=$filePath;
           
              if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) 
              {
                $Response['status']="success"; 
                $Response['data']=$product_image;
              }
            }
            else 
            {
                $Response['status']="fail"; 
                $Response['data']="Upload only valid format images";
            }
          }
        else {
            $Response['status']="fail"; 
            $Response['data']="Error While upload on image";
         }
          echo json_encode($Response,JSON_UNESCAPED_SLASHES);
         die();
    }

    public function resetpassword()
    {
        $model = json_decode($this->input->post('model',FALSE));
   
        $response['exist']=0;
        $email = trim($model->email);
   
        $res=$this->db->select("*")->like(array('email'=>$email))->where(['is_deleted'=>'0'])->get('affiliateuser');  
        if(count($res->result_array())>0)
        {
           
            $user_det = $res->result_array();
            $password = $user_det[0]['password'];

            // $config = Array(
            //     'protocol' => 'mail',
            //     'smtp_host' => 'ssl://smtp.googlemail.com',
            //     'smtp_port' => 587,
            //     'smtp_user' => 'my mail',
            //     'smtp_pass' => 'my password',
            //     'smtp_crypto'=>'tls'
            //     'mailtype'  => 'html', 
            //     'wordwrap'  => TRUE;
            //     'charset'   => 'iso-8859-1'
            // );

            // $this->load->library('email',$config);
            // $this->email->from('admin@gmail.com', 'admin');
            // $this->email->to('mr.mani99@gmail.com');
             
            // $this->email->subject('Your Password is:'.$password);
            // $this->email->message('Testing the email class.');
            // if($this->email->send()) 
            // {
            //     $response['exist']=1;
            //     $response['message']="Password sent to your mail id"; 
            // }
            
        
            
            
        }
        else{
             $response['result']=array();
            $response['exist']=0;
            $response['message']="Email id is not an registered";
        }

    echo json_encode($response,JSON_UNESCAPED_SLASHES);
    die();
    }
     public function get_user_ad()
    {
     $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $html="";
        global $api_path;        

        $res=$this->db->select("*,DATE_FORMAT(created_at,'%d/%m/%Y')as created_at")->where('is_deleted','0')->get('user_advertisements');


        if($res->num_rows()>0)
        {
          foreach($res->result_array() as $key=>$value)
          {               
            $user_det=$this->db->select("username")->where(['is_deleted'=>'0','id'=>$value['user_id']])->get('affiliateuser'); 
            $data =$user_det->result_array();  

            $value['user_id']=$data[0]['username']; 

            $result[]=array('id'=>$value['id'],'website'=>$value['url'],
              'created_at'=>$value['created_at'],'created_by'=>$value['user_id']);
          }
        }else{
            $response['status']="failure";
            $response['message']="No User records found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    

    }
    public function editad($id)
    {
        //var_dump($id); die();
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();

            $res=$this->db->query("select * from ".$this->db->dbprefix('user_advertisements')." where id='".$id."'");

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
    public function updatead() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

       // print_r($model);die();

        if (isset($model)) {
        
            $this->db->where('id',$model->id);
            $result=$this->db->update('user_advertisements', $model);
          //  pr($this->db->last_query());die();

            if ($result) {
                $response['message']="Advertisements has been updated successfully";
            }
            else
            {
                 $response['status']="failure";
            $response['message']="Advertisements has not been updated fully";
            }
            

        } else {
            $response['status']="failure";
            $response['message']="Choose Advertisements and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }
     public function deletead($id)
    {
      $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        

        $res_chk=$this->db->query("select id from ".$this->db->dbprefix('user_advertisements')." where id='".$id."' ");
        
        if($res_chk->num_rows()>0){

            $data=array('is_deleted'=>'1');
            $this->db->where('id',$id);
            $this->db->update($this->db->dbprefix('user_advertisements'),$data);

            $response['status']="success";
            $response['message']="Advertisement record has been deleted successfully";
            
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";    
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    }
  
}