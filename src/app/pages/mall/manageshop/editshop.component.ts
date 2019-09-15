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
  selector: 'app-editshop',
  templateUrl: './editshop.component.html'
})
export class EditshopComponent implements OnInit {

  
  private sub: any;
  model: any = {};
  id:number;
  malllist:Array<Object>;
  select:any;
  malltypeid:any;
  floorlist:Array<Object>;
  insertshopRestApiUrl: string = AppSettings.Addshop; 
  FetchshopRestApiUrl: string = AppSettings.editshop; 
  updateshopRestApiUrl: string = AppSettings.updateshop;  
  getmalllistRestApiUrl:string = AppSettings.getmallDetail;  
  getfloorlistRestApiUrl:string = AppSettings.getfloorbymallid;  
  constructor(private loginService: LoginService,private CommonService: CommonService,private route: ActivatedRoute,private router: Router,private http:Http) { 
      document.body.className="theme-red";

  }

  ngOnInit() {
    this.malltypeid = localStorage.getItem('malltypeid');  
    this.model.usergroup=localStorage.getItem('currentUsergroup');
    if(this.malltypeid==null){
      this.model.created_by=localStorage.getItem('currentUserID');
    } else{
      
      this.model.mall_id = localStorage.getItem('mallid'); 
     this.model.floor_id = localStorage.getItem('floorid'); 
     this.loginService.malllocalStorageData();        
     this.model.created_by = localStorage.getItem('mallcurrentUser'); 
    }
      this.loginService.viewsActivate();
      
      this.sub = this.route.params.subscribe(params => {
        this.id = +params['id']; // (+) converts string 'id' to a number
        this.editshop(this.id);        
        });
        this.getmalllists();
      }
      getmalllists(){
        // this.CommonService.getdata(this.getmalllistRestApiUrl)
        this.CommonService.insertdata(this.getmalllistRestApiUrl,this.model)
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
  
  editshop(id:any)
  {
    this.CommonService.editdata(this.FetchshopRestApiUrl,id)
        .subscribe(resultdata =>{   
          this.model = resultdata.result;      
          this.getfloorlists();   
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
  updateshoplist()
  {
     //this.model.is_deleted=1
     this.CommonService.updatedata(this.updateshopRestApiUrl,this.model)
    .subscribe(package_det =>{       
         swal(
          package_det.status,
          package_det.message,
          package_det.status
        )
         this.router.navigate(['/mall/manageshop']);
        
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

}
