import { Component, OnInit } from '@angular/core';
import { LoginService } from '../../services/login.service';
import { Routes,Router,RouterModule}  from '@angular/router';
import { CommonService} from '../../services/common.service';
import { AppSettings } from '../../appSettings';
import Swal from 'sweetalert2'
declare var $ :any;

@Component({
  selector: 'app-packageinfo',
  templateUrl: './packageinfo.component.html',
  styleUrls: ['./packageinfo.component.css']
})
export class PackageinfoComponent implements OnInit {
  getpackageinfodetApiUrl:string = AppSettings.getPackageInfo; 
  getinfolistRestApiUrl:string = AppSettings.getallPackageInfo; 
  checkUserRestApiUrl:string = AppSettings.checkuserdetail; 
  CheckwebsiteExistsRestApiUrl:string = AppSettings.checkwebsitedetail; 
  packageActivateApiUrl:string = AppSettings.PACKAGE_ACTIVATE;
  packageRenewApiUrl:string = AppSettings.package_renew;
  updatetemplatepackagevsuser:string = AppSettings.updatetemplatepackagevsuser;
  ReactivatepackageRestApiUrl:string = AppSettings.reactivatepackagevsuser;
  websiteurl:any;
  appwebsiteurl:string=AppSettings.WEBSITE_URL;
  DeletepackageRestApiUrl:string = AppSettings.deletePackageDetails;
  InstructorPasswordmodel:any={};

