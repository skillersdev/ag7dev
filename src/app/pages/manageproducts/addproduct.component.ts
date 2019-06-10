import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';

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
  templateUrl: './addproduct.component.html'
})
export class AddproductComponent implements OnInit {

  currentUser:any;
  currentUserID:any;
  currentUsername:any;
  currentUsergroup:any;
  currentUserStatus:any;
  currentAllUsers:any;
  select: any;
  getcategorylistRestApiUrl:string = AppSettings.getcategoryDetail; 
  uploaduserProfileApi:string=AppSettings.uploadproductimage;
  getsubcategorylistRestApiUrl:string = AppSettings.getsubcategoryDetail; 
  getwebsiteRestApiUrl:string = AppSettings.getwebsitelist; 
  getsubcategoryRestApiUrl:string = AppSettings.getsubcategorybyid;
  insertproductRestApiUrl :string = AppSettings.addproduct;
  getcategorybyUserRestApiUrl:string = AppSettings.categorybyid; 
  categorylist:Array<Object>;
  subcategorylist:Array<Object>;
  websitelist:Array<Object>;
  product_det:Array<Object>;
  model: any = {};
  alldata: any = {};
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router,private http:Http) { 
      document.body.className="theme-red";

  }

  ngOnInit() {
     this.loginService.localStorageData();
      this.loginService.viewsActivate();
      /*category list*/

      let user_id = localStorage.getItem('currentUserID');
     this.model.imagePath = AppSettings.API_BASE;
    this.model.usergroup=localStorage.getItem('currentUsergroup');
    if(this.model.usergroup==2)
    {

      this.CommonService.editdata(this.getcategorybyUserRestApiUrl,user_id)
        .subscribe(resultdata =>{   
          this.categorylist=resultdata.result; 
        });
    
      }
      else{
        this.CommonService.getdata(this.getcategorylistRestApiUrl)
        .subscribe(det =>{
            if(det.result!="")
            { 
              this.categorylist=det.result;
            } 
             
        });
      } 
      // this.CommonService.getdata(this.getcategorylistRestApiUrl)
      //   .subscribe(det =>{
      //       if(det.result!=""){ this.categorylist=det.result;}
      //   });
        // this.CommonService.getdata(this.getsubcategorylistRestApiUrl)
        // .subscribe(det =>{
        //     if(det.result!=""){ this.subcategorylist=det.result;}
        // });
        this.alldata.usertype=localStorage.getItem('currentUsergroup');
        this.alldata.userid=localStorage.getItem('currentUserID');
      
         this.CommonService.insertdata(this.getwebsiteRestApiUrl,this.alldata)
        .subscribe(package_det =>{       
          if(package_det.result!=""){ this.websitelist=package_det.result;}
        }); 


  
  }

  addproduct()
  {
     this.CommonService.insertdata(this.insertproductRestApiUrl,this.model)
    .subscribe(package_det =>{       
         swal(
          package_det.status,
          package_det.message,
          package_det.status
        )
        this.router.navigate(['/manageproducts']); 
    }); 
  }
  fileEvent($event) {
    const fileSelected: File = $event.target.files[0];
    
    this.CommonService.uploadFile(this.uploaduserProfileApi,fileSelected)
    .subscribe( (response) => {
       if(response.status=='success')
       {
        this.model.product_image = response.data;
       }
        else{
          swal('',"Error while on upload photo",'Oops!');
          
          //this.toastr.errorToastr(response.data, 'Oops!');
        }
     })
   }
  logout(){
    this.loginService.logout();
  }

  back(){
    this.router.navigate(['/manageproducts']);
  }
 getsubcategory(cat_id:any)
 {
   this.CommonService.editdata(this.getsubcategoryRestApiUrl,cat_id)
        .subscribe(resultdata =>{   
          this.subcategorylist=resultdata.result; 
        });
 }
  

}
