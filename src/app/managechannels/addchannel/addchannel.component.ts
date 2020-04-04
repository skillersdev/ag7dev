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
  selector: 'app-addchannel',
  templateUrl: './addchannel.component.html',
  styleUrls: ['./addchannel.component.css']
})
export class AddchannelComponent implements OnInit {

  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router,private http:Http) { 
      document.body.className="theme-red";

  }

   model:any={};
  select:any={};
  alldata:any={};
  profilecroppedImage: any = '';
  bannercroppedImage:any="";
  profileimageChangedEvent:any;
  bannerimageChangedEvent:any;

  websitelist:Array<Object>;

  ngOnInit() {
  	 this.loginService.localStorageData();
      this.loginService.viewsActivate();

       this.alldata.usertype=localStorage.getItem('currentUsergroup');
        this.alldata.userid=localStorage.getItem('currentUserID');
      
         this.CommonService.insertdata(AppSettings.getwebsitelist,this.alldata)
        .subscribe(package_det =>{       
          if(package_det.result!=""){ this.websitelist=package_det.result;}
        }); 
        this.model.Isvalidate = true;
  }

   profileImageUpload(event: any): void {
        this.alldata.profileImage = event;
        this.profileimageChangedEvent =event;
    }
   profileimageCropped(event: ImageCroppedEvent) {
        this.profilecroppedImage = event.base64;
        this.alldata.profileImage = event.base64;
    }

    bannerImageUpload(event: any): void {
        this.alldata.bannerImage = event;
         this.bannerimageChangedEvent = event;
    }
   bannerimageCropped(event: ImageCroppedEvent) {
       this.bannercroppedImage= event.base64;
       this.alldata.bannerImage = event.base64;
    }

    addchannel_form()
    {
    	this.model.created_by = this.alldata.userid;
    	//console.log(this.model);
    	this.CommonService.insertdata(AppSettings.uploadchannellImage,this.alldata)
    	.subscribe( (response) => {
    		console.log(response);
	       if(response[0])
	       {
	       	this.model.channel_profile_img = response[0]['file'];
	       }
	       if(response[1]){
	       	this.model.channel_banner_img = response[1]['file'];	        
	       }
	       //this.model.product_image = response.data;
	          this.CommonService.insertdata(AppSettings.AddchanneldataApi,this.model)
	          .subscribe(package_det =>{       
	               swal(
	                package_det.status,
	                package_det.message,
	                package_det.status
	              )
	              this.router.navigate(['/managechannels']); 
	          });  

     	})
    }
    restrictNumbers(event: any)
    {
        const pattern = /[0-9\+\-\ ]/;
        const inputChar = String.fromCharCode(event.charCode);

        if (pattern.test(inputChar)) {    
            // invalid character, prevent input
            event.preventDefault();
        }
    }
    back(){
        this.router.navigate(['/managechannels']); 
    }
    updateChannelUrl()
    {
        this.model.Isvalidate = true;
        if(this.model.channel_name)
        {
            if(this.model.channel_name.match(/^(?![0-9]*$)[a-zA-Z0-9]+$/))
            {
                this.model.Isvalidate = true;
            }else{
                this.model.Isvalidate = false;
            }
        }

        
        this.model.channel_url='';
        if(this.model.website && this.model.channel_name && this.model.Isvalidate)
        {
            this.CommonService.insertdata(AppSettings.checkChannelduplciation,this.model)
    	    .subscribe( (response) => {
                if(response.status=='success')
                {
                    this.model.Isvalidate = true;
                }else{
                    this.model.Isvalidate = false;
                    this.model.channel_url = '';
                    swal('error',response.message,'error');
                    return false;
                }
            
            });

            this.model.channel_url = this.model.website+'/'+this.model.channel_name;
        }
       
    }


}
