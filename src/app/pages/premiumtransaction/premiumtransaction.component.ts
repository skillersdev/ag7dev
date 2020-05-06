import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';

import { AppComponent } from '../../app.component';

import { TopnavComponent } from '../../topnav/topnav.component';
import { SidemenuComponent } from '../../sidemenu/sidemenu.component';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { AppSettings } from '../../appSettings';
import { LoginService } from '../../services/login.service';
import { CommonService} from '../../services/common.service';
import Swal from 'sweetalert2'
declare var jquery:any;
declare var $ :any;
import { Injectable } from '@angular/core';

@Component({
  selector: 'app-premiumtransaction',
  templateUrl: './premiumtransaction.component.html',
  styleUrls: ['./premiumtransaction.component.css']
})
export class PremiumtransactionComponent implements OnInit {
  transactiondetails:Array<Object>;
  model:any={};
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
    this.transactiondetails=[];
    this.model.userid = localStorage.getItem('currentUserID')
    this.model.videoId =localStorage.getItem('transactionvideoid');
    this.CommonService.insertdata(AppSettings.getpremiumtransactiondetails,this.model)
      .subscribe(resultdata =>{   
       
          this.transactiondetails=resultdata.data;
          // this.categoryDet=resultdata.category_name;
          this.loginService.viewCommontdataTable('videosdataTable','videosdataTable');
    });
  }

}
