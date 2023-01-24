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
  selector: 'app-addfloor',
  templateUrl: './addfloor.component.html'
})
export class AddfloorComponent implements OnInit {
  malllist:Array<Object>;
  model: any = {};
  malltypeid:any;
  floorid:any;
  select:any;
  IsshowOption:Boolean=false;
  packageTypeList:Array<Object>;
  insertfloorRestApiUrl: string = AppSettings.Addfloor; 
  Paythrough:Array<object>=[{'id':1,'name':'Enterpreneur'},{'id':2,'name':'Flooruser'}];
  getmalllistRestApiUrl:string = AppSettings.getmallDetail;  
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router,private http:Http) { 
      document.body.className="theme-red";

  }

  ngOnInit() {
    // this.loginService.malllocalStorageData();
    
    this.malltypeid = localStorage.getItem('malltypeid');
    this.floorid=localStorage.getItem('floorid'); 
    
    this.model.usergroup=localStorage.getItem('currentUsergroup'); 
    
    if(this.model.usergroup==null){
      this.model.usergroup=localStorage.getItem('usergroup'); 
    }
    if(this.malltypeid==null){
      this.model.created_by=localStorage.getItem('currentUserID');
      this.model.owner_id=localStorage.getItem('currentUserID');     
    } else{      
      this.loginService.malllocalStorageData();  
     this.model.mall_id = localStorage.getItem('mallid'); 
      this.CommonService.insertdata(AppSettings.useridbymallid,this.model)
      .subscribe(package_det =>{       
        this.model.owner_id=package_det.created_by;
      });
     this.model.created_by = localStorage.getItem('mallcurrentUser');
     
    }
      this.loginService.viewsActivate();
      this.getmalllists();
      this.CommonService.editdata(AppSettings.getPackagetype,'7')
      .subscribe(resultdata =>{   
        this.packageTypeList=resultdata.result; 
      });
      
  }
  getmalllists(){
    // this.CommonService.getdata(this.getmalllistRestApiUrl)
    this.CommonService.insertdata(this.getmalllistRestApiUrl,this.model)
        .subscribe(det =>{
            if(det.result!="")
            { 
              this.malllist=det.result;

              this.getFloorname(this.malllist[0]['id']);
            } 
             
        });
  }
  logout(){
    this.loginService.logout();
  }
  getFloorname(mallId){
    this.CommonService.editdata(AppSettings.getFloorname,mallId)
    .subscribe(resultdata =>{   
      this.model.floor_name=resultdata.result.floorname; 
      this.model.floor_code=resultdata.result.floorcode; 
    });
  }
  addfloorlist()
  {
    
    this.CommonService.insertdata(this.insertfloorRestApiUrl,this.model)
    .subscribe(package_det =>{       
         swal(
          package_det.status,
          package_det.message,
          package_det.status
        )
        if( package_det.status=='success'){
          this.router.navigate(['/mall/managefloor']); 
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
                // this.urls.push(response.data);
                this.model.image_name=response.data;
                 
               })
        }
    }
  }
  showOption(){
    this.model.username = this.model.username;
    this.model.password = this.model.password;
    this.IsshowOption = true;
  }
  back(){
    this.router.navigate(['/mall/managefloor']);
  }
  getvalue(det:any){
    let packdet = det.value.split("+");
    this.model.package = packdet[0];
    this.model.package_id = packdet[1];
  }
}
