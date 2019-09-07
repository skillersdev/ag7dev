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
  templateUrl: './managevideo.component.html',
  //styleUrls: ['./manageuser.component.css']
})
export class ManagevideoComponent implements OnInit {
 websiteurl:string=AppSettings.API_BASE;
  currentUser:any;
  currentUserID:any;
  currentUsername:any;
  currentUsergroup:any;
  currentUserStatus:any;
  currentAllUsers:any;
  model: any = {};
  alldata: any = {};
  videolist:Array<Object>;
  datalist:Array<Object>;
  getuserlistRestApiUrl:string=AppSettings.getuserslist;
  DeleteuserRestApiUrl:string = AppSettings.deleteuser; 
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
     this.model.usergroup=localStorage.getItem('currentUsergroup');
        if(this.model.usergroup==2)
        {
          this.model.userid = localStorage.getItem('currentUserID');
          this.CommonService.insertdata(AppSettings.getvideolistbywebsiteApiUrl,this.model)
            .subscribe(resultdata =>{   
             if(resultdata.result!='')
             { 
               this.videolist=resultdata.result;
               
               // this.categoryDet=resultdata.category_name;
               //this.loginService.viewCommontdataTable('dataTable','productinfo_table');
            }
          });
        }
       
  }
  
  logout(){
    this.loginService.logout();
  }

  navigateAddvideo()
  {
    this.router.navigate(['/addvideos']);
  }
  editvideo(id:any)
  {
    console.log(id);
    this.router.navigate(['/editvideos', id]);
  }
  deletevideo(id:any)
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
          self.removeuser(idx);
          swal(
            'Deleted!',
            'User Data has been deleted.',
            'success'
          );
        }
      },function(dismiss) {
  // dismiss can be "cancel" | "close" | "outside"
});
 }
 removeuser(idx:any)
 {
   this.CommonService.deletedata(AppSettings.Deletevideosection,idx)
        .subscribe(resultdata =>{
          this.ngOnInit();
      });
 }

}
