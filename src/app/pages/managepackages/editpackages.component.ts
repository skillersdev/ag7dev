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
  templateUrl: './editpackages.component.html'
})
export class EditpackageComponent implements OnInit {

  currentUser:any;
  currentUserID:any;
  currentUsername:any;
  currentUsergroup:any;
  currentUserStatus:any;
  currentAllUsers:any;
  FetchpackageRestApiUrl: string = AppSettings.Editpackage; 
  updatepackageRestApiUrl: string = AppSettings.Updatepackage; 
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
      console.log("2here"); 
       this.stage_of_packages=[]; 
       this.stage_of_packages_prev=[];
       this.stage_upgradation_data=[];this.stage_bonus_data=[];
      // this.stage_upgradation_data=[];this.stage_bonus_data=[];
      // for (var _i = 0; _i < 100; _i++) {
      //   this.stage_of_packages.push({'id':_i,'stage_bonus_amount':0,'stage_upgradation_amount':0});
      // }
      this.sub = this.route.params.subscribe(params => {
        this.id = +params['id']; // (+) converts string 'id' to a number
        this.editpackage(this.id);
        
        });
  }
  
  logout(){
    this.loginService.logout();
  }
  back(){
    this.router.navigate(['/managepackages']);
  }
  editpackage(id:any)
  {
    
    this.CommonService.editdata(this.FetchpackageRestApiUrl,id)
        .subscribe(resultdata =>{   
          this.model = resultdata.result;
         
          let stage_bonus_amount=resultdata.level;
          let stage_upgradation_amount=resultdata.stage;
          console.log(stage_bonus_amount);
          stage_bonus_amount.filter((data:any,id:any) =>{
              this.stage_of_packages.push({'id':id,'stage_bonus_amount':stage_bonus_amount[id],
                'stage_upgradation_amount':stage_upgradation_amount[id]});
          });
          console.log(this.stage_of_packages);
        });
  }
  updatepackages()
  {
    this.stage_of_packages.filter((data:any,id:any) =>{    
       
        this.stage_bonus_data.push(data.stage_bonus_amount);
        this.stage_upgradation_data.push(data.stage_upgradation_amount);
    });
     this.model.stage_bonus_data = this.stage_bonus_data;
    this.model.stage_upgradation_data = this.stage_upgradation_data;
     this.CommonService.updatedata(this.updatepackageRestApiUrl,this.model)
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
