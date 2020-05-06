import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';

import { AppComponent } from '../app.component';

import { TopnavComponent } from '../topnav/topnav.component';
import { SidemenuComponent } from '../sidemenu/sidemenu.component';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { AppSettings } from '../appSettings';
import { LoginService } from '../services/login.service';
import { CommonService} from '../services/common.service';
import Swal from 'sweetalert2'
declare var jquery:any;
declare var $ :any;
import { Injectable } from '@angular/core';
@Component({
  selector: 'app-premiumrequestvideos',
  templateUrl: './premiumrequestvideos.component.html',
  styleUrls: ['./premiumrequestvideos.component.css']
})
export class PremiumrequestvideosComponent implements OnInit {

  constructor(
    private loginService: LoginService,
    private CommonService:CommonService,
    private router: Router,
    private http:Http) { 
      document.body.className="theme-red";

  }
  videolist:Array<Object>;
  model:any={};
  ngOnInit() {
    this.loginService.localStorageData();
    this.loginService.viewsActivate();
    this.videolist=[];
    this.model.userid = localStorage.getItem('currentUserID')
    this.CommonService.insertdata(AppSettings.getpremiumrequestvideos,this.model)
      .subscribe(resultdata =>{   
        if(resultdata.status=='success')
        { 
          this.videolist=resultdata.data[0];
          
          // this.categoryDet=resultdata.category_name;
          this.loginService.viewCommontdataTable('videosdataTable','videosdataTable');
      }
    });
  }
  acceptrequest(videoId:any)
  {
    this.model.Isaccept=1;
    this.model.videoId=videoId;
    this.saverequest();
  }
  cancelrequest(videoId:any)
  {
    this.model.Isaccept=0;
    this.model.videoId=videoId;
    this.saverequest();
  }
  saverequest()
  {
    this.CommonService.insertdata(AppSettings.savepremiumrequest,this.model)
    .subscribe(data =>{
      if(data.status=="success")  
      {
        swal('',data.message,'success');
        
      } else{
        swal('','Errow while on upgrading premium','error');
      } 
      this.CommonService.insertdata(AppSettings.getpremiumrequestvideos,this.model)
      .subscribe(resultdata =>{   
        if(resultdata.status=='success')
        { 
          this.videolist=resultdata.data[0];
         
      }
    });   
    });
  }
  navigateTodetails(id:any)
  {
    localStorage.setItem('transactionvideoid',id);
    this.router.navigate(['/premiumtransactiondetails']);
  }
}
