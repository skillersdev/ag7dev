import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';

import { AppComponent } from '../../app.component';

import { TopnavComponent } from '../../topnav/topnav.component';
import { SidemenuComponent } from '../../sidemenu/sidemenu.component';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { AppSettings } from '../../appSettings';
import { LoginService } from '../../services/login.service';
import { CommonService } from '../../services/common.service';
import swal from 'sweetalert';
declare var jquery:any;
declare var $ :any;
import { Injectable } from '@angular/core';

@Component({
  selector: 'app-managepackages',
  templateUrl: './managepackages.component.html',
  styleUrls: ['./managepackages.component.css']
})
export class ManagepackagesComponent implements OnInit {
  currentUser:any;
  currentUserID:any;
  currentUsername:any;
  currentUsergroup:any;
  currentUserStatus:any;
  currentAllUsers:any;
  packagelist:Array<Object>;
  getpackagelistRestApiUrl:string = AppSettings.getPackageDetail; 
  getPackagelistbyAdmin:string= AppSettings.getPackagelistbyAdmin; 
  DeletepackageRestApiUrl:string = AppSettings.deletepackage; 
  model: any = {};
  alldata: any = {};

  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router,private http:Http) { }

  ngOnInit() {
    this.loginService.localStorageData();
     this.loginService.viewsActivate();
       this.model.usergroup=localStorage.getItem('currentUsergroup');
        if(this.model.usergroup==2)
        {
          this.loginService.logout();
        }
      this.CommonService.getdata(this.getPackagelistbyAdmin)
        .subscribe(packagedet =>{
            if(packagedet.result!="")
            { 
              this.packagelist= packagedet.result;
            } 
             
        });
 }
 
 logout(){
   this.loginService.logout();
 }
 navigateAddpackage()
 {
   this.router.navigate(['/addpackage']);
 }
 editpackage(id:any)
 {
   console.log("here"+id);
   this.router.navigate(['/editpackage', id]);
 }
 deletepackage(id:any)
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
           self.removepackage(idx);
          swal(
            'Deleted!',
            'Package Data has been deleted.',
            'success'
          )
        }       
      },function(dismiss) {
  // dismiss can be "cancel" | "close" | "outside"
});
 }
 removepackage(idx:any)
 {
   this.CommonService.deletedata(this.DeletepackageRestApiUrl,idx)
        .subscribe(resultdata =>{
           this.CommonService.getdata(this.getpackagelistRestApiUrl)
        .subscribe(packagedet =>{
            if(packagedet.result!="")
            { 
              this.packagelist= packagedet.result;
            } 
             
        });
      });
 }
}
