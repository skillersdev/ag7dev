<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paymentinfo_controller extends CI_Controller {

	public function index() {
		$this->output->set_content_type('application/json');
		die(json_encode(array('status'=>"failure", 'error'=>'UN-Authorized access'), JSON_UNESCAPED_SLASHES));
	}

   public function get_payment_details($id)
    {
        //var_dump($id); die();
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $package=array();
        $res=$this->db->query("select * from ".$this->db->dbprefix('paypalpayments')." where orderid='".$id."'");



            if($res->num_rows()>0){
                $in_array=$res->result_array();

                foreach ($in_array as $key => $value) 
                {
                    $res1=$this->db->query("select * from ".$this->db->dbprefix('package_info')." where id='".$value['pckid']."'");
                    $in_array_1=$res1->result_array(); 

                    $package['package_taken'] = $in_array_1[0]['package_name'];

                    $package['package_price'] = $value['price'];

                    $package['payment_type']=$value['transacid']=='R.V'?'Voucher':'Paypal';

                    $package['paid_amount'] = $value['price'];

                    $package['paid_on'] = $value['date']; 
                    
                    $payme_by=$this->db->select("fname")->where(['id'=>$value['orderid']])->get('affiliateuser');
                    $user_det=$payme_by->result_array();

                    $package['payment_by'] = $user_det[0]['fname'];
                    array_push($result,$package);
                    
                }
                
            }else{
                $response['status']="failure";
                $response['message']=" No record found!!";
            }
            $response['result']=$result;

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }  
    public function get_all_payment_details()
    {
        //var_dump($id); die();
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $package=array();
        $res=$this->db->query("select * from ".$this->db->dbprefix('paypalpayments')."");



            if($res->num_rows()>0){
                $in_array=$res->result_array();

                foreach ($in_array as $key => $value) 
                {
                    $res1=$this->db->query("select * from ".$this->db->dbprefix('package_info')." where id='".$value['pckid']."'");
                    $in_array_1=$res1->result_array(); 

                    $package['package_taken'] = $in_array_1[0]['package_name'];

                    $package['package_price'] = $value['price'];

                    $package['payment_type']=$value['transacid']=='R.V'?'Voucher':'Paypal';

                    $package['paid_amount'] = $value['price'];

                    $package['paid_on'] = $value['date']; 
                    
                    $payme_by=$this->db->select("fname")->where(['id'=>$value['orderid']])->get('affiliateuser');
                    $user_det=$payme_by->result_array();

                    $package['payment_by'] = $user_det[0]['fname'];
                    array_push($result,$package);
                    
                }
                
            }else{
                $response['status']="failure";
                $response['message']=" No record found!!";
            }
            $response['result']=$result;

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
}
