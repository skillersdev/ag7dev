<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery extends CI_Controller {

	
	public function index($albumcode)
	{
		$album_det=$this->db->query("select * from ".$this->db->dbprefix('album_master')." where album_code='".$albumcode."' ");

		$album_details = $album_det->result_array();
		$data=[];

		  $res=$this->db->select("*")->where(['album_id'=>$album_details[0]['id'],'is_deleted'=>'0'])->get('album_photos');
 
          $gallery_det_result =$res->result_array();
		  $gallery_details=[];
	      if(count($gallery_det_result)>0)
	      {         
	       foreach($gallery_det_result as $key=>$value)
	          {              
	            
		    if($value['photos']){
			    $filedata=pathinfo($value['photos']);
			 $gallery_details[]=array('id'=>$value['id'],'photos'=>$value['photos'],'album'=>$album_details[0]['albumname'],'website'=>$album_details[0]['website'],'filetype'=>$filedata['extension']);
		    }else{
			 $gallery_details[]=array('id'=>$value['id'],'photos'=>$value['photos'],'album'=>$album_details[0]['albumname'],'website'=>$album_details[0]['website'],'filetype'=>'');   
		    }
	           
	          }

	      }
	      //echo "<pre>";
	      //print_r($gallery_details);die;
	      $data['gallery_details']=$gallery_details;
	      $this->load->helper('url');
	      $this->load->view('gallery1',$data);
		
	}

	
}
