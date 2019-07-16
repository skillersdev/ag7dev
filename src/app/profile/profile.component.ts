import { Component,OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';
import { AppComponent } from '../app.component';
import { TopnavComponent } from '../topnav/topnav.component';
import { SidemenuComponent } from '../sidemenu/sidemenu.component';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import {  AppSettings } from '../appSettings';
import { LoginService } from '../services/login.service';
import { CommonService } from '../services/common.service';
import { ImageCroppedEvent } from 'ngx-image-cropper';
import {ImageCropperComponent, CropperSettings} from 'ng2-img-cropper';
declare var jquery:any;
declare var $ :any;
import { Injectable } from '@angular/core';

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.css']
})
export class ProfileComponent implements OnInit {

  currentUser:any;
  currentUserID:any;
  currentUsername:any;
  currentUsergroup:any;
  currentUserStatus:any;
  currentAllUsers:any;   
  updateuserprofileRestApiUrl: string = AppSettings.Updateuserprofile;
  uploaduserProfileApi:string=AppSettings.uploadprofileimage;
  updatepasswordRestApiUrl: string = AppSettings.Updatepassword;
  FetchuserRestApiUrl: string = AppSettings.Edituser;  
  model: any = {};
  alldata: any = {};
  resultdata:any={};
  model1:any={};
   cropperSettings: CropperSettings;
  
  image_url = AppSettings.IMAGE_BASE;
  imageChangedEvent: any = '';
    croppedImage: any = '';

 
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router,private http:Http) { 
      document.body.className="theme-red"; 
      this.cropperSettings = new CropperSettings();
    this.cropperSettings.noFileInput = true;
  }

  ngOnInit() {
    this.loginService.localStorageData();
    this.loginService.viewsActivate();
    // this.model.fname = localStorage.getItem('user_fname');
   
    this.model.id = localStorage.getItem('currentUserID');
     this.CommonService.editdata(this.FetchuserRestApiUrl,this.model.id)
        .subscribe(resultdata =>{   
          this.model = resultdata.result;
        });
  }

  logout(){
    this.loginService.logout();
  }
  update_profile()
  {
    this.CommonService.insertdata(AppSettings.uploadcropimage,this.model1)
        .subscribe(response =>{       
            //swal(response.status,response.message,response.status)
            if(response.data)
            {
              this.model.image_url = response.data;

               this.CommonService.updatedata(this.updateuserprofileRestApiUrl,this.model)
                .subscribe(package_det =>{       
                     swal(
                      package_det.status,
                      package_det.message,
                      package_det.status
                    )
                     this.router.navigate(['/profile']);
                    
                });
            }
            else{
              swal(response.status,response.message,response.status)
            }
        });
    
  }
  passwordMatch()
   {
     this.model.passwordmatch=false;
     if((this.model.password!='')&&(this.model.confirmp!=''))
     {
        console.log(this.model);
       if(this.model.password!=this.model.confirmp)
       {
         this.model.passwordmatch = true;

       }
     }
   }
   updatepassword()
   {
     this.resultdata.password =this.model.password;
     this.resultdata.id =localStorage.getItem('currentUserID');
     this.CommonService.updatedata(this.updatepasswordRestApiUrl,this.resultdata)
    .subscribe(package_det =>{       
         swal(
          package_det.status,
          package_det.message,
          package_det.status
        )
         this.router.navigate(['/profile']);
        
    });
   }
   // fileEvent(event:any) {
   //   this.imageChangedEvent = event;

    // const fileSelected: File = $event.target.files[0];
    // $('.preloader').show();
    // this.CommonService.uploadFile(this.uploaduserProfileApi,fileSelected)
    // .subscribe( (response) => {
    //    if(response.status=='success')
    //    {
    //     this.model.image_url = response.data;
    //     $('.preloader').hide();
    //    }
    //     else{
    //       swal('',"Error while on upload photo",'Oops!');
          
    //       //this.toastr.errorToastr(response.data, 'Oops!');
    //     }
    //  })
   //}
   // imageCropped(event: File,$event) {
   //     // this.croppedImage = event.base64;
   //      console.log(event);
   //       const fileSelected = event.file;
   //        $('.preloader').show();
   //        this.CommonService.uploadFile(this.uploaduserProfileApi,fileSelected)
   //        .subscribe( (response) => {
   //           if(response.status=='success')
   //           {
   //            this.model.image_url = response.data;
   //            $('.preloader').hide();
   //           }
   //            else{
   //              swal('',"Error while on upload photo",'Oops!');
                
   //              //this.toastr.errorToastr(response.data, 'Oops!');
   //            }
   //         })
   //  }

  //   fileChangeListener($event) {
  //   var image:any = new Image();
  //   var file:File = $event.target.files[0];
  //   console.log(file);
  //   var myReader:FileReader = new FileReader();
  //   var that = this;
  //   myReader.onloadend = function (loadEvent:any) {
  //       image.src = loadEvent.target.result;
  //   }; 
  //  // myReader.readAsDataURL(file);
  // }


  fileChangeEvent(event: any): void {
        this.imageChangedEvent = event;
    }
  imageCropped(event: ImageCroppedEvent) {
        this.croppedImage = event.base64;
        this.model1.Imagefile = event.base64;

    }
}
