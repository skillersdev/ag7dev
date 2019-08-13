import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';
import { CommonService } from '../../../services/common.service';
import { AppSettings } from '../../../appSettings';

import { LoginService } from '../../../services/login.service';

@Component({
  selector: 'app-managemall',
  templateUrl: './managemall.component.html',
  styleUrls: []
})
export class ManagemallComponent implements OnInit {
  getmalllistRestApiUrl:string = AppSettings.getmallDetail; 
  DeletemallRestApiUrl:string = AppSettings.deletemall; 
  getmallbyUserRestApiUrl:string = AppSettings.mallbyid; 
  malllist:Array<Object>;
  model:any={};
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router) { }

  ngOnInit() {
    this.loginService.localStorageData();
    this.loginService.viewsActivate();

    let user_id = localStorage.getItem('currentUserID');
     this.model.imagePath = AppSettings.API_BASE;
    this.model.usergroup=localStorage.getItem('currentUsergroup');
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
  navigateAddmall()
  {
    this.router.navigate(['/mall/addmall']);
  }
  editmall(id:any)
  {
     this.router.navigate(['/mall/editmall', id]);
  }
  deletemall(id:any)
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
      }).then(function (result) 
      {
        if(result)
        {
           self.removemall(idx);
          swal(
            'Deleted!',
            'Mall Data has been deleted.',
            'success'
          )
        }
      },function(dismiss) {
    });
  }
 removemall(idx:any)
 {
   this.CommonService.deletedata(this.DeletemallRestApiUrl,idx)
        .subscribe(resultdata =>{
          this.getmalllists();
      });
 }

}
