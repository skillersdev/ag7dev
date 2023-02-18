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
  statelist:Array<Object>;
  citylist:Array<Object>;
  countrylist:Array<Object>;
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

    this.CommonService.getallCountry().subscribe(response=>{
      this.countrylist =response.result;
    });
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
          this.model.beforeEditshopname = this.model.shop_name;
          this.getstate(this.model.country)
          this.getCity(this.model.state)     
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
     $('.preloader').show();
     this.CommonService.updatedata(this.updateshopRestApiUrl,this.model)
    .subscribe(package_det =>{   
      $('.preloader').hide();    
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
   banneronSelectFile(event,type) {
      if (event.target.files && event.target.files[0]) {
          var filesAmount = event.target.files.length;
          for (let i = 0; i < filesAmount; i++) {

            const fileSelected: File = event.target.files[i];
            
                this.CommonService.chatuploadFile(AppSettings.imageupload,fileSelected)
                .subscribe( (response) => {
                  if(type==1){
                    this.model.banner=response.data;
                  }
                  if(type==2){
                    this.model.shop_banner_detail=response.data;
                  }
                  
                })
          }
      }
    }
  back(){
    this.router.navigate(['/mall/manageshop']);
  }

}
