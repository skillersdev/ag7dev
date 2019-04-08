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

        if($this->db->insert('transfer_history', $model))
        {
            $total_amt=$this->db->select("id,tamount")->like('username',$model->transfer_from)->where('is_deleted','0')->get('affiliateuser');
             if(count($total_amt->result_array())>0)
                {
                    $data_amt=$total_amt->result_array();
                    $tot_amt=$data_amt[0]['tamount'];
                    $user_id = $data_amt[0]['id'];
                }
                $final_tot = $tot_amt - $model->amt;

                 $data=array('tamount'=>$final_tot);
                $this->db->where('id',$user_id);
                $this->db->update($this->db->dbprefix('affiliateuser'),$data);
                $response=array('status'=>"success",'message'=>"Amount shared successfully");
        }
       // print_r($model);die;

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
  
  
  
}