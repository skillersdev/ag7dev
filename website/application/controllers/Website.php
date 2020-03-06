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
						'total_views'=>$value['total_views'],'total_likes'=>$value['total_likes'],'long_desc'=>str_replace("\n","",$value['long_desc']),'short_desc'=>str_replace("\n","",$value['short_desc']));
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

			$myvideos_result=[];
			$video_det=$this->db->select("*")->where(['website_name'=>$websitename,'is_deleted'=>'0'])->order_by('id','desc')->get('video_sections'); 
			$myvideos_result =$video_det->result_array();


			$contac_log_result=[];
			$contact_log_det=$this->db->select("*")->where(['contact_id'=>isset($contac_result[0]['id'])?$contac_result[0]['id']:0])->order_by('id','desc')->get('contact_image_log'); 
			$contac_log_result =$contact_log_det->result_array();


			$album_result=[];
			$album_det=$this->db->select("*")->where(['website'=>$websitename,'is_deleted'=>'0'])->order_by('id','desc')->get('album_master'); 
			$album_result =$album_det->result_array();


			/*******Section And Section Item Query************/

			$Getsection=$this->db->query("select * from ".$this->db->dbprefix('manage_section')." where website='".$websitename."' OR website='default' AND Issection_show=0 ORDER BY section_order ASC"); 
			$section_result_array =$Getsection->result_array();
			//echo "<pre>";print_r($section_result_array);die;
			if(count($section_result_array)>0)
			{
				$section_result=[];

				foreach($section_result_array as $key=>$value)
		          {
					//$section_result['section_name']=$value['section_name'];

					$Getsection_item=$this->db->select("*")->where(['section'=>$value['id'],'is_deleted'=>'0'])->order_by('id','desc')->get('manage_section_item');
					$Getsection_item_result_array =$Getsection_item->result_array();

					foreach($Getsection_item_result_array as $key_item=>$item_value)
		          	{
						$section_result[$value['section_name']][$key_item]['section_name'] = $value['section_name'];
						$section_result[$value['section_name']][$key_item]['section_item_id'] = $item_value['id'];
						$section_result[$value['section_name']][$key_item]['media_type'] = $item_value['media_type'];
						$section_result[$value['section_name']][$key_item]['title'] = $item_value['title'];
						$section_result[$value['section_name']][$key_item]['description'] = $item_value['description'];
						$section_result[$value['section_name']][$key_item]['file_name'] = $item_value['file_name'];
						$section_result[$value['section_name']][$key_item]['attachment_desc'] = $item_value['attachment_desc'];
						$section_result[$value['section_name']][$key_item]['preview_file'] = $item_value['preview_file'];
						$section_result[$value['section_name']][$key_item]['likes'] = $item_value['total_likes'];
						$section_result[$value['section_name']][$key_item]['views'] = $item_value['total_views'];
					}
				}
			}
			/****************************/
			/**My channel and group****/
				$channel_list=$this->db->select("*")->where(['created_by'=>$val[0]['user_id'],'channelgroup'=>1,'showinwebsite'=>1,'is_deleted'=>'0'])->get('group_master'); 
				$channel_list_query =$channel_list->result_array();
				$channel_array = array();
				foreach ($channel_list_query as $key => $value) {
					$channel_array[$key]['group_name'] = $value['group_name'];
					$channel_array[$key]['imagename'] = "group_images/".$value['imagename'];
					$channel_array[$key]['group_code'] = $value['group_code'];

					$mem_channel_list=$this->db->select("id")->where(['group_id'=>$value['id']])->get('group_members'); 
					$mem_channel_list_query =$mem_channel_list->result_array();
					$channel_array[$key]['count_mem'] = count($mem_channel_list_query);
					// print_r(count($mem_channel_list_query)); die;		
				}

				$group_list=$this->db->select("*")->where(['created_by'=>$val[0]['user_id'],'channelgroup'=>2,'showinwebsite'=>1,'is_deleted'=>'0'])->get('group_master'); 
				$group_list_query =$group_list->result_array();
				$group_array = array();
				foreach ($group_list_query as $key => $value) {
					$group_array[$key]['group_name'] = $value['group_name'];
					$group_array[$key]['imagename'] = "group_images/".$value['imagename'];
					$group_array[$key]['group_code'] = $value['group_code'];

					$mem_group_list=$this->db->select("id")->where(['group_id'=>$value['id']])->get('group_members'); 
					$mem_group_list_query =$mem_group_list->result_array();
					$group_array[$key]['count_mem'] = count($mem_group_list_query);
					// print_r(count($mem_channel_list_query)); die;		
				}
	

			/****************/

			$data['channel_array']=$channel_array;
			$data['group_array']=$group_array;
			$data['all_details'] = $section_result;
			$data['album_details'] = $album_result;
			$data['product_details']=$result;
			// print_r($contac_result); die;
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
			$data['websitename']=$websitename;
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
			$this->load->view('template1',$data);	
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
				$check_service_view_log=$this->db->query("select * from ".$this->db->dbprefix('user_views_log')." where type_id='".$_POST['id']."' AND date(created_date)='".$today."' AND ip_address='".$ip_address."' AND type='serviceview' ");

				if($check_service_view_log->num_rows()==0)
				{
					$this->db->query("insert into ".$this->db->dbprefix('user_views_log')." 
                    (type_id,ip_address,type) values('".$_POST['id']."','".$ip_address."','serviceview')");


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

				$check_service_like_log=$this->db->query("select * from ".$this->db->dbprefix('user_views_log')." where type_id='".$_POST['id']."' AND date(created_date)='".$today."' AND ip_address='".$ip_address."' AND type='servicelike' ");

				if($check_service_like_log->num_rows()==0)
				{
					$this->db->query("insert into ".$this->db->dbprefix('user_views_log')." 
                    (type_id,ip_address,type) values('".$_POST['id']."','".$ip_address."','servicelike')");


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

	public function updatesectionitemlike()
	{
		$res_chk=$this->db->query("select * from ".$this->db->dbprefix('manage_section_item')." where id='".$_POST['id']."' ");	
			//print_r($res_chk->num_rows());die;
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
	
	
	public function addwebsitefollow()
	{
		//$model = json_decode($this->input->post('model',FALSE));
		if(isset($_POST['websitename'])){
		  $response['exist']=0;
	      $website = $_POST['websitename'];
	      $datastype = $_POST['datastype'];
	      $res=$this->db->select("website")->where(['website'=>$website])->get('user_vs_packages')->result_array();

	      if(count($res)>0)
	      {  
				
			 $follow=$res['total_follows']+1;		
			 $data=array('total_follows'=>$follow);
			 $this->db->where('website',$website);
			 $this->db->update($this->db->dbprefix('user_vs_packages'),$data);
			 $response['totalfollow']=$follow;
	       
	      }
	      echo json_encode($response,JSON_UNESCAPED_SLASHES);
	      die();
		}else{
			 $response['totalfollow']=0;
			 echo json_encode($response,JSON_UNESCAPED_SLASHES);
	      die();
		}
	      
	}
	
	
}
