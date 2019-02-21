<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Child_controller extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *      http://example.com/index.php/welcome
     *  - or -
     *      http://example.com/index.php/welcome/index
     *  - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function index()
    {
         $this->output->set_content_type('application/json')
        ->set_output(json_encode(array('error' => 'UN-Authorized access'),JSON_UNESCAPED_SLASHES)); 
        die();      
    }
    
   
    public function gems_create_child_master(){
        
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
       //$model = json_decode($this->input->post('model',FALSE));
       //print_r($model);die();


        if($this->input->post('children_name',FALSE)!=''){

            $region_id=($this->input->post('region_id')!='undefined')?$this->input->post('region_id'):'';
            $zone_id=$this->input->post('zone_id',FALSE);
            $staff_id=$this->input->post('staff_id',FALSE);
            $cross_ref_no=$this->input->post('cross_ref_no',FALSE);
            $mks_no=$this->input->post('mks_no',FALSE);
            $children_name=$this->input->post('children_name',FALSE);
            $age=($this->input->post('age',FALSE)!='undefined')?$this->input->post('age'):'';
            $education=($this->input->post('education',FALSE)!='undefined')?$this->input->post('education'):'';
            $address=$this->input->post('address',FALSE);
            $contact_no=$this->input->post('contact_no',FALSE);
            $dob=$this->input->post('dob',FALSE);
            $salvation_date=$this->input->post('salvation_date',FALSE);
            $baptism_date=$this->input->post('baptism_date',FALSE);
            $involvement_ministry=($this->input->post('involvement_ministry',FALSE)!='undefined')?$this->input->post('involvement_ministry'):'';
            $gender=$this->input->post('gender',FALSE);
            $age_group=($this->input->post('age_group',FALSE)!='undefined')?$this->input->post('age_group'):'';
            $family_position=$this->input->post('family_position',FALSE);
            $job_description=$this->input->post('job_description',FALSE);
            $marital_status=$this->input->post('marital_status',FALSE);
            $email_id=$this->input->post('email_id',FALSE);
            $spouse_name=$this->input->post('spouse_name',FALSE);
            $sponsor_count=($this->input->post('sponsor_count',FALSE)!='undefined')?$this->input->post('sponsor_count'):'';
            $special_meeting=($this->input->post('special_meeting',FALSE));
            $verified_name=$this->input->post('verified_name',FALSE);
            $verified_designation=$this->input->post('verified_designation',FALSE);
            $present_status=$this->input->post('present_status',FALSE);
            $created_by=$this->input->post('created_by',FALSE);
            $dob=date("Y-m-d", strtotime($dob));
            $salvation_date=date("Y-m-d", strtotime($salvation_date));
            $baptism_date=date("Y-m-d", strtotime($baptism_date));


            //print_r($present_status);die();
            $res_chk=$this->db->query("select id from ".$this->db->dbprefix('staff_children')." where children_name='".$children_name."' ");
            if($res_chk->num_rows()>0){
                    $response['status']="failure";            
                    $response['message']="Sorry!!, Children name already exists.";
                
            }else{
                $this->db->query("insert into ".$this->db->dbprefix('staff_children')." 
                    (
                    region_id,
                    staff_zone_id,
                    staff_id,
                    cross_ref_no,
                    mks_no,
                    children_name,
                    children_age,
                    education,
                    address,
                    contact_no,
                    date_birth,
                    date_salvation,
                    date_baptism,
                    involvement_ministry,
                    gender,
                    age_group,
                    position_family,
                    job_description,
                    marital_status,
                    email_id,
                    spouse_name,
                    sponsor_count,
                    special_camps_attended,
                    verified_name,
                    verified_designation,
                    deleted_status,
                    created_date,
                    present_status,
                    created_by) values (
                                        '".$region_id."',
                                        '".$zone_id."',
                                        '".$staff_id."',
                                        '".$cross_ref_no."',
                                        '".$mks_no."',
                                        '".$children_name."',
                                        '".$age."',
                                        '".$education."',
                                        '".$address."',
                                        '".$contact_no."',
                                        '".$dob."',
                                        '".$salvation_date."',
                                        '".$baptism_date."',
                                        '".$involvement_ministry."',
                                        '".$gender."',
                                        '".$age_group."',
                                        '".$family_position."',
                                        '".$job_description."',
                                        '".$marital_status."',
                                        '".$email_id."',
                                        '".$spouse_name."',
                                        '".$sponsor_count."',
                                        '".$special_meeting."',
                                        '".$verified_name."',
                                        '".$verified_designation."',
                                        '0',
                                        NOW(),
                                        '".$present_status."',
                                        '".$created_by."')"
                );
                if($this->db->insert_id()){
                    $response['result']=array('id'=>$this->db->insert_id());
                    $response['message']="Children record stored successfully";
                }else{
                    $response['status']="failure";            
                    $response['message']="Sorry!!, Unable to insert the Children data";
                }
            }
            
        }else{
                $response['status']="failure";            
                $response['message']="Sorry!!, Invalid Attempt!!.. Permission denied.";
        }
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }

    public function get_childdata_master_list(){
        $this->output->set_content_type('application/json');
        $response=array();
        $html="";
         global $api_path;
        $response['status']="success";
        $result=array();
        $res=$this->db->select("childdata_master.id, staff_master.staff_name as staff_id, zones_staff_master.staff_zone_name as zone_id, staff_children.children_name as child_id, name_of_course, name_of_institute, year_of_data, 
            DATE_FORMAT(".$this->db->dbprefix('childdata_master').".created_at,'%d/%m/%Y') as created_at")
            ->join('staff_master', 'childdata_master.staff_id=staff_master.id', 'left')
            ->join('zones_staff_master', 'childdata_master.zone_id=zones_staff_master.id', 'left')
            ->join('staff_children', 'childdata_master.child_id=staff_children.id', 'left')
            ->order_by('id desc')
            ->where('is_deleted', '0')
            ->get('childdata_master');


        if($res->num_rows()>0){
            foreach($res->result_array() as $key=>$value){

            $html='<a class="btn btn-primary" href="'.$api_path.'/#/editchilddata/'.$value['id'].'"><i class="glyphicon glyphicon-pencil"></i></a> 

                          <button type="button" class="btn btn-danger button_delete_child"
                                  data-element-id="'.$value['id'].'"><i class="glyphicon glyphicon-trash" data-element-id="'.$value['id'].'"></i></button>';




                $result[]=array('id'=>$value['id'],'child_id'=>$value['child_id'], 'zone_id'=>$value['zone_id'], 'staff_id'=>$value['staff_id'], 'name_of_course'=>$value['name_of_course'],'name_of_institute'=>$value['name_of_institute'],'year_of_data'=>$value['year_of_data'],'created_at'=>$value['created_at'],'action'=>$html);
            }
        }else{
            $response['status']="failure";
            $response['message']="No Children list found!!..";
        }
        $response['result']=$result;
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }

   
    
    
    public function get_child_master_list(){
        $this->output->set_content_type('application/json');
        $response=array();
        $html="";
         global $api_path;
        $response['status']="success";
        $result=array();
        $res=$this->db->select("staff_children.id, staff_children.sponsor_count, staff_master.staff_name as staff_id, staff_master.id as child_staff_id, children_name, email_id, contact_no, gender, DATE_FORMAT(".$this->db->dbprefix('staff_children').".created_date,'%d/%m/%Y') as created_date")
            ->join('staff_master', 'staff_children.staff_id=staff_master.id', 'left')
            ->order_by('id desc')
            ->get('staff_children');
        if($res->num_rows()>0){
            foreach($res->result_array() as $key=>$value){

                if($value['gender']==1){ $value['gender'] ='Male'; }

                if($value['gender']==2){ $value['gender']='Female'; }

            // <button type="button" class="btn btn-primary button_edit_child" data-element-obj="'.$value['id'].'"><i class="glyphicon glyphicon-pencil" data-element-obj="'.$value['id'].'"></i></button> 
            $html='<a class="btn btn-primary" href="'.$api_path.'/#/editchild/'.$value['id'].'"><i class="glyphicon glyphicon-pencil"></i></a> 

                          <button type="button" class="btn btn-danger button_delete_child"
                                  data-element-id="'.$value['id'].'"><i class="glyphicon glyphicon-trash" data-element-id="'.$value['id'].'"></i></button>';




                $result[]=array('id'=>$value['id'],'children_name'=>$value['children_name'],'sponsor_count'=>$value['sponsor_count'],'staff_id'=>$value['staff_id'], 'child_staff_id'=>$value['child_staff_id'],'email_id'=>$value['email_id'],'contact_no'=>$value['contact_no'],'gender'=>$value['gender'],'created_date'=>$value['created_date'],'action'=>$html);
            }
        }else{
            $response['status']="failure";
            $response['message']="No Children list found!!..";
        }
        $response['result']=$result;
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
    
    public function gems_get_spouse()
    {
         $staff_id = json_decode($this->input->post('id',FALSE));

          $res=$this->db->query("select * from ".$this->db->dbprefix('staff_master')." where id='".$staff_id."'");
          $result=array();

            if($res->num_rows()>0){
                $in_array=$res->result_array();
                $result_data=$in_array[0];

                $query=$this->db->query("select id,children_name,staff_id from ".$this->db->dbprefix('staff_children')." where staff_id='".$staff_id."' AND deleted_status=0");
                $staff_child_data=$query->result_array();

                if(count($staff_child_data)>0)
                {
                    foreach ($staff_child_data as $key => $value) 
                    {
                        $result['child_list'][]=array('id'=>$value['id'],'staff_id'=>$value['staff_id'],'child_name'=>$value['children_name']);
                    } 
                    $result['total_child_count']=count($staff_child_data);  
                }
                else{
                    $result['total_child_count']=0;
                }


                $get_matched_record_based_cri=$this->db->query("select * from ".$this->db->dbprefix('staff_master')." where staff_cross_ref_number='".$result_data['staff_cross_ref_number']."' AND id NOT IN('".$staff_id."')");

                $array_result=$get_matched_record_based_cri->result_array();
                if(count($array_result)>0)
                {
                    $result['staff_name']=$array_result[0]['staff_name'];
                    $result['spouse_native_place']=$array_result[0]['place_native'];
                    $result['spouse_part_of_india']=$array_result[0]['part_of_india'];  
                    $result['missionary_native_place']=$result_data['place_native'];
                    $result['missionary_part_of_india']=$result_data['part_of_india'];   
                }
                else{
                    $result['staff_name']='';
                    $result['spouse_native_place']='';
                    $result['spouse_part_of_india']='';  
                    $result['missionary_native_place']='';
                    $result['missionary_part_of_india']=''; 
                }
                
               // print_r($staff_child_data);die();
            }else{
                $response['status']="failure";
                $response['message']=" No Staffchild record found!!";
            }
            $response['result']=$result;
             echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }

    public function gems_get_CA()
    {
         $child_id = json_decode($this->input->post('id',FALSE));

          $res=$this->db->query("select * from ".$this->db->dbprefix('childdata_master')." where child_id='".$child_id."'");
          $result=array();

            if($res->num_rows()>0){
                $in_array=$res->result_array();
                $result_data=$in_array;

                foreach ($result_data as $key => $value) 
                    {
                        $result['child_list'][]=array('id'=>$value['id'],'ca_eligiblity'=>$value['ca_eligiblity']);
                    } 
            }else{
                $response['status']="failure";
                $response['message']=" No CA record found!!";
            }
            $response['result']=$result;
             echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
    
    public function gems_add_parent_data()
    {
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";

        $model = json_decode($this->input->post('model',FALSE));

         if($model!=''){
            
                $this->db->query("insert into ".$this->db->dbprefix('parent_data_master')." (
                        zone_id,
                        staff_id,
                        spouse_name,
                        place_of_missionary,
                        missionary_part_of_india,
                        place_of_spouse,
                        spouse_part_of_india,
                        no_of_child,
                        child_list_id,
                        ca_eligiblity,
                        distance,
                        missionary_education,
                        missionary_spouse_education,
                        involvement_in_gems,
                        location,
                        position_in_gems,
                        created_at,
                        is_deleted
                            ) values (
                                '".$model->zone_id."',
                                '".$model->staff_id."',
                                '".$model->spouse_name."',
                                '".$model->place_of_missionary."',
                                '".$model->missionary_part_of_india."',
                                '".$model->place_of_spouse."',
                                '".$model->spouse_part_of_india."',
                                '".$model->no_of_child."',
                                '".$model->child_list_id."',
                                '".$model->ca_eligiblity."',
                                '".$model->distance."',
                                '".$model->missionary_education."',
                                '".$model->missionary_spouse_education."',
                                '".$model->involvement_in_gems."',
                                '".$model->location."',
                                '".$model->position_in_gems."',
                                NOW(),
                                '0'
                                )");
               // print_r($this->db->insert_id());die();
                if($this->db->insert_id()){
                        $last_parent_data_id=$this->db->insert_id();
                    /***Get Children details***/
                         $child_query=$this->db->query("select * from ".$this->db->dbprefix('staff_children')." where id='".$model->child_list_id."' AND deleted_status=0");

                         $staff_child_data=$child_query->result_array();
                         $child_data_result = $staff_child_data[0];
                    /*********/

                     /**
                        **CSH POINTS calculation**
                     **/

                    /****Distance**/
                        if($model->distance<=1000){$csh_distance_point=5;}
                        elseif(($model->distance>1000)&&($model->distance<=2000)){$csh_distance_point=10;}
                        elseif($model->distance>2000){$model->distance=15;}
                        else{$csh_distance_point=0;}
                    /****End of Distance*/    

                    /****Education of Parents*****/
                        if(($model->missionary_education>=1)&&(($model->missionary_education<=14))){$parents_education_point=5;}
                        elseif(($model->missionary_education==15)||(($model->missionary_education==17))) {$parents_education_point=10; }
                        elseif($model->missionary_education==16) {$parents_education_point=15; }
                        else{$parents_education_point=0;}
                    /***End of parents****/

                    /****Mother Involvement****/
                        if($model->involvement_in_gems==1){$parent_involvement_point=5;}
                        elseif($model->involvement_in_gems==2) {$parent_involvement_point=10; }
                        elseif($model->involvement_in_gems==3) {$parent_involvement_point=15; }
                        else{$parent_involvement_point=0;}
                    /*********/

                    /****Position in Gems****/
                        if($model->position_in_gems==1){$position_in_gems=15;}
                        elseif($model->position_in_gems==2) {$position_in_gems=10; }
                        elseif($model->position_in_gems==3) {$position_in_gems=5; }
                        else{$position_in_gems=0;}
                    /*********/


                    /***Percentage score in Education*/
                        $child_data_percentage_query=$this->db->query("select * from ".$this->db->dbprefix('childdata_master')." where child_id='".$model->child_list_id."' AND is_deleted='0'");
                         $staff_child_data_percentage=$child_data_percentage_query->result_array();

                         $result_percentage = $staff_child_data_percentage[0];

                         $total_percentage = ($result_percentage['percentage_scored'])?$result_percentage['percentage_scored']:0;
                         
                         if($result_percentage['education']>=12)
                         {
                            if($total_percentage==6){$child_cap_point=15;}
                            elseif($total_percentage==4){$child_cap_point=10;}
                            elseif(($total_percentage>=1)&&($total_percentage<=3)){$child_cap_point=5;}
                            else{$child_cap_point=0;}
                         }
                         elseif($result_percentage['education']<12) 
                         {
                             if($total_percentage>=5){$child_cap_point=15;}
                             elseif(($total_percentage>=3)&&($total_percentage<=4)){$child_cap_point=10;}
                             elseif($total_percentage<=2){$child_cap_point=5;}
                             else{$child_cap_point=0;}
                         }
                    /*****/

                    /***child experience******/
                    $staff_exp=$this->db->query("select * from ".$this->db->dbprefix('staff_vs_experience')." where fk_staff_id='".$model->staff_id."'");
                            $staff_exp_det=$staff_exp->result_array();
                            $staff_exp_from_date_det = $staff_exp_det[0]['exp_from_date'];

                            $staff_to_date = date("Y-m-d");
                            $staff_from_date_convert = date_create($staff_exp_from_date_det);
                            $staff_to_date_convert = date_create($staff_to_date);
                            $diff=date_diff($staff_from_date_convert,$staff_to_date_convert);
                            $staff_exp_in_gems = $diff->format("%y");
                            // echo $staff_exp_in_gems;
                            // die();

                    if($staff_exp_in_gems<=25)
                    {
                        $experience_point = $staff_exp_in_gems;
                    }else{$experience_point=0;}
                    /***/

                    /****Cumulative CSH Points*****/
                        $all_points_array=array($csh_distance_point,$parents_education_point,$parent_involvement_point,$position_in_gems,$child_cap_point,$experience_point);

                        $cumulative_csh_points = array_sum($all_points_array);
                    /*****/

                    /***CA Amount Calculation*****/
                        if($child_data_result['children_age']<=5){$ca_amount=600;}
                        elseif(($child_data_result['children_age']>=6)&&($child_data_result['children_age']<=12)){$ca_amount=700;}
                        elseif(($child_data_result['children_age']>=13)&&($child_data_result['children_age']<=18)){$ca_amount=850;}
                        elseif(($child_data_result['children_age']>=19)&&($child_data_result['children_age']<=25)){$ca_amount=1100;}
                        else{$ca_amount=0;}
                    /**********/

                    /*****CSH Amount calculation****/
                        if($cumulative_csh_points>=75)
                        {
                            if(($result_percentage['education']>=3)&&($result_percentage['education']<=9))
                            {
                                $csh_amount = 600;     
                            }
                            elseif(($result_percentage['education']>=10)&&($result_percentage['education']<=14))
                            {
                                $csh_amount = 900;     
                            }
                            elseif($result_percentage['education']==10)
                            {
                                $csh_amount = 900;     
                            }
                            elseif($result_percentage['education']==15)
                            {
                                $csh_amount = 1200;     
                            }
                            elseif($result_percentage['education']==16)
                            {
                                $csh_amount = 1500;     
                            }
                            else{$csh_amount=0;}
                        }
                        elseif(($cumulative_csh_points>=55)&&($cumulative_csh_points<=74))
                        {
                            if(($result_percentage['education']>=3)&&($result_percentage['education']<=9))
                            {
                                $csh_amount = 400;     
                            }
                            elseif(($result_percentage['education']>=10)&&($result_percentage['education']<=14))
                            {
                                $csh_amount = 600;     
                            }
                            elseif($result_percentage['education']==10)
                            {
                                $csh_amount = 600;     
                            }
                            elseif($result_percentage['education']==15)
                            {
                                $csh_amount = 800;     
                            }
                            elseif($result_percentage['education']==16)
                            {
                                $csh_amount = 1000;     
                            }
                            else{$csh_amount=0;}
                        }
                        elseif(($cumulative_csh_points>=40)&&($cumulative_csh_points<=54))
                        {
                            if(($result_percentage['education']>=3)&&($result_percentage['education']<=9))
                            {
                                $csh_amount = 200;     
                            }
                            elseif(($result_percentage['education']>=10)&&($result_percentage['education']<=14))
                            {
                                $csh_amount = 300;     
                            }
                            elseif($result_percentage['education']==10)
                            {
                                $csh_amount = 300;     
                            }
                            elseif($result_percentage['education']==15)
                            {
                                $csh_amount = 400;     
                            }
                            elseif($result_percentage['education']==16)
                            {
                                $csh_amount = 500;     
                            }
                            else{$csh_amount=0;}
                        }
                        else{$csh_amount=0;}
                    /****/

                    /****CER Amount calculation**********/
                        $check_staff_children_getting_allowance=$this->db->query("select * from ".$this->db->dbprefix('allowancedata_master')." where staff_id='".$model->staff_id."' AND is_deleted='0'");
                         $data_exist=$check_staff_children_getting_allowance->result_array();

                         if(count($data_exist)>0)
                         {
                            //check staff and children has same region id
                            $staff_region_id_query=$this->db->query("select * from ".$this->db->dbprefix('staff_master')." where id='".$model->staff_id."'");
                            $staff_region_id=$staff_region_id_query->result_array();
                            $result_region_id = $staff_region_id[0];

                            /****check same region and child medium of instruct is english***/
                            if($result_region_id['region_id']==$child_data_result['region_id'])
                            {
                                if(($result_percentage['education']>=1)&&($result_percentage['education']<=11)){
                                    $cer_amount=300;
                                }
                                elseif(($result_percentage['education']>=12)&&($result_percentage['education']<=14)){
                                    $cer_amount=400;
                                }
                                 elseif(($result_percentage['education']>=14)&&($result_percentage['education']<=16)){
                                    $cer_amount=500;
                                }
                                 elseif($result_percentage['education']==17){
                                    $cer_amount=400;
                                }
                            }
                            else
                            {
                                if(($result_percentage['education']>=1)&&($result_percentage['education']<=11)){
                                    $cer_amount=150;
                                }
                                elseif(($result_percentage['education']>=12)&&($result_percentage['education']<=14)){
                                    $cer_amount=200;
                                }
                                 elseif(($result_percentage['education']>=14)&&($result_percentage['education']<=16)){
                                    $cer_amount=250;
                                }
                                 elseif($result_percentage['education']==17){
                                    $cer_amount=200;
                                }
                            }

                         }else{
                            $cer_amount = 0;
                         }
                    /***/
                 /********/
                 
                 $child_data_exist=$this->db->query("select * from ".$this->db->dbprefix('allowancedata_master')." where child_id='".$model->child_list_id."' AND is_deleted=0");
                         $child_data_exist_result=$child_data_exist->result_array();   
                         //print_r(count($child_data_exist_result));die();
                       if(count($child_data_exist_result)>0)
                       {
                            $data=array(
                            'staff_id'=>$model->staff_id,
                            'child_id'=>$model->child_list_id,
                            'parent_data_id'=>$last_parent_data_id,
                            'csh_points'=>$cumulative_csh_points,
                            'ca_amount'=>$ca_amount,
                            'cer_amount'=>$cer_amount,
                            'csh_amount'=>$csh_amount,
                            );
                         //print_r($child_data_exist_result[0]['id']);die();

                            $this->db->set('created_at', 'NOW()', FALSE);
                            $this->db->where('id',$child_data_exist_result[0]['id']);
                            $this->db->update($this->db->dbprefix('allowancedata_master'),$data);
                       } 
                       else
                       {
                        $this->db->query("insert into ".$this->db->dbprefix('allowancedata_master')." (
                        staff_id,
                        child_id,
                        parent_data_id,
                        csh_points,
                        ca_amount,
                        cer_amount,
                        csh_amount,
                        created_at
                            ) values (
                                '".$model->staff_id."',
                                '".$model->child_list_id."',
                                '".$last_parent_data_id."',
                                '".$cumulative_csh_points."',
                                '".$ca_amount."',
                                '".$cer_amount."',
                                '".$csh_amount."',
                                NOW()
                                )");
                       } 
                    // $result['resultdata']=array('child_name'=>$child_data_result['children_name'],'child_age'=>$child_data_result['children_age'],'csh_points'=>$cumulative_csh_points,'ca_amount'=>$ca_amount,'csh_amount'=>$csh_amount);

                    

                    $response['result']=array('id'=>$this->db->insert_id());
                    $response['message']="Parent data record stored successfully";
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
    public function gems_fetch_child_master($id){

        $this->output->set_content_type('application/json');
        $response=array();        
        $response['status']="success";
        $result=array();
       if($id){
        $res=$this->db->query("select id,region_id,staff_zone_id,staff_id,cross_ref_no,mks_no,children_name,children_age,education,address,contact_no,date_birth,date_salvation,date_baptism,involvement_ministry,gender,age_group,position_family,job_description,marital_status,email_id,spouse_name,special_camps_attended,verified_name,verified_designation,present_status from ".$this->db->dbprefix('staff_children')." where id ='".$id."'");
            if($res->num_rows()>0){
                $in_array=$res->result_array();
                //print_r($in_array);die();
                $in_array=$in_array[0];
                $result=array(
                "id"                     =>$in_array['id'],
                "region_id"              =>$in_array['region_id'],
                "staff_zone_id"          =>$in_array['staff_zone_id'],
                "staff_id"               =>$in_array['staff_id'],
                "cross_ref_no"           =>$in_array['cross_ref_no'],
                "mks_no"                 =>$in_array['mks_no'],
                "children_name"          =>$in_array['children_name'],
                "children_age"           =>$in_array['children_age'],
                "education"              =>$in_array['education'],
                "address"                =>$in_array['address'],
                "contact_no"             =>$in_array['contact_no'],
                "date_birth"             =>$in_array['date_birth'],
                "date_salvation"         =>$in_array['date_salvation'],
                "date_baptism"           =>$in_array['date_baptism'],
                "involvement_ministry"   =>$in_array['involvement_ministry'],
                "gender"                 =>$in_array['gender'],
                "age_group"              =>$in_array['age_group'],
                "position_family"        =>$in_array['position_family'],
                "job_description"        =>$in_array['job_description'],
                "marital_status"         =>$in_array['marital_status'],
                "email_id"               =>$in_array['email_id'],
                "spouse_name"            =>$in_array['spouse_name'],
                "special_camps_attended" =>$in_array['special_camps_attended'],
                "verified_name"          =>$in_array['verified_name'],
                "verified_designation"   =>$in_array['verified_designation'],                                                                                "present_status"     =>$in_array['present_status'],                                                                                                                                                             
                );
                
            }else{
                $response['status']="failure";
                $response['message']="No Children record found..";
            }
        
       }else{
             $response['status']="failure";
             $response['message']="Invalid Attempt!!.. Any one of the input values are missed.. Access denied..";
       } 
    
        $response['result']=$result;
    
    
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    }

    public function gems_fetch_staffchild_master($id)
    {
        //var_dump($id); die();
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();

            $res=$this->db->query("select * from ".$this->db->dbprefix('staff_master')." where id='".$id."'");

            if($res->num_rows()>0){
                $in_array=$res->result_array();
                $result=$in_array[0];
            }else{
                $response['status']="failure";
                $response['message']=" No Staffchild record found!!";
            }
            $response['result']=$result;

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }

    public function gems_fetch_childdata_master($id)
    {
        //var_dump($id); die();
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();

            $res=$this->db->query("select * from ".$this->db->dbprefix('parent_data_master')." where id='".$id."'");

            if($res->num_rows()>0){
                $in_array=$res->result_array();
                $result=$in_array[0];
            }else{
                $response['status']="failure";
                $response['message']=" No child record found!!";
            }
            $response['result']=$result;

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
    public function get_parentdata_master_list($id)
    {
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();

            $res=$this->db->query("select * from ".$this->db->dbprefix('parent_data_master')." where id='".$id."'");

            if($res->num_rows()>0){
                $in_array=$res->result_array();
                $result=$in_array[0];
            }else{
                $response['status']="failure";
                $response['message']=" No child record found!!";
            }
            $response['result']=$result;

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }

    public function get_parentdata_master_list_view($id)
    {
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();

       // print_r($id);die();
        $res=$this->db->query("select * from ".$this->db->dbprefix('parent_data_master')." where id='".$id."'");
        $parent_list_array=$res->result_array();
        if(count($parent_list_array)>0)
        {
            foreach ($parent_list_array as $key => $value) 
            {
              
                $res=$this->db->query("select * from ".$this->db->dbprefix('staff_master')." where id='".$value['staff_id']."'");            
                $in_array=$res->result_array();
                $staff_name=$in_array[0]['staff_name'];
                $spouse_name=$in_array[0]['spouse_name'];
                $current_city=$in_array[0]['present_city'];

                $trust_get_query=$this->db->query("select * from ".$this->db->dbprefix('zones_staff_master')." where id='".$value['zone_id']."'");            
                $trust_get_query_data=$trust_get_query->result_array();
                $trust_name=$trust_get_query_data[0]['staff_zone_name'];

                $get_total_child=$this->db->query("select * from ".$this->db->dbprefix('staff_children')." where staff_id='".$value['staff_id']."'");            
                $get_total_child_data=$get_total_child->result_array();
                $total_child=count($get_total_child_data);
               
               $get_allowance_allot_child=$this->db->query("select * from ".$this->db->dbprefix('allowancedata_master')." where staff_id='".$value['staff_id']."'");            
                $get_allownace_child_data=$get_allowance_allot_child->result_array();
                //print_r($get_total_child_data);die();
                if((count($get_allownace_child_data)>0)&&(count($get_total_child_data)>0))
                {
                    $total_eligible_child=count($get_allownace_child_data);    
                }
                else
                {
                    $total_eligible_child='NA';
                }
                
                $get_allowance_allot_child_data=$this->db->query("select * from ".$this->db->dbprefix('allowancedata_master')." where parent_data_id=".$id." AND is_deleted='0' ");            
                $tot_parent_data=$get_allowance_allot_child_data->result_array();
                if(count($tot_parent_data)>0)
                {
                    $csh_points = $tot_parent_data[0]['csh_points'];
                    $
                    $ca_allowance = $tot_parent_data[0]['ca_amount'];
                    $cer_allowance = $tot_parent_data[0]['cer_amount'];
                    $csh_allowance = $tot_parent_data[0]['csh_amount'];  

                    $get_child_details=$this->db->query("select * from ".$this->db->dbprefix('staff_children')." where id=".$tot_parent_data[0]['child_id']."");            
                    $child_data=$get_child_details->result_array();

                    $child_name = $child_data[0]['children_name'];
                    $child_age = $child_data[0]['children_age'];                  
                }else{
                    $csh_points = 0;
                    $ca_allowance = 0;
                    $cer_allowance = 0;
                    $csh_allowance = 0;
                    $child_name = 'Nil';
                    $child_age = 0; 
                }

                $result['parent_data_details']=array('staff_name'=>$staff_name,'current_city'=>$current_city,'spouse_name'=>$spouse_name,'trust_name'=>$trust_name,'eligible_children'=>$total_eligible_child,'total_children'=>$total_child,'csh_points'=>$csh_points,'ca_allowance'=>$ca_allowance,'cer_allowance'=>$cer_allowance,'csh_allowance'=>$csh_allowance,'children_name'=>$child_name,'child_age'=>$child_age);
            }
           
        }
        else{
             $response['status']="failure";
             $response['message']=" No record found!!";
        }
        $response['result']=$result;
       // print_r($response);die();
        echo json_encode($response,JSON_UNESCAPED_SLASHES);        
        die();

    }

    public function update_parent_master_list()
    {
       
         $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";

        $resultdata = json_decode($this->input->post('resultdata',FALSE));
  //       print_r($resultdata);die();


         if($resultdata->id!="")
         {  
            $zone_id                  = ($resultdata->zone_id!='undefined')?$resultdata->zone_id:'';
            $staff_id                  = ($resultdata->staff_id!='undefined')?$resultdata->staff_id:'';
            $spouse_name              = ($resultdata->spouse_name!='undefined')?$resultdata->spouse_name:'';
            $place_of_missionary      = ($resultdata->place_of_missionary!='undefined')?$resultdata->place_of_missionary:'';
            $missionary_part_of_india = ($resultdata->missionary_part_of_india!='undefined')?$resultdata->missionary_part_of_india:'';
            $place_of_spouse          = ($resultdata->place_of_spouse!='undefined')?$resultdata->place_of_spouse:'';
            $spouse_part_of_india     = ($resultdata->spouse_part_of_india!='undefined')?$resultdata->spouse_part_of_india:'';
            $no_of_child              = (isset($resultdata->no_of_child)&&$resultdata->no_of_child!='undefined')?$resultdata->no_of_child:'';
            $child_list_id            = ($resultdata->child_list_id!='undefined')?$resultdata->child_list_id:'';
            $ca_eligiblity            = ($resultdata->ca_eligiblity!='undefined')?$resultdata->ca_eligiblity:'';
            $distance                 = ($resultdata->distance!='undefined')?$resultdata->distance:'';
            $missionary_education     = ($resultdata->missionary_education!='undefined')?$resultdata->missionary_education:'';
            $missionary_spouse_education = ($resultdata->missionary_spouse_education!='undefined')?$resultdata->missionary_spouse_education:'';
            $involvement_in_gems      = ($resultdata->involvement_in_gems!='undefined')?$resultdata->involvement_in_gems:'';
            $location                 = ($resultdata->location!='undefined')?$resultdata->location:'';
            $position_in_gems         = ($resultdata->position_in_gems!='undefined')?$resultdata->position_in_gems:'';


                $data=array('zone_id'=>$zone_id,
                            'staff_id'=>$staff_id,
                            'spouse_name'=>$spouse_name,
                            'place_of_missionary'=>$place_of_missionary,
                            'missionary_part_of_india'=>$missionary_part_of_india,
                            'place_of_spouse'=>$place_of_spouse,
                            'spouse_part_of_india'=>$spouse_part_of_india,
                            'no_of_child'=>$no_of_child,
                            'child_list_id'=>$child_list_id,
                            'ca_eligiblity'=>$ca_eligiblity,
                            'distance'=>$distance,
                            'missionary_education'=>$missionary_education,
                            'missionary_spouse_education'=>$missionary_spouse_education,
                            'involvement_in_gems'=>$involvement_in_gems,
                            'location'=>$location,
                            'position_in_gems'=>$position_in_gems,
                            //'created_at'=>NOW(),
                            'is_deleted'=>'0'
                            );

                $this->db->set('created_at', 'NOW()', FALSE);
                $this->db->where('id',$resultdata->id);
                $this->db->update($this->db->dbprefix('parent_data_master'),$data);                                                             



                    /***Get Children details***/
                         $child_query=$this->db->query("select * from ".$this->db->dbprefix('staff_children')." where id='".$child_list_id."' AND deleted_status=0");

                         $staff_child_data=$child_query->result_array();
                         if(count($staff_child_data)>0)
                         {
                            $child_data_result = $staff_child_data[0];   
                         }
                         
                    /*********/

                     /**
                        **CSH POINTS calculation**
                     **/

                    /****Distance**/
                        if($distance<=1000){$csh_distance_point=5;}
                        elseif(($distance>1000)&&($distance<=2000)){$csh_distance_point=10;}
                        elseif($distance>2000){$csh_distance_point=15;}
                        else{$csh_distance_point=0;}
                    /****End of Distance*/    

                    /****Education of Parents*****/
                        // if($missionary_education==1){$parents_education_point=5;}
                        // elseif(($missionary_education==4)||($missionary_education==2)) {$parents_education_point=10; }
                        // elseif($missionary_education==3) {$parents_education_point=15; }
                        // else{$parents_education_point=0;}
                         if(($model->missionary_education>=1)&&(($model->missionary_education<=14))){$parents_education_point=5;}
                        elseif(($model->missionary_education==15)||(($model->missionary_education==17))) {$parents_education_point=10; }
                        elseif($model->missionary_education==16) {$parents_education_point=15; }
                        else{$parents_education_point=0;}
                    /***End of parents****/

                    /****Mother Involvement****/
                        if($involvement_in_gems==1){$parent_involvement_point=5;}
                        elseif($involvement_in_gems==2) {$parent_involvement_point=10; }
                        elseif($involvement_in_gems==3) {$parent_involvement_point=15; }
                        else{$parent_involvement_point=0;}
                    /*********/

                    /****Position in Gems****/
                        if($position_in_gems==1){$position_in_gems=15;}
                        elseif($position_in_gems==2) {$position_in_gems=10; }
                        elseif($position_in_gems==3) {$position_in_gems=5; }
                        else{$position_in_gems=0;}
                    /*********/


                    /***Percentage score in Education*/
                        $child_data_percentage_query=$this->db->query("select * from ".$this->db->dbprefix('childdata_master')." where child_id='".$child_list_id."' AND is_deleted='0'");
                         $staff_child_data_percentage=$child_data_percentage_query->result_array();

                         $result_percentage = $staff_child_data_percentage[0];

                         $total_percentage = ($result_percentage['percentage_scored'])?$result_percentage['percentage_scored']:0;

                         if($result_percentage['education']>=12)
                         {
                            if($total_percentage==6){$child_cap_point=15;}
                            elseif($total_percentage==4){$child_cap_point=10;}
                            elseif(($total_percentage>=1)&&($total_percentage<=3)){$child_cap_point=5;}
                            else{$child_cap_point=0;}
                         }
                         elseif($result_percentage['education']<12) 
                         {
                             if($total_percentage>=5){$child_cap_point=15;}
                             elseif(($total_percentage>=3)&&($total_percentage<=4)){$child_cap_point=10;}
                             elseif($total_percentage<=2){$child_cap_point=5;}
                             else{$child_cap_point=0;}
                         }
                    /*****/

                  /***child experience******/
                    $staff_exp=$this->db->query("select * from ".$this->db->dbprefix('staff_vs_experience')." where fk_staff_id='".$model->staff_id."'");
                            $staff_exp_det=$staff_exp->result_array();
                            $staff_exp_from_date_det = $staff_exp_det[0]['exp_from_date'];

                            $staff_to_date = date("Y-m-d");
                            $staff_from_date_convert = date_create($staff_exp_from_date_det);
                            $staff_to_date_convert = date_create($staff_to_date);
                            $diff=date_diff($staff_from_date_convert,$staff_to_date_convert);
                            $staff_exp_in_gems = $diff->format("%y");
                            // echo $staff_exp_in_gems;
                            // die();

                    if($staff_exp_in_gems<=25)
                    {
                        $experience_point = $staff_exp_in_gems;
                    }else{$experience_point=0;}
                    /***/

                    /****Cumulative CSH Points*****/
                        $all_points_array=array($csh_distance_point,$parents_education_point,$parent_involvement_point,$position_in_gems,$child_cap_point,$experience_point);


                        $cumulative_csh_points = array_sum($all_points_array);
                    /*****/

                    /***CA Amount Calculation*****/
                        if($child_data_result['children_age']<=5){$ca_amount=600;}
                        elseif(($child_data_result['children_age']>=6)&&($child_data_result['children_age']<=12)){$ca_amount=700;}
                        elseif(($child_data_result['children_age']>=13)&&($child_data_result['children_age']<=18)){$ca_amount=850;}
                        elseif(($child_data_result['children_age']>=19)&&($child_data_result['children_age']<=25)){$ca_amount=1100;}
                        else{$ca_amount=0;}
                    /**********/

                    /*****CSH Amount calculation****/
                        if($cumulative_csh_points>=75)
                        {
                            if(($result_percentage['education']>=3)&&($result_percentage['education']<=9))
                            {
                                $csh_amount = 600;     
                            }
                            elseif(($result_percentage['education']>=10)&&($result_percentage['education']<=14))
                            {
                                $csh_amount = 900;     
                            }
                            elseif($result_percentage['education']==10)
                            {
                                $csh_amount = 900;     
                            }
                            elseif($result_percentage['education']==15)
                            {
                                $csh_amount = 1200;     
                            }
                            elseif($result_percentage['education']==16)
                            {
                                $csh_amount = 1500;     
                            }
                            else{$csh_amount=0;}
                        }
                        elseif($cumulative_csh_points>=55)
                        {
                            if(($result_percentage['education']>=3)&&($result_percentage['education']<=9))
                            {
                                $csh_amount = 400;     
                            }
                            elseif(($result_percentage['education']>=10)&&($result_percentage['education']<=14))
                            {
                                $csh_amount = 600;     
                            }
                            elseif($result_percentage['education']==10)
                            {
                                $csh_amount = 600;     
                            }
                            elseif($result_percentage['education']==15)
                            {
                                $csh_amount = 800;     
                            }
                            elseif($result_percentage['education']==16)
                            {
                                $csh_amount = 1000;     
                            }
                            else{$csh_amount=0;}
                        }
                        elseif($cumulative_csh_points>=40)
                        {
                            if(($result_percentage['education']>=3)&&($result_percentage['education']<=9))
                            {
                                $csh_amount = 200;     
                            }
                            elseif(($result_percentage['education']>=10)&&($result_percentage['education']<=14))
                            {
                                $csh_amount = 300;     
                            }
                            elseif($result_percentage['education']==10)
                            {
                                $csh_amount = 300;     
                            }
                            elseif($result_percentage['education']==15)
                            {
                                $csh_amount = 400;     
                            }
                            elseif($result_percentage['education']==16)
                            {
                                $csh_amount = 500;     
                            }
                            else{$csh_amount=0;}
                        }
                        else{$csh_amount=0;}
                    /****/

                     /****CER Amount calculation**********/
                        $check_staff_children_getting_allowance=$this->db->query("select * from ".$this->db->dbprefix('allowancedata_master')." where staff_id='".$model->staff_id."' AND is_deleted='0'");
                         $data_exist=$check_staff_children_getting_allowance->result_array();

                         if(count($data_exist)>0)
                         {
                            //check staff and children has same region id
                            $staff_region_id_query=$this->db->query("select * from ".$this->db->dbprefix('staff_master')." where id='".$model->staff_id."'");
                            $staff_region_id=$staff_region_id_query->result_array();
                            $result_region_id = $staff_region_id[0];

                            /****check same region and child medium of instruct is english***/
                            if($result_region_id['region_id']==$child_data_result['region_id'])
                            {
                                if(($result_percentage['education']>=1)&&($result_percentage['education']<=11)){
                                    $cer_amount=300;
                                }
                                elseif(($result_percentage['education']>=12)&&($result_percentage['education']<=14)){
                                    $cer_amount=400;
                                }
                                 elseif(($result_percentage['education']>=14)&&($result_percentage['education']<=16)){
                                    $cer_amount=500;
                                }
                                 elseif($result_percentage['education']==17){
                                    $cer_amount=400;
                                }
                            }
                            else
                            {
                                if(($result_percentage['education']>=1)&&($result_percentage['education']<=11)){
                                    $cer_amount=150;
                                }
                                elseif(($result_percentage['education']>=12)&&($result_percentage['education']<=14)){
                                    $cer_amount=200;
                                }
                                 elseif(($result_percentage['education']>=14)&&($result_percentage['education']<=16)){
                                    $cer_amount=250;
                                }
                                 elseif($result_percentage['education']==17){
                                    $cer_amount=200;
                                }
                            }

                         }else{
                            $cer_amount = 0;
                         }
                    /***/
                 /********/
                  //print_r($cer_amount);die();

                    $child_data_exist_1=$this->db->query("select * from ".$this->db->dbprefix('allowancedata_master')." where child_id='".$child_list_id."'");
                         $child_data_exist_result_1=$child_data_exist_1->result_array(); 
              
                    $data1=array(
                            'staff_id'=>$staff_id,
                            'child_id'=>$child_list_id,
                            'parent_data_id'=>$child_data_exist_result_1[0]['parent_data_id'],
                            'csh_points'=>$cumulative_csh_points,
                            'ca_amount'=>$ca_amount,
                            'cer_amount'=>$cer_amount,
                            'csh_amount'=>$csh_amount,
                            );
                         //print_r($child_data_exist_result[0]['id']);die();

                            $this->db->set('created_at', 'NOW()', FALSE);
                            $this->db->where('id',$child_data_exist_result_1[0]['id']);
                            $this->db->update($this->db->dbprefix('allowancedata_master'),$data1);
               // }
                $response['message']="Parent record has been updated successfully";
           
       }else{
            $response['status']="failure";            
            $response['message']="Invalid Attempt!!.. Access denied..";
       }    
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();

        //print_r($resultdata);die();
    }
    
    public function gems_edit_child_master(){
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";

        $resultdata = json_decode($this->input->post('resultdata',FALSE));
        //var_dump($resultdata->id); die();

       // $id=trim($this->input->post('id',FALSE)); 

        //"{"id":"1","region_id":"2","staff_zone_id":"11","staff_id":"1","cross_ref_no":"6","mks_no":"1","children_name":"vcbcvbxvgdsgd","children_age":"0","education":"","address":"qwdasdasdsadasdsadsadasdas","contact_no":"34234324","date_birth":"10/16/2017","date_salvation":"2010-01-15","date_baptism":"2010-01-15","involvement_ministry":"asdsadsa","gender":"2","age_group":"1","position_family":"12","job_description":"sadsad","marital_status":"3","email_id":"asdasd@gmail.com","spouse_name":"adsada","special_camps_attended":"sadasdsa1","verified_name":"asdasda","verified_designation":"5","ref_no":"1","modified_by":"1"}"

        if($resultdata->id!="" && $resultdata->children_name!=""){
           
            $res_chk=$this->db->query("select id from ".$this->db->dbprefix('staff_children')." where children_name='".$resultdata->children_name."' and id!='".$resultdata->id."' and mks_no='".$resultdata->mks_no."'");
            if($res_chk->num_rows()>0){
                    $response['status']="failure";            
                    $response['message']="Sorry!!, Children name already exists.";
            }else{

            $date_birth=date("Y-m-d", strtotime($resultdata->date_birth));
            $date_salvation=date("Y-m-d", strtotime($resultdata->date_salvation));
            $date_baptism=date("Y-m-d", strtotime($resultdata->date_baptism));


                $data=array('region_id'=>$resultdata->region_id,
                            'staff_zone_id'=>$resultdata->staff_zone_id,
                            'staff_id'=>$resultdata->staff_id,
                            'cross_ref_no'=>$resultdata->ref_no,
                            'mks_no'=>$resultdata->mks_no,
                            'children_name'=>$resultdata->children_name,
                            'address'=>$resultdata->address,
                            'contact_no'=>$resultdata->contact_no,
                            'date_birth'=>$date_birth,
                            'date_salvation'=>$date_salvation,
                            'date_baptism'=>$date_baptism,
                            'gender'=>$resultdata->gender,
                            'age_group'=>$resultdata->age_group,
                            'position_family'=>$resultdata->position_family,
                            'job_description'=>$resultdata->job_description,
                            'marital_status'=>$resultdata->marital_status,
                            'email_id'=>$resultdata->email_id,
                            'spouse_name'=>$resultdata->spouse_name,
                            'special_camps_attended'=>$resultdata->special_camps_attended,
                            'verified_name'=>$resultdata->verified_name,
                            'verified_designation'=>$resultdata->verified_designation,
                            'modified_by'=>$resultdata->modified_by
                            );

                $this->db->set('modified_date', 'NOW()', FALSE);
                $this->db->where('id',$resultdata->id);
                $this->db->update($this->db->dbprefix('staff_children'),$data);
                $response['message']="Children record has been updated successfully";
            }
       }else{
            $response['status']="failure";            
            $response['message']="Invalid Attempt!!.. Access denied..";
       }    
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }

    public function gems_create_childdata_master() {

       $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";

        $model = json_decode($this->input->post('model',FALSE));

        //var_dump($model->sponsor_missionary_remarks); die();


        if($model!=''){
            
                $this->db->query("insert into ".$this->db->dbprefix('childdata_master')." (
                        zone_id,
                        staff_id,
                        child_id,
                        year_of_data,
                        education,
                        name_of_course,
                        name_of_institute,
                        ca_eligiblity,
                        current_address,
                        job_desc,
                        child_photo,
                        cer,
                        ces,
                        percentage_scored,
                        loan_scholar,
                        prayer_request,
                        remarks,
                        created_at,
                        created_by,
                        is_deleted
                            ) values (
                                '".$model->zone_id."',
                                '".$model->staff_id."',
                                '".$model->child_id."',
                                '".$model->year_of_data."',
                                '".$model->education."',
                                '".$model->name_of_course."',
                                '".$model->name_of_institute."',
                                '".$model->ca_eligiblity."',
                                '".$model->current_address."',
                                '".$model->job_desc."',
                                '".$model->child_photo."',
                                '".$model->cer."',
                                '".$model->ces."',
                                '".$model->percentage_scored."',
                                '".$model->loan_scholar."',
                                '".$model->prayer_request."',
                                '".$model->remarks."',
                                NOW(),
                                '".$model->created_by."',
                                '0'
                                )");

                if($this->db->insert_id()){
                    $response['result']=array('id'=>$this->db->insert_id());
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


     public function gems_edit_childdata_master(){
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";

        $resultdata = json_decode($this->input->post('resultdata',FALSE));
        //var_dump($resultdata); die();

        if($resultdata->id!=""){
           
            $res_chk=$this->db->query("select id from ".$this->db->dbprefix('childdata_master')." ");
            if($res_chk->num_rows()>0){

                $data=array('zone_id'=>$resultdata->zone_id,
                            'staff_id'=>$resultdata->staff_id,
                            'child_id'=>$resultdata->child_id,
                            'year_of_data'=>$resultdata->year_of_data,
                            'education'=>$resultdata->education,
                            'name_of_course'=>$resultdata->name_of_course,
                            'name_of_institute'=>$resultdata->name_of_institute,
                            'ca_eligiblity'=>$resultdata->ca_eligiblity,
                            'current_address'=>$resultdata->current_address,
                            'job_desc'=>$resultdata->job_desc,
                            'child_photo'=>$resultdata->child_photo,
                            'cer'=>$resultdata->cer,
                            'ces'=>$resultdata->ces,
                            'percentage_scored'=>$resultdata->percentage_scored,
                            'loan_scholar'=>$resultdata->loan_scholar,
                            'prayer_request'=>$resultdata->prayer_request,
                            'remarks'=>$resultdata->remarks
                            );

                $this->db->where('id',$resultdata->id);
                $this->db->update($this->db->dbprefix('childdata_master'),$data);
                $response['message']="Children record has been updated successfully";
            }
       }else{
            $response['status']="failure";            
            $response['message']="Invalid Attempt!!.. Access denied..";
       }    
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }


     public function gems_delete_child_data_master($id){        
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";


        $res_chk=$this->db->query("select id from ".$this->db->dbprefix('childdata_master')." where id='".$id."' ");
        
        if($res_chk->num_rows()>0){

            $data=array('is_deleted'=>'1');

            $this->db->set('deleted_at', 'NOW()', FALSE);
            $this->db->where('id',$id);
            $this->db->update($this->db->dbprefix('childdata_master'),$data);

            $response['status']="success";
            $response['message']="Children record has been deleted successfully";
            
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";    
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();        
    }

    
    public function gems_delete_child_master($id){
        
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        
        if($id){
            
            $this->db->query("delete from ".$this->db->dbprefix('staff_children')."  where id='".$id."'");
            $response['status']="success";
            $response['message']="Children record has been deleted successfully";
            
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";    
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();        
    }

    public function get_parent_master_list()
    {
        $this->output->set_content_type('application/json');
        $response=array();
        $html="";
         global $api_path;
        $response['status']="success";
        $result=array();
        $res=$this->db->select("*")
            ->order_by('id desc')
            ->where('is_deleted', '0')
            ->get('parent_data_master');
        if($res->num_rows()>0){
            foreach($res->result_array() as $key=>$value){

                 $zone_list=$this->db->query("select * from  ".$this->db->dbprefix('zones_staff_master')." as z  where z.id='".$value['zone_id']."' order by z.id asc");
                 $in_array=$zone_list->result_array();

                 $zone_name=$in_array[0]['staff_zone_name'];

                   $html='<a title="Staff View" style=" margin-top: 10px;" href="'.$api_path.'/#/viewparentata/'.$value['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></a>';

                 $ca_eligiblity_array_list = array('init','No - PremSagar/Ashadeep/Anokha','YES - ORD','NO - Married','NO - Working','Not Eligible');
                 $location = array('init','Urban','Rural');

                 $date=date_create($value['created_at']);
                $result[]=array('id'=>$value['id'], 'action'=>$html, 'zone_id'=>$zone_name,'spouse_name'=>$value['spouse_name'],'ca_eligiblity'=>$ca_eligiblity_array_list[$value['ca_eligiblity']],'location'=>$location[$value['location']],'created_at'=>date_format($date,"d/m/Y"));
            }
        }else{
            $response['status']="failure";
            $response['message']="No Children list found!!..";
        }
        $response['result']=$result;
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }

    public function gems_delete_parent_data_master($id){
        
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";


        $res_chk=$this->db->query("select id from ".$this->db->dbprefix('parent_data_master')." where id='".$id."' ");
        
        if($res_chk->num_rows()>0){

            $data=array('is_deleted'=>'1');

            $this->db->set('created_at', 'NOW()', FALSE);
            $this->db->where('id',$id);
            $this->db->update($this->db->dbprefix('parent_data_master'),$data);

            $data1=array('is_deleted'=>'1');

            $this->db->set('created_at', 'NOW()', FALSE);
            $this->db->where('parent_data_id',$id);
            $this->db->update($this->db->dbprefix('allowancedata_master'),$data1);

            $response['status']="success";
            $response['message']="Parent record has been deleted successfully";
            
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";    
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();        
    }

    public function gems_check_mks_no(){

        $this->output->set_content_type('application/json');
        $response=array();
        $html="";
        $response['status']="success";
        $result=array();
        $res=$this->db->query("select mks_no from  ".$this->db->dbprefix('staff_children')." order by id desc");

        if($res->num_rows()>0){
            $in_array=$res->result_array();

            $in_array=$in_array[0];

            $in_array['mks_no'] = $in_array['mks_no'] +1;

            $result=array( "mks_no" =>$in_array['mks_no']);

        }else{

            $in_array['mks_no'] =1;
            $result=array( "mks_no" =>$in_array['mks_no']);
        }
        $response['result']=$result;
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();

    }


    public function gems_check_emp_id(){

        $this->output->set_content_type('application/json');
        $response=array();
        $html="";
        $response['status']="success";
        $result=array();
        $res=$this->db->query("select staff_employee_id from  ".$this->db->dbprefix('staff_master')." order by id desc");

        if($res->num_rows()>0){
            $in_array=$res->result_array();

            $in_array=$in_array[0];

            if(strlen($in_array['staff_employee_id'])<=4)
            {
                $in_array['staff_employee_id'] = 10001;                
            }
            else
            {
                $in_array['staff_employee_id'] = $in_array['staff_employee_id'] +1;    
            }

            

            $result=array( "staff_employee_id" =>$in_array['staff_employee_id']);

        }else{

            $in_array['staff_employee_id'] =10000;
            $result=array( "staff_employee_id" =>$in_array['staff_employee_id']);
        }
        $response['result']=$result;
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();

    }
    
      
}
