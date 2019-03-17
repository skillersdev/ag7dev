import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule,ActivatedRoute}  from '@angular/router';

import { AppComponent } from '../../app.component';

import { TopnavComponent } from '../../topnav/topnav.component';
import { SidemenuComponent } from '../../sidemenu/sidemenu.component';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { AppSettings } from '../../appSettings';
import { LoginService } from '../../services/login.service';
import { CommonService } from '../../services/common.service';
declare var jquery:any;
declare var $ :any; 
import { Injectable } from '@angular/core';  

@Component({
  selector: 'app-manageuser',
  templateUrl: './editcategory.component.html'
})
export class EditcategoryComponent implements OnInit {

  currentUser:any;
  currentUserID:any;
  currentUsername:any;
  currentUsergroup:any;
  currentUserStatus:any;
  currentAllUsers:any;
  private sub: any;
  model: any = {};
  alldata: any = {};
  id:number;
  insertcategoryRestApiUrl: string = AppSettings.Addcategory; 
  FetchcategoryRestApiUrl: string = AppSettings.editcategory; 
  updatecategoryRestApiUrl: string = AppSettings.updatecategory; 
  constructor(private loginService: LoginService,private CommonService: CommonService,private route: ActivatedRoute,private router: Router,private http:Http) { 
      document.body.className="theme-red";

  }

  ngOnInit() {
     this.loginService.localStorageData();
      this.loginService.viewsActivate();
      this.sub = this.route.params.subscribe(params => {
        this.id = +params['id']; // (+) converts string 'id' to a number
        this.editcategory(this.id);        
        });
  }
  
  logout(){
    this.loginService.logout();
  }
  addcategorylist()
  {
    this.model.created_by=localStorage.getItem('currentUserID');
    this.CommonService.insertdata(this.insertcategoryRestApiUrl,this.model)
    .subscribe(package_det =>{       
         swal(
          package_det.status,
          package_det.message,
          package_det.status
        )
        this.router.navigate(['/managecategory']); 
    });
  }
  editcategory(id:any)
  {
    this.CommonService.editdata(this.FetchcategoryRestApiUrl,id)
        .subscribe(resultdata =>{   
          this.model = resultdata.result;         
        });
  }
  updatecategorylist()
  {
     //this.model.is_deleted=1
     this.CommonService.updatedata(this.updatecategoryRestApiUrl,this.model)
    .subscribe(package_det =>{       
         swal(
          package_det.status,
          package_det.message,
          package_det.status
        )
         this.router.navigate(['/managecategory']);
        
    });
  }
  back(){
    this.router.navigate(['/managecategory']);
  }

}
