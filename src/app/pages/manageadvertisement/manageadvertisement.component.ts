import { Component, OnInit } from '@angular/core';

import { Routes,Router,RouterModule}  from '@angular/router';
import { CommonService } from '../../services/common.service';
import { AppSettings } from '../../appSettings';

import { LoginService } from '../../services/login.service';

@Component({
  selector: 'app-manageadvertisement',
  templateUrl: './manageadvertisement.component.html',
  styleUrls: ['./manageadvertisement.component.css']
})
export class ManageadvertisementComponent implements OnInit {
	advertisementlist:Array<Object>;
  model:any={};
	getadlistRestApiUrl:string = AppSettings.getadDetail;
  getadlistbyUserRestApiUrl:string = AppSettings.getadDetailbyUser;
	DeleteadRestApiUrl:string = AppSettings.deletead;
  updateibaRestApiUrl:string = AppSettings.updateibadetails;
  websiteurl:string=AppSettings.USER_TEMPLATE;
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router) { }

  ngOnInit() 
  {
     let user_id = localStorage.getItem('currentUserID');
     this.model.imagePath = AppSettings.API_BASE;
    this.model.usergroup=localStorage.getItem('currentUsergroup');
    if(this.model.usergroup==2)
    {   

      this.CommonService.editdata(this.getadlistbyUserRestApiUrl,user_id)
        .subscribe(resultdata =>{   
          this.advertisementlist=resultdata.result; 
          this.loginService.viewCommontdataTable('dataTable','adsinfo_table');
        });
  	
      }
      else{
        this.CommonService.getdata(this.getadlistRestApiUrl)
        .subscribe(det =>{
            if(det.result!="")
            { 
              this.advertisementlist=det.result;
              this.loginService.viewCommontdataTable('dataTable','adsinfo_table');
            } 
             
        });
      }
  }
  navigateAddads()
  {
  	console.log("Sdf");
  	this.router.navigate(['/addads']);
  }
  editad(id:any)
  {
     this.router.navigate(['/editad', id]);
  }
  changeibastatus(id:any)
  {
    this.model.ad_id=id;
    this.CommonService.insertdata(this.updateibaRestApiUrl,this.model)
    .subscribe(package_det =>{       
         swal(
          package_det.status,
          package_det.message,
          package_det.status
        )
        this.router.navigate(['/manageads']); 
    });
  }
  deletead(id:any)
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
          self.removead(idx);
          swal('Deleted!','Data has been deleted.','success');
        }        
      },function(dismiss) {
    });
  }
 removead(idx:any)
 {
   this.CommonService.deletedata(this.DeleteadRestApiUrl,idx)
        .subscribe(resultdata =>{
          this.CommonService.getdata(this.getadlistRestApiUrl)
        .subscribe(det =>{
            if(det.result!="")
            { 
              this.advertisementlist=det.result;
            } 
             
        });
      });
 }
}
