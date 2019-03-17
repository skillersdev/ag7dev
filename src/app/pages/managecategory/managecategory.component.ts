import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';
import { CommonService } from '../../services/common.service';
import { AppSettings } from '../../appSettings';

import { LoginService } from '../../services/login.service';

@Component({
  selector: 'app-managecategory',
  templateUrl: './managecategory.component.html',
  styleUrls: ['./managecategory.component.css']
})
export class ManagecategoryComponent implements OnInit {
  getcategorylistRestApiUrl:string = AppSettings.getcategoryDetail; 
  DeletecategoryRestApiUrl:string = AppSettings.deletecategory; 
  categorylist:Array<Object>;
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router) { }

  ngOnInit() {
    this.loginService.localStorageData();
     this.loginService.viewsActivate();
      this.CommonService.getdata(this.getcategorylistRestApiUrl)
        .subscribe(det =>{
            if(det.result!="")
            { 
              this.categorylist=det.result;
            } 
             
        });
  }
  navigateAddcategory()
  {
    this.router.navigate(['/addcategory']);
  }
  editcategory(id:any)
  {
     this.router.navigate(['/editcategory', id]);
  }
  deletecategory(id:any)
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
        self.removecategory(idx);
        swal(
          'Deleted!',
          'Package Data has been deleted.',
          'success'
        )
      },function(dismiss) {
    });
  }
 removecategory(idx:any)
 {
   this.CommonService.deletedata(this.DeletecategoryRestApiUrl,idx)
        .subscribe(resultdata =>{
           this.CommonService.getdata(this.getcategorylistRestApiUrl)
        .subscribe(det =>{
            if(det.result!="")
            { 
              this.categorylist=det.result;
            } 
             
        });
      });
 }

}
