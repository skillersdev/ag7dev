import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';

import { AppComponent } from '../../app.component';

import { TopnavComponent } from '../../topnav/topnav.component';
import { SidemenuComponent } from '../../sidemenu/sidemenu.component';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { AppSettings } from '../../appSettings';
import { LoginService } from '../../services/login.service';

import { CommonService } from '../../services/common.service';
declare var jquery:any;
declare var $ :any;
import { Injectable } from '@angular/core';

@Component({
  selector: 'app-manageuser',
  templateUrl: './addservice.component.html'
})
export class AddserviceComponent implements OnInit {

  currentUser:any;
  currentUserID:any;
  currentUsername:any;
  currentUsergroup:any;
  currentUserStatus:any;
  currentAllUsers:any;

  websitelist:Array<Object>;

  getwebsiteRestApiUrl:string = AppSettings.getwebsitelist; 
  insertserviceRestApiUrl:string = AppSettings.insertservice;
  model: any = {};
  alldata: any = {};
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router,private http:Http) { 
      document.body.className="theme-red";

  }

  ngOnInit() {
     this.loginService.localStorageData();
      this.loginService.viewsActivate();
       this.alldata.usertype=localStorage.getItem('currentUsergroup');
        this.alldata.userid=localStorage.getItem('currentUserID');
      
         this.CommonService.insertdata(this.getwebsiteRestApiUrl,this.alldata)
        .subscribe(package_det =>{       
          if(package_det.result!=""){ this.websitelist=package_det.result;}
        }); 
  }
  
  logout(){
    this.loginService.logout();
  }

  back(){
    this.router.navigate(['/manageservices']);
  }
  add_service(){
    this.CommonService.insertdata(this.insertserviceRestApiUrl,this.model)
    .subscribe(service_det =>{       
         swal(
          service_det.status,
          service_det.message,
          service_det.status
        )
        this.router.navigate(['/manageservices']); 
    });
  }

}
