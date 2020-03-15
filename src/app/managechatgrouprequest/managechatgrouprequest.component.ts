import { Component, OnInit } from '@angular/core';

import { Routes,Router,RouterModule}  from '@angular/router';
import { CommonService } from '../services/common.service';
import { AppSettings } from '../appSettings';

import { LoginService } from '../services/login.service';

@Component({
  selector: 'app-managechatgrouprequest',
  templateUrl: './managechatgrouprequest.component.html',
  styleUrls: ['./managechatgrouprequest.component.css']
})
export class ManagechatgrouprequestComponent implements OnInit {
 model:any={};
 requestlist:Array<Object>;
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router) { }

  ngOnInit() {
  	this.model.usergroup=localStorage.getItem('currentUsergroup');
  	this.model.currentuserid= localStorage.getItem('currentUserID');
  	 this.CommonService.insertdata(AppSettings.getgrouprequestlist,this.model)
        .subscribe(resultdata =>{   
          this.requestlist=resultdata; 
         // this.loginService.viewCommontdataTable('dataTable','adsinfo_table');
        });
  }

  acceptrequest(requestData:any)
  {
  	let currentuserid = this.model.currentuserid;
  	var self = this;
  	swal({
        title: 'Are you sure ?',
         buttons: {
            cancel: true,
            confirm: true,
          },
        text: "Are you sure want to accept request",
      }).then(function (result) {
        if(result)
        {
          requestData.created_by = currentuserid;
	  	  requestData.request_status = 2;
	  	  self.CommonService.insertdata(AppSettings.updategrouprequest,requestData)
	        .subscribe(resultdata =>{
	        if(resultdata.status=='fail')
	        {
	        	 swal('','Already you are in selected group','error'); 
	        }else{
	        	self.requestlist=resultdata.result;
	          self.ngOnInit();
	        }  
	         // this.loginService.viewCommontdataTable('dataTable','adsinfo_table');
	        });
         	
        }        
      },function(dismiss) {
    });
  }

  rejectrequest(requestId:any)
  {
  	var self=this;
  	swal({
        title: 'Are you sure ?',
         buttons: {
            cancel: true,
            confirm: true,
          },
        text: "Are you sure want to reject request",
      }).then(function (result) {
        if(result)
        {
          
	  	  self.CommonService.deletedata(AppSettings.rejectgrouprequest,requestId)
        .subscribe(resultdata =>{
          if(resultdata!="")
          { 
            // this.advertisementlist=[];
            swal('Deleted!','Request has been rejected.','success');
            self.ngOnInit();
           
          } 

      });
         	
        }        
      },function(dismiss) {
    });
  }

}
