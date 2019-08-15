import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';

import { LoginService } from '../../services/login.service';

import { CommonService } from '../../services/common.service';
import { AppSettings } from '../../appSettings';
;
import { ImageCroppedEvent } from 'ngx-image-cropper';

@Component({
  selector: 'app-addgallery',
  templateUrl: './addgallery.component.html'
})
export class AddgalleryComponent implements OnInit {
 model:any={};
 model1:any={};
 alldata:any={};
 websitelist:Array<Object>;
 iSfileupload:boolean=false;
 websiteurl:string=AppSettings.USER_TEMPLATE;
 getwebsiteRestApiUrl:string = AppSettings.getwebsitelist;
 uploadalbumApi:string=AppSettings.uploadalbumimage;
 insertAlbumRestApiUrl:string = AppSettings.insertAlbum;
  imageChangedEvent: any = '';
  croppedImage: any = '';
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router) { }

  ngOnInit() {
    this.loginService.localStorageData();
    this.loginService.viewsActivate();

    this.alldata.usertype=localStorage.getItem('currentUsergroup');
    this.alldata.userid=localStorage.getItem('currentUserID');

      this.CommonService.insertdata(this.getwebsiteRestApiUrl,this.alldata)
        .subscribe(package_det =>{       
          if(package_det.result!=""){ this.websitelist=package_det.result;}
        });
        console.log(this.model1.Imagefile);
  }
 
   fileChangeEvent(event: any): void {
        this.imageChangedEvent = event;
    }
  imageCropped(event: ImageCroppedEvent) {
        this.croppedImage = event.base64;
        this.model1.Imagefile = event.base64;
        this.iSfileupload= true;

    }
   addalbums(){
     console.log("test");
    this.CommonService.insertdata(this.uploadalbumApi,this.model1)
    .subscribe( (response) => {
       if(response.status=='success')
       {
        this.model.album_image = response.data;
        this.model.created_by = this.alldata.userid;
         this.CommonService.insertdata(this.insertAlbumRestApiUrl,this.model)
        .subscribe(service_det =>{       
             swal(
              service_det.status,
              service_det.message,
              service_det.status
            )
            this.router.navigate(['/managegallery']); 
        });
      }
    });
  }  

}
