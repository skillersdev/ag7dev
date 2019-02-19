import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';

import { AppComponent } from '../../app.component';

import { TopnavComponent } from '../../topnav/topnav.component';
import { SidemenuComponent } from '../../sidemenu/sidemenu.component';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { AppSettings } from '../../appSettings';
import { LoginService } from '../../services/login.service';
declare var jquery:any;
declare var $ :any;
import { Injectable } from '@angular/core';
@Component({
  selector: 'app-managecontacts',
  templateUrl: './managecontacts.component.html',
  styleUrls: ['./managecontacts.component.css']
})
export class ManagecontactsComponent implements OnInit {

  constructor(private loginService: LoginService,private router: Router,private http:Http) { }

  ngOnInit() {
    this.loginService.localStorageData();
     this.loginService.viewsActivate();
  }
  navigateAddcontact()
  {
    this.router.navigate(['/addcontact']);
  }
}
