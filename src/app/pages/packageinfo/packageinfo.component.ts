import { Component, OnInit } from '@angular/core';
import { LoginService } from '../../services/login.service';
import { Routes,Router,RouterModule}  from '@angular/router';
import { CommonService} from '../../services/common.service';
import { AppSettings } from '../../appSettings';

@Component({
  selector: 'app-packageinfo',
  templateUrl: './packageinfo.component.html',
  styleUrls: ['./packageinfo.component.css']
})
export class PackageinfoComponent implements OnInit {
  getpackageinfodetApiUrl:string = AppSettings.getPackageInfo; 
  checkUserRestApiUrl:string = AppSettings.checkuserdetail; 
  packagelist:Array<Object>;
  model:any={}; 
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
  onGoToPage2(package_name:any,package_price:any)
  {
    this.model.package_name = package_name;
    this.model.package_price = package_price;
  }

}
