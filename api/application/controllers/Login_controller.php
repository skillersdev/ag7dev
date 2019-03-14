<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_controller extends CI_Controller {

	public function index() {
		$this->output->set_content_type('application/json');
		die(json_encode(array('status'=>"failure", 'error'=>'UN-Authorized access'), JSON_UNESCAPED_SLASHES));
	}

  
  public function checklogin(){
    $model = json_decode($this->input->post('model',FALSE));
   
    $response['exist']=0;
    $username = trim($model->user_name);
    $password = trim($model->user_password);
   
        $res=$this->db->select("*")->like(array('username'=>$username,'password'=>$password))->where(['is_deleted'=>'0'])->get('affiliateuser');  
    if(count($res->result_array())>0)
    {
       foreach($res->result_array() as $key=>$value)
          {               
            $status=($value['active']=='0')?'Active':'Inactive';
            $result[]=array('id'=>$value['Id'],'username'=>$value['username'],'password'=>$value['password'],'fname'=>$value['fname'],'address'=>$value['address'],'email'=>$value['email'],'referedby'=>$value['referedby'],'mobile'=>$value['mobile'],'active'=>$status,'doj'=>$value['doj'],'country'=>$value['country'],'tamount'=>$value['tamount'],'payment'=>$value['payment'],'signupcode'=>$value['signupcode'],'level'=>$value['level'],'pcktaken'=>$value['pcktaken'],'launch'=>$value['launch'],'getpayment'=>$value['getpayment'],'renew'=>$value['renew'],'iba_status'=>$value['iba_status'],'user_type'=>$value['user_type'],'created_date'=>$value['expiry'],'status'=>$value['active']);
          }
        $get_user_id=$res->result_array();

        


        $response['result']=$result;
        $response['exist']=1;
        $response['message']="login successfully";
    }
    else{
         $response['result']=array();
        $response['exist']=0;
        $response['message']="Enter valid user credentials";
    }
    echo json_encode($response,JSON_UNESCAPED_SLASHES);
    die(); 
  }
  
  public function check_user_package($id)
  {
      /*Check whether user has been activated any packages or not*/
      
      $pack_det=$this->db->select("*")->where(['user_id'=>$id])->where("(package_status='0' OR package_status='2')")->get('user_vs_packages'); 
      //print_r(count($pack_det->result_array()));die;
      if(count($pack_det->result_array())==0)
      {
        $response['result']=$pack_det->result_array();
        $response['exist']=2;
        $response['message']="No package activated";
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
      } 

      /**/
  }
   

  
}
