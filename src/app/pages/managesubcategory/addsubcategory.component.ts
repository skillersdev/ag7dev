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
  templateUrl: './addsubcategory.component.html'
})
export class AddsubcategoryComponent implements OnInit {

  currentUser:any;
  currentUserID:any;
  currentUsername:any;
  currentUsergroup:any;
  currentUserStatus:any;
  currentAllUsers:any;
  model: any = {};
  alldata: any = {};
  getcategorylistRestApiUrl:string = AppSettings.getcategoryDetail; 
  insertsubcategoryRestApiUrl:string = AppSettings.Addsubcategory; 
  categorylist:Array<Object>;
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router,private http:Http) { 
      document.body.className="theme-red";

  }

  ngOnInit() {
     this.loginService.localStorageData();
      this.loginService.viewsActivate();
      this.CommonService.getdata(this.getcategorylistRestApiUrl)
        .subscribe(det =>{
            if(det.result!="")
            { 
              this.categorylist=det.result;
            } 
             
        });
  }
  
  logout(){
    this.loginService.logout();
  }
  back(){
    this.router.navigate(['/managesubcategory']);
  }
  addsubcategorylist()
  {
    this.model.created_by=localStorage.getItem('currentUserID');
    this.CommonService.insertdata(this.insertsubcategoryRestApiUrl,this.model)
    .subscribe(package_det =>{       
         swal(
          package_det.status,
          package_det.message,
          package_det.status
        )
        this.router.navigate(['/managesubcategory']); 
    });
  }

}
