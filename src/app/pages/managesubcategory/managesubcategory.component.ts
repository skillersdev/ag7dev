import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';
import { LoginService } from '../../services/login.service';
import { AppSettings } from '../../appSettings';
import { CommonService } from '../../services/common.service';

@Component({
  selector: 'app-managesubcategory',
  templateUrl: './managesubcategory.component.html',
  styleUrls: ['./managesubcategory.component.css']
})
export class ManagesubcategoryComponent implements OnInit {
  getsubcategorylistRestApiUrl:string = AppSettings.getsubcategoryDetail;
  DeletesubcategoryRestApiUrl :string = AppSettings.deletesubcategory;
  sub_categorylist:Array<Object>;
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router) { }

  ngOnInit() {
    this.loginService.localStorageData();
     this.loginService.viewsActivate();
     this.CommonService.getdata(this.getsubcategorylistRestApiUrl)
        .subscribe(det =>{
            if(det.result!="")
            { 
              this.sub_categorylist=det.result;
            } 
             
        });
  }
  navigateAddsubcategory()
  {
    this.router.navigate(['/addsubcategory']);
  }
  editsubcategory(id:any)
  {
     this.router.navigate(['/editsubcategory', id]);
  }
  deletesubcategory(id:any)
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
        self.removesubcategory(idx);
        swal(
          'Deleted!',
          'Package Data has been deleted.',
          'success'
        )
      },function(dismiss) {
    });
  }
 removesubcategory(idx:any)
 {
   this.CommonService.deletedata(this.DeletesubcategoryRestApiUrl,idx)
        .subscribe(resultdata =>{
         this.CommonService.getdata(this.getsubcategorylistRestApiUrl)
        .subscribe(det =>{
            if(det.result!="")
            { 
              this.sub_categorylist=det.result;
            } 
        });
      });
 }
}
