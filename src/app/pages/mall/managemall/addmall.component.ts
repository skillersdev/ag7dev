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
  selector: 'app-addmall',
  templateUrl: './addmall.component.html'
})
export class AddmallComponent implements OnInit {

  model: any = {};
  select:any;
  malltypeid:any;
  countrylist:Array<Object>;
  packageTypeList:Array<Object>;
  Paythrough:Array<object>=[{'id':1,'name':'Enterpreneur'},{'id':2,'name':'Malluser'}];
  statelist:Array<Object>;
  citylist:Array<Object>;
  IsshowOption:Boolean=false;
  insertmallRestApiUrl: string = AppSettings.Addmall; 
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router,private http:Http) { 
      document.body.className="theme-red";

  }

  ngOnInit() {
    
    this.malltypeid = localStorage.getItem('malltypeid');  
    this.model.usergroup=localStorage.getItem('usergroup');
    if(this.malltypeid==null){
      this.model.created_by=localStorage.getItem('currentUserID');
    } else{
      this.loginService.malllocalStorageData();  
     this.model.created_by = localStorage.getItem('mallcurrentUser'); 
     
    }
      this.loginService.viewsActivate();

      this.CommonService.getallCountry().subscribe(response=>{
        this.countrylist =response.result;
      });

      this.CommonService.editdata(AppSettings.getPackagetype,'6')
    .subscribe(resultdata =>{   
      this.packageTypeList=resultdata.result; 
    });
  }
  
  logout(){
    this.loginService.logout();
  }
  addmalllist()
  {
    // this.model.created_by=localStorage.getItem('currentUserID');
    this.CommonService.insertdata(this.insertmallRestApiUrl,this.model)
    .subscribe(package_det =>{       
         swal(
          package_det.status,
          package_det.message,
          package_det.status
        )
        if( package_det.status=='Success'){
          this.router.navigate(['/mall/managemall']); 
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
  showOption(){
    this.IsshowOption = true;
  }
  back(){
    this.router.navigate(['/mall/managemall']);
  }
  getvalue(det:any){
    let packdet = det.value.split("+");
    this.model.package = packdet[0];
    this.model.package_id = packdet[1];
  }

}
