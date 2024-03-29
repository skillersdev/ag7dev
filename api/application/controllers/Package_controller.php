<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Package_controller extends CI_Controller {

  public function index() {
    $this->output->set_content_type('application/json');
    die(json_encode(array('status'=>"failure", 'error'=>'UN-Authorized access'), JSON_UNESCAPED_SLASHES));
  }

   public function add_package_master(){
       $this->output->set_content_type('application/json');
      
        $response=array('status'=>"success",'message'=>"Package Inserted successfully");

        $model = json_decode($this->input->post('model',FALSE));

       // $array = json_encode($model->stage_bonus_amount);
        $inc=1;
        foreach ($model->stage_bonus_data as $key => $value) 
        {
           $level_columnn[]="level".$inc;
           $level_value[]="'".$value."'";
           $stage_column[]="stage".$inc."_up";
           $stage_column_value[]="'".$model->stage_upgradation_data[$key]."'";
           $inc++;
        }

        $level_field=implode(',', $level_columnn);
        $level_field_value=implode(',', $level_value);
        $stage_field_column=implode(',',$stage_column);
        $stage_field_value=implode(',',$stage_column_value);
        //$this->db->insert('package_info', $model);
        $this->db->query("insert into ".$this->db->dbprefix('packages')." (name,pck_type,price,currency,details,tax,sbonus,minimum_voucher,maximum_transfer,cdate,active,".$level_field.",".$stage_field_column.",validity,indirect_ref_amt,pay_via_voucher) values (
                '".$model->package_name."',
                '".$model->pck_type."',
                '".$model->package_price."',
                '".$model->currency."',
                '".$model->package_details."',
                '".$model->package_tax."',
                '".$model->sign_up_bonus."',
                '".$model->minimum_voucher."',
                '".$model->maximum_transfer."',
                NOW(),
                '1',
                ".$level_field_value.",
                ".$stage_field_value.",
                ".$model->validity.",
                '".$model->indirect_ref_amount."','".$model->pay_via_voucher."')");

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
  public function getpackagebyinstructor()
  {
      $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $html="";
        global $api_path;        

        $res=$this->db->select("*,DATE_FORMAT(cdate,'%Y-%m-%d')as cdate")->where('is_deleted','0')->where('pck_type','3')->get('packages');


        if($res->num_rows()>0)
        {
          foreach($res->result_array() as $key=>$value)
          {             
          
            $renew_date = date('Y-m-d', strtotime($value['validity']."days", strtotime($value['cdate']))); 

            $result[]=array('id'=>$value['id'],'package_name'=>$value['name'],'package_price'=>$value['price'],'currency'=>$value['currency'],'pay_via_voucher'=>$value['pay_via_voucher'],'sign_up_bonus'=>$value['sbonus'],'maximum_transfer'=>$value['maximum_transfer'],'package_details'=>$value['details'],'package_tax'=>$value['tax'],'indirect_ref_amount'=>$value['indirect_ref_amt'],'minimum_voucher'=>$value['minimum_voucher'],'created_date'=>$value['cdate'],'validity'=>$renew_date);


          }
        }else{
            $response['status']="failure";
            $response['message']="No User records found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    
  }
  public function get_package_list()
  {
     $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $html="";
        global $api_path;        

        $res=$this->db->select("*,DATE_FORMAT(cdate,'%Y-%m-%d')as cdate")->where('is_deleted','0')
        ->where('pck_type != ',3,FALSE)
        ->where('pck_type != ',2,FALSE)
        ->where('pck_type != ',6,FALSE)
        ->where('pck_type != ',7,FALSE)
        ->where('pck_type != ',8,FALSE)
        ->get('packages');


        if($res->num_rows()>0)
        {
          foreach($res->result_array() as $key=>$value)
          {             
          
            $renew_date = date('Y-m-d', strtotime($value['validity']."days", strtotime($value['cdate']))); 

            $result[]=array('id'=>$value['id'],'package_name'=>$value['name'],'pck_type'=>$value['pck_type'],'package_price'=>$value['price'],'currency'=>$value['currency'],'pay_via_voucher'=>$value['pay_via_voucher'],'sign_up_bonus'=>$value['sbonus'],'maximum_transfer'=>$value['maximum_transfer'],'package_details'=>$value['details'],'package_tax'=>$value['tax'],'indirect_ref_amount'=>$value['indirect_ref_amt'],'minimum_voucher'=>$value['minimum_voucher'],'created_date'=>$value['cdate'],'validity'=>$renew_date);


          }
        }else{
            $response['status']="failure";
            $response['message']="No User records found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    

  }
  
  public function get_package_list_by_admin()
  {
     $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $html="";
        global $api_path;        

        $res=$this->db->select("*,DATE_FORMAT(cdate,'%Y-%m-%d')as cdate")->where('is_deleted','0')->get('packages');


        if($res->num_rows()>0)
        {
          foreach($res->result_array() as $key=>$value)
          {             
          
            $renew_date = date('Y-m-d', strtotime($value['validity']."days", strtotime($value['cdate']))); 

            $result[]=array('id'=>$value['id'],'package_name'=>$value['name'],'package_price'=>$value['price'],'currency'=>$value['currency'],'pay_via_voucher'=>$value['pay_via_voucher'],'sign_up_bonus'=>$value['sbonus'],'maximum_transfer'=>$value['maximum_transfer'],'package_details'=>$value['details'],'package_tax'=>$value['tax'],'indirect_ref_amount'=>$value['indirect_ref_amt'],'minimum_voucher'=>$value['minimum_voucher'],'created_date'=>$value['cdate'],'validity'=>$renew_date);


          }
        }else{
            $response['status']="failure";
            $response['message']="No User records found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    

  }
  
   public function editpackage($id)
    {
        //var_dump($id); die();
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();

            $res=$this->db->query("select * from ".$this->db->dbprefix('packages')." where id='".$id."'");

            if($res->num_rows()>0){
                $in_array=$res->result_array();
                $result=$in_array[0];
                $inc=1;
                for($i=1;$i<=30;$i++) 
                {
                   //$level_columnn[]="level".$inc;
                   $level_value[]=$result['level'.$i];
                   $stage_column[]=$result['stage'.$i.'_up'];
                   //$stage_column_value[]="'".$model->stage_upgradation_data[$key]."'";
                   $inc++;
                }
                $response['level']=$level_value;
                $response['stage']=$stage_column;
               // print_r($level_value);die;
            }else{
                $response['status']="failure";
                $response['message']=" No Package record found!!";
            }
            $response['result']=$result;

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
  public function updatepackage() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

         $array = json_encode($model->stage_bonus_data);
        $inc=1;

        foreach ($model->stage_bonus_data as $key => $value) 
        {
           $data=($value!='')?"'".$value."'":0;
           $level_columnn[]="level".$inc."=".$data;
           //print_r($level_columnn);die;
           $level_value[]="'".$value."'";
           $data1=($model->stage_upgradation_data[$key]!='')?$model->stage_upgradation_data[$key]:0;
           $stage_column[]="stage".$inc."_up=".$data1;
           $stage_column_value[]="'".$model->stage_upgradation_data[$key]."'";
           $inc++;
        }

        $level_field=implode(',', $level_columnn);
        $level_field_value=implode(',', $level_value);
        $stage_field_column=implode(',',$stage_column);
        $stage_field_value=implode(',',$stage_column_value);
//       print_r($level_field);die();

        if (isset($model)) {
        
          //   $this->db->where('id',$model->id);
          //   $result=$this->db->update('package_info', $model);
          // //  pr($this->db->last_query());die();
            

              $result=$this->db->query("update ".$this->db->dbprefix('packages')." set  name='".$model->name."',price='".$model->price."',currency='".$model->currency."',
              details='".$model->details."',tax='".$model->tax."',sbonus='".$model->sbonus."',minimum_voucher='".$model->minimum_voucher."',maximum_transfer='".$model->maximum_transfer."',".$level_field.",".$stage_field_column.",validity='".$model->validity."',indirect_ref_amt='".$model->indirect_ref_amt."',pay_via_voucher='".$model->pay_via_voucher."',pck_type='".$model->pck_type."' where id='".$model->id."'");

            if ($result) {
                $response['message']="Package has been updated successfully";
            }
            else
            {
                 $response['status']="failure";
            $response['message']="Package has not been updated fully";
            }
            

        } else {
            $response['status']="failure";
            $response['message']="Choose Package and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }
    public function deletepackage($id)
    {
      $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        

        $res_chk=$this->db->query("select id from ".$this->db->dbprefix('packages')." where id='".$id."' ");
        //print_r($res_chk);die;
        if($res_chk->num_rows()>0){

            $data=array('is_deleted'=>'1');
            $this->db->where('id',$id);
            $this->db->update($this->db->dbprefix('packages'),$data);

            $response['status']="success";
            $response['message']="package record has been deleted successfully";
            
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";    
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    }
    public function get_all_package()
    {   //var_dump($id); die();
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $package=array();
        $res=$this->db->query("select * from ".$this->db->dbprefix('user_vs_packages')."");



            if($res->num_rows()>0){
                $in_array=$res->result_array();
                //print_r($in_array);die;
                foreach ($in_array as $key => $value) 
                {
                    $res1=$this->db->query("select * from ".$this->db->dbprefix('packages')." where id='".$value['package_id']."'");
                    $in_array_1=$res1->result_array(); 

                    $user_det=$this->db->select("username")->where(['is_deleted'=>'0','id'=>$value['user_id']])->get('affiliateuser'); 
                    $data =$user_det->result_array();  

                    $package['marketer']=$data[0]['username']; 

                    $package['package_name'] = $in_array_1[0]['name'];

                    $package['package_price'] = $in_array_1[0]['price'];
                    $package['website']= $value['website'];

                    $package['status']=$value['package_status']=='1'?'Inactivate':($value['package_status']=='0'?'Active':'Expired');
                    if($value['package_status']=='0')
                    {
                      
                      $today=date("Y-m-d");
                      $pck_end_date_time = strtotime($value['renew_date']);
                      $current_time = strtotime($today);

                      if($current_time>$pck_end_date_time)
                      {
                        $package['status']='Renewal';

                      }

                    
                    }
                    
                    $package['pck_user_id'] = $value['user_id'];
                    $package['pck_id'] = $value['package_id'];
                    $package['pck_user_master_id'] = $value['id'];

                    $package['Delivered_date'] = ($value['activated_date']!=NULL)?date("Y/m/d",strtotime($value['activated_date'])):'--';

                    $package['renew_date'] = ($value['renew_date']!=NULL)?date("Y/m/d",strtotime($value['renew_date'])):'--';
                    $package['package_status']=$value['package_status'];
                    array_push($result,$package);
                    
                }
                
            }else{
                $response['status']="failure";
                $response['message']=" No Package record found!!";
            }
            $response['result']=$result;

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    
    }

   public function get_package_info($id)
    {
        //var_dump($id); die();
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $package=array();
        $res=$this->db->query("select * from ".$this->db->dbprefix('user_vs_packages')." where user_id='".$id."'");



            if($res->num_rows()>0){
                $in_array=$res->result_array();

                foreach ($in_array as $key => $value) 
                {
                    $res1=$this->db->query("select * from ".$this->db->dbprefix('packages')." where id='".$value['package_id']."'");
                    $in_array_1=$res1->result_array(); 
                    $user_det=$this->db->select("username,tamount,eamount,elearn_user_id,instructor_amount,tamount_renewal,instructor_amount_renewal,eamount_renewal,pw_amount,pw_amount_renewal,bw_amount,bw_amount_renewal,mall_amount,mall_amount_renewal,floor_amount,floor_amount_renewal,shop_amount,shop_amount_renewal")->where(['is_deleted'=>'0','id'=>$value['user_id']])->get('affiliateuser'); 
                    $data =$user_det->result_array();  
                    
                    //echo "<pre>";print_r($data);die;
                    
                    $elearn_user_det=$this->db->select("*")->where(['id'=>$data[0]['elearn_user_id']])->get('elearn_users'); 
                    $elearn_data =$elearn_user_det->result_array(); 
                    
                    $package['marketer']=$data[0]['username']; 
                    $package['elearn_usert_status'] = $elearn_data[0]['user_type'];    
                    $package['elearn_user_id'] = $elearn_data[0]['id'];    
                    $package['package_name'] = $in_array_1[0]['name'];

                    $package['package_price'] = $in_array_1[0]['price'];
                    $package['pck_type']= $in_array_1[0]['pck_type'];

                    $package['tamount']= $data[0]['tamount'];
                    $package['website']= $value['website'];
                    $package['template']= $value['template'];
                    $package['logo_name']= $value['logo_name'];
                    $package['logo_img']= $value['logo_img'];
                    $package['eamount']= $data[0]['eamount'];

                    $package['instructor_amount']= $data[0]['instructor_amount'];
                    $package['tamount_renewal']= $data[0]['tamount_renewal'];
                    $package['instructor_amount_renewal']= $data[0]['instructor_amount_renewal'];
                    $package['eamount_renewal']= $data[0]['eamount_renewal'];
                    $package['pw_amount']= $data[0]['pw_amount'];
                    $package['pw_amount_renewal']= $data[0]['pw_amount_renewal'];
                    $package['bw_amount']= $data[0]['bw_amount'];
                    $package['bw_amount_renewal']= $data[0]['bw_amount_renewal'];
                    $package['mall_amount']= $data[0]['mall_amount'];
                    $package['mall_amount_renewal']= $data[0]['mall_amount_renewal'];
                    $package['floor_amount']= $data[0]['floor_amount'];
                    $package['floor_amount_renewal']= $data[0]['floor_amount_renewal'];
                    $package['shop_amount']= $data[0]['shop_amount'];
                    $package['shop_amount_renewal']= $data[0]['shop_amount_renewal'];

                    $package['Instructoramount']= $data[0]['instructor_amount'];
                    $package['elearn_user_id']= $data[0]['elearn_user_id'];

                    $package['status']=$value['package_status']=='1'?'Inactivate':($value['package_status']=='0'?'Active':'Expired');
                    if($value['package_status']=='0')
                    {
                      
                      $today=date("Y-m-d");
                      $pck_end_date_time = strtotime($value['renew_date']);
                      $current_time = strtotime($today);

                      if($current_time>$pck_end_date_time)
                      {
                        $package['status']='Renewal';

                      }

                    
                    }
                    
                    $package['pck_user_id'] = $value['user_id'];
                    $package['pck_id'] = $value['package_id'];
                    $package['pck_user_master_id'] = $value['id'];

                    $package['Delivered_date'] = ($value['activated_date']!=NULL)?date("Y/m/d",strtotime($value['activated_date'])):'--';

                    $package['renew_date'] = ($value['renew_date']!=NULL)?date("Y/m/d",strtotime($value['renew_date'])):'--';
                    $package['package_status']=$value['package_status'];
                    array_push($result,$package);

                   
                    
                }
                
               

            }else{
                $response['status']="failure";
                $response['message']=" No Package record found!!";
            }
            $response['result']=$result;
// print_r($result); die;
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
   
   public function addpackagevsuser()
   {
     $this->output->set_content_type('application/json');
      
        
        $model = json_decode($this->input->post('model',FALSE));
        /*Get package type*/
         $res1=$this->db->query("select * from ".$this->db->dbprefix('packages')." where id='".$model->packuser."' AND is_deleted=0");
         
        $in_array_1=$res1->result_array(); 
        
        if($in_array_1[0]['pck_type']==2)
        {
            $check_package_exist = $this->db->query("select * from ".$this->db->dbprefix('user_vs_packages')." where user_id='".$model->user_id."' AND package_id='".$model->packuser."' ");
            if($check_package_exist->num_rows()>0)
            {
                $response=array('status'=>"0",'message'=>"User cannot buy a same package");
                 echo json_encode($response,JSON_UNESCAPED_SLASHES);
                 die();
            }
           
        }
        
        $response=array('status'=>"1",'message'=>"Package assigned successfully");   
        
        if($in_array_1[0]['pck_type']==6)
        {
          $webType="M";
        }
        elseif($in_array_1[0]['pck_type']==7)
        {
          $webType="F";
        }
        elseif($in_array_1[0]['pck_type']==8)
        {
          $webType="S";
        }
        elseif($in_array_1[0]['pck_type']==4)
        {
          $webType="P";
        }
        elseif($in_array_1[0]['pck_type']==5)
        {
          $webType="B";
        }

        else{
          $webType="E";
        }

        
        $this->db->query("insert into ".$this->db->dbprefix('user_vs_packages')." (user_id,package_id,website_type) values ('".$model->user_id."','".$model->packuser."','".$webType."')");

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
   }
   
   public function updatetemplatepackagevsuser()
   {
    $this->output->set_content_type('application/json');
    $response=array('status'=>"success");
    $new_model=new stdClass();
    $model = json_decode($this->input->post('model',FALSE));
    


    if (isset($model)) {
      // print_r($model->template);die;
        $new_model->template = $model->template;
    // print_r($new_model); die;
        $this->db->where('id',$model->p_id);
        $result=$this->db->update('user_vs_packages', $new_model);

        if ($result) {
            $response['message']="Template updated successfully";
        }
        else
        {
        $response['status']="failure";
        $response['message']="Record has not been updated successfully";
        }
        

    } else {
        $response['status']="failure";
        $response['message']="Record has not been updated successfully";
    }

    die(json_encode($response, JSON_UNESCAPED_SLASHES));
   }

   public function updatelogopackagevsuser()
   {
    $this->output->set_content_type('application/json');
    $response=array('status'=>"success");
    $model = json_decode($this->input->post('model',FALSE));
    // print_r($model); exit;
    if (isset($model)) {
      $data = array(
        "logo_name" => $model->logo_name,
        "logo_img" => $model->logo_img
      );
        $this->db->where('id',$model->p_id);
        $result=$this->db->update('user_vs_packages', $data);

        if ($result) {
            $response['message']="Logo updated successfully";
        }
        else
        {
        $response['status']="failure";
        $response['message']="Record has not been updated successfully";
        }
        

    } else {
        $response['status']="failure";
        $response['message']="Record has not been updated successfully";
    }

    die(json_encode($response, JSON_UNESCAPED_SLASHES));
   }
   
    public function get_package_not_buy($id)
    {
        //var_dump($id); die();
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $package=array();
        $res=$this->db->query("select * from ".$this->db->dbprefix('user_vs_packages')." where user_id='".$id."' GROUP BY package_id");
       //  $in_array=$res->result_array();
       // print_r($in_array);die;

            if($res->num_rows()>0){
                $in_array=$res->result_array();
                $pack_vs_usr_ids=[];
                foreach ($in_array as $key => $value) 
                {
                  $pack_vs_usr_ids[] = $value['package_id'];                  
                    
                }
                
                //print_r($pack_vs_usr_ids);die;

                $ids = implode(',',$pack_vs_usr_ids);
                
                $res1=$this->db->query("select * from ".$this->db->dbprefix('packages')." where id NOT IN(".$ids.") AND is_deleted=0 AND pck_type!=3 AND pck_type!=4 AND pck_type!=5 "); //comment by sridhar
                // $res1=$this->db->query("select * from ".$this->db->dbprefix('packages')." where is_deleted=0 AND pck_type!=3");
                  $in_array_1=$res1->result_array(); 
                  $pack_details=[];
                  foreach ($in_array_1 as $key => $value1) 
                  {
                    $pack_details['id'] = $value1['id'];  
                    $pack_details['package_name'] = $value1['name'];                  
                      array_push($result,$pack_details);
                  }

                
            }else{
                $response['status']="failure";
                $response['message']=" No Package record found!!";
            }
            $response['result']=$result;

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }  

     public function getearningslist()
  {
     $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $results=array();
        $html="";
        global $api_path;        

        $res=$this->db->select("*,DATE_FORMAT(created_at,'%d/%m/%Y')as created_at")->where('active','1')->get('earning_settings');
//print_r($res->result_array());die;

        if($res->num_rows()>0)
        {
          foreach($res->result_array() as $key=>$value)
          {               

             $res_chk=$this->db->query("select * from ".$this->db->dbprefix('packages')." 
              where id='".$value['id']."'");

             $data = $res_chk->result();
            // print_r($data);die;
              $pck_name = $data[0]->name;

            $results[]=array('id'=>$value['id'],'package_name'=>$pck_name,'downline_count'=>$value['downline_count'],'earning_amt'=>$value['earning_amt'],'status'=>$value['active'],'date'=>$value['created_at']);
          }
        }else{
            $response['status']="failure";
            $response['message']="No User records found..";
        }
        $response['result']=$results;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    

  }
   public function editearnings($id)
    {
        //var_dump($id); die();
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();

            $res=$this->db->query("select * from ".$this->db->dbprefix('earning_settings')." where id='".$id."'");

            if($res->num_rows()>0){
                $in_array=$res->result_array();
                $result=$in_array[0];
            }else{
                $response['status']="failure";
                $response['message']=" No Settings found!!";
            }
            $response['result']=$result;

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
    public function updateearnings() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

       // print_r($model);die();

        if (isset($model)) {
        
            $this->db->where('id',$model->id);
            $result=$this->db->update('earning_settings', $model);
          //  pr($this->db->last_query());die();

            if ($result) {
                $response['message']="Earnings has been updated successfully";
            }
            else
            {
                 $response['status']="failure";
            $response['message']="Record has not been updated successfully";
            }
            

        } else {
            $response['status']="failure";
            $response['message']="Choose User and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }
    public function addearnings(){
       $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $response['message']="Earnings inserted successfully";

        $model = json_decode($this->input->post('model',FALSE));

        date_default_timezone_set('Asia/Kolkata');
        
        $model->updated_at = date("Y-m-d H:i:s");
        
        $this->db->insert('earning_settings', $model);

        // if(isset($model->user_type)&&($model->user_type==2))
        // {
        //   $last_inserted_user_id = $this->db->insert_id();
        //   $package_id =isset($model->pcktaken)?$model->pcktaken:0;
        //   $this->db->query("insert into ".$this->db->dbprefix('user_vs_packages')." (user_id,package_id) values('".$last_inserted_user_id."','".$package_id."')");
        // }


        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
     public function deleteearnings($id)
    {
      $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        

        $res_chk=$this->db->query("select id from ".$this->db->dbprefix('earning_settings')." where id='".$id."' ");
       // print_r($res_chk->num_rows());die;
        if($res_chk->num_rows()>0){

            $data=array('active'=>'0');
            $this->db->where('id',$id);
            $this->db->update($this->db->dbprefix('earning_settings'),$data);

            $response['status']="success";
            $response['message']="Earnings record has been deleted successfully";
            
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";    
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    }

    public function check_website_exists()
    {
      $model = json_decode($this->input->post('model',FALSE));
    
      $response['exist']=0;

      if($model->pcktaken){
        $selectedPackage=$model->pcktaken;
       
        $res1=$this->db->query("select * from ".$this->db->dbprefix('packages')." where id='".$model->pcktaken."' AND is_deleted=0");

      }
    
    if($model->website!=""){
      $website = trim($model->website);
      if($model->selectedwebsite_prefix=="p-"){
        $website = trim($model->selectedwebsite_prefix.$model->website);
      }
      else if($model->selectedwebsite_prefix=="b-"){
        $website = trim($model->selectedwebsite_prefix.$model->website);
      }else{
        $website = trim($model->website);
      }
      
      $res=$this->db->select("website")->where(['website'=>$website])->get('user_vs_packages');
      if(count($res->result_array())>0)
      {         
        $response['exist']=1;
        $response['message']="website already exists";
      }
    }
    
    if(isset($model->pck_type)){
      $eusername = trim($model->eusername);
      $res=$this->db->select("email")->where(['email'=>$eusername])->get('elearn_users');
      if(count($res->result_array())>0)
      {         
        $response['exist']=1;
        $response['message']="E-Learning username already exists";
      }
    }
    
    
    
    
      echo json_encode($response,JSON_UNESCAPED_SLASHES);
      die();
    }

    public function get_website_list()
    {
       $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $package=array();
         $model = json_decode($this->input->post('model',FALSE));
         if($model->usertype==1)
         {
            $res=$this->db->query("select * from ".$this->db->dbprefix('user_vs_packages')." where website!='' ");
            if($res->num_rows()>0){
                $in_array=$res->result_array();

                foreach ($in_array as $key => $value) 
                {
                    $package['website'] = $value['website'];                    
                    array_push($result,$package);
                }
            }else{
                $response['status']="failure";
                $response['message']=" No Package record found!!";
            }
            $response['result']=$result;
         }
         else{
            $res=$this->db->query("select * from ".$this->db->dbprefix('user_vs_packages')." where website!='' AND user_id='".$model->userid."' ");
            if($res->num_rows()>0){
                $in_array=$res->result_array();

                foreach ($in_array as $key => $value) 
                {
                    $package['website'] = $value['website'];                    
                    array_push($result,$package);
                }
            }else{
                $response['status']="failure";
                $response['message']=" No Package record found!!";
            }
            $response['result']=$result;
         }
        
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }

    public function deletepackagedetails()
    {
      $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $response['message']="Earnings inserted successfully";

        $model = json_decode($this->input->post('model',FALSE));

        // "select * from ".$this->db->dbprefix('affiliateuser')." where website LIKE '%".$model->website."%'"

        $user_res=$this->db->query("select * from ".$this->db->dbprefix('affiliateuser')." where website='".$model->website."' ");

        $user_array=$user_res->result_array();

        foreach ($user_array as $key => $value) 
        {
            $data=array('website'=>' ');
            $this->db->where('Id',$value['Id']);
            $this->db->update($this->db->dbprefix('affiliateuser'),$data);
        }

         $category_res=$this->db->query("select * from ".$this->db->dbprefix('category_master')." where url='".$model->website."' ");

        $category_res_arr=$category_res->result_array();

        foreach ($category_res_arr as $key => $value) 
        {
          //print_r($value);die;
         $category_delete=$this->db->query("DELETE FROM category_master where id='".$value['id']."' ");            
        }

         $prod_res=$this->db->query("select * from ".$this->db->dbprefix('product_master')." where website='".$model->website."' ");

        $prod_res_arr=$prod_res->result_array();

        foreach ($prod_res_arr as $key => $value) 
        {
         // print_r("DELETE FROM product_master where id='".$value['id']."' ");die;
         $prod_del=$this->db->query("DELETE FROM product_master where id='".$value['id']."' ");            
        }

        $serv_res=$this->db->query("select * from ".$this->db->dbprefix('services')." where website='".$model->website."' ");

        $serv_res_arr=$serv_res->result_array();

        foreach ($serv_res_arr as $key => $value) 
        {
         // print_r("DELETE FROM product_master where id='".$value['id']."' ");die;
         $serv_del=$this->db->query("DELETE FROM services where id='".$value['id']."' ");            
        }

        $sub_cat_res=$this->db->query("select * from ".$this->db->dbprefix('sub_category_master')." where url='".$model->website."' ");

        $sub_cat_res_arr=$sub_cat_res->result_array();

        foreach ($sub_cat_res_arr as $key => $value) 
        {
         // print_r("DELETE FROM product_master where id='".$value['id']."' ");die;
         $sub_cat_del=$this->db->query("DELETE FROM sub_category_master where id='".$value['id']."' ");            
        }

        $adv_res=$this->db->query("select * from ".$this->db->dbprefix('user_advertisements')." where url='".$model->website."' ");

        $adv_res_arr=$adv_res->result_array();

        foreach ($adv_res_arr as $key => $value) 
        {
         // print_r("DELETE FROM product_master where id='".$value['id']."' ");die;
         $adv_del=$this->db->query("DELETE FROM user_advertisements where id='".$value['id']."' ");            
        }

        $user_vs_pck_res=$this->db->query("select * from ".$this->db->dbprefix('user_vs_packages')." where website='".$model->website."' ");

        $user_vs_pck_res_arr=$user_vs_pck_res->result_array();

        foreach ($user_vs_pck_res_arr as $key => $value) 
        {
         // print_r("DELETE FROM product_master where id='".$value['id']."' ");die;
         $user_vs_packages_del=$this->db->query("DELETE FROM user_vs_packages where id='".$value['id']."' ");            
        }
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
        
    }
    
    public function updateelearnuserpassword()
    {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));
        
        $password_model->password =sha1($model->password);
        //print_r($model);die();

        if (isset($model)) {
        
            $this->db->where('id',$model->elearnuserid);
            $result=$this->db->update('elearn_users', $password_model);
          //  pr($this->db->last_query());die();

            if ($result) {
                $response['message']="Password has been updated successfully";
            }
            else
            {
                 $response['status']="failure";
            $response['message']="Password  has not been updated fully";
            }
            

        } else {
            $response['status']="failure";
            $response['message']="Choose User and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    public function getPackageType($type)
    {
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();

        $res=$this->db->query("select * from ".$this->db->dbprefix('packages')." where pck_type='".$type."' AND active='1'");
         if($res->num_rows()>0){
          foreach($res->result_array() as $key=>$value)
          {               
         
            $result[]=array('id'=>$value['id'],'packagename'=>$value['name'],'pcktype'=>$value['pck_type'],'price'=>$value['price']);
          }
        }else{
            $response['status']="failure";
            $response['message']=" No Package found!!";
        }
        $response['result']=$result;

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
}
