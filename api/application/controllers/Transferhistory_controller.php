<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transferhistory_controller extends CI_Controller {

	public function index() {
		$this->output->set_content_type('application/json');
		die(json_encode(array('status'=>"failure", 'error'=>'UN-Authorized access'), JSON_UNESCAPED_SLASHES));
	}

   public function add_transfer_history(){
       $this->output->set_content_type('application/json');
        $tot_amt=0;
        

        $model = json_decode($this->input->post('model',FALSE));
       $model->voucher_type = $model->type;
       unset($model->type);

        if($this->db->insert('transfer_history', $model))
        {
            $total_amt=$this->db->select("id,tamount,eamount")->where(['is_deleted'=>'0','username'=>$model->transfer_from])->get('affiliateuser');
            
             if(count($total_amt->result_array())>0)
                {
                    $data_amt=$total_amt->result_array();
                    $tot_amt=($model->voucher_type==1)?$data_amt[0]['tamount']:$data_amt[0]['eamount'];
                    
                    $user_id = $data_amt[0]['id'];
                }
                $final_tot= $tot_amt-$model->amt;
                if($model->voucher_type==1)
                {
                    $data=array('tamount'=>$final_tot);    
                }else{
                    $data=array('eamount'=>$final_tot);    
                }
                
                $this->db->where('id',$user_id);
                $this->db->update($this->db->dbprefix('affiliateuser'),$data);

                $user_share_to=$this->db->select("id,tamount,eamount")->where(['is_deleted'=>'0','username'=>$model->transfer_to])->get('affiliateuser');
                if(count($user_share_to->result_array())>0)
                {
                    $share_to_det=$user_share_to->result_array();
                    if($model->voucher_type==1)
                    {
                        $share_to=array('tamount'=>$model->amt+$share_to_det[0]['tamount']);    
                    }else{
                        $share_to=array('eamount'=>$model->amt+$share_to_det[0]['eamount']);    
                    }
                    
                    $this->db->where('id',$share_to_det[0]['id']);
                    $this->db->update($this->db->dbprefix('affiliateuser'),$share_to);
                }

                $response=array('status'=>"success",'message'=>"Amount shared successfully");
        }
       // print_r($model);die;

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
  
   public function gettransferlist()
  {
     $model = json_decode($this->input->post('model',FALSE));    
        $username = trim($model->currentUsername);
        if(isset($model->currentUsername)){
            //$res=$this->db->select("*")->like('transfer_from',$username)->get('transfer_history');   
            $res=$this->db->query("select * from ".$this->db->dbprefix('transfer_history')." where transfer_to LIKE '".$username."'"); 
        }
       
       $response=[];

        if(count($res->result_array())>0)
        {
          // $data = $res->result_array();
            $result=[];

             foreach($res->result_array() as $key=>$value)
              { 
                //$value['username']=$data[0]['username']; 
                $voucher_type = ($value['voucher_type']==1)?'Website':'E-Learning';
                $result[]=array('transfer_from'=>$value['transfer_from'],'transfer_to'=>$value['transfer_to'],'amt'=>$value['amt'],'voucher_type'=>$voucher_type);
              }
            //$response['message']="User name already exists";
        }
		if($result !=""){
				echo json_encode($result,JSON_UNESCAPED_SLASHES);
		}
        
        die();
  }
  
}
