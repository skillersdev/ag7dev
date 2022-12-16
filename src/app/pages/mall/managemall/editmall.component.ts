import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule,ActivatedRoute}  from '@angular/router';

import { AppComponent } from '../../../app.component';

import { TopnavComponent } from '../../../topnav/topnav.component';
import { SidemenuComponent } from '../../../sidemenu/sidemenu.component';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { AppSettings } from '../../../appSettings';
import { LoginService } from '../../../services/login.service';
import { CommonService } from '../../../services/common.service';
declare var jquery:any;
declare var $ :any; 
import { Injectable } from '@angular/core';  

@Component({
  selector: 'app-editmall',
  templateUrl: './editmall.component.html'
})
export class EditmallComponent implements OnInit {

  
  private sub: any;
  model: any = {};
  id:number;
  select:any;
  malltypeid:any;
  insertmallRestApiUrl: string = AppSettings.Addmall; 
  FetchmallRestApiUrl: string = AppSettings.editmall; 
  updatemallRestApiUrl: string = AppSettings.updatemall;
  getwebsiteRestApiUrl:string = AppSettings.getwebsitelist;  
  constructor(private loginService: LoginService,private CommonService: CommonService,private route: ActivatedRoute,private router: Router,private http:Http) { 
      document.body.className="theme-red";

  }

  ngOnInit() {
    // this.loginService.malllocalStorageData();
      this.loginService.viewsActivate();
      this.malltypeid = localStorage.getItem('malltypeid');  
      this.model.usergroup=localStorage.getItem('currentUsergroup');
      if(this.malltypeid==null){
        this.model.created_by=localStorage.getItem('currentUserID');
      } else{
        this.loginService.malllocalStorageData();  
       this.model.created_by = localStorage.getItem('mallcurrentUser'); 
       
      }
      
      this.sub = this.route.params.subscribe(params => {
        this.id = +params['id']; // (+) converts string 'id' to a number
        this.editmall(this.id);        
        });
  }
  
  logout(){
    this.loginService.logout();
  }
  
  editmall(id:any)
  {
    this.CommonService.editdata(this.FetchmallRestApiUrl,id)
        .subscribe(resultdata =>{   
          this.model = resultdata.result;         
        });
  }
  onSelectFile(event) {
    if (event.target.files && event.target.files[0]) {
        var filesAmount = event.target.files.length;
        for (let i = 0; i < filesAmount; i++) {

          const fileSelected: File = event.target.files[i];
          
              this.CommonService.chatuploadFile(AppSettings.imageupload,fileSelected)
              .subscribe( (response) => {
                // this.urls.push(response.data);
                this.model.image_name=response.data;
                console.log("onSelectFile-->",this.model.image_name);
                 
               })
               
        }
    }
  }

  updatemalllist()
  {
     //this.model.is_deleted=1
     console.log("updatemalllist-->",this.model);
     this.CommonService.updatedata(this.updatemallRestApiUrl,this.model)
    .subscribe(package_det =>{       
         swal(
          package_det.status,
          package_det.message,
          package_det.status
        )
         this.router.navigate(['/mall/managemall']);
        
    });
  }
 
  back(){
    this.router.navigate(['/mall/managemall']);
  }

}
