import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';

import { LoginService } from '../../services/login.service';

import { CommonService } from '../../services/common.service';
import { AppSettings } from '../../appSettings';

@Component({
  selector: 'app-marketmanagers',
  templateUrl: './managegallery.component.html'
})
export class ManagegalleryComponent implements OnInit {
 
 websiteurl:string=AppSettings.API_BASE;
 model:any={};
 albumlist:Array<Object>;
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router) { }

  ngOnInit() {
    this.loginService.localStorageData();
     this.loginService.viewsActivate();
     this.model.usergroup=localStorage.getItem('currentUsergroup');
    this.model.userId=localStorage.getItem('currentUserID');
    if(this.model.usergroup==2)
    {
       this.CommonService.insertdata(AppSettings.getalbumbyuser,this.model)
        .subscribe(det =>{
            if(det.result!=""){ this.albumlist=det.result[0];
              this.loginService.viewCommontdataTable('gallery','gallery');
            }
        });
    
    }
    else{
      this.CommonService.getdata(AppSettings.getalbumlistRestApiUrl)
      .subscribe(det =>{
          if(det.result!=""){ this.albumlist=det.result[0];
            this.loginService.viewCommontdataTable('gallery','gallery');
          }
      });
    }
  }
  navigateAddalbum()
  {
    this.router.navigate(['/addalbum']);
  }
   editalbum(id:any)
  {
    this.router.navigate(['/editalbum',id]);
  }
  deletealbum(id:any)
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
          self.removealbum(idx);
          swal(
            'Deleted!',
            'Service Data has been deleted.',
            'success'
          );
        }
      },function(dismiss) {
    });
  }
 removealbum(idx:any)
 {
   this.CommonService.deletedata(AppSettings.DeletealbumRestApiUrl,idx)
        .subscribe(resultdata =>{
         this.ngOnInit();
      });
 }
 addalbumphotos(id:any)
 {
   this.router.navigate(['/addalbumphotos',id]);
 }
 managereorderitem()
 {
   this.router.navigate(['/reorderalbumitem']);	
 }
}
