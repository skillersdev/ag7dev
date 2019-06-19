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
  selector: 'app-manageuser',
  templateUrl: './addtemplate.component.html'
})
export class AddtemplateComponent implements OnInit {

  currentUser:any;
  currentUserID:any;
  currentUsername:any;
  currentUsergroup:any;
  currentUserStatus:any;
  currentAllUsers:any;
  model: any = {};
  packagelist:Array<Object>;
  websitelist:Array<Object>;
  showbutton:boolean=true;
  alldata: any = {};
  getpackagelistRestApiUrl:string = AppSettings.getPackageDetail; 
  checkUserRestApiUrl:string = AppSettings.checkuserdetail; 
  AddUserRestApiUrl:string = AppSettings.Adduser;
  getwebsiteRestApiUrl:string = AppSettings.getwebsitelist; 
  AddTemplateRestApiUrl:string = AppSettings.Addtemplate;
 uploaduserAdvApi:string=AppSettings.uploadAdvfile;
  constructor(private loginService: LoginService,private CommonService:CommonService,private router: Router,private http:Http) { 
      document.body.className="theme-red";

  }

  ngOnInit() {
     this.loginService.localStorageData();
      this.loginService.viewsActivate();
      //this.model.active=1;
      this.CommonService.getdata(this.getpackagelistRestApiUrl)
        .subscribe(packagedet =>{
            if(packagedet.result!="")
            { 
              this.packagelist= packagedet.result;
            } 
            console.log(this.packagelist); 
        });

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

  back(){
    this.router.navigate(['/managetemplates']);
  }
  addtemplate()
  {
    this.model.created_by=localStorage.getItem('currentUserID');
    this.CommonService.insertdata(this.AddTemplateRestApiUrl,this.model)
    .subscribe(package_det =>{       
         swal(
          package_det.status,
          package_det.message,
          package_det.status
        )
        this.router.navigate(['/managetemplates']); 
    });
  }
  // checkUserexist(event:any)
  // {
  //   //console.log(event.target.value);
  //   this.model.username=event.target.value;
  //   this.CommonService.checkexistdata(this.checkUserRestApiUrl,this.model)
  //   .subscribe(package_det =>{
  //     if(package_det.exist==1)
  //     {
  //       swal('',package_det.message,'error')
  //     }  
  //   });
  // }
   fileEvent($event) {
    const fileSelected: File = $event.target.files[0];
    this.showbutton=false;
    $('.preloader').show();
    this.CommonService.uploadFile(this.uploaduserAdvApi,fileSelected)
    .subscribe( (response) => {
       if(response.status=='success')
       {
        this.model.slider_image = response.data;
        $('.preloader').hide();
        this.showbutton=true;
       }
        else{
          swal('',response.data,'Oops!');
          
          //this.toastr.errorToastr(response.data, 'Oops!');
        }
     })
  }

}
