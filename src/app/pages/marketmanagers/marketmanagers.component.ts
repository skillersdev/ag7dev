import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';

import { LoginService } from '../../services/login.service';

import { CommonService } from '../../services/common.service';
import { AppSettings } from '../../appSettings';

@Component({
  selector: 'app-marketmanagers',
  templateUrl: './marketmanagers.component.html',
  styleUrls: ['./marketmanagers.component.css']
})
export class MarketmanagersComponent implements OnInit {
 getmarketerslistRestApiUrl:string = AppSettings.getMarketerslistDetail; 
 model:any={};
 userlist:Array<Object>;
 websiteurl:string=AppSettings.USER_TEMPLATE;
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router) { }

  ngOnInit() {
    this.loginService.localStorageData();
     this.loginService.viewsActivate();
     this.model.currentUsername=localStorage.getItem('currentUser');
      this.CommonService.insertdata(this.getmarketerslistRestApiUrl,this.model)
    .subscribe(package_det =>{ 
        this.userlist = package_det;
        //  swal(
        //   package_det.status,
        //   package_det.message,
        //   package_det.status
        // )
        //this.router.navigate(['/manageads']); 
    });
  }
  redirectWebsite()
  {
    window.open("http://roodabatoz.com/newsite/marketerpage/","_blank");
  }

}
