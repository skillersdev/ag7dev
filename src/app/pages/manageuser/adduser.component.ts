import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';

import { AppComponent } from '../../app.component';

import { TopnavComponent } from '../../topnav/topnav.component';
import { SidemenuComponent } from '../../sidemenu/sidemenu.component';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { AppSettings } from '../../appSettings';
import { LoginService } from '../../services/login.service';
import { CommonService} from '../../services/common.service';
declare var jquery:any;
declare var $ :any;
import { Injectable } from '@angular/core';
import { Settings } from 'http2';

@Component({
  selector: 'app-manageuser',
  templateUrl: './adduser.component.html'
})
export class AdduserComponent implements OnInit {

  currentUser:any;
  currentUserID:any;
  currentUsername:any;
  currentUsergroup:any;
  currentUserStatus:any;
  currentAllUsers:any;
  model: any = {};
  alldata: any = {};
  AddUserRestApiUrl:string = AppSettings.Adduser; 
  constructor(private loginService: LoginService,private CommonService:CommonService,private router: Router,private http:Http) { 
      document.body.className="theme-red";

  }

  ngOnInit() {
     this.loginService.localStorageData();
      this.loginService.viewsActivate();
  }
  
  logout(){
    this.loginService.logout();
  }

  back(){
    this.router.navigate(['/manageuser']);
  }
  adduser()
  {
    this.CommonService.insertdata(this.AddUserRestApiUrl,this.model)
    .subscribe(package_det =>{       
         swal(
          package_det.status,
          package_det.message,
          package_det.status
        )
        this.router.navigate(['/manageuser']); 
    });
  }

}
