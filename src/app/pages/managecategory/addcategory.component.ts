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
  templateUrl: './addcategory.component.html'
})
export class AddcategoryComponent implements OnInit {

  currentUser:any;
  currentUserID:any;
  currentUsername:any;
  currentUsergroup:any;
  currentUserStatus:any;
  currentAllUsers:any;
  model: any = {};
  select: any;
  alldata: any = {};
  websitelist:Array<Object>;
  insertcategoryRestApiUrl: string = AppSettings.Addcategory; 
  getwebsiteRestApiUrl:string = AppSettings.getwebsitelist; 
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
  addcategorylist()
  {
    this.model.created_by=localStorage.getItem('currentUserID');
    this.CommonService.insertdata(this.insertcategoryRestApiUrl,this.model)
    .subscribe(package_det =>{       
         swal(
          package_det.status,
          package_det.message,
          package_det.status
        )
        this.router.navigate(['/managecategory']); 
    });
  }
  back(){
    this.router.navigate(['/managecategory']);
  }

}
