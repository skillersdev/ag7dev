import { Component, OnInit } from '@angular/core';
import { LoginService } from '../../services/login.service';
import { Routes,Router,RouterModule}  from '@angular/router';
import { CommonService} from '../../services/common.service';
import { AppSettings } from '../../appSettings';
declare var $ :any;

@Component({
  selector: 'app-packageinfo',
  templateUrl: './packageinfo.component.html',
  styleUrls: ['./packageinfo.component.css']
})
export class PackageinfoComponent implements OnInit {
  getpackageinfodetApiUrl:string = AppSettings.getPackageInfo; 
  checkUserRestApiUrl:string = AppSettings.checkuserdetail; 
  CheckwebsiteExistsRestApiUrl:string = AppSettings.checkwebsitedetail; 
  packageActivateApiUrl:string = AppSettings.PACKAGE_ACTIVATE;
  packagelist:Array<Object>;
  model:any={};
  payment_data:any={}; 
  details_array:any=[];
  payment_details:any=false;

  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router) { }

  ngOnInit() {
    this.loginService.localStorageData();
    this.loginService.viewsActivate();
    this.payment_details=false;
    let user_id = localStorage.getItem('currentUserID');
    this.CommonService.editdata(this.getpackageinfodetApiUrl,user_id)
        .subscribe(resultdata =>{   
          this.packagelist=resultdata.result; 
        });
        
  }
  pay_via_voucher()
  {
    this.payment_details=true;
  }
  checkUserexist(event:any)
  {
    //console.log(event.target.value);
    this.model.username=event.target.value;
    this.CommonService.checkexistdata(this.checkUserRestApiUrl,this.model)
    .subscribe(package_det =>{

      if(package_det.exist==0)
      {
        swal('','User doesnot exist','error')
      }  
    });
  }
  onGoToPage2(package_name:any,package_price:any,userid:any,pack_id:any,pack_id_user:any)
  {
    this.model.package_name = package_name;
    this.model.package_price = package_price;
    this.payment_data.userid = userid;//user_vs_package user id
    this.payment_data.pack_id =pack_id;//user_vs_pacakge package if
    this.payment_data.pack_id_user=pack_id_user;//user_vs_packeg mastr id
  }
  CancelPayment()
  {
    this.payment_details=false;
    //this.voucher.reset(); 
  }
  checkwebsite()
  {
    this.CommonService.checkexistdata(this.CheckwebsiteExistsRestApiUrl,this.model)
    .subscribe(package_det =>{
      if(package_det.exist==1)
      {
        swal('',package_det.message,'error')
        this.model.website='';
      }  
    });
  }
  paytoactivate()
  { 
    this.payment_data.website = this.model.website;
    this.details_array.push(this.payment_data);
     this.CommonService.insertdata(this.packageActivateApiUrl,this.details_array)
    .subscribe(payment_status =>{ 
      if(payment_status.status=='success')
      {
        swal('','Package activated successfully','success');
        this.payment_data='';
        this.model='';
      }
      else if(payment_status.status=='user_error'){
        swal('','Not a valid user or invalid user data','error');        
        //this.payment_data='';
        //this.model='';
      }
      else if(payment_status.status=='fail'){
        swal('','user has less amount on his own','error');
       // this.payment_data=''; 
        //this.model='';
      }
      else{
        swal('','Error while on activate package','error');
       // this.payment_data=''; 
        //this.model='';
      }
     
    });
  }
}
