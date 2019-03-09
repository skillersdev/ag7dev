import { Component,OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';
import { AppComponent } from '../app.component';
import { TopnavComponent } from '../topnav/topnav.component';
import { SidemenuComponent } from '../sidemenu/sidemenu.component';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { AppSettings } from '../appSettings';
import { LoginService } from '../services/login.service';
import { CommonService } from '../services/common.service';
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
  image_url = AppSettings.IMAGE_BASE;
 
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router,private http:Http) { 
      document.body.className="theme-red"; 

  }

  ngOnInit() {
    this.loginService.localStorageData();
    this.loginService.viewsActivate();
    // this.model.fname = localStorage.getItem('user_fname');
    // this.model.email = localStorage.getItem('email');
    // this.model.address = localStorage.getItem('address');
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
   fileEvent($event) {
    const fileSelected: File = $event.target.files[0];
    
    this.CommonService.uploadFile(this.uploaduserProfileApi,fileSelected)
    .subscribe( (response) => {
       if(response.status=='success')
       {
        this.model.image_url = response.data;
       }
        else{
          swal('',"Error while on upload photo",'Oops!');
          
          //this.toastr.errorToastr(response.data, 'Oops!');
        }
     })
   }
}
