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

@Component({
  selector: 'app-premiumpackage',
  templateUrl: './premiumpackage.component.html',
  styleUrls: ['./premiumpackage.component.css']
})
export class PremiumpackageComponent implements OnInit {

  constructor(
    private loginService: LoginService,
    private CommonService:CommonService,
    private router: Router,
    private http:Http) { 
      document.body.className="theme-red";

  }

  model:any={};
  premiumlist:Array<Object>;
  ngOnInit() {
    this.loginService.localStorageData();
    this.loginService.viewsActivate();
    this.model.usergroup=localStorage.getItem('currentUsergroup');
    if(this.model.usergroup==2)
    {
      this.loginService.logout();
    }
    this.CommonService.getdata(AppSettings.getpremiumpackagesettings)
    .subscribe(data =>{
        if(data.result!="")  
        { 
          this.premiumlist= data.result;
        } 
         
    });
  }
  navigateAddPremiumPackage()
  {
    
  }

}
