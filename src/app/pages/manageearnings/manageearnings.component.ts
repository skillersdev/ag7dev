import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';

import { AppComponent } from '../../app.component';

import { TopnavComponent } from '../../topnav/topnav.component';
import { SidemenuComponent } from '../../sidemenu/sidemenu.component';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { AppSettings } from '../../appSettings';
import { LoginService } from '../../services/login.service';
import { CommonService} from '../../services/common.service';
declare var jquery:any;
declare var $ :any;
import { Injectable } from '@angular/core';

@Component({
  selector: 'app-manageuser',
  templateUrl: './manageearnings.component.html',
  styleUrls: ['./manageuser.component.css']
})
export class ManageearningsComponent implements OnInit {

  currentUser:any;
  currentUserID:any;
  currentUsername:any;
  currentUsergroup:any;
  currentUserStatus:any;
  currentAllUsers:any;
  model: any = {};
  alldata: any = {};
  userlist:Array<Object>;
  getuserlistRestApiUrl:string=AppSettings.getearningslist;
  DeleteuserRestApiUrl:string = AppSettings.deleteuser; 
  DeleteearningsRestApiUrl:string = AppSettings.deleteearnings; 
  constructor(
    private loginService: LoginService,
    private CommonService:CommonService,
    private router: Router,
    private http:Http) { 
      document.body.className="theme-red";

  }

  ngOnInit() {
    this.loginService.localStorageData();
    this.loginService.viewsActivate();
    this.CommonService.getdata(this.getuserlistRestApiUrl)
    .subscribe(userdet =>{
        if(userdet.result!="")  
        { 
          this.userlist= userdet.result;
        } 
         
    });
  }
  
  logout(){
    this.loginService.logout();
  }

  navigateAddearnings()
  {
    this.router.navigate(['/addearnings']);
  }
  editearnings(id:any)
  {
    this.router.navigate(['/editearnings', id]);
  }
  deleteearnings(id:any)
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
        self.removeuser(idx);
        swal(
          'Deleted!',
          'Eaarnings has been deleted.',
          'success'
        )
      },function(dismiss) {
  // dismiss can be "cancel" | "close" | "outside"
});
 }
 removeuser(idx:any)
 {
   this.CommonService.deletedata(this.DeleteearningsRestApiUrl,idx)
        .subscribe(resultdata =>{
           this.CommonService.getdata(this.getuserlistRestApiUrl)
        .subscribe(packagedet =>{
            if(packagedet.result!="")
            { 
              this.userlist= packagedet.result;
            } 
             
        });
      });
 }

}
