<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common_controller extends CI_Controller {
	public function index() {
		$this->output->set_content_type('application/json');
		die(json_encode(array('status'=>"failure", 'error'=>'UN-Authorized access'), JSON_UNESCAPED_SLASHES));
	}

	public function getCountrylist(){
		$model = json_decode($this->input->post('model',FALSE));

     	$res=$this->db->select("*")->where(['flag'=>'1'])->get('countries'); 
     	$result=array();
     	 if($res->num_rows()>0)
        {
          foreach($res->result_array() as $key=>$value)
          {               
         
            $result[]=array('countryId'=>$value['id'],'countryName'=>$value['name']);
          }
        }else{
            $response['status']="failure";
            $response['message']="No countries found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
	}
  public function getcurrencylist(){
    $model = json_decode($this->input->post('model',FALSE));

      $res=$this->db->select("*")->get('currency'); 
      $result=array();
       if($res->num_rows()>0)
        {
          foreach($res->result_array() as $key=>$value)
          {               
         
            $result[]=array('id'=>$value['id'],'currencyName'=>$value['name']);
          }
        }else{
            $response['status']="failure";
            $response['message']="No currency found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
  }
  
	public function getStatelist($Countryid){
		 $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();

        $res=$this->db->query("select * from ".$this->db->dbprefix('states')." where country_id='".$Countryid."'");
         if($res->num_rows()>0){
          foreach($res->result_array() as $key=>$value)
          {               
         
            $result[]=array('stateId'=>$value['id'],'stateName'=>$value['name']);
          }
        }else{
            $response['status']="failure";
            $response['message']=" No States found!!";
        }
        $response['result']=$result;

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
	}
	public function getCitieslist($Stateid){
		 $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();

        $res=$this->db->query("select * from ".$this->db->dbprefix('cities')." where state_id='".$Stateid."'");
         if($res->num_rows()>0){
          foreach($res->result_array() as $key=>$value)
          {               
         
            $result[]=array('cityId'=>$value['id'],'cityName'=>$value['name']);
          }
        }else{
            $response['status']="failure";
            $response['message']=" No City found!!";
        }
        $response['result']=$result;

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
	}
	
   public function renewPackVoucher(){
        $model = json_decode($this->input->post('model',FALSE));
        $tableIsexist =0;
        /*Check user is existed or not*/
        if($model->Trasnferusername){
          /*Check Pay via type
            --Enterprenur value as 1
            --Mall user as 2
            --no pay through selected by default set as affilate user
          */
            if(isset($model->paythrough)){
              if($model->paythrough==1){
                  $res=$this->db->select("username,mall_amount,mall_amount_renewal,floor_amount_renewal,shop_amount_renewal,id")->where(['is_deleted'=>'0','username'=>$model->Trasnferusername,'password'=>$model->Trasnferpassword])->get('affiliateuser');
              }else{
                switch ($model->type) {
                    case 6:
                          $res=$this->db->select("username,mall_amount,mall_amount_renewal,id")->where(['is_deleted'=>'0','username'=>$model->Trasnferusername,'password'=>$model->Trasnferpassword])->get('mall_master');
                          $tableIsexist = 1;
                        break;
                     case 7:
                        $res=$this->db->select("username,floor_amount,floor_amount_renewal,id")->where(['is_deleted'=>'0','username'=>$model->Trasnferusername,'password'=>$model->Trasnferpassword])->get('floor_master');
                        $tableIsexist = 1;
                        break;
                     case 8:
                        $res=$this->db->select("username,shop_amount,shop_amount_renewal,id")->where(['is_deleted'=>'0','username'=>$model->Trasnferusername,'password'=>$model->Trasnferpassword])->get('shop_master');
                        $tableIsexist = 1;
                    break;
                    default:
                        echo "Bar\n";
                        break;
                }
                  
              }
            }
        }
        /*User exist*/
       
        if(count($res->result_array())>0){
          $userDetails = $res->result_array();
          if($model->type==6){
            $this->renewVoucher($tableIsexist,$model,$userDetails,'mall_amount_renewal','mall_master','Mall ME');
            $this->updateMallItems($model,$userDetails,$model->current_mallId,'Mall details','mall_id','Mall');
          }
          else if($model->type==7){
            $this->renewVoucher($tableIsexist,$model,$userDetails,'floor_amount_renewal','floor_master','Floor ME');
            $this->updateMallItems($model,$userDetails,$model->current_floorId,'floor Details','floor_id','Floor');
          }
           else if($model->type==8){
            $this->renewVoucher($tableIsexist,$model,$userDetails,'shop_amount_renewal','shop_master','Shop ME');
            $this->updateMallItems($model,$userDetails,$model->current_shopId,'shop Details','shop_id','Shop');
          }

        }else{
           $response['exist']=1;
           $response['status']="Error";
           $response['message']="Enter valid user credentials";
        }

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
   }
   public function renewVoucher($tableIsexist,$model,$userDetails,$column_amt,$table_name,$msg){
     /*Updation on mall master table*/ 
            
            if($tableIsexist==1){ 
              if($model->pack_price > $userDetails[0][$column_amt]) {
                 $response['exist']=1;
                 $response['status']="Error";
                 $response['message']="User have Insufficient ".$msg;
                   echo json_encode($response,JSON_UNESCAPED_SLASHES);
                    die();
              } else{
                
                 $balanceamt = $userDetails[0][$column_amt] - $model->pack_price; 
                  $data=array($column_amt=>$balanceamt);
                  $this->db->where('id',$userDetails[0]['id']);
                  $this->db->update($this->db->dbprefix($table_name),$data);
                 
              } 
            }
            /*Updation on affilate master table*/ 
            else{
              
               if($model->pack_price>$userDetails[0][$column_amt]) {
                 $response['exist']=1;
                 $response['status']="Error";
                 $response['message']="User have Insufficient ".$msg;
                  echo json_encode($response,JSON_UNESCAPED_SLASHES);
                  die();
              } else{

                 $balanceamt = $userDetails[0][$column_amt] - $model->pack_price; 


                  $data=array($column_amt=>$balanceamt);

                  $this->db->where('id',$userDetails[0]['id']);
                  $this->db->update($this->db->dbprefix('affiliateuser'),$data);
                  
              } 
            }
   }
   public function updateMallItems($model,$userDetails,$tableId,$msg,$typeId,$ren_msg)
   {
        /*Mall has been renewed*/
          $current_date=date("Y-m-d H:i:s");
              
          /*Check validaity of package*/
            $val_res=$this->db->select("validity,DATE_FORMAT(cdate,'%Y-%m-%d')as cdate")->where('is_deleted','0')->where('id',$model->package_id)->get('packages');

             if(count($val_res->result_array())>0){
                $detls = $val_res->result_array() ; 

                $renew_date = date('Y-m-d', strtotime($detls[0]['validity']."days", strtotime($current_date)));  
             }else{
              $renew_date = date('Y-m-d', strtotime("10 days", strtotime($current_date))); 
             }
           /*End*/

           /*Update Mall details in user vs package*/
               $data=array('renew_date'=>$renew_date,'package_status'=>0);
                $this->db->where($typeId,$tableId);
                $this->db->update($this->db->dbprefix('user_vs_packages'),$data);

               $response['exist']=2;
                $response['status']="Success";
               $response['message']=$ren_msg." Renewed successfully";
               echo json_encode($response,JSON_UNESCAPED_SLASHES);
                die();
            /**End**/
    }
   
   public function sendcontactdetails(){
       $this->output->set_content_type('application/json');
      
        $response=array('status'=>"success",'message'=>"Mail sent successfully");
        $tableIsexist = 0;
        $model = json_decode($this->input->post('model',FALSE));


         $to = $model->email;
         $subject = "SHop request";
         $message = $model->message;
         $headers = "From: remote.skillers@gmail.com" . "\r\n" .
         "CC: support@3abc7.com";

         //SMTP Configuration
         $host = "mail.3abc7.com";
         $port = "465";
         $username = "support@3abc7.com";
         $password = "3abc7123!@#";

        //Sending the email
         if(mail($to, $subject, $message, $headers)) {
             $response['exist']=1;
            $response['status']="Success";
            $response['message']=" Mail sent successfully";
         } else {
              $response['exist']=2;
            $response['status']="Fail";
            $response['message']=" Error while on sent mail";
         }
                
           echo json_encode($response,JSON_UNESCAPED_SLASHES);
          die();
    }
}
?>