  packagelist:Array<Object>;
  model:any={};
  Rmodel:any={};
  payment_data:any={}; 
  details_array:any=[];
  instructordata:any=[];
  instructorModal:any={};
  deleteDetails:any={};
  payment_details:any=false;
  showButton:Boolean=false;
  renew_payment_details:any=false;
  select:any;
  checkIswebsite:Boolean=false;
  Isinstructormodal:Boolean=false;
  isPaid:Boolean=false;
  package_list_byInstructor:Array<Object>;
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router) { }

  ngOnInit() {
    this.websiteurl=this.appwebsiteurl;
    //this.instructorModal.package_amt = 0;
    this.model.passwordmatch=false;
    this.showButton=false;
    this.loginService.localStorageData();
    this.loginService.viewsActivate();
    this.payment_details=false;
    this.renew_payment_details=true;
    let user_id = localStorage.getItem('currentUserID');
    this.model.usergroup=localStorage.getItem('currentUsergroup');
    if(this.model.usergroup==2)
    {
      this.CommonService.editdata(this.getpackageinfodetApiUrl,user_id)
        .subscribe(resultdata =>{   
          this.packagelist=resultdata.result; 
          this.loginService.viewCommontdataTable('dataTable','packinfo_table');
        });
    }
    else{
      this.CommonService.getdata(this.getinfolistRestApiUrl)
        .subscribe(det =>{
            if(det.result!="")
            { 
              this.packagelist=det.result; 
              this.loginService.viewCommontdataTable('dataTable','packinfo_table');
            } 
             
        });
    }

    this.CommonService.getdata(AppSettings.getPackagebyinstructor)
    .subscribe(resultdata =>{   
      this.package_list_byInstructor=resultdata.result; 
    });    
    this.instructorModal.showVoucherform =false;
        
  }
  getPackagevalue(event:any)
  {
    this.Isinstructormodal = false;
    console.log(event.target.selectedOptions[0].innerHTML);
    if(event.target.value>0){
      this.Isinstructormodal = true;
      this.instructorModal.package_amt = event.target.value;
      this.instructorModal.package_name = event.target.selectedOptions[0].innerHTML;
    }
  }
  pay_via_voucher()
  {
    this.payment_details=true;
    
  }
  pay_via_voucher_renew()
  {
    this.renew_payment_details=false;
  }
  checkUserexist(event:any,modelV:any)
  {
    //console.log(event.target.value);
    this.model.username=event.target.value;
    this.CommonService.checkexistdata(this.checkUserRestApiUrl,this.model)
    .subscribe(package_det =>{

      if(package_det.exist==0)
      {
        swal('','User doesnot exist','error')
        if(modelV==1)
        {
          this.payment_data.username='';
          this.payment_data.password='';
        }else{
          this.instructorModal.username='';
          this.instructorModal.password='';
        }
        
      }  
    });
  }
  onGoToPage2(package_name:any,package_price:any,userid:any,pack_id:any,pack_id_user:any,website:any,template:any,pck_type:any,eusername:any)
  {
    
    this.model.package_name = package_name;
    this.model.package_price = package_price;
    this.payment_data.userid = userid;//user_vs_package user id
    this.payment_data.pack_id =pack_id;//user_vs_pacakge package if
    this.payment_data.pack_id_user=pack_id_user;//user_vs_packeg mastr id
    this.model.website = website;
    this.checkIswebsite=(this.model.website!='')?true:false;
    this.model.template = template;
    this.model.p_id = pack_id_user;
    this.model.pck_type=pck_type;
    this.model.eusername = eusername;
    
    
  }

  updatetemplate()
  {
    this.CommonService.insertdata(this.updatetemplatepackagevsuser,this.model)
    .subscribe(package_det =>{       
      swal('','Template Updated Successfully','success');  
      // this.router.navigate(['./packageinfo']); 
      // this.router.navigate(['/dashboard']);
         
        //  this.ngOnInit();
         $('#ctemplateModal').modal('toggle');
         this.ngOnInit();
        //this.router.navigate(['/dashboard']) ; 
    });
  }

  CancelPayment()
  {
    this.payment_details=false;
    //this.voucher.reset(); 
  }
  checkwebsite()
  {
    this.CommonService.checkexistdata(this.CheckwebsiteExistsRestApiUrl,this.Rmodel)
    .subscribe(package_det =>{
      if(package_det.exist==1)
      {
        swal('',package_det.message,'error')
        this.Rmodel.website='';
      }  
    });
  }
  //code added for checl elearn username exist
  checkelearnuserexist(){
    this.model.pck_type=2;
    this.CommonService.checkexistdata(this.CheckwebsiteExistsRestApiUrl,this.model)
    .subscribe(package_det =>{
      if(package_det.exist==1)
      {
        swal('',package_det.message,'error')
        this.model.eusername='';
      }  
    });

  }
  //code ended here for elearn code exists
  paytoactivate()
  { 
    this.payment_data.website = this.model.website;
    
    //added for e learning code started here
    this.payment_data.pck_type  = this.model.pck_type;
    this.payment_data.eusername = this.model.eusername;
    this.payment_data.epassword = this.model.epassword;
    //code ended here

    this.details_array.push(this.payment_data);
    $('.preloader').show();
    this.isPaid=true;
    //return false;
     this.CommonService.insertdata(this.packageActivateApiUrl,this.details_array)
    .subscribe(payment_status =>{ 
      if(payment_status.status=='success')
      {
        swal('','Package activated successfully','success');
        this.payment_data='';
        this.model='';
        this.isPaid=false;
         $('#exampleModal').modal('toggle');
          let user_id = localStorage.getItem('currentUserID');
          this.CommonService.editdata(this.getpackageinfodetApiUrl,user_id)
              .subscribe(resultdata =>{   
                this.packagelist=resultdata.result; 
              });
              $('.preloader').hide();
              
              this.showButton=false;
            }
      else if(payment_status.status=='user_error'){
        swal('','Not a valid user or invalid user data','error');  
        this.isPaid=false;
        this.payment_data.username='';
        this.payment_data.password='';      
        //this.payment_data='';
        //this.model='';
         //this.isPaid=true;
        $('.preloader').hide();
      }
      else if(payment_status.status=='fail'){
        swal('','user has less amount on his own','error');
        this.isPaid=false;
        this.payment_data.username='';
        this.payment_data.password='';
        $('.preloader').hide();
       // this.payment_data='';  
        //this.model='';
      }
      else{
        swal('','Error while on activate package','error');
        $('.preloader').hide();
       // this.payment_data=''; 
        //this.model='';
      }
     
    });
  }
  paytorenew()
  {
    this.payment_data.website = this.model.website;
    this.details_array.push(this.payment_data);
     this.CommonService.insertdata(this.packageRenewApiUrl,this.details_array)
    .subscribe(payment_status =>{ 
      if(payment_status.status=='success')
      {
        swal('','Package Renewed successfully','success');
        this.payment_data='';
        this.model='';
         $('#renewModal').modal('toggle');
          let user_id = localStorage.getItem('currentUserID');
          this.CommonService.editdata(this.getpackageinfodetApiUrl,user_id)
              .subscribe(resultdata =>{   
                this.packagelist=resultdata.result; 
              });
            }
      else if(payment_status.status=='user_error'){
        swal('','Not a valid user or invalid user data','error');        
        //this.payment_data='';
        //this.model='';
      }
      else if(payment_status.status=='Failed'){
        swal('','user has less amount on his own','error');
       // this.payment_data=''; 
        //this.model='';
      }
      else if(payment_status.status=='website_exists')
        {
          swal('',payment_status.message,'error');  
        } 
      else{
        //  onsole.log(payment_status.status,"test");
        swal('','Error while on activate package','error');
       // this.payment_data=''; 
        //this.model='';
      }
     
    });
  }
  deletepackagedetails(id:any,website:any)
  {
    this.deleteDetails.package_id= id;
    this.deleteDetails.website= website;
      console.log(this.deleteDetails)
    let idx = id;
      let self = this;
      swal({
        title: 'Are you sure?',
         buttons: {
            cancel: true,
            confirm: true,
          },
        text: "You won't be able to revert this!",
      }).then(function (result) {
        if(result)
        {
          self.removeuser();
          swal(
            'Deleted!',
            'User Data has been deleted.',
            'success'
          );
        }
      },function(dismiss) {
      
    });
  }

 removeuser()
 {
   this.CommonService.updatedata(this.DeletepackageRestApiUrl,this.deleteDetails)
        .subscribe(resultdata =>{
         this.ngOnInit();
      });
 }
 activateweb()
 {
   this.Rmodel.user_id = localStorage.getItem('currentUserID');
     this.CommonService.updatedata(this.ReactivatepackageRestApiUrl,this.Rmodel)
        .subscribe(resultdata =>{
         swal('','Package Renewed successfully','success');
        this.payment_data='';
        this.Rmodel='';
         $('#exampleModalExists').modal('toggle');
          let user_id = localStorage.getItem('currentUserID');
          this.CommonService.editdata(this.getpackageinfodetApiUrl,user_id)
              .subscribe(resultdata =>{   
                this.packagelist=resultdata.result; 
              });
      });
 }
 openInstructorModal(packagePrice:any,elaernuser:any,package_id:any,pack_id_user:any,pack_type:any)
 {
   $('#InstructorModal').modal('show');
   //this.instructorModal.package_amt = packagePrice;
   //this.instructorModal.package_amt = 0;
   this.instructorModal.elaernuser = elaernuser;
   this.instructorModal.pack_id = package_id;
   this.instructorModal.pack_id_user=pack_id_user;//user_vs_packeg mastr id
   this.instructorModal.pck_type = pack_type;
 }
 activateInstructor()
 {   
    this.instructorModal.user_id = localStorage.getItem('currentUserID');
    this.instructordata.push(this.instructorModal);
    this.CommonService.updatedata(AppSettings.activateInstructorApi,this.instructordata)
      .subscribe(resultdata =>{
        if(resultdata.status==1)
        {
          swal('',resultdata.message,'success');          
        }else{
          swal('',resultdata.message,'error');
        }
        this.ngOnInit();
        $('#InstructorModal').modal('hide');
    });
 }
 activateVoucher()
 {
  this.instructorModal.showVoucherform =true;
 }

 updatePassword()
 {
  this.CommonService.insertdata(AppSettings.Updateelearnuserpassword,this.InstructorPasswordmodel)
  .subscribe(resultdata =>{
    if(resultdata.status=='success')
    {
      swal('',resultdata.message,'success');          
    }else{
      swal('',resultdata.message,'error');
    }
    this.ngOnInit();
   $('#changePassword').modal('hide');
  });
 }
 openChangepasswordmodal(elearnuserid:any)
 {
    this.InstructorPasswordmodel.elearnuserid = elearnuserid;
    $('#changePassword').modal('show');
 }
 passwordMatch()
   {
     this.model.passwordmatch=false;
     if((this.InstructorPasswordmodel.cpassword!='')&&(this.InstructorPasswordmodel.password!=''))
     {
       if(this.InstructorPasswordmodel.cpassword!=this.InstructorPasswordmodel.password)
       {
         this.model.passwordmatch = true;

       }
     }
   }
}
