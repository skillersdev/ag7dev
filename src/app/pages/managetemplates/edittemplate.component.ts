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
  selector: 'app-editpackage',
  templateUrl: './edittemplate.component.html'
})
export class EdittemplateComponent implements OnInit {

  currentUser:any;
  currentUserID:any;
  currentUsername:any;
  currentUsergroup:any;
  currentUserStatus:any;
  currentAllUsers:any;
  FetchtemplateRestApiUrl: string = AppSettings.Edittemplate; 
  updateuserRestApiUrl: string = AppSettings.Updatetemp; 
  getpackagelistRestApiUrl:string = AppSettings.getPackageDetail; 
  checkUserRestApiUrl:string = AppSettings.checkuserdetail; 
  getwebsiteRestApiUrl:string = AppSettings.getwebsitelist;
  uploaduserAdvApi:string=AppSettings.uploadTempfile;
  showbutton:boolean=true;
  Iserror:boolean=true;
  model: any = {};
  image_url = AppSettings.IMAGE_BASE;
   select: any;
  packagelist:Array<Object>;
  websitelist:Array<Object>;
  alldata: any = {};
  private sub: any;
  id:number;
  stage_of_packages:Array<Object>;stage_of_packages_prev:Array<Object>;

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

        this.model.usertype=localStorage.getItem('currentUsergroup');
        this.model.userid=localStorage.getItem('currentUserID');
      
         this.CommonService.insertdata(this.getwebsiteRestApiUrl,this.model)
        .subscribe(package_det =>{       
          if(package_det.result!=""){ this.websitelist=package_det.result;}
        });  

       this.CommonService.getdata(this.getpackagelistRestApiUrl)
        .subscribe(packagedet =>{
            if(packagedet.result!="")
            { 
              this.packagelist= packagedet.result;
            } 
            console.log(this.packagelist); 
        });

      this.sub = this.route.params.subscribe(params => {
        this.id = +params['id']; // (+) converts string 'id' to a number
        this.edituser(this.id);
        
        });
  }
  
  logout(){
    this.loginService.logout();
  }
  back(){
    this.router.navigate(['/managetemplates']);
  }
  edituser(id:any)
  {
    
    this.CommonService.editdata(this.FetchtemplateRestApiUrl,id)
        .subscribe(resultdata =>{   
          this.model = resultdata.result;
          console.log(this.model);
        });
  }
  updatetemp()
  {
     this.CommonService.updatedata(this.updateuserRestApiUrl,this.model)
    .subscribe(package_det =>{       
         swal(
          package_det.status,
          package_det.message,
          package_det.status
        )
         this.router.navigate(['/managetemplates']);
        
    });
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
  fileEvent($event) {
    const fileSelected: File = $event.target.files[0];
    this.showbutton=false;
    $('.preloader').show();
    this.CommonService.uploadFile(this.uploaduserAdvApi,fileSelected)
    .subscribe( (response) => {
       if(response.status=='success')
       {
        this.model.slider_image = response.data;
        $('.preloader').hide();
        this.showbutton=true;
         this.Iserror = true;
       }
        else{
          $('.preloader').hide();
          this.showbutton=true;
           this.Iserror = false;
          swal('',response.data,'error'); 
        }
     })
  }
}