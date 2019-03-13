import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { AppSettings } from '../appSettings';
import { CommonService } from '../services/common.service';
import { LoginService } from '../services/login.service';
declare var jquery:any;
declare var $ :any;

@Component({
  selector: 'app-sidemenu',
  templateUrl: './sidemenu.component.html',
  styleUrls: ['./sidemenu.component.css']
})
export class SidemenuComponent implements OnInit {
  model: any = {};
  FetchuserRestApiUrl: string = AppSettings.Edituser;  
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router,private http:Http) { }

  ngOnInit() {
    this.model.usergroup=localStorage.getItem('currentUsergroup');
    this.model.id = localStorage.getItem('currentUserID');
     this.CommonService.editdata(this.FetchuserRestApiUrl,this.model.id)
        .subscribe(resultdata =>{   
          this.model = resultdata.result;
        });
  }

    logout(){
    this.loginService.logout();
  }


}
