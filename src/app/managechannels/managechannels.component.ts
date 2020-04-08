import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';

import { AppComponent } from '../app.component';

import { TopnavComponent } from '../topnav/topnav.component';
import { SidemenuComponent } from '../sidemenu/sidemenu.component';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { AppSettings } from '../appSettings';
import { LoginService } from '../services/login.service';
import { CommonService } from '../services/common.service';
import { ImageCroppedEvent } from 'ngx-image-cropper';
declare var jquery:any;
declare var $ :any; 
import { Injectable } from '@angular/core';  

@Component({
  selector: 'app-managechannels',
  templateUrl: './managechannels.component.html',
  styleUrls: ['./managechannels.component.css']
})
export class ManagechannelsComponent implements OnInit {

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
  userdata:any={};

  channellist:Array<Object>;

  ngOnInit() {
  	this.loginService.localStorageData();
     this.loginService.viewsActivate();
     let user_id = localStorage.getItem('currentUserID');
     this.model.imagePath = AppSettings.API_BASE;
    this.model.usergroup=localStorage.getItem('currentUsergroup');

    this.userdata.user_id = localStorage.getItem('currentUserID');
    this.userdata.usergroup=localStorage.getItem('currentUsergroup');
    
    this.CommonService.insertdata(AppSettings.getChannellist,this.userdata)
    .subscribe(resultdata =>{   
      this.channellist=resultdata.result; 
      this.loginService.viewCommontdataTable('channelTable','channelTable'); 
    });
    
  }

  navigateAddchannel()
  {
  	this.router.navigate(['/addchannel']);
  }
  editchannel(id:any)
  {
     this.router.navigate(['/editchannel', id]);
  }
  deletechannel(id:any)
  {
    let idx = id;
    let self = this;
      swal({
        title: 'Are you sure?',
         buttons: {
            cancel: true,
            confirm: true,
          },
        text: "You won't be able to revert this!",
      }).then(function (result) {
        if(result)
        {
          self.removechannel(idx);
         
        }        
      },function(dismiss) {
    });
  }
  removechannel(idx:any)
 {
   this.CommonService.deletedata(AppSettings.deleteChanneldata,idx)
        .subscribe(resultdata =>{
          if(resultdata!="")
          { 
            // this.advertisementlist=[];
            swal('Deleted!','Data has been deleted.','success');
            this.CommonService.insertdata(AppSettings.getChannellist,this.userdata)
            .subscribe(resultdata =>{   
              this.channellist=resultdata.result; 
              this.loginService.viewCommontdataTable('channelTable','channelTable');
            });
          } 

      });
 }
 viewchannel(website:any,channel:any)
 {
  let url =  window.open('https://video.roodabatoz.com/channel/' + website+'/'+channel,"_blank");
  
 }
}
