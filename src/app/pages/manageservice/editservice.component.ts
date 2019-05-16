import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule,ActivatedRoute}  from '@angular/router';

import { AppComponent } from '../../app.component';

import { TopnavComponent } from '../../topnav/topnav.component';
import { SidemenuComponent } from '../../sidemenu/sidemenu.component';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { AppSettings } from '../../appSettings';
import { LoginService } from '../../services/login.service';
import { CommonService } from '../../services/common.service';
declare var jquery:any;
declare var $ :any; 
import { Injectable } from '@angular/core';  

@Component({
  selector: 'app-manageuser',
  templateUrl: './editservice.component.html'
})
export class EditserviceComponent implements OnInit {

  currentUser:any;
  currentUserID:any;
  currentUsername:any;
  currentUsergroup:any;
  currentUserStatus:any;
  currentAllUsers:any;
  image_url = AppSettings.IMAGE_BASE;
  private sub: any;
  model: any = {};
  select: any;
  alldata: any = {};
  id:number;
  insertcategoryRestApiUrl: string = AppSettings.Addcategory; 
  FetchserviceRestApiUrl: string = AppSettings.getservicebyid; 
  updateserviceRestApiUrl: string = AppSettings.updateservice; 
  uploaduserProfileApi:string=AppSettings.uploadserviceimage; 
  websitelist:Array<Object>;
  getwebsiteRestApiUrl:string = AppSettings.getwebsitelist;  
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
        this.editservice(this.id);        
        });
  }
  
  logout(){
    this.loginService.logout();
  }
 
  editservice(id:any)
  {
    this.CommonService.editdata(this.FetchserviceRestApiUrl,id)
        .subscribe(resultdata =>{   
          this.model = resultdata.result;         
        });
  }

    fileEvent($event) {
    const fileSelected: File = $event.target.files[0];
    
    this.CommonService.uploadFile(this.uploaduserProfileApi,fileSelected)
    .subscribe( (response) => {
       if(response.status=='success')
       {
        this.model.service_image = response.data;
       }
        else{
          swal('',"Error while on upload photo",'Oops!');
          
          //this.toastr.errorToastr(response.data, 'Oops!');
        }
     })
   }

  update_service()
  {
     //this.model.is_deleted=1
     this.CommonService.updatedata(this.updateserviceRestApiUrl,this.model)
    .subscribe(package_det =>{       
         swal(
          package_det.status,
          package_det.message,
          package_det.status
        )
         this.router.navigate(['/manageservices']);
        
    });
  }
  back(){
    this.router.navigate(['/manageservices']);
  }

}
