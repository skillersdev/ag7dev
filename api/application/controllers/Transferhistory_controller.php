<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transferhistory_controller extends CI_Controller {

	public function index() {
		$this->output->set_content_type('application/json');
		die(json_encode(array('status'=>"failure", 'error'=>'UN-Authorized access'), JSON_UNESCAPED_SLASHES));
	}

//    public function add_transfer_history(){
//        $this->output->set_content_type('application/json');
//         $tot_amt=0;
        

//         $model = json_decode($this->input->post('model',FALSE));
//        $model->voucher_type = $model->type;
//        unset($model->type);

//         if($this->db->insert('transfer_history', $model))
//         {
//             $total_amt=$this->db->select("id,tamount,eamount")->where(['is_deleted'=>'0','username'=>$model->transfer_from])->get('affiliateuser');
            
//              if(count($total_amt->result_array())>0)
//                 {
//                     $data_amt=$total_amt->result_array();
//                     $tot_amt=($model->voucher_type==1)?$data_amt[0]['tamount']:$data_amt[0]['eamount'];
                    
//                     $user_id = $data_amt[0]['id'];
//                 }
//                 $final_tot= $tot_amt-$model->amt;
//                 if($model->voucher_type==1)
//                 {
//                     $data=array('tamount'=>$final_tot);    
//                 }else{
//                     $data=array('eamount'=>$final_tot);    
//                 }
                
//                 $this->db->where('id',$user_id);
//                 $this->db->update($this->db->dbprefix('affiliateuser'),$data);

//                 $user_share_to=$this->db->select("id,tamount,eamount")->where(['is_deleted'=>'0','username'=>$model->transfer_to])->get('affiliateuser');
//                 if(count($user_share_to->result_array())>0)
//                 {
//                     $share_to_det=$user_share_to->result_array();
//                     if($model->voucher_type==1)
//                     {
//                         $share_to=array('tamount'=>$model->amt+$share_to_det[0]['tamount']);    
//                     }else{
//                         $share_to=array('eamount'=>$model->amt+$share_to_det[0]['eamount']);    
//                     }
                    
//                     $this->db->where('id',$share_to_det[0]['id']);
//                     $this->db->update($this->db->dbprefix('affiliateuser'),$share_to);
//                 }

//                 $response=array('status'=>"success",'message'=>"Amount shared successfully");
//         }
//        // print_r($model);die;

//         echo json_encode($response,JSON_UNESCAPED_SLASHES);
//         die();
//     }
  
public function add_transfer_history(){
    $this->output->set_content_type('application/json');
     $tot_amt=0;
     

     $model = json_decode($this->input->post('model',FALSE));
    $model->voucher_type = $model->type;
    unset($model->type);
    
     $instructorModel->transfer_from = $model->transfer_from;
     $instructorModel->transfer_to = $model->transfer_to;
     $instructorModel->amt = $model->amt;
     
    
   // print_r($this->input->post('model',FALSE));
     $insertTransferHistory=$this->db->insert('transfer_history', $instructorModel);
  
  
     if($insertTransferHistory)
     {
         $total_amt=$this->db->select("id,tamount,eamount")->where(['is_deleted'=>'0','username'=>$model->transfer_from])->get('affiliateuser');
         
          if(count($total_amt->result_array())>0)
             {
                 $data_amt=$total_amt->result_array();
                 $tot_amt=($model->voucher_type==2)?$data_amt[0]['eamount']:$data_amt[0]['tamount'];
                 
                 $user_id = $data_amt[0]['id'];
             }
             $final_tot= $tot_amt-$model->amt;
             if($model->voucher_type==2)
             {
                 $data=array('eamount'=>$final_tot);    
             }else{
                 $data=array('tamount'=>$final_tot);    
             }
             
             $this->db->where('id',$user_id);
             $this->db->update($this->db->dbprefix('affiliateuser'),$data);

             $user_share_to=$this->db->select("id,tamount,eamount")->where(['is_deleted'=>'0','username'=>$model->transfer_to])->get('affiliateuser');
             if(count($user_share_to->result_array())>0)
             {
                 $share_to_det=$user_share_to->result_array();
                 if($model->voucher_type==2)
                 {
                     $share_to=array('eamount'=>$model->amt+$share_to_det[0]['eamount']);    
                 }else{
                     $share_to=array('tamount'=>$model->amt+$share_to_det[0]['tamount']);    
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



  public function addtransfervoucher(){
        $this->output->set_content_type('application/json');
        $tot_amt=0;
        $instructorModel=new stdClass;
        $model = json_decode($this->input->post('model',FALSE));
        $instructorModel->voucher_type = $model->shareType; 
        $voucher_type=$model->shareType; 
        $instructorModel->transfer_from = $model->transfer_from;
        $instructorModel->transfer_to = $model->transfer_to;
        $instructorModel->amt = $model->amt;   
        // print_r($this->input->post('model',FALSE));
        $insertTransferHistory=$this->db->insert('transfer_history', $instructorModel);
        if($insertTransferHistory)
        {
            //{"user_id":"10308","shareType":"7","share_amt":"10","transfer_to":"omid","transfer_from":"sridhar","amt":"10"}

            $total_amt=$this->db->select("*")->where(['is_deleted'=>'0','username'=>$model->transfer_from])->get('affiliateuser');
         
            if(count($total_amt->result_array())>0)
             {
                 $data_amt=$total_amt->result_array();

                 switch ($voucher_type) {
                    case '1': //Entrepreneur
                        $tot_amt=$data_amt[0]['tamount'];
                        $final_tot= $tot_amt-$model->amt;
                        $data=array('tamount'=>$final_tot); 
                      break;
                    case '2': //Entrepreneur Renewal
                      $tot_amt=$data_amt[0]['tamount_renewal'];
                      $final_tot= $tot_amt-$model->amt;
                      $data=array('tamount_renewal'=>$final_tot); 
                      break;
                    case '3': //Instructor
                      $tot_amt=$data_amt[0]['instructor_amount'];
                      $final_tot= $tot_amt-$model->amt;
                      $data=array('instructor_amount'=>$final_tot); 
                      break;    
                    case '4': //Instructor Renewal
                      $tot_amt=$data_amt[0]['instructor_amount_renewal'];
                      $final_tot= $tot_amt-$model->amt;
                      $data=array('instructor_amount_renewal'=>$final_tot); 
                      break;
                    case '5': //Student
                      $tot_amt=$data_amt[0]['eamount'];
                      $final_tot= $tot_amt-$model->amt;
                      $data=array('eamount'=>$final_tot); 
                      break;
                    case '6': //Student Renewal
                      $tot_amt=$data_amt[0]['eamount_renewal'];
                      $final_tot= $tot_amt-$model->amt;
                      $data=array('eamount_renewal'=>$final_tot); 
                      break;  
                    case '7': //Personal
                      $tot_amt=$data_amt[0]['pw_amount'];
                      $final_tot= $tot_amt-$model->amt;
                      $data=array('pw_amount'=>$final_tot); 
                      break;  
                    case '8': //Personal Renewal
                      $tot_amt=$data_amt[0]['pw_amount_renewal'];
                      $final_tot= $tot_amt-$model->amt;
                      $data=array('pw_amount_renewal'=>$final_tot); 
                      break;
                    case '9': //Business
                      $tot_amt=$data_amt[0]['bw_amount'];
                      $final_tot= $tot_amt-$model->amt;
                      $data=array('bw_amount'=>$final_tot); 
                      break;
                    case '10': //Business Renewal
                        $tot_amt=$data_amt[0]['bw_amount_renewal'];
                        $final_tot= $tot_amt-$model->amt;
                        $data=array('bw_amount_renewal'=>$final_tot); 
                        break;  
                    case '11': //Mall
                      $tot_amt=$data_amt[0]['mall_amount'];
                      $final_tot= $tot_amt-$model->amt;
                      $data=array('mall_amount'=>$final_tot); 
                      break;
                    case '12': //Mall Renewal
                      $tot_amt=$data_amt[0]['mall_amount_renewal'];
                      $final_tot= $tot_amt-$model->amt;
                      $data=array('mall_amount_renewal'=>$final_tot); 
                      break;
                    case '13': //Floor
                      $tot_amt=$data_amt[0]['floor_amount'];
                      $final_tot= $tot_amt-$model->amt;
                      $data=array('floor_amount'=>$final_tot); 
                      break;  
                    case '14': //Floor Renewal
                      $tot_amt=$data_amt[0]['floor_amount_renewal'];
                      $final_tot= $tot_amt-$model->amt;
                      $data=array('floor_amount_renewal'=>$final_tot); 
                      break;
                    case '15': //Shop
                      $tot_amt=$data_amt[0]['shop_amount'];
                      $final_tot= $tot_amt-$model->amt;
                      $data=array('shop_amount'=>$final_tot); 
                      break;    
                    case '16': //Shop Renewal
                      $tot_amt=$data_amt[0]['shop_amount_renewal'];
                      $final_tot= $tot_amt-$model->amt;
                      $data=array('shop_amount_renewal'=>$final_tot); 
                      break;  
                    default:
                      $tot_amt=0;
                      $final_tot= 0;
                      break;
                  }
                 $user_id = $data_amt[0]['Id'];
             }
            
            if($data!="" && $user_id!="")
            {
                $this->db->where('Id',$user_id);
                $this->db->update($this->db->dbprefix('affiliateuser'),$data);    
            }
            $user_share_to=$this->db->select("*")->where(['is_deleted'=>'0','username'=>$model->transfer_to])->get('affiliateuser');
            if(count($user_share_to->result_array())>0)
            {
                $share_to_det=$user_share_to->result_array();
                // print_r($share_to_det); exit;
                switch ($voucher_type) {
                    case '1': //Entrepreneur
                        $share_to=array('tamount'=>$model->amt+$share_to_det[0]['tamount']);
                      break;
                    case '2': //Entrepreneur Renewal
                      $share_to=array('tamount_renewal'=>$model->amt+$share_to_det[0]['tamount_renewal']); 
                      break;
                    case '3': //Instructor
                      $share_to=array('instructor_amount'=>$model->amt+$share_to_det[0]['instructor_amount']);
                      break;    
                    case '4': //Instructor Renewal
                      $share_to=array('instructor_amount_renewal'=>$model->amt+$share_to_det[0]['instructor_amount_renewal']); 
                      break;
                    case '5': //Student
                      $share_to=array('eamount'=>$model->amt+$share_to_det[0]['eamount']);
                      break;
                    case '6': //Student Renewal
                      $share_to=array('eamount_renewal'=>$model->amt+$share_to_det[0]['eamount_renewal']);
                      break;  
                    case '7': //Personal
                      $share_to=array('pw_amount'=>$model->amt+$share_to_det[0]['pw_amount']);
                      break;  
                    case '8': //Personal Renewal
                      $share_to=array('pw_amount_renewal'=>$model->amt+$share_to_det[0]['pw_amount_renewal']); 
                      break;
                    case '9': //Business
                      $share_to=array('bw_amount'=>$model->amt+$share_to_det[0]['bw_amount']);
                      break;
                    case '10': //Business Renewal
                        $share_to=array('bw_amount_renewal'=>$model->amt+$share_to_det[0]['bw_amount_renewal']); 
                        break;  
                    case '11': //Mall
                      $share_to=array('mall_amount'=>$model->amt+$share_to_det[0]['mall_amount']);
                      break;
                    case '12': //Mall Renewal
                      $share_to=array('mall_amount_renewal'=>$model->amt+$share_to_det[0]['mall_amount_renewal']); 
                      break;
                    case '13': //Floor
                      $share_to=array('floor_amount'=>$model->amt+$share_to_det[0]['floor_amount']); 
                      break;  
                    case '14': //Floor Renewal
                      $share_to=array('floor_amount_renewal'=>$model->amt+$share_to_det[0]['floor_amount_renewal']); 
                      break;
                    case '15': //Shop
                      $share_to=array('shop_amount'=>$model->amt+$share_to_det[0]['shop_amount']);
                      break;    
                    case '16': //Shop Renewal
                      $share_to=array('shop_amount_renewal'=>$model->amt+$share_to_det[0]['shop_amount_renewal']); 
                      break;  
                    default:
                      $tot_amt=0;
                      $final_tot= 0;
                      break;
                  }

                  if($share_to){
                    $this->db->where('Id',$share_to_det[0]['Id']);
                    $this->db->update($this->db->dbprefix('affiliateuser'),$share_to);
                  }
                 

            }
        }

        $response=array('status'=>"success",'message'=>"Amount shared successfully");
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
     }

  
}






