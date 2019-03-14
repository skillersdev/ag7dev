import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';

import { LoginService } from '../../services/login.service';
import { CommonService } from '../../services/common.service';
import { AppSettings } from '../../appSettings';

@Component({
  selector: 'app-accountinfo',
  templateUrl: './accountinfo.component.html',
  styleUrls: ['./accountinfo.component.css']
})
export class AccountinfoComponent implements OnInit {
  getpaymentinfodetApiUrl:string = AppSettings.getpaymentdet; 
  paymentlist:Array<Object>;
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router) { }

  ngOnInit() {
    this.loginService.localStorageData();
     this.loginService.viewsActivate();
      let user_id = localStorage.getItem('currentUserID');
      this.CommonService.editdata(this.getpaymentinfodetApiUrl,user_id)
          .subscribe(resultdata =>{   
            this.paymentlist=resultdata.result; 
          });
  }

}
