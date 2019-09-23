import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule,ActivatedRoute}  from '@angular/router';

import { LoginService } from '../../services/login.service';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { CommonService } from '../../services/common.service';
import { AppSettings } from '../../appSettings';
import { ImageCroppedEvent } from 'ngx-image-cropper';

@Component({
  selector: 'app-marketmanagers',
  templateUrl: './editgallery.component.html'
})
export class EditgalleryComponent implements OnInit {
 
 websiteurl:string=AppSettings.API_BASE;
 private sub: any;
 id:number;
 model:any;
  alldata:any={};
 websitelist:Array<Object>;
 getwebsiteRestApiUrl:string = AppSettings.getwebsitelist;
 uploadalbumApi:string=AppSettings.uploadalbumimage;
 model1:any={};
 select:any;
 image_url = AppSettings.IMAGE_BASE;
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
          this.model = resultdata.result.album_det;         
        });
  }
  fileChangeEvent(event: any): void {
        this.imageChangedEvent = event;
    }
  imageCropped(event: ImageCroppedEvent) {
        this.croppedImage = event.base64;
        this.model1.Imagefile = event.base64;
        this.CommonService.insertdata(this.uploadalbumApi,this.model1)
      .subscribe( (response) => {
         if(response.status=='success')
         {
          this.model.service_image = response.data;
        
          
        }
     })
    }
    updatealbum()
    {
      this.CommonService.updatedata(AppSettings.updatealbumRestApiUrl,this.model)
    .subscribe(package_det =>{       
         swal(
          package_det.status,
          package_det.message,
          package_det.status
        )
         this.router.navigate(['/managegallery']);
        
    });
    }
     back(){
    this.router.navigate(['/managegallery']);
  }
}
