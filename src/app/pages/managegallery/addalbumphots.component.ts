import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule,ActivatedRoute}  from '@angular/router';

import { LoginService } from '../../services/login.service';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { CommonService } from '../../services/common.service';
import { AppSettings } from '../../appSettings';
import { ImageCroppedEvent } from 'ngx-image-cropper';
import {ImageCropperComponent, CropperSettings} from 'ng2-img-cropper';

@Component({
  selector: 'app-marketmanagers',
  templateUrl: './addalbumphots.component.html'
})
export class AddalbumphotsComponent implements OnInit {
 
 websiteurl:string=AppSettings.API_BASE;
 private sub: any;
 id:number;
 model:any;
  alldata:any={};
 websitelist:Array<Object>;
 getwebsiteRestApiUrl:string = AppSettings.getwebsitelist;
 uploadalbumApi:string=AppSettings.uploadalbumimage;
 uploaduserProfileApi:string=AppSettings.uploadprofileimage;
 model1:any={};
 imageChangedEvent: any = '';
    croppedImage: any = '';
 constructor(private loginService: LoginService,private CommonService: CommonService,private route: ActivatedRoute,private router: Router,private http:Http) { 
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
     this.sub = this.route.params.subscribe(params => {
        this.id = +params['id']; // (+) converts string 'id' to a number
        this.editgallery(this.id);        
        });     
  }
  navigateAddalbum()
  {
    this.router.navigate(['/addalbum']);
  }
  editgallery(id:any)
  {
    this.CommonService.editdata(AppSettings.FetchAlbumbyidRestApiUrl,id)
        .subscribe(resultdata =>{   
          this.model = resultdata.result;           
        });
  }
    updatealbum()
    {
      this.model1.website = this.model.website;
      this.model1.album_id = this.model.id;
      this.CommonService.updatedata(AppSettings.uploadalbumphotosApi,this.model1) 
    .subscribe(package_det =>{       
         swal(package_det.status,package_det.message,package_det.status)
         this.router.navigate(['/managegallery']);
        
    });
    }
     back(){
      this.router.navigate(['/managegallery']);
    }
    fileChangeEvent(event: any): void {
        this.imageChangedEvent = event;
        this.model1.Imagefile = event.target;
    }
  imageCropped(event: ImageCroppedEvent) {
        this.croppedImage = event.base64;
        this.model1.Imagefile = event.base64;

    }
}
