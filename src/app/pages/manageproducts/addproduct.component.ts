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
  templateUrl: './addproduct.component.html'
})
export class AddproductComponent implements OnInit {

  currentUser:any;
  currentUserID:any;
  currentUsername:any;
  currentUsergroup:any;
  currentUserStatus:any;
  currentAllUsers:any;
  getcategorylistRestApiUrl:string = AppSettings.getcategoryDetail; 
  getsubcategorylistRestApiUrl:string = AppSettings.getsubcategoryDetail; 
  getwebsiteRestApiUrl:string = AppSettings.getwebsitelist; 
  getsubcategoryRestApiUrl:string = AppSettings.getsubcategorybyid;
  insertproductRestApiUrl :string = AppSettings.addproduct;
  categorylist:Array<Object>;
  subcategorylist:Array<Object>;
  websitelist:Array<Object>;
  product_det:Array<Object>;
  model: any = {};
  alldata: any = {};
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router,private http:Http) { 
      document.body.className="theme-red";

  }

  ngOnInit() {
     this.loginService.localStorageData();
      this.loginService.viewsActivate();
      /*category list*/
      this.CommonService.getdata(this.getcategorylistRestApiUrl)
        .subscribe(det =>{
            if(det.result!=""){ this.categorylist=det.result;}
        });
        this.CommonService.getdata(this.getsubcategorylistRestApiUrl)
        .subscribe(det =>{
            if(det.result!=""){ this.subcategorylist=det.result;}
        });
        this.alldata.usertype=localStorage.getItem('currentUsergroup');
        this.alldata.userid=localStorage.getItem('currentUserID');
      
         this.CommonService.insertdata(this.getwebsiteRestApiUrl,this.alldata)
        .subscribe(package_det =>{       
          if(package_det.result!=""){ this.websitelist=package_det.result;}
        }); 


  
  }

  addproduct()
  {
     this.CommonService.insertdata(this.insertproductRestApiUrl,this.model)
    .subscribe(package_det =>{       
         swal(
          package_det.status,
          package_det.message,
          package_det.status
        )
        this.router.navigate(['/manageproducts']); 
    }); 
  }
  logout(){
    this.loginService.logout();
  }

  back(){
    this.router.navigate(['/manageproducts']);
  }

}
