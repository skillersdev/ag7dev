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
  templateUrl: './editsubcategory.component.html'
})
export class EditsubcategoryComponent implements OnInit {

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
  categorylist:Array<Object>;
  websitelist:Array<Object>;
  getcategorylistRestApiUrl:string = AppSettings.getcategoryDetail; 
  //insertcategoryRestApiUrl: string = AppSettings.Addcategory; 
  FetchsubcategoryRestApiUrl: string = AppSettings.editsubcategory; 
  updatesubcategoryRestApiUrl: string = AppSettings.updatesubcategory; 

  getwebsiteRestApiUrl:string = AppSettings.getwebsitelist; 
  constructor(private loginService: LoginService,private CommonService: CommonService,private route: ActivatedRoute,private router: Router,private http:Http) { 
      document.body.className="theme-red";

  }

  ngOnInit() {
     this.loginService.localStorageData();
      this.loginService.viewsActivate();
      this.CommonService.getdata(this.getcategorylistRestApiUrl)
        .subscribe(det =>{
            if(det.result!="")
            { 
              this.categorylist=det.result;
            } 
             
        });
         this.alldata.usertype=localStorage.getItem('currentUsergroup');
        this.alldata.userid=localStorage.getItem('currentUserID');
      
       this.CommonService.insertdata(this.getwebsiteRestApiUrl,this.alldata)
        .subscribe(package_det =>{       
          if(package_det.result!=""){ this.websitelist=package_det.result;}
        });
      this.sub = this.route.params.subscribe(params => {
        this.id = +params['id']; // (+) converts string 'id' to a number
        this.editsubcategory(this.id);        
        });
  }
  
  logout(){
    this.loginService.logout();
  }
  
  editsubcategory(id:any)
  {
    this.CommonService.editdata(this.FetchsubcategoryRestApiUrl,id)
        .subscribe(resultdata =>{   
          this.model = resultdata.result;         
        });
  }
  updatesubcategorylist()
  {
     //this.model.is_deleted=1
     this.CommonService.updatedata(this.updatesubcategoryRestApiUrl,this.model)
    .subscribe(package_det =>{       
         swal(
          package_det.status,
          package_det.message,
          package_det.status
        ) 
         this.router.navigate(['/managesubcategory']);
        
    });
  }
  back(){
    this.router.navigate(['/managesubcategory']);
  }

}
