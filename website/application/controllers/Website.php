<?php
//echo "die";die;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

defined('BASEPATH') OR exit('No direct script access allowed');

class Website extends CI_Controller {

	
	public function index($websitename)
	{
		
		$data=[];
		if(isset($websitename))
		{
			/*************For Slider Image*/

			$res=$this->db->select("*")->where(['website'=>$websitename])->get('user_vs_packages');
			$val=$res->result_array();

			$slider_image_res=$this->db->select("slider_image")->where(['website'=>$websitename])->get('template_settings');
			$image_array=$slider_image_res->result_array();

			/*****End****/

			/******For Contact section******/
			$contac_result=[];
			$contact_det=$this->db->select("*,fb_link as fb,linked_url as linked")->where(['website'=>$websitename,'is_deleted'=>'0'])->order_by('id','desc')->get('contacts_master'); 
			$contac_result =$contact_det->result_array();
			/***************************/


			$contac_log_result=[];
			$contact_log_det=$this->db->select("*")->where(['contact_id'=>isset($contac_result[0]['id'])?$contac_result[0]['id']:0])->order_by('id','desc')->get('contact_image_log'); 
			$contac_log_result =$contact_log_det->result_array();



			$service_det=$this->db->select("*")->where(['website'=>$websitename,'is_deleted'=>'0'])->order_by('id','desc')->get('services'); 
			$service_det_result =$service_det->result_array();
			$serv_result=[];

			if(count($service_det_result)>0)
			{	

				foreach($service_det_result as $key=>$value)
		          {              
					$file_ext = substr($value['service_image'], -3);
					if(($file_ext=='mp4')||($file_ext=='AVI')||($file_ext=='MPEG')||($file_ext=='WMv'))
					{
						$type="1";//video
					}
					else{
						$type="0";
					}
		            $serv_result[]=array('id'=>$value['id'],'service_image'=>$value['service_image'],'service_name'=>$value['title'],'desc'=>$value['description'],'weblink'=>$value['weblink'],'views'=>isset($value['total_views'])?$value['total_views']:'0','likes'=>isset($value['total_likes'])?$value['total_likes']:'0','type'=>$type);
		          }

			}

			/*******Section And Section Item Query************/

			$Getsection=$this->db->query("select * from ".$this->db->dbprefix('manage_section')." where website='".$websitename."' OR website='default' AND Issection_show=0 "); 
			$section_result_array =$Getsection->result_array();
			//echo "<pre>";print_r($section_result_array);die;
			if(count($section_result_array)>0)
			{
				$result=[];

				foreach($section_result_array as $key=>$value)
		          {
					//$result['section_name']=$value['section_name'];

					$Getsection_item=$this->db->select("*")->where(['section'=>$value['id'],'is_deleted'=>'0'])->order_by('id','desc')->get('manage_section_item');
					$Getsection_item_result_array =$Getsection_item->result_array();

					// echo "<pre>";print_r($Getsection_item_result_array);die;

					foreach($Getsection_item_result_array as $key_item=>$item_value)
		          	{
						$result[$value['section_name']][$key_item]['section_name'] = $value['section_name'];
						$result[$value['section_name']][$key_item]['section_item_id'] = $item_value['id'];
						$result[$value['section_name']][$key_item]['media_type'] = $item_value['media_type'];
						$result[$value['section_name']][$key_item]['title'] = $item_value['title'];
						$result[$value['section_name']][$key_item]['description'] = $item_value['description'];
						$result[$value['section_name']][$key_item]['file_name'] = $item_value['file_name'];
						$result[$value['section_name']][$key_item]['attachment_desc'] = $item_value['attachment_desc'];
						$result[$value['section_name']][$key_item]['preview_file'] = $item_value['preview_file'];
						$result[$value['section_name']][$key_item]['likes'] = $item_value['total_likes'];
						$result[$value['section_name']][$key_item]['views'] = $item_value['total_views'];
					}
				}
			}
			/****************************/


			
			$data['all_details'] = $result;
			$data['slider_image']=$image_array;
			$data['contact_details']=$contac_result;
			$data['contac_log_result']=$contac_log_result;
			$data['service_details']=$serv_result;
			/*
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
			$data['myvideo_det']=$myvideos_result;
			$data['slider_image']=$image_array;
			//echo "<pre>";print_r($data);die;
			*/

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
		} 
		else
		{
			$this->load->view('template1');	
		}
		
		
	}
	public function updatesectionitemlike()
	{
		$res_chk=$this->db->query("select * from ".$this->db->dbprefix('manage_section_item')." where id='".$_POST['id']."' ");	

		 if($res_chk->num_rows()>0)
        {
        	$section_item_det = $res_chk->result_array();
        	$today =date("Y-m-d");
			$ip_address = $_SERVER['REMOTE_ADDR'];

			if($_POST['field']=='like')
			{
				$check_product_log=$this->db->query("select * from ".$this->db->dbprefix('user_views_log')." where type_id='".$_POST['id']."' AND date(created_date)='".$today."' AND ip_address='".$ip_address."' AND type='".$_POST['section']."' ");
				/*Only once per user view count added per day*/
				if($check_product_log->num_rows()==0)
				{
					$this->db->query("insert into ".$this->db->dbprefix('user_views_log')." 
                    (type_id,ip_address,type) values('".$_POST['id']."','".$ip_address."','".$_POST['section']."')");
					
					   $data=array('total_likes'=>$section_item_det[0]['total_likes']+1);
		            $this->db->where('id',$_POST['id']);
		            $this->db->update($this->db->dbprefix('manage_section_item'),$data);
		             $value =  array('total_likes' =>$data['total_likes'] );

		             echo json_encode($value);
		           // return $data['total_likes'];
		            die;
	            }

	          
			}
		}
	}
	public function updateviews()
	{
		$res_chk=$this->db->query("select * from ".$this->db->dbprefix('manage_section_item')." where id='".$_POST['id']."' ");	

		 if($res_chk->num_rows()>0)
        {
        	$section_item_det = $res_chk->result_array();
        	$today =date("Y-m-d");
			$ip_address = $_SERVER['REMOTE_ADDR'];

			if($_POST['field']=='view')
			{
				$check_product_log=$this->db->query("select * from ".$this->db->dbprefix('user_views_log')." where type_id='".$_POST['id']."' AND date(created_date)='".$today."' AND ip_address='".$ip_address."' AND type='".$_POST['section']."' ");
				/*Only once per user view count added per day*/
				if($check_product_log->num_rows()==0)
				{
					$this->db->query("insert into ".$this->db->dbprefix('user_views_log')." 
                    (type_id,ip_address,type) values('".$_POST['id']."','".$ip_address."','".$_POST['section']."')");
					
					   $data=array('total_views'=>$section_item_det[0]['total_views']+1);
		            $this->db->where('id',$_POST['id']);
		            $this->db->update($this->db->dbprefix('manage_section_item'),$data);
		             $value =  array('total_views' =>$data['total_views'] );

		             echo json_encode($value);
		           // return $data['total_likes'];
		            die;
	            }

	          
			}
			
		}
	}


	public function updateproductmaster()
	{
		$res_chk=$this->db->query("select * from ".$this->db->dbprefix('product_master')." where id='".$_POST['id']."' ");
        
        if($res_chk->num_rows()>0)
        {
        	$prod_det = $res_chk->result_array();
        	$today =date("Y-m-d");
			$ip_address = $_SERVER['REMOTE_ADDR'];

			if($_POST['field']=='view')
			{
				$check_product_log=$this->db->query("select * from ".$this->db->dbprefix('user_views_log')." where type_id='".$_POST['id']."' AND date(created_date)='".$today."' AND ip_address='".$ip_address."' AND type='productview' ");

				if($check_product_log->num_rows()==0)
				{
					$this->db->query("insert into ".$this->db->dbprefix('user_views_log')." 
                    (type_id,ip_address,type) values('".$_POST['id']."','".$ip_address."','productview')");
					$data=array('total_views'=>$prod_det[0]['total_views']+1);
		            $this->db->where('id',$_POST['id']);
		            $this->db->update($this->db->dbprefix('product_master'),$data);
		             $value =  array('total_views' =>$data['total_views'] );

		             echo json_encode($value);
		           // return $data['total_likes'];
		            die;
	            }
	          
			}
			elseif($_POST['field']=='like')
			{
				$check_product_like_log=$this->db->query("select * from ".$this->db->dbprefix('user_views_log')." where type_id='".$_POST['id']."' AND date(created_date)='".$today."' AND ip_address='".$ip_address."' AND type='productlike' ");

				if($check_product_like_log->num_rows()==0)
				{
					$this->db->query("insert into ".$this->db->dbprefix('user_views_log')." 
                    (type_id,ip_address,type) values('".$_POST['id']."','".$ip_address."','productlike')");
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
	}

	public function updateservicemaster()
	{
		$res_chk=$this->db->query("select * from ".$this->db->dbprefix('services')." where id='".$_POST['id']."' ");
        
        if($res_chk->num_rows()>0)
        {
        	$prod_det = $res_chk->result_array();
        	$today =date("Y-m-d");
			$ip_address = $_SERVER['REMOTE_ADDR'];

			if($_POST['field']=='view')
			{
				$check_service_view_log=$this->db->query("select * from ".$this->db->dbprefix('user_views_log')." where type_id='".$_POST['id']."' AND date(created_date)='".$today."' AND ip_address='".$ip_address."' AND type='".$_POST['section']."' ");

				if($check_service_view_log->num_rows()==0)
				{
					$this->db->query("insert into ".$this->db->dbprefix('user_views_log')." 
                    (type_id,ip_address,type) values('".$_POST['id']."','".$ip_address."','".$_POST['section']."')");


					$data=array('total_views'=>$prod_det[0]['total_views']+1);
		            $this->db->where('id',$_POST['id']);
		            $this->db->update($this->db->dbprefix('services'),$data);
		             $value =  array('total_views' =>$data['total_views'] );

		             echo json_encode($value);
		           // return $data['total_likes'];
		            die;
		        }
	          
			}
			elseif($_POST['field']=='like')
			{

				$check_service_like_log=$this->db->query("select * from ".$this->db->dbprefix('user_views_log')." where type_id='".$_POST['id']."' AND date(created_date)='".$today."' AND ip_address='".$ip_address."' AND type='".$_POST['section']."' ");

				if($check_service_like_log->num_rows()==0)
				{
					$this->db->query("insert into ".$this->db->dbprefix('user_views_log')." 
                    (type_id,ip_address,type) values('".$_POST['id']."','".$ip_address."','".$_POST['section']."')");


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
	}

	public function updateadmaster()
	{
		$res_chk=$this->db->query("select * from ".$this->db->dbprefix('user_advertisements')." where id='".$_POST['id']."' ");
        
        if($res_chk->num_rows()>0)
        {
        	$prod_det = $res_chk->result_array();
        	$today =date("Y-m-d");
			$ip_address = $_SERVER['REMOTE_ADDR'];

			if($_POST['field']=='view')
			{
				$check_service_like_log=$this->db->query("select * from ".$this->db->dbprefix('user_views_log')." where type_id='".$_POST['id']."' AND date(created_date)='".$today."' AND ip_address='".$ip_address."' AND type='adview' ");

				if($check_service_like_log->num_rows()==0)
				{
					$this->db->query("insert into ".$this->db->dbprefix('user_views_log')." 
                    (type_id,ip_address,type) values('".$_POST['id']."','".$ip_address."','adview')");



					$data=array('total_views'=>$prod_det[0]['total_views']+1);
		            $this->db->where('id',$_POST['id']);
		            $this->db->update($this->db->dbprefix('user_advertisements'),$data);
		             $value =  array('total_views' =>$data['total_views'] );

		             echo json_encode($value);
		           // return $data['total_likes'];
		            die;
		        }
	          
			}
			elseif($_POST['field']=='like')
			{
				$check_service_like_log=$this->db->query("select * from ".$this->db->dbprefix('user_views_log')." where type_id='".$_POST['id']."' AND date(created_date)='".$today."' AND ip_address='".$ip_address."' AND type='adlike' ");

				if($check_service_like_log->num_rows()==0)
				{
					$this->db->query("insert into ".$this->db->dbprefix('user_views_log')." 
                    (type_id,ip_address,type) values('".$_POST['id']."','".$ip_address."','adlike')");

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
