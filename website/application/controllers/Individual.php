<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Individual extends CI_Controller {

	
	public function index()
	{
		$user_det=$this->db->select("*")->where(['is_deleted'=>'0'])->get('affiliateuser'); 
        $data =$user_det->result_array();


        for($i=0;$i<=count($data);$i++)
        {
        	$group_det=$this->db->select("*")->where(['is_deleted'=>'0'])->get('group_master'); 
        	$group_data =$group_det->result_array();
        	for($j=0;$j<=count($group_data);$j++)
	        {
	        	if(($group_data[$j]['group_name']!=$data[$i]['username'])||($group_data[$j]['private_public']!=4))
	        	{
	        		$length=10;
		            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		            $charactersLength = strlen($characters);
		            $randomString = '';
		            for ($k = 0; $k < $length; $k++) {
		                $randomString .= $characters[rand(0, $charactersLength - 1)];
		            }
		             date_default_timezone_set('Asia/Kolkata');        
        			$doc = date("Y-m-d H:i:s");

	        		 $this->db->query("insert into ".$this->db->dbprefix('group_master')." 
	        				(group_name,channelgroup,imagename,private_public,group_code,created_by,created_date,is_deleted) values('".$data[$i]['username']."',2,'default-profile.png',4,'".$randomString."',1,'". $doc."',0)");
	        	}
	        }

        }
	}
}
