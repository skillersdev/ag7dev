<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_controller extends CI_Controller {

	public function index() {
		$this->output->set_content_type('application/json');
		die(json_encode(array('status'=>"failure", 'error'=>'UN-Authorized access'), JSON_UNESCAPED_SLASHES));
	}

	public function gems_admin_login(){
		$this->output->set_content_type('application/json');
		$response=array('status'=>"success");
        
        if($this->input->post('login_username',FALSE)!="" && $this->input->post('login_password',FALSE) ){

        	//var_dump($this->input->post('login_password',FALSE)); die();
            
            $res=$this->db->query("select id,concat_ws(' ',firstname,lastname)as admin_name,role_type_id from ".$this->db->dbprefix('admin_master')." where admin_username='".$this->input->post('login_username',FALSE)."' and admin_password=md5('".$this->input->post('login_password',FALSE)."') and status=1");


            if($res->num_rows()>0){
                $result=$res->result_array();
                $result=$result[0];

                $data=array('last_visited_date'=>date('Y-m-d H:i:s'));
                $this->db->where('id',$result['id']);
                $this->db->update($this->db->dbprefix('admin_master'),$data);
                
                $response['result']=array('id'=>$result['id'],'admin_name'=>$result['admin_name'],'role_type_id'=>$result['role_type_id']);
                
            }else{
                $response['status']="failure";
                $response['message']="Sorry!!, Invalid User credentials submitted. Please try again.";        
            }
            
        }else{
            $response['status']="failure";            
            $response['message']="Sorry!!, Invalid Attempt!!.. Permission denied.";
        }
        
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
        
    }
    
    
    public function gems_create_zone_master(){
        
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        if($this->input->post('zone_name',FALSE)!=''){
            
            $zone_name=trim($this->input->post('zone_name',FALSE));
            $region_id=trim($this->input->post('region_id',FALSE));
            $email_id=trim($this->input->post('email_id',FALSE));
            $ad_office=trim($this->input->post('ad_office',FALSE));
            $created_by=trim($this->input->post('created_by',FALSE));

            

            $res_chk=$this->db->query("select id from ".$this->db->dbprefix('zones_staff_master')." where staff_zone_name='".$zone_name."' ");
            if($res_chk->num_rows()>0){
                    $response['status']="failure";            
                    $response['message']="Sorry!!, Zone name already exists.";
                
            }else{
                $this->db->query("insert into ".$this->db->dbprefix('zones_staff_master')." (staff_zone_name,region_id,email_id,ad_office,created_date,created_by) values
                 ('".$zone_name."',
                 '".$region_id."',
                 '".$email_id."',
                 '".$ad_office."',
                 NOW(),
                 '".$created_by."')");
                if($this->db->insert_id()){
                    $response['result']=array('id'=>$this->db->insert_id());
                    $response['message']="Zone record stored successfully";
                }else{
                    $response['status']="failure";            
                    $response['message']="Sorry!!, Unable to insert the Zone data";
                }
            }
            
        }else{
                $response['status']="failure";            
                $response['message']="Sorry!!, Invalid Attempt!!.. Permission denied.";
        }
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
    
    public function get_zone_master_list(){
        $this->output->set_content_type('application/json');
        $response=array();
        $html="";
        $response['status']="success";
        $result=array();
        $res=$this->db->query("select z.id, z.staff_zone_name, z.region_id,z.email_id,z.ad_office, DATE_FORMAT(z.created_date,'%d/%m/%Y')as created_date, c.region_name from  ".$this->db->dbprefix('zones_staff_master')." as z, ".$this->db->dbprefix('region_master')." as c where c.id=z.region_id order by z.id asc");


        if($res->num_rows()>0){
            foreach($res->result_array() as $key=>$value){


            $html='<button type="button" class="btn btn-primary editbutton" 
                                  data-element-obj="'.$value['id'].'"><i class="glyphicon glyphicon-pencil" data-element-obj="'.$value['id'].'"></i></button> 

                          <button type="button" class="btn btn-danger deletebutton"
                                  data-element-id="'.$value['id'].'"><i class="glyphicon glyphicon-trash" data-element-id="'.$value['id'].'"></i></button>';




                $result[]=array('userid'=>$value['id'],'staff_zone_name'=>$value['staff_zone_name'],'region_id'=>$value['region_id'],'email_id'=>$value['email_id'],'ad_office'=>$value['ad_office'],'region_name'=>$value['region_name'],'created_date'=>$value['created_date'],'action'=>$html);
            }
        }else{
            $response['status']="failure";
            $response['message']="No zone list found!!..";
        }
        $response['result']=$result;
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
    
     public function gems_staff_zone_home_project_master(){
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        
        $zone_id=$_POST['zone_id'];
        // print_r($zone_id);die();
        if($zone_id!=""){
            $res_chk=$this->db->query("select id,staff_name from ".$this->db->dbprefix('staff_master')." where zone_id IN(".$zone_id.")");
            //pr($res_chk->result_array());die();
            
            if($res_chk->num_rows()>0){

                foreach($res_chk->result_array() as $key=>$value){
                    // $result[$value['id']]=$value['country_name'];
                    $result[]=array('id'=>$value['id'],'name'=>$value['staff_name']);
                }
                 $response['result']=$result;
       
            }else{
                
                $response['status']="failure";            
                $response['message']="No lists Found";
            }
       }else{
            $response['status']="failure";            
            $response['message']="Invalid Attempt!!.. Access denied..";
       }    
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
    public function gems_church_zone_home_project_master(){
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        
        $zone_id=$_POST['zone_id'];
        // print_r($zone_id);die();
        if($zone_id!=""){
            $res_chk=$this->db->query("select id,church_name from ".$this->db->dbprefix('church_master')." where zone_id IN(".$zone_id.")");
            //pr($res_chk->result_array());die();
            
            if($res_chk->num_rows()>0){

                foreach($res_chk->result_array() as $key=>$value){
                    // $result[$value['id']]=$value['country_name'];
                    $result[]=array('id'=>$value['id'],'name'=>$value['church_name']);
                }
                 $response['result']=$result;
       
            }else{
                
                $response['status']="failure";            
                $response['message']="No lists Found";
            }
       }else{
            $response['status']="failure";            
            $response['message']="Invalid Attempt!!.. Access denied..";
       }    
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
    public function gems_fetch_zone_master($zone_id){
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        
        if($zone_id!=""){
            $res_chk=$this->db->query("select id,staff_zone_name,region_id,email_id,ad_office from ".$this->db->dbprefix('zones_staff_master')." where id='".$zone_id."'");
            if($res_chk->num_rows()>0){
                $result=$res_chk->result_array();
                $result=$result[0];

                $response['result']=array('id'=>$result['id'],'zone_name'=>$result['staff_zone_name'],'email_id'=>$result['email_id'],'ad_office'=>$result['ad_office'],'region_id'=>$result['region_id']);
            }else{
                
                $response['status']="failure";            
                $response['message']="Invalid Zone Id!!..";
            }
       }else{
            $response['status']="failure";            
            $response['message']="Invalid Attempt!!.. Access denied..";
       }    
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
 
    public function gems_edit_zone_master($zone_id){
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";

        if($zone_id!="" && $this->input->post('zone_name',FALSE)!=""){
            $zone_name=trim($this->input->post('zone_name',FALSE));            
            $res_chk=$this->db->query("select id from ".$this->db->dbprefix('zones_staff_master')." where staff_zone_name='".$zone_name."' and id!='".$zone_id."'");
            if($res_chk->num_rows()>0){
                    $response['status']="failure";            
                    $response['message']="Sorry!!, Zone name already exists.";
            }else{
                
                $data=array('staff_zone_name'=>$this->input->post('zone_name',FALSE),
                            'region_id'=>$this->input->post('region_id',FALSE),
                            'email_id'=>$this->input->post('email_id',FALSE),
                            'ad_office'=>$this->input->post('ad_office',FALSE),
                            'modified_by'=>$this->input->post('modified_by',FALSE));
                $this->db->set('modified_date', 'NOW()', FALSE);
                $this->db->where('id',$zone_id);
                $this->db->update($this->db->dbprefix('zones_staff_master'),$data);
                $response['message']="Zone record has been updated successfully";
            }
       }else{
            $response['status']="failure";            
            $response['message']="Invalid Attempt!!.. Access denied..";
       }    
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
    
    public function gems_delete_zone_master($id){
        
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        
        if($id){
            
            $this->db->query("delete from ".$this->db->dbprefix('zones_staff_master')."  where id='".$id."'");
            $response['status']="success";
            $response['message']="Zone record has been deleted successfully";
            
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";    
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();        
    }
    
    
  
  public function get_countries_master_list(){
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $res=$this->db->query("select id, name from ".$this->db->dbprefix('countries_master')." order by name asc");
        if($res->num_rows()>0){
            foreach($res->result_array() as $key=>$value){
                // $result[$value['id']]=$value['country_name'];
                $result[]=array('id'=>$value['id'],'name'=>$value['name']);
            }
            
        }else{
            $response['status']="failure";
            $response['message']="No country list found!!";
        }
        $response['result']=$result;
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();    
  }


  public function get_village_master_list(){
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $res=$this->db->query("select id, village from ".$this->db->dbprefix('village')." order by village asc");
        if($res->num_rows()>0){
            foreach($res->result_array() as $key=>$value){
               
                $result[]=array('id'=>$value['id'],'village'=>$value['village']);
            }
            
        }else{
            $response['status']="failure";
            $response['message']="No village list found!!";
        }
        $response['result']=$result;
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();    
  }

  public function get_district_master_list(){
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $res=$this->db->query("select id, district_name from ".$this->db->dbprefix('district')." order by district_name asc");
        if($res->num_rows()>0){
            foreach($res->result_array() as $key=>$value){
               
                $result[]=array('id'=>$value['id'],'district_name'=>$value['district_name']);
            }
            
        }else{
            $response['status']="failure";
            $response['message']="No District list found!!";
        }
        $response['result']=$result;
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();    
  }
  public function get_district_updated_list(){

       $state_id = $this->input->post('model',FALSE);
       $result=array();
         $res_chk=$this->db->query("select * from ".$this->db->dbprefix('district_master')." where state_id='".$state_id."'");
         // print_r($res_chk);
         // die();
        //pr($this->db->last_query());  
          foreach($res_chk->result_array() as $key=>$value){
          
               $result[]=array('id'=>$value['id'],'district_name'=>$value['district']); 
            }
       // pr($result);die();
            $response['result']=$result;
             echo json_encode($response,JSON_UNESCAPED_SLASHES);
             die();
  }
  public function get_district(){

       //$state_id = $this->input->post('model',FALSE);
       $result=array();
         $res_chk=$this->db->query("select * from ".$this->db->dbprefix('district_master')." order by district asc");
         // print_r($res_chk);
         // die();
        //pr($this->db->last_query());  
          foreach($res_chk->result_array() as $key=>$value){
          
               $result[]=array('id'=>$value['id'],'district_name'=>$value['district']); 
            }
       // pr($result);die();
            $response['result']=$result;
             echo json_encode($response,JSON_UNESCAPED_SLASHES);
             die();
  }
  
  public function get_updated_block_master_list(){

       $district_id = $this->input->post('model',FALSE);
       $result=array();
         $res_chk=$this->db->query("select * from ".$this->db->dbprefix('block_master')." where district_id='".$district_id."'");
         // print_r($res_chk);
         // die();
        //pr($this->db->last_query());  
          foreach($res_chk->result_array() as $key=>$value){
          
               $result[]=array('id'=>$value['id'],'block_name'=>$value['block_name']); 
            }
       // pr($result);die();
            $response['result']=$result;
             echo json_encode($response,JSON_UNESCAPED_SLASHES);
             die();
  }
  public function get_block(){

       // $district_id = $this->input->post('model',FALSE);
       $result=array();
         $res_chk=$this->db->query("select * from ".$this->db->dbprefix('block_master')." ");

          foreach($res_chk->result_array() as $key=>$value){
          
               $result[]=array('id'=>$value['id'],'block_name'=>$value['block_name']); 
            }
       // pr($result);die();
            $response['result']=$result;
             echo json_encode($response,JSON_UNESCAPED_SLASHES);
             die();
  }
  public function get_panchayat_updated_list(){

       $block_id = $this->input->post('model',FALSE);
       $result=array();
         $res_chk=$this->db->query("select * from ".$this->db->dbprefix('panchayat_master')." where block_id='".$block_id."'");
         // print_r($res_chk);
         // die();
        //pr($this->db->last_query());  
          foreach($res_chk->result_array() as $key=>$value){
          
               $result[]=array('id'=>$value['id'],'panchayat_name'=>$value['panchayat_name']); 
            }
       // pr($result);die();
            $response['result']=$result;
             echo json_encode($response,JSON_UNESCAPED_SLASHES);
             die();
  }
  public function get_panchayat(){

       // $block_id = $this->input->post('model',FALSE);
       $result=array();
         $res_chk=$this->db->query("select * from ".$this->db->dbprefix('panchayat_master')." ");
         // print_r($res_chk);
         // die();
        //pr($this->db->last_query());  
          foreach($res_chk->result_array() as $key=>$value){
          
               $result[]=array('id'=>$value['id'],'panchayat_name'=>$value['panchayat_name']); 
            }
       // pr($result);die();
            $response['result']=$result;
             echo json_encode($response,JSON_UNESCAPED_SLASHES);
             die();
  }
  public function get_village_updated_list(){

       $panchayat_id = $this->input->post('model',FALSE);
       $result=array();
         $res_chk=$this->db->query("select * from ".$this->db->dbprefix('village_master')." where panchayat_id='".$panchayat_id."'");
         // print_r($res_chk);
         // die();
        //pr($this->db->last_query());  
          foreach($res_chk->result_array() as $key=>$value){
          
               $result[]=array('id'=>$value['id'],'village_name'=>$value['village_name']); 
            }
       // pr($result);die();
            $response['result']=$result;
             echo json_encode($response,JSON_UNESCAPED_SLASHES);
             die();
  }
  public function get_village(){

       //$panchayat_id = $this->input->post('model',FALSE);
       $result=array();
         $res_chk=$this->db->query("select * from ".$this->db->dbprefix('village_master')." ");
         // print_r($res_chk);
         // die();
        //pr($this->db->last_query());  
          foreach($res_chk->result_array() as $key=>$value){
          
               $result[]=array('id'=>$value['id'],'village_name'=>$value['village_name']); 
            }
       // pr($result);die();
            $response['result']=$result;
             echo json_encode($response,JSON_UNESCAPED_SLASHES);
             die();
  }
  public function get_church_place_master_list(){
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $res=$this->db->query("select id, church_place from ".$this->db->dbprefix('church_place')." order by church_place asc");
        if($res->num_rows()>0){
            foreach($res->result_array() as $key=>$value){
               
                $result[]=array('id'=>$value['id'],'church_place'=>$value['church_place']);
            }
            
        }else{
            $response['status']="failure";
            $response['message']="No Church Place list found!!";
        }
        $response['result']=$result;
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();    
  }
  
  
    public function gems_create_state_master(){
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        
        if($this->input->post('country_id',FALSE)!="" && $this->input->post('state_name',FALSE)!=""){
            
            $res_chk=$this->db->query("select id from  ".$this->db->dbprefix('state_zone_master')."   where state_zone_name='".trim($this->input->post('state_name',FALSE))."'");
            if($res_chk->num_rows()>0){
                $response['status']="failure";
                $response['message']="Sorry!!, State already exists";        
            }else{
                $data=array('fk_country_id'=>$this->input->post('country_id',FALSE),'state_zone_name'=>trim($this->input->post('state_name',FALSE)));
                $this->db->insert($this->db->dbprefix('state_zone_master'),$data);
                if($this->db->insert_id()){
                    $response['status']="success";
                    $response['message']="State record has been inserted successfully";
                }else{
                    $response['status']="failure";
                    $response['message']="Sorry!!, Unable to record the state details..";
                }
            }
            
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    }

    public function gems_fetch_state_master($state_id){
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        
        if($state_id!=""){
            $res_chk=$this->db->query("select id,fk_country_id,state_zone_name  from ".$this->db->dbprefix('state_zone_master')." where id='".$state_id."'");
            if($res_chk->num_rows()>0){
                $result=$res_chk->result_array();
                $result=$result[0];


                $response['result']=array('id'=>$result['id'],'state_zone_name'=>$result['state_zone_name'],'fk_country_id'=>$result['fk_country_id']);
            }else{
                
                $response['status']="failure";            
                $response['message']="Invalid Request.. Please try again..";
            }
       }else{
            $response['status']="failure";            
            $response['message']="Invalid Attempt!!.. Access denied..";
       }    
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
  
  
    
   public function gems_edit_state_master($state_id){
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        
        if($this->input->post('country_id',FALSE)!="" && $this->input->post('state_name',FALSE)!=""){
            
            $res_chk=$this->db->query("select id from  ".$this->db->dbprefix('state_zone_master')."   where state_zone_name='".trim($this->input->post('state_name',FALSE))."' and id!='".$state_id."' ");
            if($res_chk->num_rows()>0){
                $response['status']="failure";
                $response['message']="Sorry!!, State already exists";        
            }else{
                $data=array('fk_country_id'=>$this->input->post('country_id',FALSE),'state_zone_name'=>trim($this->input->post('state_name',FALSE)));
                $this->db->where('id',$state_id);
                $this->db->update($this->db->dbprefix('state_zone_master'),$data);                
                $response['status']="success";
                $response['message']="State record has been updated successfully";
            }
            
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
  } 
    
    
  public function gems_delete_state_master($id){
    
    $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        
        if($id){            
            $this->db->query("delete from ".$this->db->dbprefix('state_zone_master')."  where id='".$id."'");
            $response['status']="success";
            $response['message']="State record has been deleted successfully";
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";    
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
        
    
  }  
  public function get_updated_state_master_list(){

         $country_id = $this->input->post('model',FALSE);

         $res_chk=$this->db->query("select * from ".$this->db->dbprefix('state_master'));

         if(($country_id!='')||(($country_id!='undefined')))
         {
             $this->db->where('country_id',$country_id);
         }

        // $res_chk=$this->db->query("select * from ".$this->db->dbprefix('state_master')." where country_id='".$country_id."'");

        //pr($this->db->last_query());
          foreach($res_chk->result_array() as $key=>$value){

            $html='<button type="button" class="btn btn-info btn" (click)="editdesignation("'.$value['id'].'")"><i class="glyphicon glyphicon-pencil"></i></button> 
                            <button type="button" class="btn btn-danger btn" (click)="deletedesignation("'.$value['id'].'")"><i class="glyphicon glyphicon-trash"></i></button>';


               $result[]=array('id'=>$value['id'],'state_name'=>$value['name'],'action'=>$html); 
            }
       // pr($result);die();
            $response['result']=$result;
             echo json_encode($response,JSON_UNESCAPED_SLASHES);
             die();
  }
  public function get_updated_city_master_list(){
         $state_id = $this->input->post('model',FALSE);

         $res_chk=$this->db->query("select * from ".$this->db->dbprefix('cities_master')." where state_id='".$state_id."'");

        //pr($this->db->last_query());
          foreach($res_chk->result_array() as $key=>$value){

            $html='<button type="button" class="btn btn-info btn" (click)="editdesignation("'.$value['id'].'")"><i class="glyphicon glyphicon-pencil"></i></button> 
                            <button type="button" class="btn btn-danger btn" (click)="deletedesignation("'.$value['id'].'")"><i class="glyphicon glyphicon-trash"></i></button>';


               $result[]=array('id'=>$value['id'],'city_name'=>$value['name'],'action'=>$html); 
            }
       // pr($result);die();
            $response['result']=$result;
             echo json_encode($response,JSON_UNESCAPED_SLASHES);
             die();
  }
  
  public function get_state_master_list(){
    
        $this->output->set_content_type('application/json');
        $response=array();
        $html="";
        $response['status']="success";
      
        $result=array();
        
        $res=$this->db->query("select z.id,z.fk_country_id, z.state_zone_name,  DATE_FORMAT(z.created_date,'%d/%m/%Y')as created_date, c.country_name from ".$this->db->dbprefix('state_zone_master')." as z, ".$this->db->dbprefix('country')." as c where c.id=z.fk_country_id order by z.id desc");
        if($res->num_rows()>0){
            foreach($res->result_array() as $key=>$value){

            $html='<button type="button" class="btn btn-info btn" (click)="editstate("'.$value['id'].'")"><i class="glyphicon glyphicon-pencil"></i></button> 
                            <button type="button" class="btn btn-danger btn" (click)="deletestate("'.$value['id'].'")"><i class="glyphicon glyphicon-trash"></i></button>';


                $result[]=array('id'=>$value['id'],'country_id'=>$value['fk_country_id'],'state_zone_name'=>$value['state_zone_name'],'country_name'=>$value['country_name'],'created_date'=>$value['created_date'],'action'=>$html);
            }
        }else{
            $response['status']="failure";
            $response['message']="No country list found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
  }
  
  
  public function gems_create_designation_master(){
    
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $designation=trim($this->input->post('designation_name',FALSE));
        if($designation){            
            $res_chk=$this->db->query("select id from ".$this->db->dbprefix('staff_designation_master')." where designation_name='".$designation."'");
            if($res_chk->num_rows()>0){
                 $response['status']="failure";
                 $response['message']="Designation already exists";
            }else{
                
                $this->db->query("insert into ".$this->db->dbprefix('staff_designation_master')." (designation_name, created_date, created_by) values ('".$designation."',NOW(),'1')");
                if($this->db->insert_id()){
                     $response['status']="success";
                     $response['message']="Designation record has been inserted successfully";
                }else{
                    $response['status']="failure";
                     $response['message']="Something wrong in your input!!. Please try again..";
                }
            }
        }else{
             $response['status']="failure";
             $response['message']="Invalid Attempt!!.. Access denied..";
        }
    
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    
  }
  
  public function gems_fetch_designation_master($id){
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        
        if($id){
            $res=$this->db->query("select designation_name,id from ".$this->db->dbprefix('staff_designation_master')." where id ='".$id."'");
            if($res->num_rows()>0){
                $in_result=$res->result_array();
                $in_result=$in_result[0];
                $result=array('id'=>$in_result['id'],'designation_name'=>$in_result['designation_name']);                
            }else{
                 $response['status']="failure";
                 $response['message']="Designation record not found!!";
            }
        }
        $response['result']=$result;
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
  }
  
  
  
  
  
  public function gems_edit_designation_master(){
    
    
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $designation=trim($this->input->post('designation_name',FALSE));
        
        if($this->input->post('designation_id',FALSE)!="" && $designation!=""){
             
            $res_chk=$this->db->query("select id from ".$this->db->dbprefix('staff_designation_master')." where designation_name='".$designation."' and id!='".$this->input->post('designation_id',FALSE)."'");
            if($res_chk->num_rows()>0){
                 $response['status']="failure";
                 $response['message']="Designation already exists";
            }else{
                
                $result=$this->db->query("update ".$this->db->dbprefix('staff_designation_master')." set  designation_name='".$designation."', modified_date=NOW(), modified_by='1' where id='".$this->input->post('designation_id',FALSE)."'   ");
                if($result){
                    $response['status']="success";
                    $response['message']="Designation record updated successfully";
                }else{
                    $response['status']="failure";
                    $response['message']="Something wrong in your input!!. Please try again..";
                }
            }
            
        }else{
             $response['status']="failure";
             $response['message']="Invalid Attempt!!.. Access denied..";
        }
           
     echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
         
  } 
  
  public function gems_delete_designation_master($id){
    
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        
        if($id){            
            $this->db->query("delete from ".$this->db->dbprefix('staff_designation_master')."  where id='".$id."'");
            $response['status']="success";
            $response['message']="Designation record has been deleted successfully";
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";    
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
  }
  
  
  public function get_designation_master_list(){
    
     $this->output->set_content_type('application/json');
        $response=array();
        $html='';
        $response['status']="success";
        $result=array();
        
        $res=$this->db->query("select id, designation_name, DATE_FORMAT(created_date,'%d/%m/%Y')as created_date from ".$this->db->dbprefix('staff_designation_master')." order by id desc");
        if($res->num_rows()>0){
            
            foreach($res->result_array() as $key=>$value){

            $html='<button type="button" class="btn btn-info btn" (click)="editdesignation("'.$value['id'].'")"><i class="glyphicon glyphicon-pencil"></i></button> 
                            <button type="button" class="btn btn-danger btn" (click)="deletedesignation("'.$value['id'].'")"><i class="glyphicon glyphicon-trash"></i></button>';


               $result[]=array('id'=>$value['id'],'designation_name'=>$value['designation_name'],'created_date'=>$value['created_date'],'action'=>$html); 
            }
            
        }else{
            $response['status']="failure";
            $response['message']="No Designation records found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    
  }

  public function get_user_role_list(){
    
     $this->output->set_content_type('application/json');
        $response=array();
        $html='';
        $response['status']="success";
        $result=array();
        
        $res=$this->db->query("select id, role_name, DATE_FORMAT(create_at,'%d/%m/%Y')as create_at from ".$this->db->dbprefix('user_role_master')." where is_deleted='0'");
        if($res->num_rows()>0){
            
               $result=$res->result_array();

                //$response['result']=array('id'=>$result['id'],'department_name'=>$result['department_name']);
            
        }else{
            $response['status']="failure";
            $response['message']="No Designation records found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    
  }

  public function gems_fetch_user_role_master($role_id){
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        
        if($role_id){
            $res_chk=$this->db->query("select id,role_name  from ".$this->db->dbprefix('user_role_master')." where id='".$role_id."'");
            if($res_chk->num_rows()>0){
                $result=$res_chk->result_array();
                $result=$result[0];


                $response['result']=array('id'=>$result['id'],'role_name'=>$result['role_name']);
            }else{
                
                $response['status']="failure";            
                $response['message']="Invalid Role Id!!..";
            }
       }else{
            $response['status']="failure";            
            $response['message']="Invalid Attempt!!.. Access denied..";
       }    
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }


     public function gems_edit_user_role_master(){
     	//var_dump($this->input->post('role_name',FALSE)); die();
    
    $role_id=$this->input->post('id',FALSE);
    $role_name=trim($this->input->post('role_name',FALSE));
    
    if($role_id!="" && $role_name!=""){
        
        $res_chk=$this->db->query("select id from ".$this->db->dbprefix('user_role_master')." where role_name='".$role_name."' and id!='".$role_id."'");
            if($res_chk->num_rows()>0){
                 $response['status']="failure";
                 $response['message']="User Role already exists";
            }else{
                $result=$this->db->query("update ".$this->db->dbprefix('user_role_master')."  set role_name='".$role_name."',update_at=NOW(), updated_by='1' where id='".$role_id."'");
                if($result){
                	$response['status']="success";
                    $response['message']="User Role record updated successfully";
                }else{
                    $response['status']="failure";   
                    $response['message']="Something wrong in your input!!. Please try again..";
                }
            }
        
    }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";
    }
    
    
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
       die();
       
  }

  public function gems_create_user_role_master(){
    
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        
        $role_name=trim($this->input->post('role_name',FALSE));
        
        if($role_name!=""){
            
            $res_chk=$this->db->query("select id from ".$this->db->dbprefix('user_role_master')." where role_name='".$role_name."'");
            if($res_chk->num_rows()>0){
                 $response['status']="failure";
                 $response['message']="User Role already exists";
            }else{
               $this->db->query("insert into ".$this->db->dbprefix('user_role_master')." (role_name, create_at,created_by, is_deleted) values ('".$role_name."', NOW(),'1','0')");
                if($this->db->insert_id()){                    
                    $response['message']="User Role record has been inserted successfully";
                }else{
                    $response['status']="failure";   
                    $response['message']="Something wrong in your input!!. Please try again..";
                }
            }
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";   
        }
       echo json_encode($response,JSON_UNESCAPED_SLASHES);
       die();
  }

  public function get_user_list(){
    
     $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $html="";
           global $api_path;
        
        //$res=$this->db->query("select id, firstname, lastname, CONCAT(firstname, ' ',  lastname) AS fullname, email_address, admin_username, role_type_id, last_visited_date, status,  DATE_FORMAT(created_date,'%d/%m/%Y%r')as created_date from ".$this->db->dbprefix('admin_master')." where is_deleted='0'");

        $res=$this->db->select("admin_master.id, firstname, lastname, CONCAT(firstname, ' ',  lastname) AS fullname, email_address, admin_username, role_type_id, user_role_master.role_name, last_visited_date, status,  DATE_FORMAT(created_date,'%d/%m/%Y%r')as created_date")
            ->join('user_role_master', 'admin_master.role_type_id=user_role_master.id', 'left')
            ->order_by('admin_master.id', 'desc')
            ->where('admin_master.is_deleted', '0')
            ->get('admin_master');


        if($res->num_rows()>0){
        	foreach($res->result_array() as $key=>$value){

                //var_dump($value); die();
               //$result=$res->result_array();

               $html='

	                <a title="User Edit" style=" [hidden] margin-top: 10px;" href="'.$api_path.'/#/edituser/'.$value['id'].'"><i class="fa fa-pencil" aria-hidden="true"></i></a>

                    <a title="Set User rights" style=" [hidden] margin-top: 10px;" href="'.$api_path.'/#/setuserrights/'.$value['role_type_id'].'"><i class="fa fa-cogs" aria-hidden="true"></i></a>


                    <button style=" margin-top: 10px;" type="button" class="btn btn-info button_user_rights" data-element-id="'.$value['id'].'"><i class="fa fa-cogs" data-element-id="'.$value['id'].'"></i></button>

	                
	                 <button style=" margin-top: 10px;" type="button" class="btn btn-danger button_delete_user" data-element-id="'.$value['id'].'"><i class="glyphicon glyphicon-trash" data-element-id="'.$value['id'].'"></i></button>';

					$result[]=array('id'=>$value['id'],'fullname'=>$value['fullname'],'email_address'=>$value['email_address'],'admin_username'=>$value['admin_username'],'role_type_id'=>$value['role_name'],'created_date'=>$value['created_date'],'action'=>$html);
            }
        }else{
            $response['status']="failure";
            $response['message']="No User records found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    
  }

  public function gems_create_user_master(){
    
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        
        $username=trim($this->input->post('user_name',FALSE));
        $user_password=trim($this->input->post('user_password',FALSE));
        $first_name=trim($this->input->post('first_name',FALSE));
        $last_name=trim($this->input->post('last_name',FALSE));
        $email=trim($this->input->post('email',FALSE));
        $user_roles=trim($this->input->post('user_roles',FALSE));
        $user_mobile=trim($this->input->post('user_mobile',FALSE));
        $is_deleted=trim($this->input->post('is_deleted',FALSE));
        
        if($username!=""){
            
            $res_chk=$this->db->query("select id from ".$this->db->dbprefix('admin_master')." where admin_username='".$username."'");
             //var_dump($is_deleted); die();
            if($res_chk->num_rows()>0){
                 $response['status']="failure";
                 $response['message']="User Name already exists";
            }else{
               $this->db->query("insert into ".$this->db->dbprefix('admin_master')." (admin_username,admin_password,firstname,lastname,mobile_number,email_address,role_type_id,status, created_date,created_by,is_deleted) values (
               	'".$username."',
               	md5('".$user_password."'),
               	'".$first_name."',
               	'".$last_name."',
               	'".$user_mobile."',
               	'".$email."',
               	'".$user_roles."',
               	'1',
               	NOW(),
                '1',
                '".$is_deleted."')");

                if($this->db->insert_id()){                    
                    $response['message']="User record has been inserted successfully";
                }else{
                    $response['status']="failure";   
                    $response['message']="Something wrong in your input!!. Please try again..";
                }
            }
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";   
        }
       echo json_encode($response,JSON_UNESCAPED_SLASHES);
       die();
  }

  public function gems_fetch_User($user_id){
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        
        if($user_id){
            $res_chk=$this->db->query("select * from ".$this->db->dbprefix('admin_master')." where id='".$user_id."'");
            if($res_chk->num_rows()>0){
                //$res_chk->result_array();
                

                foreach($res_chk->result_array() as $key=>$value){

               $result[]=array('id'=>$value['id'],'admin_username'=>$value['admin_username'],'admin_password'=>$value['admin_password'],'firstname'=>$value['firstname'],'lastname'=>$value['lastname'],'mobile_number'=>$value['mobile_number'],'email_address'=>$value['email_address'],'role_type_id'=>$value['role_type_id']); 
            }
            $response['result'] = $result[0];

            }else{
                
                $response['status']="failure";            
                $response['message']="Invalid Zone Id!!..";
            }
       }else{
            $response['status']="failure";            
            $response['message']="Invalid Attempt!!.. Access denied..";
       }    
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }

    public function gems_edit_user_master(){
    	//var_dump($this->input->post('id',FALSE)); die();
    	$user_id = $this->input->post('id',FALSE);
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";

        
        if($user_id!="" && $this->input->post('user_name',FALSE)!=""){

            $user_name=trim($this->input->post('user_name',FALSE));            
            $res_chk=$this->db->query("select id from ".$this->db->dbprefix('admin_master')." where admin_username='".$user_name."' and id!='".$user_id."'");
            if($res_chk->num_rows()>0){
                    $response['status']="failure";            
                    $response['message']="Sorry!!, User name already exists.";
            }else{


            	if($this->input->post('user_password',FALSE)!="")
            	{

            		$data=array('admin_username'=>$this->input->post('user_name',FALSE),
                            'firstname'=>$this->input->post('first_name',FALSE),
                            'lastname'=>$this->input->post('last_name',FALSE),
                            'admin_password'=>md5($this->input->post('user_password',FALSE)),
                            'email_address'=>$this->input->post('email',FALSE),
                            'mobile_number'=>$this->input->post('user_mobile',FALSE),
                            'role_type_id'=>$this->input->post('user_roles',FALSE),
                            'modified_by'=>$this->input->post('modified_by',FALSE));
            	}
                else
                {
                	$data=array('admin_username'=>$this->input->post('user_name',FALSE),
                            'firstname'=>$this->input->post('first_name',FALSE),
                            'lastname'=>$this->input->post('last_name',FALSE),
                            'email_address'=>$this->input->post('email',FALSE),
                            'mobile_number'=>$this->input->post('user_mobile',FALSE),
                            'role_type_id'=>$this->input->post('user_roles',FALSE),
                            'modified_by'=>$this->input->post('modified_by',FALSE));
                }
                
                $this->db->set('modified_date', 'NOW()', FALSE);
                $this->db->where('id',$user_id);
                $this->db->update($this->db->dbprefix('admin_master'),$data);
                $response['message']="User record has been updated successfully";
            }
       }else{
            $response['status']="failure";            
            $response['message']="Invalid Attempt!!.. Access denied..";
       }    
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }

   public function gems_delete_user_master($id){
        
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        
        if($id){
            
            //$this->db->query("delete from ".$this->db->dbprefix('admin_master')."  where id='".$id."'");

            $this->db->query("update ".$this->db->dbprefix('admin_master')." set is_deleted='1' where id='".$id."'");

            $response['status']="success";
            $response['message']="User record has been deleted successfully";
            
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";    
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();        
    }



  public function gems_fetch_User_role($role_id){
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        
        if($role_id){
            $res_chk=$this->db->query("select * from ".$this->db->dbprefix('security_access')." where user_role_id='".$role_id."'");
            if($res_chk->num_rows()>0){
                //$res_chk->result_array();
                

                foreach($res_chk->result_array() as $key=>$value){

               $result[]=array('id'=>$value['id'],'module_id'=>$value['module_id'],'user_role_id'=>$value['user_role_id'],'read'=>$value['mod_read'],'write'=>$value['mod_write'],'delete'=>$value['mod_delete'],'modify'=>$value['mod_modify'],'approve'=>$value['mod_approve'],'created_at'=>$value['created_at']); 
            }
            $response['result'] = $result;

            }else{
                
                $response['status']="failure";            
                $response['message']="Invalid User Role Id!!..";
            }
       }else{
            $response['status']="failure";            
            $response['message']="Invalid Attempt!!.. Access denied..";
       }    
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }

    public function gems_create_user_role()
    {
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        

        $checkedvalue=trim($this->input->post('checkedvalue'));

        $is_deleted=trim($this->input->post('is_deleted'));
        $user_role_id=trim($this->input->post('user_role_id'));
        
        $checkedvalue=json_decode($checkedvalue);


        for ($i=0; $i <count($checkedvalue); $i++) { 
        		//var_dump($checkedvalue->result[$i]); die();
               $checkedstore = $checkedvalue[$i];
               
                  //$checksecurity=\app\models\Securityaccess::findOne(['user_role_id' => $Request['user_role_id'], 'module_id' => $checkedstore['module_id']]);
                   $checksecurity=$this->db->query("select * from ".$this->db->dbprefix('security_access')." where user_role_id='".$user_role_id."' and module_id='".$checkedstore->module_id."'");
                  //var_dump($checkedstore); die();
                    if(!$checksecurity->result_array())
                    {
                    	//var_dump($checkedstore); die();
                    	$module_id = $checkedstore->module_id;
                    	$user_role_id = $user_role_id;
                    	$read = $checkedstore->read;
                        $write = $checkedstore->write;
                        $delete = $checkedstore->delete;
                        $modify = $checkedstore->modify;
                        $approve = $checkedstore->approve;
                        $is_deleted = '0';
                        $created_by = '1';
                        //var_dump($user_role_id); die();
                        $this->db->query("insert into ".$this->db->dbprefix('security_access')." (module_id, user_role_id, mod_read, mod_write, mod_delete, mod_modify, mod_approve, is_deleted,created_at,created_by) values ('".$module_id."','".$user_role_id."','".$read."','".$write."','".$delete."','".$modify."','".$approve."','".$is_deleted."', NOW(),'".$created_by."')");
                        if($this->db->insert_id()){                
		                    $response['message']="User Rights has been inserted successfully";
		                }else{
		                    $response['status']="failure";
		                    $response['message']="Something wrong in your input!!. Please try again..";
		                }  
                    }
                    else
                    {
                    	
                    	$result=$checkedstore;
                    	
                    	//$result=$result[0];
                    	//var_dump($result); die();
                        //$floordata = Securityaccess::findOne(['id' => $value['id']]);
                        $read = $result->read;
                        $write = $result->write;
                        $delete = $result->delete;
                        $modify = $result->modify;
                        $approve = $result->approve;

                        if(isset($result->id))
                        {

                            $id = $result->id;
                        }
                        // $checksecurity->save();
                    	$result=$this->db->query("update ".$this->db->dbprefix('security_access')."  set mod_read='".$read."',mod_write='".$write."',mod_delete='".$delete."',mod_modify='".$modify."',mod_approve='".$approve."',updated_at=NOW(), updated_by='1' where id='".$id."'");
                    	if($result){
		                    $response['message']="User Rights record updated successfully";
		                }else{
		                    $response['status']="failure";   
		                    $response['message']="Something wrong in your input!!. Please try again..";
		                }
                        
                    }
           }

            echo json_encode($response,JSON_UNESCAPED_SLASHES);
        	 die();
        
    }
  
  
  public function gems_create_department_master(){
    
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        
        $department=trim($this->input->post('department_name',FALSE));
        
        if($department!=""){
            
            $res_chk=$this->db->query("select id from ".$this->db->dbprefix('staff_department_master')." where department_name='".$department."'");
            if($res_chk->num_rows()>0){
                 $response['status']="failure";
                 $response['message']="Department already exists";
            }else{
               $this->db->query("insert into ".$this->db->dbprefix('staff_department_master')." (department_name, created_date,created_by) values ('".$department."', NOW(),'1')");
                if($this->db->insert_id()){                    
                    $response['message']="Department record has been inserted successfully";
                }else{
                    $response['status']="failure";   
                    $response['message']="Something wrong in your input!!. Please try again..";
                }
            }
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";   
        }
       echo json_encode($response,JSON_UNESCAPED_SLASHES);
       die();
  }
  
  
    public function gems_fetch_department_master($dept_id){
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        
        if($dept_id){
            $res_chk=$this->db->query("select id,department_name  from ".$this->db->dbprefix('staff_department_master')." where id='".$dept_id."'");
            if($res_chk->num_rows()>0){
                $result=$res_chk->result_array();
                $result=$result[0];


                $response['result']=array('id'=>$result['id'],'department_name'=>$result['department_name']);
            }else{
                
                $response['status']="failure";            
                $response['message']="Invalid Zone Id!!..";
            }
       }else{
            $response['status']="failure";            
            $response['message']="Invalid Attempt!!.. Access denied..";
       }    
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
  
  public function gems_edit_department_master(){
    
    $department_id=$this->input->post('department_id',FALSE);
    $department_name=trim($this->input->post('department_name',FALSE));
    
    if($department_id!="" && $department_name!=""){
        
        $res_chk=$this->db->query("select id from ".$this->db->dbprefix('staff_department_master')." where department_name='".$department_name."' and id!='".$department_id."'");
            if($res_chk->num_rows()>0){
                 $response['status']="failure";
                 $response['message']="Department already exists";
            }else{
                $result=$this->db->query("update ".$this->db->dbprefix('staff_department_master')."  set department_name='".$department_name."',modified_date=NOW(), modified_by='1' where id='".$department_id."'");
                if($result){
                    $response['message']="Department record updated successfully";
                }else{
                    $response['status']="failure";   
                    $response['message']="Something wrong in your input!!. Please try again..";
                }
            }
        
    }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";
    }
    
    
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
       die();
       
  }
  
  public function gems_delete_department_master($id){
    
         $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        
        if($id){            
            $this->db->query("delete from ".$this->db->dbprefix('staff_department_master')."  where id='".$id."'");
            $response['status']="success";
            $response['message']="Department record has been deleted successfully";
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";    
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
  }
  
  public function get_department_master_list(){
    
         $this->output->set_content_type('application/json');
        $response=array();
        $html='';
        $response['status']="success";
        $result=array();
        
        $res=$this->db->query("select id, department_name, DATE_FORMAT(created_date,'%d/%m/%Y')as created_date from ".$this->db->dbprefix('staff_department_master')." order by id desc");
        if($res->num_rows()>0){
            
            foreach($res->result_array() as $key=>$value){

            $html='<button type="button" class="btn btn-info btn" (click)="editdept("'.$value['id'].'")"><i class="glyphicon glyphicon-pencil"></i></button> 
                            <button type="button" class="btn btn-danger btn" (click)="deletedept("'.$value['id'].'")"><i class="glyphicon glyphicon-trash"></i></button>';


               $result[]=array('id'=>$value['id'],'department_name'=>$value['department_name'],'created_date'=>$value['created_date'],'action'=>$html); 
            }
            
        }else{
            $response['status']="failure";
            $response['message']="No Department records found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
  }

    public function gems_create_category_master()
    {
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        
        $category=trim($this->input->post('category_name',FALSE));
        
        if($category){
            
            $res_chk=$this->db->query("select id from ".$this->db->dbprefix('staff_category_master')." where staff_category_name='".$category."'");
            if($res_chk->num_rows()>0){
                 $response['status']="failure";
                 $response['message']="Category already exists";
            }else{
                    $this->db->query("insert into ".$this->db->dbprefix('staff_category_master')." (staff_category_name, created_date, created_by) values ('".$category."', NOW(),'1')");
                if($this->db->insert_id()){                
                    $response['message']="Category record has been inserted successfully";
                }else{
                    $response['status']="failure";
                    $response['message']="Something wrong in your input!!. Please try again..";
                }   
            }
            
            
            
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    }
  
  
  public function gems_fetch_category_master($id)
    {
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $res=$this->db->query("select id , staff_category_name from ".$this->db->dbprefix('staff_category_master')." where id ='".$id."'");
        if($res->num_rows()>0){
            $in_array=$res->result_array();
            $result=array("id"=>$in_array[0]['id'],'category_name'=>$in_array[0]['staff_category_name']);
        }else{
            $response['status']="failure";
            $response['message']=" No category record found!!";
        }
        $response['result']=$result;
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }

    public function gems_edit_category_master()
    {
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        
        $category=trim($this->input->post('category_name',FALSE));
        $category_id=$this->input->post('category_id',FALSE);
        
        if($category){
            
            $res_chk=$this->db->query("select id from ".$this->db->dbprefix('staff_category_master')." where staff_category_name='".$category."' and id!='".$category_id."'");
            if($res_chk->num_rows()>0){
                 $response['status']="failure";
                 $response['message']="Category already exists";
            }else{
                $result=$this->db->query("update ".$this->db->dbprefix('staff_category_master')." set staff_category_name='".$category."',modified_date=NOW(), modified_by='1' where id='".$category_id."'  ");

                if($result){                
                    $response['message']="Category record has been updated successfully";
                }else{
                    $response['status']="failure";
                    $response['message']="Something wrong in your input!!. Please try again..";
                }
                
            }            
            
            
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();        
    }
  
    public function gems_delete_category_master($id)
    {
    
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        
        if($id){            
            $this->db->query("delete from ".$this->db->dbprefix('staff_category_master')."  where id='".$id."'");
            $response['status']="success";
            $response['message']="Category record has been deleted successfully";
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";    
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    } 
  
  
   public function get_category_master_list()
    {
    
        $this->output->set_content_type('application/json');
        $response=array();
        $html='';
        $response['status']="success";
        $result=array();
        
        $res=$this->db->query("select id, staff_category_name, DATE_FORMAT(created_date,'%d/%m/%Y')as created_date from ".$this->db->dbprefix('staff_category_master')." order by id desc");
        if($res->num_rows()>0){
            
            foreach($res->result_array() as $key=>$value){

            $html='<button type="button" class="btn btn-info btn" (click)="editcategory("'.$value['id'].'")"><i class="glyphicon glyphicon-pencil"></i></button> 
                            <button type="button" class="btn btn-danger btn" (click)="deletecategory("'.$value['id'].'")"><i class="glyphicon glyphicon-trash"></i></button>';



               $result[]=array('id'=>$value['id'],'category_name'=>$value['staff_category_name'],'created_date'=>$value['created_date'],'action'=>$html); 
            }
            
        }else{
            $response['status']="failure";
            $response['message']="No Categories record found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    }
  
  
  
  
  public function gems_admin_change_password(){
    
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $login_admin_id=$this->input->post('login_admin_id',FALSE);
        $old_password=trim($this->input->post('old_password',FALSE));
        $new_password=trim($this->input->post('new_password',FALSE));
        $confirm_password=trim($this->input->post('confirm_password',FALSE));
        
        if($login_admin_id!="" && $old_password!="" && $new_password!="" && $confirm_password!=""){
            
            if($new_password==$confirm_password){
                
                $res=$this->db->query("select id from ".$this->db->dbprefix('admin_master')." where admin_password='".md5($old_password)."' ");
                if($res->num_rows()>0){
                    $result=$this->db->query("update ".$this->db->dbprefix('admin_master')." set admin_password='".MD5($new_password)."', modified_date=NOW(), modified_by='".$login_admin_id."' where id='".$login_admin_id."'");
                    if($result){
                        $response['message']="Password has been updated successfully..";
                    }else{
                        $response['status']="failure";
                        $response['message']="Something Wrong in your input.. Please try again..";
                    }
                    
                }else{
                    $response['status']="failure";
                    $response['message']="Invalid Old Password. Please try again..";   
                }
                    
            }else{
                    $response['status']="failure";
                    $response['message']="New and Confirm password doesn't match. Please try again..";
            }
            
            
        }else{
             $response['status']="failure";
             $response['message']="Invalid Attempt!!.. Any one of the input values are missed.. Access denied..";
        }
        
        
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    
    
  }
  
  
  public function gems_create_promotional_office_master(){
    
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        
        $staff_name=trim($this->input->post('staff_name',FALSE));
        $office_name=trim($this->input->post('office_name',FALSE));
        $address=trim($this->input->post('address',FALSE));
        $email=trim($this->input->post('email_address',FALSE));
        $phone_number=trim($this->input->post('phone_number',FALSE));
        $place=trim($this->input->post('office_place',FALSE));
        $state_id=trim($this->input->post('state_id',FALSE));
        $login_username=trim($this->input->post('login_username',FALSE));
        $login_password=trim($this->input->post('login_password',FALSE));
        
        if($staff_name!="" && $office_name!="" && $login_username!="" && $login_password!=""){
            
            
            
            $res_chk=$this->db->query("select id from ".$this->db->dbprefix('promotional_office_master')." where  (login_username='".$login_username."' or email_address='".$email."')");
            if($res_chk->num_rows()>0){
                $response['status']="failure";
                $response['message']="Login Username or Email address already exists. Please try again..";
            }else{
                $data=array(
                "promo_person_name"=>$staff_name,
                "promo_office_name"=>$office_name,
                "promo_office_address"=>$address,
                "email_address"=>$email,
                "phone_number"=>$phone_number,
                "promo_location"=>$place,
               // "promo_zone_location"=>'',
                "promo_state_id"=>$state_id,
                "login_username"=>$login_username,
                "login_password"=>md5($login_password),
                "created_date"=>date('Y-m-d H:i:s'),
                "created_by"=>'1'
                );

                $adminMasterdata=array(
                    "admin_username"=>$office_name,
                    "admin_password"=>md5($login_password),
                    "firstname"=>$staff_name,
                    "lastname"=>'',"date_of_birth"=>'',"gender"=>'',"qualification"=>'',"remarks"=>'',"mobile_number"=>'',"photo"=>'',"email_address"=>'',"role"=>'',"role_type_id"=>'11',"admin_zone"=>'',"created_date"=>date('Y-m-d H:i:s'),"created_by"=>'',"last_visited_date"=>'','status'=>'',"address"=>'',"address1"=>'',"state_region"=>'',"city"=>'',"zipcode"=>'',"modified_date"=>'',"modified_by"=>'',"is_deleted"=>'0'
                    );
                $this->db->insert($this->db->dbprefix('promotional_office_master'),$data);

                if($this->db->insert_id()){
                    
                     // ALSO INSERT THE PROMOTIONAL ACCOUNT IN THE DEFAULT ADMIN LOGIN TABLE 
                    
                     $this->db->insert($this->db->dbprefix('admin_master'),$adminMasterdata);
                    
                    $response['message']="Promotional Office details inserted successfully";
                }else{
                    $response['status']="failure";
                    $response['message']="Unable to insert the Promotional office details.. Please evaluate your inputs..";
                }
            }
            
        }else{
             $response['status']="failure";
             $response['message']="Invalid Attempt!!.. Any one of the input values are missed.. Access denied..";
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    
  }
  
  
  public function gems_fetch_promotional_office($id){
    
        $this->output->set_content_type('application/json');
        $response=array();        
        $response['status']="success";
        $result=array();
       if($id){
        $res=$this->db->query("select id, promo_person_name, promo_office_name, promo_office_address, email_address,phone_number, promo_location, promo_state_id, login_username from ".$this->db->dbprefix('promotional_office_master')." where id ='".$id."'");
            if($res->num_rows()>0){
                $in_array=$res->result_array();
                $in_array=$in_array[0];
                $result=array(
                "id"=>$in_array['id'],
                'person_name'=>$in_array['promo_person_name'],
                'office_name'=>$in_array['promo_office_name'],
                'email_address'=>$in_array['email_address'],
                'phone_number'=>$in_array['phone_number'],
                'location'=>$in_array['promo_location'],
                'address'=>$in_array['promo_office_address'],
                'state_id'=>$in_array['promo_state_id'],
                'login_username'=>$in_array['login_username'],
                );
                
            }else{
                $response['status']="failure";
                $response['message']="No promotional office record found..";
            }
        
       }else{
             $response['status']="failure";
             $response['message']="Invalid Attempt!!.. Any one of the input values are missed.. Access denied..";
       } 
    
        $response['result']=$result;
    
    
    echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    
  }
  
  
  public function gems_edit_promotional_office_master(){
    
    $this->output->set_content_type('application/json');
        $response=array();
        $pwd_data=array();
        $response['status']="success";
        $promo_id=$this->input->post('promo_office_id',FALSE);
        
         $staff_name=trim($this->input->post('staff_name',FALSE));
                $office_name=trim($this->input->post('office_name',FALSE));
                $address=trim($this->input->post('address',FALSE));
                $email=trim($this->input->post('email_address',FALSE));
                $phone_number=trim($this->input->post('phone_number',FALSE));
                $place=trim($this->input->post('office_place',FALSE));
                $state_id=trim($this->input->post('state_id',FALSE));
                $login_username=trim($this->input->post('login_username',FALSE));
                $login_password=trim($this->input->post('login_password',FALSE));
        
        
        $res_chk=$this->db->query("select id from ".$this->db->dbprefix('promotional_office_master')." where  (login_username='".$login_username."' or email_address='".$email."') AND id!='".$promo_id."'");
            if($res_chk->num_rows()>0){
                $response['status']="failure";
                $response['message']="Login Username or Email address already exists. Please try again..";
            }else{
                $data=array(
                "promo_person_name"=>$staff_name,
                "promo_office_name"=>$office_name,
                "promo_office_address"=>$address,
                "email_address"=>$email,
                "phone_number"=>$phone_number,
                "promo_location"=>$place,
               // "promo_zone_location"=>'',
                "promo_state_id"=>$state_id,
                "login_username"=>$login_username,                
                "modified_date"=>date('Y-m-d H:i:s'),
                "modified_by"=>'1'
                );                
                if($login_password){
                    $pwd_data=array('login_password'=>md5($login_password));
                }                
                
                $this->db->where('id',$promo_id);                
                $upd_result=$this->db->update($this->db->dbprefix('promotional_office_master'),$data);
                
                if($login_password!=""){
                    $this->db->where('id',$promo_id);
                    $this->db->update($this->db->dbprefix('promotional_office_master'),$pwd_data);
                }
                
                if($upd_result){
                    $response['message']="Promotional office record has been updated successfully";
                }
            }
        
    echo json_encode($response,JSON_UNESCAPED_SLASHES);
     die();
    
  }
  
  
  public function get_promotional_office_master_list(){
    
        global $api_path;
        $this->output->set_content_type('application/json');
        $response=array();
        $html='';
        $response['status']="success";
        $result=array();
        
        $res=$this->db->query("select id, promo_office_name, promo_person_name, email_address, promo_location,DATE_FORMAT(created_date,'%d/%m/%Y')as created_date from ".$this->db->dbprefix('promotional_office_master')." order by id desc");
        if($res->num_rows()>0){
            foreach($res->result_array() as $key=>$value){

// <button type="button" class="btn btn-primary button_edit_office" 
//                                   data-element-obj="'.$value['id'].'"><i class="glyphicon glyphicon-pencil" data-element-obj="'.$value['id'].'"></i></button> 


                            $html='<a class="btn btn-primary" href="'.$api_path.'/#/editoffice/'.$value['id'].'"><i class="glyphicon glyphicon-pencil"></i></a> 

                          <button type="button" class="btn btn-danger button_delete_office"
                                  data-element-id="'.$value['id'].'"><i class="glyphicon glyphicon-trash" data-element-id="'.$value['id'].'"></i></button>';


                $result[]=array("id"=>$value['id'],'promotional_office'=>$value['promo_office_name'],"person_name"=>$value['promo_person_name'],'location'=>$value['promo_location'],'created_date'=>$value['created_date'],'action'=>$html);
                
            }
            
        }else{
            $response['status']="failure";
            $response['message']="No promotional office list found..";
        }
        $response['result']=$result;
     echo json_encode($response,JSON_UNESCAPED_SLASHES);
     die();
     
  }
  
  public function gems_delete_promotional_office_master($id){
    
     $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        
        if($id){            
            $this->db->query("delete from ".$this->db->dbprefix('promotional_office_master')."  where id='".$id."'");
            $response['status']="success";
            $response['message']="Promotional office record has been deleted successfully";
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";    
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
  }
  
  

  // admin profile update 
  
  public function get_admin_profile_details($id){
      $response=array();
        $response['status']="success";
    
    if($id){
        $res=$this->db->query("select id, firstname, lastname, DATE_FORMAT(date_of_birth,'%d/%m/%Y')as date_of_birth, gender, qualification, remarks, mobile_number, photo, email_address from ".$this->db->dbprefix('admin_master')."  where id ='".$id."'");
        if($res->num_rows()>0){
            $in_array=$res->result_array();
            $in_array=$in_array[0];
            $result=array(
            'id'=>$in_array['id'],
            'firstname'=>$in_array['firstname'],
            'lastname'=>$in_array['lastname'],
            'date_of_birth'=>$in_array['date_of_birth'],
            'gender'=>$in_array['gender'],
            'qualification'=>$in_array['qualification'],
            'remarks'=>$in_array['remarks'],
            'mobile_number'=>$in_array['mobile_number'],
            'profile_photo'=>$in_array['photo'],
            'email_address'=>$in_array['email_address']
            );
            
            
            $response['result']=$result;                
            
            
        }else{
            $response['status']="failure";
            $response['message']="No user account details found..";
        }
                 
        
            
    }else{
        $response['status']="failure";
        $response['message']="Invalid Attempt!!.. Access denied..";
    }
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    
  }
  
  
  
  public function gems_admin_profile_update(){
        $response=array();
        $response['status']="success";
        
        $dob=date('Y-m-d',strtotime($this->input->post('date_of_birth',FALSE)));
        if($this->input->post('user_id',FALSE)){
            $data=array(
            'firstname'=>trim($this->input->post('firstname')),
            'lastname'=>trim($this->input->post('lastname')),
            
            
            
            );
            
            
            
            
        }
        
        
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    
    
  }
  
  
    // Manage News

    public function get_news_master_list(){
        $this->output->set_content_type('application/json');
        $response=array();
        $html="";
        $response['status']="success";
        $result=array();
        $res=$this->db->query("select id, news_title, DATE_FORMAT(created_date,'%d/%m/%Y')as created_date, news_content  from  ".$this->db->dbprefix('gems_news_master')." order by id desc");
        if($res->num_rows()>0){
            foreach($res->result_array() as $key=>$value){


            $html='<button type="button" class="btn btn-primary edit_button_news" 
                                  data-element-obj="'.$value['id'].'"><i class="glyphicon glyphicon-pencil" data-element-obj="'.$value['id'].'"></i></button> 

                          <button type="button" class="btn btn-danger delete_button_news"
                                  data-element-id="'.$value['id'].'"><i class="glyphicon glyphicon-trash" data-element-id="'.$value['id'].'"></i></button>';

                                                    


                $result[]=array('id'=>$value['id'],'news_title'=>$value['news_title'],'created_date'=>$value['created_date'],'news_content'=>$value['news_content'],'action'=>$html);
            }
        }else{
            $response['status']="failure";
            $response['message']="No News list found!!..";
        }
        $response['result']=$result;
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
    
    public function gems_create_news_master(){
        
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        if($this->input->post('news_title',FALSE)!=''){
            
            $news_title=trim($this->input->post('news_title',FALSE));            
            $news_content=trim($this->input->post('news_content',FALSE));   
            $res_chk=$this->db->query("select id from ".$this->db->dbprefix('gems_news_master')." where news_title='".$news_title."'");
            if($res_chk->num_rows()>0){
                    $response['status']="failure";            
                    $response['message']="Sorry!!, News Title already exists.";
                
            }else{
                $this->db->query("insert into ".$this->db->dbprefix('gems_news_master')." (news_title,news_content,created_date,created_by) values ('".$news_title."','".$news_content."',NOW(),'1')");
                if($this->db->insert_id()){
                    $response['result']=array('id'=>$this->db->insert_id());
                    $response['message']="News record stored successfully";
                }else{
                    $response['status']="failure";            
                    $response['message']="Sorry!!, Unable to insert the News data";
                }
            }
            
        }else{
                $response['status']="failure";            
                $response['message']="Sorry!!, Invalid Attempt!!.. Permission denied.";
        }
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }

    public function gems_fetch_news_master($news_id){
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        
        if($news_id!=""){
            $res_chk=$this->db->query("select id,news_title,news_content from ".$this->db->dbprefix('gems_news_master')." where id='".$news_id."'");
            if($res_chk->num_rows()>0){
                $result=$res_chk->result_array();
                $result=$result[0];

            $response['result']=array('id'=>$result['id'],'news_title'=>$result['news_title'],'news_content'=>$result['news_content']);
            }else{
                
                $response['status']="failure";            
                $response['message']="Invalid News Id!!..";
            }
       }else{
            $response['status']="failure";            
            $response['message']="Invalid Attempt!!.. Access denied..";
       }    
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }

    public function gems_edit_news_master($news_id){
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";

        if($news_id!="" && $this->input->post('news_title',FALSE)!=""){
            $news_title=trim($this->input->post('news_title',FALSE));            
            $res_chk=$this->db->query("select id from ".$this->db->dbprefix('gems_news_master')." where news_title='".$news_title."' and id!='".$news_id."'");
            if($res_chk->num_rows()>0){
                    $response['status']="failure";            
                    $response['message']="Sorry!!, News Title already exists.";
            }else{
                
                $data=array('news_title'=>$this->input->post('news_title',FALSE),'news_content'=>$this->input->post('news_content',FALSE));
                $this->db->where('id',$news_id);
                $this->db->update($this->db->dbprefix('gems_news_master'),$data);
                $response['message']="News record has been updated successfully";
            }
       }else{
            $response['status']="failure";            
            $response['message']="Invalid Attempt!!.. Access denied..";
       }    
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
    
    public function gems_delete_news_master($id){
        
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        
        if($id){
            
            $this->db->query("delete from ".$this->db->dbprefix('gems_news_master')."  where id='".$id."'");
            $response['status']="success";
            $response['message']="News record has been deleted successfully";
            
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";    
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
        
    }

    public function gems_get_module_by_path(){

    	$module_path = $this->input->post('module_path',FALSE);
    	$modulelist=$this->db->query("select * from ".$this->db->dbprefix('sidebar_menu_master')." where menu_url='".$module_path."'")->result_array();

          if(count($modulelist)>0){
          	$response['message']="";
            $response['result']=$modulelist;
          }
          else
          {
            $response['status']="failure";            
            $response['message']="";
            $response['result']=$modulelist;
           }
           echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }

    public function gems_get_security_access(){

    	$module_id = $this->input->post('module_id',FALSE);
    	$user_role_id = $this->input->post('user_role_id',FALSE);

    	$accesslist=$this->db->query("select * from ".$this->db->dbprefix('security_access')." where user_role_id='".$user_role_id."'")->result_array();

          if(count($accesslist)>0){
          	$response['message']="";
            $response['result']=$accesslist;
          }
          else
          {
            $response['status']="failure";            
            $response['message']="";
            $response['result']=$accesslist;
           }
           echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }

    public function gems_get_security_access_by_moduleid(){

        $module_id = $this->input->post('module_id',FALSE);
        $user_role_id = $this->input->post('user_role_id',FALSE);

        $accesslist=$this->db->query("select * from ".$this->db->dbprefix('security_access')." where user_role_id='".$user_role_id."' AND module_id='".$module_id."' ")->result_array();

          if(count($accesslist)>0){
            $response['message']="";
            $response['result']=$accesslist;
          }
          else
          {
            $response['status']="failure";            
            $response['message']="";
            $response['result']=$accesslist;
           }
           echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
  
  
  public function gems_fetch_sidebar_menu_module_list()
    {
       // $modulelist=Sidebarmenu::find()->where(['not',['module_id' => '0']])->all();

          $parentlist=$this->db->query("select id,menu_name,menu_url,module_id,sort_order from ".$this->db->dbprefix('sidebar_menu_master')." where is_deleted='0' AND parent!='0'")->result_array();

          if(count($parentlist)>0){
          	$response['message']="";
            $response['result']=$parentlist;
          }
          else
          {
            $response['status']="failure";            
            $response['message']="";
            $response['result']=$parentlist;
           }
           echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
  
  
  
  //side bar menu api starts here
  public function gems_fetch_sidebar_menu_master(){
       $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        $this->db->insert('package_info', $model);
       // print_r($model);die;

        echo json_encode($model,JSON_UNESCAPED_SLASHES);
        die();
    }
  //side bar menu api ends here
  
  
  public function get_cr_staff_master_list(){
    
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        
        
        
        
        
    
    
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
  }
  
  
  
  
  public function gems_create_staff_master(){
  	
     $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";                              
       // pr($this->input->post('other_addn_info_documents'));die();
        $staff_name=$this->input->post('staff_name',FALSE);
        $date_of_birth=$this->input->post('date_of_birth',FALSE);
        $date_of_birth=date("Y-m-d", strtotime($date_of_birth));

        $res_chk=$this->db->query("select id from ".$this->db->dbprefix('staff_master')." where staff_name='".$staff_name."' and  date_of_birth='".$date_of_birth."'");

        //var_dump($res_chk); die();
//print_r($staff_name);die();
            if($res_chk->num_rows()>0){
                    $response['status']="failure";            
                    $response['message']="Sorry!!, Staff name already exists.";
            }
            else if($this->input->post('staff_employee_id',FALSE)!="" && $this->input->post('staff_name',FALSE)!=""){

            		$staff_ref_id=$this->input->post('staff_ref_id',FALSE);
                    
                    $staff_cross_ref_number=$this->input->post('staff_cross_ref_number',FALSE);
                    $staff_employee_id=$this->input->post('staff_employee_id',FALSE);
                    $staff_gender=$this->input->post('staff_gender',FALSE);
                    $staff_photo_image=$this->input->post('staff_photo_image',FALSE);
                    $staff_name=$this->input->post('staff_name',FALSE);
                    $staff_name_in_certificate=$this->input->post('staff_name_in_certificate',FALSE);
                    $father_husband_name=$this->input->post('father_husband_name',FALSE);
                    $marital_status=$this->input->post('marital_status',FALSE);
                    $date_of_birth=$this->input->post('date_of_birth',FALSE);
                    $date_salvation=$this->input->post('date_salvation',FALSE);
                    $date_baptism=$this->input->post('date_baptism',FALSE);
                    $date_marriage=$this->input->post('date_marriage',FALSE);
                    $zone_id=$this->input->post('zone_id',FALSE);
                    $ad_office=$this->input->post('ad_office',FALSE);
                    $place_present=$this->input->post('place_present',FALSE);
                    $place_native=$this->input->post('place_native',FALSE);
                    $place_state=$this->input->post('place_state',FALSE);
                    $part_of_india=$this->input->post('part_of_india',FALSE);
                    $present_address=$this->input->post('present_address',FALSE);
            
                    $present_city=$this->input->post('present_city',FALSE);
                    $present_zipcode=$this->input->post('present_zipcode',FALSE);
                    $present_state_id=$this->input->post('present_state_id',FALSE);
                    $present_phone=$this->input->post('present_phone',FALSE);



                    $present_mobile=$this->input->post('present_mobile',FALSE);
                    $permanent_mobile=$this->input->post('permanent_mobile',FALSE);
                    $emergency_mobile=$this->input->post('emergency_mobile',FALSE);


                    $present_email=$this->input->post('present_email',FALSE);
                    $permanent_address=$this->input->post('permanent_address',FALSE);
            
            //
            
                    $permanent_city=$this->input->post('permanent_city',FALSE);
                    $permanent_zipcode=$this->input->post('permanent_zipcode',FALSE);
                    $permanent_state_id=$this->input->post('permanent_state_id',FALSE);
                    $permanent_phone=$this->input->post('permanent_phone',FALSE);
                    $permanent_email=$this->input->post('permanent_email',FALSE);
                    $emergency_address=$this->input->post('emergency_address',FALSE);
            
            //
                    $emergency_city=$this->input->post('emergency_city',FALSE);
                    $emergency_zipcode=$this->input->post('emergency_zipcode',FALSE);
                    $emergency_state_id=$this->input->post('emergency_state_id',FALSE);
                    $emergency_phone=$this->input->post('emergency_phone',FALSE);
                    $emergency_email=$this->input->post('emergency_email',FALSE);
                    $staff_category_id=$this->input->post('staff_category_id',FALSE);
            
            
                    $staff_identity_id=$this->input->post('staff_identity_id',FALSE);
                    $staff_designation_id=$this->input->post('staff_designation_id',FALSE);
                    $staff_department_id=$this->input->post('staff_department_id',FALSE);
                    $staff_type_id=$this->input->post('staff_type_id',FALSE);
                    $staff_academic_school=$this->input->post('staff_academic_school',FALSE);
            
            // 
            
                    $staff_academic_certificate=$this->input->post('staff_academic_certificate',FALSE);
                    $staff_academic_diploma=$this->input->post('staff_academic_diploma',FALSE);
                    $staff_secular_under_graduate=$this->input->post('staff_secular_under_graduate',FALSE);
            
                    $staff_secular_post_graduate=$this->input->post('staff_secular_post_graduate',FALSE);
                    $staff_secular_research=$this->input->post('staff_secular_research',FALSE);
                    $staff_theology_certificate=$this->input->post('staff_theology_certificate',FALSE);
            
                    $staff_theology_diploma=$this->input->post('staff_theology_diploma',FALSE);
                    $staff_theology_under_graduate=$this->input->post('staff_theology_under_graduate',FALSE);
                    $staff_theology_post_graduate=$this->input->post('staff_theology_post_graduate',FALSE);
                    $staff_theology_research=$this->input->post('staff_theology_research',FALSE);
                    $staff_any_mission_training=$this->input->post('staff_any_mission_training',FALSE);
                    $staff_academic_theology_doing=$this->input->post('staff_academic_theology_doing',FALSE);

            
                    $staff_ministrial_experience=$this->input->post('staff_ministrial_experience',FALSE);
                    $staff_date_of_joining=$this->input->post('staff_date_of_joining',FALSE);
            
                    $staff_break_period=$this->input->post('staff_break_period',FALSE);
            //
                    $staff_exp_gems=$this->input->post('staff_exp_gems',FALSE);
                    $staff_chronic_illness=$this->input->post('staff_chronic_illness',FALSE);
                    $staff_faith_of_parents=$this->input->post('staff_faith_of_parents',FALSE);

                    $staff_financial_dependency=$this->input->post('staff_financial_dependency',FALSE);
                    $staff_dedication_status=$this->input->post('staff_dedication_status',FALSE);
            
                    $staff_dedication_place=$this->input->post('staff_dedication_place',FALSE);            
                    $staff_dedication_date=$this->input->post('staff_dedication_date',FALSE);
                    $staff_dedication_information=$this->input->post('staff_dedication_information',FALSE);
                    $staff_testimony=$this->input->post('staff_testimony',FALSE);
            
                    $number_of_children=$this->input->post('number_of_children',FALSE);
                    $allowed_sponsor_allotment=$this->input->post('allowed_sponsor_allotment',FALSE);
            
                    $blood_group=$this->input->post('blood_group',FALSE);
                    $bank_account_number=$this->input->post('bank_account_number',FALSE);
                    $bank_name=$this->input->post('bank_name',FALSE);
            
            
            // additional fields 
                    $bank_ifsc_code=$this->input->post('bank_ifsc_code',FALSE);
                    $pan_card=$this->input->post('pan_card',FALSE);
                    $aadhar_number=$this->input->post('aadhar_number',FALSE);
                    $mother_ministry=$this->input->post('mother_ministry',FALSE);
                    $staff_username=$this->input->post('staff_username',FALSE);
                    $staff_password=$this->input->post('staff_password',FALSE);
                    $spouse_already_in_gems=$this->input->post('spouse_already_in_gems',FALSE);
                    $created_date=$this->input->post('created_date',FALSE);
                    $other_addn_info_documents=$this->input->post('other_addn_info_documents',FALSE);

            

            $date_of_birth=date("Y-m-d", strtotime($date_of_birth));
            
            if($date_salvation=="null")
            {
                //var_dump("HI"); die();
                $date_salvation=NULL;    
            }
            else
            {

                $date_salvation=date("Y-m-d", strtotime($date_salvation));       
            }

            if($date_baptism=="null")
            {
                $date_baptism=NULL;    
            }
            else
            {
                $date_baptism=date("Y-m-d", strtotime($date_baptism));      
            }

            if($date_marriage=="null")
            {
                $date_marriage=NULL;    
            }
            else
            {
                $date_marriage=date("Y-m-d", strtotime($date_marriage));       
            }

            if($staff_dedication_date=="null")
            {
                $staff_dedication_date=NULL;    
            }
            else
            {
                $staff_dedication_date=date("Y-m-d", strtotime($staff_dedication_date));
            }

            

if ($staff_cross_ref_number == 'undefined' ) { $staff_cross_ref_number = null; } 
if ($staff_employee_id == 'undefined' ) { $staff_employee_id = null; } 
if ($staff_gender == 'undefined' ) { $staff_gender = null; } 
if ($staff_photo_image == 'undefined' ) { $staff_photo_image = null; } 
if ($staff_name == 'undefined' ) { $staff_name = null; } 
if ($staff_name_in_certificate == 'undefined' ) { $staff_name_in_certificate = null; } 
if ($father_husband_name == 'undefined' ) { $father_husband_name = null; } 
if ($marital_status == 'undefined' ) { $marital_status = null; } 
if ($date_of_birth == 'undefined' ) { $date_of_birth = null; } 

if ($zone_id == 'undefined' ) { $zone_id = null; } 
if ($ad_office == 'undefined' ) { $ad_office = null; } 
if ($place_present == 'undefined' ) { $place_present = null; } 
if ($place_native == 'undefined' ) { $place_native = null; } 
if ($place_state == 'undefined' ) { $place_state = null; } 
if ($part_of_india == 'undefined' ) { $part_of_india = null; } 
if ($present_address == 'undefined' ) { $present_address = null; } 
if ($present_city == 'undefined' ) { $present_city = null; } 
if ($present_zipcode == 'undefined' ) { $present_zipcode = null; } 
if ($present_state_id == 'undefined' ) { $present_state_id = null; } 
if ($present_phone == 'undefined' ) { $present_phone = null; } 

if ($present_mobile == 'undefined' ) { $present_mobile = null; } 
if ($permanent_mobile == 'undefined' ) { $permanent_mobile = null; } 
if ($emergency_mobile == 'undefined' ) { $emergency_mobile = null; } 

if ($present_email == 'undefined' ) { $present_email = null; } 
if ($permanent_address == 'undefined' ) { $permanent_address = null; } 
if ($permanent_city == 'undefined' ) { $permanent_city = null; } 
if ($permanent_zipcode == 'undefined' ) { $permanent_zipcode = null; } 
if ($permanent_state_id == 'undefined' ) { $permanent_state_id = null; } 
if ($permanent_phone == 'undefined' ) { $permanent_phone = null; } 
if ($permanent_email == 'undefined' ) { $permanent_email = null; } 
if ($emergency_address == 'undefined' ) { $emergency_address = null; } 
if ($emergency_city == 'undefined' ) { $emergency_city = null; } 
if ($emergency_zipcode == 'undefined' ) { $emergency_zipcode = null; } 
if ($emergency_state_id == 'undefined' ) { $emergency_state_id = null; } 
if ($emergency_phone == 'undefined' ) { $emergency_phone = null; } 
if ($emergency_email == 'undefined' ) { $emergency_email = null; } 
if ($staff_category_id == 'undefined' ) { $staff_category_id = null; } 
if ($staff_identity_id == 'undefined' ) { $staff_identity_id = null; } 
if ($staff_designation_id == 'undefined' ) { $staff_designation_id = null; } 
if ($staff_department_id == 'undefined' ) { $staff_department_id = null; } 
if ($staff_type_id == 'undefined' ) { $staff_type_id = null; } 
if ($staff_academic_school == 'undefined' ) { $staff_academic_school = null; } 
if ($staff_academic_certificate == 'undefined' ) { $staff_academic_certificate = null; } 
if ($staff_academic_diploma == 'undefined' ) { $staff_academic_diploma = null; } 
if ($staff_secular_under_graduate == 'undefined' ) { $staff_secular_under_graduate = null; } 
if ($staff_secular_post_graduate == 'undefined' ) { $staff_secular_post_graduate = null; } 
if ($staff_secular_research == 'undefined' ) { $staff_secular_research = null; } 
if ($staff_theology_certificate == 'undefined' ) { $staff_theology_certificate = null; } 
if ($staff_theology_diploma == 'undefined' ) { $staff_theology_diploma = null; } 
if ($staff_theology_under_graduate == 'undefined' ) { $staff_theology_under_graduate = null; } 
if ($staff_theology_post_graduate == 'undefined' ) { $staff_theology_post_graduate = null; } 
if ($staff_theology_research == 'undefined' ) { $staff_theology_research = null; } 
if ($staff_any_mission_training == 'undefined' ) { $staff_any_mission_training = null; } 
if ($staff_academic_theology_doing == 'undefined' ) { $staff_academic_theology_doing = null; } 
if ($staff_ministrial_experience == 'undefined' ) { $staff_ministrial_experience = null; } 
if ($staff_date_of_joining == 'undefined' ) { $staff_date_of_joining = null; } 
if ($staff_break_period == 'undefined' ) { $staff_break_period = null; } 
if ($staff_exp_gems == 'undefined' ) { $staff_exp_gems = null; } 
if ($staff_chronic_illness == 'undefined' ) { $staff_chronic_illness = null; } 
if ($staff_faith_of_parents == 'undefined' ) { $staff_faith_of_parents = null; } 
if ($staff_financial_dependency == 'undefined' ) { $staff_financial_dependency = null; } 
if ($staff_dedication_status == 'undefined' ) { $staff_dedication_status = null; } 
if ($staff_dedication_place == 'undefined' ) { $staff_dedication_place = null; } 

if ($staff_dedication_information == 'undefined' ) { $staff_dedication_information = null; } 
if ($staff_testimony == 'undefined' ) { $staff_testimony = null; } 
if ($number_of_children == 'undefined' ) { $number_of_children = null; } 
if ($allowed_sponsor_allotment == 'undefined' ) { $allowed_sponsor_allotment = null; } 
if ($blood_group == 'undefined' ) { $blood_group = null; } 
if ($bank_account_number == 'undefined' ) { $bank_account_number = null; } 
if ($bank_name == 'undefined' ) { $bank_name = null; } 
if ($bank_ifsc_code == 'undefined' ) { $bank_ifsc_code = null; } 
if ($pan_card == 'undefined' ) { $pan_card = null; } 
if ($aadhar_number == 'undefined' ) { $aadhar_number = null; } 
if ($mother_ministry == 'undefined' ) { $mother_ministry = null; } 
if ($staff_username == 'undefined' ) { $staff_username = null; } 
if ($staff_password == 'undefined' ) { $staff_password = null; } 
if ($spouse_already_in_gems == 'undefined' ) { $spouse_already_in_gems = null; } 
if ($created_date == 'undefined' ) { $created_date = null; } 
if ($other_addn_info_documents == 'undefined' ) { $other_addn_info_documents = null; } 
            
            // INSERT BULK FIELDS

//var_dump($date_marriage); die();
//print_r($spouse_already_in_gems);print_r($staff_ref_id);die();
               

            //print_r($staff_name);die();
            $sql_insert="insert into ".$this->db->dbprefix('staff_master')."
            (
            
            staff_ref_id,
            staff_cross_ref_number,
            staff_employee_id,
            staff_gender,
            staff_photo_image,
            staff_name,
            staff_name_in_certificate,
            father_husband_name,
            marital_status,
            date_of_birth,
            date_salvation,
            date_baptism,
            date_marriage,
            zone_id,
            ad_office,
            place_present,
            place_native,
            place_state,
            part_of_india,            
            present_address,
            present_city,
            present_zipcode,
            present_state_id,
            present_phone,
            present_mobile,
            permanent_mobile,
            emergency_mobile,
            present_email,            
            permanent_address,
            permanent_city,
            permanent_zipcode,
            permanent_state_id,
            permanent_phone,
            permanent_email,            
            emergency_address,
            emergency_city,
            emergency_zipcode,
            emergency_state_id,
            emergency_phone,
            emergency_email,            
            staff_category_id,
            staff_identity_id,
            staff_designation_id,
            staff_department_id,
            staff_type_id,
            staff_academic_school,
            staff_academic_certificate,
            staff_academic_diploma,
            staff_secular_under_graduate,
            staff_secular_post_graduate,
            staff_secular_research,
            staff_theology_certificate,
            staff_theology_diploma,
            staff_theology_under_graduate,
            staff_theology_post_graduate,
            staff_theology_research,
            staff_any_mission_training,
            staff_academic_theology_doing,
            staff_ministrial_experience,
            staff_date_of_joining,
            staff_break_period,
            staff_exp_gems,
            staff_chronic_illness,
            staff_faith_of_parents,
            staff_financial_dependency,            
            staff_dedication_status,
            staff_dedication_place,
            staff_dedication_date,
            staff_dedication_information,            
            staff_testimony,
            number_of_children,
            allowed_sponsor_allotment,
            blood_group,
            bank_account_number,
            bank_name,
            bank_ifsc_code,
            pan_card,
            aadhar_number,
            mother_ministry,
            staff_username,
            staff_password,
            created_date,
            created_by,
            spouse_already_in_gems,
            other_addn_info_documents

            )values (
            '".$staff_ref_id."',
            '".$staff_cross_ref_number."',
            '".$staff_employee_id."',
            '".trim(addslashes($staff_gender))."',
            '".trim(addslashes($staff_photo_image))."',
            '".trim(addslashes($staff_name))."',
            '".trim(addslashes($staff_name_in_certificate))."',
            '".trim(addslashes($father_husband_name))."',
            '".trim(addslashes($marital_status))."',
            '".date('Y-m-d', strtotime($date_of_birth))."',
            '".$date_salvation."',
            '".$date_baptism."',
            '".$date_marriage."',
            '".trim(addslashes($zone_id))."',
            '".trim(addslashes($ad_office))."',
            '".trim(addslashes($place_present))."',
            '".trim(addslashes($place_native))."',
            '".trim(addslashes($place_state))."',
            '".trim(addslashes($part_of_india))."',
            '".trim(addslashes($present_address))."',
            '".trim(addslashes($present_city))."',
            '".trim(addslashes($present_zipcode))."',
            '".trim(addslashes($present_state_id))."',
            '".trim(addslashes($present_phone))."',
            '".trim(addslashes($present_mobile))."',
            '".trim(addslashes($permanent_mobile))."',
            '".trim(addslashes($emergency_mobile))."',
            '".trim(addslashes($present_email))."',
            '".trim(addslashes($permanent_address))."',
            '".trim(addslashes($permanent_city))."',
            '".trim(addslashes($permanent_zipcode))."',
            '".trim(addslashes($permanent_state_id))."',
            '".trim(addslashes($permanent_phone))."',
            '".trim(addslashes($permanent_email))."', 
            '".trim(addslashes($emergency_address))."',
            '".trim(addslashes($emergency_city))."',
            '".trim(addslashes($emergency_zipcode))."',
            '".trim(addslashes($emergency_state_id))."',
            '".trim(addslashes($emergency_phone))."',
            '".trim(addslashes($emergency_email))."',   
            '".trim($staff_category_id)."',
            '".trim($staff_identity_id)."',
            '".trim($staff_designation_id)."',
            '".trim($staff_department_id)."',
            '".trim($staff_type_id)."',
            '".trim(addslashes($staff_academic_school))."',
            '".trim(addslashes($staff_academic_certificate))."',
            '".trim(addslashes($staff_academic_diploma))."',
            '".trim(addslashes($staff_secular_under_graduate))."',
            '".trim(addslashes($staff_secular_post_graduate))."',
            '".trim(addslashes($staff_secular_research))."',
            '".trim(addslashes($staff_theology_certificate))."',
            '".trim(addslashes($staff_theology_diploma))."',
            '".trim(addslashes($staff_theology_under_graduate))."',
            '".trim(addslashes($staff_theology_post_graduate))."',
            '".trim(addslashes($staff_theology_research))."',
            '".trim(addslashes($staff_any_mission_training))."',
            '".trim(addslashes($staff_academic_theology_doing))."',
            '".trim(addslashes($staff_ministrial_experience))."',
            '".trim($staff_date_of_joining)."',
            '".trim($staff_break_period)."',
            '".trim($staff_exp_gems)."',
            '".trim(addslashes($staff_chronic_illness))."',
            '".trim(addslashes($staff_faith_of_parents))."',
            '".trim(addslashes($staff_financial_dependency))."',
            '".trim($staff_dedication_status)."',
            '".trim(addslashes($staff_dedication_place))."',
            '".$staff_dedication_date."',
            '".trim(addslashes($staff_dedication_information))."',
            '".trim(addslashes($staff_testimony))."',
            '".trim($number_of_children)."',
            '".trim($allowed_sponsor_allotment)."',
            '".trim($blood_group)."',
            '".trim($bank_account_number)."',
            '".trim($bank_name)."',
            '".trim($bank_ifsc_code)."',
            '".trim($pan_card)."',
            '".trim($aadhar_number)."',
            '".trim($mother_ministry)."',
            '".trim(addslashes($staff_username))."',
            '".trim(addslashes($staff_password))."',
            NOW(),
            '1',
            
            '".trim(addslashes($spouse_already_in_gems))."',
            '".trim($other_addn_info_documents)."'
            
            );
            
             "; 
	            
             
            $this->db->query($sql_insert);

            $insert_id=$this->db->insert_id();

             //pr($insert_id);die();

            if($staff_cross_ref_number==0)
            {
                if ($insert_id) {
                    $this->load->model('staff_master');

                    $update_data=array('staff_cross_ref_number'=>$insert_id);

                    $updated=$this->db->where('id', $insert_id)->update('staff_master', $update_data);
                }
            }

            /**update**/
              if ($spouse_already_in_gems==2) {

                $data=array('staff_ref_id'=>$insert_id,'spouse_already_in_gems'=>$spouse_already_in_gems,'father_husband_name'=>trim(addslashes($father_husband_name)));
                $this->db->where('id',$staff_ref_id);
                $this->db->update($this->db->dbprefix('staff_master'),$data);
                // print_r($this->db->last_query());die();
            }
            /****/


            
            $security_success_hit=$staff_cat_success_hit=$staff_exp_success_hit=0;
            $security_count=$staff_cat_count=$staff_exp_count=0;
            
            if ($insert_id) {
            	$this->load->model('staff_transfer_history');
            	$this->staff_transfer_history->save(array(
            		'fk_staff_id'=>$insert_id,
            		'staff_employee_id'=>$staff_employee_id,
            		'zone_id'=>$zone_id,
            		'department_id'=>$staff_department_id,
            		'created_date'=>date('Y-m-d H:i:s'),
            		'status'=>'2'
            	));
                
             // staff vs break period
                $breakperiod=json_decode($staff_break_period);

               
                if(!empty($breakperiod[0]->bpfrom_date))
                {
                
                    foreach ($breakperiod as $key => $value) {
                        $break_start[] = date('Y-m-d', strtotime($value->bpfrom_date));
                        $break_end[] = date('Y-m-d', strtotime($value->bpto_date));
                        $comments[] = $value->comment;
                    }
                }    

                if(!empty($break_start))
                {

                    $security_count=count($break_start);
                }
                else{
                    $security_count=0;   
                }    

                if($security_count !=0){


                    foreach($break_start as $key=>$value){                    
                        $sql_in="insert into ".$this->db->dbprefix('staff_vs_breaking_period')." (fk_staff_id,break_period_start,break_period_end,comments,created_date) values ('".$insert_id."','".$break_start[$key]."', '".$break_end[$key]."', '".$comments[$key]."',CURRENT_DATE()) ";
                        if($this->db->query($sql_in)){
                            $security_success_hit++;
                        }
                    }
                }    
                
                // staff vs category
                $dateofjoin=json_decode($staff_date_of_joining);

                if(!empty($dateofjoin[0]->cdate)){
                
                    foreach ($dateofjoin as $key => $value) {
                        $cat_start_date[] = date('Y-m-d', strtotime($value->cdate));
                        if(isset($value->cenddate))
                        {

                            $cat_end_date[] = date('Y-m-d', strtotime($value->cenddate));
                        }    
                        else
                        {
                            //$value->cenddate = NULL;
                            $cat_end_date[] = '';
                        }    
                        
                        $category_list[] = $value->cid;
                    }
                }
                
                if(!empty($category_list))
                {

                     $staff_cat_count=count($category_list);  
                }
                else{
                     $staff_cat_count=0;  
                }    

                                            
                
                if($staff_cat_count !=0){

                    foreach($category_list as $key=>$value){                    
                        $sql_in="insert into ".$this->db->dbprefix('staff_vs_category')." (fk_staff_id,category_id,start_date,end_date,created_date) values ('".$insert_id."','".$category_list[$key]."', '".$cat_start_date[$key]."', '".$cat_end_date[$key]."',CURRENT_DATE()) ";
                        if($this->db->query($sql_in)){
                            $staff_cat_success_hit++;
                        }
                    }
                }
                

                // staff vs experience
                $expgems=json_decode($staff_exp_gems);

                if(!empty($expgems[0]->department_id)){

                    foreach ($expgems as $key => $value) {
                        $department_id[] = $value->department_id;
                        $department_name[] = $value->dep_field_serve_name;
                        $exp_from_date[] = date('Y-m-d', strtotime($value->exp_from_date));

                        if(isset($value->exp_to_date))
                        {
                            $exp_to_date[] = date('Y-m-d', strtotime($value->exp_to_date));
                        }
                        else
                        {
                            $exp_to_date[] = '';
                        }    
                        
                        
                    }
                }    

               

                 if(!empty($department_id))
                {

                      $staff_exp_count=count($department_id); 
                }
                else{
                      $staff_exp_count=0;
                }    



                if($staff_exp_count !=0){

                    foreach($department_id as $key=>$value){
                        $sql_in="insert into ".$this->db->dbprefix('staff_vs_experience')." (fk_staff_id, department_id, dep_field_serve_name, exp_from_date, exp_to_date, created_date) values ('".$insert_id."','".$department_id[$key]."','".$department_name[$key]."','".$exp_from_date[$key]."','".$exp_to_date[$key]."',CURRENT_DATE()) ";    
                        if($this->db->query($sql_in)){
                            $staff_exp_success_hit++;
                        }
                    }
                }
                
            }
            
            if($insert_id && ($security_success_hit==$security_count) && ($staff_cat_success_hit==$staff_cat_count) && ($staff_exp_success_hit==$staff_exp_count)){
            	$response['result']=array('id'=>$insert_id);
            	$response['message']="Staff record stored successfully";
            }else{
            	$response['status']="failure";
            	$response['message']="Sorry!!, Unable to insert the Staff data";
            }
        }else{
        	$response['status']="failure";
        	$response['message']="Sorry!!, Invalid Attempt!!.. Permission denied.";
        }

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
  }
	
	public function get_staff_master_list(){
		$this->output->set_content_type('application/json');
		$response=array('status'=>"success");
		$result=array();
		$html="";
           global $api_path;
		
		$res=$this->db->select("staff_master.id, staff_cross_ref_number, staff_dedication_status, staff_master.region_id, zone_id, sponsor_count, staff_employee_id, staff_name, zones_staff_master.staff_zone_name as staff_zone_name, place_present, staff_category_master.staff_category_name, DATE_FORMAT(relieved_date,'%d/%m/%Y')as relieved_date, DATE_FORMAT(staff_sdamin_approve_date,'%d/%m/%Y')as approve_date")
			->join('staff_category_master', 'staff_master.staff_category_id=staff_category_master.id', 'left')
			->join('zones_staff_master', 'staff_master.zone_id=zones_staff_master.id', 'left')
			->order_by('staff_master.id', 'desc')
			->where('staff_master.staff_relief_status','NR')
			->where('staff_delete_status', '0')
            
			->get('staff_master');
		//pr($this->db->last_query());
		if($res->num_rows()>0){
			foreach($res->result_array() as $key=>$value){

				$html2='<input type="checkbox" name="chkSelect[]" class="chkSelect"  data-element-id="'.$value['staff_employee_id'].'"/>';

                $html='<a title="Staff View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewstaff/'.$value['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>';

				$result[]=array('sel'=>$html2,'id'=>$value['id'],'staff_cross_ref_number'=>$value['staff_cross_ref_number'], 'sponsor_count'=>$value['sponsor_count'],'staff_dedication_status'=>$value['staff_dedication_status'], 'zone_id'=>$value['zone_id'],'staff_employee_id'=>$value['staff_employee_id'],'staff_name'=>$value['staff_name'],'staff_zone_name'=>$value['staff_zone_name'],'place_present'=>$value['place_present'],'staff_category_name'=>$value['staff_category_name'],'relieved_date'=>$value['relieved_date'],'approve_date'=>$value['approve_date'],'action'=>$html);

                //Edit and Delete code

                // <a title="Staff Edit" style=" margin-top: 10px;" href="'.$api_path.'/#/editstaff/'.$value['id'].'"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                //<a title="Staff Relieve" style=" margin-top: 10px;" href="'.$api_path.'/#/relievestaff/'.$value['id'].'"><i class="fa fa-user-times" aria-hidden="true"></i></a>
                //<a title="Staff Enable" style=" margin-top: 10px;" href="'.$api_path.'/#/enablestaff/'.$value['id'].'"><i class="fa fa-check" aria-hidden="true"></i></a>
                // <button style=" margin-top: 10px;" type="button" class="btn btn-danger button_delete_staff" data-element-id="'.$value['id'].'"><i class="glyphicon glyphicon-trash" data-element-id="'.$value['id'].'"></i></button>
			
			}
		}else{
			$response['status']="failure";
			$response['message']="No staff list found!!..";
		}
		
		$response['result']=$result;
		die(json_encode($response, JSON_UNESCAPED_SLASHES));
	}

    public function get_staff_allot_selection_list(){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $result=array();

        $model = json_decode($this->input->post('model',FALSE));

        $html="";

        //var_dump($model); die();
        
        global $api_path;
        //print_r($model);die();
        if($model!=''){

            
            $res=$this->db->select("staff_master.id, staff_cross_ref_number, sponsor_count, staff_master.region_id, zone_id, staff_gender, staff_dedication_status, staff_employee_id, staff_name, zones_staff_master.staff_zone_name, place_present, staff_category_master.staff_category_name, DATE_FORMAT(relieved_date,'%d/%m/%Y')as relieved_date, DATE_FORMAT(staff_sdamin_approve_date,'%d/%m/%Y')as approve_date")
            ->join('staff_category_master', 'staff_master.staff_category_id=staff_category_master.id', 'left')
            ->join('zones_staff_master', 'staff_master.zone_id=zones_staff_master.id', 'left')
            ->order_by('staff_master.id', 'desc')
            ->where('staff_master.staff_relief_status','NR');
            
             if($model->sponser_missionary_preference>0) 
             {
                $res->where('staff_master.part_of_india',$model->sponser_missionary_preference);
             }  
             if($model->sponser_dedication_needed>0)              
                {
                    $res->where('staff_master.staff_dedication_status',$model->sponser_dedication_needed);
                }
            
            if(isset($model->state)&&($model->state>0))
            {   
                
               $res->where('staff_master.place_state',$model->state);
            }
            if(isset($model->zone)&&($model->zone>0))
            {
                $res->where('staff_master.zone_id',$model->zone);
            }
            if(isset($model->gender)&&($model->gender<2))
            {
                $res->where('staff_master.staff_gender',$model->gender);
            }
            if(isset($model->family_id)&&($model->family_id<2))
            {
                $res->where('staff_master.allowed_sponsor_allotment',$model->family_id);
            }
           
            $res=$res->where('staff_delete_status', '0')
            ->get('staff_master');
           // print_r($this->db->last_query());die();
        if($res->num_rows()>0){
            global $gender, $api_path;
            
                $temp_arr = array();

                foreach ($res->row() as $key => $value) {

                    if ($key=="staff_gender") {

                        $temp_arr[$key]=isset($gender[$value])?$gender[$value]:'-';
                        //var_dump($temp_arr); die();
                    }

                }
               // $response['result']=$temp_arr;
                

                
            foreach($res->result_array() as $key=>$value){
               // var_dump($result); die();

                $result[]=array('id'=>$value['id'],'staff_cross_ref_number'=>$value['staff_cross_ref_number'],'zone_id'=>$value['staff_zone_name'], 'staff_gender'=>$temp_arr['staff_gender'], 'staff_dedication_status'=>$value['staff_dedication_status'], 'staff_employee_id'=>$value['staff_employee_id'],'staff_name'=>$value['staff_name'], 'sponsor_count'=>$value['sponsor_count'],'staff_zone_name'=>$value['staff_zone_name'],'place_present'=>$value['place_present'],'staff_category_name'=>$value['staff_category_name'],'relieved_date'=>$value['relieved_date'], 'sponsor_detail'=>$model->id, 'approve_date'=>$value['approve_date']);
            
            }
        }else{
            $response['status']="failure";
            $response['message']="No staff list found!!..";
        }
        
        $response['result']=$result;
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
        }
        
        
    }
	
	public function gems_fetch_staff_master($staff_id){
		$this->output->set_content_type('application/json');
		$response=array('status'=>"success");

		$this->load->model('staff_master');
		$staff_info=$this->staff_master->get_record(array(
			'select'=>'id, staff_ref_id, staff_cross_ref_number, staff_employee_id, staff_gender, staff_photo_image, staff_name, staff_name_in_certificate, father_husband_name, mother_ministry, marital_status, date_of_birth, DATE_FORMAT(date_of_birth, "%d/%m/%Y") as std_date_of_birth, date_salvation, DATE_FORMAT(date_salvation, "%d/%m/%Y") as std_date_salvation, date_baptism, DATE_FORMAT(date_baptism, "%d/%m/%Y") as std_date_baptism, date_marriage, DATE_FORMAT(date_marriage, "%d/%m/%Y") as std_date_marriage, zone_id,ad_office, place_present, place_native, part_of_india, place_state, present_address, present_city, present_zipcode, present_state_id, present_phone, present_mobile, permanent_mobile, emergency_mobile, present_email, permanent_address, permanent_city, permanent_zipcode, permanent_state_id, permanent_phone, permanent_email, emergency_address, emergency_city, emergency_zipcode, emergency_state_id, emergency_phone, emergency_email, staff_category_id, staff_identity_id, staff_designation_id, staff_department_id, staff_type_id, staff_academic_school, staff_academic_certificate, staff_academic_diploma, staff_secular_under_graduate, staff_secular_post_graduate, staff_secular_research, staff_theology_certificate, staff_theology_diploma, staff_theology_under_graduate, staff_theology_post_graduate,staff_theology_research, staff_any_mission_training, staff_academic_theology_doing, staff_ministrial_experience, staff_date_of_joining, staff_break_period, staff_exp_gems, staff_chronic_illness, staff_faith_of_parents, staff_financial_dependency, staff_dedication_status, staff_dedication_place, staff_dedication_date, DATE_FORMAT(staff_dedication_date, "%d/%m/%Y") as std_staff_dedication_date, staff_dedication_information, staff_testimony, number_of_children, allowed_sponsor_allotment, staff_username, staff_password, created_date, DATE_FORMAT(created_date, "%d/%m/%Y") as std_created_date, created_by, modified_date, DATE_FORMAT(modified_date, "%d/%m/%Y") as std_modified_date, modified_by, staff_process_sadmin, staff_process_sadmin_date, DATE_FORMAT(staff_process_sadmin_date, "%d/%m/%Y") as std_staff_process_sadmin_date, staff_sadmin_approve, staff_sdamin_approve_date, DATE_FORMAT(staff_sdamin_approve_date, "%d/%m/%Y") as std_staff_sdamin_approve_date, staff_delete_status, staff_relief_status, last_access_time, staff_spon_allot_confirm, spouse_already_in_gems, aadhar_number, blood_group, bank_account_number, bank_name, bank_ifsc_code, pan_card, other_addn_info_documents,file_name',
			'conditions'=>array('id'=>$staff_id)
		));

                
                $res=$this->db->query("select staff_name from ".$this->db->dbprefix('staff_master')." where id='".$staff_info->staff_ref_id."'");
                $result=$res->result_array();

                if($result)
                {
                    $staff_info->spouse_det=$result[0]['staff_name'];
                }
                
                //$response['']=array('spouse_name'=>$result[0]['staff_name']);
                //print_r($staff_info);die();
                //array_push($staff_info,$result[0]);
		
		if ($staff_info!=null) {
			$response['result']=$staff_info;
		} else {
			$response['status']="failure";
			$response['message']="Invalid Staff Id!!..";
		}
		
		die(json_encode($response, JSON_UNESCAPED_SLASHES));
	}

    public function gems_fetch_staff_master_view($staff_id){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        if($staff_id!=""){
            $res_chk=$this->db->select('staff_master.id, staff_cross_ref_number, staff_employee_id, staff_gender, staff_photo_image, staff_name, staff_name_in_certificate, father_husband_name, mother_ministry, marital_status, 
                DATE_FORMAT(date_of_birth,"%d/%m/%Y") as date_of_birth, 
                DATE_FORMAT(date_salvation,"%d/%m/%Y") as date_salvation, 
                DATE_FORMAT(date_baptism,"%d/%m/%Y") as date_baptism, 
                DATE_FORMAT(date_marriage,"%d/%m/%Y") as date_marriage, zones_staff_master.staff_zone_name AS zone_id, place_present, place_native, part_of_india, state_table1.state_zone_name AS place_state, present_address, present_city, present_zipcode, state_table2.state_zone_name AS present_state_id, present_phone,present_mobile, permanent_mobile, emergency_mobile, present_email, permanent_address, permanent_city, permanent_zipcode, state_table3.state_zone_name AS permanent_state_id, permanent_phone, permanent_email, emergency_address, emergency_city, emergency_zipcode, state_table4.state_zone_name AS emergency_state_id, emergency_phone, emergency_email, staff_category_master.staff_category_name AS staff_category_id, staff_identity_id, staff_designation_master.designation_name AS staff_designation_id, staff_department_master.department_name AS staff_department_id, staff_type_id, staff_academic_school, staff_academic_certificate, staff_academic_diploma, staff_secular_under_graduate, staff_secular_post_graduate, staff_secular_research, staff_theology_certificate, staff_theology_diploma, staff_theology_under_graduate, staff_theology_post_graduate,staff_theology_research, staff_any_mission_training, staff_academic_theology_doing, staff_ministrial_experience, staff_date_of_joining, staff_break_period, staff_exp_gems, staff_chronic_illness, staff_faith_of_parents, staff_financial_dependency, staff_dedication_status, staff_dedication_place, staff_dedication_date, staff_dedication_information, staff_testimony, number_of_children, allowed_sponsor_allotment, staff_username, staff_password, staff_master.created_date, staff_master.created_by, staff_master.modified_date, staff_master.modified_by, staff_process_sadmin, staff_process_sadmin_date, staff_sadmin_approve, staff_sdamin_approve_date, staff_delete_status, staff_relief_status, last_access_time, staff_spon_allot_confirm, spouse_already_in_gems, aadhar_number, blood_group, bank_account_number, bank_name, bank_ifsc_code, pan_card, other_addn_info_documents')
                ->join('zones_staff_master', 'staff_master.zone_id=zones_staff_master.id', 'left')
                ->join('state_zone_master AS state_table1', 'staff_master.place_state=state_table1.id', 'left')
                ->join('state_zone_master AS state_table2', 'staff_master.present_state_id=state_table2.id', 'left')
                ->join('state_zone_master AS state_table3', 'staff_master.permanent_state_id=state_table3.id', 'left')
                ->join('state_zone_master AS state_table4', 'staff_master.emergency_state_id=state_table4.id', 'left')
                
                ->join('staff_department_master', 'staff_master.staff_department_id=staff_department_master.id', 'left')
                ->join('staff_category_master', 'staff_master.staff_category_id=staff_category_master.id', 'left')
                ->join('staff_designation_master', 'staff_master.staff_designation_id=staff_designation_master.id', 'left')
                ->where('staff_master.id', $staff_id)
                ->get('staff_master');
            
            if($res_chk->num_rows()>0){
                global $gender, $marital_status, $part_india, $identities, $emtypes, $blood_group, $family_position;
            
                $temp_arr = array();
                foreach ($res_chk->row() as $key => $value) {
                    if ($key=="staff_gender") {
                        $temp_arr[$key]=isset($gender[$value])?$gender[$value]:'-';
                    } else if ($key=="marital_status") {
                        $temp_arr[$key]=isset($marital_status[$value])?$marital_status[$value]:'-';
                    } else if ($key=="part_of_india") {
                        $temp_arr[$key]=isset($part_india[$value])?$part_india[$value]:'-';
                    } else if ($key=="staff_identity_id") {
                        $temp_arr[$key]=isset($identities[$value])?$identities[$value]:'-';
                    } else if ($key=="staff_type_id") {
                        $temp_arr[$key]=isset($emtypes[$value])?$emtypes[$value]:'-';
                    } else if ($key=="blood_group") {
                        $temp_arr[$key]=isset($blood_group[$value])?$blood_group[$value]:'-';
                    } else if ($key=="number_of_children") {
                        $temp_arr[$key]=isset($family_position[$value])?$family_position[$value]:'-';
                    } else {
                        $temp_arr[$key]=$value;
                    }
                }

                $response['result']=$temp_arr;
            }else{
                $response['status']="failure";
                $response['message']="Invalid Staff Id!!..";
            }
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";
        }
        
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    public function gems_fetch_staff_vs_category($staff_id) {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        if($staff_id!=""){
            $res_chk=$this->db->select('staff_vs_category.id, staff_vs_category.fk_staff_id, staff_vs_category.category_id, DATE_FORMAT(start_date,"%d/%m/%Y") as start_date, DATE_FORMAT(end_date,"%d/%m/%Y") as end_date, staff_vs_category.created_date, staff_vs_category.is_deleted, staff_category_master.staff_category_name')
                ->join('staff_category_master', 'staff_vs_category.category_id=staff_category_master.id', 'left')
                ->where('staff_vs_category.fk_staff_id', $staff_id)
                ->where('staff_vs_category.is_deleted', '0')
                ->get('staff_vs_category');
            
            if($res_chk->num_rows()>0){
                $response['result']=$res_chk->result();
                $response['message']="Staff category details retrieved successfully";
            }else{
                $response['status']="failure";
                $response['message']="Invalid Staff Id!!..";
            }
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";
        }
        
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    public function gems_fetch_staff_vs_breaking_period($staff_id){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        if($staff_id!=""){
            $res_chk=$this->db->select('id, fk_staff_id, DATE_FORMAT(break_period_start,"%d/%m/%Y") as break_period_start, DATE_FORMAT(break_period_end,"%d/%m/%Y") as break_period_end, comments, created_date, is_deleted')
                ->where('fk_staff_id', $staff_id)
                ->get('staff_vs_breaking_period');
            
            if($res_chk->num_rows()>0){
                $response['result']=$res_chk->result();
                $response['message']="Staff breaking period details retrieved successfully";
            }else{
                $response['status']="failure";
                $response['message']="Invalid Staff Id!!..";
            }
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";
        }
        
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    public function gems_fetch_staff_vs_experience($staff_id){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        if($staff_id!=""){
            $res_chk=$this->db->select('staff_vs_experience.id, staff_vs_experience.fk_staff_id, staff_vs_experience.department_id, staff_vs_experience.dep_field_serve_name, DATE_FORMAT(exp_from_date,"%d/%m/%Y") as exp_from_date, DATE_FORMAT(exp_to_date,"%d/%m/%Y") as exp_to_date, staff_vs_experience.created_date, staff_vs_experience.is_deleted, staff_department_master.department_name')
                ->join('staff_department_master', 'staff_vs_experience.department_id=staff_department_master.id')
                ->where('staff_vs_experience.fk_staff_id', $staff_id)
                ->order_by('staff_vs_experience.id', 'asc')
                ->get('staff_vs_experience');
            
            if($res_chk->num_rows()>0){
                $response['result']=$res_chk->result();
                $response['message']="Staff experience details retrieved successfully";
            }else{
                $response['status']="failure";
                $response['message']="Invalid Staff Id!!..";
            }
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";
        }
        
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

	public function gems_edit_staff_master($staff_id){
		$this->output->set_content_type('application/json');
		$response=array('status'=>"success");

		if($this->input->post('staff_cross_ref_number',FALSE)!="" && $this->input->post('staff_name',FALSE)!=""){

                    $staff_ref_id=$this->input->post('staff_ref_id',FALSE);
                    $staff_cross_ref_number=$this->input->post('staff_cross_ref_number',FALSE);
                    $staff_employee_id=$this->input->post('staff_employee_id',FALSE);
                    $staff_gender=$this->input->post('staff_gender',FALSE);
                    $staff_photo_image=$this->input->post('staff_photo_image',FALSE);
                    $staff_name=$this->input->post('staff_name',FALSE);
                    $staff_name_in_certificate=$this->input->post('staff_name_in_certificate',FALSE);
                    $father_husband_name=$this->input->post('father_husband_name',FALSE);
                    $marital_status=$this->input->post('marital_status',FALSE);
                    $date_of_birth=$this->input->post('date_of_birth',FALSE);
                    $date_salvation=$this->input->post('date_salvation',FALSE);
                    $date_baptism=$this->input->post('date_baptism',FALSE);
                    $date_marriage=$this->input->post('date_marriage',FALSE);
                    $zone_id=$this->input->post('zone_id',FALSE);
                    $place_present=$this->input->post('place_present',FALSE);
                    $place_native=$this->input->post('place_native',FALSE);
                    $place_state=$this->input->post('place_state',FALSE);
                    $part_of_india=$this->input->post('part_of_india',FALSE);
                    $present_address=$this->input->post('present_address',FALSE);
            
                    $present_city=$this->input->post('present_city',FALSE);
                    $present_zipcode=$this->input->post('present_zipcode',FALSE);
                    $present_state_id=$this->input->post('present_state_id',FALSE);
                    $present_phone=$this->input->post('present_phone',FALSE);

                    $present_mobile=$this->input->post('present_mobile',FALSE);
                    $permanent_mobile=$this->input->post('permanent_mobile',FALSE);
                    $emergency_mobile=$this->input->post('emergency_mobile',FALSE);


                    $present_email=$this->input->post('present_email',FALSE);
                    $permanent_address=$this->input->post('permanent_address',FALSE);
            
            //
            
                    $permanent_city=$this->input->post('permanent_city',FALSE);
                    $permanent_zipcode=$this->input->post('permanent_zipcode',FALSE);
                    $permanent_state_id=$this->input->post('permanent_state_id',FALSE);
                    $permanent_phone=$this->input->post('permanent_phone',FALSE);
                    $permanent_email=$this->input->post('permanent_email',FALSE);
                    $emergency_address=$this->input->post('emergency_address',FALSE);
            
            //
                    $emergency_city=$this->input->post('emergency_city',FALSE);
                    $emergency_zipcode=$this->input->post('emergency_zipcode',FALSE);
                    $emergency_state_id=$this->input->post('emergency_state_id',FALSE);
                    $emergency_phone=$this->input->post('emergency_phone',FALSE);
                    $emergency_email=$this->input->post('emergency_email',FALSE);
                    $staff_category_id=$this->input->post('staff_category_id',FALSE);
            
            
                    $staff_identity_id=$this->input->post('staff_identity_id',FALSE);
                    $staff_designation_id=$this->input->post('staff_designation_id',FALSE);
                    $staff_department_id=$this->input->post('staff_department_id',FALSE);
                    $staff_type_id=$this->input->post('staff_type_id',FALSE);
                    $staff_academic_school=$this->input->post('staff_academic_school',FALSE);
            
            // 
            
                    $staff_academic_certificate=$this->input->post('staff_academic_certificate',FALSE);
                    $staff_academic_diploma=$this->input->post('staff_academic_diploma',FALSE);
                    $staff_secular_under_graduate=$this->input->post('staff_secular_under_graduate',FALSE);
            
                    $staff_secular_post_graduate=$this->input->post('staff_secular_post_graduate',FALSE);
                    $staff_secular_research=$this->input->post('staff_secular_research',FALSE);
                    $staff_theology_certificate=$this->input->post('staff_theology_certificate',FALSE);
            
                    $staff_theology_diploma=$this->input->post('staff_theology_diploma',FALSE);
                    $staff_theology_under_graduate=$this->input->post('staff_theology_under_graduate',FALSE);
                    $staff_theology_post_graduate=$this->input->post('staff_theology_post_graduate',FALSE);
                    $staff_theology_research=$this->input->post('staff_theology_research',FALSE);
                    $staff_any_mission_training=$this->input->post('staff_any_mission_training',FALSE);
                    $staff_academic_theology_doing=$this->input->post('staff_academic_theology_doing',FALSE);

            
                    $staff_ministrial_experience=$this->input->post('staff_ministrial_experience',FALSE);
                    $staff_date_of_joining=$this->input->post('staff_date_of_joining',FALSE);
            
                    $staff_break_period=$this->input->post('staff_break_period',FALSE);
            //
                    $staff_exp_gems=$this->input->post('staff_exp_gems',FALSE);
                    $staff_chronic_illness=$this->input->post('staff_chronic_illness',FALSE);
                    $staff_faith_of_parents=$this->input->post('staff_faith_of_parents',FALSE);

                    $staff_financial_dependency=$this->input->post('staff_financial_dependency',FALSE);
                    $staff_dedication_status=$this->input->post('staff_dedication_status',FALSE);
            
                    $staff_dedication_place=$this->input->post('staff_dedication_place',FALSE);            
                    $staff_dedication_date=$this->input->post('staff_dedication_date',FALSE);
                    $staff_dedication_information=$this->input->post('staff_dedication_information',FALSE);
                    $staff_testimony=$this->input->post('staff_testimony',FALSE);
            
                    $number_of_children=$this->input->post('number_of_children',FALSE);
                    $allowed_sponsor_allotment=$this->input->post('allowed_sponsor_allotment',FALSE);
            
                    $blood_group=$this->input->post('blood_group',FALSE);
                    $bank_account_number=$this->input->post('bank_account_number',FALSE);
                    $bank_name=$this->input->post('bank_name',FALSE);
            
            
            // additional fields 
                    $bank_ifsc_code=$this->input->post('bank_ifsc_code',FALSE);
                    $pan_card=$this->input->post('pan_card',FALSE);
                    $aadhar_number=$this->input->post('aadhar_number',FALSE);
                    $mother_ministry=$this->input->post('mother_ministry',FALSE);
                    $staff_username=$this->input->post('staff_username',FALSE);
                    $staff_password=$this->input->post('staff_password',FALSE);
                    $spouse_already_in_gems=$this->input->post('spouse_already_in_gems',FALSE);
                    $created_date=$this->input->post('created_date',FALSE);
                    $other_addn_info_documents=$this->input->post('other_addn_info_documents',FALSE);

                    $dateofjoin=json_decode($staff_date_of_joining);
                   
                    $staff_date_edit = array();
                    foreach ($dateofjoin as $key => $value) {
                         
                        if(isset($value->is_deleted))
                        {   
                            if($value->is_deleted=='0')
                            {
                                $staff_date_edit[] = $value;
                            }
                            
                        }
                        else
                        {
                          $staff_date_edit[] = $value;
                        }
                    }
                    $staff_date_edit=json_encode($staff_date_edit);

                    $breakperiodedit=json_decode($staff_break_period);
                   
                    $staff_break_edit = array();
                    foreach ($breakperiodedit as $key => $value) {
                         
                        if(isset($value->is_deleted))
                        {   
                            if($value->is_deleted=='0')
                            {
                                $staff_break_edit[] = $value;
                            }
                            
                        }
                        else
                        {
                          $staff_break_edit[] = $value;
                        }
                    }
                    $staff_break_edit=json_encode($staff_break_edit);


                    $staffexpedit=json_decode($staff_exp_gems);
                   
                    $staff_exp_edit = array();
                    foreach ($staffexpedit as $key => $value) {
                         
                        if(isset($value->is_deleted))
                        {   
                            if($value->is_deleted=='0')
                            {
                                $staff_exp_edit[] = $value;
                            }
                            
                        }
                        else
                        {
                          $staff_exp_edit[] = $value;
                        }
                    }
                    $staff_exp_edit=json_encode($staff_exp_edit);

                    
                //var_dump($staff_date_edit); die();
            
            $update_data=array(
            	'staff_ref_id'=>$staff_ref_id,
            	'staff_cross_ref_number'=>$staff_cross_ref_number,
                'staff_photo_image'=>$staff_photo_image,
				'staff_employee_id'=>$staff_employee_id,
				'staff_gender'=>trim(addslashes($staff_gender)),
				'staff_name'=>trim(addslashes($staff_name)),
				'staff_name_in_certificate'=>trim(addslashes($staff_name_in_certificate)),
				'father_husband_name'=>trim(addslashes($father_husband_name)),
				'marital_status'=>trim(addslashes($marital_status)),
				'date_of_birth'=>date('Y-m-d', strtotime($date_of_birth)),
				'date_salvation'=>date('Y-m-d', strtotime($date_salvation)),
				'date_baptism'=>date('Y-m-d', strtotime($date_baptism)),
				'date_marriage'=>date('Y-m-d', strtotime($date_marriage)),
				'zone_id'=>trim(addslashes($zone_id)),
				'place_present'=>trim(addslashes($place_present)),
				'place_native'=>trim(addslashes($place_native)),
				'part_of_india'=>trim(addslashes($part_of_india)),
				'present_address'=>trim(addslashes($present_address)),
				'present_city'=>trim(addslashes($present_city)),
				'present_zipcode'=>trim(addslashes($present_zipcode)),
				'present_state_id'=>trim(addslashes($present_state_id)),
				'present_phone'=>trim(addslashes($present_phone)),
                'present_mobile'=>trim(addslashes($present_mobile)),
                'permanent_mobile'=>trim(addslashes($permanent_mobile)),
                'emergency_mobile'=>trim(addslashes($emergency_mobile)),
				'present_email'=>trim(addslashes($present_email)),
				'permanent_address'=>trim(addslashes($permanent_address)),
				'permanent_city'=>trim(addslashes($permanent_city)),
				'permanent_zipcode'=>trim(addslashes($permanent_zipcode)),
				'permanent_state_id'=>trim(addslashes($permanent_state_id)),
				'permanent_phone'=>trim(addslashes($permanent_phone)),
				'permanent_email'=>trim(addslashes($permanent_email)),
				'emergency_address'=>trim(addslashes($emergency_address)),
				'emergency_city'=>trim(addslashes($emergency_city)),
				'emergency_zipcode'=>trim(addslashes($emergency_zipcode)),
				'emergency_state_id'=>trim(addslashes($emergency_state_id)),
				'emergency_phone'=>trim(addslashes($emergency_phone)),
				'emergency_email'=>trim(addslashes($emergency_email)),
				'staff_category_id'=>trim($staff_category_id),
				'staff_identity_id'=>trim($staff_identity_id),
				'staff_designation_id'=>trim($staff_designation_id),
				'staff_department_id'=>trim($staff_department_id),
				'staff_type_id'=>trim($staff_type_id),
				'staff_academic_school'=>trim(addslashes($staff_academic_school)),
				'staff_academic_certificate'=>trim(addslashes($staff_academic_certificate)),
				'staff_academic_diploma'=>trim(addslashes($staff_academic_diploma)),
				'staff_secular_under_graduate'=>trim(addslashes($staff_secular_under_graduate)),
				'staff_secular_post_graduate'=>trim(addslashes($staff_secular_post_graduate)),
				'staff_secular_research'=>trim(addslashes($staff_secular_research)),
				'staff_theology_certificate'=>trim(addslashes($staff_theology_certificate)),
				'staff_theology_diploma'=>trim(addslashes($staff_theology_diploma)),
				'staff_theology_under_graduate'=>trim(addslashes($staff_theology_under_graduate)),
				'staff_theology_post_graduate'=>trim(addslashes($staff_theology_post_graduate)),
                'staff_theology_research'=>trim(addslashes($staff_theology_research)),
				'staff_any_mission_training'=>trim(addslashes($staff_any_mission_training)),
				'staff_academic_theology_doing'=>trim(addslashes($staff_academic_theology_doing)),
				'staff_ministrial_experience'=>trim(addslashes($staff_ministrial_experience)),
				'staff_date_of_joining'=>trim($staff_date_edit),
                'staff_break_period'=>trim($staff_break_edit),
                'staff_exp_gems'=>trim($staff_exp_edit),
				'staff_chronic_illness'=>trim(addslashes($staff_chronic_illness)),
				'staff_faith_of_parents'=>trim(addslashes($staff_faith_of_parents)),
				'staff_financial_dependency'=>trim(addslashes($staff_financial_dependency)),
				'staff_dedication_status'=>trim($staff_dedication_status),
				'staff_dedication_place'=>trim(addslashes($staff_dedication_place)),
				'staff_dedication_date'=>date('Y-m-d', strtotime($staff_dedication_date)),
				'staff_dedication_information'=>trim(addslashes($staff_dedication_information)),
				'staff_testimony'=>trim(addslashes($staff_testimony)),
				'number_of_children'=>trim($number_of_children),
				'allowed_sponsor_allotment'=>trim($allowed_sponsor_allotment),
				'staff_username'=>trim(addslashes($staff_username)),
				'staff_password'=>trim(addslashes($staff_password)),
				'spouse_already_in_gems'=>trim($spouse_already_in_gems),
				'aadhar_number'=>trim($aadhar_number),
				'blood_group'=>trim($blood_group),
				'bank_account_number'=>trim($bank_account_number),
				'bank_name'=>trim($bank_name),
				'bank_ifsc_code'=>trim($bank_ifsc_code),
				'pan_card'=>trim($pan_card),
                'created_date'=>'NOW()',
                'created_by'=>'1',
                'other_addn_info_documents'=>trim($other_addn_info_documents),
            );
            
            // UPDATE BULK FIELDS
            $updated=$this->db->where('id', $staff_id)->update('staff_master', $update_data);


            if ($spouse_already_in_gems==2) {

                $data=array('staff_ref_id'=>$staff_id,'spouse_already_in_gems'=>$spouse_already_in_gems,'father_husband_name'=>trim(addslashes($father_husband_name)));
                $this->db->where('id',$staff_ref_id);
                $this->db->update($this->db->dbprefix('staff_master'),$data);
                // print_r($this->db->last_query());die();
            }
            
            $staff_cat_success_hit=$staff_breaking_success_hit=$staff_exp_success_hit=0;
            $staff_cat_count=$staff_breaking_count=$staff_exp_count=0;
            
			if($updated==true){

                // staff vs category =================================================
                $category_list=json_decode($staff_date_of_joining);
                $staff_cat_count=count($category_list);

                if(!empty($category_list[0]->cid))
                {
                
                    foreach($category_list as $key=>$value){

                        if(isset($value->cenddate))
                        {

                            $end_date = date('Y-m-d', strtotime($value->cenddate));
                        }    
                        else
                        {
                            $end_date = '';
                        }    

                        $db_data=array(
                            'fk_staff_id'=>$staff_id,
                            'category_id'=>$value->cid,
                            'start_date'=>date('Y-m-d', strtotime($value->cdate)),
                            'end_date' => $end_date,
                            'is_deleted'=>isset($value->is_deleted)?$value->is_deleted:'0'
                        );

                        if(isset($value->id)) {
                            $db_result=$this->db->where('id', $value->id)->update('staff_vs_category', $db_data);
                        }else{
                            $db_data['created_date']='CURRENT_DATE()';
                            $db_result=$this->db->insert('staff_vs_category', $db_data);
                        }

                        if($db_result==true){
                            $staff_cat_success_hit++;
                        }
                    }
                }
                
                // staff vs break period =================================================
                $break_period_list=json_decode($staff_break_period);
                $staff_breaking_count=count($break_period_list);

                if(!empty($break_period_list[0]->bpfrom_date))
                {
                
                    foreach($break_period_list as $key=>$value){

                        if(isset($value->bpto_date))
                        {

                            $break_period_end =date('Y-m-d', strtotime($value->bpto_date));
                        }
                        else
                        {
                            $break_period_end = '';
                        }  

                    	$db_data=array(
                    		'fk_staff_id'=>$staff_id,
                    		'break_period_start'=>date('Y-m-d', strtotime($value->bpfrom_date)),
                    		'break_period_end'=>$break_period_end,
                    		'comments'=>$value->comment,
                    		'is_deleted'=>isset($value->is_deleted)?$value->is_deleted:'0'
                    	);
                    	
                    	if(isset($value->id)) {
                    		$db_result=$this->db->where('id', $value->id)->update('staff_vs_breaking_period', $db_data);
                    	}else{
                    		$db_data['created_date']='CURRENT_DATE()';
                    		$db_result=$this->db->insert('staff_vs_breaking_period', $db_data);
                    	}
                    	
                        if($db_result==true){
                        	$staff_breaking_success_hit++;
                        }
                    }
                 }   
                // staff vs experience =================================================
                $staff_exp_list=json_decode($staff_exp_gems);
                $staff_exp_count=count($staff_exp_list);

                if(!empty($staff_exp_list[0]->department_id))
                {
                
                    foreach($staff_exp_list as $key=>$value){

                        if(isset($value->exp_to_date))
                        {
                            $exp_to_date = date('Y-m-d', strtotime($value->exp_to_date));
                        }
                        else
                        {
                            $exp_to_date = '';
                        }  

                    	$db_data=array(
                    		'fk_staff_id'=>$staff_id,
                    		'department_id'=>$value->department_id,
                    		'dep_field_serve_name'=>$value->dep_field_serve_name,
                    		'exp_from_date'=>date('Y-m-d', strtotime($value->exp_from_date)),
                    		'exp_to_date'=>$exp_to_date,
                    		'is_deleted'=>isset($value->is_deleted)?$value->is_deleted:'0'
                    	);

                    	if(isset($value->id)) {
                    		$db_result=$this->db->where('id', $value->id)->update('staff_vs_experience', $db_data);
                    	}else{
                    		$db_data['created_date']='CURRENT_DATE()';
                    		$db_result=$this->db->insert('staff_vs_experience', $db_data);
                    	}

                        if($db_result==true){
                        	$staff_exp_success_hit++;
                        }
                    }
                }
            }
            // echo $updated."2".$staff_cat_success_hit."==".$staff_cat_count."3".$staff_breaking_success_hit."==".$staff_breaking_count."4".$staff_exp_success_hit."==".$staff_exp_count;
            // die(); 
            if($updated==true && ($staff_cat_success_hit==$staff_cat_count) && ($staff_breaking_success_hit==$staff_breaking_count) && ($staff_exp_success_hit==$staff_exp_count)){
            	$response['message']="Staff record has been updated successfully";
            }else{
            	$response['status']="success";
            	$response['message']="Sorry!!, Unable to update the Staff data";
            }
        }else{
        	$response['status']="failure";
        	$response['message']="Sorry!!, Invalid Attempt!!.. Permission denied.";
        }   
		
		die(json_encode($response, JSON_UNESCAPED_SLASHES));
	}

	public function gems_delete_staff_master($id){
		$this->output->set_content_type('application/json');
		$response=array('status'=>"success");

		if($id){
			$this->db->where('id', $id)->update('staff_master', array('staff_delete_status'=>'1'));
			$response['status']="success";
			$response['message']="Staff record has been deleted successfully";
		}else{
			$response['status']="failure";
			$response['message']="Invalid Attempt!!.. Access denied..";    
		}
		
		die(json_encode($response, JSON_UNESCAPED_SLASHES));
	}


    public function gems_create_region_master()
    {
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        
        $region=trim($this->input->post('region_name',FALSE));
        $email_id=trim($this->input->post('email_id',FALSE));
        $created_by=trim($this->input->post('created_by',FALSE));
        
        if($region){
            
            $res_chk=$this->db->query("select id from ".$this->db->dbprefix('region_master')." where region_name='".$region."'");
            if($res_chk->num_rows()>0){
                 $response['status']="failure";
                 $response['message']="Region already exists";
            }else{
                    $this->db->query("insert into ".$this->db->dbprefix('region_master')." (region_name,email_id, created_date, created_by) 
                        values 
                        ('".$region."',
                        '".$email_id."', 
                            NOW(),
                        '".$created_by."')");
                if($this->db->insert_id()){                
                    $response['message']="Region record has been inserted successfully";
                }else{
                    $response['status']="failure";
                    $response['message']="Something wrong in your input!!. Please try again..";
                }   
            }
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    }
    
    public function gems_fetch_region_master($id)
    {
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $res=$this->db->query("select id, region_name, email_id from ".$this->db->dbprefix('region_master')." where id ='".$id."'");
        if($res->num_rows()>0){
            $in_array=$res->result_array();
            $result=array("id"=>$in_array[0]['id'],'region_name'=>$in_array[0]['region_name'],'email_id'=>$in_array[0]['email_id']);
        }else{
            $response['status']="failure";
            $response['message']=" No Region record found!!";
        }
        $response['result']=$result;
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }

    public function gems_edit_region_master()
    {
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        
        $region=trim($this->input->post('region_name',FALSE));
        $region_id=$this->input->post('region_id',FALSE);
        $email_id=$this->input->post('email_id',FALSE);
        $modified_by=trim($this->input->post('modified_by',FALSE));
        
        if($region){
            
            $res_chk=$this->db->query("select id from ".$this->db->dbprefix('region_master')." where region_name='".$region."' and id!='".$region_id."'");
            if($res_chk->num_rows()>0){
                 $response['status']="failure";
                 $response['message']="Region already exists";
            }else{
                $result=$this->db->query("update ".$this->db->dbprefix('region_master')." set region_name='".$region."', email_id='".$email_id."', modified_date=NOW(), modified_by='".$modified_by."' where id='".$region_id."'  ");

                if($result){                
                    $response['message']="Region record has been updated successfully";
                }else{
                    $response['status']="failure";
                    $response['message']="Something wrong in your input!!. Please try again..";
                }
                
            }            
            
            
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();        
    }
  
    public function gems_delete_region_master($id)
    {
    
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        
        if($id){            
            $this->db->query("delete from ".$this->db->dbprefix('region_master')."  where id='".$id."'");
            $response['status']="success";
            $response['message']="Region record has been deleted successfully";
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";    
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    } 
  
    public function get_region_master_list()
    {
    
        $this->output->set_content_type('application/json');
        $response=array();
        $html='';
        $response['status']="success";
        $result=array();
        
        $res=$this->db->query("select id, region_name, email_id, DATE_FORMAT(created_date,'%d/%m/%Y')as created_date from ".$this->db->dbprefix('region_master')." order by id desc");
        if($res->num_rows()>0){
            
            foreach($res->result_array() as $key=>$value){

            $html='<button type="button" class="btn btn-primary button_edit_region" 
                                  data-element-obj="'.$value['id'].'"><i class="glyphicon glyphicon-pencil" data-element-obj="'.$value['id'].'"></i></button> 

                          <button type="button" class="btn btn-danger button_delete_region"
                                  data-element-id="'.$value['id'].'"><i class="glyphicon glyphicon-trash" data-element-id="'.$value['id'].'"></i></button>';



               $result[]=array('id'=>$value['id'],'region_name'=>$value['region_name'], 'email_id'=>$value['email_id'], 'created_date'=>$value['created_date'],'action'=>$html); 
            }
            
        }else{
            $response['status']="failure";
            $response['message']="No Region record found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    }



    public function gems_relieve_staffs() {
    	$this->output->set_content_type('application/json');
		$response=array('status'=>"success");
    	
    	$arr = $this->input->post('chkSelect');
        $reason_for_relieving=$this->input->post('relieved_reason');
       // print_r($this->input->post('relieved_reason'));die();
    	$staff_ids = explode(",", $arr);
       // print_r($staff_ids);die();

        $mail_list=array();
    	if (is_array($staff_ids) && count($staff_ids)>0) {
    		
    		$success_count = 0;
    		foreach ($staff_ids as $staff_id) {

                /******Get the Mail to corressponding heads while on relieving staff*****/

                    /***Zone Head***/
                     $get_zone_id= $this->db->select("staff_name,zone_id,region_id") ->where('staff_employee_id',$staff_id) ->get('staff_master');

                     $zone_id_list=$get_zone_id->result_array();

                     $staff_name_to_relieve=$zone_id_list[0]['staff_name'];

                     $get_zone_head_mail = $this->db->select("staff_zone_name,email_id") ->where('id',$zone_id_list[0]['zone_id']) ->get('zones_staff_master');

                     
                     
                     $get_zone_head_mail_list=$get_zone_head_mail->result_array();

                     $zone_name_to_relieve=$get_zone_head_mail_list[0]['staff_zone_name'];

                     array_push($mail_list,$get_zone_head_mail_list[0]['email_id']);
                     /******/

                      /***Region Head***/                    

                        $get_region_head_mail = $this->db->select("email_id") ->where('id',$zone_id_list[0]['region_id']) ->get('region_master');

                        $get_region_head_mail_list=$get_region_head_mail->result_array();
                        if($get_region_head_mail_list[0]['email_id']){
                           array_push($mail_list,$get_region_head_mail_list[0]['email_id']); 
                        }

                     /******/

                     /***R&D Head***/                    

                     $get_church_head_mail = $this->db->select("email_id") ->where('staff_id',$staff_id) ->get('church_master');

                     $get_church_head_mail_list=$get_church_head_mail->result_array();

                     if($get_church_head_mail_list[0]['email_id']){array_push($mail_list,$get_region_head_mail_list[0]['email_id']);}
                     
                    
                     /******/

                 /******************/
                    

    			if ($this->db->where('staff_employee_id', $staff_id)->update('staff_master', array('staff_relief_status' => 'SR', 'relieved_date' =>date('Y-m-d H:i:s'), 'allowed_sponsor_allotment' => '1','relieved_reason'=>$reason_for_relieving))) {

    				$res=$this->db->query("select id, missionary_emp_id,sponsor_id from ".$this->db->dbprefix('allot_missionary')." where missionary_emp_id ='".$staff_id."'");

    			

                    /******Sponsor Mail Id*****/
                         $db_det=$res->result_array();

                         $get_sponsor_head_mail = $this->db->select("sponser_email") ->where('id',$db_det[0]['sponsor_id']) ->get('sponsor_master');

                         $get_sponsor_head_mail_list=$get_sponsor_head_mail->result_array();

                         array_push($mail_list,$get_sponsor_head_mail_list[0]['sponser_email']);
                     /*************/


                     $message_info="Dear All,<br>
                                    Greetings in the name of our Lord Jesus Christ.
                                    <br>
                                    <br>
                                    This is to inform all concerned that Bro./Sis. <b>" .$staff_name_to_relieve. " </b>from  <b>".$zone_name_to_relieve."</b> zone has been relieved .
                                    <br>                                    
                                    <br>
                                    In His Service,<br>
                                    Human Resources Dept.<br>
                                    GEMS, Bihar";

                        $this->load->library('email');
                        //$this->email->from('sridhar.muthusamy@aesasp.com');
                        $this->email->from('hr@gemsbihar.org');
                        $this->email->to($mail_list);
                        $this->email->subject('Staff Relieving Information');
                        $this->email->message($message_info);
                        try{
                        $this->email->send();

                        //var_dump($this->email->send()); die();
                        //echo 'Message has been sent.';

                        $response['message']="Staff transfer record has been updated successfully";


                        }catch(Exception $e){
                        //echo $e->getMessage();
                        }
    				if($res->result_array())
    				{
    					//var_dump("okkk"); die();
    					$this->db->where('missionary_emp_id', $staff_id)->update('allot_missionary', array('revert_sponsorship' => '0'));
    				}
    				else
    				{
    					//var_dump($res->result_array()); die();

    					$this->db->query("insert into ".$this->db->dbprefix('allot_missionary')." 
    						(missionary_emp_id,
    						 sponsor_id,
    						 sadmin_allot_approve,
    						 revert_sponsorship
    						 ) 
				                        values 
				                        ('".$staff_id."',
				                        '1', 
				                        '0',
				                        '0')");
    				}
    				
    				$success_count++;
    			}
                                
    		}


    		if (count($staff_ids)==$success_count) {
    			$response['message']="Staff relieve status has been updated successfully";
    		} else {
    			$response['status']="failure";
    			$response['message']="Staff relieve status has not been updated fully";
    		}
    	} else {
    		$response['status']="failure";
    		$response['message']="Choose staff and continue!!..";
    	}

    	die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    public function gems_approve_staffs() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        
        $arr = $this->input->post('chkSelect');
        $staff_ids = explode(",", $arr);

        if (is_array($staff_ids) && count($staff_ids)>0) {
            
            $success_count = 0;
            foreach ($staff_ids as $staff_id) {
                if ($this->db->where('staff_employee_id', $staff_id)->update('staff_master', array('staff_sadmin_approve' => '1', 'staff_sdamin_approve_date' =>date('Y-m-d H:i:s')))) {
                    $success_count++;
                }
            }

            if (count($staff_ids)==$success_count) {
                $response['message']="Staff Approve status has been updated successfully";
            } else {
                $response['status']="failure";
                $response['message']="Staff Approve status has not been updated fully";
            }
        } else {
            $response['status']="failure";
            $response['message']="Choose staff and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }



    public function gems_approve_church() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        
        // $arr = $this->input->post('chkSelect');
        // $staff_ids = explode(",", $arr);


         $model = json_decode($this->input->post('model',FALSE));

         $staff_ids = $model->selectedstaff;


        //var_dump($staff_ids); die();

        if (is_array($staff_ids) && count($staff_ids)>0) {
            
            $success_count = 0;
            foreach ($staff_ids as $staff_id) {
                if ($this->db->where('id', $staff_id)->update('church_master', array('approved_by' => '1', 'approve_at' =>date('Y-m-d H:i:s')))) {
                    $success_count++;
                }
            }

            if (count($staff_ids)==$success_count) {
                $response['message']="Church Approve status has been updated successfully";
            } else {
                $response['status']="failure";
                $response['message']="Church Approve status has not been updated fully";
            }
        } else {
            $response['status']="failure";
            $response['message']="Choose Church and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    
    public function get_relieved_staff_list() {
        $this->output->set_content_type('application/json');
        global $api_path;

        $response=array('status'=>"success");

        $res=$this->db->select("staff_master.id, staff_cross_ref_number, staff_master.region_id, zone_id, staff_employee_id, staff_name, gems_region_master.region_name, zones_staff_master.staff_zone_name, place_present, staff_category_master.staff_category_name, DATE_FORMAT(staff_process_sadmin_date,'%d-%m-%Y')as process_date, DATE_FORMAT(staff_sdamin_approve_date,'%d-%m-%Y') as approve_date, DATE_FORMAT(relieved_date,'%d-%m-%Y') as relieved_date,relieved_reason")
            ->join('staff_category_master', 'staff_master.staff_category_id=staff_category_master.id', 'left')
            ->join('zones_staff_master', 'staff_master.zone_id=zones_staff_master.id', 'left')
            ->join('gems_region_master', 'staff_master.region_id=gems_region_master.id', 'left')
            ->order_by('staff_master.id', 'desc')
            
            //  ->join('gems_missionary_withdrawal','staff_master.id=gems_missionary_withdrawal.wm_missionary_id','left')    
            // ->where('staff_master.staff_delete_status','0')
            // ->where('staff_master.staff_process_sadmin','1')
            ->where('staff_master.staff_relief_status','SR') 
            //->where('gems_missionary_withdrawal.wm_sadmin_approve','1')
            ->get('staff_master');
        
        if($res->num_rows()>0) {
            
            $result=array();
            foreach($res->result_array() as $key=>$value) {

            	$html2='<input type="checkbox" name="chkSelect[]" class="chkSelect"  data-element-id="'.$value['staff_employee_id'].'"/>';

                $html='

<a title="Staff View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewstaff/'.$value['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>';

                $result[]=array('sel'=>$html2,'staff_cross_ref_number'=>$value['staff_cross_ref_number'],
                    'staff_employee_id'=>$value['staff_employee_id'],'staff_name'=>$value['staff_name'],
                    'staff_category_name'=>$value['staff_category_name'],'process_date'=>$value['process_date'],'relieved_date'=>$value['relieved_date'],
                    'relieved_reason'=>$value['relieved_reason'],'action'=>$html);
            
            }

            $response['result']=$result;
        } else {
            $response['status']="failure";
            $response['message']="No relieved staff list found!!..";
        }
        
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    public function gems_revoke_staffs() {
    	$this->output->set_content_type('application/json');
		$response=array('status'=>"success");
    	
    	$arr = $this->input->post('chkSelect');
    	$staff_ids = explode(",", $arr);

    	if (is_array($staff_ids) && count($staff_ids)>0) {
    		
    		$success_count = 0;
    		foreach ($staff_ids as $staff_id) {
    			if ($this->db->where('staff_employee_id', $staff_id)->update('staff_master', array('staff_relief_status' => 'NR', 'revoked_date' =>date('Y-m-d H:i:s')))) {
    				$success_count++;
    			}
    		}

    		if (count($staff_ids)==$success_count) {
    			$response['message']="Staff revoked successfully";
    		} else {
    			$response['status']="failure";
    			$response['message']="Staff revoke not updated";
    		}
    	} else {
    		$response['status']="failure";
    		$response['message']="Choose staff and continue!!..";
    	}

    	die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


	public function gems_fetch_master_data() {
		$this->output->set_content_type('application/json');
		$response=array('status'=>"success");

		if (($type=$this->input->post('type'))!=null && $type!="") {
			$temp_master = array();
			global $$type;
			
			foreach ($$type as $key => $value) {
				array_push($temp_master, array('id' => $key, 'name' => $value));
			}

			$response['message'] = "Master data retrieved successfully";
			$response['result'] = $temp_master;
		} else {
			$response['status']="failure";
			$response['message']="Invalid Attempt!!.. Access denied..";
		}

		die(json_encode($response, JSON_UNESCAPED_SLASHES));
	}

	public function gems_create_discipline_master() {
		$this->output->set_content_type('application/json');
		$response=array('status'=>"success");

		$corrective_action = $this->input->post('corrective_action');
        $comments = $this->input->post('comments');
        if ($comments == 'undefined' ) { $comments = null; } 


		if ($corrective_action!=null && $corrective_action!="") {
			
			$this->load->model('staff_disciplinary_action');
			$disciplinary_id=$this->staff_disciplinary_action->save(array(
				'fk_staff_id'=>$this->input->post('staff_id'),
				'corrective_action'=>$corrective_action,
				'description'=>$this->input->post('description'),
				'comments'=>$comments,
				'created_date'=>date('Y-m-d H:i:s'),
				'created_by'=>$this->input->post('created_by')
			));

			if ($disciplinary_id!=false) {
				$response['message']="Disciplinary action record has been inserted successfully";
			} else {
				$response['status']="failure";
				$response['message']="Something wrong in your input!!. Please try again.";
			}
		} else {
			$response['status']="failure";
			$response['message']="Invalid Attempt!!.. Access denied..";
		}

		die(json_encode($response, JSON_UNESCAPED_SLASHES));
	}

	public function gems_fetch_discipline_master($staff_id) {

        global $corrective_action;

		$this->output->set_content_type('application/json');
		$response=array('status'=>"success");

		$this->load->model('staff_disciplinary_action');
		$staff_disciplinary_list=$this->staff_disciplinary_action->get_staff_disciplinary_list($staff_id);
		
		if (count($staff_disciplinary_list)>0) {


            foreach ($staff_disciplinary_list as $key => $value) {

                //var_dump($value->id); die();
                
                $result[]=array('id'=>$value->id,'corrective_action'=>$corrective_action[$value->corrective_action],'description'=>$value->description,'comments'=>$value->comments,'created_date'=>$value->created_date,'staff_category_name'=>$value->staff_category_name,'staff_employee_id'=>$value->staff_employee_id,'staff_name'=>$value->staff_name,'std_created_date'=>$value->std_created_date);
            }

			$response['result']=$result;
			$response['message']="Staff disciplinary action list retrieved successfully!!..";
		} else {
			$response['status']="failure";
			$response['message']="Invalid Disciplinary Action Id!!..";
		}
		
		die(json_encode($response, JSON_UNESCAPED_SLASHES));
	}

	public function gems_discipline_master_list() {
		$this->output->set_content_type('application/json');
		$response=array('status'=>"success");

		$this->load->model('staff_disciplinary_action');
		$disciplinary_list=$this->staff_disciplinary_action->get_disciplinary_list();
		
		if (count($disciplinary_list)>0) {
			$response['result']=$disciplinary_list;
			$response['message']="Disciplinary action list retrieved successfully!!..";
		}else{
			$response['status']="failure";
			$response['message']="No disciplinary action list found!!..";
		}
		
		die(json_encode($response, JSON_UNESCAPED_SLASHES));
	}

	public function gems_create_training_master() {
		$this->output->set_content_type('application/json');
		$response=array('status'=>"success");

		$training_name = $this->input->post('training_name');
		if ($training_name!=null && $training_name!="") {
			
			$this->load->model('staff_training_master');
			$training_id=$this->staff_training_master->save(array(
				'fk_staff_id'=>$this->input->post('staff_id'),
				'training_name'=>$training_name,
				'training_date'=>date('Y-m-d H:i:s', strtotime($this->input->post('training_date'))),
				'training_description'=>$this->input->post('training_description'),
				'training_duration'=>$this->input->post('training_duration'),
				'created_date'=>date('Y-m-d H:i:s'),
				'created_by'=>$this->input->post('created_by')
			));

			if ($training_id!=false) {
				$response['message']="Staff training record has been inserted successfully";
			} else {
				$response['status']="failure";
				$response['message']="Something wrong in your input!!. Please try again.";
			}
		} else {
			$response['status']="failure";
			$response['message']="Invalid Attempt!!.. Access denied..";
		}

		die(json_encode($response, JSON_UNESCAPED_SLASHES));
	}

	public function gems_fetch_training_master($staff_id) {
		$this->output->set_content_type('application/json');
		$response=array('status'=>"success");

		$this->load->model('staff_training_master');
		$staff_training_list=$this->staff_training_master->get_staff_training_list($staff_id);

		if (count($staff_training_list)>0) {
			$response['result']=$staff_training_list;
			$response['message']="Staff training list retrieved successfully!!..";
		} else {
			$response['status']="failure";
			$response['message']="Invalid Staff Training Id!!..";
		}
		
		die(json_encode($response, JSON_UNESCAPED_SLASHES));
	}

	public function gems_training_master_list() {
		$this->output->set_content_type('application/json');
		$response=array('status'=>"success");

		$this->load->model('staff_training_master');
		$training_list=$this->staff_training_master->get_training_list();
		
		if (count($training_list)>0) {
			$response['result']=$training_list;
			$response['message']="Training list retrieved successfully!!..";
		}else{
			$response['status']="failure";
			$response['message']="No staff training list found!!..";
		}
		
		die(json_encode($response, JSON_UNESCAPED_SLASHES));
	}

	public function gems_create_transfer_master() {
		$this->output->set_content_type('application/json');
		$response=array('status'=>"success");

		$fk_staff_id = $this->input->post('fk_staff_id');
		if ($fk_staff_id!=null && $fk_staff_id!="") {
			
			$this->load->model('staff_transfer_history');
			$history_id=$this->staff_transfer_history->save(array(
				'fk_staff_id'=>$fk_staff_id,
				'staff_employee_id'=>$this->input->post('staff_employee_id'),
				'zone_id'=>$this->input->post('zone_id'),
				'department_id'=>$this->input->post('department_id'),
                'place_of_present'=>$this->input->post('place_of_present'),
				'created_date'=>date('Y-m-d H:i:s')
			));

			if ($history_id!=false) {
				$response['message']="Staff transfer record has been inserted successfully.";
			} else {
				$response['status']="failure";
				$response['message']="Something wrong in your input!!. Please try again.";
			}
		} else {
			$response['status']="failure";
			$response['message']="Invalid Attempt!!.. Access denied..";
		}

		die(json_encode($response, JSON_UNESCAPED_SLASHES));
	}


    public function gems_approve_staff_transfer_vs_experience() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = $this->input->post('model');

        $model= json_decode($model);

        $transfer_zone_id = $model->transfer_zone_id;
        $staff_department_id = $model->staff_department_id;
        $dep_field_serve_name = $model->dep_field_serve_name;
        $date_of_transfer = $model->date_of_transfer;
        $fk_staff_id = $model->staff_id;

        //var_dump($model); die();

        $this->load->model(array('staff_vs_experience'));
        

        $experience_info=$this->staff_vs_experience->get_record_list(array(
            'select'=>'id, fk_staff_id, department_id, exp_from_date, exp_to_date',
            'conditions'=>array('fk_staff_id'=>$fk_staff_id),
            'order'=>'id desc',
            'limit'=>1
        ));
            
        //var_dump($experience_info); die();



        if ($experience_info!=null) {
            // insert experience for staff_vs_experience

            if($experience_info[0]->exp_to_date==null)
            {
                $this->staff_vs_experience->update(
                array('id'=>$experience_info[0]->id),
                array(
                    'exp_to_date'=>$date_of_transfer
                ));


                $updated2=$this->staff_vs_experience->save(
                array(
                    'exp_from_date'=>$date_of_transfer,
                    'exp_to_date'=>NULL,
                    'fk_staff_id'=>$fk_staff_id,
                    'dep_field_serve_name'=>$dep_field_serve_name,
                    'department_id'=>$staff_department_id,
                    'created_date'=>date('Y-m-d H:i:s')
                ));
            }
            else
            {
                $updated2=$this->staff_vs_experience->save(
                array(
                    'exp_from_date'=>$date_of_transfer,
                    'exp_to_date'=>NULL,
                    'fk_staff_id'=>$fk_staff_id,
                    'dep_field_serve_name'=>$dep_field_serve_name,
                    'department_id'=>$staff_department_id,
                    'created_date'=>date('Y-m-d H:i:s')
                ));
            }

            

            
            if ($updated2==true) {
                $response['message']="Staff transfer record has been updated successfully";
            } else {
                $response['status']="failure";
                $response['message']="Something wrong in your input!!. Please try again.";
            }
        } else {



            $updated2=$this->staff_vs_experience->save(
                array(
                    'exp_from_date'=>$date_of_transfer,
                    'exp_to_date'=>NULL,
                    'fk_staff_id'=>$fk_staff_id,
                    'dep_field_serve_name'=>$dep_field_serve_name,
                    'department_id'=>$staff_department_id,
                    'created_date'=>date('Y-m-d H:i:s')
                ));
            if ($updated2==true) {
                $response['message']="Staff transfer record has been updated successfully";
            } else {
                $response['status']="failure";
                $response['message']="Something wrong in your input!!. Please try again.";
            }
        }
        
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }



	public function gems_fetch_staff_transfer_master($staff_id){
		$this->output->set_content_type('application/json');
		$response=array('status'=>"success");

		$this->load->model('staff_transfer_history');
		$current_transfer=$this->staff_transfer_history->get_staff_last_transfer($staff_id);
        //var_dump($current_transfer); die();
		if($current_transfer!=null){
			$response['result']=$current_transfer;
		}else{
			$response['status']="failure";
			$response['message']="Invalid Staff Id!!..";
		}
		
		die(json_encode($response, JSON_UNESCAPED_SLASHES));
	}

	public function gems_staff_transfer_history($staff_id){
		$this->output->set_content_type('application/json');
		$response=array('status'=>"success");

		$this->load->model('staff_transfer_history');
		$transfer_history=$this->staff_transfer_history->get_staff_transfer_history($staff_id);

		if (count($transfer_history)>0){
			$response['result']=$transfer_history;
		} else {
			$response['status']="failure";
			$response['message']="Invalid Staff Id!!..";
		}
		
		die(json_encode($response, JSON_UNESCAPED_SLASHES));
	}

	public function gems_approve_staff_transfer($transfer_id) {
		$this->output->set_content_type('application/json');
		$response=array('status'=>"success");
        
		$this->load->model(array('staff_transfer_history', 'staff_vs_experience', 'staff_master'));
		
        $transfer_info=$this->staff_transfer_history->get_record(array(
			'select'=>'id, fk_staff_id, zone_id, region_id, department_id,place_of_present, DATE_FORMAT(created_date,"%d/%m/%Y")as created_date,',
			'conditions'=>array('id'=>$transfer_id),
            'order'=>'id desc'
		));

		//var_dump($transfer_info); die();
        if ($transfer_info!=null) {
			$updated=$this->staff_transfer_history->update(
				array('id'=>$transfer_info->id),
				array(
					'approved_date'=>date('Y-m-d H:i:s'),
					'status'=>'1'
				));

			// Change staff zone, region and department information
			$updated1=$this->staff_master->update(
				array('id'=>$transfer_info->fk_staff_id),
				array(
					'zone_id'=>$transfer_info->zone_id,
                    'place_present'=>$transfer_info->place_of_present,
					'region_id'=>$transfer_info->region_id,
                    'staff_sdamin_approve_date'=>date('Y-m-d H:i:s'),
					'staff_department_id'=>$transfer_info->department_id
				));
   //      	$updated=true;
			// $updated1=true;
			
			if ($updated==true && $updated1==true) {

				$to_list = array('welfare@gemsbihar.org', 'srd@gemsbihar.org', 'finance@gemsbihar.org');

				//$to_list = array('mohanraj.r@aesasp.com');


					$zone_det_get=$this->db->select("staff_zone_name, email_id")
			            ->where('zones_staff_master.id', $transfer_info->zone_id)
			            ->get('zones_staff_master');  

			        $zone_det= $zone_det_get->result_array();




			        $region_det_get=$this->db->select("region_name, email_id")
			            ->where('region_master.id', $transfer_info->region_id)
			            ->get('region_master');  

			        $region_det= $region_det_get->result_array();


			        $staff_det_get=$this->db->select("staff_name, present_email")
			            ->where('staff_master.id', $transfer_info->fk_staff_id)
			            ->get('staff_master');  

			        $staff_det= $staff_det_get->result_array();


			        $department_det_get=$this->db->select("department_name")
			            ->where('staff_department_master.id', $transfer_info->department_id)
			            ->get('staff_department_master');  

			        $department_det= $department_det_get->result_array();

			       // var_dump($department_det); die();

			        if($zone_det_get->num_rows()>0 && $region_det_get->num_rows()>0 && $staff_det_get->num_rows()>0 && $department_det_get->num_rows()>0)
					{
						if($zone_det[0]['email_id'] && $region_det[0]['email_id'])
				        {
				        	//var_dump($zone_det[0]['email_id']); die();

				        	array_push($to_list, $zone_det[0]['email_id']);
				        	array_push($to_list, $region_det[0]['email_id']);
				        }

				        

				        if($staff_det[0]['staff_name'] && $department_det[0]['department_name'])
				        {
				        	$message_info="Dear All,<br>
									Greetings in the name of our Lord Jesus Christ.
									<br>
									<br>
									This is to inform all concerned that Bro./Sis. <b>" .$staff_det[0]['staff_name']. " </b>from  <b>".$zone_det[0]['staff_zone_name']."</b> zone has been transferred to the new field <b>" .$transfer_info->place_of_present. " </b>to work under <b>" .$department_det[0]['department_name']. "</b> Department in <b>".$zone_det[0]['staff_zone_name']."</b> Zone.
									<br>
									<br>
									The transfer is effective as of " .$transfer_info->created_date. ".
									<br>
									<br>
									In His Service,<br>
									Human Resources Dept.<br>
									GEMS, Bihar";
				        }
				        
				       // var_dump($message_info); die();

						$this->load->library('email');
						//$this->email->from('sridhar.muthusamy@aesasp.com');
                        $this->email->from('hr@gemsbihar.org');
						$this->email->to($to_list);
						$this->email->subject('Staff Transfer Information');
						$this->email->message($message_info);
						try{
						$this->email->send();

						//var_dump($this->email->send()); die();
						//echo 'Message has been sent.';

						$response['message']="Staff transfer record has been updated successfully";


						}catch(Exception $e){
						//echo $e->getMessage();
						}
					}
					else
					{
						$response['status']="failure";
					}


					
			        


				$response['message']="Staff transfer record has been updated successfully";
			} else {
				$response['status']="failure";
				$response['message']="Something wrong in your input!!. Please try again.";
			}
		} else {
			$response['status']="failure";
			$response['message']="Invalid Attempt!!.. Access denied..";
		}
		
		die(json_encode($response, JSON_UNESCAPED_SLASHES));
	}

	public function get_sponsor_master_list(){
		$this->output->set_content_type('application/json');
		$response=array('status'=>"success");
		$result=array();
		$html="";
           global $api_path;
		
		$res=$this->db->select("sponsor_master.id, sponser_name, promotional_office_master.promo_office_name, country.country_name, sponser_phone, sponsor_district, state_zone_master.state_zone_name, sponser_city_town_place, sponser_pin, DATE_FORMAT(sponser_sadmin_approve_date,'%d/%m/%Y')as sponser_sadmin_approve_date, sponsor_allot_mission_status,DATE_FORMAT(created_at,'%d/%m/%Y') as sponser_sadmin_created_date")
            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left')
            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
			->order_by('sponsor_master.id', 'desc')
			->where('is_deleted', '0')
			->get('sponsor_master');

		
		if($res->num_rows()>0){

			global $missionaryallotstatus;

			foreach($res->result_array() as $key=>$value){

                $html='

				<a title="Sponsor View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewsponsor/'.$value['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>

				<a title="Sponsor Enable" style=" margin-top: 10px;" href="'.$api_path.'/#/enablesponsor/'.$value['id'].'"><i class="fa fa-check" aria-hidden="true"></i></a>

                <a title="Sponsor Edit" style=" margin-top: 10px;" href="'.$api_path.'/#/editsponsor/'.$value['id'].'"><i class="fa fa-pencil" aria-hidden="true"></i></a>


                <button style=" margin-top: 10px;" type="button" class="btn btn-danger button_delete_sponsor" data-element-id="'.$value['id'].'"><i class="glyphicon glyphicon-trash" data-element-id="'.$value['id'].'"></i></button>';

				$result[]=array('id'=>$value['id'],'sponser_name'=>$value['sponser_name'],'sponser_promo_office'=>$value['promo_office_name'],'sponser_country_id'=>$value['country_name'],'sponser_phone'=>$value['sponser_phone'],'sponsor_district'=>$value['sponsor_district'],'sponser_state'=>$value['state_zone_name'],'sponser_city_town_place'=>$value['sponser_city_town_place'],'sponser_pin'=>$value['sponser_pin'],'sponser_sadmin_approve_date'=>$value['sponser_sadmin_approve_date'],'sponsor_allot_mission_status'=>$missionaryallotstatus[$value['sponsor_allot_mission_status']],'sponser_sadmin_created_date'=>$value['sponser_sadmin_created_date'],
                    'itemName'=>$value['sponser_name'],'action'=>$html);
			
			}
		}else{
			$response['status']="failure";
			$response['message']="No staff list found!!..";
		}
		
		$response['result']=$result;
		die(json_encode($response, JSON_UNESCAPED_SLASHES));
	}


    public function get_mkd_sponsor_master_list(){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $result=array();
        $html="";
           global $api_path;
        
        $res=$this->db->select("sponsor_master.id, sponser_name, promotional_office_master.promo_office_name, country.country_name, sponser_phone, sponsor_district, state_zone_master.state_zone_name, sponser_city_town_place, sponser_pin, DATE_FORMAT(sponser_sadmin_approve_date,'%d/%m/%Y')as sponser_sadmin_approve_date, sponsor_allot_mission_status")
            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left')
            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
            ->order_by('sponsor_master.id', 'desc')
            ->where('is_deleted', '0')
            ->get('sponsor_master');

        
        if($res->num_rows()>0){

            global $missionaryallotstatus;

            foreach($res->result_array() as $key=>$value){

                $html='

                <a title="Sponsor View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewsponsor/'.$value['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>

                <a title="Sponsor Enable" style=" margin-top: 10px;" href="'.$api_path.'/#/enablesponsor/'.$value['id'].'"><i class="fa fa-check" aria-hidden="true"></i></a>

                <a title="Sponsor Edit" style=" margin-top: 10px;" href="'.$api_path.'/#/editsponsor/'.$value['id'].'"><i class="fa fa-pencil" aria-hidden="true"></i></a>


                <button style=" margin-top: 10px;" type="button" class="btn btn-danger button_delete_sponsor" data-element-id="'.$value['id'].'"><i class="glyphicon glyphicon-trash" data-element-id="'.$value['id'].'"></i></button>';

                $result[]=array('id'=>$value['id'],'sponser_name'=>$value['sponser_name'],'sponser_promo_office'=>$value['promo_office_name'],'sponser_country_id'=>$value['country_name'],'sponser_phone'=>$value['sponser_phone'],'sponsor_district'=>$value['sponsor_district'],'sponser_state'=>$value['state_zone_name'],'sponser_city_town_place'=>$value['sponser_city_town_place'],'sponser_pin'=>$value['sponser_pin'],'sponser_sadmin_approve_date'=>$value['sponser_sadmin_approve_date'],'sponsor_allot_mission_status'=>$missionaryallotstatus[$value['sponsor_allot_mission_status']],'action'=>$html);
            
            }
        }else{
            $response['status']="failure";
            $response['message']="No staff list found!!..";
        }
        
        $response['result']=$result;
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

	public function gems_create_sponsor_master(){
        
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";

        

        $model = json_decode($this->input->post('model',FALSE));
       // var_dump($model->sponser_name); die();
        if($model!=''){
            
            
            $res_chk=$this->db->query("select id from ".$this->db->dbprefix('sponsor_master')." where sponser_email='".$model->sponser_email."' AND sponser_phone='".$model->sponser_phone."' ");
            if($res_chk->num_rows()>0){
                    $response['status']="failure";            
                    $response['message']="Sorry!!, Sponsor already exists.";
                
            }else{
                $this->db->query("insert into ".$this->db->dbprefix('sponsor_master')." (
	                	sponser_name,
	                	sponser_address,
	                	sponser_city_town_place,
	                	sponsor_district,
	                	sponser_pin,
	                	sponser_country_id,
	                	sponser_state,
	                	sponser_email,
	                	sponser_phone,
                        sponsor_allot_mission_status,
	                	sponser_promo_office,
	                	sponsor_username,
	                	sponsor_password,
	                	created_at,
	                	created_by
		                	) values (
			                	'".$model->sponser_name."',
								'".$model->sponser_address."',
								'".$model->sponser_city_town_place."',
								'".$model->sponsor_district."',
								'".$model->sponser_pin."',
								'".$model->sponser_country_id."',
								'".$model->sponser_state."',
								'".$model->sponser_email."',
								'".$model->sponser_phone."',
                                '".$model->sponsor_allot_mission_status."',
								'".$model->sponser_promo_office."',
								'".$model->sponsor_username."',
								'".$model->sponsor_password."',
								NOW(),
								'".$model->created_by."'
			                	)");
                if($this->db->insert_id()){
                    $response['result']=array('id'=>$this->db->insert_id());

                    $this->db->query("insert into ".$this->db->dbprefix('admin_master')." (
                    admin_username,
                    admin_password,
                    firstname,
                    mobile_number,
                    email_address,
                    role_type_id,
                    created_date,
                    created_by,
                    address,
                    is_deleted
                      ) values (
                        '".$model->sponsor_username."',
                        '".md5($model->sponsor_password)."',
                        '".$model->sponser_name."',
                        '".$model->sponser_phone."',
                        '".$model->sponser_email."',
                        '8',
                        NOW(),
                        '".$model->created_by."',
                        '".$model->sponser_address."',
                        '0'
                        )");


                    $response['message']="Sponsor record stored successfully";
                }else{
                    $response['status']="failure";            
                    $response['message']="Sorry!!, Unable to insert the Sponsor data";
                }
            }
            
        }else{
                $response['status']="failure";            
                $response['message']="Sorry!!, Invalid Attempt!!.. Permission denied.";
        }
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }

    public function gems_fetch_sponsor_master($id)
    {
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        // $res=$this->db->query("select * from ".$this->db->dbprefix('sponsor_master')." where id ='".$id."'")
        //     ->join("select * from ".$this->db->dbprefix('sponsorship_master')." where sponsor_group_id ='".$id."'");

             // $res=$this->db->select()
             //    ->join('sponsor_master', 'sponsorship_master.sponsor_group_id=sponsor_master.id', 'left')
             //    ->where('sponsorship_master.id', $id)
             //    ->get('sponsorship_master');

                $res=$this->db->query("select * from ".$this->db->dbprefix('sponsor_master')." where id='".$id."'");



        if($res->num_rows()>0){
            $in_array=$res->result_array();
            $result=$in_array[0];
        }else{
            $response['status']="failure";
            $response['message']=" No Sponsor record found!!";
        }
        $response['result']=$result;
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }


    
    public function gems_edit_sponsor_master(){
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";

        $resultdata = json_decode($this->input->post('resultdata',FALSE));
        
        if($resultdata->id!="" && $resultdata->sponser_name!=""){
            $sponser_name=$resultdata->sponser_name;
            $res_chk=$this->db->query("select id from ".$this->db->dbprefix('sponsor_master')." where sponser_email='".$resultdata->sponser_email."' AND sponser_phone='".$resultdata->sponser_phone."' AND id!='".$resultdata->id."'");

           // var_dump($res_chk->result_array()); die();
            if($res_chk->num_rows()>0){
               $response['status']="failure";            
               $response['message']="Invalid Attempt!!.. Access denied..";

                
            }
            else
            {
              $data=array('sponser_name'=>$resultdata->sponser_name,
                              'sponser_address'=>$resultdata->sponser_address,
                              'sponser_city_town_place'=>$resultdata->sponser_city_town_place,
                              'sponsor_district'=>$resultdata->sponsor_district,
                              'sponser_pin'=>$resultdata->sponser_pin,
                              'sponser_country_id'=>$resultdata->sponser_country_id,
                              'sponser_state'=>$resultdata->sponser_state,
                              'sponser_email'=>$resultdata->sponser_email,
                              'sponser_phone'=>$resultdata->sponser_phone,
                              'sponser_promo_office'=>$resultdata->sponser_promo_office,
                              'sponsor_username'=>$resultdata->sponsor_username,
                              'sponsor_password'=>$resultdata->sponsor_password
                          );

                  $this->db->set('is_deleted','0');
                  $this->db->where('id',$resultdata->id);
                  $this->db->update($this->db->dbprefix('sponsor_master'),$data);

                  /***Update Admin Master*****/
                      $res_chk=$this->db->query("SELECT id FROM ".$this->db->dbprefix('admin_master')." WHERE firstname LIKE '%".$resultdata->sponser_name."%' AND role_type_id LIKE '%8'");

                      $admin_det_val=$res_chk->result_array(); 
                      if(count($admin_det_val)>0)
                      {
                          $data_admin=array('admin_username'=>$resultdata->sponsor_username,
                         'admin_password'=>md5($resultdata->sponsor_password),
                         'firstname'=>$resultdata->sponser_name,
                         'mobile_number'=>$resultdata->sponser_phone,
                         'email_address'=>$resultdata->sponser_email
                          );
                          $this->db->set('is_deleted','0');
                          $this->db->where('id',$admin_det_val[0]['id']);
                          $this->db->update($this->db->dbprefix('admin_master'),$data_admin); 
                      }
                  /************/    
                  $response['message']="Sponsor record has been updated successfully";
            } 
       }

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }

    public function gems_delete_sponsor_master($id)
    {
    
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        
        if($id){

        	$res_chk=$this->db->query("select id from ".$this->db->dbprefix('sponsor_master')." where id='".$id."'");

        	
            if($res_chk->num_rows()==0){
                    $response['status']="failure";            
                    $response['message']="Sorry!!, No sponser valid";
            }else{

            	$this->db->set('is_deleted','1');
                $this->db->where('id',$id);
                $this->db->update($this->db->dbprefix('sponsor_master'));
                $response['message']="Sponsor record has been Deleted successfully";
            }	
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";    
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    } 

    public function gems_create_sponsorship_master() {

       $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";

        $model = json_decode($this->input->post('model',FALSE));

        //var_dump($model->sponsor_missionary_remarks); die();


        if($model!=''){
            
                $this->db->query("insert into ".$this->db->dbprefix('sponsorship_master')." (
                        sponsor_group_id,
                        category_sponsorship,
                        sponser_amount,
                        sponser_payment_details,
                        sponsor_number_of_installment,
                        sponsor_from_date,
                        sponsor_to_date,
                        sponser_missionary_preference,
                        sponsor_allot_mission_status,
                        sponser_form_filling_person_name,
                        sponser_acc_person_name,
                        sponser_acc_age_accompanying,
                        sponser_acc_gender_accompanying,
                        sponser_near_board_station,
                        sponsor_full_to_family,
                        sponser_preference_gender,
                        sponser_preference_state,
                        sponser_dedication_place,
                        sponser_dedication_needed,
                        sponser_preference_language,
                        sponsor_arrived_datetime,
                        sponsor_depart_datetime,
                        sponsor_missionary_arrived_datetime,
                        sponsor_missionary_depart_datetime,
                        sponsor_missionary_remarks,
                        sadmin_approve_by,
                        created_at,
                        created_by,
                        is_deleted
                            ) values (
                                '".$model->sponsor_group_id."',
                                '".$model->category_sponsorship."',
                                '".$model->sponser_amount."',
                                '".$model->sponser_payment_details."',
                                '".$model->sponsor_number_of_installment."',
                                '".date("Y-m-d", strtotime($model->sponsor_from_date))."',
                                '".date("Y-m-d", strtotime($model->sponsor_to_date))."',
                                '".$model->sponser_missionary_preference."',
                                '".$model->sponsor_allot_mission_status."',
                                '".$model->sponser_form_filling_person_name."',
                                '".$model->sponser_acc_person_name."',
                                '".$model->sponser_acc_age_accompanying."',
                                 '".$model->sponser_acc_gender_accompanying."',
                                '".$model->sponser_near_board_station."',
                                '".$model->sponsor_full_to_family."',
                                '".$model->sponser_preference_gender."',
                                '".$model->sponser_preference_state."',
                                '".$model->sponser_dedication_place."',
                                '".$model->sponser_dedication_needed."',
                                '".$model->sponser_preference_language."',
                                '".date("Y-m-d H:i", strtotime($model->sponsor_arrived_datetime))."',
                                '".date("Y-m-d H:i", strtotime($model->sponsor_depart_datetime))."',
                                '".date("Y-m-d H:i", strtotime($model->sponsor_missionary_arrived_datetime))."',
                                '".date("Y-m-d H:i", strtotime($model->sponsor_missionary_depart_datetime))."',
                                '".$model->sponsor_missionary_remarks."',
                                '0',
                                NOW(),
                                '".$model->created_by."',
                                '0'
                                )");

                if($this->db->insert_id()){
                    $response['result']=array('id'=>$this->db->insert_id());
                    $response['message']="Sponsorship record stored successfully";
                }else{
                    $response['status']="failure";            
                    $response['message']="Sorry!!, Unable to insert the Sponsor data";
                }
           
            }else{
                    $response['status']="failure";            
                    $response['message']="Sorry!!, Invalid Attempt!!.. Permission denied.";
            }
            echo json_encode($response,JSON_UNESCAPED_SLASHES);
            die();
    }

    public function gems_create_mkd_sponsorship_master() {

       $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";

        $model = json_decode($this->input->post('model',FALSE));

        //var_dump($model->sponsor_missionary_remarks); die();


        if($model!=''){
            
                $this->db->query("insert into ".$this->db->dbprefix('sponsorship_master')." (
                        sponsor_group_id,
                        category_sponsorship,
                        sponser_amount,
                        sponser_payment_details,
                        sponsor_number_of_installment,
                        sponsor_from_date,
                        sponsor_to_date,
                        sponsor_allot_mission_status,
                        sponser_form_filling_person_name,
                        sponsor_missionary_remarks,
                        created_at,
                        created_by,
                        is_deleted
                            ) values (
                                '".$model->sponsor_group_id."',
                                '".$model->category_sponsorship."',
                                '".$model->sponser_amount."',
                                '".$model->sponser_payment_details."',
                                '".$model->sponsor_number_of_installment."',
                                '".date("Y-m-d", strtotime($model->sponsor_from_date))."',
                                '".date("Y-m-d", strtotime($model->sponsor_to_date))."',
                                '".$model->sponsor_allot_mission_status."',
                                '".$model->sponser_form_filling_person_name."',
                                '".$model->sponsor_missionary_remarks."',
                                NOW(),
                                '".$model->created_by."',
                                '0'
                                )");

                if($this->db->insert_id()){
                    $response['result']=array('id'=>$this->db->insert_id());
                    $response['message']="Sponsorship record stored successfully";
                }else{
                    $response['status']="failure";            
                    $response['message']="Sorry!!, Unable to insert the Sponsor data";
                }
           
            }else{
                    $response['status']="failure";            
                    $response['message']="Sorry!!, Invalid Attempt!!.. Permission denied.";
            }
            echo json_encode($response,JSON_UNESCAPED_SLASHES);
            die();
    }

    public function gems_edit_sponsorship_master(){
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";

        $resultdata = json_decode($this->input->post('resultdata',FALSE));
        //var_dump($resultdata); die();
        if($resultdata->id!="" && $resultdata->sponsor_group_id!=""){
            
                
                // $data=array('staff_zone_name'=>$this->input->post('zone_name',FALSE),
                //             'region_id'=>$this->input->post('region_id',FALSE),
                //             'modified_by'=>$this->input->post('modified_by',FALSE));

                $data=array('sponsor_group_id'=>$resultdata->sponsor_group_id,
                            'category_sponsorship'=>$resultdata->category_sponsorship,
                            'sponser_amount'=>$resultdata->sponser_amount,
                            'sponser_payment_details'=>$resultdata->sponser_payment_details,
                            'sponsor_number_of_installment'=>$resultdata->sponsor_number_of_installment,
                            'sponsor_from_date'=>date("Y-m-d", strtotime($resultdata->sponsor_from_date)),
                            'sponsor_to_date'=>date("Y-m-d", strtotime($resultdata->sponsor_to_date)),
                            'sponser_missionary_preference'=>$resultdata->sponser_missionary_preference,
                            'sponser_form_filling_person_name'=>$resultdata->sponser_form_filling_person_name,
                            'sponser_acc_person_name'=>$resultdata->sponser_acc_person_name,
                            'sponser_near_board_station'=>$resultdata->sponser_near_board_station,
                            'sponsor_full_to_family'=>$resultdata->sponsor_full_to_family,
                            'sponser_preference_gender'=>$resultdata->sponser_preference_gender,
                            'sponser_preference_state'=>$resultdata->sponser_preference_state,
                            'sponser_dedication_place'=>$resultdata->sponser_dedication_place,
                            'sponser_dedication_needed'=>$resultdata->sponser_dedication_needed,
                            'sponser_preference_language'=>$resultdata->sponser_preference_language,
                            'sponsor_arrived_datetime'=>date("Y-m-d H:i", strtotime($resultdata->sponsor_arrived_datetime)),
                            'sponsor_depart_datetime'=>date("Y-m-d H:i", strtotime($resultdata->sponsor_depart_datetime)),
                            'sponsor_missionary_arrived_datetime'=>date("Y-m-d H:i", strtotime($resultdata->sponsor_missionary_arrived_datetime)),
                            'sponsor_missionary_depart_datetime'=>date("Y-m-d H:i", strtotime($resultdata->sponsor_missionary_depart_datetime)),
                            'sponsor_missionary_remarks'=>$resultdata->sponsor_missionary_remarks
                        );
                $this->db->set('is_deleted','0');
                $this->db->where('id',$resultdata->id);
                $this->db->update($this->db->dbprefix('sponsorship_master'),$data);
                $response['message']="Sponsorship record has been updated successfully";
            
       }else{
            $response['status']="failure";            
            $response['message']="Invalid Attempt!!.. Access denied..";
       }    
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }


     public function gems_edit_mkd_sponsorship_master(){
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";

        $resultdata = json_decode($this->input->post('resultdata',FALSE));
        //var_dump($resultdata); die();
        if($resultdata->id!="" && $resultdata->sponsor_group_id!=""){
            
                
                // $data=array('staff_zone_name'=>$this->input->post('zone_name',FALSE),
                //             'region_id'=>$this->input->post('region_id',FALSE),
                //             'modified_by'=>$this->input->post('modified_by',FALSE));

                $data=array('sponsor_group_id'=>$resultdata->sponsor_group_id,
                            'category_sponsorship'=>$resultdata->category_sponsorship,
                            'sponser_amount'=>$resultdata->sponser_amount,
                            'sponser_payment_details'=>$resultdata->sponser_payment_details,
                            'sponsor_number_of_installment'=>$resultdata->sponsor_number_of_installment,
                            'sponsor_from_date'=>date("Y-m-d", strtotime($resultdata->sponsor_from_date)),
                            'sponsor_to_date'=>date("Y-m-d", strtotime($resultdata->sponsor_to_date)),
                            'sponser_form_filling_person_name'=>$resultdata->sponser_form_filling_person_name,
                            'sponsor_missionary_remarks'=>$resultdata->sponsor_missionary_remarks
                        );
                $this->db->set('is_deleted','0');
                $this->db->where('id',$resultdata->id);
                $this->db->update($this->db->dbprefix('sponsorship_master'),$data);
                $response['message']="Sponsorship record has been updated successfully";
            
       }else{
            $response['status']="failure";            
            $response['message']="Invalid Attempt!!.. Access denied..";
       }    
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }

    public function get_sponsorship_master_list(){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $result=array();
        $html="";
           global $api_path;
        
        $res=$this->db->select("sponsorship_master.id, sponsor_group_id, sponser_amount,sponser_payment_details,  category_sponsorship, DATE_FORMAT(created_at,'%d/%m/%Y')as created_at, sponser_missionary_preference, state_zone_master.state_zone_name, sponsor_number_of_installment, DATE_FORMAT(sadmin_approve_date,'%d/%m/%Y')as sadmin_approve_date, sponsor_allot_mission_status")
            ->join('state_zone_master', 'sponsorship_master.sponser_preference_state=state_zone_master.id', 'left')
            ->order_by('sponsorship_master.id', 'desc')
            ->where('is_deleted', '0')
            ->where('category_sponsorship', '1')
            ->get('sponsorship_master');

        // var_dump($res->result_array()); die();
        
        if($res->num_rows()>0){

            global $missionaryallotstatus;

            foreach($res->result_array() as $key=>$value1){


               // $res_chk=$this->db->query("select * from ".$this->db->dbprefix('sponsor_master')." where id='".$value1['sponsor_group_id']."'");
                $res_chk=$this->db->select("sponsor_master.id, sponser_name, promotional_office_master.promo_office_name, country.country_name, sponser_phone, sponsor_district, state_zone_master.state_zone_name, sponser_city_town_place, sponser_pin, DATE_FORMAT(sponser_sadmin_approve_date,'%d/%m/%Y')as sponser_sadmin_approve_date, sponser_missionary_preference, sponsor_allot_mission_status,DATE_FORMAT(created_at,'%d/%m/%Y')as sponser_sadmin_created_date,")
                            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left')
                            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
                            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
                            ->order_by('sponsor_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsor_master.id', $value1['sponsor_group_id'])
                            ->get('sponsor_master');
                
                   // var_dump($res_chk); die();
                if($res_chk->num_rows()>0){

                    foreach($res_chk->result_array() as $key=>$value){


                         //var_dump($value); die();
                        // $html='

                        //         <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewsponsorship/'.$value1['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>


                        //         <a title="Sponsorship Edit" style=" margin-top: 10px;" href="'.$api_path.'/#/editsponsorship/'.$value1['id'].'"><i class="fa fa-pencil" aria-hidden="true"></i></a>


                        //         <button style=" margin-top: 10px;" type="button" class="btn btn-danger button_delete_sponsorship" data-element-id="'.$value1['id'].'"><i class="glyphicon glyphicon-trash" data-element-id="'.$value1['id'].'"></i></button>';


                        $html='<a title="Staff View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewsponsorship/'.$value1['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>';

                                $result[]=array('id'=>$value1['id'],'sponser_name'=>$value['sponser_name'],'sponser_amount'=>$value1['sponser_amount'],'sponser_payment_details'=>$value1['sponser_payment_details'],'sponsor_number_of_installment'=>$value1['sponsor_number_of_installment'],'sponser_promo_office'=>$value['promo_office_name'],'sponser_country_id'=>$value['country_name'],'sponser_phone'=>$value['sponser_phone'],'sponsor_district'=>$value['sponsor_district'],'sponser_state'=>$value1['state_zone_name'],'sponser_city_town_place'=>$value['sponser_city_town_place'],'sponser_pin'=>$value['sponser_pin'],'sponser_sadmin_approve_date'=>$value1['sadmin_approve_date'],'sponsor_allot_mission_status'=>$missionaryallotstatus[$value1['sponsor_allot_mission_status']],'sponser_sadmin_created_date'=>$value1['created_at'],'action'=>$html);

                     }   


                 }   

                
            
            }
        }else{
            $response['status']="failure";
            $response['message']="No staff list found!!..";
        }
        
        $response['result']=$result;
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    public function get_mkd_sponsorship_master_list(){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $result=array();
        $html="";
           global $api_path;
        
        $res=$this->db->select("sponsorship_master.id, sponsor_allot_mission_status, sponsor_group_id, category_sponsorship, DATE_FORMAT(created_at,'%d/%m/%Y')as created_at, sponser_missionary_preference, sponser_amount, sponser_payment_details, sponsor_number_of_installment, DATE_FORMAT(sadmin_approve_date,'%d/%m/%Y')as sadmin_approve_date")
            ->order_by('sponsorship_master.id', 'desc')
            ->where('is_deleted', '0')
            ->where('category_sponsorship', '2')
            ->get('sponsorship_master');

         
        
        if($res->num_rows()>0){

            global $missionaryallotstatus;

            foreach($res->result_array() as $key=>$value1){


               // $res_chk=$this->db->query("select * from ".$this->db->dbprefix('sponsor_master')." where id='".$value1['sponsor_group_id']."'");
                $res_chk=$this->db->select("sponsor_master.id, sponser_name, promotional_office_master.promo_office_name, country.country_name, sponser_phone, sponsor_district, state_zone_master.state_zone_name, sponser_city_town_place, sponser_pin, DATE_FORMAT(sponser_sadmin_approve_date,'%d/%m/%Y')as sponser_sadmin_approve_date, sponser_missionary_preference, sponsor_allot_mission_status")
                            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left')
                            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
                            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
                            ->order_by('sponsor_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsor_master.id', $value1['sponsor_group_id'])
                            ->get('sponsor_master');
                
                   // var_dump($res_chk); die();
                if($res_chk->num_rows()>0){

                    foreach($res_chk->result_array() as $key=>$value){


                         //var_dump($value); die();
                        $html='<a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewsponsorship/'.$value1['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>';

                                $result[]=array('id'=>$value1['id'],'sponser_name'=>$value['sponser_name'],'sponser_amount'=>$value1['sponser_amount'],'sponser_payment_details'=>$value1['sponser_payment_details'],'sponsor_number_of_installment'=>$value1['sponsor_number_of_installment'],'sponser_promo_office'=>$value['promo_office_name'],'sponser_country_id'=>$value['country_name'],'sponser_phone'=>$value['sponser_phone'],'sponsor_district'=>$value['sponsor_district'],'sponser_state'=>$value['state_zone_name'],'sponser_city_town_place'=>$value['sponser_city_town_place'],'sponser_pin'=>$value['sponser_pin'],'sponser_sadmin_approve_date'=>$value1['sadmin_approve_date'],'sponsor_allot_mission_status'=>$missionaryallotstatus[$value1['sponsor_allot_mission_status']],'action'=>$html);

                     }   


                 }   

                
            
            }
        }else{
            $response['status']="failure";
            $response['message']="No staff list found!!..";
        }
        
        $response['result']=$result;
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    public function gems_allot_mission_sponsorship() {
    	$this->output->set_content_type('application/json');
		$response=array('status'=>"success");

    	$model = json_decode($this->input->post('model',FALSE));

        $staff_ids = $model->selectedstaff;
        //var_dump($model); die();
        

    	if (is_array($staff_ids) && count($staff_ids)>0) {
    		
    		$success_count = 0;
    		foreach ($staff_ids as $staff_id) {

                $res=$this->db->select("sponsor_count")
                        ->where('staff_employee_id', $staff_id)
                        ->get('staff_master');

                 if($res->num_rows()>0) {

                    foreach($res->result_array() as $key=>$value) {

                        if($value['sponsor_count']!=null)
                        {
                            $value['sponsor_count'] = $value['sponsor_count'] +1;
                        }
                        else
                        {
                            $value['sponsor_count'] = 1;
                        }

                        //var_dump($value['sponsor_count']); die();

                        $data = array('sponsor_count' => $value['sponsor_count']);
                        $this->db->where('staff_employee_id', $staff_id);
                        $result=$this->db->update('staff_master', $data);
                    }

                }

                $this->db->query("insert into ".$this->db->dbprefix('allot_missionary')." (
                        missionary_emp_id,
                        sponsor_id,
                        sponsor_amount,
                        allotment_reallotment,
                        withdrawl_status,
                        sadmin_allot_approve,
                        family_sponsor,
                        missionary_withdrawal,
                        revert_sponsorship
                            ) values (
                                '".$staff_id."',
                                '".$model->sponsorshipid."',
                                '".$model->sponsor_amount."',
                                'A',
                                'N',
                                '0',
                                '".$model->family_id."',
                                '0',
                                '0'
                                )");

                if($this->db->insert_id()){
                    $response['result']=array('id'=>$this->db->insert_id());
                    $response['message']="Allot missionary record stored successfully";
                }else{
                    $response['status']="failure";            
                    $response['message']="Sorry!!, Unable to insert the Allot Missionary data";
                }

    			if ($result) {
    				$success_count++;
    			}
    		}

            $data = array('sponsor_allot_mission_status' => '1');
            $this->db->where('id', $model->sponsorid);
            $result1=$this->db->update('sponsor_master', $data);

            $data = array('sponsor_allot_mission_status' => '1');
            $this->db->where('id', $model->sponsorshipid);
            $result2=$this->db->update('sponsorship_master', $data);


            

    		if (count($staff_ids)==$success_count) {
    			$response['message']="Sponsor allotted status has been updated successfully";
    		} else {
    			$response['status']="failure";
    			$response['message']="Sponsor allotted status has not been updated fully";
    		}
    	} else {
    		$response['status']="failure";
    		$response['message']="Choose staff and continue!!..";
    	}

    	die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


     public function gems_allot_child_sponsorship() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        $staff_ids = $model->selectedstaff;
        //var_dump($staff_ids); die();
        

        if (is_array($staff_ids) && count($staff_ids)>0) {
            
            $success_count = 0;
            foreach ($staff_ids as $staff_id) {

                $res=$this->db->select("sponsor_count")
                        ->where('id', $staff_id)
                        ->get('staff_children');

                 if($res->num_rows()>0) {

                    foreach($res->result_array() as $key=>$value) {

                        if($value['sponsor_count']!=null)
                        {
                            $value['sponsor_count'] = $value['sponsor_count'] +1;
                        }
                        else
                        {
                            $value['sponsor_count'] = 1;
                        }

                        //var_dump($value['sponsor_count']); die();

                        $data = array('sponsor_count' => $value['sponsor_count']);
                        $this->db->where('id', $staff_id);
                        $result=$this->db->update('staff_children', $data);
                    }

                }

                $this->db->query("insert into ".$this->db->dbprefix('allot_child')." (
                        missionary_emp_id,
                        sponsor_id,
                        sponsor_amount,
                        allotment_reallotment,
                        withdrawl_status,
                        sadmin_allot_approve,
                        missionary_withdrawal,
                        revert_sponsorship
                            ) values (
                                '".$staff_id."',
                                '".$model->sponsorshipid."',
                                '".$model->sponsor_amount."',
                                'A',
                                'N',
                                '0',
                                '0',
                                '0'
                                )");

                if($this->db->insert_id()){
                    $response['result']=array('id'=>$this->db->insert_id());
                    $response['message']="Allot Child record stored successfully";
                }else{
                    $response['status']="failure";            
                    $response['message']="Sorry!!, Unable to insert the Allot Child data";
                }

                if ($result) {
                    $success_count++;
                }
            }

            $data = array('sponsor_allot_mission_status' => '1');
            $this->db->where('id', $model->sponsorid);
            $result1=$this->db->update('sponsor_master', $data);

            $data = array('sponsor_allot_mission_status' => '1');
            $this->db->where('id', $model->sponsorshipid);
            $result2=$this->db->update('sponsorship_master', $data);


            

            if (count($staff_ids)==$success_count) {
                $response['status']="success";
                $response['message']="Sponsor allotted status has been updated successfully";
            } else {
                $response['status']="failure";
                $response['message']="Sponsor allotted status has not been updated fully";
            }
        } else {
            $response['status']="failure";
            $response['message']="Choose staff and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    public function gems_approve_mission_sponsorship() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        $staff_ids = $model->selectedstaff;

       //print_r($model);die();

        if (is_array($staff_ids) && count($staff_ids)>0) {
            
            $success_count = 0;
            $init=0;
            foreach ($staff_ids as $staff_id) {


                $data = array('sadmin_allot_approve' => '1', 'admin_allot_approve_date' =>date('Y-m-d H:i:s'), 'admin_allot_approved_by' => '1');
                $this->db->where('id', $staff_id);
                $result=$this->db->update('allot_missionary', $data);

                $res=$this->db->select("sponsor_id, missionary_emp_id")
                        ->where('id', $staff_id)
                        ->get('allot_missionary');


                    //print_r($res->result_array());die();
                $promotional_office_email_get=$this->db->select("email_address,id,promo_office_name")
                                ->like('promo_office_name',$model->promotionalOfficeList[$init])
                                ->get('promotional_office_master');  

                $promo_det= $promotional_office_email_get->result_array();
                 
                $promo_email=$promo_det[0]['email_address']; 
                 //print_r($promo_det[0]['email_address']);die();      

                $init++;

                 if($res->num_rows()>0) {

                    foreach($res->result_array() as $key=>$value) {

                        $to_list = array('welfare@gemsbihar.org', 'srd@gemsbihar.org', 'finance@gemsbihar.org');

                        if($value['sponsor_id']!=null)
                        {   


                                $staff_approve_list=$this->db->select("missionary_emp_id,sponsor_id,allotment_reallotment")
                                ->where('allot_missionary.sponsor_id', $value['sponsor_id'])
                                ->get('allot_missionary');  


                                $det_emp=array();
                                    $i=0;
                                //$staff_det_missionary= $staff_approve_list->result_array();
                                 foreach($staff_approve_list->result_array() as $key=>$staff_list) {
                                    // print_r($staff_list);
                                    // print_r($value['missionary_emp_id']);
                                    
                                    if(($staff_list['missionary_emp_id']==$value['missionary_emp_id'])||($staff_list['allotment_reallotment']=='A'))
                                    {
                                        $staff_det_get_now=$this->db->select("staff_name, present_email, staff_department_id, zone_id, staff_employee_id")
                                        ->where('staff_master.staff_employee_id', $staff_list['missionary_emp_id'])
                                        ->get('staff_master');  
                                        $staff_det_now= $staff_det_get_now->result_array();

                                        $det_emp[$i]=array($staff_det_now[0]['staff_name'],$staff_det_now[0]['zone_id']); 
                                        //$det_emp[]=; 
                                        $i++;
                                    }
                                 } 

                                //  print_r($det_emp);die();
                                $staff_det_get=$this->db->select("staff_name, present_email, staff_department_id, zone_id, staff_employee_id")
                                ->where('staff_master.staff_employee_id', $value['missionary_emp_id'])
                                ->get('staff_master');  

                                $staff_det= $staff_det_get->result_array();
                                if($det_emp[0][0])
                                {
                                    
                                    $zone_det_get=$this->db->select("staff_zone_name, email_id")
                                        ->where('zones_staff_master.id', $det_emp[0][1])
                                        ->get('zones_staff_master');  

                                    $zone_det= $zone_det_get->result_array();
                                    if($det_emp[1][1]){
                                         $zone_det_get_1=$this->db->select("staff_zone_name, email_id")
                                        ->where('zones_staff_master.id', $det_emp[1][1])
                                        ->get('zones_staff_master');  

                                    $zone_det_1= $zone_det_get_1->result_array();
                                    }
                                   
                                }

                                $zone_from_allot=$this->db->select("staff_zone_name, email_id")
                                        ->where('zones_staff_master.id', $staff_det[0]['zone_id'])
                                        ->get('zones_staff_master');  

                                    $zone_for_allot= $zone_from_allot->result_array();
                                //pr($zone_for_allot[0]['staff_zone_name']);die();

                            $sponsorship_data=$this->db->select("id, sponsor_group_id,sponsor_missionary_remarks")
                                    ->where('id', $value['sponsor_id'])
                                    ->get('sponsorship_master');

                                    $sponsorship_result = $sponsorship_data->result_array();

                                     //print_r($sponsorship_result);die();

                            $remarks_from_allot=($sponsorship_result[0]['sponsor_missionary_remarks'])?$sponsorship_result[0]['sponsor_missionary_remarks']:'';

                            $remarks_from_allot_missionary= nl2br($remarks_from_allot."\n".$staff_det[0]['staff_employee_id'].'--'.$zone_for_allot[0]['staff_zone_name'].'--'.date('Y-m-d H:i:s'));

                            print_r($remarks_from_allot_missionary);die();
                                if($sponsorship_data->num_rows()>0){

                                    $data = array('sponsor_allot_mission_status' => '1');
                                    $this->db->where('id', $sponsorship_result[0]['sponsor_group_id']);
                                    $result1=$this->db->update('sponsor_master', $data);

                                    $data = array('sponsor_allot_mission_status' => '1','sponsor_missionary_remarks'=>$remarks_from_allot_missionary);
                                    $this->db->where('id', $sponsorship_result[0]['id']);
                                    $result2=$this->db->update('sponsorship_master', $data);
                                }
                                

                            $sponsor_data = array('sponser_sadmin_approve' => '1', 'sponser_sadmin_approve_date' =>date('Y-m-d H:i:s'));
                            $this->db->where('id', $value['sponsor_id']);
                            $result=$this->db->update('sponsor_master', $sponsor_data);
                        }
                    }


                    if($staff_det_get->num_rows()>0)
                    {
                        if($staff_det[0]['present_email'])
                        {
                            array_push($to_list, $staff_det[0]['present_email']);
                        }

                        if($promo_email){
                            array_push($to_list, $promo_email);
                        }

                        

                        if($det_emp[0][0]  && $zone_det[0]['staff_zone_name'])
                        {
                            
                            // echo $det_emp[0][0]."<br>".$zone_det[0]['staff_zone_name']."<br>".$det_emp[1][0]."<br>".$zone_det_1[0]['staff_zone_name'];
                            // die();
                            $message_info="Dearly beloved in Christ Jesus,<br>
                                    GGreetings form GEMS family!<br> Thank you so much for being a strong supporter of GEMS ministry and an active partner in financially supporting the work of God by sponsoring a missionary<br>
                                        We would like to bring to your kind notice that there has been a re-Allotment of missionary towards your sponsorship. We had to change the allotment towards <b>" .$det_emp[0][0]. " </b> of 
                                             <b>" .$zone_det[0]['staff_zone_name']. "</b>, who is being sponsored by you.<br>

                                        With this background we have re-allotted your sponsorship to <b>".$det_emp[1][0]."</b> of <b>" .$zone_det_1[0]['staff_zone_name']. "</b> of GEMS. The missionary’s reference number is 1501M. Kindly use this number for any future reference. The missionary is actively involved in Church planting and evangelism.<br>

                                        We will try our best to collect the prayer report from the missionaries and reach you periodically. We pray that God will bless you for all your support and cooperation.<br>
                                        Closing with prayers,
                                        <br>
                                        Yours in His vineyard,<br>
                                        D. Augustine Jebakumar<br>
                                        Copy to: Promotional Office (Bihar)<br>";

                                   //print_r($message_info);die();     
                                    $response['result']=$message_info;
                        }
                        
                       // var_dump($message_info); die();
                        //print_r($to_list);die();
                        $this->load->library('email');
                        //$this->email->from('sridhar.muthusamy@aesasp.com');
                        $this->email->from('hr@gemsbihar.org');
                        $this->email->to($to_list);
                        $this->email->subject('Allotment Missionary');
                        $this->email->message($message_info);
                        try{
                        $this->email->send();

                        //var_dump($this->email->send()); die();
                        //echo 'Message has been sent.';
                        $response['result']=$message_info;
                        $response['message']="Staff transfer record has been updated successfully";


                        }catch(Exception $e){
                        //echo $e->getMessage();
                        }
                    }
                    else
                    {
                        $response['status']="failure";
                    }
                }



                if ($result) {
                    $response['message']="Sponsor Approved status has been updated successfully";
                }
                else
                {
                     $response['status']="failure";
                $response['message']="Sponsor Approved status has not been updated fully";
                }
            }

        } else {
            $response['status']="failure";
            $response['message']="Choose missionary and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


    public function gems_previewmail_approve_mission_sponsorship() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        $staff_id = $model->staff_id;

        if ($staff_id) {
            
            $success_count = 0;

                $res=$this->db->select("sponsor_id, missionary_emp_id")
                        ->where('id', $staff_id)
                        ->get('allot_missionary');

                 if($res->num_rows()>0) {

                    foreach($res->result_array() as $key=>$value) {

                        $to_list = array('welfare@gemsbihar.org', 'srd@gemsbihar.org', 'finance@gemsbihar.org');

                        if($value['sponsor_id']!=null)
                        {   


                                $staff_approve_list=$this->db->select("missionary_emp_id,sponsor_id,allotment_reallotment")
                                ->where('allot_missionary.sponsor_id', $value['sponsor_id'])
                                ->get('allot_missionary');  
                                    $det_emp=array();
                                    $i=0;
                                //$staff_det_missionary= $staff_approve_list->result_array();
                                 foreach($staff_approve_list->result_array() as $key=>$staff_list) {
                                    // print_r($staff_list);
                                    // print_r($value['missionary_emp_id']);
                                    
                                    if(($staff_list['missionary_emp_id']==$value['missionary_emp_id'])||($staff_list['allotment_reallotment']=='A'))
                                    {
                                        $staff_det_get_now=$this->db->select("staff_name, present_email, staff_department_id, zone_id, staff_cross_ref_number,staff_gender")
                                        ->where('staff_master.staff_employee_id', $staff_list['missionary_emp_id'])
                                        ->get('staff_master');  
                                        $staff_det_now= $staff_det_get_now->result_array();
                                        $det_emp[$i]=array($staff_det_now[0]['staff_name'],$staff_det_now[0]['zone_id'],
                                            $staff_det_now[0]['staff_cross_ref_number'],$staff_det_now[0]['staff_gender']); 
                                        //$det_emp[]=; 
                                        $i++;
                                    }
                                 }
                                  //  print_r($det_emp);
                                  // die();

                                $staff_det_get=$this->db->select("staff_name, present_email, staff_department_id, zone_id, staff_employee_id")
                                ->where('staff_master.staff_employee_id', $value['missionary_emp_id'])
                                ->get('staff_master');  

                                $staff_det= $staff_det_get->result_array();


                                if($det_emp[0][0])
                                {
                                    // $department_det_get=$this->db->select("department_name")
                                    //     ->where('staff_department_master.id', $staff_det[0]['staff_department_id'])
                                    //     ->get('staff_department_master');  

                                    // $department_det= $department_det_get->result_array();

                                    $zone_det_get=$this->db->select("staff_zone_name, email_id")
                                        ->where('zones_staff_master.id', $det_emp[0][1])
                                        ->get('zones_staff_master');  

                                    $zone_det= $zone_det_get->result_array();

                                    $zone_det_get_1=$this->db->select("staff_zone_name, email_id")
                                        ->where('zones_staff_master.id', $det_emp[1][1])
                                        ->get('zones_staff_master');  

                                    $zone_det_1= $zone_det_get_1->result_array();
                                }

                        }
                    }


                    if($staff_det_get->num_rows()>0)
                    {
                        if($staff_det[0]['present_email'])
                        {
                            array_push($to_list, $staff_det[0]['present_email']);
                        }

                        

                        if($det_emp[0][0]  && $zone_det[0]['staff_zone_name'])
                        {
                            
                            // echo $det_emp[0][0]."<br>".$zone_det[0]['staff_zone_name']."<br>".$det_emp[1][0]."<br>".$zone_det_1[0]['staff_zone_name'];
                            // die();
                            if($det_emp[0][3]==1)
                            {
                                $gender='M';
                            }
                            else{
                                $gender='F';
                            }
                            $message_info="Dearly beloved in Christ Jesus,<br>
                                    GGreetings form GEMS family!<br> Thank you so much for being a strong supporter of GEMS ministry and an active partner in financially supporting the work of God by sponsoring a missionary<br>
                                        We would like to bring to your kind notice that there has been a re-Allotment of missionary towards your sponsorship. We had to change the allotment towards <b>" .$det_emp[0][0]. " </b> of 
                                             <b>" .$zone_det[0]['staff_zone_name']. "</b>, who is being sponsored by you.<br>

                                        With this background we have re-allotted your sponsorship to <b>".$det_emp[1][0]."</b> of <b>" .$zone_det_1[0]['staff_zone_name']. "</b> of GEMS. The missionary’s reference number is <b>".$det_emp[1][2]." ".$gender."</b> . Kindly use this number for any future reference. The missionary is actively involved in Church planting and evangelism.<br>

                                        We will try our best to collect the prayer report from the missionaries and reach you periodically. We pray that God will bless you for all your support and cooperation.<br>
                                        Closing with prayers,
                                        <br>
                                        Yours in His vineyard,<br>
                                        D. Augustine Jebakumar<br>
                                        Copy to: Promotional Office (Bihar)<br>";

                                    $response['result']=$message_info;
                        }
                        
                       // var_dump($message_info); die();

                        // $this->load->library('email');
                        // //$this->email->from('sridhar.muthusamy@aesasp.com');
                        // $this->email->from('hr@gemsbihar.org');
                        // $this->email->to($to_list);
                        // $this->email->subject('Allotment Missionary');
                        // $this->email->message($message_info);
                        // try{
                        // $this->email->send();

                        //var_dump($this->email->send()); die();
                        //echo 'Message has been sent.';
                        
                        $response['message']="Staff transfer record has been updated successfully";


                        // }catch(Exception $e){
                        // //echo $e->getMessage();
                        // }
                    }
                    else
                    {
                        $response['status']="failure";
                    }
                }
            

        } else {
            $response['status']="failure";
            $response['message']="Choose missionary and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


    public function gems_resend_reallot_mission_sponsorship() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        $staff_id = $model->selectedstaff;

        if ($staff_id) {
            
            $success_count = 0;

                $res=$this->db->select("sponsor_id, missionary_emp_id")
                        ->where('id', $staff_id)
                        ->get('allot_missionary');

                 if($res->num_rows()>0) {

                    foreach($res->result_array() as $key=>$value) {

                        $to_list = array('welfare@gemsbihar.org', 'srd@gemsbihar.org', 'finance@gemsbihar.org');

                        if($value['sponsor_id']!=null)
                        {   

                                $staff_det_get=$this->db->select("staff_name, present_email, staff_department_id, zone_id, staff_employee_id")
                                ->where('staff_master.staff_employee_id', $value['missionary_emp_id'])
                                ->get('staff_master');  

                                $staff_det= $staff_det_get->result_array();


                                if($staff_det[0]['staff_name'])
                                {
                                    $department_det_get=$this->db->select("department_name")
                                        ->where('staff_department_master.id', $staff_det[0]['staff_department_id'])
                                        ->get('staff_department_master');  

                                    $department_det= $department_det_get->result_array();

                                    $zone_det_get=$this->db->select("staff_zone_name, email_id")
                                        ->where('zones_staff_master.id', $staff_det[0]['zone_id'])
                                        ->get('zones_staff_master');  

                                    $zone_det= $zone_det_get->result_array();
                                }

                        }
                    }


                    if($staff_det_get->num_rows()>0)
                    {
                        if($staff_det[0]['present_email'])
                        {
                            array_push($to_list, $staff_det[0]['present_email']);
                        }

                        

                        if($staff_det[0]['staff_name'] && $department_det[0]['department_name'] && $zone_det[0]['staff_zone_name'])
                        {
                            $message_info="Dearly beloved in Christ Jesus,<br>
                                    Greetings to you in His blessed name! God loves a cheerful giver and will enlarge the harvest of your righteousness. You will be made rich in every way so that you can be generous on every occasion.. <br>
                                    We greatly appreciate your love and concern for Gods work and for especially coming forward to sponsor one of our missionary.<br>
                                    In view of the above, we are glad to inform you that <b>" .$staff_det[0]['staff_name']. " </b> is allotted to be sponsored by you. This missionary is presently based in <b>" .$department_det[0]['department_name']. "</b> under <b>".$zone_det[0]['staff_zone_name']."</b> Zone of GEMS. Your reference number for this missionary is <b>".$staff_det[0]['staff_employee_id']."</b>. For future reference, kindly use this number. <br>
                                    <b>" .$staff_det[0]['staff_name']. " </b> has been advised to send ministerial reports on a regular basis, which will enable you to pray and praise the Lord for all His works in this part of the land. We request you to accept our missionary by upholding their ministry through your fervent prayers and sacrificial offering.<br>
                                    Once again I want to thank you for all that you mean for the cause of His Kingdom and pray that the God of Peace make you complete in every good work to do His will, working in you what is well pleasing in His sight, through Jesus Christ, to whom be Glory! Amen!<br>
                                    Closing with prayers,
                                    <br>
                                    Yours in His vineyard,<br>
                                    D. Augustine Jebakumar<br>
                                    Copy to: Promotional Office (Bihar)<br>";

                                    $response['result']=$message_info;
                        }
                        
                       // var_dump($message_info); die();

                        $this->load->library('email');
                        //$this->email->from('sridhar.muthusamy@aesasp.com');
                        $this->email->from('hr@gemsbihar.org');
                        $this->email->to($to_list);
                        $this->email->subject('Allotment Missionary');
                        $this->email->message($message_info);
                        try{
                        $this->email->send();

                        //var_dump($this->email->send()); die();
                        //echo 'Message has been sent.';
                        
                        $response['message']="Staff transfer record has been updated successfully";


                        }catch(Exception $e){
                        //echo $e->getMessage();
                        }
                    }
                    else
                    {
                        $response['status']="failure";
                    }
                }
            

        } else {
            $response['status']="failure";
            $response['message']="Choose missionary and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


    public function gems_preview_mail_mission_sponsorship() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        $staff_id = $model->staff_id;



        

        if ($staff_id) {
            
            $success_count = 0;


                // $data = array('sadmin_allot_approve' => '1', 'admin_allot_approve_date' =>date('Y-m-d H:i:s'), 'admin_allot_approved_by' => '1');
                // $this->db->where('id', $staff_id);
                // $result=$this->db->update('allot_missionary', $data);

                $res=$this->db->select("sponsor_id, missionary_emp_id")
                        ->where('missionary_emp_id', $staff_id)
                        ->get('allot_missionary');


                    //var_dump($res->result_array()); die();
                       



                 if($res->num_rows()>0) {

                    foreach($res->result_array() as $key=>$value) {

                        $to_list = array('welfare@gemsbihar.org', 'srd@gemsbihar.org', 'finance@gemsbihar.org');

                        if($value['sponsor_id']!=null)
                        {   

                                $staff_det_get=$this->db->select("staff_name, present_email, staff_department_id, zone_id, staff_employee_id")
                                ->where('staff_master.staff_employee_id', $value['missionary_emp_id'])
                                ->get('staff_master');  

                                $staff_det= $staff_det_get->result_array();




                                if($staff_det[0]['staff_name'])
                                {
                                    $department_det_get=$this->db->select("department_name")
                                        ->where('staff_department_master.id', $staff_det[0]['staff_department_id'])
                                        ->get('staff_department_master');  

                                    $department_det= $department_det_get->result_array();

                                    $zone_det_get=$this->db->select("staff_zone_name, email_id")
                                        ->where('zones_staff_master.id', $staff_det[0]['zone_id'])
                                        ->get('zones_staff_master');  

                                    $zone_det= $zone_det_get->result_array();
                                }

                        }

                        break;
                    }

                    

                   // var_dump($staff_det_get->num_rows()); die();
                    if($staff_det_get->num_rows()>0)
                    {
                        if($staff_det[0]['present_email'])
                        {
                            array_push($to_list, $staff_det[0]['present_email']);
                        }

                        

                        if($staff_det[0]['staff_name'] && $department_det[0]['department_name'] && $zone_det[0]['staff_zone_name'])
                        {
                            $message_info="<p>Dearly beloved in Christ Jesus,<br>
                                    Greetings to you in His blessed name! God loves a cheerful giver and will enlarge the harvest of your righteousness. You will be made rich in every way so that you can be generous on every occasion.. 
                                    <br>
                                    We greatly appreciate your love and concern for Gods work and for especially coming forward to sponsor one of our missionary.
                                    <br>
                                    In view of the above, we are glad to inform you that <b>" .$staff_det[0]['staff_name']. " </b> is allotted to be sponsored by you. This missionary is presently based in <b>" .$department_det[0]['department_name']. "</b> under <b>".$zone_det[0]['staff_zone_name']."</b> Zone of GEMS. Your reference number for this missionary is <b>".$staff_det[0]['staff_employee_id']."</b>. For future reference, kindly use this number. 
                                    <br>
                                    <b>" .$staff_det[0]['staff_name']. " </b> has been advised to send ministerial reports on a regular basis, which will enable you to pray and praise the Lord for all His works in this part of the land. We request you to accept our missionary by upholding their ministry through your fervent prayers and sacrificial offering.
                                    <br>
                                    Once again I want to thank you for all that you mean for the cause of His Kingdom and pray that the God of Peace make you complete in every good work to do His will, working in you what is well pleasing in His sight, through Jesus Christ, to whom be Glory! Amen!
                                    <br>
                                    Closing with prayers,
                                    <br>
                                    Yours in His vineyard,<br>
                                    D. Augustine Jebakumar<br>
                                    Copy to: Promotional Office (Bihar)<br></p>";

                                    $response['result']=$message_info;
                        }
                        
                       // var_dump($message_info); die();

                        // $this->load->library('email');
                        // //$this->email->from('sridhar.muthusamy@aesasp.com');
                        // $this->email->from('hr@gemsbihar.org');
                        // $this->email->to($to_list);
                        // $this->email->subject('Allotment Missionary');
                        // $this->email->message($message_info);
                        // try{
                        // $this->email->send();

                        //var_dump($this->email->send()); die();
                        //echo 'Message has been sent.';
                        
                        $response['message']="Staff transfer record has been updated successfully";


                        
                    }
                    else
                    {
                        $response['status']="failure";
                    }
                
            }

        } else {
            $response['status']="failure";
            $response['message']="Choose missionary and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }



    public function gems_resend_mail_mission_sponsorship() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        $staff_id = $model->staff_id;

        if ($staff_id) {
            
            $success_count = 0;

                $res=$this->db->select("sponsor_id, missionary_emp_id")
                        ->where('missionary_emp_id', $staff_id)
                        ->get('allot_missionary');

                 if($res->num_rows()>0) {

                    foreach($res->result_array() as $key=>$value) {

                        $to_list = array('welfare@gemsbihar.org', 'srd@gemsbihar.org', 'finance@gemsbihar.org');

                        if($value['sponsor_id']!=null)
                        {   

                                $staff_det_get=$this->db->select("staff_name, present_email, staff_department_id, zone_id, staff_employee_id")
                                ->where('staff_master.staff_employee_id', $value['missionary_emp_id'])
                                ->get('staff_master');  

                                $staff_det= $staff_det_get->result_array();

                                if($staff_det[0]['staff_name'])
                                {
                                    $department_det_get=$this->db->select("department_name")
                                        ->where('staff_department_master.id', $staff_det[0]['staff_department_id'])
                                        ->get('staff_department_master');  

                                    $department_det= $department_det_get->result_array();

                                    $zone_det_get=$this->db->select("staff_zone_name, email_id")
                                        ->where('zones_staff_master.id', $staff_det[0]['zone_id'])
                                        ->get('zones_staff_master');  

                                    $zone_det= $zone_det_get->result_array();
                                }

                        }

                        break;
                    }

                    if($staff_det_get->num_rows()>0)
                    {
                        if($staff_det[0]['present_email'])
                        {
                            array_push($to_list, $staff_det[0]['present_email']);
                        }

                        if($staff_det[0]['staff_name'] && $department_det[0]['department_name'] && $zone_det[0]['staff_zone_name'])
                        {
                            $message_info="<p>Dearly beloved in Christ Jesus,<br>
                                    Greetings to you in His blessed name! God loves a cheerful giver and will enlarge the harvest of your righteousness. You will be made rich in every way so that you can be generous on every occasion.. 
                                    <br>
                                    We greatly appreciate your love and concern for Gods work and for especially coming forward to sponsor one of our missionary.
                                    <br>
                                    In view of the above, we are glad to inform you that <b>" .$staff_det[0]['staff_name']. " </b> is allotted to be sponsored by you. This missionary is presently based in <b>" .$department_det[0]['department_name']. "</b> under <b>".$zone_det[0]['staff_zone_name']."</b> Zone of GEMS. Your reference number for this missionary is <b>".$staff_det[0]['staff_employee_id']."</b>. For future reference, kindly use this number. 
                                    <br>
                                    <b>" .$staff_det[0]['staff_name']. " </b> has been advised to send ministerial reports on a regular basis, which will enable you to pray and praise the Lord for all His works in this part of the land. We request you to accept our missionary by upholding their ministry through your fervent prayers and sacrificial offering.
                                    <br>
                                    Once again I want to thank you for all that you mean for the cause of His Kingdom and pray that the God of Peace make you complete in every good work to do His will, working in you what is well pleasing in His sight, through Jesus Christ, to whom be Glory! Amen!
                                    <br>
                                    Closing with prayers,
                                    <br>
                                    Yours in His vineyard,<br>
                                    D. Augustine Jebakumar<br>
                                    Copy to: Promotional Office (Bihar)<br></p>";

                                    $response['result']=$message_info;
                        }
                        
                       // var_dump($message_info); die();

                        $this->load->library('email');
                        //$this->email->from('sridhar.muthusamy@aesasp.com');
                        $this->email->from('hr@gemsbihar.org');
                        $this->email->to($to_list);
                        $this->email->subject('Allotment Missionary');
                        $this->email->message($message_info);
                        try{
                        $this->email->send();

                        //var_dump($this->email->send()); die();
                        //echo 'Message has been sent.';
                        
                        $response['message']="Staff transfer record has been updated successfully";
                        }catch(Exception $e){
                        //echo $e->getMessage();
                        }

                        
                    }
                    else
                    {
                        $response['status']="failure";
                    }
                
            }

        } else {
            $response['status']="failure";
            $response['message']="Choose missionary and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


    public function gems_approve_reallot_child_sponsorship() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        $staff_ids = $model->selectedstaff;

        

        if (is_array($staff_ids) && count($staff_ids)>0) {
            
            $success_count = 0;
            foreach ($staff_ids as $staff_id) {


                $data = array('sadmin_allot_approve' => '1', 'admin_allot_approve_date' =>date('Y-m-d H:i:s'), 'admin_allot_approved_by' => '1');
                $this->db->where('id', $staff_id);
                $result=$this->db->update('allot_child', $data);

                            $mkd_allot_result=$this->db->select("id, sponsor_id")
                            ->where('id', $staff_id)
                            ->get('allot_child');

                            $mkd_allot_data = $mkd_allot_result->result_array();


                            if($mkd_allot_result->num_rows()>0){

                                $sponsorship_data=$this->db->select("id, sponsor_group_id")
                                ->where('id', $mkd_allot_data[0]['sponsor_id'])
                                ->get('sponsorship_master');

                                $sponsorship_result = $sponsorship_data->result_array();

                                if($sponsorship_data->num_rows()>0){

                                  //  var_dump($sponsorship_data->result_array()); die();


                                    $data = array('sponsor_allot_mission_status' => '2');
                                    $this->db->where('id', $sponsorship_result[0]['sponsor_group_id']);
                                    $result1=$this->db->update('sponsor_master', $data);

                                    $data = array('sponsor_allot_mission_status' => '2');
                                    $this->db->where('id', $sponsorship_result[0]['id']);
                                    $result2=$this->db->update('sponsorship_master', $data);
                                }

                            }


                             


                if ($result) {
                    $response['message']="Sponsor Approved status has been updated successfully";
                }
                else
                {
                     $response['status']="failure";
                $response['message']="Sponsor Approved status has not been updated fully";
                }
            }

        } else {
            $response['status']="failure";
            $response['message']="Choose missionary and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

     public function gems_approve_child_sponsorship() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        $staff_ids = $model->selectedstaff;

        

        if (is_array($staff_ids) && count($staff_ids)>0) {
            
            $success_count = 0;
            foreach ($staff_ids as $staff_id) {


                $data = array('sadmin_allot_approve' => '1', 'admin_allot_approve_date' =>date('Y-m-d H:i:s'), 'admin_allot_approved_by' => '1');
                $this->db->where('missionary_emp_id', $staff_id);
                $result=$this->db->update('allot_child', $data);

                            $child_result=$this->db->select("id, sponsor_id")
                            ->where('missionary_emp_id', $staff_id)
                            ->get('allot_child');

                            if($child_result->num_rows()>0){

                                $child_data=$child_result->result_array();

                                $sponsorship_data=$this->db->select("id, sponsor_group_id")
                                ->where('id', $child_data[0]['sponsor_id'])
                                ->get('sponsorship_master');

                                $sponsorship_result = $sponsorship_data->result_array();

                                if($sponsorship_data->num_rows()>0){

                                    $data = array('sponsor_allot_mission_status' => '1');
                                    $this->db->where('id', $sponsorship_result[0]['sponsor_group_id']);
                                    $result1=$this->db->update('sponsor_master', $data);

                                    $data = array('sponsor_allot_mission_status' => '1');
                                    $this->db->where('id', $sponsorship_result[0]['id']);
                                    $result2=$this->db->update('sponsorship_master', $data);
                                }

                            }


                            


                if ($result) {
                    $response['message']="Sponsor Approved status has been updated successfully";
                }
                else
                {
                     $response['status']="failure";
                $response['message']="Sponsor Approved status has not been updated fully";
                }
            }

        } else {
            $response['status']="failure";
            $response['message']="Choose missionary and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

     public function gems_revoke_mission_sponsorship() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        $staff_ids = $model->selectedstaff;

        

        if (is_array($staff_ids) && count($staff_ids)>0) {
            
            $success_count = 0;
            foreach ($staff_ids as $staff_id) {


                $res=$this->db->select("allot_missionary.id, missionary_emp_id, sponsor_id, sponsor_amount, allotment_reallotment, withdrawl_status, sadmin_allot_approve, admin_allot_approve_date, family_sponsor, admin_allot_approved_by, missionary_withdrawal")
                    ->where('id', $staff_id)
                    ->get('allot_missionary');

                // $res=$this->db->select("sponsor_count")
                //         ->where('staff_employee_id', $staff_id)
                //         ->get('staff_master');
                    //var_dump($res->num_rows()); die();
                 if($res->num_rows()>0) {

                    foreach($res->result_array() as $key=>$value) {


                        $res_chk=$this->db->select("sponsorship_master.id, sponsor_group_id, category_sponsorship, sponser_amount")
                            ->order_by('sponsorship_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsorship_master.id', $value['sponsor_id'])
                            ->get('sponsorship_master');  

                        $res_chk = $res_chk->result_array();

                        $staff_res_chk=$this->db->select("staff_master.id, staff_employee_id, staff_name,  staff_cross_ref_number, zone_id, zones_staff_master.staff_zone_name, sponsor_count")
                                    ->join('zones_staff_master', 'staff_master.zone_id=zones_staff_master.id', 'left')
                                    ->where('staff_delete_status', '0')
                                    ->where('staff_employee_id', $value['missionary_emp_id'])
                                    ->get('staff_master');          
                        $staff_res_chk = $staff_res_chk->result_array();


                      // var_dump($res_chk); die();
                        if($staff_res_chk[0]['sponsor_count']!=null)
                        {
                            $staff_res_chk[0]['sponsor_count'] = $staff_res_chk[0]['sponsor_count'] -1;
                        }

                        //var_dump($value['sponsor_count']); die();

                        $data = array('sponsor_count' => $staff_res_chk[0]['sponsor_count']);
                        $this->db->where('staff_employee_id', $value['missionary_emp_id']);
                        $result=$this->db->update('staff_master', $data);

                        $data = array('sponsor_allot_mission_status' => '4');
                        $this->db->where('id', $res_chk[0]['sponsor_group_id']);
                        $result1=$this->db->update('sponsor_master', $data);

                        $data = array('sponsor_allot_mission_status' => '4');
                        $this->db->where('id', $value['sponsor_id']);
                        $result2=$this->db->update('sponsorship_master', $data);


                    }

                }

                $this->db->query("delete from ".$this->db->dbprefix('allot_missionary')."  where id='".$staff_id."'");
                $response['status']="success";
                $response['message']="Allot missionary record has been deleted successfully";

            }

            

        } else {
            $response['status']="failure";
            $response['message']="Choose staff and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


     public function gems_revoke_reallot_child_sponsorship() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        $staff_ids = $model->selectedstaff;

        

        if (is_array($staff_ids) && count($staff_ids)>0) {
            
            $success_count = 0;
            foreach ($staff_ids as $staff_id) {


                $res=$this->db->select("allot_child.id, missionary_emp_id, sponsor_id, sponsor_amount, allotment_reallotment, withdrawl_status, sadmin_allot_approve, admin_allot_approve_date, admin_allot_approved_by, missionary_withdrawal")
                    ->where('id', $staff_id)
                    ->get('allot_child');

                 if($res->num_rows()>0) {

                    foreach($res->result_array() as $key=>$value) {


                        $res_chk=$this->db->select("sponsorship_master.id, sponsor_group_id, category_sponsorship, sponser_amount")
                            ->order_by('sponsorship_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsorship_master.id', $value['sponsor_id'])
                            ->get('sponsorship_master');  

                        $res_chk = $res_chk->result_array();

                        $staff_res_chk=$this->db->select("staff_master.id, staff_employee_id, staff_name,  staff_cross_ref_number, zone_id, zones_staff_master.staff_zone_name, sponsor_count")
                                    ->join('zones_staff_master', 'staff_master.zone_id=zones_staff_master.id', 'left')
                                    ->where('staff_delete_status', '0')
                                    ->where('staff_employee_id', $value['missionary_emp_id'])
                                    ->get('staff_master');          

                        if($staff_res_chk->num_rows()>0){

                            $staff_res_chk = $staff_res_chk->result_array();

                            if($staff_res_chk[0]['sponsor_count']!=null)
                            {
                                $staff_res_chk[0]['sponsor_count'] = $staff_res_chk[0]['sponsor_count'] -1;
                            }

                            $data = array('sponsor_count' => $staff_res_chk[0]['sponsor_count']);
                            $this->db->where('staff_employee_id', $value['missionary_emp_id']);
                            $result=$this->db->update('staff_master', $data);

                            $data = array('sponsor_allot_mission_status' => '3');
                            $this->db->where('id', $res_chk[0]['sponsor_group_id']);
                            $result1=$this->db->update('sponsor_master', $data);

                            $data = array('sponsor_allot_mission_status' => '3');
                            $this->db->where('id', $value['sponsor_id']);
                            $result2=$this->db->update('sponsorship_master', $data);


                        }


                       


                    }

                }

                $this->db->query("delete from ".$this->db->dbprefix('allot_child')."  where id='".$staff_id."'");
                $response['status']="success";
                $response['message']="Reallot Child record has been deleted successfully";

            }

            

        } else {
            $response['status']="failure";
            $response['message']="Choose staff and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

     public function gems_revoke_child_sponsorship() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        $staff_ids = $model->selectedstaff;

        

        if (is_array($staff_ids) && count($staff_ids)>0) {
            
            $success_count = 0;
            foreach ($staff_ids as $staff_id) {


                $res=$this->db->select("allot_child.id, missionary_emp_id, sponsor_id, sponsor_amount, allotment_reallotment, withdrawl_status, sadmin_allot_approve, admin_allot_approve_date, admin_allot_approved_by, missionary_withdrawal")
                    ->where('id', $staff_id)
                    ->get('allot_child');

                // $res=$this->db->select("sponsor_count")
                //         ->where('staff_employee_id', $staff_id)
                //         ->get('staff_master');
                    //var_dump($res->num_rows()); die();
                 if($res->num_rows()>0) {

                    foreach($res->result_array() as $key=>$value) {


                        $res_chk=$this->db->select("sponsorship_master.id, sponsor_group_id, category_sponsorship, sponser_amount")
                            ->order_by('sponsorship_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsorship_master.id', $value['sponsor_id'])
                            ->get('sponsorship_master');  

                        $res_chk = $res_chk->result_array();

                        // $staff_res_chk=$this->db->select("staff_master.id, staff_employee_id, staff_name,  staff_cross_ref_number, zone_id, zones_staff_master.staff_zone_name, sponsor_count")
                        //             ->join('zones_staff_master', 'staff_master.zone_id=zones_staff_master.id', 'left')
                        //             ->where('staff_delete_status', '0')
                        //             ->where('staff_employee_id', $value['missionary_emp_id'])
                        //             ->get('staff_master');          
                        // $staff_res_chk = $staff_res_chk->result_array();


                        $child_res_chk=$this->db->select("staff_children.id, staff_id, children_name,  cross_ref_no, staff_zone_id, zones_staff_master.staff_zone_name, sponsor_count")
                                    ->join('zones_staff_master', 'staff_children.staff_zone_id=zones_staff_master.id', 'left')
                                    ->get('staff_children');          
                        $child_res_chk = $child_res_chk->result_array();


                      // var_dump($res_chk); die();
                        if($child_res_chk[0]['sponsor_count']!=null)
                        {
                            $child_res_chk[0]['sponsor_count'] = $child_res_chk[0]['sponsor_count'] -1;
                        }

                        //var_dump($value['sponsor_count']); die();

                        $data = array('sponsor_count' => $child_res_chk[0]['sponsor_count']);
                        $result=$this->db->update('staff_children', $data);

                        $data = array('sponsor_allot_mission_status' => '4');
                        $this->db->where('id', $res_chk[0]['sponsor_group_id']);
                        $result1=$this->db->update('sponsor_master', $data);

                        $data = array('sponsor_allot_mission_status' => '4');
                        $this->db->where('id', $value['sponsor_id']);
                        $result2=$this->db->update('sponsorship_master', $data);


                    }

                }

                $this->db->query("delete from ".$this->db->dbprefix('allot_child')."  where id='".$staff_id."'");
                $response['status']="success";
                $response['message']="Allot missionary record has been deleted successfully";

            }

            

        } else {
            $response['status']="failure";
            $response['message']="Choose staff and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


    public function gems_insert_withdrawl_missionary() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        //var_dump($model); die();
        $staff_ids = $model->selectedstaff;

        

        if (is_array($staff_ids) && count($staff_ids)>0) {
            
            $success_count = 0;
            foreach ($staff_ids as $staff_id) {


                $data = array('withdrawl_status' => 'W');
                $this->db->where('id', $staff_id);
                $result=$this->db->update('allot_missionary', $data);

                $res=$this->db->query("select * from ".$this->db->dbprefix('staff_master')." where id ='".$staff_id."'");

                    if($res->num_rows()>0){
                         $in_array=$res->result_array();

                         if($in_array[0]['sponsor_count']==NULL || $in_array[0]['sponsor_count']==0)
                         {
                            $in_array[0]['sponsor_count']=0;
                         }
                         else
                         {
                            $in_array[0]['sponsor_count']=$in_array[0]['sponsor_count']-1;
                         }   

                        // var_dump($in_array[0]['sponsor_count']); die();

                         $data = array('sponsor_count' => $in_array[0]['sponsor_count'],
                                       'staff_dedication_status' => '0');
                         $this->db->where('id', $staff_id);
                         $result=$this->db->update('staff_master', $data);


                         
                    }    

                if ($result) {
                 $res=$this->db->select("missionary_emp_id, sponsor_id")
                        ->where('id', $staff_id)
                        ->get('allot_missionary');

                   // var_dump($res); die();

                 if($res->num_rows()>0) {

                    foreach($res->result_array() as $key=>$value) {

                        //var_dump($value); die();

                            $data = array('sponsor_allot_mission_status' => '4');
                            $this->db->where('id', $value['sponsor_id']);
                            $result1=$this->db->update('sponsor_master', $data);

                         $this->db->query("insert into ".$this->db->dbprefix('withdrawl_missionary')." (
                                        missionary_id,
                                        sponsor_id,
                                        reason,
                                        created_at,
                                        created_by,
                                        admin_approve
                                            ) values (
                                                '".$value['missionary_emp_id']."',
                                                '".$value['sponsor_id']."',
                                                '".$model->reasonwithdrawl."',
                                                NOW(),
                                                '1',
                                                '0'
                                                )");

                         

                                if($this->db->insert_id()){
                                    $response['result']=array('id'=>$this->db->insert_id());
                                    $response['message']="withdrawl missionary record stored successfully";
                                }else{
                                    $response['status']="failure";            
                                    $response['message']="Sorry!!, Unable to insert the withdrawl Missionary data";
                                }
                        }

                    }
                }
                else
                {
                    $response['status']="failure";
                    $response['message']="Missionary withdrawl status has not been updated fully";
                }

            }

        } else {
            $response['status']="failure";
            $response['message']="Choose missionary and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


     public function gems_insert_withdrawl_child() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        $staff_ids = $model->selectedstaff;

        

        if (is_array($staff_ids) && count($staff_ids)>0) {
            
            $success_count = 0;
            foreach ($staff_ids as $staff_id) {


                $data = array('withdrawl_status' => 'W');
                $this->db->where('missionary_emp_id', $staff_id);
                $result=$this->db->update('allot_child', $data);

                if ($result) {
                 $res=$this->db->select("missionary_emp_id, sponsor_id")
                        ->where('missionary_emp_id', $staff_id)
                        ->get('allot_child');

                   // var_dump($res); die();

                 if($res->num_rows()>0) {

                    foreach($res->result_array() as $key=>$value) {

                        //var_dump($value); die();

                         $this->db->query("insert into ".$this->db->dbprefix('withdrawl_child')." (
                                        missionary_id,
                                        sponsor_id,
                                        reason,
                                        created_at,
                                        created_by,
                                        admin_approve
                                            ) values (
                                                '".$value['missionary_emp_id']."',
                                                '".$value['sponsor_id']."',
                                                '".$model->reasonwithdrawl."',
                                                NOW(),
                                                '1',
                                                '0'
                                                )");

                                if($this->db->insert_id()){
                                    $response['result']=array('id'=>$this->db->insert_id());
                                    $response['message']="withdrawl missionary record stored successfully";
                                }else{
                                    $response['status']="failure";            
                                    $response['message']="Sorry!!, Unable to insert the withdrawl Missionary data";
                                }
                        }

                    }
                }
                else
                {
                    $response['status']="failure";
                    $response['message']="Missionary withdrawl status has not been updated fully";
                }

            }

        } else {
            $response['status']="failure";
            $response['message']="Choose missionary and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


     public function gems_approve_withdrawl_sponsorship() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        $staff_ids = $model->selectedstaff;

       

        if (is_array($staff_ids) && count($staff_ids)>0) {
            
            $success_count = 0;
            foreach ($staff_ids as $staff_id) {

                //$to_list = array('welfare@gemsbihar.org', 'srd@gemsbihar.org', 'finance@gemsbihar.org');
                $to_list = array('gems@gemsbihar.org');

                $data = array('admin_approve' => '1', 'admin_approve_date' =>date('Y-m-d H:i:s'), 'admin_approve_by' => '1');
                $this->db->where('id', $staff_id);
                $result=$this->db->update('withdrawl_missionary', $data);


                    $withdrawl_det_get=$this->db->select("missionary_id, sponsor_id")
                        ->where('withdrawl_missionary.id', $staff_id)
                        ->get('withdrawl_missionary');  

                    $withdrawl_det= $withdrawl_det_get->result_array();

                     //print_r($withdrawl_det);die();

                    if($withdrawl_det_get->num_rows()>0)
                    {
                        
                        $staff_det_get=$this->db->select("id,staff_name, present_email, zone_id,sponsor_count")
                            ->where('staff_master.staff_employee_id', $withdrawl_det[0]['missionary_id'])
                            ->get('staff_master');  

                        $staff_det= $staff_det_get->result_array();
                        //print_r($staff_det);die();

                        $zone_det_get=$this->db->select("staff_zone_name, email_id")
                            ->where('zones_staff_master.id', $staff_det[0]['zone_id'])
                            ->get('zones_staff_master');  

                        $zone_det= $zone_det_get->result_array();

                       // var_dump($zone_det); die();

                        $data_up = array('sponsor_count' => $staff_det[0]['sponsor_count']-1);
                        $this->db->where('id', $staff_det[0]['id']);
                        $result_up=$this->db->update('staff_master', $data_up);


                        $sponsorship_det_get=$this->db->select("sponsor_group_id")
                            ->where('sponsorship_master.id', $withdrawl_det[0]['sponsor_id'])
                            ->get('sponsorship_master');  

                        $sponsorship_det= $sponsorship_det_get->result_array();

                        if($sponsorship_det_get->num_rows()>0)
                        {
                            $sponsor_det_get=$this->db->select("sponser_email")
                                ->where('sponsor_master.id', $sponsorship_det[0]['sponsor_group_id'])
                                ->get('sponsor_master');  

                                $sponsor_det= $sponsor_det_get->result_array();

                                    if($sponsor_det_get->num_rows()>0)
                                    {
                                        $sponsor_emails = explode(",", $sponsor_det[0]['sponser_email']);

                                            if(count($sponsor_emails)>1)
                                            {
                                                foreach ($sponsor_emails as $key => $email) {
                                                    array_push($to_list, $email);
                                                }
                                            }
                                            else
                                            {
                                                array_push($to_list, $sponsor_det[0]['sponser_email']);
                                            }

                                            array_push($to_list, $staff_det[0]['present_email']);
                                            
                                            //var_dump($to_list); die();


                                            if($to_list)
                                            {
                                                $message_info="Dear in Christ, <br> 

                                                                Greetings from GEMS family! <br>
                                                                <br>
                                                                Thank you so much for being a strong supporter of GEMS ministry and an active partner in financially supporting the work of God by sponsoring a missionary. <br>

                                                                With reference to your request to withdraw your sponsorship commitment to sponsor a missionary, we hereby inform you that the following missionary has been withdrawn from your sponsorship allotment.

                                                                <b>" .$staff_det[0]['staff_name']. " </b> of <b>" .$zone_det[0]['staff_zone_name']. " </b>

                                                                We greatly appreciate your sacrificial support till now. We also pray that God will continue to enable you to support the ministry of GEMS and other ministries of God. May God bless you abundantly for all your help and support for GEMS ministries. We are open for any suggestions for improvement, and in the future also feel free to contact us so that we can partner together in any way possible.";
                                            }


                                            //var_dump($message_info); die();
                                            $this->load->library('email');
                                            //$this->email->from('sridhar.muthusamy@aesasp.com');
                                            $this->email->from('hr@gemsbihar.org');
                                            $this->email->to($to_list);
                                            $this->email->subject('Withdrawal Information');
                                            $this->email->message($message_info);
                                            try{
                                            $this->email->send();

                                            //var_dump($this->email->send()); die();
                                            //echo 'Message has been sent.';

                                            $response['message']="Staff transfer record has been updated successfully";


                                            }catch(Exception $e){
                                            //echo $e->getMessage();
                                            }
                                    }
                            
                        }
                        
                    }


                if ($result) {
                    $response['message']="withdrawl Approved status has been updated successfully";
                }
                else
                {
                     $response['status']="failure";
                $response['message']="withdrawl Approved status has not been updated fully";
                }
            }

        } else {
            $response['status']="failure";
            $response['message']="Choose missionary and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


    public function gems_preview_mail_approve_withdrawl_sponsorship() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        $staff_id = $model->staff_id;

        

        if ($staff_id) {
            
            $success_count = 0;

                //$to_list = array('welfare@gemsbihar.org', 'srd@gemsbihar.org', 'finance@gemsbihar.org');
                $to_list = array('gems@gemsbihar.org');

                // $data = array('admin_approve' => '1', 'admin_approve_date' =>date('Y-m-d H:i:s'), 'admin_approve_by' => '1');
                // $this->db->where('id', $staff_id);
                // $result=$this->db->update('withdrawl_missionary', $data);


                    $withdrawl_det_get=$this->db->select("missionary_id, sponsor_id")
                        ->where('withdrawl_missionary.id', $staff_id)
                        ->get('withdrawl_missionary');  

                    $withdrawl_det= $withdrawl_det_get->result_array();

                    if($withdrawl_det_get->num_rows()>0)
                    {
                        
                        $staff_det_get=$this->db->select("staff_name, present_email, zone_id")
                            ->where('staff_master.staff_employee_id', $withdrawl_det[0]['missionary_id'])
                            ->get('staff_master');  

                        $staff_det= $staff_det_get->result_array();

                        $zone_det_get=$this->db->select("staff_zone_name, email_id")
                            ->where('zones_staff_master.id', $staff_det[0]['zone_id'])
                            ->get('zones_staff_master');  

                        $zone_det= $zone_det_get->result_array();

                        //var_dump($zone_det); die();


                        $sponsorship_det_get=$this->db->select("sponsor_group_id")
                            ->where('sponsorship_master.id', $withdrawl_det[0]['sponsor_id'])
                            ->get('sponsorship_master');  

                        $sponsorship_det= $sponsorship_det_get->result_array();

                        if($sponsorship_det_get->num_rows()>0)
                        {
                            $sponsor_det_get=$this->db->select("sponser_email")
                                ->where('sponsor_master.id', $sponsorship_det[0]['sponsor_group_id'])
                                ->get('sponsor_master');  

                                $sponsor_det= $sponsor_det_get->result_array();

                                    if($sponsor_det_get->num_rows()>0)
                                    {
                                        $sponsor_emails = explode(",", $sponsor_det[0]['sponser_email']);

                                            if(count($sponsor_emails)>1)
                                            {
                                                foreach ($sponsor_emails as $key => $email) {
                                                    array_push($to_list, $email);
                                                }
                                            }
                                            else
                                            {
                                                array_push($to_list, $sponsor_det[0]['sponser_email']);
                                            }

                                            array_push($to_list, $staff_det[0]['present_email']);
                                            
                                            //var_dump($to_list); die();


                                            if($to_list)
                                            {
                                                $message_info="Dear in Christ, <br> 
                                                                Greetings from GEMS family! <br>
                                                                Thank you so much for being a strong supporter of GEMS ministry and an active partner in financially supporting the work of God by sponsoring a missionary. <br>
                                                                With reference to your request to withdraw your sponsorship commitment to sponsor a missionary, we hereby inform you that the following missionary has been withdrawn from your sponsorship allotment.
                                                                <b>" .$staff_det[0]['staff_name']. " </b> of <b>" .$zone_det[0]['staff_zone_name']. " </b>
                                                                We greatly appreciate your sacrificial support till now. We also pray that God will continue to enable you to support the ministry of GEMS and other ministries of God. May God bless you abundantly for all your help and support for GEMS ministries. We are open for any suggestions for improvement, and in the future also feel free to contact us so that we can partner together in any way possible.";

                                                   $response['result']=$message_info;              
                                            }


                                            //var_dump($message_info); die();
                                            // $this->load->library('email');
                                            // //$this->email->from('sridhar.muthusamy@aesasp.com');
                                            // $this->email->from('hr@gemsbihar.org');
                                            // $this->email->to($to_list);
                                            // $this->email->subject('Withdrawal Information');
                                            // $this->email->message($message_info);
                                            // try{
                                            // $this->email->send();

                                            //var_dump($this->email->send()); die();
                                            //echo 'Message has been sent.';

                                            $response['message']="Staff transfer record has been updated successfully";


                                            // }catch(Exception $e){
                                            // //echo $e->getMessage();
                                            // }
                                    }
                            
                        }
                        
                    }
            

        } else {
            $response['status']="failure";
            $response['message']="Choose missionary and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }




    public function gems_approve_resent_withdrawl_sponsorship() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        $staff_ids = $model->selectedstaff;

        

        if ($staff_ids && count($staff_ids)>0) {
            
            $success_count = 0;

                //$to_list = array('welfare@gemsbihar.org', 'srd@gemsbihar.org', 'finance@gemsbihar.org');
                $to_list = array('gems@gemsbihar.org');

                $data = array('admin_approve' => '1', 'admin_approve_date' =>date('Y-m-d H:i:s'), 'admin_approve_by' => '1');
                $this->db->where('id', $staff_ids);
                $result=$this->db->update('withdrawl_missionary', $data);


                    $withdrawl_det_get=$this->db->select("missionary_id, sponsor_id")
                        ->where('withdrawl_missionary.id', $staff_ids)
                        ->get('withdrawl_missionary');  

                    $withdrawl_det= $withdrawl_det_get->result_array();

                    if($withdrawl_det_get->num_rows()>0)
                    {
                        
                        $staff_det_get=$this->db->select("staff_name, present_email, zone_id")
                            ->where('staff_master.staff_employee_id', $withdrawl_det[0]['missionary_id'])
                            ->get('staff_master');  

                        $staff_det= $staff_det_get->result_array();

                        $zone_det_get=$this->db->select("staff_zone_name, email_id")
                            ->where('zones_staff_master.id', $staff_det[0]['zone_id'])
                            ->get('zones_staff_master');  

                        $zone_det= $zone_det_get->result_array();

                       // var_dump($zone_det); die();


                        $sponsorship_det_get=$this->db->select("sponsor_group_id")
                            ->where('sponsorship_master.id', $withdrawl_det[0]['sponsor_id'])
                            ->get('sponsorship_master');  

                        $sponsorship_det= $sponsorship_det_get->result_array();

                        if($sponsorship_det_get->num_rows()>0)
                        {
                            $sponsor_det_get=$this->db->select("sponser_email")
                                ->where('sponsor_master.id', $sponsorship_det[0]['sponsor_group_id'])
                                ->get('sponsor_master');  

                                $sponsor_det= $sponsor_det_get->result_array();

                                    if($sponsor_det_get->num_rows()>0)
                                    {
                                        $sponsor_emails = explode(",", $sponsor_det[0]['sponser_email']);

                                            if(count($sponsor_emails)>1)
                                            {
                                                foreach ($sponsor_emails as $key => $email) {
                                                    array_push($to_list, $email);
                                                }
                                            }
                                            else
                                            {
                                                array_push($to_list, $sponsor_det[0]['sponser_email']);
                                            }

                                            array_push($to_list, $staff_det[0]['present_email']);
                                            
                                            //var_dump($to_list); die();


                                            if($to_list)
                                            {
                                                $message_info="Dear in Christ, <br> 

                                                                Greetings from GEMS family! <br>
                                                                <br>
                                                                Thank you so much for being a strong supporter of GEMS ministry and an active partner in financially supporting the work of God by sponsoring a missionary. <br>

                                                                With reference to your request to withdraw your sponsorship commitment to sponsor a missionary, we hereby inform you that the following missionary has been withdrawn from your sponsorship allotment.

                                                                <b>" .$staff_det[0]['staff_name']. " </b> of <b>" .$zone_det[0]['staff_zone_name']. " </b>

                                                                We greatly appreciate your sacrificial support till now. We also pray that God will continue to enable you to support the ministry of GEMS and other ministries of God. May God bless you abundantly for all your help and support for GEMS ministries. We are open for any suggestions for improvement, and in the future also feel free to contact us so that we can partner together in any way possible.";
                                            }


                                            //var_dump($message_info); die();
                                            $this->load->library('email');
                                            //$this->email->from('sridhar.muthusamy@aesasp.com');
                                            $this->email->from('hr@gemsbihar.org');
                                            $this->email->to($to_list);
                                            $this->email->subject('Withdrawal Information');
                                            $this->email->message($message_info);
                                            try{
                                            $this->email->send();

                                            //var_dump($this->email->send()); die();
                                            //echo 'Message has been sent.';

                                            $response['message']="Staff transfer record has been updated successfully";


                                            }catch(Exception $e){
                                            //echo $e->getMessage();
                                            }
                                    }
                            
                        }
                        
                    }


                if ($result) {
                    $response['message']="withdrawl Approved status has been updated successfully";
                }
                else
                {
                     $response['status']="failure";
                $response['message']="withdrawl Approved status has not been updated fully";
                }

        } else {
            $response['status']="failure";
            $response['message']="Choose missionary and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


    public function gems_approve_withdrawl_child_sponsorship() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        $staff_ids = $model->selectedstaff;

        

        if (is_array($staff_ids) && count($staff_ids)>0) {
            
            $success_count = 0;
            foreach ($staff_ids as $staff_id) {


                $data = array('admin_approve' => '1', 'admin_approve_date' =>date('Y-m-d H:i:s'), 'admin_approve_by' => '1');
                $this->db->where('missionary_id', $staff_id);
                $result=$this->db->update('withdrawl_child', $data);


                if ($result) {
                    $response['message']="withdrawl Approved status has been updated successfully";
                }
                else
                {
                     $response['status']="failure";
                $response['message']="withdrawl Approved status has not been updated fully";
                }
            }

        } else {
            $response['status']="failure";
            $response['message']="Choose missionary and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    public function gems_revoke_withdrawl_sponsorship() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        $staff_ids = $model->selectedstaff;

        

        if (is_array($staff_ids) && count($staff_ids)>0) {
            
            $success_count = 0;
            foreach ($staff_ids as $staff_id) {

                 $res=$this->db->select("missionary_id, sponsor_id")
                        ->where('id', $staff_id)
                        ->get('withdrawl_missionary');

                   // var_dump($res); die();

                 if($res->num_rows()>0) {

                    foreach($res->result_array() as $key=>$value) {

                        $data = array('withdrawl_status' => 'N');
                        $this->db->where('missionary_emp_id', $value['missionary_id']);
                        $this->db->where('sponsor_id', $value['sponsor_id']);
                        $result=$this->db->update('allot_missionary', $data);

                        //var_dump($value); die();

                         $this->db->query("delete from ".$this->db->dbprefix('withdrawl_missionary')."  where id='".$staff_id."'");
                         $response['status']="success";
                         $response['message']="Withdrawl missionary record has been deleted successfully";
                        

                        }

                    }

            }

        } else {
            $response['status']="failure";
            $response['message']="Choose missionary and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


    public function gems_revoke_withdrawl_child_sponsorship() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        $staff_ids = $model->selectedstaff;

        

        if (is_array($staff_ids) && count($staff_ids)>0) {
            
            $success_count = 0;
            foreach ($staff_ids as $staff_id) {

                 $res=$this->db->select("missionary_id, sponsor_id")
                        ->where('missionary_id', $staff_id)
                        ->get('withdrawl_child');

                   // var_dump($res); die();

                 if($res->num_rows()>0) {

                    foreach($res->result_array() as $key=>$value) {

                        $data = array('withdrawl_status' => 'N');
                        $this->db->where('missionary_emp_id', $value['missionary_id']);
                        $this->db->where('sponsor_id', $value['sponsor_id']);
                        $result=$this->db->update('allot_child', $data);

                        //var_dump($value); die();

                         $this->db->query("delete from ".$this->db->dbprefix('withdrawl_child')."  where missionary_id='".$staff_id."'");
                         $response['status']="success";
                         $response['message']="Withdrawl missionary record has been deleted successfully";
                        

                        }

                    }

            }

        } else {
            $response['status']="failure";
            $response['message']="Choose missionary and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    public function gems_fetch_sponsorship_master($id)
    {
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $res=$this->db->query("select * from ".$this->db->dbprefix('sponsorship_master')." where id ='".$id."'");
        if($res->num_rows()>0){
            $in_array=$res->result_array();
            $result=$in_array[0];
        }else{
            $response['status']="failure";
            $response['message']=" No Region record found!!";
        }
        $response['result']=$result;
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }


    public function gems_delete_sponsorship_master($id)
    {
    
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        
        if($id){

            $res_chk=$this->db->query("select id from ".$this->db->dbprefix('sponsorship_master')." where id='".$id."'");

            
            if($res_chk->num_rows()==0){
                    $response['status']="failure";            
                    $response['message']="Sorry!!, No sponsership valid";
            }else{

                $this->db->set('is_deleted','1');
                $this->db->where('id',$id);
                $this->db->update($this->db->dbprefix('sponsorship_master'));
                $response['message']="Sponsorship record has been Deleted successfully";
            }   
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";    
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    } 

    public function gems_fetch_sponsorship_master_view($sponsor_id){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        if($sponsor_id!=""){

           $res_chk=$this->db->select('sponsorship_master.*,sponsor_master.sponser_name')
               ->join('sponsor_master', 'sponsorship_master.sponsor_group_id=sponsor_master.id', 'inner')
                ->where('sponsorship_master.id', $sponsor_id)
                ->get('sponsorship_master');

                //var_dump($res_chk->row()); die();




            
            if($res_chk->num_rows()>0){
                global $categorysponsor, $languages, $missionaryallotstatus;
            
                $temp_arr = array();
                foreach ($res_chk->row() as $key => $value) {
                    if ($key=="category_sponsorship") {
                        $temp_arr[$key]=isset($categorysponsor[$value])?$categorysponsor[$value]:'-';
                    } else if ($key=="sponser_preference_language") {
                        $temp_arr[$key]=isset($languages[$value])?$languages[$value]:'-';
                    } else if ($key=="sponsor_allot_mission_status") {
                        $temp_arr[$key]=isset($missionaryallotstatus[$value])?$missionaryallotstatus[$value]:'-';
                    } else {
                        $temp_arr[$key]=$value;
                    }
                }

                $response['result']=$temp_arr;
            }else{
                $response['status']="failure";
                $response['message']="Invalid Staff Id!!..";
            }
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";
        }
        
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }   




    public function gems_fetch_church_master_view($church_id){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        if($church_id!=""){

           $res_chk=$this->db->select('church_master.*,zones_staff_master.staff_zone_name as staff_zone_id, staff_master.staff_name as staff_id, staff_master.staff_employee_id as employee_id, village_master.village_name as village_town, panchayat.panchayat as panchayat,  post_office.post_office_name as post_office, district.district_name as district')
               ->join('zones_staff_master', 'church_master.staff_zone_id=zones_staff_master.id', 'inner')
               ->join('staff_master', 'church_master.staff_id=staff_master.id', 'inner')
               ->join('village_master', 'church_master.village_town=village_master.id', 'inner')
               ->join('panchayat', 'church_master.panchayat=panchayat.id', 'inner')
               // ->join('block', 'church_master.block=block.id', 'inner')
               ->join('post_office', 'church_master.post_office=post_office.id', 'inner')
               ->join('district', 'church_master.district=district.id', 'inner')
                ->where('church_master.id', $church_id)
                ->get('church_master');

                //var_dump($res_chk->row()); die();




            
            if($res_chk->num_rows()>0){

                $result = $res_chk->row();
                // global $categorysponsor, $languages, $missionaryallotstatus;
            
                // $temp_arr = array();
                // foreach ($res_chk->row() as $key => $value) {
                //     if ($key=="category_sponsorship") {
                //         $temp_arr[$key]=isset($categorysponsor[$value])?$categorysponsor[$value]:'-';
                //     } else if ($key=="sponser_preference_language") {
                //         $temp_arr[$key]=isset($languages[$value])?$languages[$value]:'-';
                //     } else if ($key=="sponsor_allot_mission_status") {
                //         $temp_arr[$key]=isset($missionaryallotstatus[$value])?$missionaryallotstatus[$value]:'-';
                //     } else {
                //         $temp_arr[$key]=$value;
                //     }
                // }

                $response['result']=$result;
            }else{
                $response['status']="failure";
                $response['message']="Invalid Staff Id!!..";
            }
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";
        }
        
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }  



    public function gems_fetch_staff_alloted_list($missionary_emp_id){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $result_view = array();
        $spouse_name = array();

        global $missionaryallotstatus;

        if($missionary_emp_id!=""){


            $res_chk=$this->db->select('sponsor_id')
                ->where('allot_missionary.missionary_emp_id', $missionary_emp_id)
                ->get('allot_missionary');


            if($res_chk->num_rows()>0){

                foreach ($res_chk->result_array() as $key => $value) {
                   

                   $sponsorship_result=$this->db->select('sponsor_group_id')
                    ->where('sponsorship_master.id', $value['sponsor_id'])
                    ->get('sponsorship_master');


                    $sponsorship_data= $sponsorship_result->result_array();

                    if($sponsorship_result->num_rows()>0)
                    {
                        $sponsor_result=$this->db->select('sponsor_master.*')
                        ->where('sponsor_master.id', $sponsorship_data[0]['sponsor_group_id'])
                        ->get('sponsor_master');


                        $sponsor_data= $sponsor_result->result_array();

                        foreach ($sponsor_result->result_array() as $key => $value) {

                           // var_dump($value['sponsor_allot_mission_status']); die();


                            if(isset($value['sponsor_allot_mission_status']))
                            {
                                $value['sponsor_allot_mission_status'] = $missionaryallotstatus[$value['sponsor_allot_mission_status']];
                            }

                            

                          //  var_dump($value); die();

                            array_push($result_view, $value);
                        }
                    }

                   
                }

                            $spouse_staff=$this->db->select('staff_master.id, staff_name, staff_cross_ref_number, staff_employee_id')
                            ->where('staff_master.staff_employee_id', $missionary_emp_id)
                            ->get('staff_master');

                            $spouse_staff= $spouse_staff->result_array();

                            //var_dump($spouse_staff); die();


                            if(isset($spouse_staff[0]['staff_cross_ref_number']))
                            {
                                $spouse_staff_name=$this->db->select('staff_master.id, staff_name as spouse_name, staff_cross_ref_number, staff_employee_id')
                                ->where('staff_master.staff_cross_ref_number', $spouse_staff[0]['staff_cross_ref_number'])
                                ->where('staff_master.id!=', $spouse_staff[0]['id'])
                                ->get('staff_master');

                                $spouse_staff_name= $spouse_staff_name->result_array();
                            }

                            //var_dump($spouse_staff_name); die();


                            if(isset($spouse_staff_name[0]['staff_employee_id']))
                            {



                                $spouse_res_chk=$this->db->select('sponsor_id')
                                ->where('allot_missionary.missionary_emp_id', $spouse_staff_name[0]['staff_employee_id'])
                                ->get('allot_missionary');

                                //var_dump($spouse_res_chk->result_array()); die();



                                if($spouse_res_chk->num_rows()>0){

                                    foreach ($spouse_res_chk->result_array() as $key => $spouse) {
                                       

                                       $sponsorship_result=$this->db->select('sponsor_group_id')
                                        ->where('sponsorship_master.id', $spouse['sponsor_id'])
                                        ->get('sponsorship_master');

                                        $sponsorship_data= $sponsorship_result->result_array();

                                        if($sponsorship_result->num_rows()>0)
                                        {
                                            $sponsor_result=$this->db->select('sponsor_master.*')
                                            ->where('sponsor_master.id', $sponsorship_data[0]['sponsor_group_id'])
                                            ->get('sponsor_master');


                                            $sponsor_data= $sponsor_result->result_array();

                                                foreach ($sponsor_result->result_array() as $key => $value) {

                                                   // var_dump($value['sponsor_allot_mission_status']); die();


                                                    if(isset($value['sponsor_allot_mission_status']))
                                                    {
                                                        $value['sponsor_allot_mission_status'] = $missionaryallotstatus[$value['sponsor_allot_mission_status']];
                                                    }

                                                    

                                                  //  var_dump($value); die();

                                                    array_push($spouse_name, $value);
                                                }
                                                
                                        }
                                    }
                                }

                            }
                        
                    

              //  var_dump($result_view); die();
                $response['result']=$result_view;
                $response['spouse_name']=$spouse_name;

            }
            else{
                $response['status']="failure";
                $response['message']="Invalid Staff Id!!..";
            }
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";
        }
        
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }  




     public function gems_fetch_sponsor_master_view($sponsor_id){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        if($sponsor_id!=""){

           $res_chk=$this->db->select("sponsor_master.id, sponser_name, promotional_office_master.promo_office_name,sponser_address, country.country_name, sponser_phone, sponser_city_town_place, sponsor_district, state_zone_master.state_zone_name, sponser_email, sponser_city_town_place, sponser_pin, DATE_FORMAT(sponser_sadmin_approve_date,'%d/%m/%Y')as sponser_sadmin_approve_date, sponsor_allot_mission_status")
                            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left')
                            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
                            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
                            ->order_by('sponsor_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsor_master.id', $sponsor_id)
                            ->get('sponsor_master');

                //var_dump($res_chk->row()); die();
            
            if($res_chk->num_rows()>0){
                global $gender, $languages, $missionaryallotstatus;
            
                $temp_arr = array();
                foreach ($res_chk->row() as $key => $value) {
                    if ($key=="sponsor_allot_mission_status") {
                        $temp_arr[$key]=isset($missionaryallotstatus[$value])?$missionaryallotstatus[$value]:'-';
                    }
                    else
                    {
                        $temp_arr[$key]=$value;
                    }
                }

                $response['result']=$temp_arr;
            }else{
                $response['status']="failure";
                $response['message']="Invalid Staff Id!!..";
            }
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";
        }
        
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }    



    public function get_allot_missionary_master_list(){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $result=array();
        $html="";
           global $api_path;
        
        $res=$this->db->select("sponsorship_master.id, sponsor_group_id, sponser_amount, category_sponsorship, DATE_FORMAT(created_at,'%d/%m/%Y')as created_at, sponser_missionary_preference, sponsor_allot_mission_status")
            ->order_by('sponsorship_master.id', 'desc')
            ->where('is_deleted', '0')
            ->where('sponsor_allot_mission_status', '4')
            ->where('category_sponsorship', '1')
            ->where('sadmin_approve_date!=', 'NULL')
            ->get('sponsorship_master');

         
        
        if($res->num_rows()>0){

            global $missionaryallotstatus, $api_path;

            foreach($res->result_array() as $key=>$value1){


               // $res_chk=$this->db->query("select * from ".$this->db->dbprefix('sponsor_master')." where id='".$value1['sponsor_group_id']."'");
                $res_chk=$this->db->select("sponsor_master.id, sponser_name, promotional_office_master.promo_office_name, sponser_country_id, sponser_promo_office, country.country_name, sponser_phone, sponsor_district, state_zone_master.state_zone_name, sponser_city_town_place, sponser_pin, DATE_FORMAT(sponser_sadmin_approve_date,'%d/%m/%Y')as sponser_sadmin_approve_date, sponser_missionary_preference, sponsor_allot_mission_status")
                            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left')
                            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
                            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
                            ->order_by('sponsor_master.id', 'desc')
                            ->where('is_deleted', '0')
                            // ->where('sponsor_allot_mission_status', '4')
                            ->where('sponser_sadmin_approve_date!=', 'NULL')
                            ->where('sponsor_master.id', $value1['sponsor_group_id'])
                            ->get('sponsor_master');
                
                  //  var_dump($res_chk->result_array()); die();
                if($res_chk->num_rows()>0){

                    foreach($res_chk->result_array() as $key=>$value){


                         //var_dump($value); die();
                        $html='

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewsponsorship/'.$value['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/allotmissionsponsor/'.$value1['id'].'"><i class="fa fa-check" aria-hidden="true"></i></a>';

                                $result[]=array('id'=>$value1['id'],'sponser_amount'=>$value1['sponser_amount'],'sponser_name'=>$value['sponser_name'],'sponser_promo_office'=>$value['promo_office_name'],'sponser_country_id'=>$value['country_name'],'sponser_phone'=>$value['sponser_phone'],'sponsor_district'=>$value['sponsor_district'],'sponser_state'=>$value['state_zone_name'],'sponser_city_town_place'=>$value['sponser_city_town_place'],'sponser_pin'=>$value['sponser_pin'],
                                    'created_at'=>$value1['created_at'],
                                    'sponser_sadmin_approve_date'=>$value['sponser_sadmin_approve_date'],'
                                    sponsor_allot_mission_status'=>$missionaryallotstatus[$value1['sponsor_allot_mission_status']],'action'=>$html);

                     }   


                 }   

                
            
            }
        }else{
            $response['status']="failure";
            $response['message']="No staff list found!!..";
        }
        
        $response['result']=$result;
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    public function get_allotchild_master_list(){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $result=array();
        $html="";
           global $api_path;
        
        $res=$this->db->select("sponsorship_master.id, sponsor_group_id, sponser_amount, category_sponsorship, DATE_FORMAT(created_at,'%d/%m/%Y')as created_at, sponser_missionary_preference, sponsor_allot_mission_status")
            ->order_by('sponsorship_master.id', 'desc')
            ->where('is_deleted', '0')
            ->where('sponsor_allot_mission_status', '4')
            ->where('sadmin_approve_date!=', 'NULL')
            ->where('category_sponsorship', '2')
            ->get('sponsorship_master');


         //var_dump($res->result_array()); die();
        
        if($res->num_rows()>0){

            global $missionaryallotstatus, $api_path;

            foreach($res->result_array() as $key=>$value1){


               // $res_chk=$this->db->query("select * from ".$this->db->dbprefix('sponsor_master')." where id='".$value1['sponsor_group_id']."'");
                $res_chk=$this->db->select("sponsor_master.id, sponser_name, promotional_office_master.promo_office_name, sponser_country_id, sponser_promo_office, country.country_name, sponser_phone, sponsor_district, state_zone_master.state_zone_name, sponser_city_town_place, sponser_pin, DATE_FORMAT(sponser_sadmin_approve_date,'%d/%m/%Y')as sponser_sadmin_approve_date, sponser_missionary_preference, sponsor_allot_mission_status")
                            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left')
                            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
                            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
                            ->order_by('sponsor_master.id', 'desc')
                            ->where('sponser_sadmin_approve_date!=', 'NULL')
                            ->where('is_deleted', '0')
                            ->where('sponsor_master.id', $value1['sponsor_group_id'])
                            ->get('sponsor_master');
                
                    //var_dump($res_chk); die();
                if($res_chk->num_rows()>0){

                    foreach($res_chk->result_array() as $key=>$value){


                         //var_dump($value); die();
                        $html='

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewsponsorship/'.$value['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                <a title="Allot Child" style=" margin-top: 10px;" href="'.$api_path.'/#/allotchild/'.$value1['id'].'"><i class="fa fa-check" aria-hidden="true"></i></a>';

                                $result[]=array('id'=>$value1['id'],'sponser_amount'=>$value1['sponser_amount'],'sponser_name'=>$value['sponser_name'],'sponser_promo_office'=>$value['promo_office_name'],'sponser_country_id'=>$value['country_name'],'sponser_phone'=>$value['sponser_phone'],'sponsor_district'=>$value['sponsor_district'],'sponser_state'=>$value['state_zone_name'],'sponser_city_town_place'=>$value['sponser_city_town_place'],'sponser_pin'=>$value['sponser_pin'],'sponser_sadmin_approve_date'=>$value['sponser_sadmin_approve_date'],'sponsor_allot_mission_status'=>$missionaryallotstatus[$value1['sponsor_allot_mission_status']],'action'=>$html);

                     }   


                 }   

                
            
            }
        }else{
            $response['status']="failure";
            $response['message']="No staff list found!!..";
        }
        
        $response['result']=$result;
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

     public function get_mkd_allot_child_master_list(){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $result=array();
        $html="";
           global $api_path;
        
        $res=$this->db->select("sponsorship_master.id, sponsor_group_id, sponser_amount, category_sponsorship, DATE_FORMAT(created_at,'%d/%m/%Y')as created_at, sponser_missionary_preference, sponsor_allot_mission_status")
            ->order_by('sponsorship_master.id', 'desc')
            ->where('is_deleted', '0')
            ->where('sponsor_allot_mission_status', '4')
            ->where('category_sponsorship', '2')
            ->get('sponsorship_master');

         
        
        if($res->num_rows()>0){

            global $missionaryallotstatus, $api_path;

            foreach($res->result_array() as $key=>$value1){


               // $res_chk=$this->db->query("select * from ".$this->db->dbprefix('sponsor_master')." where id='".$value1['sponsor_group_id']."'");
                $res_chk=$this->db->select("sponsor_master.id, sponser_name, promotional_office_master.promo_office_name, sponser_country_id, sponser_promo_office, country.country_name, sponser_phone, sponsor_district, state_zone_master.state_zone_name, sponser_city_town_place, sponser_pin, DATE_FORMAT(sponser_sadmin_approve_date,'%d/%m/%Y')as sponser_sadmin_approve_date, sponser_missionary_preference, sponsor_allot_mission_status")
                            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left')
                            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
                            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
                            ->order_by('sponsor_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsor_master.id', $value1['sponsor_group_id'])
                            ->get('sponsor_master');
                
                   // var_dump($res_chk); die();
                if($res_chk->num_rows()>0){

                    foreach($res_chk->result_array() as $key=>$value){


                         //var_dump($value); die();
                        $html='

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewsponsorship/'.$value['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/allotmissionsponsor/'.$value1['id'].'"><i class="fa fa-check" aria-hidden="true"></i></a>';

                                $result[]=array('id'=>$value1['id'],'sponser_amount'=>$value1['sponser_amount'],'sponser_name'=>$value['sponser_name'],'sponser_promo_office'=>$value['promo_office_name'],'sponser_country_id'=>$value['country_name'],'sponser_phone'=>$value['sponser_phone'],'sponsor_district'=>$value['sponsor_district'],'sponser_state'=>$value['state_zone_name'],'sponser_city_town_place'=>$value['sponser_city_town_place'],'sponser_pin'=>$value['sponser_pin'],'sponser_sadmin_approve_date'=>$value['sponser_sadmin_approve_date'],'sponsor_allot_mission_status'=>$missionaryallotstatus[$value1['sponsor_allot_mission_status']],'action'=>$html);

                     }   


                 }   

                
            
            }
        }else{
            $response['status']="failure";
            $response['message']="No staff list found!!..";
        }
        
        $response['result']=$result;
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

     public function get_allot_missionary_approve_list(){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $result=array();
        $html="";
           global $api_path;
        

          $res=$this->db->select("allot_missionary.id, missionary_emp_id, sponsor_id, sponsor_amount, allotment_reallotment, withdrawl_status, sadmin_allot_approve, admin_allot_approve_date, family_sponsor, admin_allot_approved_by, missionary_withdrawal")
            ->order_by('allot_missionary.id', 'desc')
            ->where('allotment_reallotment', 'A')
            ->where('sadmin_allot_approve', '0')
            ->get('allot_missionary');  

         //    echo "<pre>";
         // var_dump($res->result_array()); die();
        
        if($res->num_rows()>0){

            global $missionaryallotstatus, $api_path;

            foreach($res->result_array() as $staff_key=>$value1){

                 $res_chk=$this->db->select("sponsorship_master.id, sponsor_group_id, category_sponsorship, sponser_amount")
                            ->order_by('sponsorship_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsorship_master.id', $value1['sponsor_id'])
                            ->get('sponsorship_master');  

                  $staff_res_chk=$this->db->select("staff_master.id, staff_employee_id, staff_name,  staff_cross_ref_number, staff_cross_ref_number, zone_id, zones_staff_master.staff_zone_name, sponsor_count")
                            ->join('zones_staff_master', 'staff_master.zone_id=zones_staff_master.id', 'left')
                            ->where('staff_delete_status', '0')
                            ->where('staff_employee_id', $value1['missionary_emp_id'])
                            ->get('staff_master');          

                $staff_res_chk = $staff_res_chk->result_array();


                


                if(isset($staff_res_chk[0]['staff_cross_ref_number']) && $staff_res_chk[0]['staff_cross_ref_number']!=0)
                {
                    $spouse_detail=$this->db->select("staff_master.*")
                            ->where('staff_delete_status', '0')
                            ->where('staff_cross_ref_number', $staff_res_chk[0]['staff_cross_ref_number'])
                            ->where('staff_master.id!=', $staff_res_chk[0]['staff_cross_ref_number'])
                            ->get('staff_master');

                    $spouse_detail = $spouse_detail->result_array();


                }

                // echo "<pre>";
                // var_dump(isset($spouse_detail));
               
                   

                if($res_chk->num_rows()>0){

                    foreach($res_chk->result_array() as $key=>$sponsorship){


                         //var_dump($value); die();

                         $res_chk_sponsor=$this->db->select("sponsor_master.id, sponser_name, promotional_office_master.promo_office_name, sponser_country_id, sponser_promo_office, country.country_name, sponser_phone, sponsor_district, state_zone_master.state_zone_name, sponser_city_town_place, sponser_pin, DATE_FORMAT(sponser_sadmin_approve_date,'%d/%m/%Y')as sponser_sadmin_approve_date, sponser_missionary_preference, sponsor_allot_mission_status,DATE_FORMAT(created_at,'%d/%m/%Y') as created_at")
                            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left')
                            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
                            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
                            ->order_by('sponsor_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsor_master.id', $sponsorship['sponsor_group_id'])
                            ->get('sponsor_master');

                            if($res_chk_sponsor->num_rows()>0){

                                foreach($res_chk_sponsor->result_array() as $key=>$value){

                                $html='

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewsponsorship/'.$value['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/allotmissionsponsor/'.$value1['id'].'"><i class="fa fa-check" aria-hidden="true"></i></a>';


                                if(isset($spouse_detail[0]['staff_name']) && isset($staff_res_chk[0]['staff_cross_ref_number']))
                                {

                                    $result[]=array('id'=>$value1['id'], 'sponser_id'=>$value1['sponsor_id'], 'sponser_amount'=>$sponsorship['sponser_amount'],'sponser_name'=>$value['sponser_name'],'sponser_promo_office'=>$value['promo_office_name'],'sponser_country_id'=>$value['country_name'],'sponser_phone'=>$value['sponser_phone'],'sponsor_district'=>$value['sponsor_district'],'sponser_state'=>$value['state_zone_name'],'sponser_city_town_place'=>$value['sponser_city_town_place'],'sponser_pin'=>$value['sponser_pin'], 'sponser_sadmin_approve_date'=>$value['sponser_sadmin_approve_date'], 
                                        'created_at'=>$value['created_at'],
                                        'staff_missionary_name'=>$staff_res_chk[0]['staff_name'], 'staffid'=>$staff_res_chk[0]['id'], 'spouse_name'=>$spouse_detail[0]['staff_name'], 'crn_no'=>$staff_res_chk[0]['staff_cross_ref_number'], 'zone_name'=>$staff_res_chk[0]['staff_zone_name'], 'emp_id'=>$staff_res_chk[0]['staff_employee_id'], 'sponsor_count'=>$staff_res_chk[0]['sponsor_count'], 'action'=>$html);

                                    //var_dump($result); die();
                                }
                                else if(isset($staff_res_chk[$key]['id']))
                                {

                                        $result[]=array('id'=>$value1['id'], 'sponser_id'=>$value1['sponsor_id'], 'sponser_amount'=>$sponsorship['sponser_amount'],'sponser_name'=>$value['sponser_name'],'sponser_promo_office'=>$value['promo_office_name'],'sponser_country_id'=>$value['country_name'],'sponser_phone'=>$value['sponser_phone'],'sponsor_district'=>$value['sponsor_district'],'sponser_state'=>$value['state_zone_name'],'sponser_city_town_place'=>$value['sponser_city_town_place'],'sponser_pin'=>$value['sponser_pin'], 'sponser_sadmin_approve_date'=>$value['sponser_sadmin_approve_date'], 
                                            'created_at'=>$value['created_at'],
                                            'staff_missionary_name'=>$staff_res_chk[$key]['staff_name'], 'staffid'=>$staff_res_chk[$key]['id'], 'crn_no'=>$staff_res_chk[$key]['staff_cross_ref_number'], 'zone_name'=>$staff_res_chk[$key]['staff_zone_name'], 'emp_id'=>$staff_res_chk[$key]['staff_employee_id'], 'sponsor_count'=>$staff_res_chk[$key]['sponsor_count'], 'action'=>$html);
                                    
                                }

                                

                               }
                            }    

                     }   


                 }   

                
            
            }
        }else{
            $response['status']="failure";
            $response['message']="No staff list found!!..";
        }
        
        $response['result']=$result;
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


    public function get_allot_child_approve_list(){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $result=array();
        $html="";
           global $api_path;
        

          $res=$this->db->select("allot_child.id, missionary_emp_id, sponsor_id, sponsor_amount, allotment_reallotment, withdrawl_status, sadmin_allot_approve, admin_allot_approve_date, admin_allot_approved_by, missionary_withdrawal")
            ->order_by('allot_child.id', 'desc')
            ->where('allotment_reallotment', 'A')
            ->where('sadmin_allot_approve', '0')
            ->get('allot_child');  

        // var_dump($res); die();
        
        if($res->num_rows()>0){

            global $missionaryallotstatus, $api_path;

            foreach($res->result_array() as $key=>$value1){

                 $res_chk=$this->db->select("sponsorship_master.id, sponsor_group_id, category_sponsorship, sponser_amount")
                            ->order_by('sponsorship_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsorship_master.id', $value1['sponsor_id'])
                            ->get('sponsorship_master');  

                  // $staff_res_chk=$this->db->select("staff_master.id, staff_employee_id, staff_name,  staff_cross_ref_number, zone_id, zones_staff_master.staff_zone_name, sponsor_count")
                  //           ->join('zones_staff_master', 'staff_master.zone_id=zones_staff_master.id', 'left')
                  //           ->where('staff_delete_status', '0')
                  //           ->where('staff_employee_id', $value1['missionary_emp_id'])
                  //           ->get('staff_master');          
                  //   $staff_res_chk = $staff_res_chk->result_array();


                $child_res_chk=$this->db->select("staff_children.id, staff_id, children_name,  cross_ref_no, staff_zone_id, zones_staff_master.staff_zone_name, sponsor_count")
                            ->join('zones_staff_master', 'staff_children.staff_zone_id=zones_staff_master.id', 'left')
                            ->where('staff_children.id', $value1['missionary_emp_id'])
                            ->get('staff_children');          
                $child_res_chk = $child_res_chk->result_array();


                   //var_dump($staff_res_chk->result_array()); die();
                if($res_chk->num_rows()>0){

                    foreach($res_chk->result_array() as $key=>$sponsorship){


                         //var_dump($value); die();

                         $res_chk_sponsor=$this->db->select("sponsor_master.id, sponser_name, promotional_office_master.promo_office_name, sponser_country_id, sponser_promo_office, country.country_name, sponser_phone, sponsor_district, state_zone_master.state_zone_name, sponser_city_town_place, sponser_pin, DATE_FORMAT(sponser_sadmin_approve_date,'%d/%m/%Y')as sponser_sadmin_approve_date, sponser_missionary_preference, sponsor_allot_mission_status")
                            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left')
                            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
                            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
                            ->order_by('sponsor_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsor_master.id', $sponsorship['sponsor_group_id'])
                            ->get('sponsor_master');

                            if($res_chk_sponsor->num_rows()>0){

                                foreach($res_chk_sponsor->result_array() as $key=>$value){

                                $html='

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewsponsorship/'.$value['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/allotmissionsponsor/'.$value1['id'].'"><i class="fa fa-check" aria-hidden="true"></i></a>';

                                if(isset($child_res_chk[$key]['id']))
                                {

                                    $result[]=array('id'=>$value1['id'], 'sponser_id'=>$value1['sponsor_id'], 'sponser_amount'=>$sponsorship['sponser_amount'],'sponser_name'=>$value['sponser_name'],'sponser_promo_office'=>$value['promo_office_name'],'sponser_country_id'=>$value['country_name'],'sponser_phone'=>$value['sponser_phone'],'sponsor_district'=>$value['sponsor_district'],'sponser_state'=>$value['state_zone_name'],'sponser_city_town_place'=>$value['sponser_city_town_place'],'sponser_pin'=>$value['sponser_pin'], 'sponser_sadmin_approve_date'=>$value['sponser_sadmin_approve_date'], 'staff_missionary_name'=>$child_res_chk[$key]['children_name'], 'staffid'=>$child_res_chk[$key]['id'], 'crn_no'=>$child_res_chk[$key]['cross_ref_no'], 'zone_name'=>$child_res_chk[$key]['staff_zone_name'], 'sponsor_count'=>$child_res_chk[$key]['sponsor_count'], 'action'=>$html);
                                }

                               }
                            }    

                     }   


                 }   

                
            
            }
        }else{
            $response['status']="failure";
            $response['message']="No staff list found!!..";
        }
        
        $response['result']=$result;
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


     public function get_withdrawl_list(){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $result=array();
        $html="";
           global $api_path;

           // $res=$this->db->select("withdrawl_missionary.id, missionary_id, sponsor_id, reason, created_by")
           //  ->order_by('withdrawl_missionary.id', 'desc')
           //  ->where('admin_approve', '0')
           //  ->get('withdrawl_missionary');    


            $res=$this->db->select("allot_missionary.id, missionary_emp_id, sponsor_id, sponsor_amount, allotment_reallotment, withdrawl_status, sadmin_allot_approve, admin_allot_approve_date, family_sponsor, admin_allot_approved_by, missionary_withdrawal")
            ->order_by('allot_missionary.id', 'desc')
            ->where('withdrawl_status', 'N')
            ->get('allot_missionary');  
        // var_dump($res); die();
        
        if($res->num_rows()>0){

            global $missionaryallotstatus, $api_path;

            foreach($res->result_array() as $key=>$value1){


                $res_chk=$this->db->select("sponsorship_master.id, sponsor_group_id, category_sponsorship, sponser_amount")
                            ->order_by('sponsorship_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsorship_master.id', $value1['sponsor_id'])
                            ->get('sponsorship_master');         

                  $staff_res_chk=$this->db->select("staff_master.id, staff_employee_id, staff_name,  staff_cross_ref_number, zone_id, zones_staff_master.staff_zone_name, sponsor_count")
                            ->join('zones_staff_master', 'staff_master.zone_id=zones_staff_master.id', 'left')
                            ->where('staff_delete_status', '0')
                            ->where('staff_employee_id', $value1['missionary_emp_id'])
                            ->get('staff_master');          
                $staff_res_chk = $staff_res_chk->result_array();
                   //var_dump($staff_res_chk->result_array()); die();
                if($res_chk->num_rows()>0){

                    foreach($res_chk->result_array() as $key=>$sponsorship){


                         //var_dump($value); die();

                         $res_chk_sponsor=$this->db->select("sponsor_master.id, sponser_name, promotional_office_master.promo_office_name, sponser_country_id, sponser_promo_office, country.country_name, sponser_phone, sponsor_district, state_zone_master.state_zone_name, sponser_city_town_place, sponser_pin, DATE_FORMAT(sponser_sadmin_approve_date,'%d/%m/%Y')as sponser_sadmin_approve_date, sponser_missionary_preference, sponsor_allot_mission_status,sponser_pin, DATE_FORMAT(created_at,'%d/%m/%Y')as created_at")
                            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left')
                            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
                            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
                            ->order_by('sponsor_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsor_master.id', $sponsorship['sponsor_group_id'])
                            ->get('sponsor_master');

                            if($res_chk_sponsor->num_rows()>0){

                                foreach($res_chk_sponsor->result_array() as $key=>$value){

                                $html='

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewsponsorship/'.$value['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/allotmissionsponsor/'.$value1['id'].'"><i class="fa fa-check" aria-hidden="true"></i></a>';

                                if(isset($staff_res_chk[$key]['id']))
                                {

                                $result[]=array('id'=>$value1['id'], 'sponser_id'=>$value1['sponsor_id'], 'staffid'=>$staff_res_chk[$key]['id'], 'sponser_amount'=>$sponsorship['sponser_amount'],'sponser_name'=>$value['sponser_name'],'sponser_promo_office'=>$value['promo_office_name'],'sponser_country_id'=>$value['country_name'],'sponser_phone'=>$value['sponser_phone'],'sponsor_district'=>$value['sponsor_district'],'sponser_state'=>$value['state_zone_name'],'sponser_city_town_place'=>$value['sponser_city_town_place'],'sponser_pin'=>$value['sponser_pin'], 'sponser_sadmin_approve_date'=>$value['sponser_sadmin_approve_date'], 
                                    'created_at'=>$value['created_at'],
                                    'staff_missionary_name'=>$staff_res_chk[$key]['staff_name'], 'crn_no'=>$staff_res_chk[$key]['staff_cross_ref_number'], 'zone_name'=>$staff_res_chk[$key]['staff_zone_name'], 'emp_id'=>$staff_res_chk[$key]['staff_employee_id'], 'sponsor_count'=>$staff_res_chk[$key]['sponsor_count'], 'action'=>$html);
                                }

                               }
                             }   

                     }   


                 }   

                
            
            }
        }else{
            $response['status']="failure";
            $response['message']="No staff list found!!..";
        }
        
        $response['result']=$result;
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


    public function get_withdrawl_child_list(){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $result=array();
        $html="";
           global $api_path;

            $res=$this->db->select("allot_child.id, missionary_emp_id, sponsor_id, sponsor_amount, allotment_reallotment, withdrawl_status, sadmin_allot_approve, admin_allot_approve_date, admin_allot_approved_by, missionary_withdrawal")
            ->order_by('allot_child.id', 'desc')
            ->where('withdrawl_status', 'N')
            ->get('allot_child');  
        
        if($res->num_rows()>0){

            global $missionaryallotstatus, $api_path;

            foreach($res->result_array() as $key=>$value1){


                $res_chk=$this->db->select("sponsorship_master.id, sponsor_group_id, category_sponsorship, sponser_amount")
                            ->order_by('sponsorship_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsorship_master.id', $value1['sponsor_id'])
                            ->get('sponsorship_master');         

                        $child_res_chk=$this->db->select("staff_children.id, staff_id, children_name, cross_ref_no, staff_zone_id, zones_staff_master.staff_zone_name, sponsor_count")
                            ->join('zones_staff_master', 'staff_children.staff_zone_id=zones_staff_master.id', 'left')
                            ->where('staff_children.id', $value1['missionary_emp_id'])
                            ->get('staff_children');          
                        $child_res_chk = $child_res_chk->result_array();
                
                if($res_chk->num_rows()>0){

                    foreach($res_chk->result_array() as $key=>$sponsorship){

                         $res_chk_sponsor=$this->db->select("sponsor_master.id, sponser_name, promotional_office_master.promo_office_name, sponser_country_id, sponser_promo_office, country.country_name, sponser_phone, sponsor_district, state_zone_master.state_zone_name, sponser_city_town_place, sponser_pin, DATE_FORMAT(sponser_sadmin_approve_date,'%d/%m/%Y')as sponser_sadmin_approve_date, sponser_missionary_preference, sponsor_allot_mission_status")
                            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left')
                            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
                            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
                            ->order_by('sponsor_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsor_master.id', $sponsorship['sponsor_group_id'])
                            ->get('sponsor_master');

                            if($res_chk_sponsor->num_rows()>0){

                                foreach($res_chk_sponsor->result_array() as $key=>$value){

                                $html='

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewsponsorship/'.$value['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/allotmissionsponsor/'.$value1['id'].'"><i class="fa fa-check" aria-hidden="true"></i></a>';

                                if(isset($child_res_chk[$key]['id']))
                                {

                                    $result[]=array('id'=>$value1['id'], 'sponser_id'=>$value1['sponsor_id'], 'sponser_amount'=>$sponsorship['sponser_amount'],'sponser_name'=>$value['sponser_name'],'sponser_promo_office'=>$value['promo_office_name'],'sponser_country_id'=>$value['country_name'],'sponser_phone'=>$value['sponser_phone'],'sponsor_district'=>$value['sponsor_district'],'sponser_state'=>$value['state_zone_name'],'sponser_city_town_place'=>$value['sponser_city_town_place'],'sponser_pin'=>$value['sponser_pin'], 'sponser_sadmin_approve_date'=>$value['sponser_sadmin_approve_date'], 'staff_missionary_name'=>$child_res_chk[$key]['children_name'], 'staffid'=>$child_res_chk[$key]['id'], 'crn_no'=>$child_res_chk[$key]['cross_ref_no'], 'zone_name'=>$child_res_chk[$key]['staff_zone_name'], 'sponsor_count'=>$child_res_chk[$key]['sponsor_count'], 'action'=>$html);
                                }

                               }
                             }   

                     }   


                 }   

                
            
            }
        }else{
            $response['status']="failure";
            $response['message']="No staff list found!!..";
        }
        
        $response['result']=$result;
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

     public function get_approve_withdrawl_list(){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $result=array();
        $html="";
           global $api_path;

          $res=$this->db->select("withdrawl_missionary.id, missionary_id, sponsor_id, reason, date, created_at, created_by, admin_approve, admin_approve_by, admin_approve_date")
            ->order_by('withdrawl_missionary.id', 'desc')
            ->where('admin_approve', '0')
            ->get('withdrawl_missionary');    

        //var_dump($res); die();
        
        if($res->num_rows()>0){

            global $missionaryallotstatus, $api_path;

            foreach($res->result_array() as $key=>$value1){


                   $res_chk=$this->db->select("sponsorship_master.id, sponsor_group_id, category_sponsorship, sponser_amount")
                            ->order_by('sponsorship_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsorship_master.id', $value1['sponsor_id'])
                            ->get('sponsorship_master');          
                

                  $staff_res_chk=$this->db->select("staff_master.id, staff_employee_id, staff_name,  staff_cross_ref_number, zone_id, zones_staff_master.staff_zone_name, sponsor_count")
                            ->join('zones_staff_master', 'staff_master.zone_id=zones_staff_master.id', 'left')
                            ->where('staff_delete_status', '0')
                            ->where('staff_employee_id', $value1['missionary_id'])
                            ->get('staff_master');          
                $staff_res_chk = $staff_res_chk->result_array();
                   //var_dump($staff_res_chk->result_array()); die();
                if($res_chk->num_rows()>0){

                    foreach($res_chk->result_array() as $key=>$sponsorship){


                         $res_chk_sponsor=$this->db->select("sponsor_master.id, sponser_name, promotional_office_master.promo_office_name, sponser_country_id, sponser_promo_office, country.country_name, sponser_phone, sponsor_district, state_zone_master.state_zone_name, sponser_city_town_place, sponser_pin, DATE_FORMAT(sponser_sadmin_approve_date,'%d/%m/%Y')as sponser_sadmin_approve_date, sponser_missionary_preference, sponsor_allot_mission_status,DATE_FORMAT(created_at,'%d/%m/%Y') as created_at")
                            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left')
                            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
                            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
                            ->order_by('sponsor_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsor_master.id', $sponsorship['sponsor_group_id'])
                            ->get('sponsor_master');

                            if($res_chk_sponsor->num_rows()>0){

                                foreach($res_chk_sponsor->result_array() as $key=>$value){

                                 //var_dump($value); die();
                                $html='

                                        <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewsponsorship/'.$value['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                        <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/allotmissionsponsor/'.$value1['id'].'"><i class="fa fa-check" aria-hidden="true"></i></a>';

                                        if(isset($staff_res_chk[$key]['id']))
                                        {

                                            $result[]=array('id'=>$value1['id'], 'sponser_id'=>$value1['sponsor_id'],'reason'=>$value1['reason'], 'staffid'=>$staff_res_chk[$key]['id'], 'sponser_name'=>$value['sponser_name'], 'sponsor_amount'=>$sponsorship['sponser_amount'],'sponser_promo_office'=>$value['promo_office_name'],'sponser_country_id'=>$value['country_name'],'sponser_phone'=>$value['sponser_phone'],'sponsor_district'=>$value['sponsor_district'],'sponser_state'=>$value['state_zone_name'],'sponser_city_town_place'=>$value['sponser_city_town_place'],'sponser_pin'=>$value['sponser_pin'], 'sponser_sadmin_approve_date'=>$value['sponser_sadmin_approve_date'], 'staff_missionary_name'=>$staff_res_chk[$key]['staff_name'], 'crn_no'=>$staff_res_chk[$key]['staff_cross_ref_number'], 'zone_name'=>$staff_res_chk[$key]['staff_zone_name'], 'emp_id'=>$staff_res_chk[$key]['staff_employee_id'], 'sponsor_count'=>$staff_res_chk[$key]['sponsor_count'], 
                                                'created_at'=>$value['created_at'],
                                                'action'=>$html);
                                        }


                                   }
                                   
                                }     

                             }   


                 }   

                
            
            }
        }else{
            $response['status']="failure";
            $response['message']="No staff list found!!..";
        }
        
        $response['result']=$result;
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    public function get_approve_withdrawl_child_list(){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $result=array();
        $html="";
           global $api_path;

          $res=$this->db->select("withdrawl_child.id, missionary_id, sponsor_id, reason, date, created_at, created_by, admin_approve, admin_approve_by, admin_approve_date")
            ->order_by('withdrawl_child.id', 'desc')
            ->where('admin_approve', '0')
            ->get('withdrawl_child');    

        //var_dump($res); die();
        
        if($res->num_rows()>0){

            global $missionaryallotstatus, $api_path;

            foreach($res->result_array() as $key=>$value1){


                   $res_chk=$this->db->select("sponsorship_master.id, sponsor_group_id, category_sponsorship, sponser_amount")
                            ->order_by('sponsorship_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsorship_master.id', $value1['sponsor_id'])
                            ->get('sponsorship_master');          
                

                //   $staff_res_chk=$this->db->select("staff_master.id, staff_employee_id, staff_name,  staff_cross_ref_number, zone_id, zones_staff_master.staff_zone_name, sponsor_count")
                //             ->join('zones_staff_master', 'staff_master.zone_id=zones_staff_master.id', 'left')
                //             ->where('staff_delete_status', '0')
                //             ->where('staff_employee_id', $value1['missionary_id'])
                //             ->get('staff_master');          
                // $staff_res_chk = $staff_res_chk->result_array();
                   //var_dump($staff_res_chk->result_array()); die();

                    $child_res_chk=$this->db->select("staff_children.id, staff_id, children_name, cross_ref_no, staff_zone_id, zones_staff_master.staff_zone_name, sponsor_count")
                            ->join('zones_staff_master', 'staff_children.staff_zone_id=zones_staff_master.id', 'left')
                            ->where('staff_children.id', $value1['missionary_id'])
                            ->get('staff_children');          
                        $child_res_chk = $child_res_chk->result_array();


                if($res_chk->num_rows()>0){

                    foreach($res_chk->result_array() as $key=>$sponsorship){


                         $res_chk_sponsor=$this->db->select("sponsor_master.id, sponser_name, promotional_office_master.promo_office_name, sponser_country_id, sponser_promo_office, country.country_name, sponser_phone, sponsor_district, state_zone_master.state_zone_name, sponser_city_town_place, sponser_pin, DATE_FORMAT(sponser_sadmin_approve_date,'%d/%m/%Y')as sponser_sadmin_approve_date, sponser_missionary_preference, sponsor_allot_mission_status")
                            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left')
                            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
                            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
                            ->order_by('sponsor_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsor_master.id', $sponsorship['sponsor_group_id'])
                            ->get('sponsor_master');

                            if($res_chk_sponsor->num_rows()>0){

                                foreach($res_chk_sponsor->result_array() as $key=>$value){

                                 //var_dump($value); die();
                                $html='

                                        <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewsponsorship/'.$value['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                        <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/allotmissionsponsor/'.$value1['id'].'"><i class="fa fa-check" aria-hidden="true"></i></a>';

                                        if(isset($child_res_chk[$key]['id']))
                                        {

                                            $result[]=array('id'=>$value1['id'], 'sponser_id'=>$value1['sponsor_id'], 'reason'=>$value1['reason'], 'staffid'=>$child_res_chk[$key]['id'], 'sponser_name'=>$value['sponser_name'], 'sponsor_amount'=>$sponsorship['sponser_amount'],'sponser_promo_office'=>$value['promo_office_name'],'sponser_country_id'=>$value['country_name'],'sponser_phone'=>$value['sponser_phone'],'sponsor_district'=>$value['sponsor_district'],'sponser_state'=>$value['state_zone_name'],'sponser_city_town_place'=>$value['sponser_city_town_place'],'sponser_pin'=>$value['sponser_pin'], 'sponser_sadmin_approve_date'=>$value['sponser_sadmin_approve_date'], 'staff_missionary_name'=>$child_res_chk[$key]['children_name'], 'staffid'=>$child_res_chk[$key]['id'], 'crn_no'=>$child_res_chk[$key]['cross_ref_no'], 'zone_name'=>$child_res_chk[$key]['staff_zone_name'], 'sponsor_count'=>$child_res_chk[$key]['sponsor_count'], 'action'=>$html);
                                        }


                                   }
                                   
                                }     

                             }   


                 }   

                
            
            }
        }else{
            $response['status']="failure";
            $response['message']="No staff list found!!..";
        }
        
        $response['result']=$result;
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    public function get_allot_missionary_approved_list(){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $result=array();
        $html="";

          $res=$this->db->select("allot_missionary.id, missionary_emp_id, sponsor_id, sponsor_amount, allotment_reallotment, withdrawl_status, sadmin_allot_approve, DATE_FORMAT(admin_allot_approve_date,'%d/%m/%Y')as admin_allot_approve_date, family_sponsor, admin_allot_approved_by, missionary_withdrawal")
            ->order_by('allot_missionary.id', 'desc')
            ->where('allotment_reallotment', 'A')
            ->where('sadmin_allot_approve', '1')
            ->get('allot_missionary');  

        // var_dump($res); die();
        
        if($res->num_rows()>0){

            global $missionaryallotstatus, $api_path;

            foreach($res->result_array() as $key=>$value1){

                 $res_chk=$this->db->select("sponsorship_master.id, sponsor_group_id, category_sponsorship, sponser_amount")
                            ->order_by('sponsorship_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsorship_master.id', $value1['sponsor_id'])
                            ->get('sponsorship_master');          

                  $staff_res_chk=$this->db->select("staff_master.id, staff_employee_id, staff_name,  staff_cross_ref_number, zone_id, zones_staff_master.staff_zone_name, sponsor_count")
                            ->join('zones_staff_master', 'staff_master.zone_id=zones_staff_master.id', 'left')
                            ->where('staff_delete_status', '0')
                            ->where('staff_employee_id', $value1['missionary_emp_id'])
                            ->get('staff_master');          
                $staff_res_chk = $staff_res_chk->result_array();
                   //var_dump($staff_res_chk->result_array()); die();
                if($res_chk->num_rows()>0){

                    foreach($res_chk->result_array() as $key=>$sponsorship){


                         //var_dump($value); die();

                        $res_chk_sponsor=$this->db->select("sponsor_master.id, sponser_name, promotional_office_master.promo_office_name, sponser_country_id, sponser_promo_office, country.country_name, sponser_phone, sponsor_district, state_zone_master.state_zone_name, sponser_city_town_place, sponser_pin, DATE_FORMAT(sponser_sadmin_approve_date,'%d/%m/%Y')as sponser_sadmin_approve_date, sponser_missionary_preference, sponsor_allot_mission_status,DATE_FORMAT(created_at,'%d/%m/%Y')as created_at")
                            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left')
                            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
                            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
                            ->order_by('sponsor_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsor_master.id', $sponsorship['sponsor_group_id'])
                            ->get('sponsor_master');

                            if($res_chk_sponsor->num_rows()>0){

                                foreach($res_chk_sponsor->result_array() as $key=>$value){


                                $html='

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewsponsorship/'.$value['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/allotmissionsponsor/'.$value1['id'].'"><i class="fa fa-check" aria-hidden="true"></i></a>';

                                if(isset($staff_res_chk[$key]['id']))
                                {

                                    $result[]=array('id'=>$value1['id'], 'sponser_id'=>$value1['sponsor_id'], 'sponser_amount'=>$sponsorship['sponser_amount'],'sponser_name'=>$value['sponser_name'],'sponser_promo_office'=>$value['promo_office_name'],'sponser_country_id'=>$value['country_name'],'sponser_phone'=>$value['sponser_phone'],'sponsor_district'=>$value['sponsor_district'],'sponser_state'=>$value['state_zone_name'],'sponser_city_town_place'=>$value['sponser_city_town_place'],'sponser_pin'=>$value['sponser_pin'], 'admin_allot_approve_date'=>$value1['admin_allot_approve_date'], 'staff_missionary_name'=>$staff_res_chk[$key]['staff_name'], 'staffid'=>$staff_res_chk[$key]['id'], 'crn_no'=>$staff_res_chk[$key]['staff_cross_ref_number'], 'zone_name'=>$staff_res_chk[$key]['staff_zone_name'], 'emp_id'=>$staff_res_chk[$key]['staff_employee_id'], 'sponsor_count'=>$staff_res_chk[$key]['sponsor_count'],
                                        'created_at'=>$value['created_at'], 'action'=>$html);
                                }
                              }
                            }   

                     }   


                 }   

                
            
            }
        }else{
            $response['status']="failure";
            $response['message']="No staff list found!!..";
        }
        
        $response['result']=$result;
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


    public function get_allot_child_approved_list(){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $result=array();
        $html="";

          $res=$this->db->select("allot_child.id, missionary_emp_id, sponsor_id, sponsor_amount, allotment_reallotment, withdrawl_status, sadmin_allot_approve, DATE_FORMAT(admin_allot_approve_date,'%d/%m/%Y')as admin_allot_approve_date, family_sponsor, admin_allot_approved_by, missionary_withdrawal,DATE_FORMAT(created_at,'%d/%m/%Y')as created_at")
            ->order_by('allot_child.id', 'desc')
            ->where('allotment_reallotment', 'A')
            ->where('sadmin_allot_approve', '1')
            ->get('allot_child');  

        //var_dump($res->result_array()); die();
        
        if($res->num_rows()>0){

            global $missionaryallotstatus, $api_path;

            foreach($res->result_array() as $key=>$value1){



                 $res_chk=$this->db->select("sponsorship_master.id, sponsor_group_id, category_sponsorship, sponser_amount")
                            ->order_by('sponsorship_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsorship_master.id', $value1['sponsor_id'])
                            ->get('sponsorship_master');          

                  // $staff_res_chk=$this->db->select("staff_master.id, staff_employee_id, staff_name,  staff_cross_ref_number, zone_id, zones_staff_master.staff_zone_name, sponsor_count")
                  //           ->join('zones_staff_master', 'staff_master.zone_id=zones_staff_master.id', 'left')
                  //           ->where('staff_delete_status', '0')
                  //           ->where('staff_employee_id', $value1['missionary_emp_id'])
                  //           ->get('staff_master');          
                  //   $staff_res_chk = $staff_res_chk->result_array();

                          //  var_dump($value1['missionary_emp_id']); die();
                $child_res_chk=$this->db->select("staff_children.id, staff_id, children_name, cross_ref_no, staff_zone_id, zones_staff_master.staff_zone_name, sponsor_count")
                            ->join('zones_staff_master', 'staff_children.staff_zone_id=zones_staff_master.id', 'left')
                            ->where('staff_children.id', $value1['missionary_emp_id'])
                            ->get('staff_children');          
                $child_res_chk1 = $child_res_chk->result_array();

               //var_dump($res_chk->num_rows()); die();

                  // var_dump($child_res_chk); die();
                if($res_chk->num_rows()>0){

                    foreach($res_chk->result_array() as $key=>$sponsorship){


                         //var_dump($value); die();

                        $res_chk_sponsor=$this->db->select("sponsor_master.id, sponser_name, promotional_office_master.promo_office_name, sponser_country_id, sponser_promo_office, country.country_name, sponser_phone, sponsor_district, state_zone_master.state_zone_name, sponser_city_town_place, sponser_pin, DATE_FORMAT(sponser_sadmin_approve_date,'%d/%m/%Y')as sponser_sadmin_approve_date,
                            DATE_FORMAT(created_at,'%d/%m/%Y')as created_at,
                         sponser_missionary_preference, sponsor_allot_mission_status")
                            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left')
                            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
                            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
                            ->order_by('sponsor_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsor_master.id', $sponsorship['sponsor_group_id'])
                            ->get('sponsor_master');



                            if($res_chk_sponsor->num_rows()>0){

                                foreach($res_chk_sponsor->result_array() as $key=>$value){


                                $html='

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewsponsorship/'.$value['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/allotmissionsponsor/'.$value1['id'].'"><i class="fa fa-check" aria-hidden="true"></i></a>';

                                if(isset($child_res_chk1[$key]['id']))
                                {

                                    $result[]=array('id'=>$value1['id'], 'sponser_id'=>$value1['sponsor_id'], 'sponser_amount'=>$sponsorship['sponser_amount'],'sponser_name'=>$value['sponser_name'],'sponser_promo_office'=>$value['promo_office_name'],'sponser_country_id'=>$value['country_name'],'sponser_phone'=>$value['sponser_phone'],'sponsor_district'=>$value['sponsor_district'],'sponser_state'=>$value['state_zone_name'],'sponser_city_town_place'=>$value['sponser_city_town_place'],'sponser_pin'=>$value['sponser_pin'], 'admin_allot_approve_date'=>$value1['admin_allot_approve_date'], 
                                        'created_at'=>$value['created_at'],
                                        'staff_missionary_name'=>$child_res_chk1[$key]['children_name'], 'staffid'=>$child_res_chk1[$key]['id'], 'crn_no'=>$child_res_chk1[$key]['cross_ref_no'], 'zone_name'=>$child_res_chk1[$key]['staff_zone_name'], 'sponsor_count'=>$child_res_chk1[$key]['sponsor_count'],'created_at'=>$value1['created_at'],'action'=>$html);
                                }

                              }
                            }   


                     }   
                 }

                    

                
           // break;
            }
        }else{
            $response['status']="failure";
            $response['message']="No staff list found!!..";
        }
        
        $response['result']=$result;
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    public function get_approved_withdrawl_list(){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $result=array();
        $html="";

          // $res=$this->db->select("allot_missionary.id, missionary_emp_id, sponsor_id, sponsor_amount, allotment_reallotment, withdrawl_status, sadmin_allot_approve, DATE_FORMAT(admin_allot_approve_date,'%d/%m/%Y')as admin_allot_approve_date, family_sponsor, admin_allot_approved_by, missionary_withdrawal")
          //   ->order_by('allot_missionary.id', 'desc')
          //   ->where('allotment_reallotment', 'A')
          //   ->where('sadmin_allot_approve', '1')
          //   ->get('allot_missionary');  

         $res=$this->db->select("withdrawl_missionary.id, missionary_id, DATE_FORMAT(admin_approve_date,'%d/%m/%Y')as admin_approve_date,sponsor_id, reason, date")
            ->order_by('withdrawl_missionary.id', 'desc')
            ->where('admin_approve', '1')
            ->get('withdrawl_missionary');     

        // var_dump($res); die();
        
        if($res->num_rows()>0){

            global $missionaryallotstatus, $api_path;

            foreach($res->result_array() as $key=>$value1){

                 $res_chk=$this->db->select("sponsorship_master.id, sponsor_group_id, category_sponsorship, sponser_amount")
                            ->order_by('sponsorship_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsorship_master.id', $value1['sponsor_id'])
                            ->get('sponsorship_master');          

                  $staff_res_chk=$this->db->select("staff_master.id, staff_employee_id, staff_name,  staff_cross_ref_number, zone_id, zones_staff_master.staff_zone_name, sponsor_count")
                            ->join('zones_staff_master', 'staff_master.zone_id=zones_staff_master.id', 'left')
                            ->where('staff_delete_status', '0')
                            ->where('staff_employee_id', $value1['missionary_id'])
                            ->get('staff_master');          
                $staff_res_chk = $staff_res_chk->result_array();
                   //var_dump($staff_res_chk->result_array()); die();
                if($res_chk->num_rows()>0){

                    foreach($res_chk->result_array() as $key=>$sponsorship){


                         //var_dump($value); die();

                        $res_chk_sponsor=$this->db->select("sponsor_master.id, sponser_name, promotional_office_master.promo_office_name, sponser_country_id, sponser_promo_office, country.country_name, sponser_phone, sponsor_district, state_zone_master.state_zone_name, sponser_city_town_place, sponser_pin, DATE_FORMAT(sponser_sadmin_approve_date,'%d/%m/%Y')as sponser_sadmin_approve_date, sponser_missionary_preference, sponsor_allot_mission_status")
                            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left')
                            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
                            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
                            ->order_by('sponsor_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsor_master.id', $sponsorship['sponsor_group_id'])
                            ->get('sponsor_master');

                            if($res_chk_sponsor->num_rows()>0){

                                foreach($res_chk_sponsor->result_array() as $key=>$value){


                                $html='

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewsponsorship/'.$value['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/allotmissionsponsor/'.$value1['id'].'"><i class="fa fa-check" aria-hidden="true"></i></a>';

                                if(isset($staff_res_chk[$key]['id']))
                                {

                                    $result[]=array('id'=>$value1['id'], 'sponser_id'=>$value1['sponsor_id'],'reason'=>$value1['reason'], 'staffid'=>$staff_res_chk[$key]['id'], 'sponser_amount'=>$sponsorship['sponser_amount'],'sponser_name'=>$value['sponser_name'],'sponser_promo_office'=>$value['promo_office_name'],'sponser_country_id'=>$value['country_name'],'sponser_phone'=>$value['sponser_phone'],'sponsor_district'=>$value['sponsor_district'],'sponser_state'=>$value['state_zone_name'],'sponser_city_town_place'=>$value['sponser_city_town_place'],'sponser_pin'=>$value['sponser_pin'], 'admin_allot_approve_date'=>$value1['admin_approve_date'], 'staff_missionary_name'=>$staff_res_chk[$key]['staff_name'], 'crn_no'=>$staff_res_chk[$key]['staff_cross_ref_number'], 'zone_name'=>$staff_res_chk[$key]['staff_zone_name'], 'emp_id'=>$staff_res_chk[$key]['staff_employee_id'], 'sponsor_count'=>$staff_res_chk[$key]['sponsor_count'], 'action'=>$html);
                                }

                              }
                            }   

                     }   


                 }   

                
            
            }
        }else{
            $response['status']="failure";
            $response['message']="No staff list found!!..";
        }
        
        $response['result']=$result;
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    public function get_approved_withdrawl_child_list(){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $result=array();
        $html="";

         $res=$this->db->select("withdrawl_child.id, missionary_id, DATE_FORMAT(admin_approve_date,'%d/%m/%Y')as admin_approve_date,sponsor_id, reason, date")
            ->order_by('withdrawl_child.id', 'desc')
            ->where('admin_approve', '1')
            ->get('withdrawl_child');     

        // var_dump($res); die();
        
        if($res->num_rows()>0){

            global $missionaryallotstatus, $api_path;

            foreach($res->result_array() as $key=>$value1){

                 $res_chk=$this->db->select("sponsorship_master.id, sponsor_group_id, category_sponsorship, sponser_amount")
                            ->order_by('sponsorship_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsorship_master.id', $value1['sponsor_id'])
                            ->get('sponsorship_master');          

                //   $staff_res_chk=$this->db->select("staff_master.id, staff_employee_id, staff_name,  staff_cross_ref_number, zone_id, zones_staff_master.staff_zone_name, sponsor_count")
                //             ->join('zones_staff_master', 'staff_master.zone_id=zones_staff_master.id', 'left')
                //             ->where('staff_delete_status', '0')
                //             ->where('staff_employee_id', $value1['missionary_id'])
                //             ->get('staff_master');          
                // $staff_res_chk = $staff_res_chk->result_array();
                   //var_dump($staff_res_chk->result_array()); die();

                    $child_res_chk=$this->db->select("staff_children.id, staff_id, children_name, cross_ref_no, staff_zone_id, zones_staff_master.staff_zone_name, sponsor_count")
                            ->join('zones_staff_master', 'staff_children.staff_zone_id=zones_staff_master.id', 'left')
                            ->where('staff_children.id', $value1['missionary_id'])
                            ->get('staff_children');          
                        $child_res_chk = $child_res_chk->result_array();

                if($res_chk->num_rows()>0){

                    foreach($res_chk->result_array() as $key=>$sponsorship){


                         //var_dump($value); die();

                        $res_chk_sponsor=$this->db->select("sponsor_master.id, sponser_name, promotional_office_master.promo_office_name, sponser_country_id, sponser_promo_office, country.country_name, sponser_phone, sponsor_district, state_zone_master.state_zone_name, sponser_city_town_place, sponser_pin, DATE_FORMAT(sponser_sadmin_approve_date,'%d/%m/%Y')as sponser_sadmin_approve_date, sponser_missionary_preference, sponsor_allot_mission_status")
                            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left')
                            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
                            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
                            ->order_by('sponsor_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsor_master.id', $sponsorship['sponsor_group_id'])
                            ->get('sponsor_master');

                            if($res_chk_sponsor->num_rows()>0){

                                foreach($res_chk_sponsor->result_array() as $key=>$value){


                                $html='

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewsponsorship/'.$value['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/allotmissionsponsor/'.$value1['id'].'"><i class="fa fa-check" aria-hidden="true"></i></a>';

                                if(isset($child_res_chk[$key]['id']))
                                {

                                    $result[]=array('id'=>$value1['id'], 'sponser_id'=>$value1['sponsor_id'], 'reason'=>$value1['reason'], 'staffid'=>$child_res_chk[$key]['id'], 'sponser_amount'=>$sponsorship['sponser_amount'],'sponser_name'=>$value['sponser_name'],'sponser_promo_office'=>$value['promo_office_name'],'sponser_country_id'=>$value['country_name'],'sponser_phone'=>$value['sponser_phone'],'sponsor_district'=>$value['sponsor_district'],'sponser_state'=>$value['state_zone_name'],'sponser_city_town_place'=>$value['sponser_city_town_place'],'sponser_pin'=>$value['sponser_pin'], 'admin_allot_approve_date'=>$value1['admin_approve_date'], 'staff_missionary_name'=>$child_res_chk[$key]['children_name'], 'staffid'=>$child_res_chk[$key]['id'], 'crn_no'=>$child_res_chk[$key]['cross_ref_no'], 'zone_name'=>$child_res_chk[$key]['staff_zone_name'], 'sponsor_count'=>$child_res_chk[$key]['sponsor_count'], 'action'=>$html);
                                }

                              }
                            }   

                     }   


                 }   

                
            
            }
        }else{
            $response['status']="failure";
            $response['message']="No staff list found!!..";
        }
        
        $response['result']=$result;
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    public function get_revert_sponsorship_list(){
          $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $result=array();
        $html="";

          $res=$this->db->select("allot_missionary.id, missionary_emp_id, sponsor_id, sponsor_amount, allotment_reallotment, withdrawl_status, sadmin_allot_approve, DATE_FORMAT(admin_allot_approve_date,'%d/%m/%Y')as admin_allot_approve_date, family_sponsor, admin_allot_approved_by, missionary_withdrawal")
            ->order_by('allot_missionary.id', 'desc')
            ->where('revert_sponsorship', '0')
            ->get('allot_missionary');  

        //var_dump($res->result_array()); die();
        
        if($res->num_rows()>0){

            global $missionaryallotstatus, $api_path;

            foreach($res->result_array() as $key=>$value1){

                 $res_chk=$this->db->select("sponsorship_master.id, sponsor_group_id, category_sponsorship, sponser_amount")
                            ->order_by('sponsorship_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsorship_master.id', $value1['sponsor_id'])
                            ->get('sponsorship_master');          

                  $staff_res_chk=$this->db->select("staff_master.id, staff_employee_id, staff_name,  staff_cross_ref_number, zone_id, zones_staff_master.staff_zone_name, sponsor_count")
                            ->join('zones_staff_master', 'staff_master.zone_id=zones_staff_master.id', 'left')
                            ->where('staff_delete_status', '0')
                            ->where('staff_employee_id', $value1['missionary_emp_id'])
                            ->get('staff_master');          
                $staff_res_chk = $staff_res_chk->result_array();
                  // var_dump($staff_res_chk); die();
                if($res_chk->num_rows()>0){

                    foreach($res_chk->result_array() as $key=>$sponsorship){


                         //var_dump($value); die();

                        $res_chk_sponsor=$this->db->select("sponsor_master.id, sponser_name, promotional_office_master.promo_office_name, sponser_country_id, sponser_promo_office, country.country_name, sponser_phone, sponsor_district, state_zone_master.state_zone_name, sponser_city_town_place, sponser_pin, DATE_FORMAT(sponser_sadmin_approve_date,'%d/%m/%Y')as sponser_sadmin_approve_date, sponser_missionary_preference, sponsor_allot_mission_status,DATE_FORMAT(created_at,'%d/%m/%Y') as created_at")
                            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left')
                            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
                            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
                            ->order_by('sponsor_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsor_master.id', $sponsorship['sponsor_group_id'])
                            ->get('sponsor_master');

                            if($res_chk_sponsor->num_rows()>0){

                                foreach($res_chk_sponsor->result_array() as $key=>$value){


                                $html='

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewsponsorship/'.$value['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/allotmissionsponsor/'.$value1['id'].'"><i class="fa fa-check" aria-hidden="true"></i></a>';

                                if(isset($staff_res_chk[$key]['id']))
                                {
                                	$result[]=array('id'=>$value1['id'], 'sponser_id'=>$value1['sponsor_id'], 'staffid'=>$staff_res_chk[$key]['id'], 'sponser_amount'=>$sponsorship['sponser_amount'],'sponser_name'=>$value['sponser_name'],'sponser_promo_office'=>$value['promo_office_name'],'sponser_country_id'=>$value['country_name'],'sponser_phone'=>$value['sponser_phone'],'sponsor_district'=>$value['sponsor_district'],'sponser_state'=>$value['state_zone_name'],'sponser_city_town_place'=>$value['sponser_city_town_place'],'sponser_pin'=>$value['sponser_pin'], 'admin_allot_approve_date'=>$value1['admin_allot_approve_date'], 'staff_missionary_name'=>$staff_res_chk[$key]['staff_name'], 'crn_no'=>$staff_res_chk[$key]['staff_cross_ref_number'], 'zone_name'=>$staff_res_chk[$key]['staff_zone_name'], 'emp_id'=>$staff_res_chk[$key]['staff_employee_id'], 'sponsor_count'=>$staff_res_chk[$key]['sponsor_count'], 
                                        'created_at'=>$value['created_at'],'action'=>$html);
                                }

                                

                                //var_dump($result); die();
                              }
                            }   

                     }   


                 }   

                
            
            }
        }else{
            $response['status']="failure";
            $response['message']="No staff list found!!..";
        }
        
        $response['result']=$result;
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


    public function get_revert_child_sponsorship_list(){
          $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $result=array();
        $html="";

          $res=$this->db->select("allot_child.id, missionary_emp_id, sponsor_id, sponsor_amount, allotment_reallotment, withdrawl_status, sadmin_allot_approve, DATE_FORMAT(admin_allot_approve_date,'%d/%m/%Y')as admin_allot_approve_date, family_sponsor, admin_allot_approved_by, missionary_withdrawal")
            ->order_by('allot_child.id', 'desc')
            ->where('revert_sponsorship', '0')
            ->get('allot_child');  

        // var_dump($res); die();
        
        if($res->num_rows()>0){

            global $missionaryallotstatus, $api_path;

            foreach($res->result_array() as $key=>$value1){

                 $res_chk=$this->db->select("sponsorship_master.id, sponsor_group_id, category_sponsorship, sponser_amount")
                            ->order_by('sponsorship_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsorship_master.id', $value1['sponsor_id'])
                            ->get('sponsorship_master');          

                //   $staff_res_chk=$this->db->select("staff_master.id, staff_employee_id, staff_name,  staff_cross_ref_number, zone_id, zones_staff_master.staff_zone_name, sponsor_count")
                //             ->join('zones_staff_master', 'staff_master.zone_id=zones_staff_master.id', 'left')
                //             ->where('staff_delete_status', '0')
                //             ->where('staff_employee_id', $value1['missionary_emp_id'])
                //             ->get('staff_master');          
                // $staff_res_chk = $staff_res_chk->result_array();

                    $child_res_chk=$this->db->select("staff_children.id, staff_id, children_name, cross_ref_no, staff_zone_id, zones_staff_master.staff_zone_name, sponsor_count")
                    ->join('zones_staff_master', 'staff_children.staff_zone_id=zones_staff_master.id', 'left')
                    ->where('staff_children.id', $value1['missionary_emp_id'])
                    ->get('staff_children');          
                    $child_res_chk = $child_res_chk->result_array();


                   //var_dump($staff_res_chk->result_array()); die();
                if($res_chk->num_rows()>0){

                    foreach($res_chk->result_array() as $key=>$sponsorship){


                         //var_dump($value); die();

                        $res_chk_sponsor=$this->db->select("sponsor_master.id, sponser_name, promotional_office_master.promo_office_name, sponser_country_id, sponser_promo_office, country.country_name, sponser_phone, sponsor_district, state_zone_master.state_zone_name, sponser_city_town_place, sponser_pin, DATE_FORMAT(sponser_sadmin_approve_date,'%d/%m/%Y')as sponser_sadmin_approve_date, sponser_missionary_preference, sponsor_allot_mission_status")
                            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left')
                            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
                            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
                            ->order_by('sponsor_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsor_master.id', $sponsorship['sponsor_group_id'])
                            ->get('sponsor_master');

                            if($res_chk_sponsor->num_rows()>0){

                                foreach($res_chk_sponsor->result_array() as $key=>$value){


                                $html='

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewsponsorship/'.$value['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/allotmissionsponsor/'.$value1['id'].'"><i class="fa fa-check" aria-hidden="true"></i></a>';

                                if(isset($child_res_chk[$key]['id']))
                                {

                                    $result[]=array('id'=>$value1['id'], 'sponser_id'=>$value1['sponsor_id'], 'sponser_amount'=>$sponsorship['sponser_amount'],'sponser_name'=>$value['sponser_name'],'sponser_promo_office'=>$value['promo_office_name'],'sponser_country_id'=>$value['country_name'],'sponser_phone'=>$value['sponser_phone'],'sponsor_district'=>$value['sponsor_district'],'sponser_state'=>$value['state_zone_name'],'sponser_city_town_place'=>$value['sponser_city_town_place'],'sponser_pin'=>$value['sponser_pin'], 'admin_allot_approve_date'=>$value1['admin_allot_approve_date'], 'staff_missionary_name'=>$child_res_chk[$key]['children_name'], 'staffid'=>$child_res_chk[$key]['id'], 'crn_no'=>$child_res_chk[$key]['cross_ref_no'], 'zone_name'=>$child_res_chk[$key]['staff_zone_name'], 'sponsor_count'=>$child_res_chk[$key]['sponsor_count'], 'action'=>$html);
                                }

                              }
                            }   

                     }   


                 }   

                
            
            }
        }else{
            $response['status']="failure";
            $response['message']="No staff list found!!..";
        }
        
        $response['result']=$result;
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


    public function gems_insert_revert_sponsorship() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        $staff_ids = $model->selectedstaff;

        

        if (is_array($staff_ids) && count($staff_ids)>0) {
            
            $success_count = 0;
            foreach ($staff_ids as $staff_id) {


                $data = array('revert_sponsorship' => '1');
                $this->db->where('id', $staff_id);
                $result=$this->db->update('allot_missionary', $data);

                if ($result) {
                 $res=$this->db->select("missionary_emp_id, sponsor_id")
                        ->where('id', $staff_id)
                        ->get('allot_missionary');

                   // var_dump($res); die();

                 if($res->num_rows()>0) {

                    foreach($res->result_array() as $key=>$value) {

                        //var_dump($value); die();

                         $this->db->query("insert into ".$this->db->dbprefix('revert_sponsorship')." (
                                        missionary_id,
                                        sponsor_id,
                                        created_at,
                                        created_by,
                                        sdmin_approve
                                            ) values (
                                                '".$value['missionary_emp_id']."',
                                                '".$value['sponsor_id']."',
                                                NOW(),
                                                '1',
                                                '0'
                                                )");

                                if($this->db->insert_id()){
                                    $response['result']=array('id'=>$this->db->insert_id());
                                    $response['message']="Revert Sponsorship record stored successfully";
                                }else{
                                    $response['status']="failure";            
                                    $response['message']="Sorry!!, Unable to insert the Revert Sponsorship data";
                                }
                        }

                    }
                }
                else
                {
                    $response['status']="failure";
                    $response['message']="Revert Sponsorship status has not been updated fully";
                }

            }

        } else {
            $response['status']="failure";
            $response['message']="Choose missionary and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


    public function gems_insert_revert_child_sponsorship() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        $staff_ids = $model->selectedstaff;

        

        if (is_array($staff_ids) && count($staff_ids)>0) {
            
            $success_count = 0;
            foreach ($staff_ids as $staff_id) {


                $data = array('revert_sponsorship' => '1');
                $this->db->where('missionary_emp_id', $staff_id);
                $result=$this->db->update('allot_child', $data);

                if ($result) {
                 $res=$this->db->select("missionary_emp_id, sponsor_id")
                        ->where('missionary_emp_id', $staff_id)
                        ->get('allot_child');

                   // var_dump($res); die();

                 if($res->num_rows()>0) {

                    foreach($res->result_array() as $key=>$value) {

                        //var_dump($value); die();

                         $this->db->query("insert into ".$this->db->dbprefix('revert_child')." (
                                        missionary_id,
                                        sponsor_id,
                                        created_at,
                                        created_by,
                                        sdmin_approve
                                            ) values (
                                                '".$value['missionary_emp_id']."',
                                                '".$value['sponsor_id']."',
                                                NOW(),
                                                '1',
                                                '0'
                                                )");

                                if($this->db->insert_id()){
                                    $response['result']=array('id'=>$this->db->insert_id());
                                    $response['message']="Revert Sponsorship record stored successfully";
                                }else{
                                    $response['status']="failure";            
                                    $response['message']="Sorry!!, Unable to insert the Revert Sponsorship data";
                                }
                        }

                    }
                }
                else
                {
                    $response['status']="failure";
                    $response['message']="Revert Sponsorship status has not been updated fully";
                }

            }

        } else {
            $response['status']="failure";
            $response['message']="Choose missionary and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


    public function get_approve_revert_sponsorship_list(){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $result=array();
        $html="";
           global $api_path;

          $res=$this->db->select("revert_sponsorship.id, missionary_id, sponsor_id, reason, DATE_FORMAT(created_at,'%d/%m/%Y') as created_at, created_by, sdmin_approve, sdmin_approve_date, sdmin_approved_by")
            ->order_by('revert_sponsorship.id', 'desc')
            ->where('sdmin_approve', '0')
            ->get('revert_sponsorship');    

        //var_dump($res); die();
        
        if($res->num_rows()>0){

            global $missionaryallotstatus, $api_path;

            foreach($res->result_array() as $key=>$value1){


                   $res_chk=$this->db->select("sponsorship_master.id, sponsor_group_id, category_sponsorship, sponser_amount")
                            ->order_by('sponsorship_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsorship_master.id', $value1['sponsor_id'])
                            ->get('sponsorship_master');          
                

                  $staff_res_chk=$this->db->select("staff_master.id, staff_employee_id, staff_name,  staff_cross_ref_number, zone_id, zones_staff_master.staff_zone_name, sponsor_count")
                            ->join('zones_staff_master', 'staff_master.zone_id=zones_staff_master.id', 'left')
                            ->where('staff_delete_status', '0')
                            ->where('staff_employee_id', $value1['missionary_id'])
                            ->get('staff_master');          
                $staff_res_chk = $staff_res_chk->result_array();
                   //var_dump($staff_res_chk->result_array()); die();
                if($res_chk->num_rows()>0){

                    foreach($res_chk->result_array() as $key=>$sponsorship){


                         $res_chk_sponsor=$this->db->select("sponsor_master.id, sponser_name, promotional_office_master.promo_office_name, sponser_country_id, sponser_promo_office, country.country_name, sponser_phone, sponsor_district, state_zone_master.state_zone_name, sponser_city_town_place, sponser_pin, DATE_FORMAT(sponser_sadmin_approve_date,'%d/%m/%Y')as sponser_sadmin_approve_date, sponser_missionary_preference, sponsor_allot_mission_status")
                            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left')
                            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
                            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
                            ->order_by('sponsor_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsor_master.id', $sponsorship['sponsor_group_id'])
                            ->get('sponsor_master');

                            if($res_chk_sponsor->num_rows()>0){

                                foreach($res_chk_sponsor->result_array() as $key=>$value){

                                 //var_dump($value); die();
                                $html='

                                        <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewsponsorship/'.$value['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                        <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/allotmissionsponsor/'.$value1['id'].'"><i class="fa fa-check" aria-hidden="true"></i></a>';

                                        if(isset($staff_res_chk[$key]['id']))
                                        {

                                             $result[]=array('id'=>$value1['id'], 'sponser_id'=>$value1['sponsor_id'], 'staffid'=>$staff_res_chk[$key]['id'], 'sponser_name'=>$value['sponser_name'], 'sponsor_amount'=>$sponsorship['sponser_amount'],'sponser_promo_office'=>$value['promo_office_name'],'sponser_country_id'=>$value['country_name'],'sponser_phone'=>$value['sponser_phone'],'sponsor_district'=>$value['sponsor_district'],'sponser_state'=>$value['state_zone_name'],'sponser_city_town_place'=>$value['sponser_city_town_place'],'sponser_pin'=>$value['sponser_pin'], 'sponser_sadmin_approve_date'=>$value['sponser_sadmin_approve_date'], 
                                                'created_at'=>$value1['created_at'],
                                                'staff_missionary_name'=>$staff_res_chk[$key]['staff_name'], 'crn_no'=>$staff_res_chk[$key]['staff_cross_ref_number'], 'zone_name'=>$staff_res_chk[$key]['staff_zone_name'], 'emp_id'=>$staff_res_chk[$key]['staff_employee_id'], 'sponsor_count'=>$staff_res_chk[$key]['sponsor_count'], 'action'=>$html);
                                        }


                                   }
                                   
                                }     

                             }   


                 }   

                
            
            }
        }else{
            $response['status']="failure";
            $response['message']="No staff list found!!..";
        }
        
        $response['result']=$result;
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    public function get_approve_revert_child_list(){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $result=array();
        $html="";
           global $api_path;

          $res=$this->db->select("revert_child.id, missionary_id, sponsor_id, reason, created_at, created_by, sdmin_approve, sdmin_approve_date, sdmin_approved_by")
            ->order_by('revert_child.id', 'desc')
            ->where('sdmin_approve', '0')
            ->get('revert_child');    

        //var_dump($res); die();
        
        if($res->num_rows()>0){

            global $missionaryallotstatus, $api_path;

            foreach($res->result_array() as $key=>$value1){


                   $res_chk=$this->db->select("sponsorship_master.id, sponsor_group_id, category_sponsorship, sponser_amount")
                            ->order_by('sponsorship_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsorship_master.id', $value1['sponsor_id'])
                            ->get('sponsorship_master');          
                

                         $child_res_chk=$this->db->select("staff_children.id, staff_id, children_name, cross_ref_no, staff_zone_id, zones_staff_master.staff_zone_name, sponsor_count")
                            ->join('zones_staff_master', 'staff_children.staff_zone_id=zones_staff_master.id', 'left')
                            ->where('staff_children.id', $value1['missionary_id'])
                            ->get('staff_children');          
                        $child_res_chk = $child_res_chk->result_array();


                if($res_chk->num_rows()>0){

                    foreach($res_chk->result_array() as $key=>$sponsorship){


                         $res_chk_sponsor=$this->db->select("sponsor_master.id, sponser_name, promotional_office_master.promo_office_name, sponser_country_id, sponser_promo_office, country.country_name, sponser_phone, sponsor_district, state_zone_master.state_zone_name, sponser_city_town_place, sponser_pin, DATE_FORMAT(sponser_sadmin_approve_date,'%d/%m/%Y')as sponser_sadmin_approve_date, sponser_missionary_preference, sponsor_allot_mission_status")
                            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left')
                            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
                            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
                            ->order_by('sponsor_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsor_master.id', $sponsorship['sponsor_group_id'])
                            ->get('sponsor_master');

                            if($res_chk_sponsor->num_rows()>0){

                                foreach($res_chk_sponsor->result_array() as $key=>$value){

                                 //var_dump($value); die();
                                $html='

                                        <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewsponsorship/'.$value['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                        <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/allotmissionsponsor/'.$value1['id'].'"><i class="fa fa-check" aria-hidden="true"></i></a>';

                                        if(isset($child_res_chk[$key]['id']))
                                        {

                                            $result[]=array('id'=>$value1['id'], 'sponser_id'=>$value1['sponsor_id'], 'staffid'=>$child_res_chk[$key]['id'], 'sponser_name'=>$value['sponser_name'], 'sponsor_amount'=>$sponsorship['sponser_amount'],'sponser_promo_office'=>$value['promo_office_name'],'sponser_country_id'=>$value['country_name'],'sponser_phone'=>$value['sponser_phone'],'sponsor_district'=>$value['sponsor_district'],'sponser_state'=>$value['state_zone_name'],'sponser_city_town_place'=>$value['sponser_city_town_place'],'sponser_pin'=>$value['sponser_pin'], 'sponser_sadmin_approve_date'=>$value['sponser_sadmin_approve_date'], 'staff_missionary_name'=>$child_res_chk[$key]['children_name'], 'staffid'=>$child_res_chk[$key]['id'], 'crn_no'=>$child_res_chk[$key]['cross_ref_no'], 'zone_name'=>$child_res_chk[$key]['staff_zone_name'], 'sponsor_count'=>$child_res_chk[$key]['sponsor_count'], 'action'=>$html);
                                        }


                                   }
                                   
                                }     

                             }   


                 }   

                
            
            }
        }else{
            $response['status']="failure";
            $response['message']="No staff list found!!..";
        }
        
        $response['result']=$result;
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    public function gems_approve_revert_sponsorship() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        $staff_ids = $model->selectedstaff;

        //var_dump($model); die();

        if (is_array($staff_ids) && count($staff_ids)>0) {
            
            $success_count = 0;
            foreach ($staff_ids as $staff_id) {

                $revert_sponsor_data=$this->db->select("id, sponsor_id")
                            ->where('id', $staff_id)
                            ->get('revert_sponsorship');

                    $revert_result = $revert_sponsor_data->result_array();



                 if($revert_sponsor_data->num_rows()>0){


                    $sponsorship_data=$this->db->select("id, sponsor_group_id")
                            ->where('id', $revert_result[0]['sponsor_id'])
                            ->get('sponsorship_master');

                            $sponsorship_result = $sponsorship_data->result_array();

                        if($sponsorship_data->num_rows()>0){

                          //  var_dump($sponsorship_data->result_array()); die();


                            $data = array('sponsor_allot_mission_status' => '3');
                            $this->db->where('id', $sponsorship_result[0]['sponsor_group_id']);
                            $result1=$this->db->update('sponsor_master', $data);

                            $data = array('sponsor_allot_mission_status' => '3');
                            $this->db->where('id', $sponsorship_result[0]['id']);
                            $result2=$this->db->update('sponsorship_master', $data);
                        }

                 }        


                $data = array('sdmin_approve' => '1', 'sdmin_approve_date' =>date('Y-m-d H:i:s'), 'sdmin_approved_by' => '1');
                $this->db->where('id', $staff_id);
                $result=$this->db->update('revert_sponsorship', $data);


                if ($result) {
                    $response['message']="Revert Sponsorship Approved status has been updated successfully";
                }
                else
                {
                     $response['status']="failure";
                $response['message']="Revert Sponsorship Approved status has not been updated fully";
                }
            }

        } else {
            $response['status']="failure";
            $response['message']="Choose Sponsorship and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


    public function gems_approve_revert_child_sponsorship() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        $staff_ids = $model->selectedstaff;

        

        if (is_array($staff_ids) && count($staff_ids)>0) {
            
            $success_count = 0;
            foreach ($staff_ids as $staff_id) {


                $data = array('sdmin_approve' => '1', 'sdmin_approve_date' =>date('Y-m-d H:i:s'), 'sdmin_approved_by' => '1');
                $this->db->where('missionary_id', $staff_id);
                $result=$this->db->update('revert_child', $data);

                             $revertchild_result=$this->db->select("id, sponsor_id")
                            ->where('missionary_id', $staff_id)
                            ->get('revert_child');

                            if($revertchild_result->num_rows()>0){

                                $revertchild_data = $revertchild_result->result_array();

                                $sponsorship_data=$this->db->select("id, sponsor_group_id")
                                ->where('id', $revertchild_data[0]['sponsor_id'])
                                ->get('sponsorship_master');

                                $sponsorship_result = $sponsorship_data->result_array();

                                if($sponsorship_data->num_rows()>0){

                                  //  var_dump($sponsorship_data->result_array()); die();


                                    $data = array('sponsor_allot_mission_status' => '3');
                                    $this->db->where('id', $sponsorship_result[0]['sponsor_group_id']);
                                    $result1=$this->db->update('sponsor_master', $data);

                                    $data = array('sponsor_allot_mission_status' => '3');
                                    $this->db->where('id', $sponsorship_result[0]['id']);
                                    $result2=$this->db->update('sponsorship_master', $data);
                                }


                            }



                            

                if ($result) {
                    $response['message']="Revert Sponsorship Approved status has been updated successfully";
                }
                else
                {
                     $response['status']="failure";
                $response['message']="Revert Sponsorship Approved status has not been updated fully";
                }
            }

        } else {
            $response['status']="failure";
            $response['message']="Choose Sponsorship and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


    public function gems_revoke_revert_sponsorship() {
         $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        $staff_ids = $model->selectedstaff;

        

        if (is_array($staff_ids) && count($staff_ids)>0) {
            
            $success_count = 0;
            foreach ($staff_ids as $staff_id) {

                 $res=$this->db->select("missionary_id, sponsor_id")
                        ->where('id', $staff_id)
                        ->get('revert_sponsorship');

                   // var_dump($res); die();

                 if($res->num_rows()>0) {

                    foreach($res->result_array() as $key=>$value) {

                        $data = array('revert_sponsorship' => '0');
                        $this->db->where('missionary_emp_id', $value['missionary_id']);
                        $this->db->where('sponsor_id', $value['sponsor_id']);
                        $result=$this->db->update('allot_missionary', $data);

                        //var_dump($value); die();

                         $this->db->query("delete from ".$this->db->dbprefix('revert_sponsorship')."  where id='".$staff_id."'");
                         $response['status']="success";
                         $response['message']="Revert sponsorship record has been deleted successfully";
                        

                        }

                    }

            }

        } else {
            $response['status']="failure";
            $response['message']="Choose sponsorship and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


    public function gems_revoke_revert_child_sponsorship() {
         $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        $staff_ids = $model->selectedstaff;

        

        if (is_array($staff_ids) && count($staff_ids)>0) {
            
            $success_count = 0;
            foreach ($staff_ids as $staff_id) {

                 $res=$this->db->select("missionary_id, sponsor_id")
                        ->where('id', $staff_id)
                        ->get('revert_child');

                   // var_dump($res); die();

                 if($res->num_rows()>0) {

                    foreach($res->result_array() as $key=>$value) {

                        $data = array('revert_sponsorship' => '0');
                        $this->db->where('missionary_emp_id', $value['missionary_id']);
                        $this->db->where('sponsor_id', $value['sponsor_id']);
                        $result=$this->db->update('allot_child', $data);

                        //var_dump($value); die();

                         $this->db->query("delete from ".$this->db->dbprefix('revert_child')."  where id='".$staff_id."'");
                         $response['status']="success";
                         $response['message']="Revert sponsorship record has been deleted successfully";
                        

                        }

                    }

            }

        } else {
            $response['status']="failure";
            $response['message']="Choose sponsorship and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


    public function get_approved_revert_sponsorship_list(){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $result=array();
        $html="";
           global $api_path;

          $res=$this->db->select("revert_sponsorship.id, missionary_id, sponsor_id, reason, DATE_FORMAT(created_at,'%d/%m/%Y') as created_at, created_by, sdmin_approve, DATE_FORMAT(sdmin_approve_date,'%d/%m/%Y')as sdmin_approve_date, sdmin_approved_by")
            ->order_by('revert_sponsorship.id', 'desc')
            ->where('sdmin_approve', '1')
            ->get('revert_sponsorship');    

        //var_dump($res); die();
        
        if($res->num_rows()>0){

            global $missionaryallotstatus, $api_path;

            foreach($res->result_array() as $key=>$value1){


                   $res_chk=$this->db->select("sponsorship_master.id, sponsor_group_id, category_sponsorship, sponser_amount")
                            ->order_by('sponsorship_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsorship_master.id', $value1['sponsor_id'])
                            ->get('sponsorship_master');          
                

                  $staff_res_chk=$this->db->select("staff_master.id, staff_employee_id, staff_name,  staff_cross_ref_number, zone_id, zones_staff_master.staff_zone_name, sponsor_count")
                            ->join('zones_staff_master', 'staff_master.zone_id=zones_staff_master.id', 'left')
                            ->where('staff_delete_status', '0')
                            ->where('staff_employee_id', $value1['missionary_id'])
                            ->get('staff_master');          
                $staff_res_chk = $staff_res_chk->result_array();
                   //var_dump($staff_res_chk->result_array()); die();
                if($res_chk->num_rows()>0){

                    foreach($res_chk->result_array() as $key=>$sponsorship){


                         $res_chk_sponsor=$this->db->select("sponsor_master.id, sponser_name, promotional_office_master.promo_office_name, sponser_country_id, sponser_promo_office, country.country_name, sponser_phone, sponsor_district, state_zone_master.state_zone_name, sponser_city_town_place, sponser_pin, DATE_FORMAT(sponser_sadmin_approve_date,'%d/%m/%Y')as sponser_sadmin_approve_date, sponser_missionary_preference, sponsor_allot_mission_status")
                            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left')
                            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
                            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
                            ->order_by('sponsor_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsor_master.id', $sponsorship['sponsor_group_id'])
                            ->get('sponsor_master');

                            if($res_chk_sponsor->num_rows()>0){

                                foreach($res_chk_sponsor->result_array() as $key=>$value){

                                 //var_dump($value); die();
                                $html='

                                        <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewsponsorship/'.$value['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                        <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/allotmissionsponsor/'.$value1['id'].'"><i class="fa fa-check" aria-hidden="true"></i></a>';

                                        if(isset($staff_res_chk[$key]['id']))
                                        {
                                        $result[]=array('id'=>$value1['id'], 'sponser_id'=>$value1['sponsor_id'], 'staffid'=>$staff_res_chk[$key]['id'], 'sponser_name'=>$value['sponser_name'], 'sponsor_amount'=>$sponsorship['sponser_amount'],'sponser_promo_office'=>$value['promo_office_name'],'sponser_country_id'=>$value['country_name'],'sponser_phone'=>$value['sponser_phone'],'sponsor_district'=>$value['sponsor_district'],'sponser_state'=>$value['state_zone_name'],'sponser_city_town_place'=>$value['sponser_city_town_place'],'sponser_pin'=>$value['sponser_pin'], 'admin_allot_approve_date'=>$value1['sdmin_approve_date'], 
                                            'created_at'=>$value1['created_at'],
                                            'staff_missionary_name'=>$staff_res_chk[$key]['staff_name'], 'crn_no'=>$staff_res_chk[$key]['staff_cross_ref_number'], 'zone_name'=>$staff_res_chk[$key]['staff_zone_name'], 'emp_id'=>$staff_res_chk[$key]['staff_employee_id'], 'sponsor_count'=>$staff_res_chk[$key]['sponsor_count'], 'action'=>$html);
                                        	
                                        }


                                   }
                                   
                                }     

                             }   


                 }   

                
            
            }
        }else{
            $response['status']="failure";
            $response['message']="No staff list found!!..";
        }
        
        $response['result']=$result;
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


    public function get_approved_revert_child_sponsorship_list(){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $result=array();
        $html="";
           global $api_path;

          $res=$this->db->select("revert_child.id, missionary_id, sponsor_id, reason, created_at, created_by, sdmin_approve, DATE_FORMAT(sdmin_approve_date,'%d/%m/%Y')as sdmin_approve_date, sdmin_approved_by")
            ->order_by('revert_child.id', 'desc')
            ->where('sdmin_approve', '1')
            ->get('revert_child');    

        //var_dump($res); die();
        
        if($res->num_rows()>0){

            global $missionaryallotstatus, $api_path;

            foreach($res->result_array() as $key=>$value1){


                   $res_chk=$this->db->select("sponsorship_master.id, sponsor_group_id, category_sponsorship, sponser_amount")
                            ->order_by('sponsorship_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsorship_master.id', $value1['sponsor_id'])
                            ->get('sponsorship_master');          
                

                //   $staff_res_chk=$this->db->select("staff_master.id, staff_employee_id, staff_name,  staff_cross_ref_number, zone_id, zones_staff_master.staff_zone_name, sponsor_count")
                //             ->join('zones_staff_master', 'staff_master.zone_id=zones_staff_master.id', 'left')
                //             ->where('staff_delete_status', '0')
                //             ->where('staff_employee_id', $value1['missionary_id'])
                //             ->get('staff_master');          
                // $staff_res_chk = $staff_res_chk->result_array();
                   //var_dump($staff_res_chk->result_array()); die();

                    $child_res_chk=$this->db->select("staff_children.id, staff_id, children_name, cross_ref_no, staff_zone_id, zones_staff_master.staff_zone_name, sponsor_count")
                            ->join('zones_staff_master', 'staff_children.staff_zone_id=zones_staff_master.id', 'left')
                            ->where('staff_children.id', $value1['missionary_id'])
                            ->get('staff_children');          
                        $child_res_chk = $child_res_chk->result_array();


                if($res_chk->num_rows()>0){

                    foreach($res_chk->result_array() as $key=>$sponsorship){


                         $res_chk_sponsor=$this->db->select("sponsor_master.id, sponser_name, promotional_office_master.promo_office_name, sponser_country_id, sponser_promo_office, country.country_name, sponser_phone, sponsor_district, state_zone_master.state_zone_name, sponser_city_town_place, sponser_pin, DATE_FORMAT(sponser_sadmin_approve_date,'%d/%m/%Y')as sponser_sadmin_approve_date, sponser_missionary_preference, sponsor_allot_mission_status")
                            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left')
                            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
                            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
                            ->order_by('sponsor_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsor_master.id', $sponsorship['sponsor_group_id'])
                            ->get('sponsor_master');

                            if($res_chk_sponsor->num_rows()>0){

                                foreach($res_chk_sponsor->result_array() as $key=>$value){

                                 //var_dump($value); die();
                                $html='

                                        <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewsponsorship/'.$value['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                        <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/allotmissionsponsor/'.$value1['id'].'"><i class="fa fa-check" aria-hidden="true"></i></a>';

                                        if(isset($child_res_chk[$key]['id']))
                                        {

                                            $result[]=array('id'=>$value1['id'], 'sponser_id'=>$value1['sponsor_id'], 'sponser_name'=>$value['sponser_name'], 'sponsor_amount'=>$sponsorship['sponser_amount'],'sponser_promo_office'=>$value['promo_office_name'],'sponser_country_id'=>$value['country_name'],'sponser_phone'=>$value['sponser_phone'],'sponsor_district'=>$value['sponsor_district'],'sponser_state'=>$value['state_zone_name'],'sponser_city_town_place'=>$value['sponser_city_town_place'],'sponser_pin'=>$value['sponser_pin'], 'admin_allot_approve_date'=>$value1['sdmin_approve_date'], 'staff_missionary_name'=>$child_res_chk[$key]['children_name'], 'staffid'=>$child_res_chk[$key]['id'], 'crn_no'=>$child_res_chk[$key]['cross_ref_no'], 'zone_name'=>$child_res_chk[$key]['staff_zone_name'], 'sponsor_count'=>$child_res_chk[$key]['sponsor_count'], 'action'=>$html);
                                        }


                                   }
                                   
                                }     

                             }   


                 }   

                
            
            }
        }else{
            $response['status']="failure";
            $response['message']="No staff list found!!..";
        }
        
        $response['result']=$result;
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


    public function get_reallot_missionary_master_list(){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $result=array();
        $html="";
           global $api_path;
    

        $res=$this->db->select("allot_missionary.id, missionary_emp_id, sponsor_id, allotment_reallotment, DATE_FORMAT(admin_allot_approve_date,'%d/%m/%Y')as admin_allot_approve_date, withdrawl_status, sadmin_allot_approve")
            ->order_by('allot_missionary.id', 'desc')
            ->where('sadmin_allot_approve', '1')
            ->where('allotment_reallotment', 'A')
            ->get('allot_missionary');

         
        
         if($res->num_rows()>0){

            global $missionaryallotstatus, $api_path;

            foreach($res->result_array() as $key=>$value1){


                   $res_chk=$this->db->select("sponsorship_master.id, sponsor_group_id, category_sponsorship, sponser_amount, sponsor_allot_mission_status")
                            ->order_by('sponsorship_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsor_allot_mission_status', '3')
                            ->where('sponsorship_master.id', $value1['sponsor_id'])
                            ->get('sponsorship_master');          
                

                  $staff_res_chk=$this->db->select("staff_master.id, staff_employee_id, staff_name,  staff_cross_ref_number, zone_id, zones_staff_master.staff_zone_name, sponsor_count")
                            ->join('zones_staff_master', 'staff_master.zone_id=zones_staff_master.id', 'left')
                            ->where('staff_delete_status', '0')
                            ->where('staff_employee_id', $value1['missionary_emp_id'])
                            ->get('staff_master');          
                $staff_res_chk = $staff_res_chk->result_array();
                   //var_dump($staff_res_chk->result_array()); die();
                if($res_chk->num_rows()>0){

                    foreach($res_chk->result_array() as $key=>$sponsorship){

                            if(isset($sponsorship['sponsor_allot_mission_status']))
                            {
                                $sponsorship['sponsor_allot_mission_status'] = $missionaryallotstatus[$sponsorship['sponsor_allot_mission_status']];
                            }


                         $res_chk_sponsor=$this->db->select("sponsor_master.id, sponser_name, promotional_office_master.promo_office_name, sponser_country_id, sponser_promo_office, country.country_name, sponser_phone, sponsor_district, state_zone_master.state_zone_name, sponser_city_town_place, sponser_pin, DATE_FORMAT(sponser_sadmin_approve_date,'%d/%m/%Y')as sponser_sadmin_approve_date, sponser_missionary_preference, sponsor_allot_mission_status,DATE_FORMAT(created_at,'%d/%m/%Y') as created_at")
                            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left')
                            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
                            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
                            ->order_by('sponsor_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsor_allot_mission_status', '3')
                            ->where('sponsor_master.id', $sponsorship['sponsor_group_id'])
                            ->get('sponsor_master');

                            if($res_chk_sponsor->num_rows()>0){

                                foreach($res_chk_sponsor->result_array() as $key=>$value){

                                 //var_dump($value); die();
                                $html='

                                        <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewsponsorship/'.$value['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                        <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/reallotmissionsponsor/'.$value1['sponsor_id'].'"><i class="fa fa-check" aria-hidden="true"></i></a>';

                                        if(isset($staff_res_chk[$key]['staff_name']))
                                        {

                                       		 $result[]=array('id'=>$value1['sponsor_id'],'sponser_name'=>$value['sponser_name'], 'sponsor_allot_mission_status'=>$sponsorship['sponsor_allot_mission_status'],'sponsor_amount'=>$sponsorship['sponser_amount'],'sponser_promo_office'=>$value['promo_office_name'],'sponser_country_id'=>$value['country_name'],'sponser_phone'=>$value['sponser_phone'],'sponsor_district'=>$value['sponsor_district'],'sponser_state'=>$value['state_zone_name'],'sponser_city_town_place'=>$value['sponser_city_town_place'],'sponser_pin'=>$value['sponser_pin'], 'admin_allot_approve_date'=>$value1['sadmin_allot_approve'], 
                                                'created_at'=>$value['created_at'],
                                                'staff_missionary_name'=>$staff_res_chk[$key]['staff_name'], 'crn_no'=>$staff_res_chk[$key]['staff_cross_ref_number'], 'zone_name'=>$staff_res_chk[$key]['staff_zone_name'], 'emp_id'=>$staff_res_chk[$key]['staff_employee_id'], 'sponsor_count'=>$staff_res_chk[$key]['sponsor_count'], 'action'=>$html);
                                        }


                                   }
                                   
                                }     

                             }   


                 }   

                
            
            }
        }else{
            $response['status']="failure";
            $response['message']="No staff list found!!..";
        }
        
        $response['result']=$result;
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


    public function get_reallot_child_master_list(){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $result=array();
        $html="";
           global $api_path;

        $res=$this->db->select("allot_child.id, missionary_emp_id, sponsor_id, allotment_reallotment, DATE_FORMAT(admin_allot_approve_date,'%d/%m/%Y')as admin_allot_approve_date, withdrawl_status, sadmin_allot_approve")
            ->order_by('allot_child.id', 'desc')
            ->where('sadmin_allot_approve', '1')
            ->where('allotment_reallotment', 'A')
            ->get('allot_child');

        //var_dump($res); die();
        
         if($res->num_rows()>0){

            global $missionaryallotstatus, $api_path;

            foreach($res->result_array() as $key=>$value1){


                   $res_chk=$this->db->select("sponsorship_master.id, sponsor_group_id, category_sponsorship, sponser_amount, sponsor_allot_mission_status")
                            ->order_by('sponsorship_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsor_allot_mission_status', '3')
                            ->where('sponsorship_master.id', $value1['sponsor_id'])
                            ->get('sponsorship_master');          
                

                    $child_res_chk=$this->db->select("staff_children.id, staff_id, children_name, cross_ref_no, staff_zone_id, zones_staff_master.staff_zone_name, sponsor_count")
                            ->join('zones_staff_master', 'staff_children.staff_zone_id=zones_staff_master.id', 'left')
                            ->where('staff_children.id', $value1['missionary_emp_id'])
                            ->get('staff_children');          
                        $child_res_chk = $child_res_chk->result_array();


                if($res_chk->num_rows()>0){

                    foreach($res_chk->result_array() as $key=>$sponsorship){


                         $res_chk_sponsor=$this->db->select("sponsor_master.id, sponser_name, promotional_office_master.promo_office_name, sponser_country_id, sponser_promo_office, country.country_name, sponser_phone, sponsor_district, state_zone_master.state_zone_name, sponser_city_town_place, sponser_pin, DATE_FORMAT(sponser_sadmin_approve_date,'%d/%m/%Y')as sponser_sadmin_approve_date, sponser_missionary_preference, sponsor_allot_mission_status")
                            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left')
                            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
                            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
                            ->order_by('sponsor_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsor_allot_mission_status', '3')
                            ->where('sponsor_master.id', $sponsorship['sponsor_group_id'])
                            ->get('sponsor_master');

                            if($res_chk_sponsor->num_rows()>0){

                                foreach($res_chk_sponsor->result_array() as $key=>$value){


                                    if(isset($sponsorship['sponsor_allot_mission_status']))
                                    {
                                        $sponsorship['sponsor_allot_mission_status'] = $missionaryallotstatus[$sponsorship['sponsor_allot_mission_status']];
                                    }

                                 //var_dump($value); die();
                                $html='

                                        <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewsponsorship/'.$value1['sponsor_id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                        <a title="Reallot Child" style=" margin-top: 10px;" href="'.$api_path.'/#/reallotchildsponsor/'.$value1['sponsor_id'].'"><i class="fa fa-check" aria-hidden="true"></i></a>';

                                        if(isset($child_res_chk[$key]['id']))
                                        {

                                            $result[]=array('id'=>$value1['sponsor_id'],'sponser_name'=>$value['sponser_name'], 'sponsor_allot_mission_status'=>$sponsorship['sponsor_allot_mission_status'],'sponsor_amount'=>$sponsorship['sponser_amount'],'sponser_promo_office'=>$value['promo_office_name'],'sponser_country_id'=>$value['country_name'],'sponser_phone'=>$value['sponser_phone'],'sponsor_district'=>$value['sponsor_district'],'sponser_state'=>$value['state_zone_name'],'sponser_city_town_place'=>$value['sponser_city_town_place'],'sponser_pin'=>$value['sponser_pin'], 'admin_allot_approve_date'=>$value1['sadmin_allot_approve'], 'staff_missionary_name'=>$child_res_chk[$key]['children_name'], 'staffid'=>$child_res_chk[$key]['id'], 'crn_no'=>$child_res_chk[$key]['cross_ref_no'], 'zone_name'=>$child_res_chk[$key]['staff_zone_name'], 'sponsor_count'=>$child_res_chk[$key]['sponsor_count'], 'action'=>$html);
                                        }


                                   }
                                   
                                }     

                             }   


                 }   

                
            
            }
        }else{
            $response['status']="failure";
            $response['message']="No staff list found!!..";
        }
        
        $response['result']=$result;
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


    public function gems_reallot_mission_sponsorship() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        $staff_ids = $model->selectedstaff;

        

        if (is_array($staff_ids) && count($staff_ids)>0) {
            
            $success_count = 0;
            foreach ($staff_ids as $staff_id) {

                $res=$this->db->select("sponsor_count, id")
                        ->where('staff_employee_id', $staff_id)
                        ->get('staff_master');

                 if($res->num_rows()>0) {

                    foreach($res->result_array() as $key=>$value) {

                        if($value['sponsor_count']!=null)
                        {
                            $value['sponsor_count'] = $value['sponsor_count'] +1;
                        }
                        else
                        {
                            $value['sponsor_count'] = 1;
                        }

                        
                        //var_dump($model->sponsorshipid); die();
                        $data = array('sponsor_count' => $value['sponsor_count']);
                        $this->db->where('id', $value['id']);
                        $result=$this->db->update('staff_master', $data);

                    }

                }

                $this->db->query("insert into ".$this->db->dbprefix('allot_missionary')." (
                        missionary_emp_id,
                        sponsor_id,
                        sponsor_amount,
                        allotment_reallotment,
                        withdrawl_status,
                        sadmin_allot_approve,
                        family_sponsor,
                        missionary_withdrawal
                            ) values (
                                '".$staff_id."',
                                '".$model->sponsorshipid."',
                                '".$model->sponsor_amount."',
                                'R',
                                'N',
                                '0',
                                '".$model->family_id."',
                                '0'
                                )");

                if($this->db->insert_id()){
                    $response['result']=array('id'=>$this->db->insert_id());
                    $response['message']="Allot missionary record stored successfully";
                }else{
                    $response['status']="failure";            
                    $response['message']="Sorry!!, Unable to insert the Allot Missionary data";
                }

                if ($result) {
                    $success_count++;
                }
            }

            $data = array('sponsor_allot_mission_status' => '1');
            $this->db->where('id', $model->sponsorid);
            $result1=$this->db->update('sponsor_master', $data);

            $data = array('sponsor_allot_mission_status' => '1');
            $this->db->where('id', $model->sponsorshipid);
            $result2=$this->db->update('sponsorship_master', $data);


            

            if (count($staff_ids)==$success_count) {
                $response['message']="Sponsor allotted status has been updated successfully";
            } else {
                $response['status']="failure";
                $response['message']="Sponsor allotted status has not been updated fully";
            }
        } else {
            $response['status']="failure";
            $response['message']="Choose staff and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


     public function gems_reallot_child_sponsorship() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        $staff_ids = $model->selectedstaff;

        

        if (is_array($staff_ids) && count($staff_ids)>0) {
            
            $success_count = 0;
            foreach ($staff_ids as $staff_id) {

                $res=$this->db->select("sponsor_count, id")
                        ->where('staff_employee_id', $staff_id)
                        ->get('staff_master');

                 if($res->num_rows()>0) {

                    foreach($res->result_array() as $key=>$value) {

                        if($value['sponsor_count']!=null)
                        {
                            $value['sponsor_count'] = $value['sponsor_count'] +1;
                        }
                        else
                        {
                            $value['sponsor_count'] = 1;
                        }

                        
                        //var_dump($model->sponsorshipid); die();
                        $data = array('sponsor_count' => $value['sponsor_count']);
                        $this->db->where('id', $value['id']);
                        $result=$this->db->update('staff_master', $data);

                    }

                }

                $this->db->query("insert into ".$this->db->dbprefix('allot_child')." (
                        missionary_emp_id,
                        sponsor_id,
                        sponsor_amount,
                        allotment_reallotment,
                        withdrawl_status,
                        sadmin_allot_approve,
                        missionary_withdrawal
                            ) values (
                                '".$staff_id."',
                                '".$model->sponsorshipid."',
                                '".$model->sponsor_amount."',
                                'R',
                                'N',
                                '0',
                                '0'
                                )");

                if($this->db->insert_id()){
                    $response['result']=array('id'=>$this->db->insert_id());
                    $response['message']="Allot Child record stored successfully";
                }else{
                    $response['status']="failure";            
                    $response['message']="Sorry!!, Unable to insert the Allot Child data";
                }

                if ($response['result']) {
                    $success_count++;
                }
            }

            $data = array('sponsor_allot_mission_status' => '1');
            $this->db->where('id', $model->sponsorid);
            $result1=$this->db->update('sponsor_master', $data);

            $data = array('sponsor_allot_mission_status' => '1');
            $this->db->where('id', $model->sponsorshipid);
            $result2=$this->db->update('sponsorship_master', $data);


            

            if (count($staff_ids)==$success_count) {
                $response['message']="Sponsor allotted status has been updated successfully";
            } else {
                $response['status']="failure";
                $response['message']="Sponsor allotted status has not been updated fully";
            }
        } else {
            $response['status']="failure";
            $response['message']="Choose staff and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


    public function get_staff_reallot_selection_list(){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $result=array();

        $model = json_decode($this->input->post('model',FALSE));

        $html="";

        //var_dump($model); die();
        
        global $api_path;

        if($model!=''){

            
            $res=$this->db->select("staff_master.id, staff_cross_ref_number, sponsor_count, staff_master.region_id, zone_id, staff_gender, staff_dedication_status, staff_employee_id, staff_name, zones_staff_master.staff_zone_name, place_present, staff_category_master.staff_category_name, DATE_FORMAT(relieved_date,'%d/%m/%Y')as relieved_date, DATE_FORMAT(staff_sdamin_approve_date,'%d/%m/%Y')as approve_date")
            ->join('staff_category_master', 'staff_master.staff_category_id=staff_category_master.id', 'left')
            ->join('zones_staff_master', 'staff_master.zone_id=zones_staff_master.id', 'left')
            ->order_by('staff_master.id', 'desc')
            ->where('staff_master.staff_relief_status','NR');


            if(isset($model->state))
            {   
                
               $res->where('staff_master.place_state',$model->state);
            }
             if(isset($model->sponser_dedication_needed))
            {   
                
               $res->where('staff_master.staff_dedication_status',$model->sponser_dedication_needed);
            }
            if(isset($model->zone))
            {
                $res->where('staff_master.zone_id',$model->zone);
            }
            if(isset($model->gender))
            {
                $res->where('staff_master.staff_gender',$model->gender);
            }
            if(isset($model->family_id))
            {
                $res->where('staff_master.allowed_sponsor_allotment',$model->family_id);
            }
            
            $res=$res->where('staff_delete_status', '0')
            ->get('staff_master');
        //var_dump($res); die();
        if($res->num_rows()>0){
            global $gender, $api_path;
            
                $temp_arr = array();

                foreach ($res->row() as $key => $value) {

                    if ($key=="staff_gender") {

                        $temp_arr[$key]=isset($gender[$value])?$gender[$value]:'-';
                        //var_dump($temp_arr); die();
                    }

                }
               // $response['result']=$temp_arr;
                

                
            foreach($res->result_array() as $key=>$value){
               // var_dump($result); die();

                $result[]=array('id'=>$value['id'],'staff_cross_ref_number'=>$value['staff_cross_ref_number'],'zone_id'=>$value['staff_zone_name'], 'staff_gender'=>$temp_arr['staff_gender'], 'staff_dedication_status'=>$value['staff_dedication_status'], 'staff_employee_id'=>$value['staff_employee_id'],'staff_name'=>$value['staff_name'], 'sponsor_count'=>$value['sponsor_count'],'staff_zone_name'=>$value['staff_zone_name'],'place_present'=>$value['place_present'],'staff_category_name'=>$value['staff_category_name'],'relieved_date'=>$value['relieved_date'], 'sponsor_detail'=>$model->id, 'approve_date'=>$value['approve_date']);
            
            }
        }else{
            $response['status']="failure";
            $response['message']="No staff list found!!..";
        }
        
        $response['result']=$result;
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
        }
        
        
    }


     public function get_reallot_missionary_approve_list(){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $result=array();
        $html="";
           global $api_path;
        

          $res=$this->db->select("allot_missionary.id, missionary_emp_id, sponsor_id, sponsor_amount, allotment_reallotment, withdrawl_status, sadmin_allot_approve, admin_allot_approve_date, family_sponsor, admin_allot_approved_by, missionary_withdrawal")
            ->order_by('allot_missionary.id', 'desc')
            ->where('allotment_reallotment', 'R')
            ->where('sadmin_allot_approve', '0')
            ->get('allot_missionary');  

        // var_dump($res); die();
        
        if($res->num_rows()>0){

            global $missionaryallotstatus, $api_path;

            foreach($res->result_array() as $key=>$value1){

                 $res_chk=$this->db->select("sponsorship_master.id, sponsor_group_id, category_sponsorship, sponser_amount")
                            ->order_by('sponsorship_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsorship_master.id', $value1['sponsor_id'])
                            ->get('sponsorship_master');  

                  $staff_res_chk=$this->db->select("staff_master.id, staff_employee_id, staff_name,  staff_cross_ref_number, zone_id, zones_staff_master.staff_zone_name, sponsor_count")
                            ->join('zones_staff_master', 'staff_master.zone_id=zones_staff_master.id', 'left')
                            ->where('staff_delete_status', '0')
                            ->where('staff_employee_id', $value1['missionary_emp_id'])
                            ->get('staff_master');          
                $staff_res_chk = $staff_res_chk->result_array();
                   //var_dump($staff_res_chk->result_array()); die();
                if($res_chk->num_rows()>0){

                    foreach($res_chk->result_array() as $key=>$sponsorship){


                         //var_dump($value); die();

                         $res_chk_sponsor=$this->db->select("sponsor_master.id, sponser_name, promotional_office_master.promo_office_name, sponser_country_id, sponser_promo_office, country.country_name, sponser_phone, sponsor_district, state_zone_master.state_zone_name, sponser_city_town_place, sponser_pin, DATE_FORMAT(sponser_sadmin_approve_date,'%d/%m/%Y')as sponser_sadmin_approve_date, sponser_missionary_preference, sponsor_allot_mission_status,DATE_FORMAT(created_at,'%d/%m/%Y') as created_at")
                            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left')
                            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
                            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
                            ->order_by('sponsor_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsor_master.id', $sponsorship['sponsor_group_id'])
                            ->get('sponsor_master');

                            if($res_chk_sponsor->num_rows()>0){

                                foreach($res_chk_sponsor->result_array() as $key=>$value){

                                $html='

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewsponsorship/'.$value['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/allotmissionsponsor/'.$value1['id'].'"><i class="fa fa-check" aria-hidden="true"></i></a>';

                                if(isset($staff_res_chk[$key]['id']))
                                {

                                    $result[]=array('id'=>$value1['id'], 'sponser_id'=>$value1['sponsor_id'], 'staffid'=>$staff_res_chk[$key]['id'], 'sponser_amount'=>$sponsorship['sponser_amount'], 'sponsership_id'=>$sponsorship['id'], 'sponser_name'=>$value['sponser_name'],'sponser_promo_office'=>$value['promo_office_name'],'sponser_country_id'=>$value['country_name'],'sponser_phone'=>$value['sponser_phone'],'sponsor_district'=>$value['sponsor_district'],'sponser_state'=>$value['state_zone_name'],'sponser_city_town_place'=>$value['sponser_city_town_place'],'sponser_pin'=>$value['sponser_pin'], 'sponser_sadmin_approve_date'=>$value['sponser_sadmin_approve_date'], 'staff_missionary_name'=>$staff_res_chk[$key]['staff_name'], 'crn_no'=>$staff_res_chk[$key]['staff_cross_ref_number'], 'zone_name'=>$staff_res_chk[$key]['staff_zone_name'], 'emp_id'=>$staff_res_chk[$key]['staff_employee_id'], 'sponsor_count'=>$staff_res_chk[$key]['sponsor_count'],
                                        'created_at'=>$value['created_at'], 'action'=>$html);
                                }

                               }
                            }    

                     }   


                 }   

                
            
            }
        }else{
            $response['status']="failure";
            $response['message']="No staff list found!!..";
        }
        
        $response['result']=$result;
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


    public function get_reallot_child_approve_list(){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $result=array();
        $html="";
           global $api_path;
        

          $res=$this->db->select("allot_child.id, missionary_emp_id, sponsor_id, sponsor_amount, allotment_reallotment, withdrawl_status, sadmin_allot_approve, admin_allot_approve_date, admin_allot_approved_by, missionary_withdrawal")
            ->order_by('allot_child.id', 'desc')
            ->where('allotment_reallotment', 'R')
            ->where('sadmin_allot_approve', '0')
            ->get('allot_child');  

        // var_dump($res); die();
        
        if($res->num_rows()>0){

            global $missionaryallotstatus, $api_path;

            foreach($res->result_array() as $key=>$value1){

                 $res_chk=$this->db->select("sponsorship_master.id, sponsor_group_id, category_sponsorship, sponser_amount")
                            ->order_by('sponsorship_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsorship_master.id', $value1['sponsor_id'])
                            ->get('sponsorship_master');  

                //   $staff_res_chk=$this->db->select("staff_master.id, staff_employee_id, staff_name,  staff_cross_ref_number, zone_id, zones_staff_master.staff_zone_name, sponsor_count")
                //             ->join('zones_staff_master', 'staff_master.zone_id=zones_staff_master.id', 'left')
                //             ->where('staff_delete_status', '0')
                //             ->where('staff_employee_id', $value1['missionary_emp_id'])
                //             ->get('staff_master');          
                // $staff_res_chk = $staff_res_chk->result_array();
                   //var_dump($staff_res_chk->result_array()); die();

                     $child_res_chk=$this->db->select("staff_children.id, staff_id, children_name, cross_ref_no, staff_zone_id, zones_staff_master.staff_zone_name, sponsor_count")
                            ->join('zones_staff_master', 'staff_children.staff_zone_id=zones_staff_master.id', 'left')
                            ->where('staff_children.id', $value1['missionary_emp_id'])
                            ->get('staff_children');          
                        $child_res_chk = $child_res_chk->result_array();

                        //var_dump($child_res_chk); die();
                if($res_chk->num_rows()>0){

                    foreach($res_chk->result_array() as $key=>$sponsorship){


                         //var_dump($value); die();

                         $res_chk_sponsor=$this->db->select("sponsor_master.id, sponser_name, promotional_office_master.promo_office_name, sponser_country_id, sponser_promo_office, country.country_name, sponser_phone, sponsor_district, state_zone_master.state_zone_name, sponser_city_town_place, sponser_pin, DATE_FORMAT(sponser_sadmin_approve_date,'%d/%m/%Y')as sponser_sadmin_approve_date, sponser_missionary_preference, sponsor_allot_mission_status")
                            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left')
                            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
                            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
                            ->order_by('sponsor_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsor_master.id', $sponsorship['sponsor_group_id'])
                            ->get('sponsor_master');

                            if($res_chk_sponsor->num_rows()>0){

                                foreach($res_chk_sponsor->result_array() as $key=>$value){

                                $html='

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewsponsorship/'.$value['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/allotmissionsponsor/'.$value1['id'].'"><i class="fa fa-check" aria-hidden="true"></i></a>';

                                if(isset($child_res_chk[$key]['id']))
                                {

                                    $result[]=array('id'=>$value1['id'], 'sponser_id'=>$value1['sponsor_id'], 'sponser_amount'=>$sponsorship['sponser_amount'],'sponser_name'=>$value['sponser_name'],'sponser_promo_office'=>$value['promo_office_name'],'sponser_country_id'=>$value['country_name'],'sponser_phone'=>$value['sponser_phone'],'sponsor_district'=>$value['sponsor_district'],'sponser_state'=>$value['state_zone_name'],'sponser_city_town_place'=>$value['sponser_city_town_place'],'sponser_pin'=>$value['sponser_pin'], 'sponser_sadmin_approve_date'=>$value['sponser_sadmin_approve_date'], 'staff_missionary_name'=>$child_res_chk[$key]['children_name'], 'staffid'=>$child_res_chk[$key]['id'], 'crn_no'=>$child_res_chk[$key]['cross_ref_no'], 'zone_name'=>$child_res_chk[$key]['staff_zone_name'], 'sponsor_count'=>$child_res_chk[$key]['sponsor_count'], 'action'=>$html);
                                }

                               }
                            }    

                     }   


                 }   

                
            
            }
        }else{
            $response['status']="failure";
            $response['message']="No staff list found!!..";
        }
        
        $response['result']=$result;
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


    public function get_reallot_missionary_approved_list(){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $result=array();
        $html="";

          $res=$this->db->select("allot_missionary.id, missionary_emp_id, sponsor_id, sponsor_amount, allotment_reallotment, withdrawl_status, sadmin_allot_approve, DATE_FORMAT(admin_allot_approve_date,'%d/%m/%Y')as admin_allot_approve_date, family_sponsor, admin_allot_approved_by, missionary_withdrawal")
            ->order_by('allot_missionary.id', 'desc')
            ->where('allotment_reallotment', 'R')
            ->where('sadmin_allot_approve', '1')
            ->get('allot_missionary');  

        // var_dump($res); die();
        
        if($res->num_rows()>0){

            global $missionaryallotstatus, $api_path;

            foreach($res->result_array() as $key=>$value1){

                 $res_chk=$this->db->select("sponsorship_master.id, sponsor_group_id, category_sponsorship, sponser_amount")
                            ->order_by('sponsorship_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsorship_master.id', $value1['sponsor_id'])
                            ->get('sponsorship_master');          

                  $staff_res_chk=$this->db->select("staff_master.id, staff_employee_id, staff_name,  staff_cross_ref_number, zone_id, zones_staff_master.staff_zone_name, sponsor_count")
                            ->join('zones_staff_master', 'staff_master.zone_id=zones_staff_master.id', 'left')
                            ->where('staff_delete_status', '0')
                            ->where('staff_employee_id', $value1['missionary_emp_id'])
                            ->get('staff_master');          
                $staff_res_chk = $staff_res_chk->result_array();
                   //var_dump($staff_res_chk->result_array()); die();
                if($res_chk->num_rows()>0){

                    foreach($res_chk->result_array() as $key=>$sponsorship){


                         //var_dump($value); die();

                        $res_chk_sponsor=$this->db->select("sponsor_master.id, sponser_name, promotional_office_master.promo_office_name, sponser_country_id, sponser_promo_office, country.country_name, sponser_phone, sponsor_district, state_zone_master.state_zone_name, sponser_city_town_place, sponser_pin, DATE_FORMAT(sponser_sadmin_approve_date,'%d/%m/%Y')as sponser_sadmin_approve_date, sponser_missionary_preference, sponsor_allot_mission_status,DATE_FORMAT(created_at,'%d/%m/%Y') as created_at")
                            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left')
                            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
                            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
                            ->order_by('sponsor_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsor_master.id', $sponsorship['sponsor_group_id'])
                            ->get('sponsor_master');

                            if($res_chk_sponsor->num_rows()>0){

                                foreach($res_chk_sponsor->result_array() as $key=>$value){


                                $html='

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewsponsorship/'.$value['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/allotmissionsponsor/'.$value1['id'].'"><i class="fa fa-check" aria-hidden="true"></i></a>';

                                if(isset($staff_res_chk[$key]['id']))
                                {

                                    $result[]=array('id'=>$value1['id'], 'sponser_id'=>$value1['sponsor_id'], 'staffid'=>$staff_res_chk[$key]['id'], 'sponser_amount'=>$sponsorship['sponser_amount'],'sponser_name'=>$value['sponser_name'],'sponser_promo_office'=>$value['promo_office_name'],'sponser_country_id'=>$value['country_name'],'sponser_phone'=>$value['sponser_phone'],'sponsor_district'=>$value['sponsor_district'],'sponser_state'=>$value['state_zone_name'],'sponser_city_town_place'=>$value['sponser_city_town_place'],'sponser_pin'=>$value['sponser_pin'], 'admin_allot_approve_date'=>$value1['admin_allot_approve_date'], 'staff_missionary_name'=>$staff_res_chk[$key]['staff_name'], 'crn_no'=>$staff_res_chk[$key]['staff_cross_ref_number'], 'zone_name'=>$staff_res_chk[$key]['staff_zone_name'], 'emp_id'=>$staff_res_chk[$key]['staff_employee_id'], 'sponsor_count'=>$staff_res_chk[$key]['sponsor_count'], 
                                        'created_at'=>$value['created_at'],'action'=>$html);
                                }

                              }
                            }   

                     }   


                 }   

                
            
            }
        }else{
            $response['status']="failure";
            $response['message']="No staff list found!!..";
        }
        
        $response['result']=$result;
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

     public function get_reallot_child_approved_list(){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $result=array();
        $html="";

          $res=$this->db->select("allot_child.id, missionary_emp_id, sponsor_id, sponsor_amount, allotment_reallotment, withdrawl_status, sadmin_allot_approve, DATE_FORMAT(admin_allot_approve_date,'%d/%m/%Y')as admin_allot_approve_date, admin_allot_approved_by, missionary_withdrawal")
            ->order_by('allot_child.id', 'desc')
            ->where('allotment_reallotment', 'R')
            ->where('sadmin_allot_approve', '1')
            ->get('allot_child');  

        //var_dump($res); die();
        
        if($res->num_rows()>0){

            global $missionaryallotstatus, $api_path;

            foreach($res->result_array() as $key=>$value1){

                 $res_chk=$this->db->select("sponsorship_master.id, sponsor_group_id, category_sponsorship, sponser_amount")
                            ->order_by('sponsorship_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsorship_master.id', $value1['sponsor_id'])
                            ->get('sponsorship_master');          

                //   $staff_res_chk=$this->db->select("staff_master.id, staff_employee_id, staff_name,  staff_cross_ref_number, zone_id, zones_staff_master.staff_zone_name, sponsor_count")
                //             ->join('zones_staff_master', 'staff_master.zone_id=zones_staff_master.id', 'left')
                //             ->where('staff_delete_status', '0')
                //             ->where('staff_employee_id', $value1['missionary_emp_id'])
                //             ->get('staff_master');          
                // $staff_res_chk = $staff_res_chk->result_array();
                   //var_dump($staff_res_chk->result_array()); die();

                    $child_res_chk=$this->db->select("staff_children.id, staff_id, children_name, cross_ref_no, staff_zone_id, zones_staff_master.staff_zone_name, sponsor_count")
                            ->join('zones_staff_master', 'staff_children.staff_zone_id=zones_staff_master.id', 'left')
                            ->where('staff_children.id', $value1['missionary_emp_id'])
                            ->get('staff_children');          
                        $child_res_chk = $child_res_chk->result_array();


                if($res_chk->num_rows()>0){

                    foreach($res_chk->result_array() as $key=>$sponsorship){


                         //var_dump($value); die();

                        $res_chk_sponsor=$this->db->select("sponsor_master.id, sponser_name, promotional_office_master.promo_office_name, sponser_country_id, sponser_promo_office, country.country_name, sponser_phone, sponsor_district, state_zone_master.state_zone_name, sponser_city_town_place, sponser_pin, DATE_FORMAT(sponser_sadmin_approve_date,'%d/%m/%Y')as sponser_sadmin_approve_date, sponser_missionary_preference, sponsor_allot_mission_status")
                            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left')
                            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
                            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
                            ->order_by('sponsor_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsor_master.id', $sponsorship['sponsor_group_id'])
                            ->get('sponsor_master');

                            if($res_chk_sponsor->num_rows()>0){

                                foreach($res_chk_sponsor->result_array() as $key=>$value){


                                $html='

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewsponsorship/'.$value['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/reallotchildsponsor/'.$value1['id'].'"><i class="fa fa-check" aria-hidden="true"></i></a>';

                                if(isset($child_res_chk[$key]['id']))
                                {

                                    $result[]=array('id'=>$value1['id'], 'sponser_id'=>$value1['sponsor_id'], 'sponser_amount'=>$sponsorship['sponser_amount'],'sponser_name'=>$value['sponser_name'],'sponser_promo_office'=>$value['promo_office_name'],'sponser_country_id'=>$value['country_name'],'sponser_phone'=>$value['sponser_phone'],'sponsor_district'=>$value['sponsor_district'],'sponser_state'=>$value['state_zone_name'],'sponser_city_town_place'=>$value['sponser_city_town_place'],'sponser_pin'=>$value['sponser_pin'], 'admin_allot_approve_date'=>$value1['admin_allot_approve_date'], 'staff_missionary_name'=>$child_res_chk[$key]['children_name'], 'staffid'=>$child_res_chk[$key]['id'], 'crn_no'=>$child_res_chk[$key]['cross_ref_no'], 'zone_name'=>$child_res_chk[$key]['staff_zone_name'], 'sponsor_count'=>$child_res_chk[$key]['sponsor_count'], 'action'=>$html);
                                }

                              }
                            }   

                     }   


                 }   

                
            
            }
        }else{
            $response['status']="failure";
            $response['message']="No staff list found!!..";
        }
        
        $response['result']=$result;
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    public function gems_create_home_project_master() {

       $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";

        $model = json_decode($this->input->post('model',FALSE));

        //var_dump($model->sponsor_missionary_remarks); die();
        //print_r($model);die();

        if($model!=''){
            
                $this->db->query("insert into ".$this->db->dbprefix('homeprojects_master')." (
                        home_project_number,
                        home_project_name,
                        current_address,
                        mobile_number,
                        name_of_incharge,
                        category,
                        name_of_zone,
                        staff_id,
                        created_by,
                        created_at,
                        is_deleted
                            ) values (
                                '".$model->home_project_number."',
                                '".$model->home_project_name."',
                                '".$model->current_address."',
                                '".$model->mobile_number."',
                                '".$model->name_of_incharge."',
                                '".$model->category."',
                                '".$model->name_of_zone."',
                                '".$model->name_of_staff."',
                                '".$model->created_by."',
                                NOW(),
                                '0'
                                )");

                if($this->db->insert_id()){
                    $response['result']=array('id'=>$this->db->insert_id());
                    $response['message']="home projects data record stored successfully";
                }else{
                    $response['status']="failure";            
                    $response['message']="Sorry!!, Unable to insert the home projects data";
                }
           
            }else{
                    $response['status']="failure";            
                    $response['message']="Sorry!!, Invalid Attempt!!.. Permission denied.";
            }
            echo json_encode($response,JSON_UNESCAPED_SLASHES);
            die();
    }

    public function gems_edit_home_project_master(){
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";

        $resultdata = json_decode($this->input->post('resultdata',FALSE));
        //var_dump($resultdata); die();
        //pr($resultdata);die();
        if($resultdata->id!=""){
           
            $res_chk=$this->db->query("select id from ".$this->db->dbprefix('homeprojects_master')." ");
            if($res_chk->num_rows()>0){

                $data=array('home_project_number'=>$resultdata->home_project_number,
                            'home_project_name'=>$resultdata->home_project_name,
                            'current_address'=>$resultdata->current_address,
                            'mobile_number'=>$resultdata->mobile_number,
                            'name_of_incharge'=>$resultdata->name_of_incharge,
                            'category'=>$resultdata->category,
                            'name_of_zone'=>$resultdata->name_of_zone,
                            'staff_id'=>$resultdata->staff_id
                            );

                $this->db->where('id',$resultdata->id);
                $this->db->update($this->db->dbprefix('homeprojects_master'),$data);
                $response['message']="Home Project record has been updated successfully";
            }
       }else{
            $response['status']="failure";            
            $response['message']="Invalid Attempt!!.. Access denied..";
       }    
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }

    public function get_home_projects_master_list(){
        $this->output->set_content_type('application/json');
        $response=array();
        $html="";
         global $api_path;
        $response['status']="success";
        $result=array();
        $res=$this->db->select("homeprojects_master.id, home_project_number, home_project_name, current_address, mobile_number, name_of_incharge, zones_staff_master.staff_zone_name as name_of_zone, DATE_FORMAT(".$this->db->dbprefix('homeprojects_master').".created_at,'%d/%m/%Y') as created_at,category")
            ->join('zones_staff_master', 'homeprojects_master.name_of_zone=zones_staff_master.id', 'left')
            ->order_by('id desc')
            ->where('is_deleted', '0')
            ->get('homeprojects_master');

       // var_dump($res); die();
        if($res->num_rows()>0){
            foreach($res->result_array() as $key=>$value){

            $html='<a class="btn btn-primary" href="'.$api_path.'/#/edithomeproject/'.$value['id'].'"><i class="glyphicon glyphicon-pencil"></i></a> 

                          <button type="button" class="btn btn-danger button_delete_child"
                                  data-element-id="'.$value['id'].'"><i class="glyphicon glyphicon-trash" data-element-id="'.$value['id'].'"></i></button>';




                $result[]=array('id'=>$value['id'],'home_project_number'=>$value['home_project_number'], 'home_project_name'=>$value['home_project_name'], 'current_address'=>$value['current_address'], 'mobile_number'=>$value['mobile_number'],'name_of_incharge'=>$value['name_of_incharge'],'name_of_zone'=>$value['name_of_zone'],'created_at'=>$value['created_at'],'category'=>($value['category']=='1')?'Home':'Project','action'=>$html);
            }
        }else{
            $response['status']="failure";
            $response['message']="No Home Project list found!!..";
        }
        $response['result']=$result;
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }

    public function gems_fetch_home_project_master($id)
    {
        //var_dump($id); die();
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();

            $res=$this->db->query("select * from ".$this->db->dbprefix('homeprojects_master')." where id='".$id."'");

            if($res->num_rows()>0){
                $in_array=$res->result_array();
                $result=$in_array[0];
            }else{
                $response['status']="failure";
                $response['message']=" No Home Project record found!!";
            }
            $response['result']=$result;

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }

    public function gems_delete_home_project_master($id){
        
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";


        $res_chk=$this->db->query("select id from ".$this->db->dbprefix('homeprojects_master')." where id='".$id."' ");
        
        if($res_chk->num_rows()>0){

            $data=array('is_deleted'=>'1');

            $this->db->set('deleted_at', 'NOW()', FALSE);
            $this->db->where('id',$id);
            $this->db->update($this->db->dbprefix('homeprojects_master'),$data);

            $response['status']="success";
            $response['message']="Home Proejct record has been deleted successfully";
            
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";    
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();        
    }


    public function gems_create_home_project_child_master() {

       $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";

        $model = json_decode($this->input->post('model',FALSE));

        if($model!=''){
            $insert_data=[];

            $check = array(
                'home_project_id',
                'home_project_reg_no',
                'date_of_admission',
                'child_name',
                'child_gender',
                'religion',
                'date_of_birth',
                'child_caste',
                'child_type',
                'father_name',
                'father_alive_or_not',
                'father_year_of_death',
                'father_cause_of_death',
                'father_occupation',
                'mother_name',
                'mother_alive_or_not',
                'mother_year_of_death',
                'mother_cause_of_death',
                'mother_occupation',
                'monthly_income',
                'edu_class',
                'name_of_school',
                'medium_of_instruct',
                'hobbies',
                'weight',
                'height',
                'health_condition',
                'child_address',
                'phone_number',
                'guardian_name',
                'guardian_address',
                'family_detail',
                'brief_of_family',
                'child_photo_image',
                'sponsor_count',
                'created_at',
                'created_by',
                'is_deleted'
            );

            foreach ($check as $value) {
                if (isset($model->$value)) {

                    $insert_data = array_merge($insert_data, array($value=>$model->$value));

                }
            }

            $result = $this->db->insert('homeprojects_child', $insert_data);
           
                if($result==true){
                    $response['result']=array($result);
                    $response['message']="child data record stored successfully";
                }else{
                    $response['status']="failure";            
                    $response['message']="Sorry!!, Unable to insert the Child data";
                }
           
            }else{
                    $response['status']="failure";            
                    $response['message']="Sorry!!, Invalid Attempt!!.. Permission denied.";
            }
            echo json_encode($response,JSON_UNESCAPED_SLASHES);
            die();
    }

    public function get_homeproject_child_master_list(){
        $this->output->set_content_type('application/json');
        $response=array();
        $html="";
         global $api_path, $gender;
        $response['status']="success";
        $result=array();
        $res=$this->db->select("homeprojects_child.id,
                home_project_id,
                homeprojects_master.home_project_name as home_project_names,
                homeprojects_master.home_project_number as home_project_number,
                home_project_reg_no,
                date_of_admission,
                child_name,
                child_gender,
                religion,
                DATE_FORMAT(".$this->db->dbprefix('homeprojects_child').".date_of_birth, '%d/%m/%Y') as date_of_birth,
                child_caste,
                child_type,
                father_name,
                father_alive_or_not,
                father_year_of_death,
                father_cause_of_death,
                father_occupation,
                mother_name,
                mother_alive_or_not,
                mother_year_of_death,
                mother_cause_of_death,
                mother_occupation,
                monthly_income,
                edu_class,
                name_of_school,
                medium_of_instruct,
                hobbies,
                weight,
                height,
                health_condition,
                child_address,
                phone_number,
                guardian_name,
                guardian_address,
                family_detail,
                brief_of_family,
                child_photo_image,
                sponsor_count,
                DATE_FORMAT(".$this->db->dbprefix('homeprojects_child').".created_at, '%d/%m/%Y') as created_at,
                ")
            ->join('homeprojects_master', 'homeprojects_child.home_project_id=homeprojects_master.id', 'left')
            ->order_by('id desc')
            ->where('homeprojects_child.is_deleted', '0')
            ->get('homeprojects_child');

            //var_dump($res); die();


        if($res->num_rows()>0){
            foreach($res->result_array() as $key=>$value){

            $html='<a class="btn btn-primary" href="'.$api_path.'/#/editchilddata/'.$value['id'].'"><i class="glyphicon glyphicon-pencil"></i></a> 

                          <button type="button" class="btn btn-danger button_delete_child"
                                  data-element-id="'.$value['id'].'"><i class="glyphicon glyphicon-trash" data-element-id="'.$value['id'].'"></i></button>';

                    if(isset($value['child_gender']))
                    {
                        $value['child_gender'] = $gender[$value['child_gender']];
                    }


                $result[]=array('id'=>$value['id'],
                                'home_project_id'=>$value['home_project_id'],
                                'home_project_name'=>$value['home_project_names'],
                                'home_project_reg_no'=>$value['home_project_reg_no'],
                                'home_project_number'=>$value['home_project_number'],
                                'date_of_admission'=>$value['date_of_admission'],
                                'child_name'=>$value['child_name'],
                                'child_gender'=>$value['child_gender'],
                                'religion'=>$value['religion'],
                                'date_of_birth'=>$value['date_of_birth'],
                                'child_caste'=>$value['child_caste'],
                                'child_type'=>$value['child_type'],
                                'father_name'=>$value['father_name'],
                                'father_alive_or_not'=>$value['father_alive_or_not'],
                                'father_year_of_death'=>$value['father_year_of_death'],
                                'father_cause_of_death'=>$value['father_cause_of_death'],
                                'father_occupation'=>$value['father_occupation'],
                                'mother_name'=>$value['mother_name'],
                                'mother_alive_or_not'=>$value['mother_alive_or_not'],
                                'mother_year_of_death'=>$value['mother_year_of_death'],
                                'mother_cause_of_death'=>$value['mother_cause_of_death'],
                                'mother_occupation'=>$value['mother_occupation'],
                                'monthly_income'=>$value['monthly_income'],
                                'edu_class'=>$value['edu_class'],
                                'name_of_school'=>$value['name_of_school'],
                                'medium_of_instruct'=>$value['medium_of_instruct'],
                                'hobbies'=>$value['hobbies'],
                                'weight'=>$value['weight'],
                                'height'=>$value['height'],
                                'health_condition'=>$value['health_condition'],
                                'child_address'=>$value['child_address'],
                                'phone_number'=>$value['phone_number'],
                                'guardian_name'=>$value['guardian_name'],
                                'guardian_address'=>$value['guardian_address'],
                                'family_detail'=>$value['family_detail'],
                                'brief_of_family'=>$value['brief_of_family'],
                                'child_photo_image'=>$value['child_photo_image'],
                                'sponsor_count'=>$value['sponsor_count'],
                                'created_at'=>$value['created_at'], 'action'=>$html);
            }
        }else{
            $response['status']="failure";
            $response['message']="No Children list found!!..";
        }
        $response['result']=$result;
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }

    public function gems_fetch_child_home_project_master($id)
    {
        //var_dump($id); die();
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();

            $res=$this->db->query("select * from ".$this->db->dbprefix('homeprojects_child')." where id='".$id."'");

            if($res->num_rows()>0){
                $in_array=$res->result_array();
                $result=$in_array[0];
            }else{
                $response['status']="failure";
                $response['message']=" No Home Project Child record found!!";
            }
            $response['result']=$result;

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }

    public function gems_edit_child_home_project_master(){
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";

        $resultdata = json_decode($this->input->post('resultdata',FALSE));
        

        if($resultdata->id!=""){
           
            $res_chk=$this->db->query("select id from ".$this->db->dbprefix('homeprojects_child')." ");
            if($res_chk->num_rows()>0){

                $data=array('home_project_id'=>$resultdata->home_project_id,
                            'home_project_reg_no'=>$resultdata->home_project_reg_no,
                            'date_of_admission'=>$resultdata->date_of_admission,
                            'child_name'=>$resultdata->child_name,
                            'child_gender'=>$resultdata->child_gender,
                            'religion'=>$resultdata->religion,
                            'date_of_birth'=>$resultdata->date_of_birth,
                            'child_caste'=>$resultdata->child_caste,
                            'child_type'=>$resultdata->child_type,
                            'father_name'=>$resultdata->father_name,
                            'father_alive_or_not'=>$resultdata->father_alive_or_not,
                            'father_year_of_death'=>$resultdata->father_year_of_death,
                            'father_cause_of_death'=>$resultdata->father_cause_of_death,
                            'father_occupation'=>$resultdata->father_occupation,
                            'mother_name'=>$resultdata->mother_name,
                            'mother_alive_or_not'=>$resultdata->mother_alive_or_not,
                            'mother_year_of_death'=>$resultdata->mother_year_of_death,
                            'mother_cause_of_death'=>$resultdata->mother_cause_of_death,
                            'mother_occupation'=>$resultdata->mother_occupation,
                            'monthly_income'=>$resultdata->monthly_income,
                            'edu_class'=>$resultdata->edu_class,
                            'name_of_school'=>$resultdata->name_of_school,
                            'medium_of_instruct'=>$resultdata->medium_of_instruct,
                            'hobbies'=>$resultdata->hobbies,
                            'weight'=>$resultdata->weight,
                            'height'=>$resultdata->height,
                            'health_condition'=>$resultdata->health_condition,
                            'child_address'=>$resultdata->child_address,
                            'phone_number'=>$resultdata->phone_number,
                            'guardian_name'=>$resultdata->guardian_name,
                            'guardian_address'=>$resultdata->guardian_address,
                            'family_detail'=>$resultdata->family_detail,
                            'brief_of_family'=>$resultdata->brief_of_family,
                            'child_photo_image'=>$resultdata->child_photo_image
                            );

                //var_dump($data); die();

                $this->db->where('id',$resultdata->id);
                $this->db->update($this->db->dbprefix('homeprojects_child'),$data);
                $response['message']="Home Project Child record has been updated successfully";
            }
       }else{
            $response['status']="failure";            
            $response['message']="Invalid Attempt!!.. Access denied..";
       }    
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }

     public function gems_delete_child_home_project_master($id){
        
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";


        $res_chk=$this->db->query("select id from ".$this->db->dbprefix('homeprojects_child')." where id='".$id."' ");
        
        if($res_chk->num_rows()>0){

            $data=array('is_deleted'=>'1');

            $this->db->set('deleted_at', 'NOW()', FALSE);
            $this->db->where('id',$id);
            $this->db->update($this->db->dbprefix('homeprojects_child'),$data);

            $response['status']="success";
            $response['message']="Children record has been deleted successfully";
            
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";    
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();        
    }

    public function gems_create_homeproject_sponsorship_master() {

       $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";

        $model = json_decode($this->input->post('model',FALSE));

        //var_dump($model->sponsor_missionary_remarks); die();


        if($model!=''){
            
                $this->db->query("insert into ".$this->db->dbprefix('sponsorship_master')." (
                        sponsor_group_id,
                        category_sponsorship,
                        child_preference,
                        sponser_amount,
                        sponser_payment_details,
                        sponsor_number_of_installment,
                        sponsor_from_date,
                        sponsor_to_date,
                        sponsor_allot_mission_status,
                        sponser_form_filling_person_name,
                        sponsor_missionary_remarks,
                        created_at,
                        created_by,
                        is_deleted
                            ) values (
                                '".$model->sponsor_group_id."',
                                '".$model->category_sponsorship."',
                                '".$model->child_preference."',
                                '".$model->sponser_amount."',
                                '".$model->sponser_payment_details."',
                                '".$model->sponsor_number_of_installment."',
                                '".date("Y-m-d", strtotime($model->sponsor_from_date))."',
                                '".date("Y-m-d", strtotime($model->sponsor_to_date))."',
                                '".$model->sponsor_allot_mission_status."',
                                '".$model->sponser_form_filling_person_name."',
                                '".$model->sponsor_missionary_remarks."',
                                NOW(),
                                '".$model->created_by."',
                                '0'
                                )");

                if($this->db->insert_id()){
                    $response['result']=array('id'=>$this->db->insert_id());
                    $response['message']="Sponsorship record stored successfully";
                }else{
                    $response['status']="failure";            
                    $response['message']="Sorry!!, Unable to insert the Sponsor data";
                }
           
            }else{
                    $response['status']="failure";            
                    $response['message']="Sorry!!, Invalid Attempt!!.. Permission denied.";
            }
            echo json_encode($response,JSON_UNESCAPED_SLASHES);
            die();
    }


    public function get_homeproject_sponsorship_overall_list(){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $result=array();
        $html="";
           global $api_path;
        
        $res=$this->db->select("sponsorship_master.id, sponsor_group_id, category_sponsorship, DATE_FORMAT(created_at,'%d/%m/%Y')as created_at, sponser_missionary_preference, DATE_FORMAT(sadmin_approve_date,'%d/%m/%Y')as sadmin_approve_date, sponser_amount, sponser_payment_details, sponsor_number_of_installment, sponsor_allot_mission_status")
            ->order_by('sponsorship_master.id', 'desc')
            ->where('is_deleted', '0')
            ->where('category_sponsorship', '2')
            ->where('child_preference!=', 'NULL')
            ->get('sponsorship_master');
      // var_dump($res); die();
         
        
        if($res->num_rows()>0){

            global $missionaryallotstatus;

            foreach($res->result_array() as $key=>$value1){


               // $res_chk=$this->db->query("select * from ".$this->db->dbprefix('sponsor_master')." where id='".$value1['sponsor_group_id']."'");
                $res_chk=$this->db->select("sponsor_master.id, sponser_name, promotional_office_master.promo_office_name, country.country_name, sponser_phone, sponsor_district, state_zone_master.state_zone_name, sponser_city_town_place, sponser_pin, DATE_FORMAT(sponser_sadmin_approve_date,'%d/%m/%Y')as sponser_sadmin_approve_date, sponser_missionary_preference, sponsor_allot_mission_status")
                            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left')
                            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
                            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
                            ->order_by('sponsor_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsor_master.id', $value1['sponsor_group_id'])
                            ->get('sponsor_master');
                
                   // var_dump($res_chk); die();
                if($res_chk->num_rows()>0){

                    foreach($res_chk->result_array() as $key=>$value){


                         //var_dump($value); die();
                        $html='<a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewsponsorship/'.$value1['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>';

                                $result[]=array('id'=>$value1['id'],'sponser_name'=>$value['sponser_name'],'sponser_amount'=>$value1['sponser_amount'],'sponser_payment_details'=>$value1['sponser_payment_details'],'sponsor_number_of_installment'=>$value1['sponsor_number_of_installment'],'sponser_promo_office'=>$value['promo_office_name'],'sponser_country_id'=>$value['country_name'],'sponser_phone'=>$value['sponser_phone'],'sponsor_district'=>$value['sponsor_district'],'sponser_state'=>$value['state_zone_name'],'sponser_city_town_place'=>$value['sponser_city_town_place'],'sponser_pin'=>$value['sponser_pin'],'sponser_sadmin_approve_date'=>$value1['sadmin_approve_date'],'sponsor_allot_mission_status'=>$missionaryallotstatus[$value1['sponsor_allot_mission_status']],'action'=>$html);

                     }   


                 }   

                
            
            }
        }else{
            $response['status']="failure";
            $response['message']="No staff list found!!..";
        }
        
        $response['result']=$result;
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }



    public function get_homeproject_sponsorship_master_list(){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $result=array();
        $html="";
           global $api_path;
        
        $res=$this->db->select("sponsorship_master.id, sponsor_group_id, category_sponsorship, DATE_FORMAT(created_at,'%d/%m/%Y')as created_at, sponser_missionary_preference, DATE_FORMAT(sadmin_approve_date,'%d/%m/%Y')as sadmin_approve_date, sponser_amount, sponser_payment_details, sponsor_number_of_installment")
            ->order_by('sponsorship_master.id', 'desc')
            ->where('is_deleted', '0')
            ->where('category_sponsorship', '2')
            ->where('sadmin_approve_date!=', 'NULL')
            ->where('child_preference!=', 'NULL')
            ->get('sponsorship_master');
      // var_dump($res); die();
         
        
        if($res->num_rows()>0){

            global $missionaryallotstatus;

            foreach($res->result_array() as $key=>$value1){


               // $res_chk=$this->db->query("select * from ".$this->db->dbprefix('sponsor_master')." where id='".$value1['sponsor_group_id']."'");
                $res_chk=$this->db->select("sponsor_master.id, sponser_name, promotional_office_master.promo_office_name, country.country_name, sponser_phone, sponsor_district, state_zone_master.state_zone_name, sponser_city_town_place, sponser_pin, DATE_FORMAT(sponser_sadmin_approve_date,'%d/%m/%Y')as sponser_sadmin_approve_date, sponser_missionary_preference, sponsor_allot_mission_status")
                            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left')
                            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
                            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
                            ->order_by('sponsor_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponser_sadmin_approve_date!=', 'NULL')
                            ->where('sponsor_master.id', $value1['sponsor_group_id'])
                            ->get('sponsor_master');
                
                   // var_dump($res_chk); die();
                if($res_chk->num_rows()>0){

                    foreach($res_chk->result_array() as $key=>$value){


                         //var_dump($value); die();
                        $html='<a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewsponsorship/'.$value1['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>';

                                $result[]=array('id'=>$value1['id'],'sponser_name'=>$value['sponser_name'],'sponser_amount'=>$value1['sponser_amount'],'sponser_payment_details'=>$value1['sponser_payment_details'],'sponsor_number_of_installment'=>$value1['sponsor_number_of_installment'],'sponser_promo_office'=>$value['promo_office_name'],'sponser_country_id'=>$value['country_name'],'sponser_phone'=>$value['sponser_phone'],'sponsor_district'=>$value['sponsor_district'],'sponser_state'=>$value['state_zone_name'],'sponser_city_town_place'=>$value['sponser_city_town_place'],'sponser_pin'=>$value['sponser_pin'],'sponser_sadmin_approve_date'=>$value1['sadmin_approve_date'],'sponsor_allot_mission_status'=>$missionaryallotstatus[$value['sponsor_allot_mission_status']],'action'=>$html);

                     }   


                 }   

                
            
            }
        }else{
            $response['status']="failure";
            $response['message']="No staff list found!!..";
        }
        
        $response['result']=$result;
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    public function gems_edit_homeproject_sponsorship_master(){
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";

        $resultdata = json_decode($this->input->post('resultdata',FALSE));
        //var_dump($resultdata); die();
        if($resultdata->id!="" && $resultdata->sponsor_group_id!=""){
            
                
                // $data=array('staff_zone_name'=>$this->input->post('zone_name',FALSE),
                //             'region_id'=>$this->input->post('region_id',FALSE),
                //             'modified_by'=>$this->input->post('modified_by',FALSE));

                $data=array('sponsor_group_id'=>$resultdata->sponsor_group_id,
                            'category_sponsorship'=>$resultdata->category_sponsorship,
                            'child_preference'=>$resultdata->child_preference,
                            'sponser_amount'=>$resultdata->sponser_amount,
                            'sponser_payment_details'=>$resultdata->sponser_payment_details,
                            'sponsor_number_of_installment'=>$resultdata->sponsor_number_of_installment,
                            'sponsor_from_date'=>date("Y-m-d", strtotime($resultdata->sponsor_from_date)),
                            'sponsor_to_date'=>date("Y-m-d", strtotime($resultdata->sponsor_to_date)),
                            'sponser_form_filling_person_name'=>$resultdata->sponser_form_filling_person_name,
                            'sponsor_missionary_remarks'=>$resultdata->sponsor_missionary_remarks
                        );
                $this->db->set('is_deleted','0');
                $this->db->where('id',$resultdata->id);
                $this->db->update($this->db->dbprefix('sponsorship_master'),$data);
                $response['message']="Sponsorship record has been updated successfully";
            
       }else{
            $response['status']="failure";            
            $response['message']="Invalid Attempt!!.. Access denied..";
       }    
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }

    public function get_home_allotchild_master_list(){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $result=array();
        $html="";
           global $api_path;
        
        $res=$this->db->select("sponsorship_master.id, sponsor_group_id, sponser_amount, category_sponsorship, DATE_FORMAT(created_at,'%d/%m/%Y')as created_at, sponser_missionary_preference, sponsor_allot_mission_status")
            ->order_by('sponsorship_master.id', 'desc')
            ->where('is_deleted', '0')
            ->where('sponsor_allot_mission_status', '4')
            ->where('category_sponsorship', '2')
            ->where('sadmin_approve_date!=', 'NULL')
            ->where('child_preference!=', NULL)
            ->get('sponsorship_master');

         
        
        if($res->num_rows()>0){

            global $missionaryallotstatus, $api_path;

            foreach($res->result_array() as $key=>$value1){


               // $res_chk=$this->db->query("select * from ".$this->db->dbprefix('sponsor_master')." where id='".$value1['sponsor_group_id']."'");
                $res_chk=$this->db->select("sponsor_master.id, sponser_name, promotional_office_master.promo_office_name, sponser_country_id, sponser_promo_office, country.country_name, sponser_phone, sponsor_district, state_zone_master.state_zone_name, sponser_city_town_place, sponser_pin, DATE_FORMAT(sponser_sadmin_approve_date,'%d/%m/%Y')as sponser_sadmin_approve_date, sponser_missionary_preference, sponsor_allot_mission_status")
                            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left')
                            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
                            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
                            ->order_by('sponsor_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponser_sadmin_approve_date!=', 'NULL')
                            ->where('sponsor_master.id', $value1['sponsor_group_id'])
                            ->get('sponsor_master');
                
                   // var_dump($res_chk); die();
                if($res_chk->num_rows()>0){

                    foreach($res_chk->result_array() as $key=>$value){


                         //var_dump($value); die();
                        $html='

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewsponsorship/'.$value['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                <a title="Allot Child" style=" margin-top: 10px;" href="'.$api_path.'/#/homeprojectallotchild/'.$value1['id'].'"><i class="fa fa-check" aria-hidden="true"></i></a>';

                                $result[]=array('id'=>$value1['id'],'sponser_amount'=>$value1['sponser_amount'],'sponser_name'=>$value['sponser_name'],'sponser_promo_office'=>$value['promo_office_name'],'sponser_country_id'=>$value['country_name'],'sponser_phone'=>$value['sponser_phone'],'sponsor_district'=>$value['sponsor_district'],'sponser_state'=>$value['state_zone_name'],'sponser_city_town_place'=>$value['sponser_city_town_place'],'sponser_pin'=>$value['sponser_pin'],'sponser_sadmin_approve_date'=>$value['sponser_sadmin_approve_date'],'sponsor_allot_mission_status'=>$missionaryallotstatus[$value1['sponsor_allot_mission_status']],'action'=>$html);

                     }   


                 }   

                
            
            }
        }else{
            $response['status']="failure";
            $response['message']="No staff list found!!..";
        }
        
        $response['result']=$result;
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    public function gems_homeproject_allot_child_sponsorship() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        $staff_ids = $model->selectedstaff;
        //var_dump($staff_ids); die();
        

        if (is_array($staff_ids) && count($staff_ids)>0) {
            
            $success_count = 0;
            foreach ($staff_ids as $staff_id) {

                $res=$this->db->select("sponsor_count")
                        ->where('id', $staff_id)
                        ->get('homeprojects_child');

                 if($res->num_rows()>0) {

                    foreach($res->result_array() as $key=>$value) {

                        if($value['sponsor_count']!=null)
                        {
                            $value['sponsor_count'] = $value['sponsor_count'] +1;
                        }
                        else
                        {
                            $value['sponsor_count'] = 1;
                        }

                        //var_dump($value['sponsor_count']); die();

                        $data = array('sponsor_count' => $value['sponsor_count']);
                        $this->db->where('id', $staff_id);
                        $result=$this->db->update('homeprojects_child', $data);

                        $sponsorship_data = array('sponsor_allot_mission_status' => '1');
                        $this->db->where('id', $model->sponsor_id);
                        $result=$this->db->update('sponsorship_master', $sponsorship_data);
                    }

                }

                $this->db->query("insert into ".$this->db->dbprefix('homeproject_allot_child')." (
                        home_project_id,
                        sponsor_id,
                        allotment_reallotment,
                        withdrawl_status,
                        sadmin_allot_approve,
                        missionary_withdrawal,
                        revert_sponsorship
                            ) values (
                                '".$staff_id."',
                                '".$model->sponsor_id."',
                                'A',
                                'N',
                                '0',
                                '0',
                                '0'
                                )");

                if($this->db->insert_id()){
                    $response['result']=array('id'=>$this->db->insert_id());
                    $response['message']="Allot Child record stored successfully";
                }else{
                    $response['status']="failure";            
                    $response['message']="Sorry!!, Unable to insert the Allot Child data";
                }

                if ($result) {
                    $success_count++;
                }
            }
            

            if (count($staff_ids)==$success_count) {
                $response['status']="success";
                $response['message']="Sponsor allotted status has been updated successfully";
            } else {
                $response['status']="failure";
                $response['message']="Sponsor allotted status has not been updated fully";
            }
        } else {
            $response['status']="failure";
            $response['message']="Choose staff and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    public function get_homeproject_allot_child_approve_list(){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $result=array();
        $html="";
           global $api_path;
        

          $res=$this->db->select("homeproject_allot_child.id, sponsor_id, home_project_id, allotment_reallotment, withdrawl_status, sadmin_allot_approve, admin_allot_approve_date, admin_allot_approved_by, missionary_withdrawal")
            ->order_by('homeproject_allot_child.id', 'desc')
            ->where('allotment_reallotment', 'A')
            ->where('sadmin_allot_approve', '0')
            ->get('homeproject_allot_child');  

         
        
        if($res->num_rows()>0){

            global $missionaryallotstatus, $api_path;

            foreach($res->result_array() as $key=>$value1){
               

                 $res_chk=$this->db->select("sponsorship_master.id, sponsor_group_id, category_sponsorship, sponser_amount")
                            ->order_by('sponsorship_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsorship_master.id', $value1['sponsor_id'])
                            ->get('sponsorship_master');  



                $child_res_chk=$this->db->select("homeprojects_child.id,
                                        home_project_id,
                                        homeprojects_master.home_project_name as home_project_names,
                                        homeprojects_master.home_project_number as home_project_number,
                                        home_project_reg_no,
                                        date_of_admission,
                                        child_name,
                                        child_gender,
                                        religion,
                                        DATE_FORMAT(".$this->db->dbprefix('homeprojects_child').".date_of_birth, '%d/%m/%Y') as date_of_birth,
                                        child_caste,
                                        child_type,
                                        father_name,
                                        father_alive_or_not,
                                        father_year_of_death,
                                        father_cause_of_death,
                                        father_occupation,
                                        mother_name,
                                        mother_alive_or_not,
                                        mother_year_of_death,
                                        mother_cause_of_death,
                                        mother_occupation,
                                        monthly_income,
                                        edu_class,
                                        name_of_school,
                                        medium_of_instruct,
                                        hobbies,
                                        weight,
                                        height,
                                        health_condition,
                                        child_address,
                                        phone_number,
                                        guardian_name,
                                        guardian_address,
                                        family_detail,
                                        brief_of_family,
                                        child_photo_image,
                                        sponsor_count,
                                        DATE_FORMAT(".$this->db->dbprefix('homeprojects_child').".created_at, '%d/%m/%Y') as created_at,
                                        ")
                            ->join('homeprojects_master', 'homeprojects_child.home_project_id=homeprojects_master.id', 'left')
                            ->order_by('id desc')
                            ->where('homeprojects_child.is_deleted', '0')
                            ->where('homeprojects_child.id', $value1['home_project_id'])
                            ->get('homeprojects_child');


                $child_res_chk = $child_res_chk->result_array();

                //var_dump($child_res_chk); die();  

                if($res_chk->num_rows()>0){

                    foreach($res_chk->result_array() as $key=>$sponsorship){

                         $res_chk_sponsor=$this->db->select("sponsor_master.id, sponser_name, promotional_office_master.promo_office_name, sponser_country_id, sponser_promo_office, country.country_name, sponser_phone, sponsor_district, state_zone_master.state_zone_name, sponser_city_town_place, sponser_pin, DATE_FORMAT(sponser_sadmin_approve_date,'%d/%m/%Y')as sponser_sadmin_approve_date, sponser_missionary_preference, sponsor_allot_mission_status")
                            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left')
                            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
                            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
                            ->order_by('sponsor_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsor_master.id', $sponsorship['sponsor_group_id'])
                            ->get('sponsor_master');

                            if($res_chk_sponsor->num_rows()>0){

                                foreach($res_chk_sponsor->result_array() as $key=>$value){

                                $html='

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewsponsorship/'.$value['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/allotmissionsponsor/'.$value1['id'].'"><i class="fa fa-check" aria-hidden="true"></i></a>';

                                $result[]=array('id'=>$value1['id'], 'sponser_id'=>$value1['sponsor_id'], 'sponser_amount'=>$sponsorship['sponser_amount'],'sponser_name'=>$value['sponser_name'],'sponser_promo_office'=>$value['promo_office_name'],'sponser_country_id'=>$value['country_name'],'sponser_phone'=>$value['sponser_phone'],'sponsor_district'=>$value['sponsor_district'],'sponser_state'=>$value['state_zone_name'],'sponser_city_town_place'=>$value['sponser_city_town_place'],'sponser_pin'=>$value['sponser_pin'], 'sponser_sadmin_approve_date'=>$value['sponser_sadmin_approve_date'], 'home_project_name'=>$child_res_chk[$key]['home_project_names'], 'home_project_id'=>$child_res_chk[$key]['id'], 'home_project_reg_no'=>$child_res_chk[$key]['home_project_reg_no'], 'child_name'=>$child_res_chk[$key]['child_name'], 'sponsor_count'=>$child_res_chk[$key]['sponsor_count'], 'action'=>$html);
                               }
                            }    

                     }   


                 }   

                
            
            }
        }else{
            $response['status']="failure";
            $response['message']="No staff list found!!..";
        }
        
        $response['result']=$result;
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


    public function gems_approve_homeproject_child_sponsorship() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        $staff_ids = $model->selectedstaff;

        

        if (is_array($staff_ids) && count($staff_ids)>0) {
            
            $success_count = 0;
            foreach ($staff_ids as $staff_id) {


                $data = array('sadmin_allot_approve' => '1', 'admin_allot_approve_date' =>date('Y-m-d H:i:s'), 'admin_allot_approved_by' => '1');
                $this->db->where('id', $staff_id);
                $result=$this->db->update('homeproject_allot_child', $data);


                if ($result) {
                    $response['message']="Sponsor Approved status has been updated successfully";
                }
                else
                {
                     $response['status']="failure";
                $response['message']="Sponsor Approved status has not been updated fully";
                }
            }

        } else {
            $response['status']="failure";
            $response['message']="Choose missionary and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

     public function gems_revoke_homeproject_child_sponsorship() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        $staff_ids = $model->selectedstaff;

        if (is_array($staff_ids) && count($staff_ids)>0) {
            
            $success_count = 0;
            foreach ($staff_ids as $staff_id) {

                 $res=$this->db->select("homeproject_allot_child.id, sponsor_id, home_project_id, allotment_reallotment, withdrawl_status, sadmin_allot_approve, admin_allot_approve_date, admin_allot_approved_by, missionary_withdrawal")
                    ->where('id', $staff_id)
                    ->get('homeproject_allot_child');    

                 if($res->num_rows()>0) {

                    foreach($res->result_array() as $key=>$value) {


                        $res_chk=$this->db->select("sponsorship_master.id, sponsor_group_id, category_sponsorship, sponser_amount")
                            ->order_by('sponsorship_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsorship_master.id', $value['sponsor_id'])
                            ->get('sponsorship_master');  

                        $res_chk = $res_chk->result_array();

                        $child_res_chk=$this->db->select("homeprojects_child.id,
                                        home_project_id,
                                        homeprojects_master.home_project_name as home_project_names,
                                        homeprojects_master.home_project_number as home_project_number,
                                        home_project_reg_no,
                                        date_of_admission,
                                        child_name,
                                        child_gender,
                                        religion,
                                        DATE_FORMAT(".$this->db->dbprefix('homeprojects_child').".date_of_birth, '%d/%m/%Y') as date_of_birth,
                                        child_caste,
                                        child_type,
                                        father_name,
                                        father_alive_or_not,
                                        father_year_of_death,
                                        father_cause_of_death,
                                        father_occupation,
                                        mother_name,
                                        mother_alive_or_not,
                                        mother_year_of_death,
                                        mother_cause_of_death,
                                        mother_occupation,
                                        monthly_income,
                                        edu_class,
                                        name_of_school,
                                        medium_of_instruct,
                                        hobbies,
                                        weight,
                                        height,
                                        health_condition,
                                        child_address,
                                        phone_number,
                                        guardian_name,
                                        guardian_address,
                                        family_detail,
                                        brief_of_family,
                                        child_photo_image,
                                        sponsor_count,
                                        DATE_FORMAT(".$this->db->dbprefix('homeprojects_child').".created_at, '%d/%m/%Y') as created_at,
                                        ")
                            ->join('homeprojects_master', 'homeprojects_child.home_project_id=homeprojects_master.id', 'left')
                            ->order_by('id desc')
                            ->where('homeprojects_child.is_deleted', '0')
                            ->where('homeprojects_child.id', $value['home_project_id'])
                            ->get('homeprojects_child');


                        $child_res_chk = $child_res_chk->result_array();
                        // var_dump($child_res_chk); die();

                        if($child_res_chk[0]['sponsor_count']!=null)
                        {
                            $child_res_chk[0]['sponsor_count'] = $child_res_chk[0]['sponsor_count'] -1;
                        }

                        //var_dump($value['sponsor_count']); die();

                        $data = array('sponsor_count' => $child_res_chk[0]['sponsor_count']);
                        $result=$this->db->update('homeprojects_child', $data);

                    }

                }

                $this->db->query("delete from ".$this->db->dbprefix('homeproject_allot_child')."  where id='".$staff_id."'");
                $response['status']="success";
                $response['message']="Allot Home Project child record has been deleted successfully";

            }

            

        } else {
            $response['status']="failure";
            $response['message']="Choose staff and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    public function get_homeproject_allot_child_approved_list(){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $result=array();
        $html="";
           global $api_path;
        

          $res=$this->db->select("homeproject_allot_child.id, sponsor_id, home_project_id, allotment_reallotment, withdrawl_status, sadmin_allot_approve, admin_allot_approved_by, missionary_withdrawal, DATE_FORMAT(".$this->db->dbprefix('homeproject_allot_child').".admin_allot_approve_date, '%d/%m/%Y') as admin_allot_approve_date")
            ->order_by('homeproject_allot_child.id', 'desc')
            ->where('allotment_reallotment', 'A')
            ->where('sadmin_allot_approve', '1')
            ->get('homeproject_allot_child');  

         
        
        if($res->num_rows()>0){

            global $missionaryallotstatus, $api_path;

            foreach($res->result_array() as $key=>$value1){
               

                 $res_chk=$this->db->select("sponsorship_master.id, sponsor_group_id, category_sponsorship, sponser_amount")
                            ->order_by('sponsorship_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsorship_master.id', $value1['sponsor_id'])
                            ->get('sponsorship_master');  



                $child_res_chk=$this->db->select("homeprojects_child.id,
                                        home_project_id,
                                        homeprojects_master.home_project_name as home_project_names,
                                        homeprojects_master.home_project_number as home_project_number,
                                        home_project_reg_no,
                                        date_of_admission,
                                        child_name,
                                        child_gender,
                                        religion,
                                        DATE_FORMAT(".$this->db->dbprefix('homeprojects_child').".date_of_birth, '%d/%m/%Y') as date_of_birth,
                                        child_caste,
                                        child_type,
                                        father_name,
                                        father_alive_or_not,
                                        father_year_of_death,
                                        father_cause_of_death,
                                        father_occupation,
                                        mother_name,
                                        mother_alive_or_not,
                                        mother_year_of_death,
                                        mother_cause_of_death,
                                        mother_occupation,
                                        monthly_income,
                                        edu_class,
                                        name_of_school,
                                        medium_of_instruct,
                                        hobbies,
                                        weight,
                                        height,
                                        health_condition,
                                        child_address,
                                        phone_number,
                                        guardian_name,
                                        guardian_address,
                                        family_detail,
                                        brief_of_family,
                                        child_photo_image,
                                        sponsor_count,
                                        DATE_FORMAT(".$this->db->dbprefix('homeprojects_child').".created_at, '%d/%m/%Y') as created_at,
                                        ")
                            ->join('homeprojects_master', 'homeprojects_child.home_project_id=homeprojects_master.id', 'left')
                            ->order_by('id desc')
                            ->where('homeprojects_child.is_deleted', '0')
                            ->where('homeprojects_child.id', $value1['home_project_id'])
                            ->get('homeprojects_child');


                $child_res_chk = $child_res_chk->result_array();

                //var_dump($child_res_chk); die();  

                if($res_chk->num_rows()>0){

                    foreach($res_chk->result_array() as $key=>$sponsorship){

                         $res_chk_sponsor=$this->db->select("sponsor_master.id, sponser_name, promotional_office_master.promo_office_name, sponser_country_id, sponser_promo_office, country.country_name, sponser_phone, sponsor_district, state_zone_master.state_zone_name, sponser_city_town_place, sponser_pin, DATE_FORMAT(sponser_sadmin_approve_date,'%d/%m/%Y')as sponser_sadmin_approve_date, sponser_missionary_preference, sponsor_allot_mission_status")
                            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left')
                            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
                            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
                            ->order_by('sponsor_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsor_master.id', $sponsorship['sponsor_group_id'])
                            ->get('sponsor_master');

                            if($res_chk_sponsor->num_rows()>0){

                                foreach($res_chk_sponsor->result_array() as $key=>$value){

                                $html='

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewsponsorship/'.$value['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/allotmissionsponsor/'.$value1['id'].'"><i class="fa fa-check" aria-hidden="true"></i></a>';

                                $result[]=array('id'=>$value1['id'], 'sponser_id'=>$value1['sponsor_id'], 'sponser_amount'=>$sponsorship['sponser_amount'],'sponser_name'=>$value['sponser_name'],'sponser_promo_office'=>$value['promo_office_name'],'sponser_country_id'=>$value['country_name'],'sponser_phone'=>$value['sponser_phone'],'sponsor_district'=>$value['sponsor_district'],'sponser_state'=>$value['state_zone_name'],'sponser_city_town_place'=>$value['sponser_city_town_place'],'sponser_pin'=>$value['sponser_pin'], 'sponser_sadmin_approve_date'=>$value1['admin_allot_approve_date'], 'home_project_name'=>$child_res_chk[$key]['home_project_names'], 'home_project_id'=>$child_res_chk[$key]['id'], 'home_project_reg_no'=>$child_res_chk[$key]['home_project_reg_no'], 'child_name'=>$child_res_chk[$key]['child_name'], 'sponsor_count'=>$child_res_chk[$key]['sponsor_count'], 'action'=>$html);
                               }
                            }    

                     }   


                 }   

                
            
            }
        }else{
            $response['status']="failure";
            $response['message']="No staff list found!!..";
        }
        
        $response['result']=$result;
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    public function get_withdrawl_home_child_list(){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $result=array();
        $html="";
           global $api_path;

           $res=$this->db->select("homeproject_allot_child.id, sponsor_id, home_project_id, allotment_reallotment, withdrawl_status, sadmin_allot_approve, admin_allot_approved_by, missionary_withdrawal, DATE_FORMAT(".$this->db->dbprefix('homeproject_allot_child').".admin_allot_approve_date, '%d/%m/%Y') as admin_allot_approve_date")
                ->order_by('homeproject_allot_child.id', 'desc')
                ->where('withdrawl_status', 'N')
                ->get('homeproject_allot_child');  

        
        if($res->num_rows()>0){

            global $missionaryallotstatus, $api_path;

            foreach($res->result_array() as $key=>$value1){


                $res_chk=$this->db->select("sponsorship_master.id, sponsor_group_id, category_sponsorship, sponser_amount")
                            ->order_by('sponsorship_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsorship_master.id', $value1['sponsor_id'])
                            ->get('sponsorship_master');         

                       $child_res_chk=$this->db->select("homeprojects_child.id,
                                        home_project_id,
                                        homeprojects_master.home_project_name as home_project_names,
                                        homeprojects_master.home_project_number as home_project_number,
                                        home_project_reg_no,
                                        date_of_admission,
                                        child_name,
                                        child_gender,
                                        religion,
                                        DATE_FORMAT(".$this->db->dbprefix('homeprojects_child').".date_of_birth, '%d/%m/%Y') as date_of_birth,
                                        child_caste,
                                        child_type,
                                        father_name,
                                        father_alive_or_not,
                                        father_year_of_death,
                                        father_cause_of_death,
                                        father_occupation,
                                        mother_name,
                                        mother_alive_or_not,
                                        mother_year_of_death,
                                        mother_cause_of_death,
                                        mother_occupation,
                                        monthly_income,
                                        edu_class,
                                        name_of_school,
                                        medium_of_instruct,
                                        hobbies,
                                        weight,
                                        height,
                                        health_condition,
                                        child_address,
                                        phone_number,
                                        guardian_name,
                                        guardian_address,
                                        family_detail,
                                        brief_of_family,
                                        child_photo_image,
                                        sponsor_count,
                                        DATE_FORMAT(".$this->db->dbprefix('homeprojects_child').".created_at, '%d/%m/%Y') as created_at,
                                        ")
                            ->join('homeprojects_master', 'homeprojects_child.home_project_id=homeprojects_master.id', 'left')
                            ->order_by('id desc')
                            ->where('homeprojects_child.is_deleted', '0')
                            ->where('homeprojects_child.id', $value1['home_project_id'])
                            ->get('homeprojects_child');


                $child_res_chk = $child_res_chk->result_array();
                
                if($res_chk->num_rows()>0){

                    foreach($res_chk->result_array() as $key=>$sponsorship){

                         $res_chk_sponsor=$this->db->select("sponsor_master.id, sponser_name, promotional_office_master.promo_office_name, sponser_country_id, sponser_promo_office, country.country_name, sponser_phone, sponsor_district, state_zone_master.state_zone_name, sponser_city_town_place, sponser_pin, DATE_FORMAT(sponser_sadmin_approve_date,'%d/%m/%Y')as sponser_sadmin_approve_date, sponser_missionary_preference, sponsor_allot_mission_status")
                            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left')
                            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
                            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
                            ->order_by('sponsor_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsor_master.id', $sponsorship['sponsor_group_id'])
                            ->get('sponsor_master');

                            if($res_chk_sponsor->num_rows()>0){

                                foreach($res_chk_sponsor->result_array() as $key=>$value){

                                $html='

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewsponsorship/'.$value['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/allotmissionsponsor/'.$value1['id'].'"><i class="fa fa-check" aria-hidden="true"></i></a>';

                                $result[]=array('id'=>$value1['id'], 'sponser_id'=>$value1['sponsor_id'], 'sponser_amount'=>$sponsorship['sponser_amount'],'sponser_name'=>$value['sponser_name'],'sponser_promo_office'=>$value['promo_office_name'],'sponser_country_id'=>$value['country_name'],'sponser_phone'=>$value['sponser_phone'],'sponsor_district'=>$value['sponsor_district'],'sponser_state'=>$value['state_zone_name'],'sponser_city_town_place'=>$value['sponser_city_town_place'],'sponser_pin'=>$value['sponser_pin'], 'sponser_sadmin_approve_date'=>$value['sponser_sadmin_approve_date'], 'home_project_name'=>$child_res_chk[$key]['home_project_names'], 'home_project_id'=>$child_res_chk[$key]['id'], 'home_project_reg_no'=>$child_res_chk[$key]['home_project_reg_no'], 'child_name'=>$child_res_chk[$key]['child_name'], 'sponsor_count'=>$child_res_chk[$key]['sponsor_count'], 'action'=>$html);
                               }
                             }   

                     }   


                 }   

                
            
            }
        }else{
            $response['status']="failure";
            $response['message']="No staff list found!!..";
        }
        
        $response['result']=$result;
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    public function gems_insert_withdrawl_home_child() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        $staff_ids = $model->selectedstaff;

        

        if (is_array($staff_ids) && count($staff_ids)>0) {
            
            $success_count = 0;
            foreach ($staff_ids as $staff_id) {


                $data = array('withdrawl_status' => 'W');
                $this->db->where('id', $staff_id);
                $result=$this->db->update('homeproject_allot_child', $data);

                if ($result) {
                 $res=$this->db->select("home_project_id, sponsor_id")
                        ->where('id', $staff_id)
                        ->get('homeproject_allot_child');

                   // var_dump($res); die();

                 if($res->num_rows()>0) {

                    foreach($res->result_array() as $key=>$value) {

                        //var_dump($value); die();

                         $this->db->query("insert into ".$this->db->dbprefix('withdrawal_home_child')." (
                                        home_project_id,
                                        sponsor_id,
                                        reason,
                                        created_at,
                                        created_by,
                                        admin_approve
                                            ) values (
                                                '".$value['home_project_id']."',
                                                '".$value['sponsor_id']."',
                                                '".$model->reasonwithdrawl."',
                                                NOW(),
                                                '1',
                                                '0'
                                                )");

                                if($this->db->insert_id()){
                                    $response['result']=array('id'=>$this->db->insert_id());
                                    $response['message']="withdrawl Home child record stored successfully";
                                }else{
                                    $response['status']="failure";            
                                    $response['message']="Sorry!!, Unable to insert the withdrawl Home child data";
                                }
                        }

                    }
                }
                else
                {
                    $response['status']="failure";
                    $response['message']="Home child withdrawl status has not been updated fully";
                }

            }

        } else {
            $response['status']="failure";
            $response['message']="Choose Home child and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    public function get_approve_withdrawl_home_child_list(){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $result=array();
        $html="";
           global $api_path;

          $res=$this->db->select("withdrawal_home_child.id, home_project_id, sponsor_id, reason, date, created_at, created_by, admin_approve, admin_approve_by, admin_approve_date")
            ->order_by('withdrawal_home_child.id', 'desc')
            ->where('admin_approve', '0')
            ->get('withdrawal_home_child');    

        //var_dump($res); die();
        
        if($res->num_rows()>0){

            global $missionaryallotstatus, $api_path;

            foreach($res->result_array() as $key=>$value1){


                   $res_chk=$this->db->select("sponsorship_master.id, sponsor_group_id, category_sponsorship, sponser_amount")
                            ->order_by('sponsorship_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsorship_master.id', $value1['sponsor_id'])
                            ->get('sponsorship_master');          

                        $child_res_chk=$this->db->select("homeprojects_child.id,
                                        home_project_id,
                                        homeprojects_master.home_project_name as home_project_names,
                                        homeprojects_master.home_project_number as home_project_number,
                                        home_project_reg_no,
                                        date_of_admission,
                                        child_name,
                                        child_gender,
                                        religion,
                                        DATE_FORMAT(".$this->db->dbprefix('homeprojects_child').".date_of_birth, '%d/%m/%Y') as date_of_birth,
                                        child_caste,
                                        child_type,
                                        father_name,
                                        father_alive_or_not,
                                        father_year_of_death,
                                        father_cause_of_death,
                                        father_occupation,
                                        mother_name,
                                        mother_alive_or_not,
                                        mother_year_of_death,
                                        mother_cause_of_death,
                                        mother_occupation,
                                        monthly_income,
                                        edu_class,
                                        name_of_school,
                                        medium_of_instruct,
                                        hobbies,
                                        weight,
                                        height,
                                        health_condition,
                                        child_address,
                                        phone_number,
                                        guardian_name,
                                        guardian_address,
                                        family_detail,
                                        brief_of_family,
                                        child_photo_image,
                                        sponsor_count,
                                        DATE_FORMAT(".$this->db->dbprefix('homeprojects_child').".created_at, '%d/%m/%Y') as created_at,
                                        ")
                            ->join('homeprojects_master', 'homeprojects_child.home_project_id=homeprojects_master.id', 'left')
                            ->order_by('id desc')
                            ->where('homeprojects_child.is_deleted', '0')
                            ->where('homeprojects_child.id', $value1['home_project_id'])
                            ->get('homeprojects_child');

                        $child_res_chk = $child_res_chk->result_array();

                if($res_chk->num_rows()>0){

                    foreach($res_chk->result_array() as $key=>$sponsorship){


                         $res_chk_sponsor=$this->db->select("sponsor_master.id, sponser_name, promotional_office_master.promo_office_name, sponser_country_id, sponser_promo_office, country.country_name, sponser_phone, sponsor_district, state_zone_master.state_zone_name, sponser_city_town_place, sponser_pin, DATE_FORMAT(sponser_sadmin_approve_date,'%d/%m/%Y')as sponser_sadmin_approve_date, sponser_missionary_preference, sponsor_allot_mission_status")
                            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left')
                            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
                            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
                            ->order_by('sponsor_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsor_master.id', $sponsorship['sponsor_group_id'])
                            ->get('sponsor_master');

                            if($res_chk_sponsor->num_rows()>0){

                                foreach($res_chk_sponsor->result_array() as $key=>$value){

                                 //var_dump($value); die();
                                $html='

                                    <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewsponsorship/'.$value['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                    <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/allotmissionsponsor/'.$value1['id'].'"><i class="fa fa-check" aria-hidden="true"></i></a>';

                                    $result[]=array('id'=>$value1['id'], 'sponser_id'=>$value1['sponsor_id'], 'reason'=>$value1['reason'], 'staffid'=>$child_res_chk[$key]['id'], 'sponser_name'=>$value['sponser_name'], 'sponsor_amount'=>$sponsorship['sponser_amount'],'sponser_promo_office'=>$value['promo_office_name'],'sponser_country_id'=>$value['country_name'],'sponser_phone'=>$value['sponser_phone'],'sponsor_district'=>$value['sponsor_district'],'sponser_state'=>$value['state_zone_name'],'sponser_city_town_place'=>$value['sponser_city_town_place'],'sponser_pin'=>$value['sponser_pin'], 'sponser_sadmin_approve_date'=>$value['sponser_sadmin_approve_date'], 'home_project_name'=>$child_res_chk[$key]['home_project_names'], 'home_project_id'=>$child_res_chk[$key]['id'], 'home_project_reg_no'=>$child_res_chk[$key]['home_project_reg_no'], 'child_name'=>$child_res_chk[$key]['child_name'], 'sponsor_count'=>$child_res_chk[$key]['sponsor_count'], 'action'=>$html);

                                   }
                                   
                                }     

                             }   
                 }   
            }
        }else{
            $response['status']="failure";
            $response['message']="No staff list found!!..";
        }
        
        $response['result']=$result;
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

     public function gems_approve_withdrawl_home_child_sponsorship() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        $staff_ids = $model->selectedstaff;

        

        if (is_array($staff_ids) && count($staff_ids)>0) {
            
            $success_count = 0;
            foreach ($staff_ids as $staff_id) {


                $res=$this->db->select("home_project_id, sponsor_id")
                        ->where('id', $staff_id)
                        ->get('withdrawal_home_child');


                if($res->num_rows()>0) {

                    foreach($res->result_array() as $key=>$value) {

                        $sponsorshipdata = array('sponsor_allot_mission_status' => '3');
                        $this->db->where('id', $value['sponsor_id']);
                        $result=$this->db->update('sponsorship_master', $sponsorshipdata);
                        

                    }

                }


                $data = array('admin_approve' => '1', 'admin_approve_date' =>date('Y-m-d H:i:s'), 'admin_approve_by' => '1');
                $this->db->where('id', $staff_id);
                $result=$this->db->update('withdrawal_home_child', $data);


                if ($result) {
                    $response['message']="withdrawl Approved status has been updated successfully";
                }
                else
                {
                     $response['status']="failure";
                $response['message']="withdrawl Approved status has not been updated fully";
                }
            }

        } else {
            $response['status']="failure";
            $response['message']="Choose missionary and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


    public function gems_approve_sponsorship() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        
         $model = json_decode($this->input->post('model',FALSE));

         $staff_ids = $model->selectedstaff;

         //var_dump($staff_ids); die();

        if (is_array($staff_ids) && count($staff_ids)>0) {
            
            $success_count = 0;
            foreach ($staff_ids as $staff_id) {

                if ($this->db->where('id', $staff_id)->update('sponsorship_master', array('sadmin_approve_by' => '1', 'sadmin_approve_date' =>date('Y-m-d H:i:s')))) {
                    $success_count++;
                }
            }

            if (count($staff_ids)==$success_count) {
                $response['message']="Sponsor Approve status has been updated successfully";
            } else {
                $response['status']="failure";
                $response['message']="Sponsor Approve status has not been updated fully";
            }
        } else {
            $response['status']="failure";
            $response['message']="Choose staff and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }



    public function gems_approve_sponsor() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        
         $model = json_decode($this->input->post('model',FALSE));

         $staff_ids = $model->selectedstaff;

         //var_dump($staff_ids); die();

        if (is_array($staff_ids) && count($staff_ids)>0) {
            
            $success_count = 0;
            foreach ($staff_ids as $staff_id) {


                if ($this->db->where('id', $staff_id)->update('sponsor_master', array('sponser_sadmin_approve' => '1', 'sponser_sadmin_approve_date' =>date('Y-m-d H:i:s')))) {
                    $success_count++;
                }
            }

            if (count($staff_ids)==$success_count) {
                $response['message']="Sponsor Approve status has been updated successfully";
            } else {
                $response['status']="failure";
                $response['message']="Sponsor Approve status has not been updated fully";
            }
        } else {
            $response['status']="failure";
            $response['message']="Choose staff and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }



    public function gems_revoke_withdrawl_home_child_sponsorship() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        $staff_ids = $model->selectedstaff;

        

        if (is_array($staff_ids) && count($staff_ids)>0) {
            
            $success_count = 0;
            foreach ($staff_ids as $staff_id) {

                 $res=$this->db->select("home_project_id, sponsor_id")
                        ->where('id', $staff_id)
                        ->get('withdrawal_home_child');

                   // var_dump($res); die();

                 if($res->num_rows()>0) {

                    foreach($res->result_array() as $key=>$value) {

                        $data = array('withdrawl_status' => 'N');
                        $this->db->where('home_project_id', $value['home_project_id']);
                        $this->db->where('sponsor_id', $value['sponsor_id']);
                        $result=$this->db->update('homeproject_allot_child', $data);

                        //var_dump($value); die();

                         $this->db->query("delete from ".$this->db->dbprefix('withdrawal_home_child')."  where id='".$staff_id."'");
                         $response['status']="success";
                         $response['message']="Withdrawl missionary record has been deleted successfully";
                        

                        }

                    }

            }

        } else {
            $response['status']="failure";
            $response['message']="Choose missionary and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    public function get_approved_withdrawl_home_child_list(){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $result=array();
        $html="";
           global $api_path;

          $res=$this->db->select("withdrawal_home_child.id, home_project_id, sponsor_id, reason, date, created_at, created_by, admin_approve, admin_approve_by, DATE_FORMAT(".$this->db->dbprefix('withdrawal_home_child').".admin_approve_date, '%d/%m/%Y') as admin_approve_date,")
            ->order_by('withdrawal_home_child.id', 'desc')
            ->where('admin_approve', '1')
            ->get('withdrawal_home_child');    

        //var_dump($res); die();
        
        if($res->num_rows()>0){

            global $missionaryallotstatus, $api_path;

            foreach($res->result_array() as $key=>$value1){


                   $res_chk=$this->db->select("sponsorship_master.id, sponsor_group_id, category_sponsorship, sponser_amount")
                            ->order_by('sponsorship_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsorship_master.id', $value1['sponsor_id'])
                            ->get('sponsorship_master');          

                        $child_res_chk=$this->db->select("homeprojects_child.id,
                                        home_project_id,
                                        homeprojects_master.home_project_name as home_project_names,
                                        homeprojects_master.home_project_number as home_project_number,
                                        home_project_reg_no,
                                        date_of_admission,
                                        child_name,
                                        child_gender,
                                        religion,
                                        DATE_FORMAT(".$this->db->dbprefix('homeprojects_child').".date_of_birth, '%d/%m/%Y') as date_of_birth,
                                        child_caste,
                                        child_type,
                                        father_name,
                                        father_alive_or_not,
                                        father_year_of_death,
                                        father_cause_of_death,
                                        father_occupation,
                                        mother_name,
                                        mother_alive_or_not,
                                        mother_year_of_death,
                                        mother_cause_of_death,
                                        mother_occupation,
                                        monthly_income,
                                        edu_class,
                                        name_of_school,
                                        medium_of_instruct,
                                        hobbies,
                                        weight,
                                        height,
                                        health_condition,
                                        child_address,
                                        phone_number,
                                        guardian_name,
                                        guardian_address,
                                        family_detail,
                                        brief_of_family,
                                        child_photo_image,
                                        sponsor_count,
                                        DATE_FORMAT(".$this->db->dbprefix('homeprojects_child').".created_at, '%d/%m/%Y') as created_at,
                                        ")
                            ->join('homeprojects_master', 'homeprojects_child.home_project_id=homeprojects_master.id', 'left')
                            ->order_by('id desc')
                            ->where('homeprojects_child.is_deleted', '0')
                            ->where('homeprojects_child.id', $value1['home_project_id'])
                            ->get('homeprojects_child');

                        $child_res_chk = $child_res_chk->result_array();

                if($res_chk->num_rows()>0){

                    foreach($res_chk->result_array() as $key=>$sponsorship){


                         $res_chk_sponsor=$this->db->select("sponsor_master.id, sponser_name, promotional_office_master.promo_office_name, sponser_country_id, sponser_promo_office, country.country_name, sponser_phone, sponsor_district, state_zone_master.state_zone_name, sponser_city_town_place, sponser_pin, DATE_FORMAT(sponser_sadmin_approve_date,'%d/%m/%Y')as sponser_sadmin_approve_date, sponser_missionary_preference, sponsor_allot_mission_status")
                            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left')
                            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
                            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
                            ->order_by('sponsor_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsor_master.id', $sponsorship['sponsor_group_id'])
                            ->get('sponsor_master');

                            if($res_chk_sponsor->num_rows()>0){

                                foreach($res_chk_sponsor->result_array() as $key=>$value){

                                 //var_dump($value); die();
                                $html='

                                    <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewsponsorship/'.$value['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                    <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/allotmissionsponsor/'.$value1['id'].'"><i class="fa fa-check" aria-hidden="true"></i></a>';

                                    $result[]=array('id'=>$value1['id'], 'sponser_id'=>$value1['sponsor_id'], 'reason'=>$value1['reason'],'staffid'=>$child_res_chk[$key]['id'], 'sponser_name'=>$value['sponser_name'], 'sponsor_amount'=>$sponsorship['sponser_amount'],'sponser_promo_office'=>$value['promo_office_name'],'sponser_country_id'=>$value['country_name'],'sponser_phone'=>$value['sponser_phone'],'sponsor_district'=>$value['sponsor_district'],'sponser_state'=>$value['state_zone_name'],'sponser_city_town_place'=>$value['sponser_city_town_place'],'sponser_pin'=>$value['sponser_pin'], 'admin_approve_date'=>$value1['admin_approve_date'], 'home_project_name'=>$child_res_chk[$key]['home_project_names'], 'home_project_id'=>$child_res_chk[$key]['id'], 'home_project_reg_no'=>$child_res_chk[$key]['home_project_reg_no'], 'child_name'=>$child_res_chk[$key]['child_name'], 'sponsor_count'=>$child_res_chk[$key]['sponsor_count'], 'action'=>$html);

                                   }
                                   
                                }     

                             }   
                 }   
            }
        }else{
            $response['status']="failure";
            $response['message']="No staff list found!!..";
        }
        
        $response['result']=$result;
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


    public function get_revert_home_child_list(){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $result=array();
        $html="";
           global $api_path;

           $res=$this->db->select("homeproject_allot_child.id, sponsor_id, home_project_id, allotment_reallotment, withdrawl_status, sadmin_allot_approve, admin_allot_approved_by, missionary_withdrawal, DATE_FORMAT(".$this->db->dbprefix('homeproject_allot_child').".admin_allot_approve_date, '%d/%m/%Y') as admin_allot_approve_date")
                ->order_by('homeproject_allot_child.id', 'desc')
                ->where('revert_sponsorship', '0')
                ->get('homeproject_allot_child');  

        
        if($res->num_rows()>0){

            global $missionaryallotstatus, $api_path;

            foreach($res->result_array() as $key=>$value1){


                $res_chk=$this->db->select("sponsorship_master.id, sponsor_group_id, category_sponsorship, sponser_amount")
                            ->order_by('sponsorship_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsorship_master.id', $value1['sponsor_id'])
                            ->get('sponsorship_master');         

                       $child_res_chk=$this->db->select("homeprojects_child.id,
                                        home_project_id,
                                        homeprojects_master.home_project_name as home_project_names,
                                        homeprojects_master.home_project_number as home_project_number,
                                        home_project_reg_no,
                                        date_of_admission,
                                        child_name,
                                        child_gender,
                                        religion,
                                        DATE_FORMAT(".$this->db->dbprefix('homeprojects_child').".date_of_birth, '%d/%m/%Y') as date_of_birth,
                                        child_caste,
                                        child_type,
                                        father_name,
                                        father_alive_or_not,
                                        father_year_of_death,
                                        father_cause_of_death,
                                        father_occupation,
                                        mother_name,
                                        mother_alive_or_not,
                                        mother_year_of_death,
                                        mother_cause_of_death,
                                        mother_occupation,
                                        monthly_income,
                                        edu_class,
                                        name_of_school,
                                        medium_of_instruct,
                                        hobbies,
                                        weight,
                                        height,
                                        health_condition,
                                        child_address,
                                        phone_number,
                                        guardian_name,
                                        guardian_address,
                                        family_detail,
                                        brief_of_family,
                                        child_photo_image,
                                        sponsor_count,
                                        DATE_FORMAT(".$this->db->dbprefix('homeprojects_child').".created_at, '%d/%m/%Y') as created_at,
                                        ")
                            ->join('homeprojects_master', 'homeprojects_child.home_project_id=homeprojects_master.id', 'left')
                            ->order_by('id desc')
                            ->where('homeprojects_child.is_deleted', '0')
                            ->where('homeprojects_child.id', $value1['home_project_id'])
                            ->get('homeprojects_child');


                $child_res_chk = $child_res_chk->result_array();
                
                if($res_chk->num_rows()>0){

                    foreach($res_chk->result_array() as $key=>$sponsorship){

                         $res_chk_sponsor=$this->db->select("sponsor_master.id, sponser_name, promotional_office_master.promo_office_name, sponser_country_id, sponser_promo_office, country.country_name, sponser_phone, sponsor_district, state_zone_master.state_zone_name, sponser_city_town_place, sponser_pin, DATE_FORMAT(sponser_sadmin_approve_date,'%d/%m/%Y')as sponser_sadmin_approve_date, sponser_missionary_preference, sponsor_allot_mission_status")
                            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left')
                            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
                            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
                            ->order_by('sponsor_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsor_master.id', $sponsorship['sponsor_group_id'])
                            ->get('sponsor_master');

                            if($res_chk_sponsor->num_rows()>0){

                                foreach($res_chk_sponsor->result_array() as $key=>$value){

                                $html='

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewsponsorship/'.$value['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/allotmissionsponsor/'.$value1['id'].'"><i class="fa fa-check" aria-hidden="true"></i></a>';

                                $result[]=array('id'=>$value1['id'], 'sponser_id'=>$value1['sponsor_id'], 'sponser_amount'=>$sponsorship['sponser_amount'],'sponser_name'=>$value['sponser_name'],'sponser_promo_office'=>$value['promo_office_name'],'sponser_country_id'=>$value['country_name'],'sponser_phone'=>$value['sponser_phone'],'sponsor_district'=>$value['sponsor_district'],'sponser_state'=>$value['state_zone_name'],'sponser_city_town_place'=>$value['sponser_city_town_place'],'sponser_pin'=>$value['sponser_pin'], 'sponser_sadmin_approve_date'=>$value['sponser_sadmin_approve_date'], 'home_project_name'=>$child_res_chk[$key]['home_project_names'], 'home_project_id'=>$child_res_chk[$key]['id'], 'home_project_reg_no'=>$child_res_chk[$key]['home_project_reg_no'], 'child_name'=>$child_res_chk[$key]['child_name'], 'sponsor_count'=>$child_res_chk[$key]['sponsor_count'], 'action'=>$html);
                               }
                             }   

                     }   


                 }   

                
            
            }
        }else{
            $response['status']="failure";
            $response['message']="No staff list found!!..";
        }
        
        $response['result']=$result;
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    public function gems_insert_revert_home_child_sponsorship() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        $staff_ids = $model->selectedstaff;

        

        if (is_array($staff_ids) && count($staff_ids)>0) {
            
            $success_count = 0;
            foreach ($staff_ids as $staff_id) {


                $data = array('revert_sponsorship' => '1');
                $this->db->where('id', $staff_id);
                $result=$this->db->update('homeproject_allot_child', $data);

                if ($result) {
                 $res=$this->db->select("home_project_id, sponsor_id")
                        ->where('id', $staff_id)
                        ->get('homeproject_allot_child');





                 if($res->num_rows()>0) {

                    foreach($res->result_array() as $key=>$value) {

                        //var_dump($value); die();

                         $this->db->query("insert into ".$this->db->dbprefix('revert_home_child')." (
                                        home_project_id,
                                        sponsor_id,
                                        created_at,
                                        created_by,
                                        admin_approve
                                            ) values (
                                                '".$value['home_project_id']."',
                                                '".$value['sponsor_id']."',
                                                NOW(),
                                                '1',
                                                '0'
                                                )");

                                if($this->db->insert_id()){
                                    $response['result']=array('id'=>$this->db->insert_id());
                                    $response['message']="Revert Home child record stored successfully";
                                }else{
                                    $response['status']="failure";            
                                    $response['message']="Sorry!!, Unable to insert the Revert Home child data";
                                }


                        }

                    }
                }
                else
                {
                    $response['status']="failure";
                    $response['message']="Home child Revert status has not been updated fully";
                }

            }

        } else {
            $response['status']="failure";
            $response['message']="Choose Home child and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    public function get_approve_revert_home_child_list(){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $result=array();
        $html="";
           global $api_path;

          $res=$this->db->select("revert_home_child.id, home_project_id, sponsor_id, reason, date, created_at, created_by, admin_approve, admin_approve_by, admin_approve_date")
            ->order_by('revert_home_child.id', 'desc')
            ->where('admin_approve', '0')
            ->get('revert_home_child');    

        //var_dump($res); die();
        
        if($res->num_rows()>0){

            global $missionaryallotstatus, $api_path;

            foreach($res->result_array() as $key=>$value1){


                   $res_chk=$this->db->select("sponsorship_master.id, sponsor_group_id, category_sponsorship, sponser_amount")
                            ->order_by('sponsorship_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsorship_master.id', $value1['sponsor_id'])
                            ->get('sponsorship_master');          

                        $child_res_chk=$this->db->select("homeprojects_child.id,
                                        home_project_id,
                                        homeprojects_master.home_project_name as home_project_names,
                                        homeprojects_master.home_project_number as home_project_number,
                                        home_project_reg_no,
                                        date_of_admission,
                                        child_name,
                                        child_gender,
                                        religion,
                                        DATE_FORMAT(".$this->db->dbprefix('homeprojects_child').".date_of_birth, '%d/%m/%Y') as date_of_birth,
                                        child_caste,
                                        child_type,
                                        father_name,
                                        father_alive_or_not,
                                        father_year_of_death,
                                        father_cause_of_death,
                                        father_occupation,
                                        mother_name,
                                        mother_alive_or_not,
                                        mother_year_of_death,
                                        mother_cause_of_death,
                                        mother_occupation,
                                        monthly_income,
                                        edu_class,
                                        name_of_school,
                                        medium_of_instruct,
                                        hobbies,
                                        weight,
                                        height,
                                        health_condition,
                                        child_address,
                                        phone_number,
                                        guardian_name,
                                        guardian_address,
                                        family_detail,
                                        brief_of_family,
                                        child_photo_image,
                                        sponsor_count,
                                        DATE_FORMAT(".$this->db->dbprefix('homeprojects_child').".created_at, '%d/%m/%Y') as created_at,
                                        ")
                            ->join('homeprojects_master', 'homeprojects_child.home_project_id=homeprojects_master.id', 'left')
                            ->order_by('id desc')
                            ->where('homeprojects_child.is_deleted', '0')
                            ->where('homeprojects_child.id', $value1['home_project_id'])
                            ->get('homeprojects_child');

                        $child_res_chk = $child_res_chk->result_array();

                if($res_chk->num_rows()>0){

                    foreach($res_chk->result_array() as $key=>$sponsorship){


                         $res_chk_sponsor=$this->db->select("sponsor_master.id, sponser_name, promotional_office_master.promo_office_name, sponser_country_id, sponser_promo_office, country.country_name, sponser_phone, sponsor_district, state_zone_master.state_zone_name, sponser_city_town_place, sponser_pin, DATE_FORMAT(sponser_sadmin_approve_date,'%d/%m/%Y')as sponser_sadmin_approve_date, sponser_missionary_preference, sponsor_allot_mission_status")
                            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left')
                            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
                            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
                            ->order_by('sponsor_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsor_master.id', $sponsorship['sponsor_group_id'])
                            ->get('sponsor_master');

                            if($res_chk_sponsor->num_rows()>0){

                                foreach($res_chk_sponsor->result_array() as $key=>$value){

                                 //var_dump($value); die();
                                $html='

                                    <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewsponsorship/'.$value['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                    <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/allotmissionsponsor/'.$value1['id'].'"><i class="fa fa-check" aria-hidden="true"></i></a>';

                                    $result[]=array('id'=>$value1['id'], 'sponser_id'=>$value1['sponsor_id'], 'staffid'=>$child_res_chk[$key]['id'], 'sponser_name'=>$value['sponser_name'], 'sponsor_amount'=>$sponsorship['sponser_amount'],'sponser_promo_office'=>$value['promo_office_name'],'sponser_country_id'=>$value['country_name'],'sponser_phone'=>$value['sponser_phone'],'sponsor_district'=>$value['sponsor_district'],'sponser_state'=>$value['state_zone_name'],'sponser_city_town_place'=>$value['sponser_city_town_place'],'sponser_pin'=>$value['sponser_pin'], 'sponser_sadmin_approve_date'=>$value['sponser_sadmin_approve_date'], 'home_project_name'=>$child_res_chk[$key]['home_project_names'], 'home_project_id'=>$child_res_chk[$key]['id'], 'home_project_reg_no'=>$child_res_chk[$key]['home_project_reg_no'], 'child_name'=>$child_res_chk[$key]['child_name'], 'sponsor_count'=>$child_res_chk[$key]['sponsor_count'], 'action'=>$html);

                                   }
                                   
                                }     

                             }   
                 }   
            }
        }else{
            $response['status']="failure";
            $response['message']="No staff list found!!..";
        }
        
        $response['result']=$result;
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    public function gems_approve_revert_home_child_sponsorship() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        $staff_ids = $model->selectedstaff;

        

        if (is_array($staff_ids) && count($staff_ids)>0) {
            
            $success_count = 0;
            foreach ($staff_ids as $staff_id) {


                $data = array('admin_approve' => '1', 'admin_approve_date' =>date('Y-m-d H:i:s'), 'admin_approve_by' => '1');
                $this->db->where('id', $staff_id);
                $result=$this->db->update('revert_home_child', $data);


                if ($result) {
                    $response['message']="Revert Child Approved status has been updated successfully";
                }
                else
                {
                     $response['status']="failure";
                $response['message']="Revert Child Approved status has not been updated fully";
                }
            }

        } else {
            $response['status']="failure";
            $response['message']="Choose Revert Child and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    public function gems_revoke_revert_home_child_sponsorship() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        $staff_ids = $model->selectedstaff;

        

        if (is_array($staff_ids) && count($staff_ids)>0) {
            
            $success_count = 0;
            foreach ($staff_ids as $staff_id) {

                 $res=$this->db->select("home_project_id, sponsor_id")
                        ->where('id', $staff_id)
                        ->get('revert_home_child');

                   // var_dump($res); die();

                 if($res->num_rows()>0) {

                    foreach($res->result_array() as $key=>$value) {

                        $data = array('revert_sponsorship' => '0');
                        $this->db->where('home_project_id', $value['home_project_id']);
                        $this->db->where('sponsor_id', $value['sponsor_id']);
                        $result=$this->db->update('homeproject_allot_child', $data);

                        //var_dump($value); die();

                         $this->db->query("delete from ".$this->db->dbprefix('revert_home_child')."  where id='".$staff_id."'");
                         $response['status']="success";
                         $response['message']="Revert Child record has been deleted successfully";
                        

                        }

                    }

            }

        } else {
            $response['status']="failure";
            $response['message']="Choose Revert Child and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    public function get_approved_revert_home_child_list(){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $result=array();
        $html="";
           global $api_path;

          $res=$this->db->select("revert_home_child.id, home_project_id, sponsor_id, reason, date, created_at, created_by, admin_approve, admin_approve_by, DATE_FORMAT(".$this->db->dbprefix('revert_home_child').".admin_approve_date, '%d/%m/%Y') as admin_approve_date,")
            ->order_by('revert_home_child.id', 'desc')
            ->where('admin_approve', '1')
            ->get('revert_home_child');    

        //var_dump($res); die();
        
        if($res->num_rows()>0){

            global $missionaryallotstatus, $api_path;

            foreach($res->result_array() as $key=>$value1){


                   $res_chk=$this->db->select("sponsorship_master.id, sponsor_group_id, category_sponsorship, sponser_amount")
                            ->order_by('sponsorship_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsorship_master.id', $value1['sponsor_id'])
                            ->get('sponsorship_master');          

                        $child_res_chk=$this->db->select("homeprojects_child.id,
                                        home_project_id,
                                        homeprojects_master.home_project_name as home_project_names,
                                        homeprojects_master.home_project_number as home_project_number,
                                        home_project_reg_no,
                                        date_of_admission,
                                        child_name,
                                        child_gender,
                                        religion,
                                        DATE_FORMAT(".$this->db->dbprefix('homeprojects_child').".date_of_birth, '%d/%m/%Y') as date_of_birth,
                                        child_caste,
                                        child_type,
                                        father_name,
                                        father_alive_or_not,
                                        father_year_of_death,
                                        father_cause_of_death,
                                        father_occupation,
                                        mother_name,
                                        mother_alive_or_not,
                                        mother_year_of_death,
                                        mother_cause_of_death,
                                        mother_occupation,
                                        monthly_income,
                                        edu_class,
                                        name_of_school,
                                        medium_of_instruct,
                                        hobbies,
                                        weight,
                                        height,
                                        health_condition,
                                        child_address,
                                        phone_number,
                                        guardian_name,
                                        guardian_address,
                                        family_detail,
                                        brief_of_family,
                                        child_photo_image,
                                        sponsor_count,
                                        DATE_FORMAT(".$this->db->dbprefix('homeprojects_child').".created_at, '%d/%m/%Y') as created_at,
                                        ")
                            ->join('homeprojects_master', 'homeprojects_child.home_project_id=homeprojects_master.id', 'left')
                            ->order_by('id desc')
                            ->where('homeprojects_child.is_deleted', '0')
                            ->where('homeprojects_child.id', $value1['home_project_id'])
                            ->get('homeprojects_child');

                        $child_res_chk = $child_res_chk->result_array();

                if($res_chk->num_rows()>0){

                    foreach($res_chk->result_array() as $key=>$sponsorship){


                         $res_chk_sponsor=$this->db->select("sponsor_master.id, sponser_name, promotional_office_master.promo_office_name, sponser_country_id, sponser_promo_office, country.country_name, sponser_phone, sponsor_district, state_zone_master.state_zone_name, sponser_city_town_place, sponser_pin, DATE_FORMAT(sponser_sadmin_approve_date,'%d/%m/%Y')as sponser_sadmin_approve_date, sponser_missionary_preference, sponsor_allot_mission_status")
                            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left')
                            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
                            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
                            ->order_by('sponsor_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsor_master.id', $sponsorship['sponsor_group_id'])
                            ->get('sponsor_master');

                            if($res_chk_sponsor->num_rows()>0){

                                foreach($res_chk_sponsor->result_array() as $key=>$value){

                                 //var_dump($value); die();
                                $html='

                                    <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewsponsorship/'.$value['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                    <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/allotmissionsponsor/'.$value1['id'].'"><i class="fa fa-check" aria-hidden="true"></i></a>';

                                    $result[]=array('id'=>$value1['id'], 'sponser_id'=>$value1['sponsor_id'], 'staffid'=>$child_res_chk[$key]['id'], 'sponser_name'=>$value['sponser_name'], 'sponsor_amount'=>$sponsorship['sponser_amount'],'sponser_promo_office'=>$value['promo_office_name'],'sponser_country_id'=>$value['country_name'],'sponser_phone'=>$value['sponser_phone'],'sponsor_district'=>$value['sponsor_district'],'sponser_state'=>$value['state_zone_name'],'sponser_city_town_place'=>$value['sponser_city_town_place'],'sponser_pin'=>$value['sponser_pin'], 'admin_approve_date'=>$value1['admin_approve_date'], 'home_project_name'=>$child_res_chk[$key]['home_project_names'], 'home_project_id'=>$child_res_chk[$key]['id'], 'home_project_reg_no'=>$child_res_chk[$key]['home_project_reg_no'], 'child_name'=>$child_res_chk[$key]['child_name'], 'sponsor_count'=>$child_res_chk[$key]['sponsor_count'], 'action'=>$html);

                                   }
                                   
                                }     

                             }   
                 }   
            }
        }else{
            $response['status']="failure";
            $response['message']="No staff list found!!..";
        }
        
        $response['result']=$result;
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    public function get_home_reallotchild_master_list(){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $result=array();
        $html="";
           global $api_path;
        
        $res=$this->db->select("sponsorship_master.id, sponsor_group_id, sponser_amount, category_sponsorship, DATE_FORMAT(created_at,'%d/%m/%Y')as created_at, sponser_missionary_preference, sponsor_allot_mission_status")
            ->order_by('sponsorship_master.id', 'desc')
            ->where('is_deleted', '0')
            ->where('sponsor_allot_mission_status', '3')
            ->where('category_sponsorship', '2')
            ->where('child_preference!=', 'NULL')
            ->get('sponsorship_master');

         
        
        if($res->num_rows()>0){

            global $missionaryallotstatus, $api_path;

            foreach($res->result_array() as $key=>$value1){


               // $res_chk=$this->db->query("select * from ".$this->db->dbprefix('sponsor_master')." where id='".$value1['sponsor_group_id']."'");
                $res_chk=$this->db->select("sponsor_master.id, sponser_name, promotional_office_master.promo_office_name, sponser_country_id, sponser_promo_office, country.country_name, sponser_phone, sponsor_district, state_zone_master.state_zone_name, sponser_city_town_place, sponser_pin, DATE_FORMAT(sponser_sadmin_approve_date,'%d/%m/%Y')as sponser_sadmin_approve_date, sponser_missionary_preference, sponsor_allot_mission_status")
                            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left')
                            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
                            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
                            ->order_by('sponsor_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsor_master.id', $value1['sponsor_group_id'])
                            ->get('sponsor_master');
                
                   // var_dump($res_chk); die();
                if($res_chk->num_rows()>0){

                    foreach($res_chk->result_array() as $key=>$value){


                         //var_dump($value); die();
                        $html='

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewsponsorship/'.$value['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                <a title="Allot Child" style=" margin-top: 10px;" href="'.$api_path.'/#/reallothomechild/'.$value1['id'].'"><i class="fa fa-check" aria-hidden="true"></i></a>';

                                $result[]=array('id'=>$value1['id'],'sponser_amount'=>$value1['sponser_amount'],'sponser_name'=>$value['sponser_name'],'sponser_promo_office'=>$value['promo_office_name'],'sponser_country_id'=>$value['country_name'],'sponser_phone'=>$value['sponser_phone'],'sponsor_district'=>$value['sponsor_district'],'sponser_state'=>$value['state_zone_name'],'sponser_city_town_place'=>$value['sponser_city_town_place'],'sponser_pin'=>$value['sponser_pin'],'sponser_sadmin_approve_date'=>$value['sponser_sadmin_approve_date'],'sponsor_allot_mission_status'=>$missionaryallotstatus[$value1['sponsor_allot_mission_status']],'action'=>$html);

                     }   


                 }   

                
            
            }
        }else{
            $response['status']="failure";
            $response['message']="No staff list found!!..";
        }
        
        $response['result']=$result;
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    public function gems_homeproject_reallot_child_sponsorship() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        $staff_ids = $model->selectedstaff;
        //var_dump($staff_ids); die();
        

        if (is_array($staff_ids) && count($staff_ids)>0) {
            
            $success_count = 0;
            foreach ($staff_ids as $staff_id) {

                $res=$this->db->select("sponsor_count")
                        ->where('id', $staff_id)
                        ->get('homeprojects_child');

                 if($res->num_rows()>0) {

                    foreach($res->result_array() as $key=>$value) {

                        if($value['sponsor_count']!=null)
                        {
                            $value['sponsor_count'] = $value['sponsor_count'] +1;
                        }
                        else
                        {
                            $value['sponsor_count'] = 1;
                        }

                        //var_dump($value['sponsor_count']); die();

                        $sponsorship_data = array('sponsor_allot_mission_status' => '2');
                        $this->db->where('id', $model->sponsor_id);
                        $result=$this->db->update('sponsorship_master', $sponsorship_data);

                        $data = array('sponsor_count' => $value['sponsor_count']);
                        $this->db->where('id', $staff_id);
                        $result=$this->db->update('homeprojects_child', $data);
                    }

                }

                $this->db->query("insert into ".$this->db->dbprefix('homeproject_allot_child')." (
                        home_project_id,
                        sponsor_id,
                        allotment_reallotment,
                        withdrawl_status,
                        sadmin_allot_approve,
                        missionary_withdrawal,
                        revert_sponsorship
                            ) values (
                                '".$staff_id."',
                                '".$model->sponsor_id."',
                                'R',
                                'N',
                                '0',
                                '0',
                                '0'
                                )");

                if($this->db->insert_id()){
                    $response['result']=array('id'=>$this->db->insert_id());
                    $response['message']="Allot Child record stored successfully";
                }else{
                    $response['status']="failure";            
                    $response['message']="Sorry!!, Unable to insert the Allot Child data";
                }

                if ($result) {
                    $success_count++;
                }
            }
            

            if (count($staff_ids)==$success_count) {
                $response['status']="success";
                $response['message']="Sponsor allotted status has been updated successfully";
            } else {
                $response['status']="failure";
                $response['message']="Sponsor allotted status has not been updated fully";
            }
        } else {
            $response['status']="failure";
            $response['message']="Choose staff and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    public function gems_approve_homeproject_reallot_child_sponsorship() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        $staff_ids = $model->selectedstaff;

        

        if (is_array($staff_ids) && count($staff_ids)>0) {
            
            $success_count = 0;
            foreach ($staff_ids as $staff_id) {


                $data = array('sadmin_allot_approve' => '1', 'admin_allot_approve_date' =>date('Y-m-d H:i:s'), 'admin_allot_approved_by' => '1');
                $this->db->where('id', $staff_id);
                $result=$this->db->update('homeproject_allot_child', $data);


                if ($result) {
                    $response['message']="Sponsor Approved status has been updated successfully";
                }
                else
                {
                     $response['status']="failure";
                $response['message']="Sponsor Approved status has not been updated fully";
                }
            }

        } else {
            $response['status']="failure";
            $response['message']="Choose missionary and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    public function get_homeproject_reallot_child_approve_list(){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $result=array();
        $html="";
           global $api_path;
        

          $res=$this->db->select("homeproject_allot_child.id, sponsor_id, home_project_id, allotment_reallotment, withdrawl_status, sadmin_allot_approve, admin_allot_approve_date, admin_allot_approved_by, missionary_withdrawal")
            ->order_by('homeproject_allot_child.id', 'desc')
            ->where('allotment_reallotment', 'R')
            ->where('sadmin_allot_approve', '0')
            ->get('homeproject_allot_child');  

         
        
        if($res->num_rows()>0){

            global $missionaryallotstatus, $api_path;

            foreach($res->result_array() as $key=>$value1){
               

                 $res_chk=$this->db->select("sponsorship_master.id, sponsor_group_id, category_sponsorship, sponser_amount")
                            ->order_by('sponsorship_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsorship_master.id', $value1['sponsor_id'])
                            ->get('sponsorship_master');  



                $child_res_chk=$this->db->select("homeprojects_child.id,
                                        home_project_id,
                                        homeprojects_master.home_project_name as home_project_names,
                                        homeprojects_master.home_project_number as home_project_number,
                                        home_project_reg_no,
                                        date_of_admission,
                                        child_name,
                                        child_gender,
                                        religion,
                                        DATE_FORMAT(".$this->db->dbprefix('homeprojects_child').".date_of_birth, '%d/%m/%Y') as date_of_birth,
                                        child_caste,
                                        child_type,
                                        father_name,
                                        father_alive_or_not,
                                        father_year_of_death,
                                        father_cause_of_death,
                                        father_occupation,
                                        mother_name,
                                        mother_alive_or_not,
                                        mother_year_of_death,
                                        mother_cause_of_death,
                                        mother_occupation,
                                        monthly_income,
                                        edu_class,
                                        name_of_school,
                                        medium_of_instruct,
                                        hobbies,
                                        weight,
                                        height,
                                        health_condition,
                                        child_address,
                                        phone_number,
                                        guardian_name,
                                        guardian_address,
                                        family_detail,
                                        brief_of_family,
                                        child_photo_image,
                                        sponsor_count,
                                        DATE_FORMAT(".$this->db->dbprefix('homeprojects_child').".created_at, '%d/%m/%Y') as created_at,
                                        ")
                            ->join('homeprojects_master', 'homeprojects_child.home_project_id=homeprojects_master.id', 'left')
                            ->order_by('id desc')
                            ->where('homeprojects_child.is_deleted', '0')
                            ->where('homeprojects_child.id', $value1['home_project_id'])
                            ->get('homeprojects_child');


                $child_res_chk = $child_res_chk->result_array();

                //var_dump($child_res_chk); die();  

                if($res_chk->num_rows()>0){

                    foreach($res_chk->result_array() as $key=>$sponsorship){

                         $res_chk_sponsor=$this->db->select("sponsor_master.id, sponser_name, promotional_office_master.promo_office_name, sponser_country_id, sponser_promo_office, country.country_name, sponser_phone, sponsor_district, state_zone_master.state_zone_name, sponser_city_town_place, sponser_pin, DATE_FORMAT(sponser_sadmin_approve_date,'%d/%m/%Y')as sponser_sadmin_approve_date, sponser_missionary_preference, sponsor_allot_mission_status")
                            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left')
                            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
                            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
                            ->order_by('sponsor_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsor_master.id', $sponsorship['sponsor_group_id'])
                            ->get('sponsor_master');

                            if($res_chk_sponsor->num_rows()>0){

                                foreach($res_chk_sponsor->result_array() as $key=>$value){

                                $html='

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewsponsorship/'.$value['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/allotmissionsponsor/'.$value1['id'].'"><i class="fa fa-check" aria-hidden="true"></i></a>';

                                $result[]=array('id'=>$value1['id'], 'sponser_id'=>$value1['sponsor_id'], 'sponser_amount'=>$sponsorship['sponser_amount'],'sponser_name'=>$value['sponser_name'],'sponser_promo_office'=>$value['promo_office_name'],'sponser_country_id'=>$value['country_name'],'sponser_phone'=>$value['sponser_phone'],'sponsor_district'=>$value['sponsor_district'],'sponser_state'=>$value['state_zone_name'],'sponser_city_town_place'=>$value['sponser_city_town_place'],'sponser_pin'=>$value['sponser_pin'], 'sponser_sadmin_approve_date'=>$value['sponser_sadmin_approve_date'], 'home_project_name'=>$child_res_chk[$key]['home_project_names'], 'home_project_id'=>$child_res_chk[$key]['id'], 'home_project_reg_no'=>$child_res_chk[$key]['home_project_reg_no'], 'child_name'=>$child_res_chk[$key]['child_name'], 'sponsor_count'=>$child_res_chk[$key]['sponsor_count'], 'action'=>$html);
                               }
                            }    

                     }   


                 }   

                
            
            }
        }else{
            $response['status']="failure";
            $response['message']="No staff list found!!..";
        }
        
        $response['result']=$result;
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


    public function gems_revoke_homeproject_reallot_child_sponsorship() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        $staff_ids = $model->selectedstaff;

        if (is_array($staff_ids) && count($staff_ids)>0) {
            
            $success_count = 0;
            foreach ($staff_ids as $staff_id) {

                 $res=$this->db->select("homeproject_allot_child.id, sponsor_id, home_project_id, allotment_reallotment, withdrawl_status, sadmin_allot_approve, admin_allot_approve_date, admin_allot_approved_by, missionary_withdrawal")
                    ->where('id', $staff_id)
                    ->get('homeproject_allot_child');    

                 if($res->num_rows()>0) {

                    foreach($res->result_array() as $key=>$value) {


                        $res_chk=$this->db->select("sponsorship_master.id, sponsor_group_id, category_sponsorship, sponser_amount")
                            ->order_by('sponsorship_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsorship_master.id', $value['sponsor_id'])
                            ->get('sponsorship_master');  

                        $res_chk = $res_chk->result_array();

                        $sponsorship_data = array('sponsor_allot_mission_status' => '3');
                        $this->db->where('id', $value['sponsor_id']);
                        $result=$this->db->update('sponsorship_master', $sponsorship_data);

                        $child_res_chk=$this->db->select("homeprojects_child.id,
                                        home_project_id,
                                        homeprojects_master.home_project_name as home_project_names,
                                        homeprojects_master.home_project_number as home_project_number,
                                        home_project_reg_no,
                                        date_of_admission,
                                        child_name,
                                        child_gender,
                                        religion,
                                        DATE_FORMAT(".$this->db->dbprefix('homeprojects_child').".date_of_birth, '%d/%m/%Y') as date_of_birth,
                                        child_caste,
                                        child_type,
                                        father_name,
                                        father_alive_or_not,
                                        father_year_of_death,
                                        father_cause_of_death,
                                        father_occupation,
                                        mother_name,
                                        mother_alive_or_not,
                                        mother_year_of_death,
                                        mother_cause_of_death,
                                        mother_occupation,
                                        monthly_income,
                                        edu_class,
                                        name_of_school,
                                        medium_of_instruct,
                                        hobbies,
                                        weight,
                                        height,
                                        health_condition,
                                        child_address,
                                        phone_number,
                                        guardian_name,
                                        guardian_address,
                                        family_detail,
                                        brief_of_family,
                                        child_photo_image,
                                        sponsor_count,
                                        DATE_FORMAT(".$this->db->dbprefix('homeprojects_child').".created_at, '%d/%m/%Y') as created_at,
                                        ")
                            ->join('homeprojects_master', 'homeprojects_child.home_project_id=homeprojects_master.id', 'left')
                            ->order_by('id desc')
                            ->where('homeprojects_child.is_deleted', '0')
                            ->where('homeprojects_child.id', $value['home_project_id'])
                            ->get('homeprojects_child');


                        $child_res_chk = $child_res_chk->result_array();
                        // var_dump($child_res_chk); die();

                        if($child_res_chk[0]['sponsor_count']!=null)
                        {
                            $child_res_chk[0]['sponsor_count'] = $child_res_chk[0]['sponsor_count'] -1;
                        }

                        //var_dump($value['sponsor_count']); die();

                        $data = array('sponsor_count' => $child_res_chk[0]['sponsor_count']);
                        $result=$this->db->update('homeprojects_child', $data);

                    }

                }

                $this->db->query("delete from ".$this->db->dbprefix('homeproject_allot_child')."  where id='".$staff_id."'");
                $response['status']="success";
                $response['message']="Allot Home Project child record has been deleted successfully";

            }

            

        } else {
            $response['status']="failure";
            $response['message']="Choose staff and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    public function get_homeproject_reallot_child_approved_list(){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        $result=array();
        $html="";
           global $api_path;
        

          $res=$this->db->select("homeproject_allot_child.id, sponsor_id, home_project_id, allotment_reallotment, withdrawl_status, sadmin_allot_approve, admin_allot_approved_by, missionary_withdrawal, DATE_FORMAT(".$this->db->dbprefix('homeproject_allot_child').".admin_allot_approve_date, '%d/%m/%Y') as admin_allot_approve_date")
            ->order_by('homeproject_allot_child.id', 'desc')
            ->where('allotment_reallotment', 'R')
            ->where('sadmin_allot_approve', '1')
            ->get('homeproject_allot_child');  

         
        
        if($res->num_rows()>0){

            global $missionaryallotstatus, $api_path;

            foreach($res->result_array() as $key=>$value1){
               

                 $res_chk=$this->db->select("sponsorship_master.id, sponsor_group_id, category_sponsorship, sponser_amount")
                            ->order_by('sponsorship_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsorship_master.id', $value1['sponsor_id'])
                            ->get('sponsorship_master');  



                $child_res_chk=$this->db->select("homeprojects_child.id,
                                        home_project_id,
                                        homeprojects_master.home_project_name as home_project_names,
                                        homeprojects_master.home_project_number as home_project_number,
                                        home_project_reg_no,
                                        date_of_admission,
                                        child_name,
                                        child_gender,
                                        religion,
                                        DATE_FORMAT(".$this->db->dbprefix('homeprojects_child').".date_of_birth, '%d/%m/%Y') as date_of_birth,
                                        child_caste,
                                        child_type,
                                        father_name,
                                        father_alive_or_not,
                                        father_year_of_death,
                                        father_cause_of_death,
                                        father_occupation,
                                        mother_name,
                                        mother_alive_or_not,
                                        mother_year_of_death,
                                        mother_cause_of_death,
                                        mother_occupation,
                                        monthly_income,
                                        edu_class,
                                        name_of_school,
                                        medium_of_instruct,
                                        hobbies,
                                        weight,
                                        height,
                                        health_condition,
                                        child_address,
                                        phone_number,
                                        guardian_name,
                                        guardian_address,
                                        family_detail,
                                        brief_of_family,
                                        child_photo_image,
                                        sponsor_count,
                                        DATE_FORMAT(".$this->db->dbprefix('homeprojects_child').".created_at, '%d/%m/%Y') as created_at,
                                        ")
                            ->join('homeprojects_master', 'homeprojects_child.home_project_id=homeprojects_master.id', 'left')
                            ->order_by('id desc')
                            ->where('homeprojects_child.is_deleted', '0')
                            ->where('homeprojects_child.id', $value1['home_project_id'])
                            ->get('homeprojects_child');


                $child_res_chk = $child_res_chk->result_array();

                //var_dump($child_res_chk); die();  

                if($res_chk->num_rows()>0){

                    foreach($res_chk->result_array() as $key=>$sponsorship){

                         $res_chk_sponsor=$this->db->select("sponsor_master.id, sponser_name, promotional_office_master.promo_office_name, sponser_country_id, sponser_promo_office, country.country_name, sponser_phone, sponsor_district, state_zone_master.state_zone_name, sponser_city_town_place, sponser_pin, DATE_FORMAT(sponser_sadmin_approve_date,'%d/%m/%Y')as sponser_sadmin_approve_date, sponser_missionary_preference, sponsor_allot_mission_status")
                            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left')
                            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
                            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
                            ->order_by('sponsor_master.id', 'desc')
                            ->where('is_deleted', '0')
                            ->where('sponsor_master.id', $sponsorship['sponsor_group_id'])
                            ->get('sponsor_master');

                            if($res_chk_sponsor->num_rows()>0){

                                foreach($res_chk_sponsor->result_array() as $key=>$value){

                                $html='

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewsponsorship/'.$value['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/allotmissionsponsor/'.$value1['id'].'"><i class="fa fa-check" aria-hidden="true"></i></a>';

                                $result[]=array('id'=>$value1['id'], 'sponser_id'=>$value1['sponsor_id'], 'sponser_amount'=>$sponsorship['sponser_amount'],'sponser_name'=>$value['sponser_name'],'sponser_promo_office'=>$value['promo_office_name'],'sponser_country_id'=>$value['country_name'],'sponser_phone'=>$value['sponser_phone'],'sponsor_district'=>$value['sponsor_district'],'sponser_state'=>$value['state_zone_name'],'sponser_city_town_place'=>$value['sponser_city_town_place'],'sponser_pin'=>$value['sponser_pin'], 'sponser_sadmin_approve_date'=>$value1['admin_allot_approve_date'], 'home_project_name'=>$child_res_chk[$key]['home_project_names'], 'home_project_id'=>$child_res_chk[$key]['id'], 'home_project_reg_no'=>$child_res_chk[$key]['home_project_reg_no'], 'child_name'=>$child_res_chk[$key]['child_name'], 'sponsor_count'=>$child_res_chk[$key]['sponsor_count'], 'action'=>$html);
                               }
                            }    

                     }   


                 }   

                
            
            }
        }else{
            $response['status']="failure";
            $response['message']="No staff list found!!..";
        }
        
        $response['result']=$result;
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }



     public function gems_get_staff_report_master() {

       $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";

        $model = json_decode($this->input->post('model',FALSE));
        //print_r($model);die();
        $result=NULL;

        if($model!=''){

                if(isset($model->selectedstaffvalue))
                {
                     array_push($model->selectedstaffvalue, "id");
                     array_push($model->selectedstaffvalue, "staff_name");

                      $columns = array_map(function($column) {
                        return 'staff_master.' . $column;
                    }, $model->selectedstaffvalue);

                      //print_r($columns);die();

                      $find_zone_column=array_search("staff_master.zone_id",$columns);
                        if(!empty($find_zone_column)){
                            array_push($columns,"zones_staff_master.staff_zone_name AS zone_id");
                        }

                       $find_state_column=array_search("staff_master.present_state_id",$columns);
                        if(!empty($find_state_column)){
                            array_push($columns,"state_zone_master.state_zone_name AS present_state_id");


                        } 

                        $find_category_column=array_search("staff_master.staff_category_id",$columns);
                        if(!empty($find_category_column)){
                            array_push($columns," staff_category_master.staff_category_name AS staff_category_id");


                        } 

                        $find_designation_column=array_search("staff_master.staff_designation_id",$columns);
                        if(!empty($find_designation_column)){
                            array_push($columns,"staff_designation_master.designation_name AS staff_designation_id");


                        } 

                        $find_department_column=array_search("staff_master.staff_department_id",$columns);
                        if(!empty($find_department_column)){
                            array_push($columns,"staff_department_master.department_name AS staff_department_id");


                        } 

                        
                       
                     
                     $res_chk=$this->db->select(implode(',', $columns))
                            ->join('zones_staff_master', 'staff_master.zone_id=zones_staff_master.id', 'left')
                            ->join('state_zone_master', 'staff_master.present_state_id=state_zone_master.id', 'left')
                            ->join('staff_category_master', 'staff_master.staff_category_id=staff_category_master.id', 'left')
                            ->join('staff_designation_master', 'staff_master.staff_designation_id=staff_designation_master.id', 'left')
                            ->join('staff_department_master', 'staff_master.staff_department_id=staff_department_master.id', 'left');

                            if(isset($model->staff_employee_id) && $model->staff_employee_id!="")
                            {   
                                $res_chk=$this->db->where('staff_employee_id', $model->staff_employee_id);
                            }

                            if(isset($model->staff_gender) && $model->staff_gender!="")
                            {   
                                $res_chk=$this->db->where('staff_gender', $model->staff_gender);
                            }

                            if(isset($model->zone_id) && $model->zone_id!="")
                            {   
                                $res_chk=$this->db->where('zone_id', $model->zone_id);
                            }

                             if(isset($model->ad_office) && $model->ad_office!="")
                            {   
                                $res_chk=$this->db->where('staff_master.ad_office', $model->ad_office);
                            }

                            if(isset($model->present_state_id) && $model->present_state_id!="")
                            {   
                                $res_chk=$this->db->where('present_state_id', $model->present_state_id);
                            }

                            if(isset($model->staff_identity_id) && $model->staff_identity_id!="")
                            {   
                                $res_chk=$this->db->where('staff_identity_id', $model->staff_identity_id);
                            }

                            if(isset($model->staff_department_id) && $model->staff_department_id!="")
                            {   
                                $res_chk=$this->db->where('staff_department_id', $model->staff_department_id);
                            }

                            if(isset($model->staff_type_id) && $model->staff_type_id!="")
                            {   
                                $res_chk=$this->db->where('staff_type_id', $model->staff_type_id);
                            }

                            if(isset($model->staff_designation_id) && $model->staff_designation_id!="")
                            {   
                                $res_chk=$this->db->where('staff_designation_id', $model->staff_designation_id);
                            }

                        $res_chk=$this->db->order_by('staff_master.id', 'desc')
                         ->where('staff_delete_status', '0')
                        ->where('staff_relief_status!=', 'SR')
                        ->get('staff_master'); 

                       // var_dump($res_chk); die();
                }
                else
                {   

                    $res_chk=$this->db->select("staff_name, id");

                        if(isset($model->staff_employee_id) && $model->staff_employee_id!="")
                        {   
                            $res_chk=$this->db->where('staff_employee_id', $model->staff_employee_id);
                        }

                        if(isset($model->staff_gender) && $model->staff_gender!="")
                        {   
                            $res_chk=$this->db->where('staff_gender', $model->staff_gender);
                        }

                        if(isset($model->zone_id) && $model->zone_id!="")
                        {   
                            $res_chk=$this->db->where('zone_id', $model->zone_id);
                        }
                       if(isset($model->ad_office) && $model->ad_office!="")
                        {   
                            $res_chk=$this->db->where('staff_master.ad_office', $model->ad_office);
                        }   
                        if(isset($model->present_state_id) && $model->present_state_id!="")
                        {   
                            $res_chk=$this->db->where('present_state_id', $model->present_state_id);
                        }

                        if(isset($model->staff_identity_id) && $model->staff_identity_id!="")
                        {   
                            $res_chk=$this->db->where('staff_identity_id', $model->staff_identity_id);
                        }

                        if(isset($model->staff_department_id) && $model->staff_department_id!="")
                        {   
                            $res_chk=$this->db->where('staff_department_id', $model->staff_department_id);
                        }

                        if(isset($model->staff_type_id) && $model->staff_type_id!="")
                        {   
                            $res_chk=$this->db->where('staff_type_id', $model->staff_type_id);
                        }

                        if(isset($model->staff_designation_id) && $model->staff_designation_id!="")
                        {   
                            $res_chk=$this->db->where('staff_designation_id', $model->staff_designation_id);
                        }
                        if(isset($model->experience_type) && $model->experience_type!=""){


                            $res=$this->db->query(
                                                "select t1.id,t2.fk_staff_id
                                                from ".$this->db->dbprefix('staff_master')." as t1
                                                left join ".$this->db->dbprefix('staff_vs_experience')." as t2 on t1.id=t2.fk_staff_id
                                                
                                                where YEAR(CURDATE()) - YEAR(exp_from_date) = ".$model->experience_type."
                                                group by t2.fk_staff_id"
                                                );
                           // where exp_from_date >= NOW() - INTERVAL ".$model->experience_type." YEAR
                            //print_r($this->db->last_query());die();

                            $ids = array();
                            foreach ($res->result_array() as $id)
                                {
                                    $ids[] = $id['id'];
                                }
                           //print_r($ids);die();
                            //print_r(count($res->result_array()));die();
                                 if(count($res->result_array())>0){
                                        $res_chk=$this->db->where_in('id', $ids);
                                 }
                                 else{
                                    $res_chk=$this->db->where('id',0);
                                 }
                            
                                

                          
                        }

                        $res_chk=$this->db->order_by('staff_master.id', 'desc')
                         ->where('staff_delete_status', '0')
                        ->where('staff_relief_status!=', 'SR')
                        ->get('staff_master'); 
                        //pr($this->db->last_query());die();
                }
                //var_dump($model->selectedchildvalue!='undefined'); die();

                
                if(isset($model->selectedchildvalue))
                {
                    array_push($model->selectedchildvalue, "staff_id");
                   //array_push($model->selectedchildvalue, "staff_master.staff_name");
                 

                    $childcolumns = array_map(function($column) {
                        //print_r($column);
                        return 'staff_children.' . $column;
                    }, $model->selectedchildvalue);

                   // die(); 
                    $find_child_designation_column=array_search("staff_children.verified_designation",$childcolumns);
                        if(!empty($find_child_designation_column)){
                            array_push($childcolumns,"staff_designation_master.designation_name AS verified_designation");


                        } 

                     array_push($childcolumns,"staff_master.staff_name");   
                     $res_chk_child=$this->db->select(implode(',', $childcolumns))
                            ->join('staff_designation_master', 'staff_children.verified_designation=staff_designation_master.id', 'left')
                            ->join('staff_master', 'staff_master.id=staff_id', 'left')
                            ->order_by('staff_children.id', 'desc')
                            ->get('staff_children');  

                        // print_r($res_chk_child->result_array());die();   
                    
                }
                

                if(isset($res_chk))
                {
                   

                        if($res_chk->num_rows()>0){

                             global $gender, $childgender, $age_group,  $marital_status, $part_india, $identities, $emtypes, $blood_group, $family_position;
                            

                            foreach($res_chk->result_array() as $key=>$value){

                                    if(isset($value['staff_gender']))
                                    {
                                        $value['staff_gender'] = $gender[$value['staff_gender']];
                                    }
                                    if(isset($value['marital_status']))
                                    {
                                        $value['marital_status'] = $marital_status[$value['marital_status']];
                                    }
                                    if(isset($value['staff_identity_id']))
                                    {
                                        $value['staff_identity_id'] = $identities[$value['staff_identity_id']];
                                    }
                                    if(isset($value['staff_type_id']))
                                    {
                                        $value['staff_type_id'] = $emtypes[$value['staff_type_id']];
                                    }
                                    if(isset($value['staff_dedication_status']))
                                    {
                                       // var_dump($value['staff_dedication_status']); die();
                                       if($value['staff_dedication_status']==0)
                                       {
                                            $value['staff_dedication_status']="Not Dedicated";
                                       }
                                       else
                                       {
                                            $value['staff_dedication_status']="Not Dedicated";
                                       }
                                    }


                                    //$this->pr($value);exit;
                                    
                                    $result[]=array($value);
                                    if(isset($model->selectedchildvalue))
                                    {

                                        if($res_chk_child->num_rows()>0){
                                            //print_r($res_chk_child->result_array());die();

                                            foreach($res_chk_child->result_array() as $key1=>$child){


                                                if(isset($child['gender']))
                                                {
                                                    $child['gender'] = $childgender[$child['gender']];
                                                }
                                                if(isset($child['marital_status']))
                                                {
                                                    $child['marital_status'] = $marital_status[$child['marital_status']];
                                                }
                                                if(isset($child['age_group']))
                                                {
                                                    $child['age_group'] = $age_group[$child['age_group']];
                                                }

                                                

                                                if($child['staff_id']==$value['id'])
                                                {
                                                    $result[]=array($child);
                                                }

                                            }
                                        }

                                    }

                            }
                            //print_r($result);die();

                       
                        }
                }                       
                else
                {
                    $response['status']="failure";            
                    $response['message']="Sorry!!, Invalid Attempt!!.. Permission denied.";
                }


        }
            if($result!=NULL)
            {
                $response['result']=$result;
            }
            else
            {
                $response['result']=NULL;
            }
            die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


    public function gems_get_child_report_master()
    {

        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";

        $model = json_decode($this->input->post('model',FALSE));

        /****Get Sponsor field Based result*******/
        if(isset($model->selectedsponsorvalue))
        {
            array_push($model->selectedsponsorvalue, "id");
            array_push($model->selectedsponsorvalue, "sponser_promo_office");             

            $sponsorcolumns = array_map(function($column) {
                return 'sponsor_master.' . $column;
            }, $model->selectedsponsorvalue);

           
            $find_country_column=array_search('sponsor_master.sponser_country_id',$sponsorcolumns);
            if(!empty($find_country_column)){
                array_push($sponsorcolumns,"country.country_name AS sponser_country_id");
            }

            $find_state_column=array_search('sponsor_master.sponser_state',$sponsorcolumns);

            if(!empty($find_state_column)){

                array_push($sponsorcolumns,"state_zone_master.state_zone_name AS sponser_state");


            }   

            $find_promo_column=array_search('sponsor_master.sponser_promo_office',$sponsorcolumns);

            if(!empty($find_promo_column)){

                array_push($sponsorcolumns,"promotional_office_master.promo_office_name AS sponser_promo_office");


            }    

                    // pr($sponsorcolumns);die();
             $res_chk_sponsor=$this->db->select(implode(',', $sponsorcolumns))
                    ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
                    ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
                    ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left');


                if(isset($model->sponser_promo_office) && $model->sponser_promo_office!="")
                {   
                    $res_chk_sponsor=$this->db->where('sponser_promo_office', $model->sponser_promo_office);
                }
                $res_chk_sponsor=$this->db->order_by('sponsor_master.id', 'desc')
                ->get('sponsor_master'); 
        }
        /*****END****/
        if(isset($model->selectedsponsorshipvalue))
        {
            array_push($model->selectedsponsorshipvalue, "id");
            array_push($model->selectedsponsorshipvalue, "sponsor_group_id");

            $sponsorshipcolumns = array_map(function($column) {
                return 'sponsorship_master.' . $column;
            }, $model->selectedsponsorshipvalue);


            $find_category_column=array_search('sponsorship_master.category_sponsorship',$sponsorshipcolumns);

            if(!empty($find_category_column)){
                array_push($sponsorshipcolumns,"staff_category_master.staff_category_name AS category_sponsorship");
            }


            $find_state_column=array_search("sponsorship_master.sponser_preference_state",$sponsorshipcolumns);
            if(!empty($find_state_column)){
                array_push($sponsorshipcolumns,"state_zone_master.state_zone_name AS sponser_preference_state");
            } 


            $res_chk_sponsorship=$this->db->select(implode(',', $sponsorshipcolumns))
                ->join('staff_category_master', 'sponsorship_master.category_sponsorship=staff_category_master.id', 'left')
                ->join('state_zone_master', 'sponsorship_master.sponser_preference_state=state_zone_master.id', 'left');

            if(isset($model->sponser_dedication_needed) && $model->sponser_dedication_needed!="")
            {   
                $res_chk_sponsorship=$this->db->where('sponser_dedication_needed', $model->sponser_dedication_needed);
            }

            if(isset($model->sponsor_allot_mission_status) && $model->sponsor_allot_mission_status!="")
            {   
                $res_chk_sponsorship=$this->db->where('sponsor_allot_mission_status', $model->sponsor_allot_mission_status);
            }

            if(isset($model->sponsor_from_month) && $model->sponsor_from_month!="")
            {   
               
                $res_chk_sponsorship=$this->db->where('DATE_FORMAT(sponsor_from_date, "%m") = "'.$model->sponsor_from_month.'"');

            }

            if(isset($model->sponsor_from_year) && $model->sponsor_from_year!="")
            {   
               
                $res_chk_sponsorship=$this->db->where('DATE_FORMAT(sponsor_from_date, "%Y") = "'.$model->sponsor_from_year.'"');

            }

            if(isset($model->sponsor_to_month) && $model->sponsor_to_month!="")
            {   
               
                $res_chk_sponsorship=$this->db->where('DATE_FORMAT(sponsor_to_date, "%m") = "'.$model->sponsor_to_month.'"');

            }

            if(isset($model->sponsor_to_year) && $model->sponsor_to_year!="")
            {   
               
                $res_chk_sponsorship=$this->db->where('DATE_FORMAT(sponsor_to_date, "%Y") = "'.$model->sponsor_to_year.'"');

            }
            $res_chk_sponsorship=$this->db->order_by('sponsorship_master.id', 'desc')
            ->get('sponsorship_master');   
        // pr($res_chk_sponsorship->result_array());die(); 

        }
        if(isset($model->selectedchildvalue))
        {
            array_push($model->selectedchildvalue, "staff_id");

            $childcolumns = array_map(function($column) {
                //print_r($column);
                return 'staff_children.' . $column;
            }, $model->selectedchildvalue);

           // die(); 
            $find_child_designation_column=array_search("staff_children.verified_designation",$childcolumns);
                if(!empty($find_child_designation_column)){
                    array_push($childcolumns,"staff_designation_master.designation_name AS verified_designation");


                } 

             array_push($childcolumns,"staff_master.staff_name,allot_child.missionary_emp_id as allo,allot_child.sponsor_id as allot_sponsor");   
             $res_chk_child=$this->db->select(implode(',', $childcolumns))
                    ->join('staff_designation_master', 'staff_children.verified_designation=staff_designation_master.id', 'left')
                    ->join('staff_master', 'staff_master.id=staff_id', 'left')
                    ->join('allot_child', 'staff_children.staff_id=allot_child.missionary_emp_id', 'left') 
                    ->order_by('staff_children.id', 'desc')
                    ->get('staff_children');  

               // $chk=$this->db->select("staff_id,allot_child.missionary_emp_id as allo")
               //      ->join('allot_child', 'staff_children.staff_id=allot_child.missionary_emp_id', 'left') 
               //       ->get('staff_children'); 
             //print_r($chk->result_array());die();   
            
        }   
        //pr($res_chk_child->result_array());die();

         if(isset($res_chk_sponsorship))
                {
                   // pr($res_chk_sponsorship->result_array());die(); 
                    global $gender, $childgender, $age_group,  $marital_status, $part_india, $identities, $emtypes, $blood_group, $family_position, $dedication_needed, $languages, $missionary_prefrence;

                    if($res_chk_sponsorship->num_rows()>0){

                        foreach($res_chk_sponsorship->result_array() as $key=>$sponsorship){

                                if(isset($sponsorship['sponser_preference_gender']))
                                {
                                    $sponsorship['sponser_preference_gender'] = $gender[$sponsorship['sponser_preference_gender']];
                                }

                                if(isset($sponsorship['sponser_dedication_needed']))
                                {
                                    $sponsorship['sponser_dedication_needed'] = $dedication_needed[$sponsorship['sponser_dedication_needed']];
                                }

                            if(isset($res_chk_sponsor))
                            {

                                if($res_chk_sponsor->num_rows()>0){

                                    foreach($res_chk_sponsor->result_array() as $key1=>$sponsor){


                                        if(isset($sponsor['sponser_preference_language']) && $sponsor['sponser_preference_language']!=NULL)
                                        {
                                            $sponsor['sponser_preference_language'] = $languages[$sponsor['sponser_preference_language']];
                                        }

                                        if(isset($sponsor['sponser_missionary_preference']) && $sponsor['sponser_missionary_preference']!=NULL)
                                        {
                                            $sponsor['sponser_missionary_preference'] = $missionary_prefrence[$sponsor['sponser_missionary_preference']];
                                        }
                                        //var_dump($sponsor['sponser_preference_language']); die();

                                        /*mani***/

                                        foreach ($res_chk_child->result_array() as $key => $value_child) 
                                        {
                                            if($sponsor['id']==$value_child['allot_sponsor'])
                                            {

                                                $child_sponsor_data=array_merge($sponsorship, $value_child);  
                                                  // $a[]=$value_child;    
                                            }

                                        }
                                       
                                       // pr($mergedata);die();
                                        /**/

                                       if($sponsorship['sponsor_group_id']==$sponsor['id'])
                                       {
                                            
                                            $mergedata=array_merge($sponsorship, $sponsor,$child_sponsor_data);

                                           // $result[]=array($mergedata);


                                            if(isset($res_chk_promo))
                                            {

                                                if($res_chk_promo->num_rows()>0){

                                                   // var_dump($res_chk_promo); die();

                                                    foreach($res_chk_promo->result_array() as $key1=>$promo){

                                                       if($sponsor['sponser_promo_office']==$promo['promo_office_name'])
                                                       {
                                                            
                                                            $mergepromodata=array_merge($mergedata, $promo);

                                                            $result[]=array($mergepromodata);
                                                       }

                                                    }
                                                }
                                            }
                                            else
                                            {
                                                $result[]=array($mergedata);
                                            }
                                       }



                                    }
                                    //$result[]=array($child_sponsor_data);
                                    
                                }

                            }
                            else
                            {
                                $result[]=array($sponsorship);
                            }

                        }
                       // pr($result);die();
                    }

                }

        /***Sponsor field Based result Bind***/
        else if(isset($res_chk_sponsor))
        {
            if($res_chk_sponsor->num_rows()>0){
                foreach($res_chk_sponsor->result_array() as $key1=>$sponsor){
                        $result[]=array($sponsor);
                }
            }
        }

        else if(isset($model->selectedchildvalue))
        {


            if($res_chk_child->num_rows()>0){
                foreach($res_chk_child->result_array() as $key1=>$child){
                    if(isset($child['gender']))
                    {
                        $child['gender'] = $childgender[$child['gender']];
                    }
                    if(isset($child['marital_status']))
                    {
                        $child['marital_status'] = $marital_status[$child['marital_status']];
                    }
                    if(isset($child['age_group']))
                    {
                        $child['age_group'] = $age_group[$child['age_group']];
                    }
                    // if($child['staff_id']==$value['id'])
                    // {
                        $result[]=array($child);
                    //}

                }
               // print_r($result);die();
            }

        }
        //pr($result);die(); 
        /*****End**/

        /****Sponsor field Based result Bind****/
        
        /******/
       if($result!=NULL)
        {
            $response['result']=$result;
        }
        else
        {
            $response['result']=NULL;
        }
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


     public function gems_get_sponsor_report_master() {

       $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";

        $model = json_decode($this->input->post('model',FALSE));

        $result=NULL;

        if($model!=''){


                $res_allot_mission=$this->db->select()
                            ->get('allot_missionary'); 


                       // pr($model);die();    
                //var_dump($res_allot_mission); die();

                if(isset($model->selectedstaffvalue))
                {
                     array_push($model->selectedstaffvalue, "id");
                     array_push($model->selectedstaffvalue, "staff_name");
                     array_push($model->selectedstaffvalue, "staff_employee_id");

                      $columns = array_map(function($column) {
                        return 'staff_master.' . $column;
                    }, $model->selectedstaffvalue);

                      $find_zone_column=array_search("staff_master.zone_id",$columns);
                        if(!empty($find_zone_column)){
                            array_push($columns,"zones_staff_master.staff_zone_name AS zone_id");


                        }

                       $find_state_column=array_search("staff_master.present_state_id",$columns);
                        if(!empty($find_state_column)){
                            array_push($columns,"state_zone_master.state_zone_name AS present_state_id");


                        } 

                        $find_category_column=array_search("staff_master.staff_category_id",$columns);
                        if(!empty($find_category_column)){
                            array_push($columns," staff_category_master.staff_category_name AS staff_category_id");


                        } 

                        $find_designation_column=array_search("staff_master.staff_designation_id",$columns);
                        if(!empty($find_designation_column)){
                            array_push($columns,"staff_designation_master.designation_name AS staff_designation_id");


                        } 

                        $find_department_column=array_search("staff_master.staff_department_id",$columns);
                        if(!empty($find_department_column)){
                            array_push($columns,"staff_department_master.department_name AS staff_department_id");


                        } 

                        
                       
                     
                     $res_chk_staff=$this->db->select(implode(',', $columns))
                            ->join('zones_staff_master', 'staff_master.zone_id=zones_staff_master.id', 'left')
                            ->join('state_zone_master', 'staff_master.present_state_id=state_zone_master.id', 'left')
                            ->join('staff_category_master', 'staff_master.staff_category_id=staff_category_master.id', 'left')
                            ->join('staff_designation_master', 'staff_master.staff_designation_id=staff_designation_master.id', 'left')
                            ->join('staff_department_master', 'staff_master.staff_department_id=staff_department_master.id', 'left');

                            if(isset($model->staff_employee_id) && $model->staff_employee_id!="")
                            {   
                                $res_chk_staff=$this->db->where('staff_employee_id', $model->staff_employee_id);
                            }

                            if(isset($model->staff_gender) && $model->staff_gender!="")
                            {   
                                $res_chk_staff=$this->db->where('staff_gender', $model->staff_gender);
                            }

                            if(isset($model->zone_id) && $model->zone_id!="")
                            {   
                                $res_chk_staff=$this->db->where('zone_id', $model->zone_id);
                            }

                            if(isset($model->present_state_id) && $model->present_state_id!="")
                            {   
                                $res_chk_staff=$this->db->where('present_state_id', $model->present_state_id);
                            }

                            if(isset($model->staff_identity_id) && $model->staff_identity_id!="")
                            {   
                                $res_chk_staff=$this->db->where('staff_identity_id', $model->staff_identity_id);
                            }

                            if(isset($model->staff_department_id) && $model->staff_department_id!="")
                            {   
                                $res_chk_staff=$this->db->where('staff_department_id', $model->staff_department_id);
                            }

                            if(isset($model->staff_type_id) && $model->staff_type_id!="")
                            {   
                                $res_chk_staff=$this->db->where('staff_type_id', $model->staff_type_id);
                            }

                            if(isset($model->staff_designation_id) && $model->staff_designation_id!="")
                            {   
                                $res_chk_staff=$this->db->where('staff_designation_id', $model->staff_designation_id);
                            }

                        $res_chk_staff=$this->db->order_by('staff_master.id', 'desc')
                        ->get('staff_master'); 

                       // var_dump($res_chk); die();
                }
                else
                {   

                    $res_chk_staff=$this->db->select("staff_name, id");

                        if(isset($model->staff_employee_id) && $model->staff_employee_id!="")
                        {   
                            $res_chk_staff=$this->db->where('staff_employee_id', $model->staff_employee_id);
                        }

                        if(isset($model->staff_gender) && $model->staff_gender!="")
                        {   
                            $res_chk_staff=$this->db->where('staff_gender', $model->staff_gender);
                        }

                        if(isset($model->zone_id) && $model->zone_id!="")
                        {   
                            $res_chk_staff=$this->db->where('zone_id', $model->zone_id);
                        }

                        if(isset($model->present_state_id) && $model->present_state_id!="")
                        {   
                            $res_chk_staff=$this->db->where('present_state_id', $model->present_state_id);
                        }

                        if(isset($model->staff_identity_id) && $model->staff_identity_id!="")
                        {   
                            $res_chk_staff=$this->db->where('staff_identity_id', $model->staff_identity_id);
                        }

                        if(isset($model->staff_department_id) && $model->staff_department_id!="")
                        {   
                            $res_chk_staff=$this->db->where('staff_department_id', $model->staff_department_id);
                        }

                        if(isset($model->staff_type_id) && $model->staff_type_id!="")
                        {   
                            $res_chk_staff=$this->db->where('staff_type_id', $model->staff_type_id);
                        }

                        if(isset($model->staff_designation_id) && $model->staff_designation_id!="")
                        {   
                            $res_chk_staff=$this->db->where('staff_designation_id', $model->staff_designation_id);
                        }

                        $res_chk_staff=$this->db->order_by('staff_master.id', 'desc')
                        ->get('staff_master'); 
                }





                if(isset($model->selectedsponsorvalue))
                {
                    //var_dump($model->selectedsponsorvalue); die();

                    array_push($model->selectedsponsorvalue, "id");
                    array_push($model->selectedsponsorvalue, "sponser_promo_office");
                 

                    $sponsorcolumns = array_map(function($column) {
                        return 'sponsor_master.' . $column;
                    }, $model->selectedsponsorvalue);

                   
                    $find_country_column=array_search('sponsor_master.sponser_country_id',$sponsorcolumns);

                        if(!empty($find_country_column)){

                            array_push($sponsorcolumns,"country.country_name AS sponser_country_id");


                        }

                     $find_state_column=array_search('sponsor_master.sponser_state',$sponsorcolumns);

                        if(!empty($find_state_column)){

                            array_push($sponsorcolumns,"state_zone_master.state_zone_name AS sponser_state");


                        }   

                      $find_promo_column=array_search('sponsor_master.sponser_promo_office',$sponsorcolumns);

                        if(!empty($find_promo_column)){

                            array_push($sponsorcolumns,"promotional_office_master.promo_office_name AS sponser_promo_office");


                        }    

                        // pr($sponsorcolumns);die();
                     $res_chk_sponsor=$this->db->select(implode(',', $sponsorcolumns))
                            ->join('country', 'sponsor_master.sponser_country_id=country.id', 'left')
                            ->join('state_zone_master', 'sponsor_master.sponser_state=state_zone_master.id', 'left')
                            ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left');

                            if(isset($model->sponser_promo_office) && $model->sponser_promo_office!="")
                            {   
                                $res_chk_sponsor=$this->db->where('sponser_promo_office', $model->sponser_promo_office);
                            }



                            $res_chk_sponsor=$this->db->order_by('sponsor_master.id', 'desc')
                            ->get('sponsor_master');  


                }

                if(isset($model->selectedsponsorshipvalue))
                {

                    array_push($model->selectedsponsorshipvalue, "id");
                    array_push($model->selectedsponsorshipvalue, "sponsor_group_id");

                    

                    $sponsorshipcolumns = array_map(function($column) {
                        return 'sponsorship_master.' . $column;
                    }, $model->selectedsponsorshipvalue);



                    $find_category_column=array_search('sponsorship_master.category_sponsorship',$sponsorshipcolumns);

                        if(!empty($find_category_column)){

                            array_push($sponsorshipcolumns,"staff_category_master.staff_category_name AS category_sponsorship");


                        }


                        $find_state_column=array_search("sponsorship_master.sponser_preference_state",$sponsorshipcolumns);
                        if(!empty($find_state_column)){
                            array_push($sponsorshipcolumns,"state_zone_master.state_zone_name AS sponser_preference_state");


                        } 


                     $res_chk_sponsorship=$this->db->select(implode(',', $sponsorshipcolumns))
                            ->join('staff_category_master', 'sponsorship_master.category_sponsorship=staff_category_master.id', 'left')
                            ->join('state_zone_master', 'sponsorship_master.sponser_preference_state=state_zone_master.id', 'left');

                            if(isset($model->sponser_dedication_needed) && $model->sponser_dedication_needed!="")
                            {   
                                $res_chk_sponsorship=$this->db->where('sponser_dedication_needed', $model->sponser_dedication_needed);
                            }

                            if(isset($model->sponsor_allot_mission_status) && $model->sponsor_allot_mission_status!="")
                            {   
                                $res_chk_sponsorship=$this->db->where('sponsor_allot_mission_status', $model->sponsor_allot_mission_status);
                            }

                            if(isset($model->sponsor_from_month) && $model->sponsor_from_month!="")
                            {   
                               
                                $res_chk_sponsorship=$this->db->where('DATE_FORMAT(sponsor_from_date, "%m") = "'.$model->sponsor_from_month.'"');
 
                            }

                            if(isset($model->sponsor_from_year) && $model->sponsor_from_year!="")
                            {   
                               
                                $res_chk_sponsorship=$this->db->where('DATE_FORMAT(sponsor_from_date, "%Y") = "'.$model->sponsor_from_year.'"');
 
                            }

                            if(isset($model->sponsor_to_month) && $model->sponsor_to_month!="")
                            {   
                               
                                $res_chk_sponsorship=$this->db->where('DATE_FORMAT(sponsor_to_date, "%m") = "'.$model->sponsor_to_month.'"');
 
                            }

                            if(isset($model->sponsor_to_year) && $model->sponsor_to_year!="")
                            {   
                               
                                $res_chk_sponsorship=$this->db->where('DATE_FORMAT(sponsor_to_date, "%Y") = "'.$model->sponsor_to_year.'"');
 
                            }

                            

                            $res_chk_sponsorship=$this->db->order_by('sponsorship_master.id', 'desc')
                            ->get('sponsorship_master');    

                            //echo $this->db->last_query(); exit;

                            //var_dump($res_chk_sponsorship); die();
                }

                if(isset($model->selectedpromovalue))
                {

                    array_push($model->selectedpromovalue, "id");
                    array_push($model->selectedpromovalue, "promo_office_name");
                    

                    $promocolumns = array_map(function($column) {
                        return 'promotional_office_master.' . $column;
                    }, $model->selectedpromovalue);


                     $find_state_column=array_search("promotional_office_master.promo_state_id",$promocolumns);
                        if(!empty($find_state_column)){
                            array_push($promocolumns,"state_zone_master.state_zone_name AS promo_state_id");


                        } 

                     $res_chk_promo=$this->db->select(implode(',', $promocolumns))
                            ->join('state_zone_master', 'promotional_office_master.promo_state_id=state_zone_master.id', 'left');

                            if(isset($model->zone_id) && $model->zone_id!="")
                            {   
                                $res_chk_promo=$this->db->where('promo_zone_location', $model->zone_id);
                            }

                            $res_chk_promo=$this->db->order_by('promotional_office_master.id', 'desc')
                            ->get('promotional_office_master');  

                    //var_dump($res_chk_promo); die();
                }

               if(isset($model->selectedstaffvalue))
                {

                    
                    foreach ($res_allot_mission->result_array() as $key => $mission) {

                        foreach ($res_chk_staff->result_array() as $key => $staff) {

                            
                            if($mission['missionary_emp_id']==$staff['staff_employee_id'])
                            {
                                
                                $mergedata=array_merge($mission, $staff);

                            }

                        }

                        if(isset($res_chk_sponsorship))
                        {
                            foreach($res_chk_sponsorship->result_array() as $key=>$sponsorship){

                                if($mission['sponsor_id']==$sponsorship['id'])
                                {
                                    
                                    $mergedata=array_merge($mergedata, $sponsorship);

                                    foreach($res_chk_sponsor->result_array() as $key=>$sponsor){

                                        if($sponsorship['sponsor_group_id']==$sponsor['id'])
                                        {
                                            if(isset($res_chk_promo))
                                            {

                                                if($res_chk_promo->num_rows()>0){

                                                   // var_dump($res_chk_promo); die();

                                                    foreach($res_chk_promo->result_array() as $key1=>$promo){

                                                       if($sponsor['sponser_promo_office']==$promo['promo_office_name'])
                                                       {
                                                            
                                                            $mergedata=array_merge($mergedata, $promo);

                                                            
                                                       }

                                                    }
                                                }
                                            }
                                            else
                                            {
                                                $result[]=array($mergedata);
                                            }
                                            $mergedata=array_merge($mergedata, $sponsor);

                                        }

                                    }

                                }

                            }
                        }

                        $result[]=array($mergedata);
                        

                    }

                   // var_dump($result); die();
        
                }
                else if(isset($res_chk_sponsorship))
                {

                    global $gender, $childgender, $age_group,  $marital_status, $part_india, $identities, $emtypes, $blood_group, $family_position, $dedication_needed, $languages, $missionary_prefrence;

                    if($res_chk_sponsorship->num_rows()>0){

                        foreach($res_chk_sponsorship->result_array() as $key=>$sponsorship){

                                if(isset($sponsorship['sponser_preference_gender']))
                                {
                                    $sponsorship['sponser_preference_gender'] = $gender[$sponsorship['sponser_preference_gender']];
                                }

                                if(isset($sponsorship['sponser_dedication_needed']))
                                {
                                    $sponsorship['sponser_dedication_needed'] = $dedication_needed[$sponsorship['sponser_dedication_needed']];
                                }

                            if(isset($res_chk_sponsor))
                            {

                                if($res_chk_sponsor->num_rows()>0){

                                    foreach($res_chk_sponsor->result_array() as $key1=>$sponsor){


                                        if(isset($sponsor['sponser_preference_language']) && $sponsor['sponser_preference_language']!=NULL)
                                        {
                                            $sponsor['sponser_preference_language'] = $languages[$sponsor['sponser_preference_language']];
                                        }

                                        if(isset($sponsor['sponser_missionary_preference']) && $sponsor['sponser_missionary_preference']!=NULL)
                                        {
                                            $sponsor['sponser_missionary_preference'] = $missionary_prefrence[$sponsor['sponser_missionary_preference']];
                                        }
                                        //var_dump($sponsor['sponser_preference_language']); die();

                                       if($sponsorship['sponsor_group_id']==$sponsor['id'])
                                       {
                                            
                                            $mergedata=array_merge($sponsorship, $sponsor);

                                           // $result[]=array($mergedata);


                                            if(isset($res_chk_promo))
                                            {

                                                if($res_chk_promo->num_rows()>0){

                                                   // var_dump($res_chk_promo); die();

                                                    foreach($res_chk_promo->result_array() as $key1=>$promo){

                                                       if($sponsor['sponser_promo_office']==$promo['promo_office_name'])
                                                       {
                                                            
                                                            $mergepromodata=array_merge($mergedata, $promo);

                                                            $result[]=array($mergepromodata);
                                                       }

                                                    }
                                                }
                                            }
                                            else
                                            {
                                                $result[]=array($mergedata);
                                            }
                                       }

                                    }
                                }
                            }
                            else
                            {
                                $result[]=array($sponsorship);
                            }

                            
                            

                        }
                    }
                }
                else if(isset($res_chk_sponsor))
                {

                    if($res_chk_sponsor->num_rows()>0){

                        foreach($res_chk_sponsor->result_array() as $key1=>$sponsor){

                                $result[]=array($sponsor);

                        }
                    }

                }
                else if(isset($res_chk_promo))
                {

                    if($res_chk_promo->num_rows()>0){

                        foreach($res_chk_promo->result_array() as $key=>$promo){

                                $result[]=array($promo);

                        }
                    }
                }


                // else
                // {
                //     $response['status']="failure";            
                //     $response['message']="Sorry!!, Invalid Attempt!!.. Permission denied.";
                // }


        }
            if($result!=NULL)
            {
                $response['result']=$result;
            }
            else
            {
                $response['result']=NULL;
            }
            die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    public function gems_add_church_land_docs(){
        $last_inserted_church_id=$this->input->post('churchid',FALSE);
         $currentDocument=$this->input->post('currentDocument',FALSE);
         $data=array();
         //pr($_FILES);die();
        if($_FILES)
        {
            
            for( $i=0 ; $i < count($_FILES['file']['name']); $i++ ) 
            {
                
                $filename = $_FILES['file']['name'][$i];   
                 $tmp = explode('.', $filename);
                 $extension=end($tmp); 
                $newfilename=rand().date('Y_m_d_h_i_s') .".".$extension;

                $targetPath = "upload/multiple";
                $temp_path=$targetPath."/";
                $destination =$temp_path.$newfilename;               
                

                $tmpFilePath = $_FILES['file']['tmp_name'][$i];

                  if ($tmpFilePath != "")
                  {
                    $newFilePath = "./uploadFiles/" . $_FILES['file']['name'][$i];
                    if(move_uploaded_file($tmpFilePath, $destination)) 
                    {
                        // $data=array('file_name'=>$newfilename);
                         $data[]=$newfilename;
                        //$this->db->set('deleted_at', 'NOW()', FALSE);
                        
                    }
                    else if(!move_uploaded_file($tmpFilePath, $destination)){
                        $response['status']="failure";            
                        $response['message']="Sorry!!, Unable to Upload the Documents";
                     }
                  }
            } 
            if($currentDocument!=''){
                array_push($data,$currentDocument);
            }
            $Filename_list=implode(",",$data);
           // pr($Filename_list);
             $data_list=array('file_name'=>$Filename_list);
            //die();
            $this->db->where('id',$last_inserted_church_id);
            $this->db->update($this->db->dbprefix('church_master'),$data_list);
            //pr($this->db->last_query());die();
            $response['message']="Church record stored successfully";
        }
        else{
           // pr($currentDocument);
            if($currentDocument!=''){
                array_push($data,$currentDocument);
            }
            $Filename_list=implode(",",$data);
           
             $data_list=array('file_name'=>$Filename_list);
            //die();
            $this->db->where('id',$last_inserted_church_id);
            $this->db->update($this->db->dbprefix('church_master'),$data_list);
            //pr($this->db->last_query());die();
            $response['message']="Church record stored successfully";
        }
        die(json_encode($response, JSON_UNESCAPED_SLASHES));    
    }


    public function gems_add_staff_docs()
    {
       //pr($_FILES);die(); 
       $last_inserted_staff_id=$this->input->post('staffid',FALSE);
       $currentDocument=$this->input->post('currentDocument',FALSE);
       $data=array();
       //print_r($_FILES);die();
       if($_FILES)
        {
            for( $i=0 ; $i < count($_FILES['file']['name']); $i++ ) 
            {   
                $filename = $_FILES['file']['name'][$i];   
                $tmp = explode('.', $filename);
                $extension=end($tmp); 
                $newfilename=rand().date('Y_m_d_h_i_s') .".".$extension;

                $targetPath = "upload/multiple";
                $temp_path=$targetPath."/";
                $destination =$temp_path.$newfilename;
                $tmpFilePath = $_FILES['file']['tmp_name'][$i];

                if ($tmpFilePath != "")
                {
                    $newFilePath = "./uploadFiles/" . $_FILES['file']['name'][$i];
                    if(move_uploaded_file($tmpFilePath, $destination)) 
                    {
                        $data[]=$newfilename;
                    }
                    else if(!move_uploaded_file($tmpFilePath, $destination)){
                        $response['status']="failure";            
                        $response['message']="Sorry!!, Unable to Upload the Documents";
                        }
                }
            }
      
        }

        if($currentDocument!='')
        {
            array_push($data,$currentDocument);
        }

        $Filename_list=implode(",",$data);
        // pr($Filename_list);
        $data_list=array('file_name'=>$Filename_list);
        //die();
        $this->db->where('id',$last_inserted_staff_id);
        $this->db->update($this->db->dbprefix('staff_master'),$data_list);
        //pr($this->db->last_query());die();
        $response['status']="success"; 
        $response['message']="staff record stored successfully";
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    public function gems_insert_church_master() {

        //print_r($model);
        
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        //$model->resultexpstore=
       // $model->detail_pioneer=$model->resultexpstore; 
       //print_r($model->resultexpstore);die();
       

        if (isset($model)) {


                $this->db->insert('church_master', $model);
                
                if($this->db->insert_id()){
                    $response['result']=array('id'=>$this->db->insert_id());
                    $response['message']="Church record stored successfully";
                }else{
                    $response['status']="failure";            
                    $response['message']="Sorry!!, Unable to insert the Allot Child data";
                }

               
        } else {
            $response['status']="failure";
            $response['message']="Choose Church and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


    public function gems_get_church_master() {

        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

            $res=$this->db->select("church_master.id AS church_id, DATE_FORMAT(".$this->db->dbprefix('church_master.')."created_at,'%d/%m/%Y')as created_date1, DATE_FORMAT(".$this->db->dbprefix('church_master.')."approve_at,'%d/%m/%Y')as approved_date, church_master.*,zones_staff_master.*,village_master.*")
            ->join('zones_staff_master', 'church_master.staff_zone_id=zones_staff_master.id', 'left')
            ->join('village_master', 'church_master.village_town=village_master.id', 'left')
            ->where('church_master.is_deleted','0')
            ->get('church_master');


           if($res->num_rows()>0){

                $result = $res->result_array();

              
                if($result){
                    $response['result']=$result;
                    $response['message']="Church record get successfully";
                }else{
                    $response['status']="failure";            
                    $response['message']="Sorry!!, Unable to getbChurch data";
                }

               
        } else {
            $response['status']="failure";
            $response['message']="Choose Church and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


     public function gems_fetch_church_master($id)
    {
        //var_dump($id); die();
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();

            $res=$this->db->query("select * from ".$this->db->dbprefix('church_master')." where id='".$id."'");

            if($res->num_rows()>0){
                $in_array=$res->result_array();
                $result=$in_array[0];
            }else{
                $response['status']="failure";
                $response['message']=" No Church record found!!";
            }
            $response['result']=$result;

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }

    
    public function gems_update_church_master() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

       // print_r($model);die();

        if (isset($model)) {
        
            $this->db->where('id',$model->id);
            $result=$this->db->update('church_master', $model);
          //  pr($this->db->last_query());die();

            if ($result) {
                $response['message']="Church has been updated successfully";
            }
            else
            {
                 $response['status']="failure";
            $response['message']="Church has not been updated fully";
            }
            

        } else {
            $response['status']="failure";
            $response['message']="Choose Church and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


    public function gems_delete_church_master($id){
        
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";


        $res_chk=$this->db->query("select id from ".$this->db->dbprefix('church_master')." where id='".$id."' ");
        
        if($res_chk->num_rows()>0){

            $data=array('is_deleted'=>'1');

            $this->db->set('deleted_at', 'NOW()', FALSE);
            $this->db->where('id',$id);
            $this->db->update($this->db->dbprefix('church_master'),$data);

            $response['status']="success";
            $response['message']="Church record has been deleted successfully";
            
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";    
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();        
    }


    public function gems_insert_six_month_report_master() {

        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        if (isset($model)) {


                $this->db->insert('church_six_month_report', $model);
                
                if($this->db->insert_id()){
                    $response['result']=array('id'=>$this->db->insert_id());
                    $response['message']="Six Month Report record stored successfully";
                }else{
                    $response['status']="failure";            
                    $response['message']="Sorry!!, Unable to insert the Six Month Report";
                }

               
        } else {
            $response['status']="failure";
            $response['message']="Choose Six Month Report and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


    public function gems_get_church_six_month_report_master() {

        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

            $res=$this->db->select("church_six_month_report.id AS sixmonth_id,church_six_month_report.church_id as church_id, DATE_FORMAT(".$this->db->dbprefix('church_six_month_report.')."created_at,'%d/%m/%Y')as created_date1, DATE_FORMAT(".$this->db->dbprefix('church_six_month_report.')."rep_sadmin_approve_date,'%d/%m/%Y')as rep_sadmin_approve_date1,  church_six_month_report.*,zones_staff_master.*,church_master.*,village_master.*")
            ->join('zones_staff_master', 'church_six_month_report.staff_zone_id=zones_staff_master.id', 'left')
            ->join('church_master', 'church_six_month_report.church_id=church_master.id', 'left')
            ->join('village_master', 'church_six_month_report.village_town=village_master.id', 'left')
            ->where('church_six_month_report.is_deleted','0')
            ->get('church_six_month_report');

             $html="";
           if($res->num_rows()>0){
            global $api_path;

                $result = $res->result_array();



              
                if($result){
                    $response['result']=$result;
                    $response['message']="Six Month Report record get successfully";
                }else{
                    $response['status']="failure";            
                    $response['message']="Sorry!!, Unable to Six Month Report data";
                }

               
        } else {
            $response['status']="failure";
            $response['message']="Choose Church and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }
    
    public function gems_fetch_six_month_report_master($id)
    {
        //var_dump($id); die();
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();

            $res=$this->db->query("select * from ".$this->db->dbprefix('church_six_month_report')." where id='".$id."'");
            //pr($this->db->last_query());die();
            if($res->num_rows()>0){
                $in_array=$res->result_array();
                $result=$in_array[0];
            }else{
                $response['status']="failure";
                $response['message']=" No Six Month Report record found!!";
            }
            $response['result']=$result;

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }


    public function gems_update_six_month_report_master() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

        unset($model->id);
        if (isset($model)) {
        
            //$this->db->where('id',$id);
            $result=$this->db->update('church_six_month_report', $model);


            if ($result) {
                $response['message']="Six Month Report has been updated successfully";
            }
            else
            {
                 $response['status']="failure";
            $response['message']="Six Month Report has not been updated fully";
            }
            

        } else {
            $response['status']="failure";
            $response['message']="Choose Six Month Report and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    public function gems_delete_church_six_month_master($id){
            
            $this->output->set_content_type('application/json');
            $response=array();
            $response['status']="success";


            $res_chk=$this->db->query("select id from ".$this->db->dbprefix('church_six_month_report')." where id='".$id."' ");
            
            if($res_chk->num_rows()>0){

                $data=array('is_deleted'=>'1');

                $this->db->set('deleted_at', 'NOW()', FALSE);
                $this->db->where('id',$id);
                $this->db->update($this->db->dbprefix('church_six_month_report'),$data);

                $response['status']="success";
                $response['message']="Church record has been deleted successfully";
                
            }else{
                $response['status']="failure";
                $response['message']="Invalid Attempt!!.. Access denied..";    
            }
             echo json_encode($response,JSON_UNESCAPED_SLASHES);
             die();        
        }

    public function gems_find_month_date_language_duplicate(){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));
        //pr($model);die();
        $where='';
        if($model->id!=''){
            $where="AND id='".$model->id."'";
        }
        $month=($model->from_month_report->value)?$model->from_month_report->value:'';
        $year=($model->from_year_report)?$model->from_year_report:'';
        $language=($model->language)?$model->language:'';
                
        $res_chk=$this->db->query("select id from ".$this->db->dbprefix('staff_monthly_report')." where from_month_report='".$month."' AND from_year_report='".$year."' AND language='".$language."' ".$where." ");
                //print_r($this->db->last_query());die();
        if($res_chk->num_rows()>0){
            $response['status']="exist";            
            $response['message']="Selected language is already exist in same month";
        }
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    public function gems_insert_staff_monthly_report_master() {

        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));

       

        if (isset($model)) {

              
                    //print_r("here22");die();
                    $model->from_month_report=$model->from_month_report->value;
                    //print_r($model);die();
                    $this->db->insert('staff_monthly_report', $model);
                    
                    if($this->db->insert_id()){
                        $response['result']=array('id'=>$this->db->insert_id());
                        $response['message']="Staff Month record stored successfully";
                    }else{
                        $response['status']="failure";            
                        $response['message']="Sorry!!, Unable to insert the Staff Month data";
                    }  
              
               
        } else {
            $response['status']="failure";
            $response['message']="Choose Staff and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }






    public function gems_get_staff_month_report_master() {

        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

            $res=$this->db->select("staff_monthly_report.id AS staff_month_id, staff_master.id AS staff_id, DATE_FORMAT(".$this->db->dbprefix('staff_monthly_report.')."created_at,'%d/%m/%Y')as created_date1, staff_monthly_report.*, zones_staff_master.*, staff_master.*")
            ->join('zones_staff_master', 'staff_monthly_report.staff_zone_id=zones_staff_master.id', 'left')
            ->join('staff_master', 'staff_monthly_report.staff_id=staff_master.id', 'left')
            ->where('staff_monthly_report.is_deleted','0')
            ->get('staff_monthly_report');

             $html="";
           if($res->num_rows()>0){
            global $api_path;

                $result = $res->result_array();


                foreach($result as $key=>$value){


                        $html=' <a title="Sponsorship View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewstaffmonthreport/'.$value['staff_month_id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>';


                        //$result[]=array('userid'=>$value['id'],'staff_zone_name'=>$value['staff_zone_name'],'region_id'=>$value['region_id'],'email_id'=>$value['email_id'],'ad_office'=>$value['ad_office'],'region_name'=>$value['region_name'],'created_date'=>$value['created_date'],'action'=>$html);

                        $value['action']=array($html);

                        $resultdata[]=$value;
                }

                // echo "<pre>";
                // var_dump($resultdata); die();
              
                if($resultdata){
                    $response['result']=$resultdata;
                    $response['message']="Staff Month Report record get successfully";
                }else{
                    $response['status']="failure";            
                    $response['message']="Sorry!!, Unable to Staff Month Report data";
                }

               
        } else {
            $response['status']="failure";
            $response['message']="Choose Staff and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


    public function gems_fetch_staff_month_report_master($id)
    {
        //var_dump($id); die();
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();

            $res=$this->db->query("select * from ".$this->db->dbprefix('staff_monthly_report')." where id='".$id."'");

            if($res->num_rows()>0){
                $in_array=$res->result_array();
                $result=$in_array[0];
            }else{
                $response['status']="failure";
                $response['message']=" No Staff Month Report record found!!";
            }
            $response['result']=$result;

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }


    public function gems_update_staff_month_report_master() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));
         unset($model->id);
        //pr($model);die();

        if (isset($model)) {
        
           
            $result=$this->db->update('staff_monthly_report', $model);


            if ($result) {
                $response['message']="Staff Month Report has been updated successfully";
            }
            else
            {
                 $response['status']="failure";
            $response['message']="Staff Month Report has not been updated fully";
            }
            

        } else {
            $response['status']="failure";
            $response['message']="Choose Staff Month Report and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    public function gems_delete_staff_month_master($id){
            
            $this->output->set_content_type('application/json');
            $response=array();
            $response['status']="success";


            $res_chk=$this->db->query("select id from ".$this->db->dbprefix('staff_monthly_report')." where id='".$id."' ");
            
            if($res_chk->num_rows()>0){

                $data=array('is_deleted'=>'1');

                $this->db->set('deleted_at', 'NOW()', FALSE);
                $this->db->where('id',$id);
                $this->db->update($this->db->dbprefix('staff_monthly_report'),$data);

                $response['status']="success";
                $response['message']="Staff Month record has been deleted successfully";
                
            }else{
                $response['status']="failure";
                $response['message']="Invalid Attempt!!.. Access denied..";    
            }
             echo json_encode($response,JSON_UNESCAPED_SLASHES);
             die();        
        }



        public function gems_get_flat_report_master() {

       $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";

        $model = json_decode($this->input->post('model',FALSE));

        $result=NULL;

        if($model!=''){

                if(isset($model->selectedstaffvalue))
                {
                     array_push($model->selectedstaffvalue, "id");
                     array_push($model->selectedstaffvalue, "staff_name");

                      $columns = array_map(function($column) {
                        return 'staff_master.' . $column;
                    }, $model->selectedstaffvalue);

                      $find_zone_column=array_search("staff_master.zone_id",$columns);
                        if(!empty($find_zone_column)){
                            array_push($columns,"zones_staff_master.staff_zone_name AS zone_id");


                        }

                     $res_chk=$this->db->select(implode(',', $columns))
                            ->join('zones_staff_master', 'staff_master.zone_id=zones_staff_master.id', 'left');

                            if(isset($model->zone_id) && $model->zone_id!="")
                            {   
                                $res_chk=$this->db->where('zone_id', $model->zone_id);
                            }

                            if(isset($model->staff_id) && $model->staff_id!="")
                            {   
                                $res_chk=$this->db->where('staff_master.id', $model->staff_id);
                            }

                        $res_chk=$this->db->order_by('staff_master.id', 'desc')
                        ->get('staff_master'); 

                        //var_dump($res_chk); die();
                }
                else
                {   

                    $res_chk=$this->db->select("staff_name, id");


                        if(isset($model->zone_id) && $model->zone_id!="")
                        {   
                            $res_chk=$this->db->where('zone_id', $model->zone_id);
                        }

                        if(isset($model->staff_id) && $model->staff_id!="")
                        {   
                            $res_chk=$this->db->where('id', $model->staff_id);
                        }


                        $res_chk=$this->db->order_by('staff_master.id', 'desc')
                        ->get('staff_master'); 
                }
                //var_dump($model->selectedchildvalue!='undefined'); die();

                
                if(isset($model->selectedchildvalue))
                {
                    array_push($model->selectedchildvalue, "staff_id");
                    array_push($model->selectedchildvalue, "from_month_report");
                    array_push($model->selectedchildvalue, "from_year_report");
                    array_push($model->selectedchildvalue, "to_month_report");
                    array_push($model->selectedchildvalue, "to_year_report");
                    array_push($model->selectedchildvalue, "church_id");
                 

                    $childcolumns = array_map(function($column) {
                        return 'church_six_month_report.' . $column;
                    }, $model->selectedchildvalue);


                    // $find_child_designation_column=array_search("staff_children.verified_designation",$childcolumns);
                    //     if(!empty($find_child_designation_column)){
                    //         array_push($childcolumns,"staff_designation_master.designation_name AS verified_designation");


                    //     } 

                     $res_chk_child=$this->db->select(implode(',', $childcolumns))
                            ->select('church_master.church_name, church_master.type_church')
                            ->join('church_master', 'church_six_month_report.church_id=church_master.id', 'left');

                            if(isset($model->type_church) && $model->type_church!="")
                            {   
                                $res_chk_child=$this->db->where('church_master.type_church', $model->type_church);
                            }

                            $res_chk_child=$this->db->order_by('church_six_month_report.id', 'desc')
                            ->get('church_six_month_report');    

                    //         echo "<pre>";
                    //         echo $this->db->last_query();
                    //         exit;

                     //var_dump($res_chk_child->result_array()); die();
                }
                

                if(isset($res_chk))
                {

                        if($res_chk->num_rows()>0){

                             global $gender, $months, $age_group,  $marital_status, $part_india, $identities, $emtypes, $blood_group, $family_position;
                            

                            foreach($res_chk->result_array() as $key=>$value){

                                    if(isset($value['staff_gender']))
                                    {
                                        $value['staff_gender'] = $gender[$value['staff_gender']];
                                    }
                                    if(isset($value['marital_status']))
                                    {
                                        $value['marital_status'] = $marital_status[$value['marital_status']];
                                    }
                                    if(isset($value['staff_identity_id']))
                                    {
                                        $value['staff_identity_id'] = $identities[$value['staff_identity_id']];
                                    }
                                    if(isset($value['staff_type_id']))
                                    {
                                        $value['staff_type_id'] = $emtypes[$value['staff_type_id']];
                                    }
                                    if(isset($value['staff_dedication_status']))
                                    {
                                       // var_dump($value['staff_dedication_status']); die();
                                       if($value['staff_dedication_status']==0)
                                       {
                                            $value['staff_dedication_status']="Not Dedicated";
                                       }
                                       else
                                       {
                                            $value['staff_dedication_status']="Not Dedicated";
                                       }
                                    }


                                    //$this->pr($value);exit;
                                    
                                    $result[]=array($value);

                                    if(isset($model->selectedchildvalue))
                                    {

                                        if($res_chk_child->num_rows()>0){

                                            foreach($res_chk_child->result_array() as $key1=>$child){


                                                if(isset($child['from_month_report']))
                                                {


                                                    $child['from_month_report'] = $months[$child['from_month_report']];
                                                   // var_dump($child['from_month_report']); die();
                                                }
                                                
                                                if(isset($child['to_month_report']))
                                                {
                                                    $child['to_month_report'] = $months[$child['to_month_report']];
                                                }
                                                

                                                if($child['staff_id']==$value['id'])
                                                {
                                                    $result[]=array($child);
                                                }

                                                
                                            }																																																																		
                                        }
                                    }

                            }

                       
                        }
                }                       
                else
                {
                    $response['status']="failure";            
                    $response['message']="Sorry!!, Invalid Attempt!!.. Permission denied.";
                }


        }
            if($result!=NULL)
            {
                $response['result']=$result;
            }
            else
            {
                $response['result']=NULL;
            }
            die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }



   public function gems_get_flat_report_master_pdf() {
   		$this->load->library('m_pdf');

       //$this->output->set_content_type('application/json');
        $response=array();
        $tharray=array();
        $response['status']="success";

        //,'staff_employee_id','marital_status'

        $model = json_decode($this->input->post('model',FALSE));

        //var_dump($model->selectedchildvalue); die();
        // $model->selectedstaffvalue =array('staff_cross_ref_number','staff_employee_id','marital_status');
       
        // $model->selectedchildvalue =array('no_baptized_believe','no_believer','no_seekers');

        foreach ($model->selectedstaffvalue as $key => $staff) {
        		array_push($tharray, $staff);
        }
        
        foreach ($model->selectedchildvalue as $key => $child) {
        		array_push($tharray, $child);
        }
        

       

        $result=NULL;

        if($model!=''){

                if(isset($model->selectedstaffvalue))
                {
                     array_push($model->selectedstaffvalue, "id");
                     array_push($model->selectedstaffvalue, "staff_name");

                      $columns = array_map(function($column) {
                        return 'staff_master.' . $column;
                    }, $model->selectedstaffvalue);

                      $find_zone_column=array_search("staff_master.zone_id",$columns);
                        if(!empty($find_zone_column)){
                            array_push($columns,"zones_staff_master.staff_zone_name AS zone_id");


                        }

                     $res_chk=$this->db->select(implode(',', $columns))
                            ->join('zones_staff_master', 'staff_master.zone_id=zones_staff_master.id', 'left');

                            if(isset($model->zone_id) && $model->zone_id!="")
                            {   
                                $res_chk=$this->db->where('zone_id', $model->zone_id);
                            }

                            if(isset($model->staff_id) && $model->staff_id!="")
                            {   
                                $res_chk=$this->db->where('staff_master.id', $model->staff_id);
                            }

                        $res_chk=$this->db->order_by('staff_master.id', 'desc')
                        ->limit(300)
                        ->get('staff_master'); 

                        //var_dump($res_chk); die();
                }
                else
                {   

                    $res_chk=$this->db->select("staff_name, id");


                        if(isset($model->zone_id) && $model->zone_id!="")
                        {   
                            $res_chk=$this->db->where('zone_id', $model->zone_id);
                        }

                        if(isset($model->staff_id) && $model->staff_id!="")
                        {   
                            $res_chk=$this->db->where('id', $model->staff_id);
                        }


                        $res_chk=$this->db->order_by('staff_master.id', 'desc')
                       ->limit(300)
                        ->get('staff_master'); 
                }
                //var_dump($model->selectedchildvalue!='undefined'); die();

                
                if(isset($model->selectedchildvalue))
                {
                     array_push($model->selectedchildvalue, "staff_id");
                    // array_push($model->selectedchildvalue, "from_month_report");
                    // array_push($model->selectedchildvalue, "from_year_report");
                    // array_push($model->selectedchildvalue, "to_month_report");
                    // array_push($model->selectedchildvalue, "to_year_report");
                     array_push($model->selectedchildvalue, "church_id");
                 

                    $childcolumns = array_map(function($column) {
                        return 'church_six_month_report.' . $column;
                    }, $model->selectedchildvalue);


                    // $find_child_designation_column=array_search("staff_children.verified_designation",$childcolumns);
                    //     if(!empty($find_child_designation_column)){
                    //         array_push($childcolumns,"staff_designation_master.designation_name AS verified_designation");


                    //     } 

                     $res_chk_child=$this->db->select(implode(',', $childcolumns))
                            ->select('church_master.church_name, church_master.type_church')
                            ->join('church_master', 'church_six_month_report.church_id=church_master.id', 'left');

                            if(isset($model->type_church) && $model->type_church!="")
                            {   
                                $res_chk_child=$this->db->where('church_master.type_church', $model->type_church);
                            }

                            $res_chk_child=$this->db->order_by('church_six_month_report.id', 'desc')
                            ->limit(300)
                            ->get('church_six_month_report');    

                    //         echo "<pre>";
                    //         echo $this->db->last_query();
                    //         exit;

                     //var_dump($res_chk_child->result_array()); die();
                }
                


                if(isset($res_chk))
                {

                        if($res_chk->num_rows()>0){

                             global $gender, $months, $age_group,  $marital_status, $part_india, $identities, $emtypes, $blood_group, $family_position;
                            

                            foreach($res_chk->result_array() as $key=>$value){

                                    if(isset($value['staff_gender']))
                                    {
                                        $value['staff_gender'] = $gender[$value['staff_gender']];
                                    }
                                    if(isset($value['marital_status']))
                                    {
                                        $value['marital_status'] = $marital_status[$value['marital_status']];
                                    }
                                    if(isset($value['staff_identity_id']))
                                    {
                                        $value['staff_identity_id'] = $identities[$value['staff_identity_id']];
                                    }
                                    if(isset($value['staff_type_id']))
                                    {
                                        $value['staff_type_id'] = $emtypes[$value['staff_type_id']];
                                    }
                                    if(isset($value['staff_dedication_status']))
                                    {
                                       // var_dump($value['staff_dedication_status']); die();
                                       if($value['staff_dedication_status']==0)
                                       {
                                            $value['staff_dedication_status']="Not Dedicated";
                                       }
                                       else
                                       {
                                            $value['staff_dedication_status']="Not Dedicated";
                                       }
                                    }




                                    //$this->pr($value);exit;
                                    $child_column=count($model->selectedchildvalue);

                                    for($i=0; $i<$child_column; $i++)
                                	{
                                		$value[$model->selectedchildvalue[$i]]='';
                                	}
                                    
                                    $result[]=array($value);

                                    



                                    //var_dump($result); die();

                                    $staff_column=count($model->selectedstaffvalue);

                                    if(isset($model->selectedchildvalue))
                                    {

                                        if($res_chk_child->num_rows()>0){

                                            foreach($res_chk_child->result_array() as $key1=>$child){


                                                if(isset($child['from_month_report']))
                                                {
                                                    $child['from_month_report'] = $months[$child['from_month_report']];
                                                }
                                                
                                                if(isset($child['to_month_report']))
                                                {
                                                    $child['to_month_report'] = $months[$child['to_month_report']];
                                                }
                                                

                                                if($child['staff_id']==$value['id'])
                                                {
                                                	$resultcount=count($result);

                                                	$resultcount= $resultcount+1;

                                                	$result[$resultcount]=array();

                                                	for($i=0; $i<$staff_column; $i++)
                                                	{
                                                		$child[$model->selectedstaffvalue[$i]]='';
                                                	}

                                                	$result[]=array($child);

                                                }

                                            }
                                        }
                                    }



                            }

                       
                        }
                }                       
                else
                {
                    $response['status']="failure";            
                    $response['message']="Sorry!!, Invalid Attempt!!.. Permission denied.";
                }


        }
            if($result!=NULL)
            {
                $response['result']=$result;

				$response['resultth']=$tharray;

            }
            else
            {
                $response['result']=NULL;
               
            }

         //  var_dump($response); die();
            $html= $this->load->view('report/flatreport',$response, true);

        //this the the PDF filename that user will get to download




		$pdfFilePath = "output_pdf_name.pdf";

        //load mPDF library
	

       //generate the PDF from the given html
		$this->m_pdf->pdf->WriteHTML($html);

		//var_dump($this->m_pdf->pdf->WriteHTML($html)); die();

        //download it.
		$this->m_pdf->pdf->Output($pdfFilePath, "D");


    }



    public function gems_get_growth_chart_master() {

       $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";

        $model = json_decode($this->input->post('model',FALSE));

        //var_dump($model->zone_ids); die();

        
        $result=NULL;

        if($model!=''){

        		// SELECT COUNT(DISTINCT(staff_id)) AS ms_count,COUNT(id) as tot_church,SUM(no_baptized_believe) AS tot_bab,SUM(no_believer) AS tot_bvrs,SUM(no_seekers) AS tot_seekers,SUM(no_movers) AS tot_movers,SUM(no_people_left) AS tot_left_faith FROM gems_church_master WHERE is_deleted ='0' 


        	$res=$this->db->select("count(id) as churchtol, count(DISTINCT(staff_id)) as staffs, SUM(no_baptized_believe) AS tot_bab,SUM(no_believer) AS tot_bvrs,SUM(no_seekers) AS tot_seekers,SUM(no_movers) AS tot_movers,SUM(no_people_left) AS tot_left_faith");

                    if(isset($model->type_church))
                    {
                        $res=$this->db->where('church_master.type_church', $model->type_church);
                    }

                $res=$this->db->get('church_master');


        	$res_six_month=$this->db->select("SUM(no_baptized_believe) AS tot_bab_six, SUM(no_believer) AS tot_bvrs_six, SUM(no_seekers) AS tot_seekers_six, SUM(no_movers) AS tot_movers_six, SUM(no_people_left) AS tot_left_faith_six, STR_TO_DATE( concat( '1-', from_month_report, '-', from_year_report ) , '%d-%m-%Y' ) AS from_d, from_month_report, from_year_report, to_month_report, to_year_report");

                        if(isset($model->zone_ids))
                        {
                            if($model->zone_ids)
                            {
                                $zone_filter_id = array();
                                foreach ($model->zone_ids as $key => $value) {
                                    
                                    $zone_filter_id[] =  $value->id;
                                }


                                     $res_six_month=$this->db->where_in('church_six_month_report.staff_zone_id', $zone_filter_id);


                               
                            }
                        }

                        if(isset($model->staff_id))
                        {
                            $res_six_month=$this->db->where('church_six_month_report.staff_id', $model->staff_id);
                        }

                        if(isset($model->church_id))
                        {
                            $res_six_month=$this->db->where('church_six_month_report.church_id', $model->church_id);
                        }




        			$res_six_month=$this->db->group_by('from_d')
        			->limit(10)
        			->get('church_six_month_report');

        	//var_dump($res_six_month->result_array()); die();

                //global  $months;
                    $months=array('01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Aug','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec');

               // $value['final_bab']=0;

        		foreach($res->result_array() as $key=>$value){

        			$value['total_accum'] = $value['tot_bab'] + $value['tot_bvrs'] + $value['tot_seekers'] + $value['tot_movers'] + $value['tot_left_faith'];

        			$result[]=$value;
        		}

                //pr($res_six_month);die();
                //var_dump($result); die();

        		foreach($res_six_month->result_array() as $key=>$sixmonth){

                    if(isset($sixmonth['from_month_report']))
                    {
                        $sixmonth['from_month_report'] = $months[$sixmonth['from_month_report']];
                    }

                    if($sixmonth['from_year_report']=="")
                    {
                        $sixmonth['from_year_report'] = "--";
                    }

                    if(isset($sixmonth['to_month_report']))
                    {
                        $sixmonth['to_month_report'] = $months[$sixmonth['to_month_report']];
                    }

                    if($sixmonth['to_year_report']=="")
                    {
                        $sixmonth['to_year_report'] = "--";
                    }


        			$sixmonth['total_accum_six_month'] = ($sixmonth['tot_bab_six'] + $sixmonth['tot_bvrs_six'] + $sixmonth['tot_seekers_six'] + $sixmonth['tot_movers_six']) - ($sixmonth['tot_left_faith_six']);

        			$result[]=$sixmonth;
        		}
                // pr($result);die();
                $count= count($result);
                //$count= $count + 1;
               // var_dump($count); die();
                foreach ($result as $key => $final) {


                    if(isset($final['tot_bab']))
                    {

                        if(isset($result[$count]['final_bab_six']))
                        {
                            $result[$count]['final_bab_six'] = $result[$count]['final_bab_six'] + $final['tot_bab'];
                        }
                        else
                        {
                            $result[$count]['final_bab_six'] = $final['tot_bab'];
                        }
                    }

                    if(isset($final['tot_bab_six']))
                    {

                        if(isset($result[$count]['final_bab_six']))
                        {
                            $result[$count]['final_bab_six'] = $result[$count]['final_bab_six'] + $final['tot_bab_six'];
                        }
                        else
                        {
                            $result[$count]['final_bab_six'] = $final['tot_bab_six'];
                        }
                    }


                    //Belivers Final

                    if(isset($final['tot_bvrs']))
                    {

                        if(isset($result[$count]['final_believers']))
                        {
                            $result[$count]['final_believers'] = $result[$count]['final_believers'] + $final['tot_bvrs'];
                        }
                        else
                        {
                            $result[$count]['final_believers'] = $final['tot_bvrs'];
                        }
                    }

                    if(isset($final['tot_bvrs_six']))
                    {

                        if(isset($result[$count]['final_believers']))
                        {
                            $result[$count]['final_believers'] = $result[$count]['final_believers'] + $final['tot_bvrs_six'];
                        }
                        else
                        {
                            $result[$count]['final_believers'] = $final['tot_bvrs_six'];
                        }
                    }

                    //Seekers Final

                    if(isset($final['tot_seekers']))
                    {

                        if(isset($result[$count]['final_seekers']))
                        {
                            $result[$count]['final_seekers'] = $result[$count]['final_seekers'] + $final['tot_seekers'];
                        }
                        else
                        {
                            $result[$count]['final_seekers'] = $final['tot_seekers'];
                        }
                    }

                    if(isset($final['tot_seekers_six']))
                    {

                        if(isset($result[$count]['final_seekers']))
                        {
                            $result[$count]['final_seekers'] = $result[$count]['final_seekers'] + $final['tot_seekers_six'];
                        }
                        else
                        {
                            $result[$count]['final_seekers'] = $final['tot_seekers_six'];
                        }
                    }

                    //Movers Final

                    if(isset($final['tot_movers']))
                    {

                        if(isset($result[$count]['final_movers']))
                        {
                            $result[$count]['final_movers'] = $result[$count]['final_movers'] + $final['tot_movers'];
                        }
                        else
                        {
                            $result[$count]['final_movers'] = $final['tot_movers'];
                        }
                    }

                    if(isset($final['tot_movers_six']))
                    {

                        if(isset($result[$count]['final_movers']))
                        {
                            $result[$count]['final_movers'] = $result[$count]['final_movers'] + $final['tot_movers_six'];
                        }
                        else
                        {
                            $result[$count]['final_movers'] = $final['tot_movers_six'];
                        }
                    }

                    //No of People left faith Final

                    if(isset($final['tot_left_faith']))
                    {

                        if(isset($result[$count]['final_left_faith']))
                        {
                            $result[$count]['final_left_faith'] = $result[$count]['final_left_faith'] + $final['tot_left_faith'];
                        }
                        else
                        {
                            $result[$count]['final_left_faith'] = $final['tot_left_faith'];
                        }
                    }

                    if(isset($final['tot_left_faith_six']))
                    {

                        if(isset($result[$count]['final_left_faith']))
                        {
                            $result[$count]['final_left_faith'] = $result[$count]['final_left_faith'] + $final['tot_left_faith_six'];
                        }
                        else
                        {
                            $result[$count]['final_left_faith'] = $final['tot_left_faith_six'];
                        }
                    }

                    //Accumilate value final

                    if(isset($final['total_accum']))
                    {

                        if(isset($result[$count]['final_accum']))
                        {
                            $result[$count]['final_accum'] = $result[$count]['final_accum'] + $final['total_accum'];
                        }
                        else
                        {
                            $result[$count]['final_accum'] = $final['total_accum'];
                        }
                    }

                    if(isset($final['total_accum_six_month']))
                    {

                        if(isset($result[$count]['final_accum']))
                        {
                            $result[$count]['final_accum'] = $result[$count]['final_accum'] + $final['total_accum_six_month'];
                        }
                        else
                        {
                            $result[$count]['final_accum'] = $final['total_accum_six_month'];
                        }
                    }

                    //Final Church total

                    if(isset($final['churchtol']))
                    {

                        if(isset($result[$count]['final_church']))
                        {
                            $result[$count]['final_church'] = $result[$count]['final_church'] + $final['churchtol'];
                        }
                        else
                        {
                            $result[$count]['final_church'] = $final['churchtol'];
                        }
                    }

                    //Final Church total

                    if(isset($final['staffs']))
                    {

                        if(isset($result[$count]['final_staffs']))
                        {
                            $result[$count]['final_staffs'] = $result[$count]['final_staffs'] + $final['staffs'];
                        }
                        else
                        {
                            $result[$count]['final_staffs'] = $final['staffs'];
                        }
                    }

                }

        		//var_dump($result); die();

        }
        else
        {
            $response['status']="failure";            
            $response['message']="Sorry!!, Invalid Attempt!!.. Permission denied.";
        }


            if($result!=NULL)
            {
                $response['result']=$result;
            }
            else
            {
                $response['result']=NULL;
            }
            die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }




    public function gems_get_growth_chart_training_master() {

       $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";

        $model = json_decode($this->input->post('model',FALSE));

        
        $result=NULL;
        //pr($model);die();

        if($model!=''){


            $res=$this->db->select("count(id) as churchtol, count(DISTINCT(staff_id)) as staffs, SUM(tbs) AS tot_tbs,SUM(gtc) AS tot_gtc,SUM(tailoring) AS tot_tailoring,SUM(bible_men_women) AS tot_bible_men_women,SUM(other_bible_course) AS tot_other_bible_course,SUM(vbs_jet) AS tot_vbs_jet,SUM(agni_peace) AS tot_agni_peace");

                if(isset($model->type_church))
                {
                    $res=$this->db->where('church_master.type_church', $model->type_church);
                }

                $res=$this->db->get('church_master');


            $res_six_month=$this->db->select("SUM(tbs) AS tot_tbs_six, SUM(gtc) AS tot_gtc_six, SUM(tailoring) AS tot_tailoring_six, SUM(bible_men_women) AS tot_bible_men_women_six, SUM(other_bible_course) AS tot_other_bible_course_six, SUM(vbs_jet) AS tot_vbs_jet_six, SUM(agni_peace) AS tot_agni_peace_six, STR_TO_DATE( concat( '1-', from_month_report, '-', from_year_report ) , '%d-%m-%Y' ) AS from_d, from_month_report, from_year_report, to_month_report, to_year_report");

                    if(isset($model->zone_ids))
                    {
                        if($model->zone_ids)
                        {
                            $zone_filter_id = array();
                            foreach ($model->zone_ids as $key => $value) {
                                
                                $zone_filter_id[] =  $value->id;
                            }


                                 $res_six_month=$this->db->where_in('church_six_month_report.staff_zone_id', $zone_filter_id);


                           
                        }
                    }

                    if(isset($model->staff_id))
                    {
                        $res_six_month=$this->db->where('church_six_month_report.staff_id', $model->staff_id);
                    }

                    if(isset($model->church_id))
                    {
                        $res_six_month=$this->db->where('church_six_month_report.church_id', $model->church_id);
                    }


                    $res_six_month=$this->db->group_by('from_d')
                    ->limit(10)
                    ->get('church_six_month_report');


                //global  $months;
                    
                $months=array('01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Aug','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec');
                foreach($res->result_array() as $key=>$value){

                    $result[]=$value;
                }
                //pr($months);die();
                //var_dump($result); die();

                foreach($res_six_month->result_array() as $key=>$sixmonth){

                    if(isset($sixmonth['from_month_report']))
                    {
                        $sixmonth['from_month_report'] = $months[$sixmonth['from_month_report']];
                    }

                    if($sixmonth['from_year_report']=="")
                    {
                        $sixmonth['from_year_report'] = "--";
                    }

                    if(isset($sixmonth['to_month_report']))
                    {
                        $sixmonth['to_month_report'] = $months[$sixmonth['to_month_report']];
                    }

                    if($sixmonth['to_year_report']=="")
                    {
                        $sixmonth['to_year_report'] = "--";
                    }


                    $result[]=$sixmonth;
                }

                $count= count($result);

                //$count= $count + 1;
               // var_dump($count); die();
                foreach ($result as $key => $final) {


                    if(isset($final['tot_tbs']))
                    {

                        if(isset($result[$count]['final_tbs_six']))
                        {
                            $result[$count]['final_tbs_six'] = $result[$count]['final_tbs_six'] + $final['tot_tbs'];
                        }
                        else
                        {
                            $result[$count]['final_tbs_six'] = $final['tot_tbs'];
                        }
                    }

                    if(isset($final['tot_tbs_six']))
                    {

                        if(isset($result[$count]['final_tbs_six']))
                        {
                            $result[$count]['final_tbs_six'] = $result[$count]['final_tbs_six'] + $final['tot_tbs_six'];
                        }
                        else
                        {
                            $result[$count]['final_tbs_six'] = $final['tot_tbs_six'];
                        }
                    }


                    //Belivers Final

                    if(isset($final['tot_gtc']))
                    {

                        if(isset($result[$count]['final_gtc']))
                        {
                            $result[$count]['final_gtc'] = $result[$count]['final_gtc'] + $final['tot_gtc'];
                        }
                        else
                        {
                            $result[$count]['final_gtc'] = $final['tot_gtc'];
                        }
                    }

                    if(isset($final['tot_gtc_six']))
                    {

                        if(isset($result[$count]['final_gtc']))
                        {
                            $result[$count]['final_gtc'] = $result[$count]['final_gtc'] + $final['tot_gtc_six'];
                        }
                        else
                        {
                            $result[$count]['final_gtc'] = $final['tot_gtc_six'];
                        }
                    }

                    //Seekers Final

                    if(isset($final['tot_tailoring']))
                    {

                        if(isset($result[$count]['final_tailoring']))
                        {
                            $result[$count]['final_tailoring'] = $result[$count]['final_tailoring'] + $final['tot_tailoring'];
                        }
                        else
                        {
                            $result[$count]['final_tailoring'] = $final['tot_tailoring'];
                        }
                    }

                    if(isset($final['tot_tailoring_six']))
                    {

                        if(isset($result[$count]['final_tailoring']))
                        {
                            $result[$count]['final_tailoring'] = $result[$count]['final_tailoring'] + $final['tot_tailoring_six'];
                        }
                        else
                        {
                            $result[$count]['final_tailoring'] = $final['tot_tailoring_six'];
                        }
                    }

                    //Movers Final

                    if(isset($final['tot_bible_men_women']))
                    {

                        if(isset($result[$count]['final_bible_men_women']))
                        {
                            $result[$count]['final_bible_men_women'] = $result[$count]['final_bible_men_women'] + $final['tot_bible_men_women'];
                        }
                        else
                        {
                            $result[$count]['final_bible_men_women'] = $final['tot_bible_men_women'];
                        }
                    }

                    if(isset($final['tot_bible_men_women_six']))
                    {

                        if(isset($result[$count]['final_bible_men_women']))
                        {
                            $result[$count]['final_bible_men_women'] = $result[$count]['final_bible_men_women'] + $final['tot_bible_men_women_six'];
                        }
                        else
                        {
                            $result[$count]['final_bible_men_women'] = $final['tot_bible_men_women_six'];
                        }
                    }

                    //No of People left faith Final

                    if(isset($final['tot_other_bible_course']))
                    {

                        if(isset($result[$count]['final_other_bible_course']))
                        {
                            $result[$count]['final_other_bible_course'] = $result[$count]['final_other_bible_course'] + $final['tot_other_bible_course'];
                        }
                        else
                        {
                            $result[$count]['final_other_bible_course'] = $final['tot_other_bible_course'];
                        }
                    }

                    if(isset($final['tot_other_bible_course_six']))
                    {

                        if(isset($result[$count]['final_other_bible_course']))
                        {
                            $result[$count]['final_other_bible_course'] = $result[$count]['final_other_bible_course'] + $final['tot_other_bible_course_six'];
                        }
                        else
                        {
                            $result[$count]['final_other_bible_course'] = $final['tot_other_bible_course_six'];
                        }
                    }

                    //Accumilate value final

                    if(isset($final['tot_vbs_jet']))
                    {

                        if(isset($result[$count]['final_vbs_jet']))
                        {
                            $result[$count]['final_vbs_jet'] = $result[$count]['final_vbs_jet'] + $final['tot_vbs_jet'];
                        }
                        else
                        {
                            $result[$count]['final_vbs_jet'] = $final['tot_vbs_jet'];
                        }
                    }

                    if(isset($final['tot_vbs_jet_six']))
                    {

                        if(isset($result[$count]['final_vbs_jet']))
                        {
                            $result[$count]['final_vbs_jet'] = $result[$count]['final_vbs_jet'] + $final['tot_vbs_jet_six'];
                        }
                        else
                        {
                            $result[$count]['final_vbs_jet'] = $final['tot_vbs_jet_six'];
                        }
                    }

                    //Accumilate value final

                    if(isset($final['tot_agni_peace']))
                    {

                        if(isset($result[$count]['final_agni_peace']))
                        {
                            $result[$count]['final_agni_peace'] = $result[$count]['final_agni_peace'] + $final['tot_agni_peace'];
                        }
                        else
                        {
                            $result[$count]['final_agni_peace'] = $final['tot_agni_peace'];
                        }
                    }

                    if(isset($final['tot_agni_peace_six']))
                    {

                        if(isset($result[$count]['final_agni_peace']))
                        {
                            $result[$count]['final_agni_peace'] = $result[$count]['final_agni_peace'] + $final['tot_agni_peace_six'];
                        }
                        else
                        {
                            $result[$count]['final_agni_peace'] = $final['tot_agni_peace_six'];
                        }
                    }

                    //Final Church total

                    if(isset($final['churchtol']))
                    {

                        if(isset($result[$count]['final_church']))
                        {
                            $result[$count]['final_church'] = $result[$count]['final_church'] + $final['churchtol'];
                        }
                        else
                        {
                            $result[$count]['final_church'] = $final['churchtol'];
                        }
                    }

                    //Final Church total

                    if(isset($final['staffs']))
                    {

                        if(isset($result[$count]['final_staffs']))
                        {
                            $result[$count]['final_staffs'] = $result[$count]['final_staffs'] + $final['staffs'];
                        }
                        else
                        {
                            $result[$count]['final_staffs'] = $final['staffs'];
                        }
                    }

                }

                //var_dump($result); die();

        }
        else
        {
            $response['status']="failure";            
            $response['message']="Sorry!!, Invalid Attempt!!.. Permission denied.";
        }


            if($result!=NULL)
            {
                $response['result']=$result;
            }
            else
            {
                $response['result']=NULL;
            }
            die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }



     public function gems_get_growth_chart_program_master() {

       $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";

        $model = json_decode($this->input->post('model',FALSE));

        
        $result=NULL;

        if($model!=''){

            //$SQLChurch_CHART_train="SELECT SUM(church_trained_tbs) AS tot_tbs,SUM(church_trained_gtc) AS tot_gtc,SUM(church_trained_tailoring) AS tot_tailoring,SUM(church_bible_men_women) AS tot_bible_men_women,SUM(church_other_bible_courses) AS tot_other_bible_courses,SUM(church_vbs_jet) AS tot_vbs_jet,SUM(church_agni_peace) AS tot_agni_peace FROM tbl_church_det WHERE church_delete_status =0 AND church_sadmin_approve=1 AND church_abeyance_status=0";




            $res=$this->db->select("count(id) as churchtol, count(DISTINCT(staff_id)) as staffs, SUM(no_of_bible_men_women) AS tot_no_of_bible_men_women,SUM(no_of_child_program) AS tot_no_of_child_program,SUM(no_of_medical_program) AS tot_no_of_medical_program,SUM(no_of_youth) AS tot_no_of_youth,SUM(no_of_mini_major) AS tot_no_of_mini_major,SUM(no_of_film_show) AS tot_no_of_film_show,SUM(no_of_surrond_village) AS tot_no_of_surrond_village");

                if(isset($model->type_church))
                {
                    $res=$this->db->where('church_master.type_church', $model->type_church);
                }

            $res=$this->db->get('church_master');


            $res_six_month=$this->db->select("SUM(no_of_bible_men_women) AS tot_no_of_bible_men_women_six, SUM(no_of_child_program) AS tot_no_of_child_program_six, SUM(no_of_medical_program) AS tot_no_of_medical_program_six, SUM(no_of_youth) AS tot_no_of_youth_six, SUM(no_of_mini_major) AS tot_no_of_mini_major_six, SUM(no_of_film_show) AS tot_no_of_film_show_six, SUM(no_of_surrond_village) AS tot_no_of_surrond_village_six, STR_TO_DATE( concat( '1-', from_month_report, '-', from_year_report ) , '%d-%m-%Y' ) AS from_d, from_month_report, from_year_report, to_month_report, to_year_report");


                        if(isset($model->zone_ids))
                        {
                            if($model->zone_ids)
                            {
                                $zone_filter_id = array();
                                foreach ($model->zone_ids as $key => $value) {
                                    
                                    $zone_filter_id[] =  $value->id;
                                }


                                     $res_six_month=$this->db->where_in('church_six_month_report.staff_zone_id', $zone_filter_id);


                               
                            }
                        }

                        if(isset($model->staff_id))
                        {
                            $res_six_month=$this->db->where('church_six_month_report.staff_id', $model->staff_id);
                        }

                        if(isset($model->church_id))
                        {
                            $res_six_month=$this->db->where('church_six_month_report.church_id', $model->church_id);
                        }




                    $res_six_month=$this->db->group_by('from_d')
                    ->limit(10)
                    ->get('church_six_month_report');


                 //   var_dump($res_six_month->result_array()); die();

                //global  $months;
                    $months=array('01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Aug','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec');
                foreach($res->result_array() as $key=>$value){

                    $result[]=$value;
                }

                //var_dump($result); die();

                foreach($res_six_month->result_array() as $key=>$sixmonth){

                    if(isset($sixmonth['from_month_report']))
                    {
                        $sixmonth['from_month_report'] = $months[$sixmonth['from_month_report']];
                    }

                    if($sixmonth['from_year_report']=="")
                    {
                        $sixmonth['from_year_report'] = "--";
                    }

                    if(isset($sixmonth['to_month_report']))
                    {
                        $sixmonth['to_month_report'] = $months[$sixmonth['to_month_report']];
                    }

                    if($sixmonth['to_year_report']=="")
                    {
                        $sixmonth['to_year_report'] = "--";
                    }


                    $result[]=$sixmonth;
                }

                $count= count($result);
                //$count= $count + 1;
               // var_dump($count); die();
                foreach ($result as $key => $final) {


                    if(isset($final['tot_no_of_bible_men_women']))
                    {

                        if(isset($result[$count]['final_no_of_bible_men_women_six']))
                        {
                            $result[$count]['final_no_of_bible_men_women_six'] = $result[$count]['final_no_of_bible_men_women_six'] + $final['tot_no_of_bible_men_women'];
                        }
                        else
                        {
                            $result[$count]['final_no_of_bible_men_women_six'] = $final['tot_no_of_bible_men_women'];
                        }
                    }

                    if(isset($final['tot_no_of_bible_men_women_six']))
                    {

                        if(isset($result[$count]['final_no_of_bible_men_women_six']))
                        {
                            $result[$count]['final_no_of_bible_men_women_six'] = $result[$count]['final_no_of_bible_men_women_six'] + $final['tot_no_of_bible_men_women_six'];
                        }
                        else
                        {
                            $result[$count]['final_no_of_bible_men_women_six'] = $final['tot_no_of_bible_men_women_six'];
                        }
                    }


                    //Belivers Final

                    if(isset($final['tot_no_of_child_program']))
                    {

                        if(isset($result[$count]['final_no_of_child_program']))
                        {
                            $result[$count]['final_no_of_child_program'] = $result[$count]['final_no_of_child_program'] + $final['tot_no_of_child_program'];
                        }
                        else
                        {
                            $result[$count]['final_no_of_child_program'] = $final['tot_no_of_child_program'];
                        }
                    }

                    if(isset($final['tot_no_of_child_program_six']))
                    {

                        if(isset($result[$count]['final_no_of_child_program']))
                        {
                            $result[$count]['final_no_of_child_program'] = $result[$count]['final_no_of_child_program'] + $final['tot_no_of_child_program_six'];
                        }
                        else
                        {
                            $result[$count]['final_no_of_child_program'] = $final['tot_no_of_child_program_six'];
                        }
                    }

                    //Seekers Final

                    if(isset($final['tot_no_of_medical_program']))
                    {

                        if(isset($result[$count]['final_no_of_medical_program']))
                        {
                            $result[$count]['final_no_of_medical_program'] = $result[$count]['final_no_of_medical_program'] + $final['tot_no_of_medical_program'];
                        }
                        else
                        {
                            $result[$count]['final_no_of_medical_program'] = $final['tot_no_of_medical_program'];
                        }
                    }

                    if(isset($final['tot_no_of_medical_program_six']))
                    {

                        if(isset($result[$count]['final_no_of_medical_program']))
                        {
                            $result[$count]['final_no_of_medical_program'] = $result[$count]['final_no_of_medical_program'] + $final['tot_no_of_medical_program_six'];
                        }
                        else
                        {
                            $result[$count]['final_no_of_medical_program'] = $final['tot_no_of_medical_program_six'];
                        }
                    }

                    //Movers Final

                    if(isset($final['tot_no_of_youth']))
                    {

                        if(isset($result[$count]['final_no_of_youth']))
                        {
                            $result[$count]['final_no_of_youth'] = $result[$count]['final_no_of_youth'] + $final['tot_no_of_youth'];
                        }
                        else
                        {
                            $result[$count]['final_no_of_youth'] = $final['tot_no_of_youth'];
                        }
                    }

                    if(isset($final['tot_no_of_youth_six']))
                    {

                        if(isset($result[$count]['final_no_of_youth']))
                        {
                            $result[$count]['final_no_of_youth'] = $result[$count]['final_no_of_youth'] + $final['tot_no_of_youth_six'];
                        }
                        else
                        {
                            $result[$count]['final_no_of_youth'] = $final['tot_no_of_youth_six'];
                        }
                    }

                    //No of People left faith Final

                    if(isset($final['tot_no_of_mini_major']))
                    {

                        if(isset($result[$count]['final_no_of_mini_major']))
                        {
                            $result[$count]['final_no_of_mini_major'] = $result[$count]['final_no_of_mini_major'] + $final['tot_no_of_mini_major'];
                        }
                        else
                        {
                            $result[$count]['final_no_of_mini_major'] = $final['tot_no_of_mini_major'];
                        }
                    }

                    if(isset($final['tot_no_of_mini_major_six']))
                    {

                        if(isset($result[$count]['final_no_of_mini_major']))
                        {
                            $result[$count]['final_no_of_mini_major'] = $result[$count]['final_no_of_mini_major'] + $final['tot_no_of_mini_major_six'];
                        }
                        else
                        {
                            $result[$count]['final_no_of_mini_major'] = $final['tot_no_of_mini_major_six'];
                        }
                    }

                    //Accumilate value final

                    if(isset($final['tot_no_of_film_show']))
                    {

                        if(isset($result[$count]['final_no_of_film_show']))
                        {
                            $result[$count]['final_no_of_film_show'] = $result[$count]['final_no_of_film_show'] + $final['tot_no_of_film_show'];
                        }
                        else
                        {
                            $result[$count]['final_no_of_film_show'] = $final['tot_no_of_film_show'];
                        }
                    }

                    if(isset($final['tot_no_of_film_show_six']))
                    {

                        if(isset($result[$count]['final_no_of_film_show']))
                        {
                            $result[$count]['final_no_of_film_show'] = $result[$count]['final_no_of_film_show'] + $final['tot_no_of_film_show_six'];
                        }
                        else
                        {
                            $result[$count]['final_no_of_film_show'] = $final['tot_no_of_film_show_six'];
                        }
                    }

                    //Accumilate value final

                    if(isset($final['tot_no_of_surrond_village']))
                    {

                        if(isset($result[$count]['final_no_of_surrond_village']))
                        {
                            $result[$count]['final_no_of_surrond_village'] = $result[$count]['final_no_of_surrond_village'] + $final['tot_no_of_surrond_village'];
                        }
                        else
                        {
                            $result[$count]['final_no_of_surrond_village'] = $final['tot_no_of_surrond_village'];
                        }
                    }

                    if(isset($final['tot_no_of_surrond_village_six']))
                    {

                        if(isset($result[$count]['final_no_of_surrond_village']))
                        {
                            $result[$count]['final_no_of_surrond_village'] = $result[$count]['final_no_of_surrond_village'] + $final['tot_no_of_surrond_village_six'];
                        }
                        else
                        {
                            $result[$count]['final_no_of_surrond_village'] = $final['tot_no_of_surrond_village_six'];
                        }
                    }

                    //Final Church total

                    if(isset($final['churchtol']))
                    {

                        if(isset($result[$count]['final_church']))
                        {
                            $result[$count]['final_church'] = $result[$count]['final_church'] + $final['churchtol'];
                        }
                        else
                        {
                            $result[$count]['final_church'] = $final['churchtol'];
                        }
                    }

                    //Final Church total

                    if(isset($final['staffs']))
                    {

                        if(isset($result[$count]['final_staffs']))
                        {
                            $result[$count]['final_staffs'] = $result[$count]['final_staffs'] + $final['staffs'];
                        }
                        else
                        {
                            $result[$count]['final_staffs'] = $final['staffs'];
                        }
                    }

                }

                //var_dump($result); die();

        }
        else
        {
            $response['status']="failure";            
            $response['message']="Sorry!!, Invalid Attempt!!.. Permission denied.";
        }


            if($result!=NULL)
            {
                $response['result']=$result;
            }
            else
            {
                $response['result']=NULL;
            }
            die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


    public function gems_get_growth_chart_personnel_master() {

       $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";

        $model = json_decode($this->input->post('model',FALSE));
       // $model = 1;

        
        $result=NULL;

        if($model!=''){

            //$SQL_CHURC_SIX_Train="SELECT SUM(church_six_tbc) AS tot_tbs_six,SUM(church_six_gtc) AS tot_gtc_six,SUM(church_six_tailoring) AS tot_tailoring_six,SUM(church_six_bible_mw) AS tot_bible_men_women_six, from_d,SUM(church_six_othr_bib_crses) AS tot_other_bible_courses_six,SUM(church_six_vbc_jet) AS tot_vbs_jet_six,SUM(church_six_agni_peace) AS tot_agni_peace_six, date_format(from_d, '%b%y') as from_date, date_format(to_d, '%b%y') as to_date,church_six_zone FROM (SELECT * , STR_TO_DATE( concat( '1-', church_six_from_month, '-', church_six_from_year ) , '%d-%m-%Y' ) AS from_d, STR_TO_DATE( concat( '1-', church_six_to_month, '-', church_six_to_year ) , '%d-%m-%Y' ) AS to_d FROM `tbl_church_six_month_report` CSMR JOIN  tbl_church_det CD ON CD.pk_church_det_id=CSMR.church_six_id WHERE church_six_delete_status=0 AND church_six_rep_sadmin_approve=1 AND church_abeyance_status=0) AS CHT JOIN tbl_church_det TCD ON TCD.pk_church_det_id=CHT.church_six_id WHERE CHT.church_six_delete_status=0 AND CHT.church_six_rep_sadmin_approve=1  AND TCD.church_delete_status =0  AND  TCD.church_abeyance_status=0";




            $res=$this->db->select("count(id) as churchtol, count(DISTINCT(staff_id)) as staffs, SUM(no_of_full_time_workers) AS tot_no_of_full_time_workers,SUM(no_of_bible_men_women) AS tot_no_of_bible_men_women,SUM(no_of_women_program) AS tot_no_of_women_program,SUM(no_of_staff_dev_program) AS tot_no_of_staff_dev_program");

                    if(isset($model->type_church))
                    {
                        $res=$this->db->where('church_master.type_church', $model->type_church);
                    }

                $res=$this->db->get('church_master');



            $res_six_month=$this->db->select("SUM(no_of_full_time_workers) AS tot_no_of_full_time_workers_six, SUM(no_of_bible_men_women) AS tot_no_of_bible_men_women_six, SUM(no_of_women_program) AS tot_no_of_women_program_six, SUM(no_of_staff_dev_program) AS tot_no_of_staff_dev_program_six, STR_TO_DATE( concat( '1-', from_month_report, '-', from_year_report ) , '%d-%m-%Y' ) AS from_d, from_month_report, from_year_report, to_month_report, to_year_report");


                        if(isset($model->zone_ids))
                        {
                            if($model->zone_ids)
                            {
                                $zone_filter_id = array();
                                foreach ($model->zone_ids as $key => $value) {
                                    
                                    $zone_filter_id[] =  $value->id;
                                }


                                     $res_six_month=$this->db->where_in('church_six_month_report.staff_zone_id', $zone_filter_id);


                               
                            }
                        }

                        if(isset($model->staff_id))
                        {
                            $res_six_month=$this->db->where('church_six_month_report.staff_id', $model->staff_id);
                        }

                        if(isset($model->church_id))
                        {
                            $res_six_month=$this->db->where('church_six_month_report.church_id', $model->church_id);
                        }




                    $res_six_month=$this->db->group_by('from_d')
                    ->limit(10)
                    ->get('church_six_month_report');


                  // var_dump($res_six_month->result_array()); die();

                //global  $months;
                    $months=array('01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Aug','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec');

                foreach($res->result_array() as $key=>$value){

                    $result[]=$value;
                }

                //var_dump($result); die();

                foreach($res_six_month->result_array() as $key=>$sixmonth){

                    if(isset($sixmonth['from_month_report']))
                    {
                        $sixmonth['from_month_report'] = $months[$sixmonth['from_month_report']];
                    }

                    if($sixmonth['from_year_report']=="")
                    {
                        $sixmonth['from_year_report'] = "--";
                    }

                    if(isset($sixmonth['to_month_report']))
                    {
                        $sixmonth['to_month_report'] = $months[$sixmonth['to_month_report']];
                    }

                    if($sixmonth['to_year_report']=="")
                    {
                        $sixmonth['to_year_report'] = "--";
                    }


                    $result[]=$sixmonth;
                }

                $count= count($result);
                //$count= $count + 1;
               // var_dump($count); die();
                foreach ($result as $key => $final) {


                    if(isset($final['no_of_full_time_workers']))
                    {

                        if(isset($result[$count]['final_no_of_full_time_workers_six']))
                        {
                            $result[$count]['final_no_of_full_time_workers_six'] = $result[$count]['final_no_of_full_time_workers_six'] + $final['no_of_full_time_workers'];
                        }
                        else
                        {
                            $result[$count]['final_no_of_full_time_workers_six'] = $final['no_of_full_time_workers'];
                        }
                    }

                    if(isset($final['tot_no_of_full_time_workers_six']))
                    {

                        if(isset($result[$count]['final_no_of_full_time_workers_six']))
                        {
                            $result[$count]['final_no_of_full_time_workers_six'] = $result[$count]['final_no_of_full_time_workers_six'] + $final['tot_no_of_full_time_workers_six'];
                        }
                        else
                        {
                            $result[$count]['final_no_of_full_time_workers_six'] = $final['tot_no_of_full_time_workers_six'];
                        }
                    }


                    //Belivers Final

                    if(isset($final['no_of_bible_men_women']))
                    {

                        if(isset($result[$count]['final_no_of_bible_men_women']))
                        {
                            $result[$count]['final_no_of_bible_men_women'] = $result[$count]['final_no_of_bible_men_women'] + $final['no_of_bible_men_women'];
                        }
                        else
                        {
                            $result[$count]['final_no_of_bible_men_women'] = $final['no_of_bible_men_women'];
                        }
                    }

                    if(isset($final['tot_no_of_bible_men_women_six']))
                    {

                        if(isset($result[$count]['final_no_of_bible_men_women']))
                        {
                            $result[$count]['final_no_of_bible_men_women'] = $result[$count]['final_no_of_bible_men_women'] + $final['tot_no_of_bible_men_women_six'];
                        }
                        else
                        {
                            $result[$count]['final_no_of_bible_men_women'] = $final['tot_no_of_bible_men_women_six'];
                        }
                    }

                    //Seekers Final

                    if(isset($final['no_of_staff_dev_program']))
                    {

                        if(isset($result[$count]['final_no_of_staff_dev_program']))
                        {
                            $result[$count]['final_no_of_staff_dev_program'] = $result[$count]['final_no_of_staff_dev_program'] + $final['no_of_staff_dev_program'];
                        }
                        else
                        {
                            $result[$count]['final_no_of_staff_dev_program'] = $final['no_of_staff_dev_program'];
                        }
                    }

                    if(isset($final['tot_no_of_staff_dev_program_six']))
                    {

                        if(isset($result[$count]['final_no_of_staff_dev_program']))
                        {
                            $result[$count]['final_no_of_staff_dev_program'] = $result[$count]['final_no_of_staff_dev_program'] + $final['tot_no_of_staff_dev_program_six'];
                        }
                        else
                        {
                            $result[$count]['final_no_of_staff_dev_program'] = $final['tot_no_of_staff_dev_program_six'];
                        }
                    }

                    //Movers Final

                    if(isset($final['tot_no_of_women_program']))
                    {

                        if(isset($result[$count]['final_tot_no_of_women_program']))
                        {
                            $result[$count]['final_tot_no_of_women_program'] = $result[$count]['final_tot_no_of_women_program'] + $final['tot_no_of_women_program'];
                        }
                        else
                        {
                            $result[$count]['final_tot_no_of_women_program'] = $final['tot_no_of_women_program'];
                        }
                    }

                    if(isset($final['tot_no_of_women_program_six']))
                    {

                        if(isset($result[$count]['final_tot_no_of_women_program']))
                        {
                            $result[$count]['final_tot_no_of_women_program'] = $result[$count]['final_tot_no_of_women_program'] + $final['tot_no_of_women_program_six'];
                        }
                        else
                        {
                            $result[$count]['final_tot_no_of_women_program'] = $final['tot_no_of_women_program_six'];
                        }
                    }


                    //Final Church total

                     if(isset($final['churchtol']))
                    {

                        if(isset($result[$count]['final_church']))
                        {
                            $result[$count]['final_church'] = $result[$count]['final_church'] + $final['churchtol'];
                        }
                        else
                        {
                            $result[$count]['final_church'] = $final['churchtol'];
                        }
                    }

                    //Final Church total

                    if(isset($final['staffs']))
                    {

                        if(isset($result[$count]['final_staffs']))
                        {
                            $result[$count]['final_staffs'] = $result[$count]['final_staffs'] + $final['staffs'];
                        }
                        else
                        {
                            $result[$count]['final_staffs'] = $final['staffs'];
                        }
                    }

                }

                //var_dump($result); die();

        }
        else
        {
            $response['status']="failure";            
            $response['message']="Sorry!!, Invalid Attempt!!.. Permission denied.";
        }


            if($result!=NULL)
            {
                $response['result']=$result;
            }
            else
            {
                $response['result']=NULL;
            }
            die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }



    public function gems_get_growth_chart_finance_master() {

       $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";

        $model = json_decode($this->input->post('model',FALSE));

        
        $result=NULL;

        if($model!=''){


            $res=$this->db->select("count(id) as churchtol, count(DISTINCT(staff_id)) as staffs, SUM(monthly_church_offer) AS tot_monthly_church_offer,SUM(church_tithe) AS tot_church_tithe,SUM(value_of_gift) AS tot_value_of_gift,SUM(personal_offer_receive) AS tot_personal_offer_receive");

                    if(isset($model->type_church))
                    {
                        $res=$this->db->where('church_master.type_church', $model->type_church);
                    }

                $res=$this->db->get('church_master');


            $res_six_month=$this->db->select("SUM(six_month_church_offer) AS tot_six_month_church_offer, SUM(church_tithe) AS tot_church_tithe_six, SUM(value_of_gift) AS tot_value_of_gift_six, SUM(six_month_offer_received) AS tot_six_month_offer_received, STR_TO_DATE( concat( '1-', from_month_report, '-', from_year_report ) , '%d-%m-%Y' ) AS from_d, from_month_report, from_year_report, to_month_report, to_year_report");


                        if(isset($model->zone_ids))
                        {
                            if($model->zone_ids)
                            {
                                $zone_filter_id = array();
                                foreach ($model->zone_ids as $key => $value) {
                                    
                                    $zone_filter_id[] =  $value->id;
                                }


                                     $res_six_month=$this->db->where_in('church_six_month_report.staff_zone_id', $zone_filter_id);


                               
                            }
                        }
                        

                        if(isset($model->staff_id))
                        {
                            $res_six_month=$this->db->where('church_six_month_report.staff_id', $model->staff_id);
                        }

                        if(isset($model->church_id))
                        {
                            $res_six_month=$this->db->where('church_six_month_report.church_id', $model->church_id);
                        }




                    $res_six_month=$this->db->group_by('from_d')
                    ->limit(10)
                    ->get('church_six_month_report');

                    //global  $months;
                    $months=array('01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Aug','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec');

                foreach($res->result_array() as $key=>$value){

                    $result[]=$value;
                }

                //var_dump($result); die();

                foreach($res_six_month->result_array() as $key=>$sixmonth){

                    if(isset($sixmonth['from_month_report']))
                    {
                        $sixmonth['from_month_report'] = $months[$sixmonth['from_month_report']];
                    }

                    if($sixmonth['from_year_report']=="")
                    {
                        $sixmonth['from_year_report'] = "--";
                    }

                    if(isset($sixmonth['to_month_report']))
                    {
                        $sixmonth['to_month_report'] = $months[$sixmonth['to_month_report']];
                    }

                    if($sixmonth['to_year_report']=="")
                    {
                        $sixmonth['to_year_report'] = "--";
                    }


                    $result[]=$sixmonth;
                }

                $count= count($result);
                //$count= $count + 1;
               // var_dump($count); die();
                foreach ($result as $key => $final) {


                    if(isset($final['tot_monthly_church_offer']))
                    {

                        if(isset($result[$count]['final_monthly_church_offer_six']))
                        {
                            $result[$count]['final_monthly_church_offer_six'] = $result[$count]['final_monthly_church_offer_six'] + $final['tot_monthly_church_offer'];
                        }
                        else
                        {
                            $result[$count]['final_monthly_church_offer_six'] = $final['tot_monthly_church_offer'];
                        }
                    }

                    if(isset($final['tot_six_month_church_offer']))
                    {

                        if(isset($result[$count]['final_monthly_church_offer_six']))
                        {
                            $result[$count]['final_monthly_church_offer_six'] = $result[$count]['final_monthly_church_offer_six'] + $final['tot_six_month_church_offer'];
                        }
                        else
                        {
                            $result[$count]['final_monthly_church_offer_six'] = $final['tot_six_month_church_offer'];
                        }
                    }


                    //Belivers Final

                    if(isset($final['tot_church_tithe']))
                    {

                        if(isset($result[$count]['final_church_tithe']))
                        {
                            $result[$count]['final_church_tithe'] = $result[$count]['final_church_tithe'] + $final['tot_church_tithe'];
                        }
                        else
                        {
                            $result[$count]['final_church_tithe'] = $final['tot_church_tithe'];
                        }
                    }

                    if(isset($final['tot_church_tithe_six']))
                    {

                        if(isset($result[$count]['final_church_tithe']))
                        {
                            $result[$count]['final_church_tithe'] = $result[$count]['final_church_tithe'] + $final['tot_church_tithe_six'];
                        }
                        else
                        {
                            $result[$count]['final_church_tithe'] = $final['tot_church_tithe_six'];
                        }
                    }

                    //Seekers Final

                    if(isset($final['tot_value_of_gift']))
                    {

                        if(isset($result[$count]['final_value_of_gift']))
                        {
                            $result[$count]['final_value_of_gift'] = $result[$count]['final_value_of_gift'] + $final['tot_value_of_gift'];
                        }
                        else
                        {
                            $result[$count]['final_value_of_gift'] = $final['tot_value_of_gift'];
                        }
                    }

                    if(isset($final['tot_value_of_gift_six']))
                    {

                        if(isset($result[$count]['final_value_of_gift']))
                        {
                            $result[$count]['final_value_of_gift'] = $result[$count]['final_value_of_gift'] + $final['tot_value_of_gift_six'];
                        }
                        else
                        {
                            $result[$count]['final_value_of_gift'] = $final['tot_value_of_gift_six'];
                        }
                    }

                    //Movers Final

                    if(isset($final['tot_personal_offer_receive']))
                    {

                        if(isset($result[$count]['final_personal_offer_receive']))
                        {
                            $result[$count]['final_personal_offer_receive'] = $result[$count]['final_personal_offer_receive'] + $final['tot_personal_offer_receive'];
                        }
                        else
                        {
                            $result[$count]['final_personal_offer_receive'] = $final['tot_personal_offer_receive'];
                        }
                    }

                    if(isset($final['tot_six_month_offer_received']))
                    {

                        if(isset($result[$count]['final_personal_offer_receive']))
                        {
                            $result[$count]['final_personal_offer_receive'] = $result[$count]['final_personal_offer_receive'] + $final['tot_six_month_offer_received'];
                        }
                        else
                        {
                            $result[$count]['final_personal_offer_receive'] = $final['tot_six_month_offer_received'];
                        }
                    }

                    //Final Church total

                    if(isset($final['churchtol']))
                    {

                        if(isset($result[$count]['final_church']))
                        {
                            $result[$count]['final_church'] = $result[$count]['final_church'] + $final['churchtol'];
                        }
                        else
                        {
                            $result[$count]['final_church'] = $final['churchtol'];
                        }
                    }

                    //Final Church total

                    if(isset($final['staffs']))
                    {

                        if(isset($result[$count]['final_staffs']))
                        {
                            $result[$count]['final_staffs'] = $result[$count]['final_staffs'] + $final['staffs'];
                        }
                        else
                        {
                            $result[$count]['final_staffs'] = $final['staffs'];
                        }
                    }

                }

                //var_dump($result); die();

        }
        else
        {
            $response['status']="failure";            
            $response['message']="Sorry!!, Invalid Attempt!!.. Permission denied.";
        }


            if($result!=NULL)
            {
                $response['result']=$result;
            }
            else
            {
                $response['result']=NULL;
            }
            die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

 

    public function gems_get_sponsor_dedication_report_master() {

       $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";

        $model = json_decode($this->input->post('model',FALSE));

        $result=NULL;

        if($model!=''){

                if(isset($model->selectedstaffvalue))
                {
                     array_push($model->selectedstaffvalue, "id");
                     array_push($model->selectedstaffvalue, "staff_name");

                     

                    // $res_chk=$this->db->select(implode(',', $columns))

                        $res_chk=$this->db->select('staff_master.staff_name, zones_staff_master.staff_zone_name AS zone_id, staff_master.staff_gender, sponsorship_master.*, allot_missionary.*, sponsor_master.*, promotional_office_master.*')
                        ->join('sponsorship_master', 'allot_missionary.sponsor_id=sponsorship_master.id', 'left')
                        ->join('sponsor_master', 'sponsorship_master.sponsor_group_id=sponsor_master.id', 'left')
                        ->join('staff_master', 'allot_missionary.missionary_emp_id=staff_master.staff_employee_id', 'left')
                        ->join('zones_staff_master', 'staff_master.zone_id=zones_staff_master.id', 'left')
                        ->join('promotional_office_master', 'sponsor_master.sponser_promo_office=promotional_office_master.id', 'left');

                            if(isset($model->office_id) && $model->office_id!="")
                            {   
                                $res_chk=$this->db->where('promotional_office_master.id', $model->office_id);
                            }

                            if(isset($model->zone_id) && $model->zone_id!="")
                            {   
                                $res_chk=$this->db->where('zones_staff_master.id', $model->zone_id);
                            }

                            if(isset($model->dedication_from_date) && $model->dedication_from_date!="")
                            {   
                                $datefrom=date("Y-m-d",strtotime($model->dedication_from_date));
                                $res_chk=$this->db->where('sponsorship_master.sponsor_from_date', $datefrom);
                               
                            }

                            if(isset($model->dedication_to_date) && $model->dedication_to_date!="")
                            {   
                                $dateto=date("Y-m-d",strtotime($model->dedication_to_date));
                                $res_chk=$this->db->where('sponsorship_master.sponsor_to_date', $dateto);
                               
                            }


                            

                        $res_chk=$this->db->order_by('allot_missionary.id', 'desc')
                        ->get('allot_missionary');

                        //var_dump($res_chk->result_array()); die();

                        if($res_chk->num_rows()>0){

                            global $gender, $months, $age_group,  $marital_status, $part_india, $identities, $emtypes, $blood_group, $family_position;

                            foreach($res_chk->result_array() as $key=>$value){

                                    if(isset($value['staff_gender']))
                                    {
                                        $value['staff_gender'] = $gender[$value['staff_gender']];
                                    }

                                    if(isset($value['sponser_preference_gender']))
                                    {
                                        $value['sponser_preference_gender'] = $gender[$value['sponser_preference_gender']];
                                    }
                                  

                                    $result[]=array($value);                                    

                            }
                        }
                       // var_dump($result); die();
                }
                else
                {   

                    $res_chk=$this->db->select("staff_name, id");


                        if(isset($model->zone_id) && $model->zone_id!="")
                        {   
                            $res_chk=$this->db->where('zone_id', $model->zone_id);
                        }

                        if(isset($model->staff_id) && $model->staff_id!="")
                        {   
                            $res_chk=$this->db->where('id', $model->staff_id);
                        }


                        $res_chk=$this->db->order_by('staff_master.id', 'desc')
                        ->get('staff_master'); 
                }
                //var_dump($model->selectedchildvalue!='undefined'); die();


        }

            if($result!=NULL)
            {
                $response['result']=$result;
            }
            else
            {
                $response['result']=NULL;
                $response['status']="failure";            
                $response['message']="Sorry!!, Invalid Attempt!!.. Permission denied.";
            }

            ini_set('memory_limit', '-1');

            die(json_encode($response, JSON_UNESCAPED_SLASHES));

    }




    public function gems_get_staff_report_master_pdf() {

       $this->output->set_content_type('application/json');
        $response=array();
        $tharray=array();
        $response['status']="success";

        $model = json_decode($this->input->post('model',FALSE));


        $this->load->library('m_pdf');

        



        $result=NULL;

        if($model!=''){

                foreach ($model->selectedstaffvalue as $key => $staff) {
                array_push($tharray, $staff);
                }
                
                foreach ($model->selectedchildvalue as $key => $child) {
                        array_push($tharray, $child);
                }

                if(isset($model->selectedstaffvalue))
                {
                     array_push($model->selectedstaffvalue, "id");
                     array_push($model->selectedstaffvalue, "staff_name");

                      $columns = array_map(function($column) {
                        return 'staff_master.' . $column;
                    }, $model->selectedstaffvalue);

                      $find_zone_column=array_search("staff_master.zone_id",$columns);
                        if(!empty($find_zone_column)){
                            array_push($columns,"zones_staff_master.staff_zone_name AS zone_id");


                        }

                       $find_state_column=array_search("staff_master.present_state_id",$columns);
                        if(!empty($find_state_column)){
                            array_push($columns,"state_zone_master.state_zone_name AS present_state_id");


                        } 

                        $find_category_column=array_search("staff_master.staff_category_id",$columns);
                        if(!empty($find_category_column)){
                            array_push($columns," staff_category_master.staff_category_name AS staff_category_id");


                        } 

                        $find_designation_column=array_search("staff_master.staff_designation_id",$columns);
                        if(!empty($find_designation_column)){
                            array_push($columns,"staff_designation_master.designation_name AS staff_designation_id");


                        } 

                        $find_department_column=array_search("staff_master.staff_department_id",$columns);
                        if(!empty($find_department_column)){
                            array_push($columns,"staff_department_master.department_name AS staff_department_id");


                        } 

                        
                       
                     
                     $res_chk=$this->db->select(implode(',', $columns))
                            ->join('zones_staff_master', 'staff_master.zone_id=zones_staff_master.id', 'left')
                            ->join('state_zone_master', 'staff_master.present_state_id=state_zone_master.id', 'left')
                            ->join('staff_category_master', 'staff_master.staff_category_id=staff_category_master.id', 'left')
                            ->join('staff_designation_master', 'staff_master.staff_designation_id=staff_designation_master.id', 'left')
                            ->join('staff_department_master', 'staff_master.staff_department_id=staff_department_master.id', 'left');

                            if(isset($model->staff_employee_id) && $model->staff_employee_id!="")
                            {   
                                $res_chk=$this->db->where('staff_employee_id', $model->staff_employee_id);
                            }

                            if(isset($model->staff_gender) && $model->staff_gender!="")
                            {   
                                $res_chk=$this->db->where('staff_gender', $model->staff_gender);
                            }

                            if(isset($model->zone_id) && $model->zone_id!="")
                            {   
                                $res_chk=$this->db->where('zone_id', $model->zone_id);
                            }

                            if(isset($model->present_state_id) && $model->present_state_id!="")
                            {   
                                $res_chk=$this->db->where('present_state_id', $model->present_state_id);
                            }

                            if(isset($model->staff_identity_id) && $model->staff_identity_id!="")
                            {   
                                $res_chk=$this->db->where('staff_identity_id', $model->staff_identity_id);
                            }

                            if(isset($model->staff_department_id) && $model->staff_department_id!="")
                            {   
                                $res_chk=$this->db->where('staff_department_id', $model->staff_department_id);
                            }

                            if(isset($model->staff_type_id) && $model->staff_type_id!="")
                            {   
                                $res_chk=$this->db->where('staff_type_id', $model->staff_type_id);
                            }

                            if(isset($model->staff_designation_id) && $model->staff_designation_id!="")
                            {   
                                $res_chk=$this->db->where('staff_designation_id', $model->staff_designation_id);
                            }

                        $res_chk=$this->db->order_by('staff_master.id', 'desc')
                        ->where('staff_delete_status', '0')
                        ->where('staff_relief_status!=', 'SR')
                        ->get('staff_master'); 

                       // var_dump($res_chk); die();
                }
                else
                {   

                    $res_chk=$this->db->select("staff_name, id");

                        if(isset($model->staff_employee_id) && $model->staff_employee_id!="")
                        {   
                            $res_chk=$this->db->where('staff_employee_id', $model->staff_employee_id);
                        }

                        if(isset($model->staff_gender) && $model->staff_gender!="")
                        {   
                            $res_chk=$this->db->where('staff_gender', $model->staff_gender);
                        }

                        if(isset($model->zone_id) && $model->zone_id!="")
                        {   
                            $res_chk=$this->db->where('zone_id', $model->zone_id);
                        }

                        if(isset($model->present_state_id) && $model->present_state_id!="")
                        {   
                            $res_chk=$this->db->where('present_state_id', $model->present_state_id);
                        }

                        if(isset($model->staff_identity_id) && $model->staff_identity_id!="")
                        {   
                            $res_chk=$this->db->where('staff_identity_id', $model->staff_identity_id);
                        }

                        if(isset($model->staff_department_id) && $model->staff_department_id!="")
                        {   
                            $res_chk=$this->db->where('staff_department_id', $model->staff_department_id);
                        }

                        if(isset($model->staff_type_id) && $model->staff_type_id!="")
                        {   
                            $res_chk=$this->db->where('staff_type_id', $model->staff_type_id);
                        }

                        if(isset($model->staff_designation_id) && $model->staff_designation_id!="")
                        {   
                            $res_chk=$this->db->where('staff_designation_id', $model->staff_designation_id);
                        }

                        $res_chk=$this->db->order_by('staff_master.id', 'desc')
                        ->where('staff_delete_status', '0')
                        ->where('staff_relief_status!=', 'SR')
                        ->get('staff_master'); 
                }
                //var_dump($model->selectedchildvalue!='undefined'); die();

                
                if(isset($model->selectedchildvalue))
                {
                    array_push($model->selectedchildvalue, "staff_id");
                 

                    $childcolumns = array_map(function($column) {
                        return 'staff_children.' . $column;
                    }, $model->selectedchildvalue);


                    $find_child_designation_column=array_search("staff_children.verified_designation",$childcolumns);
                        if(!empty($find_child_designation_column)){
                            array_push($childcolumns,"staff_designation_master.designation_name AS verified_designation");


                        } 

                     $res_chk_child=$this->db->select(implode(',', $childcolumns))
                            ->join('staff_designation_master', 'staff_children.verified_designation=staff_designation_master.id', 'left')
                            ->order_by('staff_children.id', 'desc')
                            ->where('deleted_status', '0')
                            ->get('staff_children');    

                    
                }
                

                if(isset($res_chk))
                {

                        if($res_chk->num_rows()>0){

                             global $gender, $childgender, $age_group,  $marital_status, $part_india, $identities, $emtypes, $blood_group, $family_position;
                            

                            foreach($res_chk->result_array() as $key=>$value){

                                    if(isset($value['staff_gender']))
                                    {
                                        $value['staff_gender'] = $gender[$value['staff_gender']];
                                    }
                                    if(isset($value['marital_status']))
                                    {
                                        $value['marital_status'] = $marital_status[$value['marital_status']];
                                    }
                                    if(isset($value['staff_identity_id']))
                                    {
                                        $value['staff_identity_id'] = $identities[$value['staff_identity_id']];
                                    }
                                    if(isset($value['staff_type_id']))
                                    {
                                        $value['staff_type_id'] = $emtypes[$value['staff_type_id']];
                                    }
                                    if(isset($value['staff_dedication_status']))
                                    {
                                       // var_dump($value['staff_dedication_status']); die();
                                       if($value['staff_dedication_status']==0)
                                       {
                                            $value['staff_dedication_status']="Not Dedicated";
                                       }
                                       else
                                       {
                                            $value['staff_dedication_status']="Not Dedicated";
                                       }
                                    }



                                     $child_column=count($model->selectedchildvalue);

                                    for($i=0; $i<$child_column; $i++)
                                    {
                                        $value[$model->selectedchildvalue[$i]]='';
                                    }
                                    
                                    $result[]=array($value);




                                    if(isset($model->selectedchildvalue))
                                    {

                                        if($res_chk_child->num_rows()>0){

                                            foreach($res_chk_child->result_array() as $key1=>$child){


                                                if(isset($child['gender']))
                                                {
                                                    $child['gender'] = $childgender[$child['gender']];
                                                }
                                                if(isset($child['marital_status']))
                                                {
                                                    $child['marital_status'] = $marital_status[$child['marital_status']];
                                                }
                                                if(isset($child['age_group']))
                                                {
                                                    $child['age_group'] = $age_group[$child['age_group']];
                                                }

                                                

                                                if($child['staff_id']==$value['id'])
                                                {

                                                    $resultcount=count($result);

                                                    $resultcount= $resultcount+1;

                                                    $result[$resultcount]=array();

                                                    for($i=0; $i<$staff_column; $i++)
                                                    {
                                                        $child[$model->selectedstaffvalue[$i]]='';
                                                    }


                                                    $result[]=array($child);
                                                }

                                            }
                                        }
                                    }

                            }

                       
                        }
                }                       
                else
                {
                    $response['status']="failure";            
                    $response['message']="Sorry!!, Invalid Attempt!!.. Permission denied.";
                }


        }
            if($result!=NULL)
            {
                $response['result']=$result;

                $response['resultth']=$tharray;
            }
            else
            {
                $response['result']=NULL;
            }
           // die(json_encode($response, JSON_UNESCAPED_SLASHES));

          //  var_dump($response); die();

             $html= $this->load->view('report/flatreport',$response, true);

            //this the the PDF filename that user will get to download

            $pdfFilePath = "staff_report.pdf";

            //load mPDF library

                    //load mPDF library
            $this->load->library('m_pdf');

           //generate the PDF from the given html
            $this->m_pdf->pdf->WriteHTML($html);

            //var_dump($this->m_pdf->pdf->WriteHTML($html)); die();

            //download it.
             $this->m_pdf->pdf->Output($pdfFilePath, "D");


            die(json_encode($this->m_pdf->pdf->Output($pdfFilePath, "D"), JSON_UNESCAPED_SLASHES));
    }


    public function gems_fetch_staff_month_report_view($report_id){
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        if($report_id!=""){

          // $res_chk=$this->db->select('sponsorship_master.*,sponsor_master.sponser_name')
               // ->join('sponsor_master', 'sponsorship_master.sponsor_group_id=sponsor_master.id', 'inner')
               //  ->where('sponsorship_master.id', $report_id)
               //  ->get('sponsorship_master');


            $res_chk=$this->db->select('staff_monthly_report.*,staff_master.*')
               ->join('staff_master', 'staff_monthly_report.staff_id=staff_master.id', 'inner')
                ->where('staff_monthly_report.id', $report_id)
                ->get('staff_monthly_report');   

               // var_dump($res_chk->row()); die();




            
            if($res_chk->num_rows()>0){

                $result = $res_chk->result_array();

                $response['result']=$result;
            }else{
                $response['status']="failure";
                $response['message']="Invalid Staff Id!!..";
            }
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";
        }
        
        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }   



     public function gems_approve_six_month_report() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");
        
        // $arr = $this->input->post('chkSelect');
        // $staff_ids = explode(",", $arr);


         $model = json_decode($this->input->post('model',FALSE));

         $staff_ids = $model->selectedstaff;


        //var_dump($staff_ids); die();

        if (is_array($staff_ids) && count($staff_ids)>0) {
            
            $success_count = 0;
            foreach ($staff_ids as $staff_id) {
                if ($this->db->where('id', $staff_id)->update('church_six_month_report', array('rep_sadmin_approve' => '1', 'rep_sadmin_approve_date' =>date('Y-m-d H:i:s')))) {
                    $success_count++;
                }
            }

            if (count($staff_ids)==$success_count) {
                $response['message']="Six Month Approve status has been updated successfully";
            } else {
                $response['status']="failure";
                $response['message']="Six Month Approve status has not been updated fully";
            }
        } else {
            $response['status']="failure";
            $response['message']="Choose Report and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }


    public function get_zone_master_filter_list(){
        $this->output->set_content_type('application/json');
        $response=array();
        $html="";
        $response['status']="success";
        $result=array();
        $res=$this->db->query("select z.id, z.staff_zone_name, z.region_id,z.email_id,z.ad_office, DATE_FORMAT(z.created_date,'%d/%m/%Y')as created_date, c.region_name from  ".$this->db->dbprefix('zones_staff_master')." as z, ".$this->db->dbprefix('region_master')." as c where c.id=z.region_id order by z.id desc");


        if($res->num_rows()>0){
            foreach($res->result_array() as $key=>$value){


                $result[]=array('id'=>$value['id'],'itemName'=>$value['staff_zone_name']);
            }
        }else{
            $response['status']="failure";
            $response['message']="No zone list found!!..";
        }
        $response['result']=$result;
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }


	public function get_identity_master_list() {
		  $this->output->set_content_type('application/json');
        $response=array();
        $html='';
        $response['status']="success";
        $result=array();
        
        $res=$this->db->query("select id,identity_name,DATE_FORMAT(created_date,'%d/%m/%Y')as created_date from ".$this->db->dbprefix('identity_master')." order by id desc");
        if($res->num_rows()>0){
            
            foreach($res->result_array() as $key=>$value){

            $html='<button type="button" class="btn btn-primary button_edit_region" 
                                  data-element-obj="'.$value['id'].'"><i class="glyphicon glyphicon-pencil" data-element-obj="'.$value['id'].'"></i></button> 

                          <button type="button" class="btn btn-danger button_delete_region"
                                  data-element-id="'.$value['id'].'"><i class="glyphicon glyphicon-trash" data-element-id="'.$value['id'].'"></i></button>';



               $result[]=array('id'=>$value['id'],'identity_name'=>$value['identity_name'],'created_date'=>$value['created_date'],'action'=>$html); 
            }
            
        }else{
            $response['status']="failure";
            $response['message']="No Identity record found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
	}

   public function gems_create_identity_master()
    {
      $this->output->set_content_type('application/json');
      $response=array();
      $response['status']="success";
        
      $identity_name=trim($this->input->post('identity_name',FALSE));
      $created_by=trim($this->input->post('created_by',FALSE));
        
        if($identity_name){
            
            $res_chk=$this->db->query("select id from ".$this->db->dbprefix('identity_master')." where identity_name='".$identity_name."'");
            if($res_chk->num_rows()>0){
                 $response['status']="failure";
                 $response['message']="Identity already exists";
            }else{
                    $this->db->query("insert into ".$this->db->dbprefix('identity_master')." (identity_name,created_date,created_by) 
                        values 
                        ('".$identity_name."', 
                            NOW(),
                        '".$created_by."')");
                if($this->db->insert_id()){                
                    $response['message']="Identity record has been inserted successfully";
                }else{
                    $response['status']="failure";
                    $response['message']="Something wrong in your input!!. Please try again..";
                }   
            }
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    }
    public function gems_fetch_identity_master($id)
    {
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $res=$this->db->query("select id, identity_name from ".$this->db->dbprefix('identity_master')." where id ='".$id."'");
        if($res->num_rows()>0){
            $in_array=$res->result_array();
            $result=array("id"=>$in_array[0]['id'],'identity_name'=>$in_array[0]['identity_name']);
        }else{
            $response['status']="failure";
            $response['message']=" No Region record found!!";
        }
        $response['result']=$result;
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
     public function gems_update_identity_master()
    {
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        
        $identity_name=trim($this->input->post('identity_name',FALSE));
        $modified_by=trim($this->input->post('modified_by',FALSE));
        $identity_id = trim($this->input->post('identity_id',FALSE));
        
        if($identity_name){
            
            $res_chk=$this->db->query("select id from ".$this->db->dbprefix('identity_master')." where identity_name='".$identity_name."' and id!='".$identity_id."'");
            if($res_chk->num_rows()>0){
                 $response['status']="failure";
                 $response['message']="Identity already exists";
            }else{
                $result=$this->db->query("update ".$this->db->dbprefix('identity_master')." set identity_name='".$identity_name."',created_date=NOW(), created_by='".$modified_by."' where id='".$identity_id."'  ");

                if($result){                
                    $response['message']="identity record has been updated successfully";
                }else{
                    $response['status']="failure";
                    $response['message']="Something wrong in your input!!. Please try again..";
                }
                
            }            
            
            
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();        
    }
    public function gems_delete_identity_master($id)
    {
    
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        
        if($id){            
            $this->db->query("delete from ".$this->db->dbprefix('identity_master')."  where id='".$id."'");
            $response['status']="success";
            $response['message']="identity record has been deleted successfully";
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";    
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    } 

  
}
