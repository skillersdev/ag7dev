import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { AppSettings } from '../appSettings';
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
  constructor(private loginService: LoginService,private router: Router,private http:Http) { }

  ngOnInit() {
    this.model.usergroup=localStorage.getItem('currentUsergroup');
    console.log("manjatah da",this.model.usergroup);
  }

    logout(){
    this.loginService.logout();
  }


}
