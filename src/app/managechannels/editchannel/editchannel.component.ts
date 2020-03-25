import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule,ActivatedRoute}  from '@angular/router';

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
  selector: 'app-editchannel',
  templateUrl: './editchannel.component.html',
  styleUrls: ['./editchannel.component.css']
})
export class EditchannelComponent implements OnInit {

  constructor(private loginService: LoginService,private CommonService: CommonService,
    private route: ActivatedRoute,private router: Router,private http:Http) { }
  private sub: any;
  model:any;
  alldata:any={};
  select:any;
  websitelist:Array<Object>;
  profileimageChangedEvent:any;
  profilecroppedImage:any;
  bannerimageChangedEvent:any;
  bannercroppedImage:any;
  image_url = AppSettings.IMAGE_BASE;
  id:number;
  ngOnInit() {
  	 this.sub = this.route.params.subscribe(params => {
        this.id = +params['id']; // (+) converts string 'id' to a number
        this.editchannel(this.id);        
        });

  	 this.alldata.usertype=localStorage.getItem('currentUsergroup');
        this.alldata.userid=localStorage.getItem('currentUserID');
      
         this.CommonService.insertdata(AppSettings.getwebsitelist,this.alldata)
        .subscribe(package_det =>{       
          if(package_det.result!=""){ this.websitelist=package_det.result;}
        });
  }
  editchannel(id:any)
  {
  	this.CommonService.editdata(AppSettings.editchannel,id)
        .subscribe(resultdata =>{   
          this.model = resultdata.result;                  
        });
  }
  back()
  {
  	 this.router.navigate(['/managechannels']); 
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
    	
    }

}
