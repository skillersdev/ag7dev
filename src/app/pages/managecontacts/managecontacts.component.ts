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
  getcontactbyUserRestApiUrl:string = AppSettings.getcontactbyid; 
  contactlist:Array<Object>;
  model:any={};

  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router,private http:Http) { }

  ngOnInit() {
    this.loginService.localStorageData();
     this.loginService.viewsActivate();
       let user_id = localStorage.getItem('currentUserID');
    this.model.usergroup=localStorage.getItem('currentUsergroup');
    if(this.model.usergroup==2)
    {

      this.CommonService.editdata(this.getcontactbyUserRestApiUrl,user_id)
        .subscribe(det =>{   
          this.contactlist=det.result;
          this.loginService.viewCommontdataTable('contactdataTable','contactdataTable');
        });
    
      }
      else{
         this.CommonService.getdata(this.getcontactlistRestApiUrl)
        .subscribe(det =>{
            if(det.result!="")
            { 
              this.contactlist=det.result;
              this.loginService.viewCommontdataTable('contactdataTable','contactdataTable');
            }   
             
        });
      }
    
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
        if(result)
        {
           self.removecontact(idx);
            swal(
              'Deleted!',
              'Package Data has been deleted.',
              'success'
            )
          }       
      },function(dismiss) {
    });
  }
 removecontact(idx:any)
 {
   this.CommonService.deletedata(this.DeletecontactRestApiUrl,idx)
        .subscribe(resultdata =>{
        this.ngOnInit();
      });
 }
}
