<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Website extends CI_Controller {

	
	public function index($websitename)
	{
		
		$data=[];
		if(isset($websitename))
		{
			$res=$this->db->select("*")->where(['website'=>$websitename])->get('user_vs_packages');
			$val=$res->result_array();
			if($val){

			
			$user_profile=$this->db->select("*")->where(['id'=>$val[0]['user_id'],'is_deleted'=>'0'])->order_by('id','desc')->get('affiliateuser'); 
			$user_profile_result =$user_profile->result_array();
			/*Product list*/
			$product_det=$this->db->select("*")->where(['website'=>$websitename,'is_deleted'=>'0'])->order_by('id','desc')->get('product_master'); 
			$product_det_result =$product_det->result_array();

			$slider_image_res=$this->db->select("slider_image")->where(['website'=>$websitename])->get('template_settings');
			$image_array=$slider_image_res->result_array();
			
		//echo "<pre>";print_r($product_det_result); exit;
			$result=[];
			if(count($product_det_result)>0)
			{	
				$category_name=$sub_category_name='';

				foreach($product_det_result as $key=>$value)
		          {   
					//   print_r($value); die;
					$category_det=$this->db->select("category_name")->where(['id'=>$value['category_id']])->get('category_master'); 
					$category_det_result =$category_det->result_array();
					if($category_det_result){
						$category_name = $category_det_result[0]['category_name'];
					}

					$sub_category_det=$this->db->select("sub_category_name")->where(['id'=>$value['sub_category_id']])->get('sub_category_master'); 
					$sub_category_det_result =$sub_category_det->result_array();
					if($sub_category_det_result){
						$sub_category_name = $sub_category_det_result[0]['sub_category_name'];
					}
					
					$result[]=array('id'=>$value['id'],'product_name'=>$value['product_name'],'category_name'=>$category_name,'sub_category_name'=>$sub_category_name,'website'=>$value['website'],'currency'=>$value['currency'],'price'=>$value['price'],'product_image'=>$value['product_image'],
						'total_views'=>$value['total_views'],'total_likes'=>$value['total_likes'],'desc'=>$value['desc'],'short_desc'=>$value['short_desc']);
		          }

			}
			/*Services list*/
			$service_det=$this->db->select("*")->where(['website'=>$websitename,'is_deleted'=>'0'])->order_by('id','desc')->get('services'); 
			$service_det_result =$service_det->result_array();
			$serv_result=[];
			if(count($service_det_result)>0)
			{	

				foreach($service_det_result as $key=>$value)
		          {              
		            
		            $serv_result[]=array('id'=>$value['id'],'service_image'=>$value['service_image'],'service_name'=>$value['title'],'desc'=>$value['description'],'weblink'=>$value['weblink'],'views'=>$value['total_views'],'likes'=>$value['total_likes']);
		          }

			}

			/*Adver*/
			/*Services list*/
			$ad_det=$this->db->select("*")->where(['url'=>$websitename,'is_deleted'=>'0'])->order_by('id','desc')->get('user_advertisements'); 
			$ad_det_result =$ad_det->result_array();
			$ads_result=[];
			if(count($ad_det_result)>0)
			{	

				foreach($ad_det_result as $key=>$value)
		          {              
		            
		            $ads_result[]=array('id'=>$value['id'],'uploads'=>$value['uploads'],'ad_type'=>$value['ad_type'],'desc'=>$value['desc'],'weblink'=>$value['weblink'],'views'=>$value['total_views'],'likes'=>$value['total_likes']);
		          }

			}


			/*Contact list*/
			$contac_result=[];
			$contact_det=$this->db->select("*,fb_link as fb,linked_url as linked")->where(['website'=>$websitename,'is_deleted'=>'0'])->order_by('id','desc')->get('contacts_master'); 
			$contac_result =$contact_det->result_array();


			$contac_log_result=[];
			$contact_log_det=$this->db->select("*")->where(['contact_id'=>$contac_result[0]['id']])->order_by('id','desc')->get('contact_image_log'); 
			$contac_log_result =$contact_log_det->result_array();
			
			// if(count($contact_det_result)>0)
			// {	

			// 	foreach($contact_det_result as $key=>$value)
		    //       { 
		    //         $contac_result[]=array('id'=>$value['id'],'fb'=>$value['fb_link'],'linked'=>$value['linked_url']);
		    //       }

			// }
			// print_r($contac_result); die;
			$data['product_details']=$result;
			$data['service_details']=$serv_result;
			$data['contact_details']=$contac_result;
			$data['contac_log_result']=$contac_log_result;
			$data['ad_details'] = $ads_result;
			$data['profile_image']=$user_profile_result[0]['image_url'];
			$data['address']=$user_profile_result[0]['address'];
			$data['about_me']=$user_profile_result[0]['about_me'];
			$data['mobile']=$user_profile_result[0]['mobile'];
			$data['mail']=$user_profile_result[0]['email'];
			$data['website']=$val[0]['website'];
			$data['slider_image']=$image_array;
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

	public function updateproductmaster()
	{
		$res_chk=$this->db->query("select * from ".$this->db->dbprefix('product_master')." where id='".$_POST['id']."' ");
        
        if($res_chk->num_rows()>0)
        {
        	$prod_det = $res_chk->result_array();

			if($_POST['field']=='view')
			{
				$data=array('total_views'=>$prod_det[0]['total_views']+1);
	            $this->db->where('id',$_POST['id']);
	            $this->db->update($this->db->dbprefix('product_master'),$data);
	             $value =  array('total_views' =>$data['total_views'] );

	             echo json_encode($value);
	           // return $data['total_likes'];
	            die;
	          
			}
			elseif($_POST['field']=='like')
			{
				$data=array('total_likes'=>$prod_det[0]['total_likes']+1);
	            $this->db->where('id',$_POST['id']);
	            $this->db->update($this->db->dbprefix('product_master'),$data);
	            $value =  array('total_likes' =>$data['total_likes'] );

	             echo json_encode($value);
	           // return $data['total_likes'];
	            die;
			}
		}
	}

	public function updateservicemaster()
	{
		$res_chk=$this->db->query("select * from ".$this->db->dbprefix('services')." where id='".$_POST['id']."' ");
        
        if($res_chk->num_rows()>0)
        {
        	$prod_det = $res_chk->result_array();

			if($_POST['field']=='view')
			{
				$data=array('total_views'=>$prod_det[0]['total_views']+1);
	            $this->db->where('id',$_POST['id']);
	            $this->db->update($this->db->dbprefix('services'),$data);
	             $value =  array('total_views' =>$data['total_views'] );

	             echo json_encode($value);
	           // return $data['total_likes'];
	            die;
	          
			}
			elseif($_POST['field']=='like')
			{
				$data=array('total_likes'=>$prod_det[0]['total_likes']+1);
	            $this->db->where('id',$_POST['id']);
	            $this->db->update($this->db->dbprefix('services'),$data);
	            $value =  array('total_likes' =>$data['total_likes'] );

	             echo json_encode($value);
	           // return $data['total_likes'];
	            die;
			}
		}
	}

	public function updateadmaster()
	{
		$res_chk=$this->db->query("select * from ".$this->db->dbprefix('user_advertisements')." where id='".$_POST['id']."' ");
        
        if($res_chk->num_rows()>0)
        {
        	$prod_det = $res_chk->result_array();

			if($_POST['field']=='view')
			{
				$data=array('total_views'=>$prod_det[0]['total_views']+1);
	            $this->db->where('id',$_POST['id']);
	            $this->db->update($this->db->dbprefix('user_advertisements'),$data);
	             $value =  array('total_views' =>$data['total_views'] );

	             echo json_encode($value);
	           // return $data['total_likes'];
	            die;
	          
			}
			elseif($_POST['field']=='like')
			{
				$data=array('total_likes'=>$prod_det[0]['total_likes']+1);
	            $this->db->where('id',$_POST['id']);
	            $this->db->update($this->db->dbprefix('user_advertisements'),$data);
	            $value =  array('total_likes' =>$data['total_likes'] );

	             echo json_encode($value);
	           // return $data['total_likes'];
	            die;
			}
		}
		
	}

	public function findwebsite()
	{
		//$model = json_decode($this->input->post('model',FALSE));

	      $response['exist']=0;
	      $website = $_POST['value'];
	      
	      $res=$this->db->select("website")->where(['website'=>$website])->get('user_vs_packages');

	      if(count($res->result_array())>0)
	      {         
	        $response['exist']=1;
	        $response['message']="website already exists";
	      }
	      echo json_encode($response,JSON_UNESCAPED_SLASHES);
	      die();
	}
}
