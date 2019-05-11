import { Component,OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { AppSettings } from '../appSettings';
import { LoginService } from '../services/login.service';
import { CommonService } from '../services/common.service';
import Swal from 'sweetalert2'

declare var jquery:any;
declare var $ :any;
import { Injectable } from '@angular/core';

@Component({
  selector: 'app-chat',
  templateUrl: './chat.component.html',
  styleUrls: []
})



export class ChatComponent implements OnInit {
  currentUser:any;
  currentUserID:any;
  model: any = {}; 
 
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router,private http:Http) { 
      // document.body.className="theme-red";

  }

  ngOnInit() {
    this.loginService.localStorageData();
    this.loginService.viewsActivate();
    let id=localStorage.getItem('currentUserID');
  }

 

 
}
