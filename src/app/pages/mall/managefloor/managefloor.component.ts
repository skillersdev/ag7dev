import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';
import { CommonService } from '../../../services/common.service';
import { AppSettings } from '../../../appSettings';

import { LoginService } from '../../../services/login.service';

@Component({
  selector: 'app-managefloor',
  templateUrl: './managefloor.component.html',
  styleUrls: []
})
export class ManagefloorComponent implements OnInit {
  getfloorlistRestApiUrl:string = AppSettings.getfloorDetail; 
  DeletefloorRestApiUrl:string = AppSettings.deletefloor; 
  getfloorbyUserRestApiUrl:string = AppSettings.floorbyid; 
  floorlist:Array<Object>;
  model:any={};
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router) { }

  ngOnInit() {
    this.loginService.localStorageData();
    this.loginService.viewsActivate();

    let user_id = localStorage.getItem('currentUserID');
     this.model.imagePath = AppSettings.API_BASE;
    this.model.usergroup=localStorage.getItem('currentUsergroup');
    this.getfloorlists();
    
  }
  getfloorlists(){
    this.CommonService.getdata(this.getfloorlistRestApiUrl)
        .subscribe(det =>{
            if(det.result!="")
            { 
              this.floorlist=det.result;
            } 
             
        });
  }
  navigateAddfloor()
  {
    this.router.navigate(['/mall/addfloor']);
  }
  editfloor(id:any)
  {
     this.router.navigate(['/mall/editfloor', id]);
  }
  deletefloor(id:any)
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
           self.removefloor(idx);
          swal(
            'Deleted!',
            'floor Data has been deleted.',
            'success'
          )
        }
      },function(dismiss) {
    });
  }
 removefloor(idx:any)
 {
   this.CommonService.deletedata(this.DeletefloorRestApiUrl,idx)
        .subscribe(resultdata =>{
          this.getfloorlists();
      });
 }

}