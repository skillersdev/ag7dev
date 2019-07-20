import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';

import { AppComponent } from '../../app.component';

import { TopnavComponent } from '../../topnav/topnav.component';
import { SidemenuComponent } from '../../sidemenu/sidemenu.component';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { AppSettings } from '../../appSettings';
import { LoginService } from '../../services/login.service';
import { CommonService } from '../../services/common.service';
import { ImageCroppedEvent } from 'ngx-image-cropper';
declare var jquery:any;
declare var $ :any; 
import { Injectable } from '@angular/core';  

@Component({
  selector: 'app-manageuser',
  templateUrl: './addadvertisement.component.html'
})
export class AddadvertisementComponent implements OnInit {

  currentUser:any;
  currentUserID:any;
  currentUsername:any;
  currentUsergroup:any;
  currentUserStatus:any;
  currentAllUsers:any;
  model: any = {};
  model1: any = {};
  alldata: any = {};
  websitelist:Array<Object>;
  uploaduserAdvApi:string=AppSettings.uploadcropimage;
  insertuseradRestApiUrl: string = AppSettings.Adduseradvertisement; 
  getwebsiteRestApiUrl:string = AppSettings.getwebsitelist; 
  imageChangedEvent: any = '';
    croppedImage: any = '';
  
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router,private http:Http) { 
      document.body.className="theme-red";

  }

  ngOnInit() {
     this.loginService.localStorageData();
      this.loginService.viewsActivate();

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
  gettype()
  {
    if(this.model.ad_type==1){
      this.model.formEnable=1;
    }else{
      this.model.formEnable=2;
    }
  }
  adduseradvertisement()
  {
    delete this.model.formEnable;
    this.model.user_id=localStorage.getItem('currentUserID');
     this.CommonService.insertdata(this.uploaduserAdvApi,this.model1)
      .subscribe( (response) => {
         if(response.status=='success')
         {
          this.model.uploads = response.data;
        
           this.CommonService.insertdata(this.insertuseradRestApiUrl,this.model)
          .subscribe(package_det =>{       
               swal(package_det.status,package_det.message,package_det.status)
              this.router.navigate(['/manageads']); 
          });
        }
     })
  }
  fileEvent($event) {
    const fileSelected: File = $event.target.files[0];
    
    this.CommonService.uploadFile(this.uploaduserAdvApi,fileSelected)
    .subscribe( (response) => {
       if(response.status=='success')
       {
        this.model.uploads = response.data;
       }
        else{
          swal('',response.data,'Oops!');
          
          //this.toastr.errorToastr(response.data, 'Oops!');
        }
     })
  }

  fileChangeEvent(event: any): void {
        this.imageChangedEvent = event;
    }
  imageCropped(event: ImageCroppedEvent) {
        this.croppedImage = event.base64;
        this.model1.Imagefile = event.base64;

    }

  back(){
    this.router.navigate(['/manageads']);
  }

}
