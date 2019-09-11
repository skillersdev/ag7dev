import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';

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
  selector: 'app-addmallproduct',
  templateUrl: './addmallproduct.component.html'
})
export class AddmallproductComponent implements OnInit {
  malllist:Array<Object>;
  floorlist:Array<Object>;
  shoplist:Array<Object>;
  model: any = {};
  select:any;
  malltypeid:any;
  insertproductRestApiUrl: string = AppSettings.Addmallproduct; 
  getmalllistRestApiUrl:string = AppSettings.getmallDetail;  
  getfloorlistRestApiUrl:string = AppSettings.getfloorbymallid;  
  getshoplistRestApiUrl:string = AppSettings.getshopbyfloorid;  
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router,private http:Http) { 
      document.body.className="theme-red";

  }

  ngOnInit() {
    
    
    this.malltypeid = localStorage.getItem('malltypeid');  
    if(this.malltypeid==null){
      this.model.created_by=localStorage.getItem('currentUserID');
    } else{
      
      this.model.mall_id = localStorage.getItem('mallid'); 
      this.model.floor_id = localStorage.getItem('floorid'); 
      this.model.shop_id = localStorage.getItem('shopid'); 
      this.model.created_by = localStorage.getItem('mallcurrentUser'); 
      this.loginService.malllocalStorageData();     
    }
      this.loginService.viewsActivate();
      this.getmalllists();
      // this.getfloorlists();
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
  getfloorlists(){
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
  logout(){
    this.loginService.logout();
  }
  addproductlist()
  {
    // this.model.created_by=localStorage.getItem('currentUserID');
    this.CommonService.insertdata(this.insertproductRestApiUrl,this.model)
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

  onSelectFile(event) {
    if (event.target.files && event.target.files[0]) {
        var filesAmount = event.target.files.length;
        for (let i = 0; i < filesAmount; i++) {

          const fileSelected: File = event.target.files[i];
          
              this.CommonService.chatuploadFile(AppSettings.imageupload,fileSelected)
              .subscribe( (response) => {
                // this.urls.push(response.data);
                this.model.image_name=response.data;
                 
               })
                // var reader = new FileReader();
                // this.msgfileEvent(event);
                // reader.onload = (event:any) => {
                //   console.log(event.target.result);
                //    this.urls.push(event.target.result); 
                // }
                
                // reader.readAsDataURL(event.target.files[i]);
        }
    }
  }

    banneronSelectFile(event) {
      if (event.target.files && event.target.files[0]) {
          var filesAmount = event.target.files.length;
          for (let i = 0; i < filesAmount; i++) {

            const fileSelected: File = event.target.files[i];
            
                this.CommonService.chatuploadFile(AppSettings.imageupload,fileSelected)
                .subscribe( (response) => {
                  this.model.banner=response.data;
                  
                })
          }
      }
    }

  

}
