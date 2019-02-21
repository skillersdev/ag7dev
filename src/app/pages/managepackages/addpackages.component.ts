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
  selector: 'app-addpackage',
  templateUrl: './addpackages.component.html'
})
export class AddpackageComponent implements OnInit {

  currentUser:any;
  currentUserID:any;
  currentUsername:any;
  currentUsergroup:any;
  currentUserStatus:any;
  currentAllUsers:any;
  insertpackageRestApiUrl: string = AppSettings.Addpackage; 
  model: any = {};
  alldata: any = {};
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router,private http:Http) { 
      document.body.className="theme-red";

  }

  ngOnInit() {
     this.loginService.localStorageData();
      this.loginService.viewsActivate();
  }
  arrayOne(n: number): any[] {
    return Array(n);
  }
  logout(){
    this.loginService.logout();
  }
  back(){
    this.router.navigate(['/managepackages']);
  }
  addpackages()
  {    
    this.CommonService.insertdata(this.insertpackageRestApiUrl,this.model)
    .subscribe(package_det =>{       
        console.log("location",package_det);
        
    });
  }

}
