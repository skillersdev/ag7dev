import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';
import { CommonService } from '../../../services/common.service';
import { AppSettings } from '../../../appSettings';

import { LoginService } from '../../../services/login.service';

@Component({
  selector: 'app-manageshop',
  templateUrl: './manageshop.component.html',
  styleUrls: []
})
export class ManageshopComponent implements OnInit {
  getshoplistRestApiUrl:string = AppSettings.getshopDetail; 
  DeleteshopRestApiUrl:string = AppSettings.deleteshop; 
  getshopbyUserRestApiUrl:string = AppSettings.shopbyid; 
  shoplist:Array<Object>;
  model:any={};
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router) { }

  ngOnInit() {
    this.loginService.localStorageData();
    this.loginService.viewsActivate();

    let user_id = localStorage.getItem('currentUserID');
     this.model.imagePath = AppSettings.API_BASE;
    this.model.usergroup=localStorage.getItem('currentUsergroup');
    this.getshoplists();
    
  }
  getshoplists(){
    this.shoplist=[];
    this.CommonService.getdata(this.getshoplistRestApiUrl)
        .subscribe(det =>{
            if(det.result!="")
            { 
              this.shoplist=det.result;
            } 
             
        });
  }
  navigateAddshop()
  {
    this.router.navigate(['/mall/addshop']);
  }
  editshop(id:any)
  {
     this.router.navigate(['/mall/editshop', id]);
  }
  deleteshop(id:any)
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
           self.removeshop(idx);
          swal(
            'Deleted!',
            'shop Data has been deleted.',
            'success'
          )
         
        }
      },function(dismiss) {
    });
  }
 removeshop(idx:any)
 {
   this.CommonService.deletedata(this.DeleteshopRestApiUrl,idx)
        .subscribe(resultdata =>{
          this.getshoplists();
      });
 }

}
