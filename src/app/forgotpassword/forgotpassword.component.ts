import { Component, Injectable, OnInit} from '@angular/core';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { Router } from '@angular/router';
import { AppSettings } from '../appSettings';
import { LoginService } from '../services/login.service';
import { CommonService } from '../services/common.service';
declare let swal: any;
declare var jquery:any;
declare var $ :any;
@Component({
  selector: 'app-forgotpassword',
  templateUrl: './forgotpassword.component.html',
  styleUrls: ['./forgotpassword.component.css']
})
export class ForgotpasswordComponent implements OnInit {
	model:any={};
	//userRestApiUrl: string = AppSettings.Userlogin; //API common URL
	userRestApiUrl: string = AppSettings.passwordreset; //API common URL 
  constructor(private CommonService: CommonService) {
  document.body.className="login-page";
   }

  ngOnInit() {
  }

  forgotpassword(){
  	console.log(this.userRestApiUrl);
  	this.CommonService.checkexistdata(this.userRestApiUrl,this.model).subscribe(data=>{
     //console.log(data);
  	});
  }
}
