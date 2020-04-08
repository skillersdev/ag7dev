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
  getsubcategorybyUserRestApiUrl:string = AppSettings.getsubcategorybyid;
  getsubcatlistbyuser:string = AppSettings.getsubcatlist;
  DeletesubcategoryRestApiUrl :string = AppSettings.deletesubcategory;
  sub_categorylist:Array<Object>;
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

      this.CommonService.editdata(this.getsubcatlistbyuser,user_id)
        .subscribe(resultdata =>{   
          this.sub_categorylist=resultdata.result; 
          this.loginService.viewCommontdataTable('subcategory_table','subcategory_table');
        });
    
      }
      else
      {
         this.CommonService.getdata(this.getsubcategorylistRestApiUrl)
        .subscribe(det =>{
            if(det.result!="")
            { 
              this.sub_categorylist=det.result;
              this.loginService.viewCommontdataTable('subcategory_table','subcategory_table');
            } 
             
        });
      }
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
        if(result)
        {
          self.removesubcategory(idx);
          swal(
            'Deleted!',
            'Sub category Data has been deleted.',
            'success'
          );
        }
      },function(dismiss) {
    });
  }
 removesubcategory(idx:any)
 {
   this.CommonService.deletedata(this.DeletesubcategoryRestApiUrl,idx)
        .subscribe(resultdata =>{
          if(this.model.usergroup==2)
          {
            let user_id = localStorage.getItem('currentUserID');
            this.CommonService.editdata(this.getsubcatlistbyuser,user_id)
              .subscribe(resultdata =>{   
                this.sub_categorylist=resultdata.result; 
                this.loginService.viewCommontdataTable('subcategory_table','subcategory_table');
              });
          
            }
            else
            {
               this.CommonService.getdata(this.getsubcategorylistRestApiUrl)
              .subscribe(det =>{
                  if(det.result!="")
                  { 
                    this.sub_categorylist=det.result;
                    this.loginService.viewCommontdataTable('subcategory_table','subcategory_table');
                  } 
                   
              });
            }
      });
 }
}
