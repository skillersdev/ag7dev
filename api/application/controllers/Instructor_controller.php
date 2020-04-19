<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Instructor_controller extends CI_Controller {

	public function index() {
		$this->output->set_content_type('application/json');
		die(json_encode(array('status'=>"failure", 'error'=>'UN-Authorized access'), JSON_UNESCAPED_SLASHES));
	}
	
  public function check_user_credit(){
    $model = json_decode($this->input->post('model',FALSE));
    //print_r($model);die;
    $user_name = $model[0]->username;
    $share_amount_from_user = $model[0]->package_amt;
    
    $res=$this->db->select("Id,username,tamount,pcktaken,eamount")->where(['is_deleted'=>'0','username'=>$user_name])->get('affiliateuser'); 
    
    
    if(count($res->result_array())>0)
    {
        $data =$res->result_array();  
        if($model[0]->package_amt<=$data[0]['eamount'])
        {
            /* Update eamount with subtract of package amount */
                $user_model->eamount = $data[0]['eamount'] - $model[0]->package_amt;
                $this->db->where('Id',$data[0]['Id']);
                $result=$this->db->update('affiliateuser', $user_model);
            /******/
            
            /*set as instructor status from student*/
                $new_model->user_type = 1;
                $this->db->where('id',$model[0]->elaernuser);
                $result=$this->db->update('elearn_users', $new_model);
            /********/    
            
            /**Transaction log*/
            $elaern_user_get=
            $this->db->select("*")->where(['id'=>$model[0]->elaernuser])->get('elearn_users');
            $elaern_data =$elaern_user_get->result_array(); 
            
            $this->db->query("insert into ".$this->db->dbprefix('elearn_transaction')." 
                (transaction_amount,account_to_activated,account_from_activated) values('".$model[0]->package_amt."','".$elaern_data[0]['email']."','".$user_name."')");
            /*******/
            $response['status']=1;
            $response['message']="Successfully activated!!.Now you can add a course online";
        }else{
            $response['status']=0;
             $response['message']="Insufficient e-learning voucher to activate this package";
        }

       echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
   
  }
  
   
}
