<?php
ini_set('display_errors', 1);
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_controller extends CI_Controller {

	public function index() {
		$this->output->set_content_type('application/json');
		die(json_encode(array('status'=>"failure", 'error'=>'UN-Authorized access'), JSON_UNESCAPED_SLASHES));
	}

   public function addproduct(){
        $this->output->set_content_type('application/json');
      
        $response=array('status'=>"success",'message'=>"Product Inserted successfully");

        $model = json_decode($this->input->post('model',FALSE));

        /*Check Product code already exist or not*/

        $dup_res=$this->db->query("select * from ".$this->db->dbprefix('product_master')." where sku='".$model->sku."'");
        $duplicate_array=$dup_res->result_array();
        /*End*/
     
        if(count($duplicate_array)==0)
        {
          
          $variationItem = $attributeItem=[];
          
          if(isset($model->variation_list)){
            $variationItem = $model->variation_list;
            unset($model->variation_list);
          }

          if(isset($model->attribute_list)){
            $attributeItem = $model->attribute_list;
            unset($model->attribute_list);
          }
        
          $this->db->insert('product_master', $model);

          $productId = $this->db->insert_id();
          
          if(count($attributeItem)>0){
           
            foreach($attributeItem as $key=>$value)
            {      
              $this->db->query("insert into ".$this->db->dbprefix('product_settings')." (product_id,attribute_name,attribute_value) values ('".$productId."','".$attributeItem[$key]->name."','".$attributeItem[$key]->value."')");
            } 
          }
        
          if(count($variationItem)>0){
            
            foreach($variationItem as $key=>$value)
            {      
              $this->db->query("insert into ".$this->db->dbprefix('product_settings')." (product_id,variation_name,variation_value) values ('".$productId."','".$variationItem[$key]->name."','".$variationItem[$key]->value."')");
            } 
          }
        }else{
          $response['status']="failure";
          $response['message']="Product SKU is already existed..";
        }
        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
    
     public function uploadproductimage()
    {
       $path = 'product_image/';
        $Response=[];
     
        if (isset($_FILES['file'])) 
          {
            $originalName = $_FILES['file']['name'];
            $ext = '.'.pathinfo($originalName, PATHINFO_EXTENSION);
             
            if($ext==".img"||$ext==".jpg"||$ext==".jpeg"||$ext==".png")
            {

              $generatedName = md5($_FILES['file']['tmp_name']).$ext;

              $filePath = $path.$generatedName;
              $product_image=$filePath;
           
              if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) 
              {
                $Response['status']="success"; 
                $Response['data']=$product_image;
              }
            }
            else 
            {
                $Response['status']="fail"; 
                $Response['data']="Upload only valid format images";
            }
          }
        else {
            $Response['status']="fail"; 
            $Response['data']="Error While upload on image";
         }
          echo json_encode($Response,JSON_UNESCAPED_SLASHES);
         die();
    }
  
  public function productlist()
  {
     $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=array();
        $html="";
        global $api_path;        

        $res=$this->db->select("*,DATE_FORMAT(created_date,'%d/%m/%Y')as cdate")->where('is_deleted','0')->get('product_master');


        if($res->num_rows()>0)
        {
          foreach($res->result_array() as $key=>$value)
          {               

            $cat_sql=$this->db->query("select category_name from ".$this->db->dbprefix('category_master')." where id='".$value['category_id']."'");
            $cat_array=$cat_sql->result_array(); 
            $package['category_name'] = $cat_array[0]['category_name'];

            //  $sub_cat_sql=$this->db->query("select sub_category_name from ".$this->db->dbprefix('category_master')." where id='".$value['sub_category_id']."'");
            // $sub_cat_array=$sub_cat_sql->result_array(); 
            // $package['sub_category_name'] = $sub_cat_array[0]['sub_category_name'];

            $result[]=array('id'=>$value['id'],'product_name'=>$value['product_name'],'price'=>$value['price'],'currency'=>$value['currency'],'category_name'=>$package['category_name'],'website'=>$value['website'],'created_date'=>$value['cdate']);
          }
        }else{
            $response['status']="failure";
            $response['message']="No User records found..";
        }
        $response['result']=$result;
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    

  }
  
  public function productlistbyweb()
  {
    $this->output->set_content_type('application/json');
      
        //$response=array('status'=>"success",'message'=>"Product Inserted successfully");

        $this->output->set_content_type('application/json');
      
        //$response=array('status'=>"success",'message'=>"Package Inserted successfully");

        $model = json_decode($this->input->post('model',FALSE));

        $filtered_array = array_filter($model->weblist); 

        $response=array();

        $result = "'" . implode ( "', '", $filtered_array ) . "'";
        $fn_res =explode(",",$result);
        //print_r (explode(" ,",$result));

        
        $string = implode('OR website LIKE ', $fn_res);
        
         $res=$this->db->query("select * from ".$this->db->dbprefix('product_master')." where is_deleted=0  AND (website LIKE {$string})");
		  //$res=$this->db->query("select * from ".$this->db->dbprefix('product_master')." where website = {$string} AND is_deleted=0");//added by sridhar
         $in_array=$res->result_array();
         // print_r("select * from ".$this->db->dbprefix('product_master')." where is_deleted=0  AND (website LIKE {$string})");die;
         $response['result']=$in_array;
          if($res->num_rows()>0)
        {
          foreach($res->result_array() as $key=>$value)
          {               

            $cat_sql=$this->db->query("select category_name from ".$this->db->dbprefix('category_master')." where id='".$value['category_id']."'");
            $cat_array=$cat_sql->result_array(); 
            $response['category_name'][] = $cat_array[0]['category_name'];
          }
        }

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
         // print_r($in_array);die;

       
  }
   public function editproduct($id)
    {
        //var_dump($id); die();
        $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        $result=$setting_attribute_array=$setting_variations_array=array();

        $res=$this->db->query("select * from ".$this->db->dbprefix('product_master')." where id='".$id."'");

        if($res->num_rows()>0){
            $in_array=$res->result_array();
            $result=$in_array[0];
            /*Attribute Items*/
            $setting_attr_res=$this->db->query("select id,attribute_name as name,attribute_value as value from ".$this->db->dbprefix('product_settings')." where product_id='".$id."' AND attribute_name!='' AND attribute_value!='' " );
            if($setting_attr_res->num_rows()>0){
              $setting_attribute_array=$setting_attr_res->result_array();              
            }

            /*Variations Items*/
            $setting_variations_res=$this->db->query("select id,variation_name as name,variation_value as value from ".$this->db->dbprefix('product_settings')." where product_id='".$id."' AND variation_name!='' AND variation_value!='' ");
            if($setting_variations_res->num_rows()>0){
              $setting_variations_array=$setting_variations_res->result_array();              
            }
         
        }else{
            $response['status']="failure";
            $response['message']=" No Package record found!!";
        }
        $response['result']=$result;
        $response['attribute_response']=$setting_attribute_array;
        $response['variations_response']=$setting_variations_array;

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        die();
    }
  public function updateproduct() {
        $this->output->set_content_type('application/json');
        $response=array('status'=>"success");

        $model = json_decode($this->input->post('model',FALSE));


        if (isset($model)) {
        
              $result=$this->db->query("update ".$this->db->dbprefix('product_master')." set sku='".$model->sku."',product_name='".$model->product_name."',price='".$model->price."',currency='".$model->currency."',category_id='".$model->category_id."',sub_category_id='".$model->sub_category_id."',website='".$model->website."',product_image='".$model->product_image."',long_desc='".$model->long_desc."',short_desc='".$model->short_desc."' where id='".$model->id."'");

            /*Update Product settings*/
            $attributeItem = isset($model->attribute_list)?$model->attribute_list:[];
            $variationItem = isset($model->variation_list)?$model->variation_list:[];
            $productId = $model->id;
            if((count($attributeItem)>0) ||(count($variationItem)>0)) {
              $this -> db -> where('product_id', $model->id);
              $this -> db -> delete('product_settings');
            }


              if(count($attributeItem)>0){

                foreach($attributeItem as $key=>$value)
                {      
                  $this->db->query("insert into ".$this->db->dbprefix('product_settings')." (product_id,attribute_name,attribute_value) values ('".$productId."','".$attributeItem[$key]->name."','".$attributeItem[$key]->value."')");
                } 
              }
    
              if(count($variationItem)>0){
                foreach($variationItem as $key=>$value)
                {      
                  $this->db->query("insert into ".$this->db->dbprefix('product_settings')." (product_id,variation_name,variation_value) values ('".$productId."','".$variationItem[$key]->name."','".$variationItem[$key]->value."')");
                } 
              }

              /*END*/
            if ($result) {
                $response['message']="Product has been updated successfully";
            }
            else
            {
                 $response['status']="failure";
            $response['message']="Product has not been updated fully";
            }
            

        } else {
            $response['status']="failure";
            $response['message']="Choose Product and continue!!..";
        }

        die(json_encode($response, JSON_UNESCAPED_SLASHES));
    }
    public function deleteproduct($id)
    {
      $this->output->set_content_type('application/json');
        $response=array();
        $response['status']="success";
        

        $res_chk=$this->db->query("select id from ".$this->db->dbprefix('product_master')." where id='".$id."' ");
        //print_r($res_chk);die;
        if($res_chk->num_rows()>0){

            $data=array('is_deleted'=>'1');
            $this->db->where('id',$id);
            $this->db->update($this->db->dbprefix('product_master'),$data);

            $response['status']="success";
            $response['message']="product record has been deleted successfully";
            
        }else{
            $response['status']="failure";
            $response['message']="Invalid Attempt!!.. Access denied..";    
        }
         echo json_encode($response,JSON_UNESCAPED_SLASHES);
         die();
    }

}
