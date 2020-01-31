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
  getcategorybyUserRestApiUrl:string = AppSettings.categorybyid; 
  categorylist:Array<Object>;
  model:any={};
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router) { }

  ngOnInit() {
    this.loginService.localStorageData();
    this.loginService.viewsActivate();

    let user_id = localStorage.getItem('currentUserID');
     this.model.imagePath = AppSettings.API_BASE;
    this.model.usergroup=localStorage.getItem('currentUsergroup');
    if(this.model.usergroup==2)
    {

      this.CommonService.editdata(this.getcategorybyUserRestApiUrl,user_id)
        .subscribe(resultdata =>{   
          this.categorylist=resultdata.result; 
        });
    
      }
      else{
        this.CommonService.getdata(this.getcategorylistRestApiUrl)
        .subscribe(det =>{
            if(det.result!="")
            { 
              this.categorylist=det.result;
            } 
             
        });
      }      
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
      }).then(function (result) 
      {
        if(result)
        {
           self.removecategory(idx);
          swal(
            'Deleted!',
            'Category Data has been deleted.',
            'success'
          )
        }
      },function(dismiss) {
    });
  }
 removecategory(idx:any)
 {
   
   this.CommonService.deletedata(this.DeletecategoryRestApiUrl,idx)
        .subscribe(resultdata =>{
          if(this.model.usergroup==2)
          {
            let user_id = localStorage.getItem('currentUserID');
            this.CommonService.editdata(this.getcategorybyUserRestApiUrl,user_id)
              .subscribe(resultdata =>{   
                this.categorylist=resultdata.result; 
              });
          
            }
            else{
              this.CommonService.getdata(this.getcategorylistRestApiUrl)
              .subscribe(det =>{
                  if(det.result!="")
                  { 
                    this.categorylist=det.result;
                  } 
                   
              });
            } 
      });
 }

}
