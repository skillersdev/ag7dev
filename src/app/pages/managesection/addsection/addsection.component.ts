import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';

import { AppComponent } from '../../../app.component';

import { TopnavComponent } from '../../../topnav/topnav.component';
import { SidemenuComponent } from '../../../sidemenu/sidemenu.component';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { AppSettings } from '../../../appSettings';
import { LoginService } from '../../../services/login.service';
import { CommonService } from '../../../services/common.service';
declare var jquery:any;
declare var $ :any;
import { Injectable } from '@angular/core';

@Component({
  selector: 'app-addsection',
  templateUrl: './addsection.component.html',
  // styleUrls: ['./addsection.component.css']
})
export class AddsectionComponent implements OnInit {

  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router) { }
  model:any={};
  alldata:any={};
  select:any;
  getwebsiteRestApiUrl:string = AppSettings.getwebsitelist; 
  websitelist:Array<Object>;

  ngOnInit() {
  	this.alldata.usertype=localStorage.getItem('currentUsergroup');
    this.alldata.userid=localStorage.getItem('currentUserID');
  
     this.CommonService.insertdata(this.getwebsiteRestApiUrl,this.alldata)
    .subscribe(package_det =>{       
      if(package_det.result!=""){ this.websitelist=package_det.result;}
    }); 
  }

  add_section()
  	{
  		this.model.created_by = this.alldata.userid;
	  	this.CommonService.insertdata(AppSettings.addsection,this.model)
	      .subscribe( (response) => {
	         if(response.status=='success')
	         {
	         	swal(response.status,response.message,response.status)
            	this.router.navigate(['/managesection']); 
	         }

	         else{
	            swal('',response.data,'Oops!');
	         }
	     })
  	}
  back()
	{
	  	 this.router.navigate(['/managesection']);
	}

}
