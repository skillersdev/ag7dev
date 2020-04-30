import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule,ActivatedRoute}  from '@angular/router';

import { AppComponent } from '../../../app.component';

import { TopnavComponent } from '../../../topnav/topnav.component';
import { SidemenuComponent } from '../../../sidemenu/sidemenu.component';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { AppSettings } from '../../../appSettings';
import { LoginService } from '../../../services/login.service';
import { CommonService } from '../../../services/common.service';
import { ImageCroppedEvent } from 'ngx-image-cropper';
declare var jquery:any;
declare var $ :any; 
import { Injectable } from '@angular/core'; 

@Component({
  selector: 'app-editpremiumpackage',
  templateUrl: './editpremiumpackage.component.html',
  // styleUrls: ['./editpremiumpackage.component.css']
})
export class EditpremiumpackageComponent implements OnInit {

  constructor(private loginService: LoginService,private CommonService: CommonService,private route: ActivatedRoute,private router: Router,private http:Http) { 
    document.body.className="theme-red";
  } 
  id:any;
  model:any={};
  ngOnInit() {
    this.loginService.localStorageData();
    this.loginService.viewsActivate();

    this.route.params.subscribe(params => {
      this.id = +params['id']; // (+) converts string 'id' to a number
      this.editpremium(this.id);        
      });

  }
  editpremium(id:any)
  {
    this.CommonService.editdata(AppSettings.Editpremium,id)
    .subscribe(resultdata =>{   
      this.model = resultdata.result;
      this.model.previoustype = this.model.type;         
    });
  }

  update_premium()
  {
    this.CommonService.updatedata(AppSettings.updatePremium,this.model)
      .subscribe( (response) => {
         if(response)
         { 
            swal(
              response.status,
              response.message,
              response.status  
            )
            this.router.navigate(['/premiumsettings']);
        }
     })
  }

}
