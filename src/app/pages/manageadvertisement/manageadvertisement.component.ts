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
	getadlistRestApiUrl:string = AppSettings.getadDetail;
	DeleteadRestApiUrl:string = AppSettings.deletead;
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router) { }

  ngOnInit() {
  	this.CommonService.getdata(this.getadlistRestApiUrl)
        .subscribe(det =>{
            if(det.result!="")
            { 
              this.advertisementlist=det.result;
            } 
             
        });
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
        self.removead(idx);
        swal(
          'Deleted!',
          'Data has been deleted.',
          'success'
        )
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
