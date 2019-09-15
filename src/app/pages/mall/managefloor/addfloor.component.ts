import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';

import { AppComponent } from '../../../app.component';

import { TopnavComponent } from '../../../topnav/topnav.component';
import { SidemenuComponent } from '../../../sidemenu/sidemenu.component';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { AppSettings } from '../../../appSettings';
import { LoginService } from '../../../services/login.service';
import { CommonService } from '../../../services/common.service';
declare var jquery:any;
declare var $ :any; 
import { Injectable } from '@angular/core';  

@Component({
  selector: 'app-addfloor',
  templateUrl: './addfloor.component.html'
})
export class AddfloorComponent implements OnInit {
  malllist:Array<Object>;
  model: any = {};
  malltypeid:any;
  select:any;
  insertfloorRestApiUrl: string = AppSettings.Addfloor; 
  getmalllistRestApiUrl:string = AppSettings.getmallDetail;  
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router,private http:Http) { 
      document.body.className="theme-red";

  }

  ngOnInit() {
    // this.loginService.malllocalStorageData();
    
    this.malltypeid = localStorage.getItem('malltypeid');
    this.model.usergroup=localStorage.getItem('currentUsergroup');  
    if(this.malltypeid==null){
      this.model.created_by=localStorage.getItem('currentUserID');
      this.model.owner_id=localStorage.getItem('currentUserID');     
    } else{      
      this.loginService.malllocalStorageData();  
     this.model.mall_id = localStorage.getItem('mallid'); 
      this.CommonService.insertdata(AppSettings.useridbymallid,this.model)
      .subscribe(package_det =>{       
        this.model.owner_id=package_det.created_by;
      });
     this.model.created_by = localStorage.getItem('mallcurrentUser');
     
    }
      this.loginService.viewsActivate();
      this.getmalllists();
  }
  getmalllists(){
    // this.CommonService.getdata(this.getmalllistRestApiUrl)
    this.CommonService.insertdata(this.getmalllistRestApiUrl,this.model)
        .subscribe(det =>{
            if(det.result!="")
            { 
              this.malllist=det.result;
            } 
             
        });
  }
  logout(){
    this.loginService.logout();
  }
  addfloorlist()
  {
    
    this.CommonService.insertdata(this.insertfloorRestApiUrl,this.model)
    .subscribe(package_det =>{       
         swal(
          package_det.status,
          package_det.message,
          package_det.status
        )
        this.router.navigate(['/mall/managefloor']); 
    });
  }
  back(){
    this.router.navigate(['/mall/managefloor']);
  }

}
