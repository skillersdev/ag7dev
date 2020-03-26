import { Component, OnInit } from '@angular/core';

import { Routes,Router,RouterModule}  from '@angular/router';
import { LoginService } from '../../services/login.service';
import { AppSettings } from '../../appSettings';

import { CommonService } from '../../services/common.service';

declare var jquery:any;
declare var $ :any;

@Component({
  selector: 'app-manageservice',
  templateUrl: './manageservice.component.html',
  styleUrls: ['./manageservice.component.css']
})
export class ManageserviceComponent implements OnInit {

  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router) { }
  getservicelistRestApiUrl:string = AppSettings.getservicelist;
  DeleteserviceRestApiUrl:string = AppSettings.deleteservicedata;
  service_det:Array<Object>;
  model:any={};
  ngOnInit() {
    this.loginService.localStorageData();
    this.loginService.viewsActivate();
     this.model.imagePath = AppSettings.API_BASE;
    this.model.usergroup=localStorage.getItem('currentUsergroup');
    this.model.userId=localStorage.getItem('currentUserID');
    if(this.model.usergroup==2)
    {
       this.CommonService.insertdata(AppSettings.getservicebyuser,this.model)
        .subscribe(det =>{
            if(det.result!=""){ this.service_det=det.result;}
        });
    
    }
    else{
      this.CommonService.getdata(this.getservicelistRestApiUrl)
      .subscribe(det =>{
          if(det.result!=""){ this.service_det=det.result;}
      });
    }
     
  }

  navigateAddservice()
  {
    this.router.navigate(['/addservice']);
  }
  editservice(id:any)
  {
    this.router.navigate(['/editservice',id]);
  }
   deleteservice(id:any)
  {
    let idx = id;
      let self = this;
      swal({
        title: 'Are you sure?',
         buttons: {
            cancel: true,
            confirm: true,
          },
        text: "You won't be able to revert this!",
      }).then(function (result) {
        if(result)
        {
          self.removeservice(idx);
          swal(
            'Deleted!',
            'Service Data has been deleted.',
            'success'
          );
        }
      },function(dismiss) {
    });
  }
 removeservice(idx:any)
 {
   this.CommonService.deletedata(this.DeleteserviceRestApiUrl,idx)
        .subscribe(resultdata =>{
          if(this.model.usergroup==2)
          {
             this.CommonService.insertdata(AppSettings.getservicebyuser,this.model)
              .subscribe(det =>{
                  if(det.result!=""){ this.service_det=det.result;}
              });
          
          }
          else{
            this.CommonService.getdata(this.getservicelistRestApiUrl)
            .subscribe(det =>{
                if(det.result!=""){ this.service_det=det.result;}
            });
          }
      });
 }

}
