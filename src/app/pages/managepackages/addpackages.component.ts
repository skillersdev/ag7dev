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
  stage_of_packages:Array<Object>;
  stage_bonus_data:Array<Object>;
  stage_upgradation_data:Array<Object>;
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router,private http:Http) { 
      document.body.className="theme-red";

  }

  ngOnInit() {
     this.loginService.localStorageData();
      this.loginService.viewsActivate();
      this.stage_of_packages=[]; 
      this.stage_upgradation_data=[];this.stage_bonus_data=[];
      for (var _i = 0; _i < 100; _i++) {
        this.stage_of_packages.push({'id':_i,'stage_bonus_amount':0,'stage_upgradation_amount':0});
      }
  }
  
  logout(){
    this.loginService.logout();
  }
  back(){
    this.router.navigate(['/managepackages']);
  }
  addpackages()
  {
    this.stage_of_packages.filter((data:any,id:any) =>{    
      // if((data.stage_upgradation_amount!='')&&(data.stage_bonus_amount!=''))
      // {   
        this.stage_bonus_data.push({'id':id,'stage_bonus_amount':data.stage_bonus_amount});
        this.stage_upgradation_data.push({'id':id,'stage_upgradation_amount':data.stage_upgradation_amount});
      // }
    }); 
    this.model.stage_bonus_amount = JSON.stringify(this.stage_bonus_data);
    this.model.stage_upgradation_amount = JSON.stringify(this.stage_upgradation_data);
    this.CommonService.insertdata(this.insertpackageRestApiUrl,this.model)
    .subscribe(package_det =>{       
         swal(
          package_det.status,
          package_det.message,
          package_det.status
        )
        this.router.navigate(['/managepackages']); 
    });
  }

}
