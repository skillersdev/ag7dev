import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule,ActivatedRoute}  from '@angular/router';

import { AppComponent } from '../../../app.component';

import { TopnavComponent } from '../../../topnav/topnav.component';
import { SidemenuComponent } from '../../../sidemenu/sidemenu.component';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { AppSettings } from '../../../appSettings';
import { LoginService } from '../../../services/login.service';
import { CommonService } from '../../../services/common.service';
declare var jquery:any;
declare var $ :any;
import { Injectable } from '@angular/core';

@Component({
  selector: 'app-editproduct',
  templateUrl: './editproduct.component.html',
  styleUrls: ['./editproduct.component.css']
})
export class EditproductComponent implements OnInit {

  currentUser:any;
  currentUserID:any;
  currentUsername:any;
  currentUsergroup:any;
  currentUserStatus:any;
  currentAllUsers:any;
  select: any;
  getcategorylistRestApiUrl:string = AppSettings.getcategoryDetail; 
  getsubcategorylistRestApiUrl:string = AppSettings.getsubcategoryDetail; 
  getwebsiteRestApiUrl:string = AppSettings.getwebsitelist; 
  uploaduserProfileApi:string=AppSettings.uploadserviceimage;
  getsubcategoryRestApiUrl:string = AppSettings.getsubcategorybyid;
  insertproductRestApiUrl :string = AppSettings.addproduct;
  FetchproductRestApiUrl:string = AppSettings.editproduct;
  updateproductRestApiUrl:string = AppSettings.updateproduct;
  image_url = AppSettings.IMAGE_BASE;
  categorylist:Array<Object>;
  subcategorylist:Array<Object>;
  websitelist:Array<Object>;
  product_det:Array<Object>;
   private sub: any;
   id:number;
  model: any = {};
  alldata: any = {};
  constructor(private loginService: LoginService,private CommonService: CommonService,private route: ActivatedRoute,private router: Router,private http:Http) { 
      document.body.className="theme-red";

  }

  ngOnInit() {
  	 this.loginService.localStorageData();
      this.loginService.viewsActivate();
      /*category list*/
      this.CommonService.getdata(this.getcategorylistRestApiUrl)
        .subscribe(det =>{
            if(det.result!=""){ this.categorylist=det.result;}
        });

        this.CommonService.getdata(this.getsubcategorylistRestApiUrl)
        .subscribe(det =>{
            if(det.result!=""){ this.subcategorylist=det.result;}
        });
        this.alldata.usertype=localStorage.getItem('currentUsergroup');
        this.alldata.userid=localStorage.getItem('currentUserID');
      
         this.CommonService.insertdata(this.getwebsiteRestApiUrl,this.alldata)
        .subscribe(package_det =>{       
          if(package_det.result!=""){ this.websitelist=package_det.result;}
        }); 
         this.sub = this.route.params.subscribe(params => {
        this.id = +params['id']; // (+) converts string 'id' to a number
        this.editproduct(this.id);        
        });
  }

  editproduct(id:any)
  {
  	this.CommonService.editdata(this.FetchproductRestApiUrl,id)
        .subscribe(resultdata =>{   
          this.model = resultdata.result;         
        });
  }
  updateproduct()
  {
  	 this.CommonService.updatedata(this.updateproductRestApiUrl,this.model)
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
  back(){
    this.router.navigate(['/manageproducts']);
  }

}
