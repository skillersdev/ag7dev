import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule,ActivatedRoute}  from '@angular/router';

import { LoginService } from '../../services/login.service';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { CommonService } from '../../services/common.service';
import { AppSettings } from '../../appSettings';
import { ImageCroppedEvent } from 'ngx-image-cropper';
import {ImageCropperComponent, CropperSettings} from 'ng2-img-cropper';
declare var jquery:any;
declare var $ :any;

@Component({ 
  selector: 'app-marketmanagers',
  templateUrl: './addalbumphots.component.html'
})
export class AddalbumphotsComponent implements OnInit {
 
 websiteurl:string=AppSettings.API_BASE;
 private sub: any;
 id:number;
 model:any={};
  alldata:any={};
 websitelist:Array<Object>;
 IsMediafileupload:Boolean=false;
 galleryImagelist:Array<Object>;
 getwebsiteRestApiUrl:string = AppSettings.getwebsitelist;
 uploadalbumApi:string=AppSettings.uploadalbumimage;
 uploaduserProfileApi:string=AppSettings.uploadprofileimage;
 uploaduserAdvApi:string=AppSettings.uploadcropimage;
 image_url = AppSettings.IMAGE_BASE;
 uploadVideofile:any={};
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
        this.id = +params['id']; 
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
          this.model = resultdata.result['album_det'];
          this.galleryImagelist= resultdata.result['gallery_det'];           
        });
  }
    updatealbum()
    {
      this.model1.website = this.model.website;
      this.model1.album_id = this.model.id;       
      if(this.IsMediafileupload)
      {
        $('.preloader').show();
           this.CommonService.uploadFile(this.uploaduserProfileApi,this.uploadVideofile)
          .subscribe( (response) => {
             if(response.status=='success')
             {
              this.model1.photos = response.data;
              $('.preloader').hide();
              this.CommonService.updatedata(AppSettings.uploadalbumphotosApi,this.model1) 
              .subscribe(package_det =>{       
                   swal(package_det.status,package_det.message,package_det.status)
                   //this.router.navigate(['/managegallery']);
                 //  this.router.navigate(['/addalbumphotos',id]);
                   window.location.href = AppSettings.URL_BASE+'addalbumphotos/'+this.id;
                  // window.location.reload();
                  
              });
             }
              else{
                swal('',response.data,'Oops!');
              }
         });
      }
      else{
          console.log(this.model1);
          this.CommonService.updatedata(AppSettings.uploadalbumphotosApi,this.model1) 
          .subscribe(package_det =>{       
             swal(package_det.status,package_det.message,package_det.status)
            //  this.router.navigate(['/managegallery']);
            window.location.href = AppSettings.URL_BASE+'addalbumphotos/'+this.id;
          });
      }
     
      
    }
     back(){
      this.router.navigate(['/managegallery']);
    }
    fileChangeEvent(event: any): void {
        this.imageChangedEvent = event;
        this.IsMediafileupload = false;
        this.model1.Imagefile = event.target;
        console.log(this.model1.Imagefile);

    }
  imageCropped(event: ImageCroppedEvent) {
        this.croppedImage = event.base64;
        this.model1.Imagefile = event.base64;
        console.log("s");
        console.log(this.model1.Imagefile);
    }
  deletealbumimage(id:any)
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
          self.removegalleryimages(idx);
         
        }        
      },function(dismiss) {
    });
  }
 removegalleryimages(idx:any)
 {
   this.CommonService.deletedata(AppSettings.DeletegalleryimagesRestApiUrl,idx)
        .subscribe(resultdata =>{
          
          if(resultdata!="")
          {
            swal('Deleted!','Data has been deleted.','success');
            this.ngOnInit();
           
          } 

      });
 }
 fileEvent($event) {
    this.uploadVideofile = $event.target.files[0];
    this.IsMediafileupload = true;
    
  }
}
