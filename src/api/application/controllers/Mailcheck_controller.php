<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mailcheck_controller extends CI_Controller {


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

				//$to_list = array('welfare@gemsbihar.org', 'srd@gemsbihar.org', 'finance@gemsbihar.org');

				$to_list = array('sabarish834@gmail.com, mohan.morkel7@gmail.com');


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
				        	$message_info="Dear All,
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
						$this->email->from('mohan.morkel7@gmail.com');
						$this->email->to($to_list);
						$this->email->subject('Staff Transfer Information');
						$this->email->message($message_info);
						try{
						//$this->email->send();

						var_dump($this->email->send()); die();
						//echo 'Message has been sent.';

						$response['message']="Staff transfer record has been updated successfully";


						}catch(Exception $e){
						//echo $e->getMessage();
						}
					}
					else
					{
						var_dump("Something Wrong!!!!"); die();
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


}
?>