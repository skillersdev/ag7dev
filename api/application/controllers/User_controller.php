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

        
        $this->db->insert('affiliateuser', $model);

        if($model->user_type==2)
        {
          $last_inserted_user_id = $this->db->insert_id();
          $package_id =isset($model->pcktaken)?$model->pcktaken:0;
          $this->db->query("insert into ".$this->db->dbprefix('user_vs_packages')." (user_id,package_id) values('".$last_inserted_user_id."','".$package_id."')");
        }


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

        $res=$this->db->select("id,username,password,fname,address,email,referedby,mobile,active,DATE_FORMAT(doj,'%d/%m/%Y%r')as doj,country,tamount,payment,signupcode,level,pcktaken,launch,getpayment,renew,iba_status,user_type,DATE_FORMAT(expiry,'%d/%m/%Y%r')as expiry")->where('is_deleted','0')->get('affiliateuser');


        if($res->num_rows()>0)
        {
          foreach($res->result_array() as $key=>$value)
          {               
            $status=($value['active']=='0')?'Active':'Inactive';
            $result[]=array('id'=>$value['id'],'username'=>$value['username'],'password'=>$value['password'],'fname'=>$value['fname'],'address'=>$value['address'],'email'=>$value['email'],'referedby'=>$value['referedby'],'mobile'=>$value['mobile'],'active'=>$status,'doj'=>$value['doj'],'country'=>$value['country'],'tamount'=>$value['tamount'],'payment'=>$value['payment'],'signupcode'=>$value['signupcode'],'level'=>$value['level'],'pcktaken'=>$value['pcktaken'],'launch'=>$value['launch'],'getpayment'=>$value['getpayment'],'renew'=>$value['renew'],'iba_status'=>$value['iba_status'],'user_type'=>$value['user_type'],'created_date'=>$value['expiry']);
          }
        }else{
            $response['status']="failure";
            $response['message']="No User records found..";
        }
        $response['result']=$result;
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

  
}
