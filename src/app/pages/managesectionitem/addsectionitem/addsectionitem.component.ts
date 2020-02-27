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
  getwebsiteRestApiUrl:string = AppSettings.getwebsitelist; 
  websitelist:Array<Object>;
  sectionlist:Array<Object>;
  ServicePreviewimageChangedEvent:any={};
  serviceimageChangedEvent:any={};
  previewcroppedImage:any='';
  sectioncroppedImage:any='';

  ngOnInit() {
  	this.alldata.usertype=localStorage.getItem('currentUsergroup');
    this.alldata.userid=localStorage.getItem('currentUserID');
  
   	this.CommonService.insertdata(this.getwebsiteRestApiUrl,this.alldata)
    .subscribe(package_det =>{       
      if(package_det.result!=""){ this.websitelist=package_det.result;}
    });
    this.CommonService.insertdata(AppSettings.GetsectionsList,this.model)
    .subscribe(resultdata =>{   
      this.sectionlist=resultdata.result; 
    });
  }

  add_section()
  	{
  		this.model.created_by = this.alldata.userid;
	  	this.CommonService.insertdata(AppSettings.addsection,this.model)
	      .subscribe( (response) => {
	         if(response.status=='success')
	         {
	         	swal(response.status,response.message,response.status)
            	this.router.navigate(['/managesection']); 
	         }

	         else{
	            swal('',response.data,'Oops!');
	         }
	     })
  	}
  	back(){this.router.navigate(['/managesectionitem']);}
	/*Preview File section*/
		getservicePreviewImage(event: any): void {
	        this.ServicePreviewimageChangedEvent = event;
	    }
	    PreviewimageCropped(event: ImageCroppedEvent) {
	        this.previewcroppedImage = event.base64;
	        this.model.preview_file = event.base64;
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
	    this.model.file_name = $event.target.files[0];
	 }
    /**/

    /*Video file section*/
    getVideodet($event) {
      this.model.file_name = $event.target.files[0];
    }
    /**/

}
