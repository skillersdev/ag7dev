import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';

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
  selector: 'app-addmall',
  templateUrl: './addmall.component.html'
})
export class AddmallComponent implements OnInit {

  model: any = {};
  select:any;
  malltypeid:any;
  insertmallRestApiUrl: string = AppSettings.Addmall; 
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router,private http:Http) { 
      document.body.className="theme-red";

  }

  ngOnInit() {
    
    this.malltypeid = localStorage.getItem('malltypeid');  
    this.model.usergroup=localStorage.getItem('currentUsergroup');
    if(this.malltypeid==null){
      this.model.created_by=localStorage.getItem('currentUserID');
    } else{
      this.loginService.malllocalStorageData();  
     this.model.created_by = localStorage.getItem('mallcurrentUser'); 
     
    }
      this.loginService.viewsActivate();
  }
  
  logout(){
    this.loginService.logout();
  }
  addmalllist()
  {
    // this.model.created_by=localStorage.getItem('currentUserID');
    this.CommonService.insertdata(this.insertmallRestApiUrl,this.model)
    .subscribe(package_det =>{       
         swal(
          package_det.status,
          package_det.message,
          package_det.status
        )
        this.router.navigate(['/mall/managemall']); 
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
                 
               })
                // var reader = new FileReader();
                // this.msgfileEvent(event);
                // reader.onload = (event:any) => {
                //   console.log(event.target.result);
                //    this.urls.push(event.target.result); 
                // }
                
                // reader.readAsDataURL(event.target.files[i]);
        }
    }
  }

  back(){
    this.router.navigate(['/mall/managemall']);
  }

}
