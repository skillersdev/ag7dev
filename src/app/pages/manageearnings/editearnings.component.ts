import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule,ActivatedRoute}  from '@angular/router';
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
  selector: 'app-editpackage',
  templateUrl: './editearnings.component.html'
})
export class EditearningsComponent implements OnInit {

  currentUser:any;
  currentUserID:any;
  currentUsername:any;
  currentUsergroup:any;
  currentUserStatus:any;
  currentAllUsers:any;
  FetchearningsRestApiUrl: string = AppSettings.Editearnings; 
  getpackagelistRestApiUrl:string = AppSettings.getPackageDetail; 
  updateearningsRestApiUrl: string = AppSettings.Updateearnings; 
  updateuserRestApiUrl: string = AppSettings.Updateuser; 
  checkUserRestApiUrl:string = AppSettings.checkuserdetail; 
  model: any = {};
  packagelist:Array<Object>;
  alldata: any = {};
  private sub: any;
  id:number;
  stage_of_packages:Array<Object>;stage_of_packages_prev:Array<Object>;

  stage_bonus_data:Array<Object>;
  stage_upgradation_data:Array<Object>;
  constructor(private loginService: LoginService,
            private route: ActivatedRoute,private CommonService: CommonService,
            private router: Router,private http:Http) { 
      document.body.className="theme-red";

  }

  ngOnInit() {
     this.loginService.localStorageData();
      this.loginService.viewsActivate();
       this.stage_of_packages=[]; 
       this.stage_of_packages_prev=[];

      this.sub = this.route.params.subscribe(params => {
        this.id = +params['id']; // (+) converts string 'id' to a number
        this.editearnings(this.id);
        
        });
      this.CommonService.getdata(this.getpackagelistRestApiUrl)
        .subscribe(packagedet =>{
            if(packagedet.result!="")
            { 
              this.packagelist= packagedet.result;
            } 
            console.log(this.packagelist); 
        });
  }
  
  logout(){
    this.loginService.logout();
  }
  back(){
    this.router.navigate(['/manageuser']);
  }
  editearnings(id:any)
  {
    
    this.CommonService.editdata(this.FetchearningsRestApiUrl,id)
        .subscribe(resultdata =>{   
          this.model = resultdata.result;
          
        });
  }
  updateearnings()
  {
     this.CommonService.updatedata(this.updateearningsRestApiUrl,this.model)
    .subscribe(package_det =>{       
         swal(
          package_det.status,
          package_det.message,
          package_det.status
        )
         this.router.navigate(['/manageearnings']);
        
    });
  }
  checkUserexist(event:any)
  {
    //console.log(event.target.value);
    this.model.username=event.target.value;
    //this.model.username=event.target.va;
    this.CommonService.checkexistdata(this.checkUserRestApiUrl,this.model)
    .subscribe(package_det =>{
      if(package_det.exist==1)
      {
        swal('',package_det.message,'error')
      }  
    });
  }
}
