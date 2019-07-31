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
  templateUrl: './addcontact.component.html'
})
export class AddcontactComponent implements OnInit {

  currentUser:any;
  currentUserID:any;
  currentUsername:any;
  currentUsergroup:any;
  currentUserStatus:any;
  currentAllUsers:any;
  model: any = {};
  model1: any = {};
  select: any;
  alldata: any = {};
  websitelist:Array<Object>;
   imageChangedEvent: any = '';
    croppedImage: any = '';


  getwebsiteRestApiUrl:string = AppSettings.getwebsitelist;
  insertcontactsRestApiUrl: string = AppSettings.Addcontacts; 
  //uploaduserProfileApi:string=AppSettings.uploadprofileimage;
  uploaduserProfileApi:string=AppSettings.uploadcropimage;
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
  back(){
    this.router.navigate(['/managecontacts']);
  }

  addcontactlist()
  {
    console.log(this.model1.Imagefile);
    this.CommonService.insertdata(this.uploaduserProfileApi,this.model1)
    .subscribe( (response) => {
       if(response.status=='success')
       {
          this.model.website_image = response.data;
           this.model.created_by=localStorage.getItem('currentUserID');
            this.CommonService.insertdata(this.insertcontactsRestApiUrl,this.model)
            .subscribe(contact_det =>{  
                if(contact_det.exist==1)
                {
                  swal(
                    'error',
                    contact_det.message,
                    'error'
                  )
                }
                else{
                   swal(
                    contact_det.status,
                    contact_det.message,
                    contact_det.status
                  )
                }

                
                this.router.navigate(['/managecontacts']); 
            });
       }
     });
  }

  fileEvent($event) {
    const fileSelected: File = $event.target.files[0];
    $('.preloader').show();
    this.CommonService.uploadFile(this.uploaduserProfileApi,fileSelected)
    .subscribe( (response) => {
       if(response.status=='success')
       {
        this.model.website_image = response.data;
        $('.preloader').hide();
       }
        else{
          swal('',"Error while on upload photo",'Oops!');
          
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
}
