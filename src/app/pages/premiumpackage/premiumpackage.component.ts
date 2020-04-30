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
  selector: 'app-premiumpackage',
  templateUrl: './premiumpackage.component.html',
  // styleUrls: ['./premiumpackage.component.css']
})
export class PremiumpackageComponent implements OnInit {

  constructor(
    private loginService: LoginService,
    private CommonService:CommonService,
    private router: Router,
    private http:Http) { 
      document.body.className="theme-red";

  }

  model:any={};
  premiumlist:Array<Object>;
  ngOnInit() {
    this.loginService.localStorageData();
    this.loginService.viewsActivate();
    this.model.usergroup=localStorage.getItem('currentUsergroup');
    this.premiumlist = [];
    if(this.model.usergroup==2)
    {
      this.loginService.logout();
    }
    this.CommonService.insertdata(AppSettings.getpremiumpackagesettings,this.model)
    .subscribe(data =>{
        if(data.status="success")  
        { 
          this.premiumlist= data.result;
          console.log(this.premiumlist);
          this.loginService.viewCommontdataTable('dataTable','premiumdataTable'); 
        } 
       else{
        this.loginService.viewCommontdataTable('dataTable','premiumdataTable'); 
       }
    });
  }
  navigateAddPremiumPackage()
  {
    this.router.navigate(['/addpremium']);
  }
  editpremium(id:any)
  {
    this.router.navigate(['/editpremium',id]);
  }
  deletepremium(id:any)
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
          self.removeservice(idx);
          swal(
            'Deleted!',
            'Premium Data has been deleted.',
            'success'
          );
        }
      },function(dismiss) {
    });
  }
 removeservice(idx:any)
 {
   this.CommonService.deletedata(AppSettings.Deletepremiumpackage,idx)
    .subscribe(resultdata =>{
      this.CommonService.insertdata(AppSettings.getpremiumpackagesettings,this.model)
      .subscribe(data =>{
        if(data.status="success")  
        { 
          this.premiumlist= data.result;
        } 
      });
    });
 }

}
