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
  selector: 'app-editpackage',
  templateUrl: './editvideo.component.html'
})
export class EditvideoComponent implements OnInit {
  websiteurl:string=AppSettings.API_BASE;
  currentUser:any;
  currentUserID:any;
  currentUsername:any;
  currentUsergroup:any;
  currentUserStatus:any;
  currentAllUsers:any;
  select: any;
  FetchvideodataRestApiUrl: string = AppSettings.Editvideo; 
  updateuserRestApiUrl: string = AppSettings.Updateuser; 
  checkUserRestApiUrl:string = AppSettings.checkuserdetail; 
  getwebsiteRestApiUrl:string = AppSettings.getwebsitelist;
  uploadvideoProfileApi:string=AppSettings.uploadvideo;
   imageChangedEvent: any = '';
  croppedImage: any = '';
  image_url = AppSettings.IMAGE_BASE;
  model: any = {};
  videopreviewmodel:any={};
  uploadVideofile:any={};
  videoFileupload:Boolean=false;
  isImageupload:Boolean=false;
  websitelist:Array<Object>;
  packagelist:Array<Object>;
  alldata: any = {};
  private sub: any;
  id:number;
  stage_of_packages:Array<Object>;stage_of_packages_prev:Array<Object>;
  
  getpackagelistRestApiUrl:string = AppSettings.getPackageDetail; 
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
       this.stage_of_packages=[]; 
       this.stage_of_packages_prev=[];

      this.sub = this.route.params.subscribe(params => {
        this.id = +params['id']; // (+) converts string 'id' to a number
        this.edituser(this.id);
        
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
    this.router.navigate(['/manageuser']);
  }
  edituser(id:any)
  {
    
    this.CommonService.editdata(this.FetchvideodataRestApiUrl,id)
        .subscribe(resultdata =>{   
          this.model = resultdata.result.video_det;
          
        });
  }
 
    updateVideos()
    {
      if(this.videoFileupload)
      {
        this.CommonService.uploadFile(this.uploadvideoProfileApi,this.uploadVideofile)
          .subscribe( (response) => {
             if(response.status=='success')
             { 
              this.model.video_file = response.data;
              //console.log(this.videopreviewmodel);
            }
          });
      }

      if(this.isImageupload)
      {
        //this.model.preview_image='';
        this.CommonService.insertdata(AppSettings.uploadvideoPreviewApi,this.videopreviewmodel)
      
          .subscribe( (response) => {
             if(response.status=='success')
             {
               this.model.preview_image = response.data;
               console.log("aaaaaa");
             }
           });
      }
      this.model.created_by = localStorage.getItem('currentUserID');
      setTimeout(()=>{ 
         
          this.CommonService.updatedata(AppSettings.updatevideosectiondata,this.model) 
          .subscribe(package_det =>{       
               swal(package_det.status,package_det.message,package_det.status)
               this.router.navigate(['/managevideos']);
          });
      }, 3000);
       
         
  }
  checkUserexist(event:any)
  {
    //console.log(event.target.value);
    this.model.username=event.target.value;
    //this.model.username=event.target.va;
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
        this.isImageupload=true;
        //this.model1.Imagefile = event.target;
        
    }
   imageCropped(event: ImageCroppedEvent) {
      this.croppedImage = event.base64;
      this.videopreviewmodel.Imagefile = event.base64;
      this.isImageupload=true;
      console.log(this.videopreviewmodel.Imagefile);
    }

    fileEvent($event) {
      this.videoFileupload =true;
      this.uploadVideofile = $event.target.files[0];
    
    }
}
