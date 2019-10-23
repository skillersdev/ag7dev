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
  selector: 'app-manageuser',
  templateUrl: './editadvertisement.component.html'
})
export class EditadvertisementComponent implements OnInit {

  currentUser:any;
  currentUserID:any;
  currentUsername:any;
  currentUsergroup:any;
  currentUserStatus:any;
  currentAllUsers:any;
  websitelist:Array<Object>;
  private sub: any;
  model: any = {};
  model1: any = {};
  alldata: any = {};
  Istypecheck:any;
  id:number;
  insertcategoryRestApiUrl: string = AppSettings.Addcategory; 
  FetchadRestApiUrl: string = AppSettings.editad; 
  updateadRestApiUrl: string = AppSettings.updatead; 
  getwebsiteRestApiUrl:string = AppSettings.getwebsitelist; 
  uploaduserAdvApi:string=AppSettings.uploadcropimage;
  uploadvideoProfileApi:string=AppSettings.uploadvideo;
  image_url = AppSettings.IMAGE_BASE;
   imageChangedEvent: any = '';
    croppedImage: any = '';
  constructor(private loginService: LoginService,private CommonService: CommonService,
    private route: ActivatedRoute,private router: Router,private http:Http) { 
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
        this.editad(this.id);        
        });

  }
  
  logout(){
    this.loginService.logout();
  }
  addcategorylist()
  {
    this.model.created_by=localStorage.getItem('currentUserID');
    this.CommonService.insertdata(this.insertcategoryRestApiUrl,this.model)
    .subscribe(package_det =>{       
         swal(
          package_det.status,
          package_det.message,
          package_det.status
        )
        this.router.navigate(['/manageads']); 
    });
  }
  gettype()
  {
    if(this.model.ad_type==1){
      this.model.formEnable=1;
    }else{
      this.model.formEnable=2;
    }
  }
  fileEvent($event) {
    const fileSelected: File = $event.target.files[0];
    this.alldata.filename=fileSelected;
    this.Istypecheck=1;
    
    
  }
  editad(id:any)
  {
    this.CommonService.editdata(this.FetchadRestApiUrl,id)
        .subscribe(resultdata =>{   
          this.model = resultdata.result; 
           if(this.model.ad_type==1){
              this.model.formEnable=1;
            }else{
              this.model.formEnable=2;
            }        
        });
  }
  updatead()
  {
     //this.model.is_deleted=1
     if(this.Istypecheck==1)
     {
        this.CommonService.uploadFile(this.uploadvideoProfileApi,this.alldata.filename)
        .subscribe( (response) => {
           if(response.status=='success')
           {
            this.model.uploads = response.data;
             delete this.model.formEnable;
                 this.CommonService.updatedata(this.updateadRestApiUrl,this.model)
                .subscribe(package_det =>{       
                     swal(
                      package_det.status,
                      package_det.message,
                      package_det.status
                    )
                     this.router.navigate(['/manageads']);
                    
                });
           }
            else{
              swal('',response.data,'Oops!');
            }
         })
     }
     else{
         this.CommonService.insertdata(this.uploaduserAdvApi,this.model1)
      .subscribe( (response) => {
         if(response.status=='success')
           {
            this.model.uploads = response.data;
          delete this.model.formEnable;
              this.CommonService.updatedata(this.updateadRestApiUrl,this.model)
                .subscribe(package_det =>{       
                     swal(
                      package_det.status,
                      package_det.message,
                      package_det.status
                    )
                     this.router.navigate(['/manageads']);
                    
                });
          }
       })
     }
    

     
  }

   fileChangeEvent(event: any): void {
        this.imageChangedEvent = event;
        this.Istypecheck==2;
    }
  imageCropped(event: ImageCroppedEvent) {
      this.Istypecheck==2;
        this.croppedImage = event.base64;
        this.model1.Imagefile = event.base64;
        


    }
  back(){
    this.router.navigate(['/manageads']); 
  }

}
