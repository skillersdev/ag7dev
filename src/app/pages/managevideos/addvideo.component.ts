import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';

import { AppComponent } from '../../app.component';

import { TopnavComponent } from '../../topnav/topnav.component';
import { SidemenuComponent } from '../../sidemenu/sidemenu.component';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { AppSettings } from '../../appSettings';
import { LoginService } from '../../services/login.service';
import { CommonService} from '../../services/common.service';
import { ImageCroppedEvent } from 'ngx-image-cropper';
import { TagInputModule } from 'ngx-chips';
declare var jquery:any;
declare var $ :any;
import { Injectable } from '@angular/core';

@Component({
  selector: 'app-manageuser',
  templateUrl: './addvideo.component.html'
})
export class AddvideoComponent implements OnInit {

  currentUser:any;
  currentUserID:any;
  currentUsername:any;
  currentUsergroup:any;
  currentUserStatus:any;
  currentAllUsers:any;
  model: any = {};
  model1:any={};
  likes:any = [];
 dislikes:any = [];
  iSfileupload:boolean=false;
  select: any;
  packagelist:Array<Object>;
  websitelist:Array<Object>;
  uploadVideofile:any={};
  alldata: any = {};
  videopreviewmodel:any={};
  getpackagelistRestApiUrl:string = AppSettings.getPackageDetail; 
  getwebsiteRestApiUrl:string = AppSettings.getwebsitelist; 
  checkUserRestApiUrl:string = AppSettings.checkuserdetail; 
  uploadvideoProfileApi:string=AppSettings.uploadvideo;
  AddUserRestApiUrl:string = AppSettings.Adduser; 
  imageChangedEvent: any = '';
  tagArray:Array<Object>;
  channellist:Array<Object>;
  croppedImage: any = '';
 
  image_url = AppSettings.IMAGE_BASE;

  constructor(private loginService: LoginService,private CommonService:CommonService,private router: Router,private http:Http) { 
      document.body.className="theme-red";

  }

  ngOnInit() {
     this.loginService.localStorageData();
      this.loginService.viewsActivate();
      //this.model.active=1;
      this.alldata.usertype=localStorage.getItem('currentUsergroup');
        this.alldata.userid=localStorage.getItem('currentUserID');
      
         this.CommonService.insertdata(this.getwebsiteRestApiUrl,this.alldata)
        .subscribe(package_det =>{       
          if(package_det.result!=""){ this.websitelist=package_det.result;}
        }); 
        this.alldata.usergroup=localStorage.getItem('currentUsergroup');
        this.alldata.user_id=localStorage.getItem('currentUserID');
        this.CommonService.insertdata(AppSettings.getChannellist,this.alldata)
        .subscribe(resultdata =>{       
          if(resultdata.result!=""){ 
            this.channellist=resultdata.result; 
          }
        }); 
        this.model.tags=[];
        this.tagArray=[];
        this.model.Iswebsite =0;
  }
  
  logout(){
    this.loginService.logout();
  }

  back(){
    this.router.navigate(['/managevideos']);
  }
  onTagsChanged(value:any){

    this.tagArray.push(value.tag.displayValue);
    console.log(value);
    this.model.taglist = this.tagArray;
  }
  adduser()
  {

    this.CommonService.insertdata(this.AddUserRestApiUrl,this.model)
    .subscribe(package_det =>{       
         swal(
          package_det.status,
          package_det.message,
          package_det.status
        )
        this.router.navigate(['/manageuser']); 
    });
  }
  checkUserexist(event:any)
  {
    //console.log(event.target.value);
    this.model.username=event.target.value;
    this.CommonService.checkexistdata(this.checkUserRestApiUrl,this.model)
    .subscribe(package_det =>{
      if(package_det.exist==1)
      {
        swal('',package_det.message,'error')
      }  
    });
  }
   fileChangeEvent(event: any): void {
        this.imageChangedEvent = event;
        //this.model1.Imagefile = event.target;
        
    }
   imageCropped(event: ImageCroppedEvent) {
      this.croppedImage = event.base64;
      this.videopreviewmodel.Imagefile = event.base64;
      console.log(this.videopreviewmodel.Imagefile);
      this.iSfileupload= true;
    }
    addVideos()
    {
      $('.preloader').show();
       this.CommonService.uploadFile(this.uploadvideoProfileApi,this.uploadVideofile)
          .subscribe( (response) => {
             if(response.status=='success')
             { 
              this.model.video_file = response.data;
              console.log(this.videopreviewmodel);
              this.CommonService.insertdata(AppSettings.uploadvideoPreviewApi,this.videopreviewmodel)
            .subscribe( (response) => {
               if(response.status=='success')
               {
                 this.model.preview_image = response.data;
                 this.model.created_by = this.alldata.userid;
                 $('.preloader').hide();
                this.CommonService.updatedata(AppSettings.addvideosectiondata,this.model) 
                .subscribe(package_det =>{       
                     swal(package_det.status,package_det.message,package_det.status)
                     this.router.navigate(['/managevideos']);
                });
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
    fileEvent($event) {
      this.uploadVideofile = $event.target.files[0];
      console.log(this.uploadVideofile);
    }

    removeLastOnBackspace(){
      
    }
    getwebsitebychannel(value:any)
    {
      if(value)
      {
        const items = this.channellist.filter(item => item['id'].indexOf(value) !== -1);
        if(items.length>0)
        {
          this.model.Iswebsite =1;
          this.model.channelWebsite = items[0]['website'];
        }
      }
     
    }
}
