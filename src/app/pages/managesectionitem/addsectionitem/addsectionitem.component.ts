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
import { ImageCroppedEvent } from 'ngx-image-cropper';

@Component({
  selector: 'app-addsectionitem',
  templateUrl: './addsectionitem.component.html',
  styleUrls: ['./addsectionitem.component.css']
})
export class AddsectionitemComponent implements OnInit {

  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router) { }
  model:any={};
  alldata:any={};
  select:any;
  getwebsiteRestApiUrl:string = AppSettings.getwebsitelist; 
  websitelist:Array<Object>;
  sectionlist:Array<Object>;
  ServicePreviewimageChangedEvent:any={};
  serviceimageChangedEvent:any={};
  previewcroppedImage:any='';
  sectioncroppedImage:any='';
  uploadVideofile:any={};

  ngOnInit() {
    this.model.media_type=1;
    this.alldata.IspreviewImage= false;
  	this.alldata.usertype=localStorage.getItem('currentUsergroup');
    this.alldata.userid=localStorage.getItem('currentUserID');
    this.model.usergroup=localStorage.getItem('currentUsergroup');
    this.model.user_id=localStorage.getItem('currentUserID');
    this.model.created_by = this.alldata.userid;
  
   	this.CommonService.insertdata(this.getwebsiteRestApiUrl,this.alldata)
    .subscribe(package_det =>{       
      if(package_det.result!=""){ this.websitelist=package_det.result;}
    });
   
  }
  getsection(website:any){
    console.log(website);
    this.model.websiteSelected = website;
    this.CommonService.insertdata(AppSettings.GetsectionsList,this.model)
    .subscribe(resultdata =>{   
      this.sectionlist=resultdata.result; 
    });
  }

  add_sectionItem()
  	{
      $('.preloader').show();
      /********Section Item Image upload******/
      if(this.model.media_type==1)
      {
        this.model.IspreviewImage= true;
        this.CommonService.insertdata(AppSettings.uploadcropserviceimage,this.model)
        .subscribe( (response) => {
         if(response.status=='success')
         {
            this.model.file_name = response.data;
            this.CommonService.insertdata(AppSettings.AddsectionItem,this.model)
            .subscribe(package_det =>{  
              $('.preloader').hide();     
                 swal(
                  package_det.status,
                  package_det.message,
                  package_det.status
                )
                this.router.navigate(['/managesectionitem']); 
            }); 
         }
          else{
            swal('',"Error while on upload photo",'Oops!');
          }
        });
      }
      /**********End*****/

      /*******Video Section Upload*******/
      /*****For video and pdf and doc and  audio file upload*******/
      if(this.model.media_type==2 || this.model.media_type==5 || this.model.media_type==4 || this.model.media_type==3)
      {
        this.CommonService.insertdata(AppSettings.uploadcropserviceimage,this.model)
        .subscribe( (response) => {
         if(response.status=='success')
         {
          this.model.preview_file = response.data;
          this.CommonService.uploadFile(AppSettings.sectionItemVideoupload,this.uploadVideofile)
          .subscribe( (response) => {
             if(response.status=='success')
             { 
                this.model.file_name = response.data;
             
                this.CommonService.insertdata(AppSettings.AddsectionItem,this.model)
                .subscribe( (response) => {
                  if(response.status=='success')
                  {
                    $('.preloader').hide();  
                      swal(response.status,response.message, response.status)
                      this.router.navigate(['/managesectionitem']); 
                    }
                  else{
                    swal('',response.data,'Oops!');
                  }
                });
              }
              else{
                swal('',response.data,'Oops!');
              }
         });
         }
        });
       
      }      
      /*******/
  	
  	}
  	back(){this.router.navigate(['/managesectionitem']);}
	/*Preview File section*/
		getservicePreviewImage(event: any): void {        
          this.ServicePreviewimageChangedEvent = event;
          
          this.alldata.IspreviewImage= true;
	    }
	    PreviewimageCropped(event: ImageCroppedEvent) {
	        this.previewcroppedImage = event.base64;
	        this.model.file_name = event.base64;
	    }
    /**/
    /*Service Image uplad section*/
    getserviceImage(event: any): void {
        this.serviceimageChangedEvent = event;
    }
    serviceimageCropped(event: ImageCroppedEvent) {
        this.sectioncroppedImage = event.base64;
        this.model.file_name = event.base64;
    }
    /**/
    /*Audio file section upload*/
    getAudiodet($event) {
      this.model.IspreviewImage= true;
      this.uploadVideofile = $event.target.files[0];
      this.alldata.IspreviewImage= true;
	 }
    /**/

    /*Video file section*/
    getVideodet($event) {
      this.model.IspreviewImage= true;
      this.uploadVideofile = $event.target.files[0];
    }
    /**/

    /*Doc/Pdf*/
    getDocOrPdf($event)
    {
      this.model.IspreviewImage= true;
      this.uploadVideofile = $event.target.files[0];
    }

}
