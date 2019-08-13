import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule,ActivatedRoute}  from '@angular/router';

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
  selector: 'app-editmall',
  templateUrl: './editmall.component.html'
})
export class EditmallComponent implements OnInit {

  
  private sub: any;
  model: any = {};
  id:number;
  insertmallRestApiUrl: string = AppSettings.Addmall; 
  FetchmallRestApiUrl: string = AppSettings.editmall; 
  updatemallRestApiUrl: string = AppSettings.updatemall;
  getwebsiteRestApiUrl:string = AppSettings.getwebsitelist;  
  constructor(private loginService: LoginService,private CommonService: CommonService,private route: ActivatedRoute,private router: Router,private http:Http) { 
      document.body.className="theme-red";

  }

  ngOnInit() {
     this.loginService.localStorageData();
      this.loginService.viewsActivate();
      
      this.sub = this.route.params.subscribe(params => {
        this.id = +params['id']; // (+) converts string 'id' to a number
        this.editmall(this.id);        
        });
  }
  
  logout(){
    this.loginService.logout();
  }
  
  editmall(id:any)
  {
    this.CommonService.editdata(this.FetchmallRestApiUrl,id)
        .subscribe(resultdata =>{   
          this.model = resultdata.result;         
        });
  }
  updatemalllist()
  {
     //this.model.is_deleted=1
     this.CommonService.updatedata(this.updatemallRestApiUrl,this.model)
    .subscribe(package_det =>{       
         swal(
          package_det.status,
          package_det.message,
          package_det.status
        )
         this.router.navigate(['/mall/managemall']);
        
    });
  }
  back(){
    this.router.navigate(['/mall/managemall']);
  }

}
