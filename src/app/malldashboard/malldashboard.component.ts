import { Component,OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';
import { AppComponent } from '../app.component';
import { TopnavComponent } from '../topnav/topnav.component';
import { SidemenuComponent } from '../sidemenu/sidemenu.component';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { AppSettings } from '../appSettings';
import { LoginService } from '../services/login.service';
import { CommonService } from '../services/common.service';
import Swal from 'sweetalert2'

declare var jquery:any;
declare var $ :any;
import { Injectable } from '@angular/core';

@Component({
  selector: 'app-malldashboard',
  templateUrl: './malldashboard.component.html',
  styleUrls: ['./malldashboard.component.css']
})



export class MalldashboardComponent implements OnInit {
  currentUser:any;
  currentUserID:any;
  currentUsername:any;
  currentUsergroup:any;
  currentUserStatus:any;
  currentAllUsers:any;
  tamount:any;
  payment_details:any
  packagelist:Array<Object>;
  package_vs_user_list:Array<Object>;
  model: any = {};
  alldata: any = {};
  transferdata: any = {};
  select: any;
  malltypeid:any;
  userwebsiteurl:string=AppSettings.userweburl;
  getpackageinfodetApiUrl:string = AppSettings.getPackageInfo; 
  checkUserRestApiUrl:string = AppSettings.checkuserdetail; 
  checkpackageisactivated:string = AppSettings.packageisactivated; 
  checkUserCreditRestApiUrl:string = AppSettings.checkusercredit;
  inserttrasnfeprocessRestApiUrl:string = AppSettings.inserttransferprocess;
  getpackagevsuserApiUrl:string = AppSettings.getPackageNotbuy;
  insertpackagevsuserApiUrl:string = AppSettings.insertpackagevsuser;

  websiteurl:string=AppSettings.USER_TEMPLATE;
 
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router,private http:Http) { 
      document.body.className="theme-red";

  }

  ngOnInit() {
    this.loginService.malllocalStorageData();
    this.loginService.viewsActivate();
    
    this.malltypeid = localStorage.getItem('malltypeid');    
    // console.log(this.malltypeid)
  }


  logout(){
    this.loginService.logout();
  }

}
