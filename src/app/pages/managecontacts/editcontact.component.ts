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
  templateUrl: './editcontact.component.html'
})
export class EditcontactComponent implements OnInit {

  currentUser:any;
  currentUserID:any;
  currentUsername:any;
  currentUsergroup:any;
  currentUserStatus:any;
  currentAllUsers:any;
  private sub: any;
  model: any = {};
  model1: any = {};
  select: any;
  alldata: any = {};
  imageChangedEvent: any = '';
    croppedImage: any = '';
  id:number;
  websitelist:Array<Object>;
  contactloglist:Array<Object>;
  insertcategoryRestApiUrl: string = AppSettings.Addcategory; 
  FetchcategoryRestApiUrl: string = AppSettings.editcategory; 
  updatecontactRestApiUrl: string = AppSettings.updatecontact;
  getwebsiteRestApiUrl:string = AppSettings.getwebsitelist;  
  FetchcontactRestApiUrl:string = AppSettings.getcontactlistbyid;
  uploaduserProfileApi:string=AppSettings.uploadprofileimage;
  uploaduserAdvApi:string=AppSettings.uploadcropimage;  
  image_url = AppSettings.IMAGE_BASE;
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
        this.editcontact(this.id);        
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
        this.router.navigate(['/managecontacts']); 
    });
  }
  editcontact(id:any)
  {
    this.CommonService.editdata(this.FetchcontactRestApiUrl,id)
        .subscribe(resultdata =>{   
          this.model = resultdata.result; 
          this.contactloglist = resultdata.result.log_result;         
        });
  }
  updatecontactlist()
  {
     this.CommonService.updatedata(this.updatecontactRestApiUrl,this.model)
    .subscribe(contact_det =>{       
        if(contact_det.exist==1)
        {
          swal(
            'error',
            contact_det.message,
            'error'
          )
        }
        else{
           swal(
            contact_det.status,
            contact_det.message,
            contact_det.status
          )
           this.router.navigate(['/managecontacts']);
        }
         
        
    });
  }
  fileEvent($event) {
    const fileSelected: File = $event.target.files[0];
    $('.preloader').show();
    this.CommonService.uploadFile(this.uploaduserProfileApi,fileSelected)
    .subscribe( (response) => {
       if(response.status=='success')
       {
        this.model.website_image = response.data;
        $('.preloader').hide();
       }
        else{
          swal('',"Error while on upload photo",'Oops!');
        }
     })
   }
  back(){
    this.router.navigate(['/managecontacts']);
  }
  deletecontactimage(id:any)
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
          self.removelogimages(idx);
         
        }        
      },function(dismiss) {
    });
  }
 removelogimages(idx:any)
 {
   this.CommonService.deletedata(AppSettings.DeletelogimagesRestApiUrl,idx)
        .subscribe(resultdata =>{
          
          if(resultdata!="")
          {
            swal('Deleted!','Data has been deleted.','success');
            this.ngOnInit();
           
          } 

      });
 }
  fileChangeEvent(event: any): void {
        this.imageChangedEvent = event;
    }
  imageCropped(event: ImageCroppedEvent) {
        this.croppedImage = event.base64;
        this.model1.Imagefile = event.base64;
        this.CommonService.insertdata(this.uploaduserAdvApi,this.model1)
      .subscribe( (response) => {
         if(response.status=='success')
         {
          this.model.website_image = response.data;
        }
     })


    }
}
