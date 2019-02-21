<?php

class Upload_controller extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->helper(array('form', 'url'));
        }

        public function index()
        {
                $this->output->set_content_type('application/json')
                ->set_output(json_encode(array('error' => 'UN-Authorized access'),JSON_UNESCAPED_SLASHES)); 
                die(); 
        }

        public function single_upload()
        {
               $targetPath = "upload/single";
       
       if($_FILES){    

                 $filename = $_FILES['file']['name'];   
                 $tmp = explode('.', $filename);
                 $extension=end($tmp);
                 $newfilename=rand().date('Y_m_d_h_i_s') .".".$extension;
                 $temp_path=$targetPath."/";
                 $destination =$temp_path.$newfilename;         
                 if(move_uploaded_file( $_FILES['file']['tmp_name'] , $destination )){
                      // return $destination;
                      echo $destination;
                      die;
                 }
            }
        }


        public function multiple_upload()
        {
            $targetPath = "upload/multiple";
          
            if($_FILES){    

                $filename = $_FILES['Filedata']['name'];   
                $tmp = explode('.', $filename);
                $extension=end($tmp);
                $newfilename=rand().date('Y_m_d_h_i_s') .".".$extension;
                $temp_path=$targetPath."/";
                $destination =$temp_path.$newfilename;         
                if(move_uploaded_file( $_FILES['Filedata']['tmp_name'] , $destination )){
                    // return $destination;
                    echo $destination;
                    die;
                }
            }
        }
}

