<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Website extends CI_Controller {

	
	public function index($websitename)
	{
		// $template=1;
		
		$data=[];
		if(isset($websitename))
		{
			$res=$this->db->select("*")->where(['website'=>$websitename])->get('user_vs_packages');
			$val=$res->result_array();
			
// print_r($val); die;
			if($val){

			
			$user_profile=$this->db->select("*")->like('id',$val[0]['user_id'])->where(['is_deleted'=>'0'])->get('affiliateuser'); 
			$user_profile_result =$user_profile->result_array();
			/*Product list*/
			$product_det=$this->db->select("*")->like('website',$websitename)->where(['is_deleted'=>'0'])->get('product_master'); 
			$product_det_result =$product_det->result_array();
			$result=[];
			if(count($product_det_result)>0)
			{	

				foreach($product_det_result as $key=>$value)
		          {              
		            
		            $result[]=array('id'=>$value['id'],'product_name'=>$value['product_name'],'website'=>$value['website'],'price'=>$value['price'],'product_image'=>$value['product_image']);
		          }

			}
			/*Services list*/
			$service_det=$this->db->select("*")->like('website',$websitename)->where(['is_deleted'=>'0'])->get('services'); 
			$service_det_result =$service_det->result_array();
			$serv_result=[];
			if(count($service_det_result)>0)
			{	

				foreach($service_det_result as $key=>$value)
		          {              
		            
		            $serv_result[]=array('id'=>$value['id'],'service_image'=>$value['service_image'],'service_name'=>$value['title'],'desc'=>$value['description']);
		          }

			}

			/*Adver*/
			/*Services list*/
			$ad_det=$this->db->select("*")->like('url',$websitename)->where(['is_deleted'=>'0'])->get('user_advertisements'); 
			$ad_det_result =$ad_det->result_array();
			$ads_result=[];
			if(count($ad_det_result)>0)
			{	

				foreach($ad_det_result as $key=>$value)
		          {              
		            
		            $ads_result[]=array('id'=>$value['id'],'uploads'=>$value['uploads'],'ad_type'=>$value['ad_type']);
		          }

			}


			/*Contact list*/
			$contact_det=$this->db->select("*")->like('website',$websitename)->where(['is_deleted'=>'0'])->get('contacts_master'); 
			$contact_det_result =$contact_det->result_array();
			$contac_result=[];
			if(count($contact_det_result)>0)
			{	

				foreach($contact_det_result as $key=>$value)
		          { 
		            $contac_result[]=array('id'=>$value['id'],'fb'=>$value['fb_link'],'linked'=>$value['linked_url']);
		          }

			}
			// print_r($contac_result); die;
			$data['product_details']=$result;
			$data['service_details']=$serv_result;
			$data['contact_details']=$contac_result;
			$data['ad_details'] = $ads_result;
			$data['profile_image']=$user_profile_result[0]['image_url'];
			$data['address']=$user_profile_result[0]['address'];
			$data['about_me']=$user_profile_result[0]['about_me'];
			$data['mobile']=$user_profile_result[0]['mobile'];
			$data['mail']=$user_profile_result[0]['email'];
			$data['website']=$val[0]['website'];
			//echo "<pre>";print_r($data);die;

			$this->load->helper('url');
			if($val[0]['template']==1){
				$this->load->view('template1',$data);	
			}
			if($val[0]['template']==2){
				$this->load->view('template2',$data);	
			}
			if($val[0]['template']==3){
				$this->load->view('template3',$data);	
			}
			if($val[0]['template']==4){
				$this->load->view('template4',$data);	
			}
			if($val[0]['template']==5){
				$this->load->view('template5',$data);	
			}
		} else{
			// $data['exist']=0;
		}
		}
		else
		{
			$this->load->view('template1');	
		}
		
		
	}
}
