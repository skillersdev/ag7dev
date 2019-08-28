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
  selector: 'app-editmallproduct',
  templateUrl: './editmallproduct.component.html'
})
export class EditmallproductComponent implements OnInit {

  
  private sub: any;
  model: any = {};
  id:number;
  malllist:Array<Object>;
  floorlist:Array<Object>;
  shoplist:Array<Object>;
  select:any;
  insertproductRestApiUrl: string = AppSettings.Addmallproduct; 
  FetchproductRestApiUrl: string = AppSettings.editmallproduct; 
  updateproductRestApiUrl: string = AppSettings.updatemallproduct;  
  getmalllistRestApiUrl:string = AppSettings.getmallDetail;  
  getfloorlistRestApiUrl:string = AppSettings.getfloorbymallid;  
  getshoplistRestApiUrl:string = AppSettings.getshopbyfloorid;  
  constructor(private loginService: LoginService,private CommonService: CommonService,private route: ActivatedRoute,private router: Router,private http:Http) { 
      document.body.className="theme-red";

  }

  ngOnInit() {
    this.loginService.malllocalStorageData();
      this.loginService.viewsActivate();
      
      this.sub = this.route.params.subscribe(params => {
        this.id = +params['id']; // (+) converts string 'id' to a number
        this.editproduct(this.id);        
        });
        this.getmalllists();
      }
      getmalllists(){
        this.CommonService.getdata(this.getmalllistRestApiUrl)
            .subscribe(det =>{
                if(det.result!="")
                { 
                  this.malllist=det.result;
                } 
                 
            });
      }
  
  logout(){
    this.loginService.logout();
  }
  
  editproduct(id:any)
  {
    this.CommonService.editdata(this.FetchproductRestApiUrl,id)
        .subscribe(resultdata =>{   
          this.model = resultdata.result;      
          this.getfloorlists();   
          this.getshoplists();
        });
  }
  getfloorlists(){
    this.floorlist=[];
    this.CommonService.insertdata(this.getfloorlistRestApiUrl,this.model)
        .subscribe(det =>{
            if(det.result!="")
            { 
              this.floorlist=det.result;
            } 
             
        });
  }
  getshoplists(){
    this.CommonService.insertdata(this.getshoplistRestApiUrl,this.model)
        .subscribe(det =>{
            if(det.result!="")
            { 
              this.shoplist=det.result;
            } 
             
        });
  }
  updateproductlist()
  {
     //this.model.is_deleted=1
     this.CommonService.updatedata(this.updateproductRestApiUrl,this.model)
    .subscribe(package_det =>{       
         swal(
          package_det.status,
          package_det.message,
          package_det.status
        )
         this.router.navigate(['/mall/managemallproduct']);
        
    });
  }
  back(){
    this.router.navigate(['/mall/managemallproduct']);
  }

}
