import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';

import { AppComponent } from '../../app.component';

import { TopnavComponent } from '../../topnav/topnav.component';
import { SidemenuComponent } from '../../sidemenu/sidemenu.component';

import { CommonService } from '../../services/common.service';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { AppSettings } from '../../appSettings';
import { LoginService } from '../../services/login.service';
declare var jquery:any;
declare var $ :any;
import { Injectable } from '@angular/core';
@Component({
  selector: 'app-managecontacts',
  templateUrl: './managecontacts.component.html',
  styleUrls: ['./managecontacts.component.css']
})
export class ManagecontactsComponent implements OnInit {
  getcontactlistRestApiUrl:string = AppSettings.getcontactDetail; 
  DeletecontactRestApiUrl:string = AppSettings.deletecontact; 
  contactlist:Array<Object>;

  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router,private http:Http) { }

  ngOnInit() {
    this.loginService.localStorageData();
     this.loginService.viewsActivate();
     this.CommonService.getdata(this.getcontactlistRestApiUrl)
        .subscribe(det =>{
            if(det.result!="")
            { 
              this.contactlist=det.result;
            }   
             
        });
  }
  navigateAddcontact()
  {
    this.router.navigate(['/addcontact']);
  }
   editcontact(id:any)
  {
     this.router.navigate(['/editcontact', id]);
  }
  deletecontact(id:any)
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
        self.removecontact(idx);
        swal(
          'Deleted!',
          'Package Data has been deleted.',
          'success'
        )
      },function(dismiss) {
    });
  }
 removecontact(idx:any)
 {
   this.CommonService.deletedata(this.DeletecontactRestApiUrl,idx)
        .subscribe(resultdata =>{
          this.CommonService.getdata(this.getcontactlistRestApiUrl)
        .subscribe(det =>{
            if(det.result!="")
            { 
              this.contactlist=det.result;
            }   
             
        });
      });
 }
}
