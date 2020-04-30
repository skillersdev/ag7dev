import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';

import { AppComponent } from '../../../app.component';

import { TopnavComponent } from '../../../topnav/topnav.component';
import { SidemenuComponent } from '../../../sidemenu/sidemenu.component';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { AppSettings } from '../../../appSettings';
import { LoginService } from '../../../services/login.service';
import { ImageCroppedEvent } from 'ngx-image-cropper';
import { CommonService } from '../../../services/common.service';
declare var jquery:any;
declare var $ :any;
import { Injectable } from '@angular/core';

@Component({
  selector: 'app-addpremiumpackage',
  templateUrl: './addpremiumpackage.component.html',
  // styleUrls: ['./addpremiumpackage.component.css']
})
export class AddpremiumpackageComponent implements OnInit {

  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router,private http:Http) { 
    document.body.className="theme-red";

}
  model:any={};
  ngOnInit() {

    this.model.created_by=localStorage.getItem('currentUserID');
  }
  add_premium()
  {
    this.CommonService.insertdata(AppSettings.addpremiumpackage,this.model)
    .subscribe( (response) => {
        swal(
          response.status,
          response.message,
          response.status
        )
        this.router.navigate(['/premiumsettings']); 
    });
  }
}
