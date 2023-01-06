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
  selector: 'app-addshop',
  templateUrl: './addshop.component.html'
})
export class AddshopComponent implements OnInit {
  malllist:Array<Object>;
  floorlist:Array<Object>;
  model: any = {};
  select:any;
  malltypeid:any;
  floorid:any;
  IsshowOption:Boolean=false;
  packageTypeList:Array<Object>;
  statelist:Array<Object>;
  citylist:Array<Object>;
  countrylist:Array<Object>;
  Paythrough:Array<object>=[{'id':1,'name':'Enterpreneur'},{'id':2,'name':'Shopuser'}];
  insertshopRestApiUrl: string = AppSettings.Addshop; 
  getmalllistRestApiUrl:string = AppSettings.getmallDetail;  
  getfloorlistRestApiUrl:string = AppSettings.getfloorbymallid;  
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router,private http:Http) { 
      document.body.className="theme-red";

  }

  ngOnInit() {
    // this.loginService.malllocalStorageData();
    // this.model.created_by=localStorage.getItem('currentUserID'); 

    this.malltypeid = localStorage.getItem('malltypeid'); 
    this.floorid=localStorage.getItem('floorid');  
    this.model.usergroup=localStorage.getItem('currentUsergroup');
    if( this.model.usergroup==""|| this.model.usergroup==null){
      this.model.usergroup=localStorage.getItem('usergroup');
    }
    
    if(this.malltypeid==null){
      this.model.created_by=localStorage.getItem('currentUserID');
      this.model.owner_id=localStorage.getItem('currentUserID');
    } else{
      
      this.model.mall_id = localStorage.getItem('mallid'); 
      this.CommonService.insertdata(AppSettings.useridbymallid,this.model)
      .subscribe(package_det =>{       
        this.model.owner_id=package_det.created_by;
      });
     this.model.floor_id = localStorage.getItem('floorid'); 
     this.loginService.malllocalStorageData();        
     this.model.created_by = localStorage.getItem('mallcurrentUser'); 
    }
      this.loginService.viewsActivate();
      this.getmalllists();
      this.CommonService.editdata(AppSettings.getPackagetype,'8')
      .subscribe(resultdata =>{   
        this.packageTypeList=resultdata.result; 
      });

      this.CommonService.getallCountry().subscribe(response=>{
        this.countrylist =response.result;
      });
      // this.getfloorlists();
  }
  getmalllists(){
    // this.CommonService.getdata(this.getmalllistRestApiUrl)
    console.log("getmalllists-->",this.model);
    this.CommonService.insertdata(this.getmalllistRestApiUrl,this.model)
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
              if(this.floorid && this.malltypeid==2){
                this.floorlist=det.result;
                this.floorlist = det.result.filter(
                  res => res.id === this.floorid);
              }else{
                this.floorlist=det.result;
              }
              
            } 
             
        });
  }
  showOption(){
    this.IsshowOption = true;
  }
  logout(){
    this.loginService.logout();
  }
  addshoplist()
  {
    // this.model.created_by=localStorage.getItem('currentUserID');
    this.CommonService.insertdata(this.insertshopRestApiUrl,this.model)
    .subscribe(package_det =>{       
         swal(
          package_det.status,
          package_det.message,
          package_det.status
        )
        if( package_det.status=='Success'){
          this.router.navigate(['/mall/manageshop']); 
        }
      
    });
  }
  onSelectFile(event) {
    if (event.target.files && event.target.files[0]) {
        var filesAmount = event.target.files.length;
        for (let i = 0; i < filesAmount; i++) {

          const fileSelected: File = event.target.files[i];
          
              this.CommonService.chatuploadFile(AppSettings.imageupload,fileSelected)
              .subscribe( (response) => {
                this.model.logo=response.data;
                 
               })
        }
    }
  }
  getstate(countryId){    
    this.CommonService.editdata(AppSettings.getStatelist,countryId)
    .subscribe(resultdata =>{   
      this.statelist=resultdata.result; 
    });
  }
  getCity(stateId){    
    this.CommonService.editdata(AppSettings.getCitieslist,stateId)
    .subscribe(resultdata =>{   
      this.citylist=resultdata.result; 
    });
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

  back(){
    this.router.navigate(['/mall/manageshop']);
  }
  getvalue(det:any){
    let packdet = det.value.split("+");
    this.model.package = packdet[0];
    this.model.package_id = packdet[1];
  }
}
