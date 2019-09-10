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
  selector: 'app-editfloor',
  templateUrl: './editfloor.component.html'
})
export class EditfloorComponent implements OnInit {

  
  private sub: any;
  model: any = {};
  id:number;
  malllist:Array<Object>;
  select:any;
  malltypeid:any;
  insertfloorRestApiUrl: string = AppSettings.Addfloor; 
  FetchfloorRestApiUrl: string = AppSettings.editfloor; 
  updatefloorRestApiUrl: string = AppSettings.updatefloor;  
  getmalllistRestApiUrl:string = AppSettings.getmallDetail;  
  constructor(private loginService: LoginService,private CommonService: CommonService,private route: ActivatedRoute,private router: Router,private http:Http) { 
      document.body.className="theme-red";

  }

  ngOnInit() {
    // this.loginService.malllocalStorageData();
      this.loginService.viewsActivate();
      this.malltypeid = localStorage.getItem('malltypeid');  
    if(this.malltypeid==null){
      this.model.created_by=localStorage.getItem('currentUserID');     
    } else{      
      this.loginService.malllocalStorageData();  
     this.model.mall_id = localStorage.getItem('mallid'); 
     this.model.created_by = localStorage.getItem('mallcurrentUser');
    }
      this.sub = this.route.params.subscribe(params => {
        this.id = +params['id']; // (+) converts string 'id' to a number
        this.editfloor(this.id);        
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
  
  editfloor(id:any)
  {
    this.CommonService.editdata(this.FetchfloorRestApiUrl,id)
        .subscribe(resultdata =>{   
          this.model = resultdata.result;         
        });
  }
  updatefloorlist()
  {
     //this.model.is_deleted=1
     this.CommonService.updatedata(this.updatefloorRestApiUrl,this.model)
    .subscribe(package_det =>{       
         swal(
          package_det.status,
          package_det.message,
          package_det.status
        )
         this.router.navigate(['/mall/managefloor']);
        
    });
  }
  back(){
    this.router.navigate(['/mall/managefloor']);
  }

}
